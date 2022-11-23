<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Http;


class PaypalHelper
{
    /**
     * @var string
     */
    protected static $cliendId = '';

    /**
     * @var string
     */
    protected static $secretId = '';

    /**
     * @var string
     */
    protected static $url = '';

    /**
     * @var string
     */
    protected static $token = '';

    /**
     * PayPal constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->cliendId = config("paypal.sandbox.client_id");
        $this->secretId = config("paypal.sandbox.client_secret");
        $this->url = config("paypal.sandbox.url");
        $this->token = $this->getAccessToken();
    }

    /**
     * Get the order detail payment
     * @var string $orderId order id
     *
     * @return object
     */
    public function getOrderDetails(String $orderId): object
    {
        $url = $this->url . 'checkout/orders/' . $orderId;
        $response = Http::withToken($this->token)->acceptJson()->get($url)->object();
        return $response;
    }
    /**
     * Refund the payment
     * @var string $captureId capture id
     * @var string $amount amount to be refund
     * @var string $currencyCode currency Code
     *
     * @return object
     */
    public function refund(String $captureId, String $amount, String $currencyCode = "EUR"): object
    {

        $url = $this->url . "payments/captures/$captureId/refund";

        $response = Http::withToken($this->token)->acceptJson()->post($url, [
            'amount' => [
                "value" => $amount,
                "currency_code" => $currencyCode
            ],
            "note_to_payer" => "Refund order payment",
        ])->json();

        return  $response;
    }
    /**
     * Get the access token
     *
     * @return String
     */
    public function getAccessToken(): String
    {
        $response = $this->accessToken();
        return  $response['access_token'];
    }

    /**
     *  Paypal access token
     *
     * @return array
     */
    public function accessToken(): array
    {

        $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        $response = Http::asForm()->withBasicAuth($this->cliendId, $this->secretId)->post(
            $url,
            ["grant_type" => "client_credentials"]
        )->json();

        return  $response;
    }
}
