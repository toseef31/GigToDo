<?php

session_start();

require_once("includes/db.php");

require_once("functions/payment.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self');</script>";
	
}


if(isset($_GET['checkout_seller_id'])){
	
  $_SESSION['checkout_seller_id'] = $input->get('checkout_seller_id');
  $_SESSION['proposal_id'] = $input->get('proposal_id');
  $_SESSION['proposal_qty'] = $input->get('proposal_qty');
  $_SESSION['proposal_price'] = $input->get('proposal_price');
  $_SESSION['method'] = "weaccept";
  if(isset($_GET['proposal_extras'])){
  $_SESSION['proposal_extras'] = unserialize(base64_decode($_GET['proposal_extras']));
  }
  if(isset($_GET['proposal_minutes'])){
	$_SESSION['proposal_minutes'] = $input->get('proposal_minutes');
  }
  if($type == "featured_listing"){
  	echo "<script>window.open('$site_url/proposals/featured_proposal','_self')</script>";
	}elseif($type == "orderExtendTime"){
		return true;
  	}else{
	  	echo "<script>window.open('$site_url/ar/order','_self')</script>";
	}

}


if(isset($_GET['cart_seller_id'])){
	
$payment = new Payment();

$payment->paypal_execute("cart");
	
}


if(isset($_GET['featured_listing'])){
	
$payment = new Payment();

$payment->paypal_execute("featured_listing");
	
}


if(isset($_GET["view_offers"])){

	$_SESSION['offer_id'] = $input->get('offer_id');
	$_SESSION['offer_buyer_id'] = $login_seller_id;
	
  	if($type == "featured_listing"){
  	echo "<script>window.open('$site_url/proposals/featured_proposal','_self')</script>";
	}elseif($type == "orderExtendTime"){
		return true;
  	}else{
	  	echo "<script>window.open('$site_url/ar/order','_self')</script>";
	}
	
}


if(isset($_GET['message_offer_id'])){
	
	$_SESSION['message_offer_id'] = $input->get('message_offer_id');
	$_SESSION['message_offer_buyer_id'] = $login_seller_id;
  	
	if($type == "featured_listing"){
	echo "<script>window.open('$site_url/proposals/featured_proposal','_self')</script>";
	}elseif($type == "orderExtendTime"){
		return true;
  	}else{
	  	echo "<script>window.open('$site_url/ar/order','_self')</script>";
	}

}