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
class WeacceptKiosk extends Weaccept{
    public $integrationId;
    public function __construct()
    {
       parent::__construct();
       
       $this->integrationId = "25996";
    }

    public function payRequest(string $paymentKey){
        $response = $this->client->post("acceptance/payments/pay",[
            "json" => [
                "source" => [
                    "identifier" => "AGGREGATOR",
                    "subtype" => "AGGREGATOR"
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

        $order =  $this->registerOrder($authToken,"kiosk");

        $extraBillingData = [
            "phone_number" => $input->post("local_mobile_number"),
            "email" => $input->post("local_email"),
        ];

        $paymentKey = $this->getPaymentKey($authToken,$this->integrationId,$extraBillingData);


        $response = $this->payRequest($paymentKey);

        return [
            "reference_number" => $response["data"]["bill_reference"],
            "pending" => $response["pending"],
        ];
    }
}


$cash = new WeacceptKiosk();



$response = $cash->charge();


http_response_code(201);

echo json_encode($response);

exit;

?>