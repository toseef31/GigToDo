<?php

include "../includes/post_request_only.php";

require_once "../includes/db.php";
require_once "../vendor/autoload.php";

use GuzzleHttp\Client;

class WeacceptTransactions{
    private $actions = [
        "check_status" => "CheckTransactionStatus",
    ];
    private $method;
    private $client;
    private $api_key = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam95TWpZd0xDSmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aWZRLk45M0lOUE9NOEtYNUNzQlFWSTFoOG92enA1aUtiYlZ3aXhjU1lrcXY4V21TVl9EQTM0aFFKaEpSQ00yYUNQVktEblNQNnhFUWszazhMdm0xMVVzMDd3";
    public function __construct($action)
    {
        global $input;

        $this->methodExists($action);

        $this->client = new Client([
            "base_uri" => "https://accept.paymobsolutions.com/api/acceptance/transactions/",
            'headers'  => [
                'Accept' => 'application/json',
            ]
        ]);

        $this->method = $this->actions[$action];

        echo call_user_func([$this,$this->method],$input->post());
    }

    public function methodExists($action){

        if(!array_key_exists($action,$this->actions)){
            http_response_code(404);
            echo json_encode([
                "message" => "Action Doesn't Exist",
            ]);
            exit;
        }

    }
    public function getAuthToken(){
        $response = $this->client->post("https://accept.paymobsolutions.com/api/auth/tokens",[
            "headers" => [
                "Accept" => "application/json",
            ],
            "json" => [
                "api_key" => $this->api_key,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(),true);

        return $body["token"];
    }
    public function CheckTransactionStatus($data){
        global $db;
        $transaction_id = $data["transaction_id"];

        $token = $this->getAuthToken();

        $response = $this->client->get("{$transaction_id}?token={$token}");

        $transaction = json_decode($response->getBody()->getContents(),true);

        $newStatus = "";

        if(filter_var($transaction["success"],FILTER_VALIDATE_BOOLEAN)){
            $newStatus = "success";
        }elseif(filter_var($transaction["pending"],FILTER_VALIDATE_BOOLEAN)){
            $newStatus = "pending";
        }elseif(filter_var($transaction["is_void"],FILTER_VALIDATE_BOOLEAN)){
            $newStatus = "void";
        }

        $payment = $db->select("weaccept_payments",["weaccept_transaction_id" => $transaction_id])->fetch();

        if($payment->status != $newStatus){
            $db->update("weaccept_payments",[
                "status" => $newStatus,
                "paid" => $newStatus == "success",
                "paid_at" => $newStatus == "success" ? new DateTime("now") : null,
            ],["id" => $payment->id]);
        }

        http_response_code(200);

        return json_encode([ 
            "status" => $newStatus,
            "orderCreated" => $payment->order_id != null,
        ]);
    }
}

new WeacceptTransactions($input->post("action"));

?>