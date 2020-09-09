<?php

if(basename($_SERVER["SCRIPT_FILENAME"]) == basename(__FILE__)){
    http_response_code(403);
    exit;
}

require_once "../includes/db.php";
include "../functions/processing_fee.php";
require_once "../vendor/autoload.php";


use GuzzleHttp\Client;

class Weaccept {
    public $api_key;
    public $seller;
    public $db;
    public $buyer;
    public $client;
    public $merchant_id;
    public $order;
    public $proposal;
    public $payment;
    public function __construct() {
        global $db;
        $this->db      = $db;
        $this->api_key = "ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam95TWpZd0xDSmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aWZRLk45M0lOUE9NOEtYNUNzQlFWSTFoOG92enA1aUtiYlZ3aXhjU1lrcXY4V21TVl9EQTM0aFFKaEpSQ00yYUNQVktEblNQNnhFUWszazhMdm0xMVVzMDd3";
        $this->seller  = $db->select("sellers", array("seller_user_name" => $_SESSION["seller_user_name"]))->fetch();
        $this->buyer   = $db->select("seller_payment_account", array("seller_id" => $this->seller->seller_id))->fetch();
        $this->client  = new Client([
            "base_uri" => "https://accept.paymobsolutions.com/api/",
            'headers'  => [
                'Accept' => 'application/json',
            ]
        ]);
        $this->merchant_id = "2260";
        $this->proposal = $db->select("proposals",["proposal_id"=> $_SESSION["c_proposal_id"]])->fetch();
    }

    public function getAuthToken() : string {

        $response = $this->client->post("auth/tokens",[
            "json" => [
                "api_key" => $this->api_key,
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(),true);

        $token = $body["token"];

        return (string) $token;
    }
    public function registerOrder(string $authToken,string $type){
        $amount_cents = $this->proposalTotalPrice();
        $payment = $this->createPayment($type);
        $response = $this->client->post("ecommerce/orders",[
            "json" => [
                "auth_token"=> $authToken, 
                "delivery_needed"=> "false",
                "merchant_id"=> $this->merchant_id,
                "amount_cents"=> $amount_cents,
                "currency"=> "EGP",
                "merchant_order_id"=> $payment->id, 
                "items"=> [],
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(),true);
        $this->order = $body;

        $this->db->update("weaccept_payments",["weaccept_order_id" => $this->order["id"]],["id" => $payment->id]);

        return $body;
    }
    public function proposalTotalPrice(){

        $processing_fee = processing_fee($_SESSION['c_sub_total']);
        $gst               = 3;
        $total    = $_SESSION['c_sub_total'] + $processing_fee + $gst;
        $total_amount      = $total * 100;

        return $total_amount;
    }
    public function getPaymentKey(string $authToken,string $integrationId,array $extraBillingData = null){
        $amount_cents = $this->proposalTotalPrice();

        $billingData = [
            "apartment"    => $this->buyer->apartment_number??"Not specified",
            "email"        => $this->seller->seller_email,
            "floor"        => $this->buyer->floor_number??"Not specified",
            "first_name"   => $this->seller->seller_name??"Not specified",
            "phone_number" => $this->buyer->mobile_number??"Not specified",
            "city"         => $this->buyer->city??"Not specified",
            "country"      => $this->buyer->country??"Not specified",
            "state"        => $this->buyer->state??"Not specified",
            "street"       => "abc",
            "building"     => "abc",
            "last_name"    => "abc",
        ];

        if($extraBillingData != null){
           $billingData =  array_merge($billingData,$extraBillingData);
        }

        $response = $this->client->post("acceptance/payment_keys",[
            "json" => [
                "auth_token"     => $authToken,
                "amount_cents"   => $amount_cents,
                "expiration"     => 3600,
                "order_id"       => $this->order['id'],
                "billing_data"   => $billingData,
                "currency"       => "EGP",
                "integration_id" => $integrationId,
            ]
        ]);
        $body = json_decode($response->getBody()->getContents(),true);
        
        return $body["token"];
        
    }
    public function createPayment($type){

        $this->db->insert("weaccept_payments",[
            "seller_id" => $this->seller->seller_id,
            "proposal_id" => $this->proposal->proposal_id,
            "status" => "pending",
            "type" => $type,
            "package_id" => $_SESSION["c_package_id"],
        ]);

        $payment_id = $this->db->lastInsertId();

        $this->payment = $this->db->select("weaccept_payments",["id" => $payment_id])->fetch();

        if($type == "wallet"){
            $_SESSION["payment_id"] = $payment_id;
        }

        return $this->payment;
    }

    public function updatePaymentTransactionId($transaction_id){

        $this->db->update("weaccept_payments",["weaccept_transaction_id" => $transaction_id],["id" => $this->payment->id]);

    }
}