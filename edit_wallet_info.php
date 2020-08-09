<?php

session_start();

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('/login','_self')</script>";
	
}

// $mobile_number = $input->post('mobile_number');
// print_r($mobile_number);
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$select_buyer_payment_account = $db->select("seller_payment_account", array("seller_id" => $login_seller_id));
$row_buyer_account = $select_buyer_payment_account->fetch();
$seller_account_id = $row_buyer_account->seller_id;

$var1 = $_GET['data'];
	$var2 =(explode(",",$var1));
	$mobile_number = $var2[0];
	// print_r($mobile_number);
// 	exit();
// die();
if (count($seller_account_id) == 0) {
	$update_cash_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"mobile_number" => $mobile_number));
}else{
	$update_cash_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"mobile_number" => $mobile_number),array("seller_id" => $login_seller_id));	
}

?>