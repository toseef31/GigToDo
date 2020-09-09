<?php

require_once "../includes/db.php";

if(!isset($_SESSION['seller_user_name'])){
    echo "<script>window.open('login','_self')</script>";
}

$response = $input->get();

$payment = $db->select("weaccept_payments",["weaccept_order_id" => $response["order"]])->fetch();

$paymentStatus = "";

if(!filter_var($response["success"],FILTER_VALIDATE_BOOLEAN)){
    $paymentStatus = "success";
}else if(filter_var($response["pending"],FILTER_VALIDATE_BOOLEAN)){
    $paymentStatus = "pending";
}else{
    $paymentStatus = "void";
}

date_default_timezone_set("UTC");
$db->update("weaccept_payments",[
    "status" => $paymentStatus,
    "paid" => !filter_var($response["success"],FILTER_VALIDATE_BOOLEAN),
    "paid_at" => date('Y-m-d H:i:s'),
],["id" => $payment->id]);


if(!filter_var($response["success"],FILTER_VALIDATE_BOOLEAN)){
    $extras = $_SESSION["c_proposal_extras"] != null ? "&proposal_extras=" . base64_encode(serialize($_SESSION['c_proposal_extras'])) : "";
    $minutes = $_SESSION["c_proposal_minutes"] != null ? "proposal_minutes={$_SESSION['c_proposal_minutes']}" : "";

    header("Location:"."/weaccept_order?checkout_seller_id=$payment->seller_id&proposal_id={$_SESSION['c_proposal_id']}&proposal_qty={$_SESSION['c_proposal_qty']}&proposal_price={$_SESSION['c_sub_total']}&$extras&$minutes");

}else{
    header("Location:/payments?payment_failed=true&payment_type=wallet");
}

exit;