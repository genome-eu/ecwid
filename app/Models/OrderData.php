<?php

namespace App\Models;

class OrderData
{
    public array $data;

    public ?string $currency;
    public ?string $genome_private_key;
    public ?string $genome_public_key;
    public ?string $order_number;
    public ?string $store_id;
    public ?string $token;
    public ?string $total_amount;
    public ?string $transaction_id;
    public ?string $user_city;
    public ?string $user_country_code_iso2;
    public ?string $user_email;
    public ?string $user_first_name;
    public ?string $user_last_name;
    public ?string $user_phone;
    public ?string $user_postal_code;
    public ?string $user_street;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->load($data);
    }

    private function load(array $data): void
    {
        $cartData = $data['cart'] ?? [];
        $orderData = $data['cart']['order'] ?? [];
        $personData = $data['cart']['order']['billingPerson'] ?? [];
        $settingsData = $data['merchantAppSettings'] ?? [];

        $this->currency = $cartData['currency'] ?? null;
        $this->genome_private_key = $settingsData['privateKey'] ?? null;
        $this->genome_public_key = $settingsData['publicKey'] ?? null;
        $this->order_number = $orderData['orderNumber'] ?? null;
        $this->store_id = $data['storeId'] ?? null;
        $this->token = $data['token'] ?? null;
        $this->total_amount = $orderData['total'] ?? null;
        $this->transaction_id = $orderData['referenceTransactionId'] ?? null;
        $this->user_city = $personData['city'] ?? null;
        $this->user_country_code_iso2 = $personData['countryCode'] ?? null;
        $this->user_email = $orderData['email'] ?? null;
        if (isset($personData['name'])) {
            if (strpos($personData['name'], ' ') === false) {
                $this->user_first_name = $personData['name'];
                $this->user_last_name = null;
            } else {
                list($this->user_first_name, $this->user_last_name) = explode(' ', $personData['name'], 2);
            }
        }
        $this->user_phone = $personData['phone'] ?? null;
        $this->user_postal_code = $personData['postalCode'] ?? null;
        $this->user_street = $personData['street'] ?? null;
    }
}
