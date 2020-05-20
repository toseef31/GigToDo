<?php
session_start();
require_once("includes/db.php");
require_once("functions/email.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_user_type = $row_login_seller->account_type;
$login_seller_name = $row_login_seller->seller_name;
$login_seller_email = $row_login_seller->seller_email;
$login_seller_paypal_email = $row_login_seller->seller_paypal_email;
$login_seller_payoneer_email = $row_login_seller->seller_payoneer_email;
$login_seller_image = $row_login_seller->seller_image;
$login_seller_cover_image = $row_login_seller->seller_cover_image;
$login_seller_headline = $row_login_seller->seller_headline;
$login_seller_country = $row_login_seller->seller_country;
$login_seller_state = $row_login_seller->seller_state;
$login_seller_city = $row_login_seller->seller_city;
$login_seller_timzeone = $row_login_seller->seller_timezone;
$login_seller_language = $row_login_seller->seller_language;
$login_seller_about = $row_login_seller->seller_about;
$login_seller_account_number = $row_login_seller->seller_m_account_number;
$login_seller_account_name = $row_login_seller->seller_m_account_name;
$login_seller_wallet = $row_login_seller->seller_wallet;
$login_seller_enable_sound = $row_login_seller->enable_sound;
$login_seller_verification = $row_login_seller->seller_verification;

$get_seller_lang = explode(',', $row_login_seller->seller_language);
// print_r($login_seller_language);
$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

if($lang_dir == "right"){
	$floatRight = "";
}else{
	$floatRight = "float-right";
}

$select_seller_payment = $db->select('seller_payment_account',array("seller_id" => $login_seller_id));
$row_seller_payment = $select_seller_payment->fetch();
$seller_account_id = $row_seller_payment->seller_id;
$mobile_number = $row_seller_payment->mobile_number;
$address = $row_seller_payment->address;
$apartment_number = $row_seller_payment->apartment_number;
$floor_number = $row_seller_payment->floor_number;
$country = $row_seller_payment->country;
$state = $row_seller_payment->state;
$city = $row_seller_payment->city;
$card_number = $row_seller_payment->card_number;
$card_name = $row_seller_payment->card_name;
$expiry_date = $row_seller_payment->expiry_date;
$security_code = $row_seller_payment->security_code;
$account_full_name = $row_seller_payment->account_full_name;
$iban = $row_seller_payment->iban;
$bank_name_address = $row_seller_payment->bank_name_address;
$swift_code = $row_seller_payment->swift_code;
$local_mobile_number = $row_seller_payment->local_mobile_number;
$local_email = $row_seller_payment->local_email;
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<title><?php echo $site_name; ?> - <?php echo $lang["settings"]; ?> </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
	
	<!--====== Bootstrap css ======-->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!--====== PreLoader css ======-->
	<link href="assets/css/preloader.css" rel="stylesheet">
	<!--====== Animate css ======-->
	<link href="assets/css/animate.min.css" rel="stylesheet">
	<!--====== Fontawesome css ======-->
	<link href="assets/css/fontawesome.min.css" rel="stylesheet">
	<!--====== Owl carousel css ======-->
	<link href="assets/css/owl.carousel.min.css" rel="stylesheet">
	<!--====== Nice select css ======-->
	<link href="assets/css/nice-select.css" rel="stylesheet">
	<!--====== Nice select css ======-->
  <link href="assets/css/tagsinput.css" rel="stylesheet">
	<!--====== Range Slider css ======-->
	<link href="assets/css/ion.rangeSlider.min.css" rel="stylesheet">
	<!--====== Default css ======-->
	<link href="assets/css/default.css" rel="stylesheet">
	<!--====== Style css ======-->
	<link href="assets/css/style.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">
	<!-- <link href="styles/user_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
	<link href="styles/croppie.css" rel="stylesheet">
	<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/croppie.js"></script>
	<?php if($paymentGateway == 1){ ?>
	<script src="plugins/paymentGateway/javascript/script.js"></script>
	<?php } ?>
	<?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
	<script src="<?php echo $site_url; ?>/js/jquery.easy-autocomplete.min.js"></script>
	<link href="<?php echo $site_url; ?>/styles/easy-autocomplete.min.css" rel="stylesheet">
	<link href="assets/css/select2.min.css" rel="stylesheet" />
	<style>
		.profile-edit-step-item{
			cursor: pointer;
		}
		.icontext{
			left: -webkit-calc(50% - (33px / 2));
	    left: -moz-calc(50% - (33px / 2));
	    left: calc(50% - (33px / 2));
	    position: absolute;
	    top: -webkit-calc(50% - (33px / 2));
	    top: -moz-calc(50% - (33px / 2));
	    top: calc(50% - (33px / 2));
		}
		.remove{
			position: absolute;
    	top: 10px;
    	right: 30px;
		}
		.edit-profile .profile-edit-card .edit-profile-image .cover-image-label{
			padding: 20px 0;
		}
		.edit-profile .profile-edit-card  .custom_nice .nice-select .list {
	    width: 100%;
	    height: 300px;
	    overflow: auto;
		}
		.crop_image , .crop_image_cover{
		  background-color: #ff0707;
		  border-color: #ff0707;
		  color: white; 
		}
		#insertimageModal .modal-header .close {
		  padding: 1rem;
		  margin: -1rem -1rem auto;
		}
		#state-list , #city-list, #country, .language{
      height: 54px;
      display: block !important;
    }
    .state_box .nice-select{
      display: none !important;
    }
    /* The message box is shown when the user clicks on the password field */
    #message {
      display:none;
      /*background: #f1f1f1;*/
      color: #000;
      position: relative;
      padding: 20px;
      margin-top: 0px;
    }
    #message p {
      padding: 0px 35px;
      font-size: 14px;
    }
    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
      color: green;
    }
    .valid:before {
      position: relative;
      left: -35px;
      content: "✔";
    }
    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
      color: red;
    }
    .invalid:before {
      position: relative;
      left: -35px;
      content: "✖";
    }
    .select2.select2-container:last-Child{
    	display: none;
    }
    .select2-container{
    	width: 100% !important;
    }
    .select2-container .select2-selection--multiple{
    	min-height: 54px;

    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
    	margin-top: 10px;
	    padding: 5px 10px;
    }
    @media(max-width: 768px){
    	.edit-profile .profile-edit-card .edit-profile-image .cover-image-label{
    		height: auto;
    		padding: 0;
    	}
    	.edit-profile .profile-edit-card .edit-profile-image .cover-image-label .icontext span{
    		font-size: 14px;
    	}
    }
	</style>
</head>
<body class="all-content">
	<!-- Preloader Start -->
	<div class="proloader">
		<div class="loader">
			<img src="assets/img/emongez_cube.png" />
		</div>
	</div>
	<!-- Preloader End -->
	<?php 
		if($login_user_type == 'seller'){ 
		  require_once('includes/user_header.php');
		}else{
		  require_once("includes/buyer-header.php");
		}
	?>
	<?php if(!isset($_GET['account_settings'])){  ?>
	<main>
		<section class="container-fluid edit-profile">
			<div class="row">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1 class="heading-title">Edit Profile</h1>
						</div>
					</div>
					<!-- Row -->
					<div class="row">
						<div class="col-12 col-lg-8">
							<div class="profile-edit-card">
								<div class="row">
									<div class="col-12">
										<div class="profile-edit-steps d-flex flex-row justify-content-between">
											<div class="profile-edit-step-item active" id="profile_tab">
												<span class="step">1</span>
												<span class="text">Basic Information</span>
											</div>
											<div class="profile-edit-step-item" id="verification_tab">
												<span class="step">2</span>
												<span class="text">Trust & Verification</span>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-content">
									<div id="profile_settings" class="tab-pane fade <?php if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){ echo "show active"; } if(isset($_GET['profile_settings'])){ echo "show active"; } ?>">
										<!-- Row -->
										<div class="row">
											<div class="col-12">
												<?php require_once("profile_settings.php") ?>
											</div>
										</div>
										<!-- Row -->
									</div>
									<div id="account_verification" class="tab-pane fade ">
										<!-- Row -->
										<div class="row">
											<div class="col-12">
												<div class="profile-verifications">
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-facebook-f"></i></span>
														<span>Facebook</span>
														<span class="ml-auto d-flex flex-row align-items-center facebook">
															<span><i class="fab fa-facebook-f"></i></span>
															<span>Connect</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-linkedin-in"></i></span>
														<span>LinkedIn</span>
														<span class="ml-auto d-flex flex-row align-items-center linkedin">
															<span><i class="fab fa-linkedin-in"></i></span>
															<span>Connect</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-google"></i></span>
														<span>Google</span>
														<span class="ml-auto d-flex flex-row align-items-center google">
															<span><i class="fab fa-google"></i></span>
															<span>Connect</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fas fa-envelope"></i></span>
														<span>Email</span>
														<span class="ml-auto d-flex flex-row align-items-center email">
															<span>Verify</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
														<span>Payment</span>
														<span class="ml-auto d-flex flex-row align-items-center payment">
															<span><i class="fal fa-check"></i></span>
															<span>Verified</span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<!-- Row -->
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="howitwork-card">
								<div class="howitwork-card-title d-flex align-items-center">Improve Your Profile</div>
								<div class="howitwork-list d-flex flex-column">
									<div class="howitwork-list-item d-flex flex-row align-items-start">
										<div class="howitwork-list-icon">
											<img alt="Post a gig" class="img-fluid d-block" src="assets/img/edit-profile/profile-photo-icon.png" />
										</div>
										<div class="howitwork-list-content">
											<h3>1. Upload a profile and cover photo</h3>
											<p>The freelancing community is a tight knit family that follows the tenets of compassion, integrity, and loyalty. Uploading a profile picture and cover photo to your profile helps show our community of freelancers that you are a genuine person committed to building quality professional relationships.</p>
										</div>
									</div>
									<!-- How it work each item -->
									<div class="howitwork-list-item d-flex flex-row align-items-start">
										<div class="howitwork-list-icon">
											<img alt="Get Hired" class="img-fluid d-block" src="assets/img/edit-profile/text-edit-icon.png" />
										</div>
										<div class="howitwork-list-content">
											<h3>2. Tell us about yourself</h3>
											<p>We want to know who you are! Tell us about your business, goals, dreams, and anything else you want to share. Writing a short bio on yourself can help freelancers get a better picture of what you are looking for in a project</p>
										</div>
									</div>
									<!-- How it work each item -->
									<div class="howitwork-list-item d-flex flex-row align-items-start">
										<div class="howitwork-list-icon">
											<img alt="Work" class="img-fluid d-block" src="assets/img/edit-profile/verifiy-icon.png" />
										</div>
										<div class="howitwork-list-content">
											<h3>3. Verify your account</h3>
                      <p>Build credibility for your profile through linking your other social media accounts. This will boost your chances of receiving more offers and better quality proposals from the best talent on eMongez.</p>
										</div>
									</div>
									<!-- How it work each item -->
								</div>
							</div>
							<!-- How it work -->
						</div>
					</div>
				</div>
			</div>
			<!-- Row -->
		</section>
	</main>
	<?php } elseif(isset($_GET['account_settings'])){?>
	<main>
		<section class="container-fluid profile-setting">
			<div class="row">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1 class="heading-title">Security</h1>
						</div>
					</div>
					<!-- Row -->
					<div class="row">
						<div class="col-12 col-lg-4">
							<div class="profile-setting-breadcrumb nav nav-tabs d-flex flex-column" id="setting-tab" role="tablist">
								<a href="#security" id="security-tab" data-toggle="tab" aria-controls="security" aria-selected="true" class="nav-item nav-link profile-setting-breadcrumb-item active d-flex flex-row align-items-center">
									<span>
										<img class="img-fluid before-icon" src="assets/img/setting/security-icon-before.png" />
										<img class="img-fluid after-icon" src="assets/img/setting/security-icon-after.png" />
									</span>
									<span class="text">Security</span>
								</a>
								<!-- Each item -->
								<a href="#notification" id="notification-tab" data-toggle="tab" aria-controls="notification" aria-selected="false" class="nav-item nav-link profile-setting-breadcrumb-item d-flex flex-row align-items-center">
									<span>
										<img class="img-fluid before-icon" src="assets/img/setting/notifications-icon-before.png" />
										<img class="img-fluid after-icon" src="assets/img/setting/notifications-icon-after.png" />
									</span>
									<span class="text">Notifications</span>
								</a>
								<!-- Each item -->
								<a href="#payments" id="payments-tab" data-toggle="tab" aria-controls="payments" aria-selected="false" class="nav-item nav-link profile-setting-breadcrumb-item d-flex flex-row align-items-center">
									<span>
										<img class="img-fluid before-icon" src="assets/img/setting/payments-icon-before.png" />
										<img class="img-fluid after-icon" src="assets/img/setting/payments-icon-after.png" />
									</span>
									<span class="text">Payments</span>
								</a>
								<!-- Each item -->
							</div>
						</div>
						<div class="col-12 col-lg-8">
							<div class="tab-content" id="setting-tabContent">
								<div class="tab-pane fade show active" id="security" role="tabpanel" aria-labelledby="security-tab">
									<div class="profile-setting-card d-flex flex-column">
										<div class="profile-setting-card-header">
											<div class="icon-title d-flex flex-row align-items-center">
												<span>
													<img src="assets/img/setting/password-icon.png" />
												</span>
												<span>Password</span>
											</div>
											<div class="title">Update Your Password</div>
											<div class="icon d-flex flex-row">
												<button type="button" role="button">
													<i class="fas fa-check-circle"></i>
												</button>
												<button type="button" role="button">
													<i class="fal fa-times-circle"></i>
												</button>
											</div>
										</div>
										<!-- Profile setting card header -->
										<div class="profile-setting-card-body">
											<form method="post" class="clearfix">
												<div class="row">
													<div class="col-12">
														<div class="form-group d-flex flex-column">
															<label class="control-label">Current Password</label>
															<input type="password" class="form-control" name="old_pass" />
														</div>
													</div>
													<div class="col-12">
														<div class="form-group d-flex flex-column">
															<label class="control-label">New Password</label>
															<input type="password" class="form-control" id="psw" name="new_pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
														</div>
													</div>
													<div id="message">
													  <!-- <h3>Password must contain the following:</h3> -->
													  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
													  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
													  <p id="number" class="invalid">A <b>number</b></p>
													  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
													</div>
													<div class="col-12">
														<div class="form-group d-flex flex-column">
															<label class="control-label">Retype New Password</label>
															<input type="password" class="form-control" id="confirm_pass" name="new_pass_again" />
														</div>
													</div>
													<span id="match" class="pl-3"></span>
													<div class="col-12">
														<div class="form-group d-flex flex-column">
															<p class="mb-0">Password should be a minimum of 8 characters long. Containing at least one numeric value and one upper case character.</p>
														</div>
													</div>
													<div class="col-12">
														<div class="form-group d-flex flex-row justify-content-end mb-0">
															<button class="button button-white" type="button" role="button">Cancel</button>
															<button class="button button-red" type="submit" name="change_password">Save</button>
														</div>
													</div>
												</div>
											</form>
											<?php 
											  if(isset($_POST['change_password'])){
											  $rules = array(
											  "old_pass" => "required",
											  "new_pass" => "required",
											  "new_pass_again" => "required");
											  $messages = array("old_pass" => "Old Password Is Required.","new_pass" => "New Password Is Required.","new_pass_again"=>"New Password Again Is Required.");
											  $val = new Validator($_POST,$rules,$messages);
											  if($val->run() == false){
											    Flash::add("change_pass_errors",$val->get_all_errors());
											    Flash::add("form_data",$_POST);
											    echo "<script> window.open('settings?account_settings','_self');</script>";
											  }else{
											    $old_pass = $input->post('old_pass');
											    $new_pass = $input->post('new_pass');
											    $new_pass_again = $input->post('new_pass_again');
											    $get_seller = $db->select("sellers",array("seller_id"=>$login_seller_id));
											    $row_seller = $get_seller->fetch();
											    $hash_password = $row_seller->seller_pass;
											    $decrypt_password = password_verify($old_pass,$hash_password);
											    if($decrypt_password == 0){
											    echo "<script>
											      swal({
											      type: 'warning',
											      html: $('<div>').addClass('some-class').text('Your old password is invalid, please try again!.'),
											      animation: false,
											      customClass: 'animated tada'
											      });
											      </script>";
											    }else{
											      if($new_pass!=$new_pass_again){
											       echo "<script>alert('Your New Password dose not match.');</script>";
											      }else{
											        $encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);
											        $update_pass = $db->update("sellers",array("seller_pass" => $encrypted_password),array("seller_id" => $login_seller_id));
											        echo "<script>
											        swal({
											          type: 'success',
											          text: 'Password updated successfully, login with your new password.',
											          timer: 3000,
											          onOpen: function(){
											            swal.showLoading();
											          }
											        }).then(function(){
											          // Read more about handling dismissals
											          window.open('logout','_self')
											        });
											        </script>";
											      }
											    }
											    }
											  }
											  ?>
										</div>
									</div>
								</div>
								<!-- Security Tab Panel -->
								<div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
									<div class="profile-setting-card d-flex flex-column">
										<div class="profile-setting-card-header">
											<div class="icon-title d-flex flex-row align-items-center">
												<span>
													<img src="assets/img/setting/notification-icon.png" />
												</span>
												<span>Notifications</span>
											</div>
											<div class="title">Customize Notifications</div>
											<div class="icon d-flex flex-row">
												<button type="button" role="button">
													<i class="fas fa-check-circle"></i>
												</button>
												<button type="button" role="button">
													<i class="fal fa-times-circle"></i>
												</button>
											</div>
										</div>
										<!-- Profile setting card header -->
										<div class="profile-setting-card-body">
											<form action="" method="POST">
												<div class="notifications-group d-flex flex-column">
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>Inbox Messages</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck1">
															<label class="custom-control-label" for="customCheck1">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>Order messages</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck2">
															<label class="custom-control-label" for="customCheck2">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>Order updates</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck3">
															<label class="custom-control-label" for="customCheck3">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>Buyer Requests</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck4">
															<label class="custom-control-label" for="customCheck4">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>My Gigs</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck5">
															<label class="custom-control-label" for="customCheck5">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>My Account</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck6">
															<label class="custom-control-label" for="customCheck6">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
													<div class="notification-item d-flex flex-row align-items-center justify-content-between">
														<span>To-dos</span>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="customCheck7">
															<label class="custom-control-label" for="customCheck7">&nbsp;</label>
														</div>
													</div>
													<!-- Each item -->
												</div>
												<div class="form-group d-flex flex-row justify-content-end mb-0">
													<button class="button button-white" type="button" role="button">Cancel</button>
													<button class="button button-red" type="submit" role="button">Save</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<!-- Notification Tab Panel -->
								<?php if($login_user_type == 'seller'){ ?> 
									<div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
										<div class="profile-setting-card d-flex flex-column">
											<div class="profile-setting-card-header">
												<div class="icon-title d-flex flex-row align-items-center">
													<span>
														<img src="assets/img/setting/payments-icon.png" />
													</span>
													<span>Payments</span>
												</div>
												<div class="title">Add Payment Methods</div>
												<div class="icon d-flex flex-row">&nbsp;</div>
											</div>
											<!-- Profile setting card header -->
											<div class="profile-setting-card-body">
												<form action="" method="POST">
													<h4>How you would like to get paid by eMongez</h4>
													<ul class="nav nav-tabs pyments-tab" id="pymentsTab" role="tablist">
														<li class="nav-item">
															<a class="nav-link active" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="true">
																<span><img class="img-fluid d-block" src="assets/img/setting/paypal.png" /></span>
																<span>PayPal</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="false">
																<span><img class="img-fluid d-block" src="assets/img/setting/bank-transfer.png" /></span>
																<span>Bank Transfer</span>
															</a>
														</li>
													</ul>
													<div class="tab-content" id="paymentsTabContent">
														<div class="tab-pane fade show active" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
															<form method="post" class="clearfix">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">Email Address</label>
																			<input type="email" name="seller_paypal_email" value="<?= $login_seller_paypal_email; ?>" placeholder="Enter Your PayPal Email Address" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">Edit</button>
																			<button class="button button-red" type="submit" name="submit_paypal_email">Submit</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php

															if(isset($_POST['submit_paypal_email'])){
															  $seller_paypal_email = strip_tags($input->post('seller_paypal_email'));
															  $update_seller = $db->update("sellers",array("seller_paypal_email" => $seller_paypal_email),array("seller_id" => $login_seller_id));
															  if($update_seller){
															    echo "<script>
															    swal({
															    type: 'success',
															    text: 'PayPal email updated successfully!',
															    timer: 3000,
															    onOpen: function(){
															    swal.showLoading()
															    }
															    }).then(function(){
															      if (
															        // Read more about handling dismissals
															        window.open('settings?account_settings','_self')
															      ) {
															        console.log('email updated successfully')
															      }
															    });</script>";
															  }
															}

															if($paymentGateway == 1){ 
															  include("plugins/paymentGateway/account_settings.php");
															} 

															?>
														</div>
														<div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
															<form method="post" class="clearfix">
																<input type="hidden" name="account_type" value="bank_transfer">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">Account Full Name</label>
																			<input type="text" name="account_full_name" value="<?= $account_full_name; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">IBAN Number</label>
																			<input type="text" name="iban" value="<?= $iban ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">Bank Name & Address</label>
																			<input type="text" name="bank_name_address" value="<?= $bank_name_address ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">Swift Code</label>
																			<input type="text" name="swift_code" value="<?= $swift_code ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">Edit</button>
																			<button class="button button-red" type="submit" name="submit_bank_info">Submit</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php 
																if(isset($_POST['submit_bank_info'])){
																	$account_type = strip_tags($input->post('account_type'));
																	$account_full_name = strip_tags($input->post('account_full_name'));
																	$iban = strip_tags($input->post('iban'));
																	$bank_name_address = strip_tags($input->post('bank_name_address'));
																	$swift_code = strip_tags($input->post('swift_code'));
																	// print_r($login_seller_id);die();
																	if (count($seller_account_id) == 0) {
																		$update_bank_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"account_full_name" => $account_full_name,"iban" => $iban, "bank_name_address" => $bank_name_address, "swift_code" => $swift_code));
																	}else{
																		$update_bank_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"account_full_name" => $account_full_name,"iban" => $iban, "bank_name_address" => $bank_name_address, "swift_code" => $swift_code),array("seller_id" => $login_seller_id));	
																	}
																	
																	// print_r($update_bank_info);die();
																	if($update_bank_info){
																	echo "<script>
																	swal({
																	type: 'success',
																	text: 'Bank Account Details Updated Successfully!',
																	timer: 3000,
																	onOpen: function(){
																	swal.showLoading()
																	}
																	}).then(function(){
																	window.open('settings?account_settings','_self')
																	});
																	</script>";
																	}
																}
															?>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- Payments Tab Panel -->
								<?php }else{ ?>
								 	<div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
									 	<div class="profile-setting-card d-flex flex-column">
									 		<div class="profile-setting-card-header">
									 			<div class="icon-title d-flex flex-row align-items-center">
									 				<span>
									 					<img src="assets/img/setting/payments-icon.png" />
									 				</span>
									 				<span>Payments</span>
									 			</div>
									 			<div class="title">Add Payment Methods</div>
									 			<div class="icon d-flex flex-row">&nbsp;</div>
									 		</div>
									 		<!-- Profile setting card header -->
									 		<div class="profile-setting-card-body">
									 			<form action="" method="POST">
									 				<h4>How you would like to pay on eMongez</h4>
									 				<ul class="nav nav-tabs pyments-tab" id="pymentsTab" role="tablist">
									 					<li class="nav-item">
									 						<a class="nav-link active" id="online-tab" data-toggle="tab" href="#online" role="tab" aria-controls="online" aria-selected="true">
									 							<span><img class="img-fluid d-block" src="assets/img/setting/online.png" /></span>
									 							<span>Online</span>
									 						</a>
									 					</li>
									 					<li class="nav-item">
									 						<a class="nav-link" id="mobile-tab" data-toggle="tab" href="#mobile" role="tab" aria-controls="mobile" aria-selected="false">
									 							<span><img class="img-fluid d-block" src="assets/img/setting/mobile.png" /></span>
									 							<span>Mobile Wallet</span>
									 						</a>
									 					</li>
									 					<li class="nav-item">
									 						<a class="nav-link" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="false">
									 							<span><img class="img-fluid d-block" src="assets/img/setting/cash.png" /></span>
									 							<span>Cash</span>
									 						</a>
									 					</li>
									 					<li class="nav-item">
									 						<a class="nav-link" id="local-tab" data-toggle="tab" href="#local" role="tab" aria-controls="local" aria-selected="false">
									 							<span><img class="img-fluid d-block" src="assets/img/setting/local.png" /></span>
									 							<span>Local</span>
									 						</a>
									 					</li>
									 				</ul>
									 				<div class="tab-content" id="paymentsTabContent">
									 					<div class="tab-pane fade show active" id="online" role="tabpanel" aria-labelledby="online-tab">
									 						<div class="online-tab d-flex flex-column">
									 							<div class="custom-control custom-radio">
									 								<input hidden data-toggle="collapse" data-target="#credit-card" aria-controls="credit-card" type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
									 								<label class="custom-control-label" for="customRadio1">
									 									<span>
									 										<img class="img-fluid before-icon" src="assets/img/setting/cradit-card-before.png" />
									 										<img class="img-fluid after-icon" src="assets/img/setting/cradit-card-after.png" />
									 									</span>
									 									<span>Credit or debit card</span>
									 								</label>
									 								<div class="collapse mt-30" id="credit-card">
									 									<form method="post" class="clearfix">
									 										<input type="hidden" name="account_type" value="card_info">
										 									<div class="row">
										 										<div class="col-12 col-md-6">
										 											<div class="form-group">
										 												<label class="control-label">Card Number</label>
										 												<input type="text" name="card_number" value="<?= $card_number; ?>" class="form-control ccFormatMonitor" />
										 											</div>
										 										</div>
										 										<div class="col-12 col-md-6">
										 											<div class="form-group">
										 												<label class="control-label">Name on card</label>
										 												<input type="text" name="card_name" value="<?= $card_name; ?>" class="form-control" />
										 											</div>
										 										</div>
										 										<div class="col-12 col-md-6">
										 											<div class="form-group">
										 												<label class="control-label">Expiry Date</label>
										 												<input type="text" id="inputExpDate" name="expiry_date" value="<?= $expiry_date; ?>" class="form-control" />
										 											</div>
										 										</div>
										 										<div class="col-12 col-md-6">
										 											<div class="form-group">
										 												<label class="control-label">Security Code</label>
										 												<input type="text" name="security_code" value="<?= $security_code; ?>" pattern="[0-9]{3}" class="form-control cvv" />
										 											</div>
										 										</div>
										 										<div class="col-12">
										 											<div class="form-group d-flex flex-row mb-0">
										 												<button class="button button-white" type="button" role="button">Edit</button>
										 												<button class="button button-red" type="submit" name="submit_card_info">Submit</button>
										 											</div>
										 										</div>
										 									</div>
										 								</form>
										 								<?php 
										 									if(isset($_POST['submit_card_info'])){
										 										$account_type = strip_tags($input->post('account_type'));
										 										$card_name = strip_tags($input->post('card_name'));
										 										$card_number = strip_tags($input->post('card_number'));
										 										$expiry_date = strip_tags($input->post('expiry_date'));
										 										$security_code = strip_tags($input->post('security_code'));
										 										// print_r($login_seller_id);die();
										 										if (count($seller_account_id) == 0) {
										 											$update_bank_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"card_name" => $card_name,"card_number" => $card_number, "expiry_date" => $expiry_date, "security_code" => $security_code));
										 										}else{
										 										$update_bank_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"card_name" => $card_name,"card_number" => $card_number, "expiry_date" => $expiry_date, "security_code" => $security_code),array("seller_id" => $login_seller_id));
										 										// print_r($update_bank_info);die();
										 										}
										 										if($update_bank_info){
										 										echo "<script>
										 										swal({
										 										type: 'success',
										 										text: 'Card Details Updated Successfully!',
										 										timer: 3000,
										 										onOpen: function(){
										 										swal.showLoading()
										 										}
										 										}).then(function(){
										 										window.open('settings?account_settings','_self')
										 										});
										 										</script>";
										 										}
										 									}
										 								?>
									 								</div>
									 							</div>
									 							<div class="custom-control custom-radio">
									 								<input hidden data-toggle="collapse" data-target="#paypal" aria-controls="paypal" type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
									 								<label class="custom-control-label" for="customRadio2">
									 									<span>
									 										<img class="img-fluid before-icon" src="assets/img/setting/paypal-before.png" />
									 										<img class="img-fluid after-icon" src="assets/img/setting/paypal-after.png" />
									 									</span>
									 									<span>Paypal</span>
									 								</label>
									 								<div class="collapse mt-30" id="paypal">
									 									<form method="post" class="clearfix">
									 										<div class="row">
									 											<div class="col-12">
									 												<div class="form-group">
									 													<label class="control-label">Email Address</label>
									 													<input type="email" name="seller_paypal_email" value="<?= $login_seller_paypal_email; ?>" placeholder="Enter paypal email" class="form-control" required />
									 												</div>
									 											</div>
									 											<div class="col-12">
									 												<div class="form-group d-flex flex-row mb-0">
									 													<button class="button button-white" type="button" role="button">Edit</button>
									 													<button class="button button-red" type="submit" name="submit_paypal_email">Submit</button>
									 												</div>
									 											</div>
									 										</div>
									 									</form>
									 									<?php

									 									if(isset($_POST['submit_paypal_email'])){
									 									  $seller_paypal_email = strip_tags($input->post('seller_paypal_email'));
									 									  $update_seller = $db->update("sellers",array("seller_paypal_email" => $seller_paypal_email),array("seller_id" => $login_seller_id));
									 									  if($update_seller){
									 									    echo "<script>
									 									    swal({
									 									    type: 'success',
									 									    text: 'PayPal email updated successfully!',
									 									    timer: 3000,
									 									    onOpen: function(){
									 									    swal.showLoading()
									 									    }
									 									    }).then(function(){
									 									      if (
									 									        // Read more about handling dismissals
									 									        window.open('settings?account_settings','_self')
									 									      ) {
									 									        console.log('email updated successfully')
									 									      }
									 									    });</script>";
									 									  }
									 									}

									 									if($paymentGateway == 1){ 
									 									  include("plugins/paymentGateway/account_settings.php");
									 									} 

									 									?>
									 								</div>
									 							</div>
									 							<div class="custom-control custom-radio">
									 								<input hidden type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
									 								<label class="custom-control-label" for="customRadio3">
									 									<span>
									 										<img class="img-fluid before-icon" src="assets/img/setting/em-wallet.png" />
									 										<img class="img-fluid after-icon" src="assets/img/setting/em-wallet.png" />
									 									</span>
									 									<span>Emongez Wallet</span>
									 								</label>
									 							</div>
									 						</div>
									 					</div>
									 					<div class="tab-pane fade" id="mobile" role="tabpanel" aria-labelledby="mobile-tab">
									 						<form method="post" class="clearfix mb-3">
									 							<div class="row">
									 								<div class="col-12">
									 									<div class="form-group">
									 										<label class="control-label">Account Number</label>
									 										<input type="text" name="m_account_number" value="<?= $login_seller_account_number; ?>" placeholder="Enter Account Number" class="form-control" />
									 									</div>
									 								</div>
									 								<div class="col-12">
									 									<div class="form-group">
									 										<label class="control-label">Account/Owner Name</label>
									 										<input type="text" name="m_account_name" value="<?= $login_seller_account_name; ?>" placeholder="Enter Account/Owner Name" class="form-control" />
									 									</div>
									 								</div>
									 								<div class="col-12">
									 									<div class="form-group d-flex flex-row mb-0">
									 										<button class="button button-white" type="button" role="button">Edit</button>
									 										<button class="button button-red" type="submit" name="update_mobile_money">Submit</button>
									 									</div>
									 								</div>
									 							</div>
									 						</form>
									 						<?php 
									 						  if(isset($_POST['update_mobile_money'])){
									 						  $m_account_number = strip_tags($input->post('m_account_number'));
									 						  $m_account_name = strip_tags($input->post('m_account_name'));
									 						  $update_seller = $db->update("sellers",array("seller_m_account_number" => $m_account_number,"seller_m_account_name" => $m_account_name),array("seller_id" => $login_seller_id));
									 						  if($update_seller){
									 						  echo "<script>
									 						  swal({
									 						  type: 'success',
									 						  text: 'Mobile Money Updated Successfully!',
									 						  timer: 3000,
									 						  onOpen: function(){
									 						  swal.showLoading()
									 						  }
									 						  }).then(function(){
									 						  window.open('settings?account_settings','_self')
									 						  });
									 						  </script>";
									 						  }
									 						  }
									 						?>
									 					</div>
									 					<div class="tab-pane fade" id="cash" role="tabpanel" aria-labelledby="cash-tab">
									 						<form method="post" class="clearfix">
									 							<input type="hidden" name="account_type" value="cash_info">
										 						<div class="row">
										 							<div class="col-12">
										 								<div class="form-group">
										 									<label class="control-label">Mobile Number</label>
										 									<input type="text" name="mobile_number" value="<?= $mobile_number; ?>" class="form-control" />
										 								</div>
										 							</div>
										 							<div class="col-12">
										 								<div class="form-group">
										 									<label class="control-label">Address</label>
										 									<input type="text" name="address" value="<?= $address; ?>" class="form-control" />
										 								</div>
										 							</div>
										 							<div class="col-12 col-md-6">
										 								<div class="form-group">
										 									<label class="control-label">Apartment Number</label>
										 									<input type="text" name="apartment_number" value="<?= $apartment_number; ?>" class="form-control" />
										 								</div>
										 							</div>
										 							<div class="col-12 col-md-6">
										 								<div class="form-group">
										 									<label class="control-label">Floor Number</label>
										 									<input type="text" name="floor_number" value="<?= $floor_number; ?>" class="form-control" />
										 								</div>
										 							</div>
										 							<div class="col-12 col-md-6">
										 								<div class="form-group d-flex flex-column state_box">
										 									<label class="control-label">Country</label>
										 									<select class="form-control wide" name="country" onChange="getState(this.value);" id="country">
										 										<option>Select Country</option>
										 										<?php
			                                    $get_countries = $db->select("countries");
			                                    while($row_countries = $get_countries->fetch()){
			                                      $id = $row_countries->id;
			                                      $name = $row_countries->name;
			                                      echo "<option value='$name'".($name == $country ? "selected" : "").">$name</option>";
			                                    }
			                                    ?>
										 									</select>
										 								</div>
										 							</div>
										 							<div class="col-12 col-md-6">
										 								<div class="form-group d-flex flex-column state_box">
										 									<label class="control-label">State</label>
										 									<select class="form-control wide" name="state" onChange="getCity(this.value);" id="state-list">
										 										<?php if(!empty($state)){ ?>
										 											<option selected><?= $state; ?></option>
										 										<?php } ?>
										 									</select>
										 								</div>
										 							</div>
										 							<div class="col-12">
										 								<div class="form-group d-flex flex-column state_box">
										 									<label class="control-label">City</label>
										 									<select class="form-control wide" name="city" required="" id="city-list">
										 										<?php if(!empty($city)){ ?>
										 											<option selected><?= $city; ?></option>
										 										<?php } ?>
										 									</select>
										 								</div>
										 							</div>
										 							<div class="col-12">
										 								<div class="form-group d-flex flex-row mb-0">
										 									<button class="button button-white" type="button" role="button">Edit</button>
										 									<button class="button button-red" type="submit" name="submit_cash_info">Submit</button>
										 								</div>
										 							</div>
										 						</div>
										 					</form>
										 					<?php 
										 						if(isset($_POST['submit_cash_info'])){
										 							$account_type = strip_tags($input->post('account_type'));
										 							$mobile_number = strip_tags($input->post('mobile_number'));
										 							$address = strip_tags($input->post('address'));
										 							$apartment_number = strip_tags($input->post('apartment_number'));
										 							$floor_number = strip_tags($input->post('floor_number'));
										 							$country = strip_tags($input->post('country'));
										 							$state = strip_tags($input->post('state'));
										 							$city = strip_tags($input->post('city'));
										 							// print_r($login_seller_id);die();
										 							if (count($seller_account_id) == 0) {
										 								$update_cash_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"mobile_number" => $mobile_number,"address" => $address, "apartment_number" => $apartment_number, "floor_number" => $floor_number, "country" => $country, "state" => $state, "city" => $city));
										 							}else{
										 								$update_cash_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"mobile_number" => $mobile_number,"address" => $address, "apartment_number" => $apartment_number, "floor_number" => $floor_number, "country" => $country, "state" => $state, "city" => $city),array("seller_id" => $login_seller_id));	
										 							}
										 							
										 							// print_r($update_bank_info);die();
										 							if($update_cash_info){
										 							echo "<script>
										 							swal({
										 							type: 'success',
										 							text: 'Cash Details Updated Successfully!',
										 							timer: 3000,
										 							onOpen: function(){
										 							swal.showLoading()
										 							}
										 							}).then(function(){
										 							window.open('settings?account_settings','_self')
										 							});
										 							</script>";
										 							}
										 						}
										 					?>
									 					</div>
									 					<div class="tab-pane fade" id="local" role="tabpanel" aria-labelledby="local-tab">
									 						<form class="clearfix" method="post">
									 							<input type="hidden" name="account_type" value="local_payment">
										 						<div class="row">
										 							<div class="col-12">
										 								<div class="form-group">
										 									<label class="control-label">Mobile Number</label>
										 									<input type="text" name="local_mobile_number" value="<?= $local_mobile_number; ?>" class="form-control" />
										 								</div>
										 							</div>
										 							<div class="col-12">
										 								<div class="form-group">
										 									<label class="control-label">Email Address</label>
										 									<input type="email" name="local_email" value="<?= $local_email; ?>" class="form-control" />
										 								</div>
										 							</div>
										 							<div class="col-12">
										 								<div class="form-group d-flex flex-row mb-0">
										 									<button class="button button-white" type="button" role="button">Edit</button>
										 									<button class="button button-red" type="submit" name="local_payment_info">Submit</button>
										 								</div>
										 							</div>
										 						</div>
										 					</form>
										 					<?php 
										 						if(isset($_POST['local_payment_info'])){
										 							$account_type = strip_tags($input->post('account_type'));
										 							$local_mobile_number = strip_tags($input->post('local_mobile_number'));
										 							$local_email = strip_tags($input->post('local_email'));
										 							// print_r($login_seller_id);die();
										 							if (count($seller_account_id) == 0) {
										 								$update_cash_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"local_mobile_number" => $local_mobile_number,"local_email" => $local_email));
										 							}else{
										 								$update_cash_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"local_mobile_number" => $local_mobile_number,"local_email" => $local_email),array("seller_id" => $login_seller_id));	
										 							}
										 							
										 							// print_r($update_bank_info);die();
										 							if($update_cash_info){
										 							echo "<script>
										 							swal({
										 							type: 'success',
										 							text: 'Local Payments Details Updated Successfully!',
										 							timer: 3000,
										 							onOpen: function(){
										 							swal.showLoading()
										 							}
										 							}).then(function(){
										 							window.open('settings?account_settings','_self')
										 							});
										 							</script>";
										 							}
										 						}
										 					?>
									 					</div>
									 				</div>
									 			</form>
									 		</div>
									 	</div>
								 	</div>
								 <!-- Payments Tab Panel -->
								<?php } ?>
							</div>
							
						</div>
					</div>
					<!-- Row -->
				</div>
			</div>
			<!-- Row -->
		</section>
	</main>
	<?php } ?>
<!-- <div class="container-fluid mt-5 mb-5">
	<div class="row terms-page" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
		<div class="col-md-3 mb-3">
			<div class="card">
				<div class="card-body">
					<ul class="nav nav-pills flex-column mt-2">
						<li class="nav-item">
						<a data-toggle="pill" href="#profile_settings" class="nav-link
						<?php
						if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){
						echo "active";
						}
						if(isset($_GET['profile_settings'])){ echo "active"; }
						?>">
						<?php echo $lang["titles"]["settings"]["profile_settings"]; ?>
						</a>
						</li>
						<li class="nav-item">
							<a data-toggle="pill" href="#account_settings" class="nav-link
              <?php
	              if(isset($_GET['account_settings'])){
	              	echo "active";
	              }
              ?>
              ">
							 <?php echo $lang["titles"]["settings"]["account_settings"]; ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="tab-content">
					<div id="profile_settings" class="tab-pane fade <?php if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){ echo "show active"; } if(isset($_GET['profile_settings'])){ echo "show active"; } ?>">
						<h2 class="mb-4"><?php echo $lang["titles"]["settings"]["profile_settings"]; ?></h2>
            <?php //require_once("profile_settings.php") ?>
					</div>
					<div id="account_settings" class="tab-pane fade <?php if(isset($_GET['account_settings'])){ echo "show active"; } ?>">
						<h2 class="mb-4"><?php echo $lang["titles"]["settings"]["account_settings"]; ?></h2>
						<?php //require_once("account_settings.php") ?>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<div id="insertimageModal" class="modal" role="dialog">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Image <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="image_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type" value="">
      <button class="btn btn-success crop_image">Crop Image</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div id="insertCoverModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Cover <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="cover_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type_cover" value="">
      <button class="btn btn-success crop_image_cover">Crop Image</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div id="wait"></div>
<script>
	$('#country option[value="Egypt"]').insertBefore('#country option[value="Afghanistan"]');
	$('#verification_tab').click(function(){
		$('#account_verification').addClass('show active');
		$('#profile_settings').removeClass('show active');
		$('#verification_tab').addClass('active');
	});
	$('#profile_tab').click(function(){
		$('#account_verification').removeClass('show active');
		$('#profile_settings').addClass('show active');
		$('#verification_tab').removeClass('active');
	});
	function getState(val) {
	  $.ajax({
	    type: "POST",
	    url: "get-state",
	    data:'country_name='+val,
	    beforeSend: function() {
	      $("#state-list").addClass("loader");
	    },
	    success: function(data){
	      // console.log(data);
	      $("#state-list").html(data);
	      $('#city-list').find('option[value]').remove();
	      $("#state-list").removeClass("loader");
	    }
	  });
	}
	function getCity(val) {
	  // alert(val);
	  $.ajax({
	    type: "POST",
	    url: "get-city",
	    data:'state_name='+val,
	    beforeSend: function() {
	      $("#city-list").addClass("loader");
	    },
	    success: function(data){
	      $("#city-list").html(data);
	      $("#city-list").removeClass("loader");
	    }
	  });
	}
</script>
<script>
	$(document).ready(function() {
		$('.js-example-basic-multiple').select2();
	});
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
$('#confirm_pass').on('keyup', function () {
  if ($('#psw').val() == $('#confirm_pass').val()) {
    $('#match').html('Password Match').css('color', 'green');
  } else 
    $('#match').html('Password Not Matching').css('color', 'red');
});

$('#creditCardText').keyup(function() {
  var foo = $(this).val().split("-").join(""); // remove hyphens
  if (foo.length > 0) {
    foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
  }
  $(this).val(foo);
});
var app;

(function() {
  'use strict';
  
  app = {
    monthAndSlashRegex: /^\d\d \/ $/, // regex to match "MM / "
    monthRegex: /^\d\d$/, // regex to match "MM"
    
    el_cardNumber: '.ccFormatMonitor',
    el_expDate: '#inputExpDate',
    el_cvv: '.cvv',
    el_ccUnknown: 'cc_type_unknown',
    el_ccTypePrefix: 'cc_type_',
    el_monthSelect: '#monthSelect',
    el_yearSelect: '#yearSelect',
    
    cardTypes: {
      'American Express': {
        name: 'American Express',
        code: 'ax',
        security: 4,
        pattern: /^3[47]/,
        valid_length: [15],
        formats: {
          length: 15,
          format: 'xxxx xxxxxxx xxxx'
        }
      },
      'Visa': {
				name: 'Visa',
				code: 'vs',
        security: 3,
				pattern: /^4/,
				valid_length: [16],
				formats: {
						length: 16,
						format: 'xxxx xxxx xxxx xxxx'
					}
			},
      'Maestro': {
				name: 'Maestro',
				code: 'ma',
        security: 3,
				pattern: /^(50(18|20|38)|5612|5893|63(04|90)|67(59|6[1-3])|0604)/,
				valid_length: [16],
				formats: {
						length: 16,
						format: 'xxxx xxxx xxxx xxxx'
					}
			},
      'Mastercard': {
				name: 'Mastercard',
				code: 'mc',
        security: 3,
				pattern: /^5[1-5]/,
				valid_length: [16],
				formats: {
						length: 16,
						format: 'xxxx xxxx xxxx xxxx'
					}
			} 
    }
  };
  
  app.addListeners = function() {
      $(app.el_expDate).on('keydown', function(e) {
        app.removeSlash(e);
      });

      $(app.el_expDate).on('keyup', function(e) {
        app.addSlash(e);
      });

      $(app.el_expDate).on('blur', function(e) {
        app.populateDate(e);
      });

      $(app.el_cvv +', '+ app.el_expDate).on('keypress', function(e) {
        return e.charCode >= 48 && e.charCode <= 57;
      });  
  };
  
  app.addSlash = function (e) {
    var isMonthEntered = app.monthRegex.exec(e.target.value);
    if (e.key >= 0 && e.key <= 9 && isMonthEntered) {
      e.target.value = e.target.value + " / ";
    }
  };
  
  app.removeSlash = function(e) {
    var isMonthAndSlashEntered = app.monthAndSlashRegex.exec(e.target.value);
    if (isMonthAndSlashEntered && e.key === 'Backspace') {
      e.target.value = e.target.value.slice(0, -3);
    }
  };
  
  app.populateDate = function(e) {
    var month, year;
    
    if (e.target.value.length == 7) {
      month = parseInt(e.target.value.slice(0, -5));
      year = "20" + e.target.value.slice(5);
      
      if (app.checkMonth(month)) {
        $(app.el_monthSelect).val(month);
      } else {
        $(app.el_monthSelect).val(0);
      }
      
      if (app.checkYear(year)) {
        $(app.el_yearSelect).val(year);
      } else {
        $(app.el_yearSelect).val(0);
      }
      
    }
  };
  
  app.checkMonth = function(month) {
    if (month <= 12) {
      var monthSelectOptions = app.getSelectOptions($(app.el_monthSelect));
      month = month.toString();
      if (monthSelectOptions.includes(month)) {
        return true; 
      }
    }
  };
  
  app.checkYear = function(year) {
    var yearSelectOptions = app.getSelectOptions($(app.el_yearSelect));
    if (yearSelectOptions.includes(year)) {
      return true; 
    }
  };
          
  app.getSelectOptions = function(select) {
    var options = select.find('option');
    var optionValues = [];
    for (var i = 0; i < options.length; i++) {
      optionValues[i] = options[i].value;
    }
    return optionValues;
  };
  
  app.setMaxLength = function ($elem, length) {
    if($elem.length && app.isInteger(length)) {
      $elem.attr('maxlength', length);
    }else if($elem.length){
      $elem.attr('maxlength', '');
    }
  };
  
  app.isInteger = function(x) {
    return (typeof x === 'number') && (x % 1 === 0);
  };

  app.createExpDateField = function() {
    $(app.el_monthSelect +', '+ app.el_yearSelect).hide();
    $(app.el_monthSelect).parent().prepend('<input type="text" class="ccFormatMonitor">');
  };
  
  
  app.isValidLength = function(cc_num, card_type) {
    for(var i in card_type.valid_length) {
      if (cc_num.length <= card_type.valid_length[i]) {
        return true;
      }
    }
    return false;
  };

  app.getCardType = function(cc_num) {
    for(var i in app.cardTypes) {
      var card_type = app.cardTypes[i];
      if (cc_num.match(card_type.pattern) && app.isValidLength(cc_num, card_type)) {
        return card_type;
      }
    }
  };

  app.getCardFormatString = function(cc_num, card_type) {
    for(var i in card_type.formats) {
      var format = card_type.formats[i];
      if (cc_num.length <= format.length) {
        return format;
      }
    }
  };

  app.formatCardNumber = function(cc_num, card_type) {
    var numAppendedChars = 0;
    var formattedNumber = '';
    var cardFormatIndex = '';

    if (!card_type) {
      return cc_num;
    }

    var cardFormatString = app.getCardFormatString(cc_num, card_type);
    for(var i = 0; i < cc_num.length; i++) {
      cardFormatIndex = i + numAppendedChars;
      if (!cardFormatString || cardFormatIndex >= cardFormatString.length) {
        return cc_num;
      }

      if (cardFormatString.charAt(cardFormatIndex) !== 'x') {
        numAppendedChars++;
        formattedNumber += cardFormatString.charAt(cardFormatIndex) + cc_num.charAt(i);
      } else {
        formattedNumber += cc_num.charAt(i);
      }
    }

    return formattedNumber;
  };

  app.monitorCcFormat = function($elem) {
    var cc_num = $elem.val().replace(/\D/g,'');
    var card_type = app.getCardType(cc_num);
    $elem.val(app.formatCardNumber(cc_num, card_type));
    app.addCardClassIdentifier($elem, card_type);
  };

  app.addCardClassIdentifier = function($elem, card_type) {
    var classIdentifier = app.el_ccUnknown;
    if (card_type) {
      classIdentifier = app.el_ccTypePrefix + card_type.code;
      app.setMaxLength($(app.el_cvv), card_type.security);
    } else {
      app.setMaxLength($(app.el_cvv));
    }

    if (!$elem.hasClass(classIdentifier)) {
      var classes = '';
      for(var i in app.cardTypes) {
        classes += app.el_ccTypePrefix + app.cardTypes[i].code + ' ';
      }
      $elem.removeClass(classes + app.el_ccUnknown);
      $elem.addClass(classIdentifier);
    }
  };

  
  app.init = function() {

    $(document).find(app.el_cardNumber).each(function() {
      var $elem = $(this);
      if ($elem.is('input')) {
        $elem.on('input', function() {
          app.monitorCcFormat($elem);
        });
      }
    });
    
    app.addListeners();
    
  }();
  
})();
</script>
<?php require_once("includes/footer.php"); ?>

</body>
</html>