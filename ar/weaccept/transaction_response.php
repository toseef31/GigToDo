<?php

include "../includes/post_request_only.php";
require_once "../includes/db.php";


$hmac = $input->get("hmac");

if(empty($hmac)){
    http_response_code(400);
    exit;
}

$hmacSecret = "4ECBBFEA73C8BA658298AB05AB1BCB3B";


$transactionData = json_decode(file_get_contents("php://input"),true);
$transaction = $transactionData["obj"];



if(!checkHmac($hmac,$transaction,$hmacSecret)){
    http_response_code(401);
    exit;
}


$status = "";

if(filter_var($transaction["success"],FILTER_VALIDATE_BOOLEAN)){
    $status = "success";
}elseif(filter_var($transaction["pending"],FILTER_VALIDATE_BOOLEAN)){
    $status = "pending";
}elseif(filter_var($transaction["is_void"],FILTER_VALIDATE_BOOLEAN)){
    $status = "void";
}

$db->update("weaccept_payments",[

    "status" => $status,
    "paid" => $status == "success",
    "paid_at" => $status == "success" ? new DateTime("now") : null,

],["weaccept_transaction_id" => $transaction["id"]]);
http_response_code(202);

function checkHmac($hmac,$data,$hmacSecret){

    $keys = ["amount_cents", "created_at", "currency", "error_occured", "has_parent_transaction", "id", "integration_id", "is_3d_secure", "is_auth", "is_capture", "is_refunded", "is_standalone_payment", "is_voided", "order.id", "owner", "pending", "source_data.pan", "source_data.sub_type", "source_data.type", "success"];
    natcasesort($keys);
    $string = "";
    foreach($keys as $key){
        $splited = explode(".",$key);
        if(count($splited) > 1){
            $value = $data[$splited[0]][$splited[1]];
            $string .= is_bool($value) ? json_encode($value) : $value;
        }else{
            $string .= is_bool($data[$key]) ? json_encode($data[$key]) : $data[$key];
        }
    }

    $localHmac = hash_hmac("SHA512",$string,$hmacSecret);

    return $localHmac === $hmac;
}

exit;





