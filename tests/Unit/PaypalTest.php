<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Helper\PaypalHelper;
use Illuminate\Support\Facades\Http;

class PaypalTest extends TestCase
{
    public function paypal_access_toke_array()
    {

        $paypal = new PaypalHelper();
        $accessToken = $paypal->accessToken();

        $this->assertContains('access_token', $accessToken);
    }


    public function it_can_get_access_token()
    {

        $paypal = new  PaypalHelper();
        $getAccessToken = $paypal->getAccessToken();
        $this->assertNotNull($getAccessToken);
    }

    public function can_create_paypal_order()
    {

        $paypal = new PaypalHelper();
        $accessToken = $paypal->getAccessToken();
        $response = Http::withToken($accessToken)->acceptJson()->post($url, [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => "d9f80740-38f0-11e8-b467-0ed5f89f718b",
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => "0.01"
                    ]
                ]
            ],
            "application_context" => [
                "shipping_preference" => "NO_SHIPPING",
            ],
        ])->json();
        $response->assertOk();
        return $response;
    }


    public function can_get_order_details_by_order_id()
    {
        $order = $this->can_create_paypal_order();

        $paypal = new  PaypalHelper();;
        $orderId = $paypal->getOrderDetails($order['id']);

        $this->assertEquals($orderId, $order['id'], true);
    }

    public function can_refund_order_by_capture_id()
    {
        $captureId = 'captureId';
        $currencyCode = "EUR";
        $amount = "0.01";

        $paypal = new  PaypalHelper();
        $response = $paypal->refund($captureId, $amount, $currencyCode);

        $response->assertOk();
        $response->assertSuccessful();
    }
}
