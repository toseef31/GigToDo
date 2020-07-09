<?php

session_start();
require_once("../includes/db.php");
require_once("../functions/email.php");
require_once("../includes/change_currency.php");
// require_once("weaccept.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('../login','_self');</script>";
}
if(isset($_SESSION['currency'])){
  $to = $_SESSION['currency'];
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;
$login_seller_account_type = $row_login_seller->account_type;
require("includes/inboxFunctions.php");



  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
       $url = "https://";   
  else  
       $url = "http://";   
  // Append the host(domain name, ip) to the URL.   
  $url.= $_SERVER['HTTP_HOST'];   

  // Append the requested resource location to the URL   
  $url.= $_SERVER['REQUEST_URI'];    
  $full_url = $_SERVER['REQUEST_URI'];

  $page_url = substr("$full_url", 15);

$cur_amount = currencyConverter($to,1);
$ch = curl_init();
			
			$postData1 = [
			    'username' => 'Mourad112007',
			    'password' => 'Fiverorder1'
			];
			curl_setopt($ch, CURLOPT_URL, "https://accept.paymobsolutions.com/api/auth/tokens");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Connection: Keep-Alive'
		    ));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData1));
			// Send the request & save response to $resp 
			$data = curl_exec($ch);

			if(!curl_errno($ch)){ 
		     $result = json_decode($data, true);

		      
		      // $user_data = array();
		      // $user_data['id'] =  $result['profile']['id'];
		      // $user_data['token'] = $result['token'];
		      // print_r($user_data);

		    $token=$result['token'];
		  }else{
		    echo 'Curl error: ' . curl_error($ch); 
		  }
		  curl_close($ch);
?>
<div class="container">
	<iframe src="https://accept.paymobsolutions.com/api/acceptance/iframe/5997?token=<?= $token; ?>" title="description" width="100%" style="height: 100vh;">
	<!-- <iframe src="https://accept.paymobsolutions.com/api/acceptance/iframes/5997?payment_token=<?= $token; ?>" title="description" width="100%" style="height: 100vh;"> -->
  <!-- <iframe src="https://accept.paymobsolutions.com/api/acceptance/iframe/5997?token=$token" title="description"> -->
</div>