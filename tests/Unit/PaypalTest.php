<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Helper\PaypalHelper;

class PaypalTest extends TestCase
{
    public function paypal_access_toke_array()
    {
        $expectedResponse = [
            'scope'         => 'some_scope',
            'access_token'  => 'some_access_token',
            'token_type'    => 'Bearer',
            'app_id'        => 'APP-80W284485P519543T',
            'expires_in'    => 32400,
            'nonce'         => 'some_nonce',
        ];

        $paypal = new PaypalHelper();
        $accessToken = $paypal->accessToken();

        $this->assertEquals($expectedResponse, $accessToken, true);
    }


    public function it_can_get_access_token()
    {
        $accessToken = 'some_access_token';

        $paypal = new  PaypalHelper();
        $getAccessToken = $paypal->getAccessToken();
        $this->assertEquals($accessToken, $getAccessToken, true);
    }


    public function can_get_order_details_by_order_id()
    {
        $orderId = 'order_id';

        $paypal = new  PaypalHelper();;
        $order = $paypal->getOrderDetails($orderId);

        $this->assertEquals($orderId, $order->id, true);
        return $order;
    }

    public function can_refund_order_by_capture_id()
    {
        $captureId = 'captureId';
        $currencyCode = "EUR";
        $$amount = "EUR";

        $paypal = new  PaypalHelper();
        $refund = $paypal->refund($captureId, $amount, $currencyCode);

        $this->assertEquals($orderId, $order->id, true);
        return $refund;
    }
}
