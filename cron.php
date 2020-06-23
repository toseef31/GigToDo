<?php
	@session_start();
	require_once("../../includes/db.php");
	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('../../login','_self')</script>";
	}

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_seller = $db->select("sellers");
	$row_seller = $select_seller->fetch();
	$seller_id = $row_seller->seller_id;

	$update_offer = $db->update("sellers",array('seller_offers'=> "10"),array('seller_id'=>$seller_id));


