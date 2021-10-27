<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHandler;
use Genome\Lib\Exception\GeneralGenomeException;
use http\Client\Response;

class PayController extends Controller
{
    public function route()
    {
        if (isset($_GET['callbackPayload'])) {
            return $this->callback();
        } else {
            return $this->newOrder();
        }
    }

    public function newOrder()
    {
        $handler = new OrderHandler();

        try {
            $response = $handler->processNewOrder();
            return response($response);
        } catch (GeneralGenomeException $e) {
            return redirect($handler->getCallbackUrl(OrderHandler::CALLBACK_STATUS_CANCELLED));
        }
    }

    public function callback()
    {
        if (
            !isset($_GET['orderId']) ||
            !isset($_GET['callbackPayload']) ||
            !isset($_GET['status'])
        ) {
            return response('Access forbidden.', 403);
        }

        $handler = new OrderHandler();
        $return_url = $handler->processPaymentCallback();
        if (!$return_url) {
            return response('Access forbidden.', 403);
        }

        return response('<script>window.location="' . $return_url . '"</script>');
    }
}
