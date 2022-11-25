<?php

namespace App\Http\Helper;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class PaypalHelper
{
    /**
     * @var string
     */
    protected  $cliendId = '';

    /**
     * @var string
     */
    protected  $secretId = '';

    /**
     * @var string
     */
    protected  $url = '';

    /**
     * @var string
     */
    protected  $token = '';

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
    public function refund(String $captureId, String $amount, String $currencyCode = "EUR")
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
        if ($response->successful()) {
            Cache::put('access_token_time', $response['expires_in'], $seconds = 30);
            return  $response['access_token'];
        }
        if ($response->failed()) {
            Log::error('MOTORSPECS OAUTH2: Caught ServerException. ' . $response->body());
            return false;
        }
        if ($response->clientError()) {
            Log::error('MOTORSPECS OAUTH2: Caught ClientException. ' . $response->body());
            return false;
        }
        if ($response->serverError()) {
            Log::error('MOTORSPECS OAUTH2: Caught ServerException. ' . $response->body());
            return false;
        }
    }

    /**
     *  Paypal access token
     *
     * @return array
     */
    public function accessToken()
    {

        $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        $response = Http::asForm()->withBasicAuth($this->cliendId, $this->secretId)->post(
            $url,
            ["grant_type" => "client_credentials"]
        );

        Cache::put('access_token', $response['access_token'], $seconds = 30);

        return  $response;
    }
}
