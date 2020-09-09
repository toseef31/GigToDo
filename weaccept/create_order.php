<?php

require_once "../includes/db.php";

$data = $input->get();

if($data["payment_id"] == null){
    header("Location:/payments");
    exit;
}

$payment = $db->select("weaccept_payments",["id" => $data["payment_id"]])->fetch();

if($payment->status != "success" && !$payment->paid){
    header("Location:/payments");
}

$package = $db->select("proposal_packages",["package_id"=> $payment->package_id])->fetch();

$proposalPrice = $package->price;

$proposalExtras = $db->select("proposals_extras",["proposal_id" => $payment->proposal_id])->fetchAll();

$proposalExtrasIds = [];

if(count($proposalExtras) > 0){
    foreach($proposalExtras as $extra){
        $proposalPrice += $extra->price;
        $proposalExtrasIds[] = $extra->id;
    }
}

$proposalQty = 1;
$subTotal = $proposalPrice * $proposalQty;

$extras = base64_encode(serialize($extras));

$_SESSION["payment_id"] = $payment->id;

header("Location:"."/weaccept_order?checkout_seller_id=$payment->seller_id&proposal_id={$payment->proposal_id}&proposal_qty={$proposalQty}&proposal_price={$subTotal}&$extras");