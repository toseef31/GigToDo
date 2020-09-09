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
class WeacceptCash extends Weaccept{
    public $integrationId;
    public function __construct()
    {
       parent::__construct();
       
       $this->integrationId = "3325";
    }

    public function payRequest(string $paymentKey){
        $response = $this->client->post("acceptance/payments/pay",[
            "json" => [
                "source" => [
                    "identifier" => "cash",
                    "subtype" => "CASH"
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

        $order =  $this->registerOrder($authToken,"cash");

        $billingData = [
            "phone_number" => $input->post("mobile_number"),
            "street" => $input->post("address"),
            "apartment" => $input->post("apartment_number"),
            "floor" => $input->post("floor_number"),
            "country" => $input->post("country"),
            "state" => $input->post("state"),
            "city" => $input->post("city"),
            "email" => $this->seller->seller_email,
            "postal_code" => "Not specified",
            "building" => "Not specified",
            "first_name" => $this->seller->seller_name,
            "last_name" => "abc",
        ];

        $paymentKey = $this->getPaymentKey($authToken,$this->integrationId,$billingData);


        $response = $this->payRequest($paymentKey);

        return $response;
    }
}


$cash = new WeacceptCash();

$response = $cash->charge();

http_response_code(201);
echo json_encode($response);

?>