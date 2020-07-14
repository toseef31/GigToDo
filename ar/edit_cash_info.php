<?php

session_start();

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$select_buyer_payment_account = $db->select("seller_payment_account", array("seller_id" => $login_seller_id));
$row_buyer_account = $select_buyer_payment_account->fetch();
$seller_account_id = $row_buyer_account->seller_id;
// if(isset($_POST['submit_cash_info'])){
	$var1 = $_GET['data'];
	$var2 =(explode(",",$var1));
	// echo $var2[0];
	// echo $var2[1];
	// echo $var2[2];
	// echo $var2[3];
	// echo $var2[4];
	// echo $var2[5];exit();
	// print_r($_GET['data']);
	// $account_type = strip_tags($input->post('account_type'));
	$mobile_number = $var2[0];
	$address = $var2[1];
	$apartment_number = $var2[2];
	$floor_number = $var2[3];
	$country = $var2[4];
	$state = $var2[5];
	$city = $var2[6];
	// print_r($mobile_number);die();
	if (count($seller_account_id) == 0) {
		$update_cash_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"mobile_number" => $mobile_number,"address" => $address, "apartment_number" => $apartment_number, "floor_number" => $floor_number, "country" => $country, "state" => $state, "city" => $city));
	}else{
		$update_cash_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"mobile_number" => $mobile_number,"address" => $address, "apartment_number" => $apartment_number, "floor_number" => $floor_number, "country" => $country, "state" => $state, "city" => $city),array("seller_id" => $login_seller_id));	
	}
	
	// print_r($seller_account_id);die();
	
// }

?>