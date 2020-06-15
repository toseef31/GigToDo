<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_SESSION['seller_user_name'])){
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
}

function userSignupEmail($email){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;
	global $u_name;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	require "$dir/vendor/autoload.php";
  $mail = new PHPMailer(true);
  try {
    //Server settings
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
		$mail->addAddress($email);
		$mail->addReplyTo($site_email_address,$site_name);
		$mail->isHTML(true);
		$mail->Subject = "$site_name: Activate Your New Account!";
		$mail->Body = "
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
		}
		@media only screen and (max-device-width: 690px) {
		.container {
			background: rgb(238, 238, 238);
			width:100%;
			padding:1px;
		}
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
		<h2> Hi $u_name, Welcome To $site_name! </h2>
		<p class='lead'> Are you ready to get started? </p>
		<br>
		<a href='$site_url/includes/verify_email.php?code=$verification_code' class='btn'>
		Click Here To Activate Your Account 
		</a>
		<hr>
		<p class='lead'>
		If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/includes/verify_email.php?code=$verification_code
		</p>
		</center>
		</div>
		</div>
		</body>
		</html>";
	  if($mail->send()){
	 		return true;
		}
	}catch(Exception $e){
    return true;
	}
}

function userConfirmEmail($email){
	global $db;
	global $dir;
	global $seller_name;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;
	
	require "$dir/vendor/autoload.php";
  $mail = new PHPMailer(true);
  try {
    //Server settings
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
		$mail->addAddress($email);
		$mail->addReplyTo($site_email_address,$site_name);
		$mail->isHTML(true);
		$mail->Subject = "$site_name: Confirm Your New Email!";
		$mail->Body = "
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
		}
		@media only screen and (max-device-width: 690px) {
		.container {
			background: rgb(238, 238, 238);
			width:100%;
			padding:1px;
		}
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
		<h2> Hi $seller_name, Welcome To $site_name! </h2>
		<p class='lead'> Are you ready to proceed with the request? </p>
		<br>
		<a href='$site_url/includes/verify_email.php?code=$verification_code' class='btn'>
		Click Here To Confirm Your New Email 
		</a>
		<hr>
		<p class='lead'>
		If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/includes/verify_email.php?code=$verification_code
		</p>
		</center>
		</div>
		</div>
		</body>
		</html>";
	  if($mail->send()){
	 		return true;
		}
	}catch(Exception $e){
    return true;
	}
}

function send_cancellation_request($order_id,$order_number,$sender_id,$proposal_id,$seller_id,$buyer_id,$date){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposal = $select_proposal->fetch();
	$proposal_title = $row_proposal->proposal_title;

	$select_buyer = $db->select("sellers",array("seller_id"=>$buyer_id));
	$row_buyer = $select_buyer->fetch();
	$buyer_user_name = $row_buyer->seller_user_name;

	$select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
	$row_seller = $select_seller->fetch();
	$seller_user_name = $row_seller->seller_user_name;

	$select_sender = $db->select("sellers",array("seller_id"=>$sender_id));
	$row_sender = $select_sender->fetch();
	$sender_user_name = $row_sender->seller_user_name;

	$get_admins = $db->select("admins");
	while($row_admins = $get_admins->fetch()){
	$admin_id = $row_admins->admin_id;
	$admin_name = $row_admins->admin_name;
	$admin_email = $row_admins->admin_email;

	$message = "
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
	.lead {
	font-size:16px;
	}
	.btn{
	background:green;
	margin-top:20px;
	color:white;
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
			<h2>Hello $admin_name</h2>
			<h2> $sender_user_name has requested to cancel this order. </h2>
			<h3>Order Details:</h3>
			<p class='lead'>
				<strong>Proposal:</strong> $proposal_title <br>
				<strong>Order Number:</strong> #$order_number <br>
				<strong>Proposal Seller:</strong> $seller_user_name <br>
				<strong>Proposal Buyer:</strong> $buyer_user_name <br>
				<strong>Date of Cancellation Request:</strong> $date
			</p>
		</center>
	</div>
	</div>
	</body>
	</html>
	";
	require "$dir/vendor/autoload.php";
	$mail = new PHPMailer(true);
	try{
		if($enable_smtp == "yes"){
			// $mail->SMTPDebug = 2;
			$mail->isSMTP();
			$mail->Host = $s_host;
			$mail->Port = $s_port;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = $s_secure;
			$mail->Username = $s_username;
			$mail->Password = $s_password;
		}
		$mail->setFrom($site_email_address,$site_name);
		$mail->addAddress($admin_email);
		$mail->addReplyTo($site_email_address,$site_name);
		$mail->isHTML(true);
		$mail->Subject =  "$site_name - Cancellation Requested";
		$mail->Body =  $message;
		if($mail->send()){
   		return true;
		}
	}catch(Exception $e){
    return false;
	}
}
}

function send_admin_forgot_password(){
	global $db;
	global $dir;
	global $forgot_email;
	global $select_admin;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	$rowAdmin = $select_admin->fetch();
	$admin_user_name = $rowAdmin->admin_user_name;
	$admin_pass = $rowAdmin->admin_pass;
	$message = "
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
	.lead {
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
	margin-top:20px;
	color:white !important;
	text-decoration:none;
	padding:10px 16px;
	font-size:18px;
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
	<h2> Dear admin $admin_user_name, you just requested to reset your password. </h2>
	<p class='lead'> Are you ready to proceed with the request? </p>
	<br>
	<a href='$site_url/admin/change_password.php?code=$admin_pass' class='btn'>
	Click Here To Reset Your Password 
	</a>
	<hr>
	<p class='lead'>
	If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/admin/change_password.php?code=$admin_pass
	</p>
	</center>
	</div>
	</div>
	</body>
	</html>
	";
	require "$dir/vendor/autoload.php";
	$mail = new PHPMailer(true);
	try{
		if($enable_smtp == "yes"){
			// $mail->SMTPDebug = 2;
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
		$mail->Subject =  "$site_name - Admin Password Reset";
		$mail->Body =  $message;
		if($mail->send()){
   			return true;
		}
	}catch(Exception $e){
    return false;
	}
}


function send_report_email($item_type,$author,$item_link,$date){
global $login_seller_user_name;
global $db;
global $dir;
global $site_name;
global $site_email_address;
global $site_logo;
global $site_url;
global $enable_smtp;
global $s_host;
global $s_port;
global $s_secure;
global $s_username;
global $s_password;

$get_general_settings = $db->select("general_settings");   
$row_general_settings = $get_general_settings->fetch();
$site_email_address = $row_general_settings->site_email_address;
$UserName = $login_seller_user_name;

if($item_type = "proposal"){
	$item_link = "$site_url/proposals/$author/$item_link";
}elseif($item_type == "message") {
	$item_link = "$site_url/conversations/inbox?single_message_id=$item_link";
}elseif($item_type == "order") {
	$item_link = "$site_url/order_details?order_id=$item_link";
}

require "$dir/vendor/autoload.php";

$get_admins = $db->select("admins");
while($row_admins = $get_admins->fetch()){
	$admin_id = $row_admins->admin_id;
	$admin_name = $row_admins->admin_name;
	$admin_email = $row_admins->admin_email;
	$mail = new PHPMailer(true);
	try{
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
		$mail->addAddress($admin_email);
		$mail->addReplyTo($site_email_address,$site_name);
		$mail->isHTML(true);
		$mail->Subject = "$site_name: Item Reported";
		$mail->Body = "
		<html>
		<head>
		<style>
		.container {
		  background: rgb(238, 238, 238);
		  padding: 80px;
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
		.table {
			width:100%;	
			background-color:#fff;
			margin-bottom:20px;
		}
		.table thead tr th {
			border:1px solid #ddd;
			font-weight:bolder;
			padding:10px;
		}
		.table tbody tr td {
			border:1px solid #ddd;
			padding:10px;
		}
		</style>
		</head>
		<body>
		<div class='container'>
		<div class='box'>
		<center>
		<img class='logo' src='$site_url/images/$site_logo' width='100'>
		<h2> Hi Admin $admin_name </h2>
		<p class='lead'> An item on $site_name has just been reported by user ($UserName). Details of reported item below : </p>
		<hr>
		<table class='table'>
		<thead>
		<tr>
		<th> Item Type </th>
		<th> Item Author </th>
		<th> Item Link </th>
		<th> Date Reported </th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td>$item_type</td>
		<td>$author</td>
		<td>$item_link</td>
		<td>$date</td>
		</tr>
		</tbody>
		</table>
		</div>
		</div>
		</body>
		</html>";
		$mail->send();
	}catch(Exception $e){
    return false;
	}
}

}
function inviteEmail($email,$link,$user_name){
	global $db;
	global $dir;
	global $site_name;
	global $site_email_address;
	global $site_logo;
	global $site_url;
	global $verification_code;
	global $u_name;

	global $enable_smtp;
	global $s_host;
	global $s_port;
	global $s_secure;
	global $s_username;
	global $s_password;

	require "$dir/vendor/autoload.php";
  $mail = new PHPMailer(true);
 
  try {
    //Server settings
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
		$addresses = explode(',',$email);
		// print_r($addresses);

		// print_r($email->AddAddress($val));
	    foreach ($addresses as $address) {
	    	// print_r($address);
    		// print_r($mail->addAddress($address));
        $mail->addAddress($address);
    }
    // die();
		// $mail->addAddress($email);
		$mail->addReplyTo($site_email_address,$site_name);
		$mail->isHTML(true);
		$mail->Subject = "$site_name: Create Your New Account!";
		$mail->Body = "
		<html>
		<head>
		<style>
		.container {
			background: rgb(238, 238, 238);
			padding: 80px;
		}
		@media only screen and (max-device-width: 690px) {
		.container {
			background: rgb(238, 238, 238);
			width:100%;
			padding:1px;
		}
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
			background:#ff0707;
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
		<h2> Hi, $user_name Invited You To $site_name! </h2>
		<p class='lead'> Are you ready to get started? </p>
		<br>
		<a href='$link' class='btn'>
		Click Here To Sign up  
		</a>
		<hr>
		<p class='lead'>
		If clicking the button above does not work, copy and paste the following url in a new browser window: $link
		</p>
		</center>
		</div>
		</div>
		</body>
		</html>";
	  if(!$mail->send()){
	 		// return true;
	 		header("Location: invite_friend");
    exit;
	 		header("Refresh:0");
	 		echo "<script>

	 		swal({
	 		type: 'success',
	 		text: 'Invitation Link Sent successfully!',
	 		timer: 3000,
	 		onOpen: function(){
	 		  swal.showLoading()
	 		}
	 		}).then(function(){
	 		    // Read more about handling dismissals
	 		    window.open('invite_friend','_self');
	 		});
	 		</script>";
		}
	}catch(Exception $e){
    return true;
	}
}