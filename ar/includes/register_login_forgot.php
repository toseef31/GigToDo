<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("$dir/functions/email.php");

$get_general_settings = $db->select("general_settings");   
$row_general_settings = $get_general_settings->fetch();
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;
$site_name = $row_general_settings->site_name;
$signup_email = $row_general_settings->signup_email;
$referral_money = $row_general_settings->referral_money;



if(isset($_POST['forgot'])){
	
	$forgot_email = $input->post('forgot_email');
	$select_seller_email = $db->select("sellers",array("seller_email" => $forgot_email));
	$count_seller_email = $select_seller_email->rowCount();
	if($count_seller_email == 0){
		
		echo "
		
		<script>
           swal({
	          type: 'warning',
	          text: 'Hmm! We don\'t seem to have this email in our system.',
          })
        </script>";
		
	}else{
		
		$row_seller_email = $select_seller_email->fetch();
		$seller_user_name = $row_seller_email->seller_user_name;
		$seller_pass = $row_seller_email->seller_pass;

		// Load Composer's autoloader
		require "$dir/vendor/autoload.php";

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
     
        if($enable_smtp == "yes"){
	        $mail->isSMTP();
	        $mail->Host = $s_host;
	        $mail->Port = $s_port;
	        $mail->SMTPAuth = true;
	        $mail->SMTPSecure = $s_secure;
	        $mail->Username = $s_username;
	        $mail->Password = $s_password;
        }
        
		$mail->setFrom($site_email_address,$site_name);

		$mail->addAddress($forgot_email);

		$mail->addReplyTo($site_email_address,$site_name);

		$mail->isHTML(true);
		 
		$mail->Subject = "$site_name: Password Reset";
		
		$mail->Body = "
		
		<html>
		
		<head>
		
		<style>
		
        .container {
        background: rgb(238, 238, 238);
        padding: 80px;
        
        }


		.box {
			background: #fff;
			margin: 0px 0px 30px;
			padding: 8px 20px 20px 20px;
            border:1px solid #e6e6e6;
            box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
		}


		h2{

		margin-top: 0px;
		margin-bottom: 0px;

		}
		
		.lead {
		    margin-top: 10px;
            margin-bottom: 0px;
			font-size:16px;
			
		}
		
		.btn{
			background:green;
			margin-top:20px;
			color:white !important;
			text-decoration:none;
			padding:10px 16px;
			font-size:18px;
			border-radius:3px;
			
		}
		
		hr{
			margin-top:20px;
			margin-bottom:20px;
			border:1px solid #eee;
			
		}
		
	    @media only screen and (max-device-width: 690px) {
        
        .container {
        background: rgb(238, 238, 238);
        width:100%;
        padding:1px;
        
        }
        
        .btn{
			background:green;
			margin-top:15px;
			color:white !important;
			text-decoration:none;
			padding:10px;
			font-size:14px;
			border-radius:3px;
			
		}
		
		.lead {
			font-size:14px;
		}
        

        }
		
		</style>
		
		</head>
		
		<body>
		
		<div class='container'>
		
		<div class='box'>
		
		<center>
		
		<img class='logo' src='$site_url/images/$site_logo' width='100' >
		
		<h2> Dear $seller_user_name </h2>
		
		<p class='lead'> Are You Ready To Change Your Password. </p>
		
		<br>
		
		<a href='$site_url/ar/change_password?code=$seller_pass".""."&username=$seller_user_name' class='btn'>
		 Click Here To Change Your Password
		</a>
		
		<hr>
		
		<p class='lead'>
		If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/ar/change_password?code=$seller_pass".""."&username=$seller_user_name
		</p>
		
		</center>
		
		</div>
		
		</div>
		
		</body>
		
		</html>
		
		";
		
       $mail->send();
		
		echo "
        
        <script>

          swal({
	          type: 'success',
	          text: 'An email has been sent to your email address with instructions on how to change your password.',
          });

        </script>";

       }catch(Exception $e){
       		
       }
	
		
	}
	
}