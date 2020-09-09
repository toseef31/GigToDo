<?php

include "../includes/post_request_only.php";

session_start();

include "./weaccept.php";

if(!isset($_SESSION["seller_user_name"])){
    http_response_code(401);
    echo json_encode([
        "status" => 401,
        "message" => "Authentication Required",
    ]);
    exit;
}

class WeacceptWallet extends Weaccept{
    public $integrationId;
    public function __construct()
    {
       parent::__construct();
       
       $this->integrationId = "3319";
    }

    public function payRequest(string $paymentKey,$identifier){
        $response = $this->client->post("acceptance/payments/pay",[
            "json" => [
                "source" => [
                    "identifier" => $identifier,
                    "subtype" => "WALLET"
                ],
                "payment_token" => $paymentKey,
            ],
        ]);
        $body = json_decode($response->getBody()->getContents(),true);

        $this->updatePaymentTransactionId($body["id"]);

        return $body;
    }
    public function charge(){

        global $input;

        $authToken = $this->getAuthToken();

        $order =  $this->registerOrder($authToken,"wallet");

        $paymentKey = $this->getPaymentKey($authToken,$this->integrationId);


        $response = $this->payRequest($paymentKey,$input->post("mobile_number"));

        return [
            "redirect_url" => $response["redirect_url"],
            "response" => $response,
        ];
    }
}


$wallet = new WeacceptWallet();


$response = $wallet->charge();



http_response_code(201);
echo json_encode($response);
exit;
