<?php

namespace App\Models;

use App\Helpers\CountriesCodesHelper;
use Genome\Lib\Exception\GeneralGenomeException;
use Genome\Lib\Model\FixedProduct;
use Genome\Lib\Model\RenderableInterface;
use Genome\Lib\Model\UserInfo;
use Genome\Scriney;

class OrderHandler
{
    const CIPHER = 'AES-128-CBC';
    const CALLBACK_STATUS_PAID = 'PAID';
    const CALLBACK_STATUS_CANCELLED = 'CANCELLED';

    public string $openssl_iv;
    public ?string $openssl_tag;

    private string $callback_url;
    private string $ecwid_client_id;
    private string $ecwid_client_secret;

    public function __construct()
    {
        $this->ecwid_client_id = env('ECWID_CLIENT_ID');
        $this->ecwid_client_secret = env('ECWID_CLIENT_SECRET');
    }

    /**
     * @return RenderableInterface
     * @throws GeneralGenomeException
     */
    public function processNewOrder(): RenderableInterface
    {
        $iv_length = openssl_cipher_iv_length(self::CIPHER);
        $this->openssl_iv = openssl_random_pseudo_bytes($iv_length);
        $this->openssl_tag = null;

        $payload = request()->post()['data'] ?? '';
        $payload = $this->decryptNewOrderPayload($payload);
        $order_data = new OrderData($payload);
        $order_id = $this->saveOrderToDb($order_data);
        $this->callback_url = $this->buildCallbackUrl($order_id, $order_data);

        return $this->buildScriney($order_data);
    }

    public function processPaymentCallback(): ?string
    {
        /** @var Order $order */
        $order = Order::find($_GET['orderId']);

        $callback_token = openssl_decrypt(
            base64_decode($_GET['callbackPayload']),self::CIPHER,
            $this->ecwid_client_secret,0, $order->openssl_iv, $order->openssl_tag
        );

        if ($callback_token !== $order->token) {
            return null;
        }

        $order_data = new OrderData($order->post_data);
        $this->updateOrderStatus($order_data, $_GET['status']);

        return
            'https://app.ecwid.com/custompaymentapps/' . $order->store_id .
            '?' . http_build_query([
                'orderId' => $order->order_number,
                'clientId' => $this->ecwid_client_id,
            ]);
    }

    /**
     * @param string $status
     * @return string
     */
    public function getCallbackUrl(string $status): string
    {
        return $this->callback_url . '&status=' . $status;
    }

    /**
     * @param string $payload
     * @return array
     */
    private function decryptNewOrderPayload(string $payload): array
    {
        // Ecwid sends data in url-safe base64. Convert the raw data to the original base64 first
        $payload = str_replace(['-', '_'], ['+', '/'], $payload);
        $payload = base64_decode($payload);
        // Initialization vector is the first 16 bytes of the received data
        $iv = substr($payload, 0, 16);
        $payload = substr($payload, 16);
        $payload = openssl_decrypt($payload, self::CIPHER, $this->ecwid_client_secret, OPENSSL_RAW_DATA, $iv);

        return json_decode($payload, true);
    }

    /**
     * @param OrderData $order_data
     * @return int
     */
    private function saveOrderToDb(OrderData $order_data): int
    {
        $order = new Order();

        $order->created_from = $_SERVER['REMOTE_ADDR'];
        $order->genome_private_key = $order_data->genome_private_key;
        $order->genome_public_key = $order_data->genome_public_key;
        $order->openssl_iv = $this->openssl_iv;
        $order->openssl_tag = $this->openssl_tag;
        $order->order_number = $order_data->order_number;
        $order->post_data = $order_data->data;
        $order->store_id = $order_data->store_id;
        $order->token = $order_data->token;

        $order->saveQuietly();

        return $order->id;
    }

    /**
     * @param OrderData $order_data
     * @return string
     */
    private function buildCallbackUrl(int $order_id, OrderData $order_data): string
    {
        $callbackPayload = $this->buildCallbackPayload($order_data);

        return
            'https://' . request()->server('HTTP_HOST') . request()->server('REQUEST_URI') .
            '?' . http_build_query([
                'orderId' => $order_id,
                'callbackPayload' => $callbackPayload,
            ]);
    }

    /**
     * @param OrderData $order_data
     * @return string
     */
    private function buildCallbackPayload(OrderData $order_data): string
    {
        $cipherTextRaw = openssl_encrypt(
            $order_data->token, self::CIPHER, $this->ecwid_client_secret, 0,
            $this->openssl_iv,$this->openssl_tag
        );

        return base64_encode($cipherTextRaw);
    }

    /**
     * @param OrderData $order_data
     * @return RenderableInterface
     * @throws GeneralGenomeException
     */
    public function buildScriney(OrderData $order_data): RenderableInterface
    {
        $scriney = new Scriney($order_data->genome_public_key, $order_data->genome_private_key);

        $user_info = $this->getUserInfo($order_data);
        $custom_products = [$this->getProduct($order_data)];

        return $scriney
            ->buildButton($order_data->user_email)
            ->setSuccessReturnUrl($this->getCallbackUrl(self::CALLBACK_STATUS_PAID))
            ->setDeclineReturnUrl($this->getCallbackUrl(self::CALLBACK_STATUS_CANCELLED))
            ->setUserInfo($user_info)
            ->setCustomProducts($custom_products)
            ->buildFrame();
    }

    /**
     * @param OrderData $order_data
     * @return UserInfo
     * @throws GeneralGenomeException
     */
    private function getUserInfo(OrderData $order_data): UserInfo
    {
        return new UserInfo(
            $order_data->user_email,
            $order_data->user_first_name,
            $order_data->user_last_name,
            CountriesCodesHelper::iso2ToIso3($order_data->user_country_code_iso2),
            $order_data->user_city,
            $order_data->user_postal_code,
            $order_data->user_street,
            $order_data->user_phone
        );
    }

    /**
     * @param OrderData $order_data
     * @return FixedProduct
     * @throws GeneralGenomeException
     */
    private function getProduct(OrderData $order_data): FixedProduct
    {
        $product_name = 'Order #' . $order_data->transaction_id;

        return new FixedProduct(
            $order_data->transaction_id,
            $product_name,
            $order_data->total_amount,
            $order_data->currency
        );
    }

    private function updateOrderStatus(OrderData $order_data, string $status)
    {
        $json = json_encode([
            'paymentStatus' => $status,
            'externalTransactionId' => 'transaction_' . $order_data->order_number
        ]);

        $url =
            "https://app.ecwid.com/api/v3/{$order_data->store_id}/orders/transaction_{$order_data->order_number}" .
            '?' . http_build_query([
                'token' => $order_data->token,
            ]);

        // Send request to update order
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json),
            ],
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_VERBOSE => 0,
        ]);

        curl_exec($ch);
        curl_close($ch);
    }
}
