<?php

session_start();


require_once("../includes/db.php");
include("../functions/processing_fee.php");

if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login.php','_self');</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_email = $row_login_seller->seller_email;
$login_seller_name = $row_login_seller->seller_name;

$select_buyer_payment_account = $db->select("seller_payment_account", array("seller_id" => $login_seller_id));
$row_buyer_account = $select_buyer_payment_account->fetch();
$mobile_number = $row_buyer_account->mobile_number;
$address = $row_buyer_account->address;
$apartment_number = $row_buyer_account->apartment_number;
$floor_number = $row_buyer_account->floor_number;
$country = $row_buyer_account->country;
$state = $row_buyer_account->state;
$city = $row_buyer_account->city;
$card_number = $row_buyer_account->card_number;
$card_name = $row_buyer_account->card_name;
$account_full_name = $row_buyer_account->account_full_name;
$iban = $row_buyer_account->iban;
$bank_name_address = $row_buyer_account->bank_name_address;
$swift_code = $row_buyer_account->swift_code;
$local_mobile_number = $row_buyer_account->local_mobile_number;
$local_email = $row_buyer_account->local_email;
// print_r($apartment_number);die();
// function weaccept(){
	
// 	global $input;
// 	global $site_url;
// 	global $db;
	
// 	$ch = curl_init();
	
// 	$postData = [
// 	    'username' => 'Mourad112007',
// 	    'password' => 'Fiverorder1'
// 	];
// 	curl_setopt($ch, CURLOPT_URL, "https://accept.paymobsolutions.com/api/auth/tokens");
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	curl_setopt($ch, CURLOPT_POST, 1);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Connection: Keep-Alive'
//     ));
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
// 	// Send the request & save response to $resp 
// 	$data = curl_exec($ch);

// 	if(!curl_errno($ch)){ 
//      $result = json_decode($data, true);

      
//       // $user_data = array();
//       // $user_data['id'] =  $result['profile']['id'];
//       // $user_data['token'] = $result['token'];
//       // print_r($user_data);
//       return $result['token'];
//   }else{
//     echo 'Curl error: ' . curl_error($ch); 
//   }
//   curl_close($ch);



// 	// return $data;

// }
// print_r($_SESSION['c_message_offer_id']);die();
try {

	global $input;
	global $site_url;
	global $db;

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

    // print_r($token);

	$select_offers = $db->select("messages_offers",array("offer_id" => $_SESSION['c_message_offer_id']));
	$row_offers = $select_offers->fetch();
	$proposal_id = $row_offers->proposal_id;
  $delivery_time = $row_offers->delivery_time;
  $sender_id = $row_offers->sender_id;
	$amount = $row_offers->amount;
	$processing_fee = processing_fee($amount);

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;

	//$payment = new Payment();
	$data = [];
	$data['name'] = $proposal_title;
	$data['qty'] = 1;
	$data['price'] = $amount;
	$data['sub_total'] = $amount;
	$data['total'] = $amount + $processing_fee;
  $total_amount = $data['total'] * 100;
  // print_r($total_amount);
  $order_time = date("F d, Y h:i:s ");
  $order_date = date("F d, Y");
  $merchant_order_id = rand();
	// print_r($data['price']);die();
	

	//$token = weaccept();
	//print_r($token.'sdfsdfsd');
	$postData2 = array(
		  'auth_token' => $token,
	    'delivery_needed' => 'false',
	    'merchant_id' => '2260',
	    'merchant_order_id' => $merchant_order_id,
	    'amount_cents' => $total_amount,
	    'currency' => 'EGP'
	);
	$chs = curl_init();
	curl_setopt($chs, CURLOPT_URL, "https://accept.paymobsolutions.com/api/ecommerce/orders");
	curl_setopt($chs, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($chs, CURLOPT_POST, 1);
	curl_setopt($chs, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Connection: Keep-Alive'
    ));
	curl_setopt($chs, CURLOPT_POSTFIELDS, json_encode($postData2));
	// Send the request & save response to $resp
		$order = curl_exec($chs);
	//print_r($order);
	
		if(!curl_errno($chs)){ 
	     $order_data = json_decode($order, true);

	      
	      // $user_data = array();
	      // $user_data['id'] =  $result['profile']['id'];
	      // $user_data['token'] = $result['token'];
	      // print_r($user_data);
	     // return $data;
	  }else{
	    echo 'Curl error: ' . curl_error($chs); 
	  }
	  curl_close($chs);    
	// return $result['id'];

// print_r($order_data['id']);
//die;

	$ch2 = curl_init();
	
	
	$postData3 = array(
		"auth_token" => $token,
    "amount_cents" => $total_amount,
    "expiration" => 3600,
    "order_id" => $order_data['id'],
    "billing_data" => [
        "apartment" => $apartment_number, 
        "email" => $login_seller_email, 
        "floor" => $floor_number, 
        "first_name" => $login_seller_name, 
        "phone_number" => $mobile_number, 
        "city" => $city, 
        "country" => $country,  
        "state" => $state,
        "street" => "abc",
        "building" => "abc",
        "last_name" => "abc",
        "order_id" => $order_data['id']
      ],
    "currency" => "EGP",
    "integration_id" => "3319"
	);
  // print_r($postData3);
	curl_setopt($ch2, CURLOPT_URL, "https://accept.paymobsolutions.com/api/acceptance/payment_keys");
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Connection: Keep-Alive'
    ));
	curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($postData3));
	
		$payment = curl_exec($ch2);
      // print_r($payment);
       $paymentdata = json_decode($payment, true);
       // print_r($paymentdata);
         //die;
		if(!curl_errno($ch2)){ 
	     
	     // return $data;
	  }else{
	    echo 'Curl error: ' . curl_error($ch2); 
	  }
	  curl_close($ch2);    
	// return $result['id'];

	$ch3 = curl_init();
	 $payToken=$paymentdata['token'];
	
	// print_r($payToken);
	// die;
 $postData4 = array(
  "source"=>[
    "identifier" => "01274155230", 
    "subtype" => "WALLET"
  ],
  "token" => $token,
  "payment_token" => $payToken
);
	/// print_r($postData4);die();
	//echo "<script>window.open('card_frame','_self')</script>";
	curl_setopt($ch3, CURLOPT_URL, "https://accept.paymobsolutions.com/api/acceptance/payments/pay");
	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch3, CURLOPT_POST, 1);
	curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Type: text/html',
    'Connection: Keep-Alive'
    ));
	curl_setopt($ch3, CURLOPT_HEADER, 0);
	curl_setopt($ch3, CURLOPT_POSTFIELDS, json_encode($postData4));
	
		$iframe = curl_exec($ch3);
        $iframedata = json_decode($iframe, true);
    $redirect_path = $iframedata['data']['redirect_url'];
  // die;
		if(!curl_errno($ch3)){
        $insert_order =$db->insert("orders", array("order_number" => $order_data['id'], "order_duration" => $delivery_time, "order_time" => $order_time, "order_date" => $order_date, "order_description" => '', "buyer_id" => $login_seller_id, "seller_id" => $sender_id, "proposal_id" => $proposal_id, "order_price" => $data['price'], "order_qty" => $data['qty'], "order_fee" => $processing_fee, "order_active" => "yes", "complete_time"=> '', "order_status" => "pending"));
        if($insert_order){
          $update_message_offer =$db->update("messages_offers", array("status" => "accepted"),array("offer_id"=>$_SESSION['c_message_offer_id']));
        }
        echo "<script>window.open('$redirect_path','_self')</script>";

	      return $iframe;
	  }else{
	    echo 'Curl error: ' . curl_error($ch3); 
	  }
	  curl_close($ch3);    
	//return $result['id'];

echo weaccept_iframe();

} catch (Error $e) { // this will catch only Errors 
    echo $e->getMessage();
}

?>
