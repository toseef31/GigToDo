<?php

session_start();

require_once("includes/db.php");

require_once("functions/functions.php");
// if(!isset($_SESSION['seller_user_name'])){
// 	echo "<script>window.open('../login','_self')</script>";
// }
$seller_user_name = $_SESSION['seller_user_name'];
	
	$toCurrency = $input->post('toCurrency');

  function currencyConverter($toCurrency,$amount_total) {

      $from_currency = 'USD'; 
      $toCurrency = $toCurrency;
      $amount_total = 10;
     $url = "http://free.currencyconverterapi.com/api/v5/convert?q=".$from_currency."_".$toCurrency."&compact=y&apiKey=0f497338a0bdf644d027";
	  
    
      $ch = curl_init();
      $timeout = 30;
      curl_setopt($ch,CURLOPT_URL,$url);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
      $data = curl_exec($ch);

      if(!curl_errno($ch)){ 
         $amount = json_decode($data, true);

          return $amount[$from_currency.'_'.$toCurrency]['val'];

      }else{
        echo 'Curl error: ' . curl_error($ch); 
      }
      curl_close($ch);

  }
  $_SESSION['currency'] = $toCurrency;
  // echo currencyConverter($toCurrency,$amount_total);
 
