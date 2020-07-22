<?php
	session_start();
	require_once("includes/db.php");
	require_once("functions/processing_fee.php");

	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('login','_self')</script>";
	}

	if(!isset($_POST['add_order']) and !isset($_POST['add_cart']) and !isset($_POST['coupon_submit']) and !isset($_SESSION['c_proposal_id'])){
		echo "<script>window.open('index','_self')</script>";
	}

	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$enable_paypal = $row_payment_settings->enable_paypal;
	$paypal_email = $row_payment_settings->paypal_email;
	$paypal_currency_code = $row_payment_settings->paypal_currency_code;
	$paypal_sandbox = $row_payment_settings->paypal_sandbox;
	$enable_dusupay = $row_payment_settings->enable_dusupay;

	if($paypal_sandbox == "on"){
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}elseif($paypal_sandbox == "off"){
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	}

	$enable_stripe = $row_payment_settings->enable_stripe;
	$enable_weaccept = $row_payment_settings->enable_weaccept;
	$enable_payza = $row_payment_settings->enable_payza;
	$payza_test = $row_payment_settings->payza_test;
	$payza_currency_code = $row_payment_settings->payza_currency_code;
	$payza_email = $row_payment_settings->payza_email;

	$enable_coinpayments = $row_payment_settings->enable_coinpayments;
	$coinpayments_merchant_id = $row_payment_settings->coinpayments_merchant_id;
	$coinpayments_currency_code = $row_payment_settings->coinpayments_currency_code;

	if($paymentGateway == 1){
		$enable_2checkout = $row_payment_settings->enable_2checkout;
	}else{
		$enable_2checkout = "no"; 
	}

	$enable_paystack = $row_payment_settings->enable_paystack;

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	

	if(isset($_POST['add_order']) or isset($_POST['coupon_submit'])){

	$_SESSION['c_offer_id'] = $input->post('offer_id');
	$_SESSION['c_request_id'] = $input->post('request_id');

	if(isset($_SESSION['c_offer_id'])){

	$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
	$row_seller_accounts = $select_seller_accounts->fetch();
	$current_balance = $row_seller_accounts->current_balance;

	// $_SESSION['c_offer_id'] = $input->post('offer_id');
	// $_SESSION['c_request_id'] = $input->post('request_id');

	$offer_id = $input->post('offer_id');
	$request_id = $input->post('request_id');

	$select_offers = $db->select("send_offers",array("offer_id" => $offer_id));
	$row_offers = $select_offers->fetch();
	$proposal_id = $row_offers->proposal_id;
	$description = $row_offers->description;
	$delivery_time = $row_offers->delivery_time;
	$amount = $row_offers->amount;
	$sub_total = $amount*1;
	$processing_fee = processing_fee($amount);
	$gst = 3;
	$total = $amount+$processing_fee+$gst;

	$get_requests = $db->select("buyer_requests",array("request_id" => $request_id));
	$row_requests = $get_requests->fetch();
	$request_description = $row_requests->request_description;

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;
	$proposal_img1 = $row_proposals->proposal_img1;
	$proposal_description = $row_proposals->proposal_desc;

	$get_site_logo_image = $row_general_settings->site_logo;


	$select_buyer_payment_account = $db->select("seller_payment_account", array("seller_id" => $login_seller_id));
	$row_buyer_account = $select_buyer_payment_account->fetch();
	$seller_account_id = $row_buyer_account->seller_id;
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
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">

<head>
	<title><?= $site_name; ?> - Checkout</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?= $site_author; ?>">
	<!--====== Bootstrap css ======-->
  <link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
	<link href="styles/styles.css" rel="stylesheet">
	<!-- <link href="styles/categories_nav_styles.css" rel="stylesheet"> -->
	<!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet"> -->
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
	<link href="styles/sweat_alert.css" rel="stylesheet">
	<script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<?php if(!empty($site_favicon)){ ?>
	<link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
	<?php } ?>
	<style>
		.stripe-submit{
			border: 1px solid #ff0707;
	    background: #ff0707;
	    color: #fff;
	    text-transform: uppercase;
	    padding: 0 50px;
	    line-height: 50px;
	    -webkit-border-radius: 6px;
	    -moz-border-radius: 6px;
	    border-radius: 6px;
	    font-weight: 600;
	    margin-bottom: 30px;
	    cursor: pointer;
	    -webkit-transition: .4s;
	    -o-transition: .4s;
	    -moz-transition: .4s;
	    transition: .4s;
		}
		#state-list , #city-list, #country{
      height: 54px;
      display: block !important;
    }
    .state_box .nice-select{
      display: none !important;
    }
    .order-button{
			border: 1px solid #ff0707;
	    background: #ff0707;
	    color: #fff;
	    text-transform: uppercase;
	    padding: 0 50px;
	    line-height: 50px;
	    -webkit-border-radius: 6px;
	    -moz-border-radius: 6px;
	    border-radius: 6px;
	    font-weight: 600;
	    margin-bottom: 30px;
	    cursor: pointer;
	    -webkit-transition: .4s;
	    -o-transition: .4s;
	    -moz-transition: .4s;
	    transition: .4s;
	  }
	  #weaccept-cash-form{
	  	margin-top: -83px;
	  	float: left;
	  }
	  @media(max-width: 767px){
	  	.input-check-area{
	  		float: none !important;
	  	}
	  	#credit-card-form, #shopping-balance-form, #paypal-form{
	  		margin-top: 14px !important; 
	  		float: none !important;
	  	}
	  	#credit-card-form button, #shopping-balance-form button, #paypal-form button{
	  		margin-bottom: 0;
	  		width: 100%;
	  	}
	  	.stripe-submit{
	  		margin-bottom: 0;
	  		width: 100%;
	  	}
	  	#edit_info{
	  		width: 100% !important;
	  		float: none !important;
	  	}
	  	#weaccept-cash-form {
	  	    margin-top: 0px;
	  	    float: none !important;
	  	}
	  	.order-button{
	  		width: 100%;
	  	}
	  }
	</style>
</head>
<body class="all-content">
<?php
require_once("includes/buyer-header.php");
if($seller_verification != "ok"){
echo "
<div class='alert alert-danger rounded-0 mt-0 text-center'>
Please confirm your email to use this feature.
</div>";
}else{

$site_logo_image = $row_general_settings->site_logo;
$coupon_usage = "no";
$coupon_type = "";

if(isset($_POST['code'])){
	$coupon_code = $input->post('code');
	$select_coupon = $db->select("coupons",array("proposal_id"=>$proposal_id,"coupon_code"=>$coupon_code));
	$count_coupon = $select_coupon->rowCount();
	if($count_coupon == 1){
		$row_coupon = $select_coupon->fetch();
		$coupon_limit = $row_coupon->coupon_limit;
		$coupon_used = $row_coupon->coupon_used;
		$coupon_type = $row_coupon->coupon_type;
		$coupon_price = $row_coupon->coupon_price;
		if($coupon_limit <= $coupon_used){
			$proposal_price = $input->post('proposal_price');
			$proposal_qty = $input->post('proposal_qty');
			$sub_total = $proposal_price * $proposal_qty;
			$processing_fee = processing_fee($sub_total);
			$total = $processing_fee + $sub_total;
			$coupon_usage = "expired";
			echo "<script> $('.coupon-response').html('Your coupon code expired.').attr('class', 'coupon-response mt-2 p-2 bg-danger text-white'); </script>";
		}else{
			$proposal_price = $input->post('proposal_price');
			$proposal_qty = $input->post('proposal_qty');
			$sub_total = $proposal_price * $proposal_qty;
			$processing_fee = processing_fee($sub_total);
			$total = $processing_fee + $sub_total;
			$select_used = $db->select("coupons_used",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id,"coupon_price"=>$sub_total));
			$count_used = $select_used->rowCount();
			if($count_used == 1){
				$coupon_usage = "a_used";
			}else{
				$update_coupon = $db->query("update coupons set coupon_used=coupon_used+1 where proposal_id=:p_id and coupon_code=:c_code",array("p_id"=>$proposal_id,"c_code"=>$coupon_code));
				if($coupon_type == "fixed_price"){
					$proposal_price = $input->post('proposal_price');
					$proposal_price = $coupon_price;
				}else{
					$proposal_price = $input->post('proposal_price');
					$numberToAdd = ($proposal_price / 100) * $coupon_price;
					$proposal_price = $proposal_price - $numberToAdd;
				}
				$proposal_qty = $input->post('proposal_qty');
				$sub_total = $proposal_price * $proposal_qty;
				$_SESSION['c_proposal_price'] = $proposal_price;
				$_SESSION["c_sub_total"] = $sub_total;
				$select_used = $db->select("coupons_used",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id,"coupon_price"=>$sub_total));
				$count_used = $select_used->rowCount();
				if($count_used == 0){
					$insert_used = $db->insert("coupons_used",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id,"coupon_used"=>1,"coupon_price"=>$sub_total));
				}
				$processing_fee = processing_fee($sub_total);
				$total = $processing_fee + $sub_total;
				$coupon_usage = "used";
			}
		}
	}else{
		$proposal_price = $input->post('proposal_price');
		$proposal_qty = $input->post('proposal_qty');
		$_SESSION['c_proposal_extras'] = $input->post('proposal_extras');
		if (isset($_POST['add_order'])) {
			$proposal_extras = $_SESSION['c_proposal_extras'];
		}else{
			$proposal_extras = unserialize(base64_decode($input->post('proposal_extras')));
		}
		$sub_total = $proposal_price * $proposal_qty;
		$processing_fee = processing_fee($sub_total);
		$gst = 3;
		$total = $processing_fee + $sub_total + $gst;
		$coupon_usage = "not_valid";
	}
}
?>

	<!-- checkout bar START-->
	<div class="checkout-bar pt-60">
		<div class="container position-relative">
			<div class="border"></div>
			<div class="row no-gutters">
				<div class="col-lg-4 col-4">
					<div class="checkout-bar-area text-center">
						<img src="assets/img/checkout/bar-icon-1.png" alt=""><br>
						<span>1</span>
						<p>Order Details</p>
					</div>
				</div>
				<div class="col-lg-4 col-4">
					<div class="checkout-bar-area text-center">
						<img src="assets/img/checkout/bar-icon-2.png" alt=""><br>
						<span>2</span>
						<p>Review and Pay</p>
					</div>
				</div>
				<div class="col-lg-4 col-4">
					<div class="checkout-bar-area item text-center">
						<img src="assets/img/checkout/bar-icon-3.png" alt=""><br>
						<span>3</span>
						<p>Submit Requirements and Start Order</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- checkout bar END-->
	<!-- checkout payment START-->
	<div class="checkout-payment-area gray-bg">
		<div class="container  pb-45">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="checkout-payment bg-white mt-30">
						<span>Choose your payment method</span>
						<div class="tab-button">
							<ul class="nav nav-pills" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active text-center" id="pills-1-tab" data-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="true"><img src="assets/img/checkout/payment-tab-1.png" alt="">
										<p>Online</p>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-center" id="pills-2-tab" data-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="false"><img src="assets/img/checkout/payment-tab-2.png" alt="">
										<p>Mobile Wallet</p>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-center" id="pills-3-tab" data-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false"><img src="assets/img/checkout/payment-tab-3.png" alt="">
										<p>Cash</p>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-center" id="pills-4-tab" data-toggle="pill" href="#pills-4" role="tab" aria-controls="pills-4" aria-selected="false"><img src="assets/img/checkout/payment-tab-4.png" alt="">
										<p>Local</p>
									</a>
								</li>
							</ul>
						</div>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
								<div class="checkout-payment-area">
									<div class="row">
										<div class="col-lg-5 col-md-4">
											<div class="payment-thumb">
												<img src="assets/img/checkout/payment-box-1.jpg" alt="">
											</div>
										</div>
										<div class="col-lg-7 col-md-8">
											<div class="checkout-payment-content">
												<h5 class="title">How Online Payment Works</h5>
												<p>Pay on eMongez using a credit card, debit card or PayPal account. eMongez accepts any local or international Debit or Credit cards using Master Card and Visa. Please ensure that online transactions have been approved by your bank.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="gigs-payment pt-30">
									<!-- <form action="#"> -->
										<ul class="radio_titme radio_style2">
											<li class="pt-30">
												<!-- <input type="radio" checked="" name="method" id="radio1">
												<label for="radio1"><span></span><img src="assets/img/checkout/card.png" alt="">Credit or debit card</label>
												<div class="row">
													<div class="col-lg-6">
														<div class="input-box mt-10">
															<span>Card Number</span>
															<input type="text">
														</div>
													</div>
													<div class="col-lg-6">
														<div class="input-box mt-10">
															<span>Name on card</span>
															<input type="text">
														</div>
													</div>
													<div class="col-lg-6">
														<div class="input-box mt-30">
															<span>Expiry Date</span>
															<input type="text">
														</div>
													</div>
													<div class="col-lg-6">
														<div class="input-box mt-30">
															<span>Security Code</span>
															<input type="text">
														</div>
													</div>
												</div>
												<div class="input-check-area">
													<input type="checkbox" name="checkbox5" id="checkbox1">
													<label for="checkbox1"><span></span>I accept the <p>terms and conditions</p></label><br>
													<button type="submit">Order</button>
												</div> -->
												<?php if($enable_stripe == "yes"){ ?>
												<input type="radio" name="method" id="credit-card">
												<label for="credit-card" class="d-inline"><span></span><img src="images/credit_cards.jpg" height="50" class="w-25">Stripe</label>
												<?php } ?>
												<?php if($enable_stripe == "yes"){ ?>
													<div class="input-check-area float-right mt-0">
												<?php require_once("stripe_config.php");
												$stripe_total_amount = $total * 100;
												?>
												<form action="requests/stripe_charge" method="post" id="credit-card-form" style="margin-top: -15px;"><!--- credit-card-form Starts --->
												<input
												type="submit"
												class="stripe-submit"
												value="Pay With Credit Card"
												data-key="<?= $stripe['publishable_key']; ?>"
												data-amount="<?= $stripe_total_amount; ?>"
												data-currency="<?= $stripe['currency_code']; ?>"
												data-email="<?= $login_seller_email; ?>"
												data-name="<?= $site_name; ?>"
												data-image="images/<?= $site_logo_image; ?>"
												data-description="<?= $proposal_title; ?>"
												data-allow-remember-me="false">
												<script>
												$(document).ready(function() {
													$('.stripe-submit').on('click', function(event) {
														event.preventDefault();
														var $button = $(this),
														$form = $button.parents('form');
														var opts = $.extend({},$button.data(),{
															token: function(result) {
																$form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
															}
														});
														StripeCheckout.open(opts);
													});
												});
												</script>
												</form>
												</div>
												<?php } ?>
											</li>
											<li class="pt-30">
												<?php if($enable_paypal == "yes"){ ?>
												<input type="radio" name="method" id="paypal">
												<label for="paypal"><span></span><img src="assets/img/checkout/paypal.png" alt="">Paypal</label>
												<?php } ?>
												<?php if($enable_paypal == "yes"){ ?>
												<div class="input-check-area float-right mt-0">
													<form action="requests/paypal_charge" method="post" id="paypal-form" class="float-right" style="margin-top: -17px;"><!--- paypal-form Starts --->
													 <button type="submit" name="paypal" class="btn btn-lg btn-success btn-block">Pay With Paypal</button>
													</form>
												</div>
												<?php } ?>
											</li>
											<li class="pt-30">
												<?php if($current_balance >= $sub_total){ ?>
												<input type="radio" name="method" id="shopping-balance"<?php if($current_balance >= $sub_total){ echo "checked"; }?>>
												<label for="shopping-balance"><span></span><img src="assets/img/checkout/emongez.png" alt="">Emongez Wallet</label>
												<?php } ?>
												<?php if($current_balance >= $sub_total){ ?>
												<div class="input-check-area float-right mt-0">
													<form action="shopping_balance" method="post" id="shopping-balance-form" style="margin-top: -17px;">
													<button class="button" type="submit" name="checkout_submit_order" onclick="return confirm('Are you sure you want to pay for this with your shopping balance?')">
														Emongez Wallet
													</button>
													</form>
												</div>
												<?php } ?>
											</li>
										</ul>
									<!-- </form> -->
								</div>
							</div>
							<div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
								<div class="checkout-payment-area">
									<div class="row">
										<div class="col-lg-5 col-md-4">
											<div class="payment-thumb-2">
												<img src="assets/img/checkout/payment-box.jpg" alt="">
											</div>
										</div>
										<div class="col-lg-7 col-md-8">
											<div class="checkout-payment-content">
												<h5 class="title">How Mobile Wallet Payment Works</h5>
												<p>Pay on eMongez using your Mobile wallet. eMongez accepts all of Egypt’s leading mobile wallet Providers. Make sure that your wallet has the needed funds for the purchase. If you would like to top up your wallet, please contact your Mobile wallet provider. </p>
											</div>
										</div>
									</div>
								</div>
								<div class="gigs-payment pt-30">
									<ul class="radio_titme radio_style2">
										<li>
											<form action="requests/weaccept.php" method="post" id="weaccept-form">
												<div class="row">
													<div class="col-lg-12">
														<div class="input-box mt-30">
															<span>Mobile Number</span>
															<input type="text" name="mobile_number" value="<?= $mobile_number; ?>">
														</div>
													</div>
												</div>
												<div class="input-check-area">
													<input type="checkbox" name="checkbox5" id="checkbox2">
													<label for="checkbox2"><span></span>I accept the <p>terms and conditions</p></label><br>
													<button type="submit" name="weaccept" class="button">Order</button>
												</div>
											</form>
										</li>
									</ul>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
								<div class="checkout-payment-area">
									<div class="row">
										<div class="col-lg-5 col-md-4">
											<div class="payment-thumb-2">
												<img src="assets/img/checkout/payment-box--2.jpg" alt="">
											</div>
										</div>
										<div class="col-lg-7 col-md-8">
											<div class="checkout-payment-content">
												<h5 class="title">How Cash Payment Works</h5>
												<p>Select Cash Collection from eMongez Our Partner R2S Egypt’s leading courier will contact you to arrange Cash Collection. Please ensure that your address is entered correctly to ensure next day Cash Collection.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="gigs-payment pt-30">
									<!-- <form action="#"> -->
										<ul class="radio_titme radio_style2">
											<li>
												<form id="cash_info" class="clearfix">
													<div class="row">
														<div class="col-lg-12">
															<div class="input-box mt-30">
																<span>Mobile Number</span>
																<input type="text" name="mobile_number" id="mobile_number" value="<?= $mobile_number; ?>">
															</div>
														</div>
														<div class="col-lg-12">
															<div class="input-box mt-30">
																<span>Address</span>
																<input type="text" name="address" id="address" value="<?= $address; ?>">
															</div>
														</div>
														<div class="col-lg-6">
															<div class="input-box mt-30">
																<span>Apartment Number</span>
																<input type="text" name="apartment_number" id="apartment_number" value="<?= $apartment_number; ?>">
															</div>
														</div>
														<div class="col-lg-6">
															<div class="input-box mt-30">
																<span>Floor Number</span>
																<input type="text" name="floor_number" id="floor_number" value="<?= $floor_number; ?>">
															</div>
														</div>
														<div class="col-lg-12">
															<div class="input-box mt-30 state_box">
																<span>Country</span>
							 									<select class="form-control wide" name="country" onChange="getState(this.value);" id="country">
							 										<option>Select Country</option>
							 										<?php
                                    $get_countries = $db->select("countries", array('name'=> 'Egypt'));
                                    while($row_countries = $get_countries->fetch()){
                                      $id = $row_countries->id;
                                      $name = $row_countries->name;
                                      echo "<option value='$name'".($name == $country ? "selected" : "").">$name</option>";
                                    }
                                    ?>
							 									</select>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="input-box mt-30 state_box">
																<span>state</span>
																<select class="form-control wide" name="state" onChange="getCity(this.value);" id="state-list">
																	<?php if(!empty($state)){ ?>
																		<option selected><?= $state; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="input-box mt-30 state_box">
																<span>city</span>
																<select class="form-control wide" name="city" required="" id="city-list">
																	<?php if(!empty($city)){ ?>
																		<option selected><?= $city; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="input-check-area">
														<input type="checkbox" name="checkbox5" id="terms">
														<label for="terms"><span></span>I accept the <p>terms and conditions</p>&nbsp;<small>(Please accept the terms and condition to proceed)</small></label><br>
														<!-- <button type="submit">Order</button> -->
														<button type="submit" name="submit_cash_info" id="edit_info" class="float-right" disabled>Edit Cash Info</button>
													</div>
												</form>
												<?php 
													
												?>
												<form action="requests/weaccept_cash.php" method="post" id="weaccept-cash-form"><!--- paypal-form Starts --->
												<button type="submit" name="weaccept_cash" class="order-button">Order</button>
												</form>
											</li>
											
										</ul>
									<!-- </form> -->
								</div>
							</div>
							<div class="tab-pane fade" id="pills-4" role="tabpanel" aria-labelledby="pills-4-tab">
								<div class="checkout-payment-area">
									<div class="row">
										<div class="col-lg-5 col-md-4">
											<div class="payment-thumb-2">
												<img src="assets/img/checkout/payment-box--3.jpg" alt="">
											</div>
										</div>
										<div class="col-lg-7 col-md-8">
											<div class="checkout-payment-content">
												<h5 class="title">How Local Payment Works</h5>
												<p>Pay on eMongez through the largest network of cash points. Enjoy the convenience of paying at your preferred time and location across Egypt. You can check your nearest cash point by visiting the providers website</p>
											</div>
										</div>
									</div>
								</div>
								<div class="gigs-payment pt-30">
									<ul class="radio_titme radio_style2">
										<li>
											<form action="requests/weaccept_kiosk.php" method="post" id="weaccept-kiosk">
												<div class="row">
													<div class="col-lg-12">
														<div class="input-box mt-30">
															<span>Mobile Number</span>
															<input type="text" name="local_mobile_number" value="<?= $local_mobile_number ?>">
														</div>
													</div>
													<div class="col-lg-12">
														<div class="input-box mt-30">
															<span>Email Address</span>
															<input type="email" name="local_email" value="<?= $local_email; ?>">
														</div>
													</div>
												</div>
												<div class="input-check-area">
													<input type="checkbox" name="checkbox5" id="checkbox4">
													<label for="checkbox4"><span></span>I accept the <p>terms and conditions</p></label><br>
													<button type="submit" name="weaccept_valu">Order</button>
												</div>
											</form>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="checkout-summary mt-30">
						<div class="summary-header">
							Summary
						</div>
						<div class="cummary-body">
							<div class="summary-card d-flex flex-row align-items-start">
								<div class="image">
									<img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" alt="">
								</div>
								<div class="text">
									<p><?= $proposal_description; ?></p>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<h4>All the items included in package</h4>
								<ul class="list-inline d-flex flex-wrap">
									<!-- <li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>Commercial Use</span>
									</li>
									<li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>300 Words Included</span>
									</li> -->
									<li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span><?= $proposal_revision; ?> Revisions</span>
									</li>
									<!-- <li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>Source File</span>
									</li>
									<li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>Topic Research</span>
									</li> -->
								</ul>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<div class="processing-fee d-flex flex-row justify-content-between">
									<span>Processing Fee</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $processing_fee;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $processing_fee,2);}else{  echo $s_currency.' '; echo $processing_fee; } ?></span>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<div class="processing-fee d-flex flex-row justify-content-between">
									<span>GST</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $gst;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $gst,2);}else{  echo $s_currency.' '; echo $gst; } ?></span>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card d-flex flex-column">
								<div class="totoal-fee d-flex flex-row justify-content-between">
									<span>Total</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $total;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $total,2);}else{  echo $s_currency.' '; echo $total; } ?></span>
								</div>
								<div class="delivery-time d-flex flex-row justify-content-between">
									<span>Total Delivery Time</span>
									<span><?= $proposal_delivery_time; ?> Days</span>
								</div>
							</div>
							<!-- Each item -->
						</div>
					</div>
					<!-- Checkout summary -->
				</div>
			</div>
		</div>
	</div>
	<!-- checkout payment END-->




<!-- <div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-7">
			<div class="row">
      	<?php if($current_balance >= $sub_total){ ?>
				<div class="col-md-12 mb-3">
					<div class="card payment-options">
						<div class="card-header">
							<h5><i class="fa fa-dollar"></i> Available Shopping Balance</h5>
						</div>
						<div class="card-body">
						<div class="row">
						<div class="col-1">
						<input id="shopping-balance" type="radio" name="method" class="form-control radio-input" checked>
						</div>
						<div class="col-11">
							<p class="lead mt-2">
							Personal Balance - <?= $login_seller_user_name; ?>
							<span class="text-success font-weight-bold"><?= $s_currency; ?><?= $current_balance; ?></span>
							</p>
						</div>
					</div>
					</div>
					</div>
				</div>
        <?php } ?>
				<div class="col-md-12 mb-3">
					<div class="card payment-options">
						<div class="card-header">
						<h5><i class="fa fa-credit-card"></i> Payment Options</h5>
						</div>
						<div class="card-body">
							<?php if($enable_paypal == "yes"){ ?>
							<div class="row">
							<div class="col-1">
							<input id="paypal" type="radio" name="method" class="form-control radio-input" 
							<?php
							if($current_balance < $sub_total){ echo "checked"; }
							?>>
							</div>
							<div class="col-11">
							<img src="images/paypal.png" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_stripe == "yes"){ ?>
							<?php if($enable_paypal == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="credit-card" type="radio" name="method" class="form-control radio-input"
							<?php
							  if($current_balance < $sub_total){
							  if($enable_paypal == "no"){ echo "checked"; }
							  }
							?>>
							</div>
							<div class="col-11">
							<img src="images/credit_cards.jpg" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>

							<?php 
							if($enable_2checkout == "yes"){ 
								require_once("plugins/paymentGateway/paymentMethod1.php");
							} 
							?>

							<?php if($enable_payza == "yes"){ ?>
							<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="payza" type="radio" name="method" class="form-control radio-input"
							<?php
							if($current_balance < $sub_total){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "yes"){ 
							echo "checked";
							}
							}
							?>>
							</div>
							<div class="col-11">
							<img src="images/payza.jpg" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>

							<?php if($enable_coinpayments == "yes"){ ?>
							<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_payza == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="coinpayments" type="radio" name="method" class="form-control radio-input"
							<?php
							if($current_balance < $sub_total){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no"){ 
							echo "checked";
							}
							}
							?>>
							</div>
							<div class="col-11">
							<img src="images/coinpayments.png" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>

							<?php if($enable_paystack == "yes"){ ?>
							<?php if($enable_payza == "yes" or $enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_coinpayments == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="paystack" type="radio" name="method" class="form-control radio-input"
							<?php
							if($current_balance < $sub_total){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "no"){ 
							echo "checked";
							}
							}
							?>>
							</div>
							<div class="col-11">
							<img src="images/paystack.png" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_dusupay == "yes"){ ?>
							<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_payza == "yes" or $enable_paystack == "yes" or $enable_coinpayments == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
								<div class="col-1">
									<input id="mobile-money" type="radio" name="method" class="form-control radio-input"
									<?php
									if($current_balance < $sub_total){
									if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "no"){ 
										echo "checked"; 
									}
									}
									?>>
								</div>
								<div class="col-11">
									<img src="images/mobile-money.png" height="50" class="ml-2 width-xs-100">
								</div>
							</div>
            <?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card checkout-details">
				<div class="card-header">
					<h5> <i class="fa fa-file-text-o"></i> Order Summary </h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-3">
						<img src="proposals/proposal_files/<?= $proposal_img1; ?>" class="img-fluid">
						</div>
						<div class="col-md-8">
						<h5><?= $proposal_title; ?></h5>
						</div>
					</div>
					<hr>
					<h6>Proposal's Price: <span class="float-right"><?= $s_currency; ?><?= $single_price; ?> </span></h6>

					<?php if(isset($_POST['proposal_extras'])){ ?>
					<hr>
					<h6>Proposal's Extras : <span class="float-right"><?= $s_currency; ?><?= $extra_price; ?></span> </h6>
					<?php } ?>

					<hr>
					<h6>Proposal's Quantity: <span class="float-right"><?= $proposal_qty; ?></span></h6>
					<?php if(isset($_SESSION['c_proposal_minutes'])){ ?>
					<hr>
					<h6>Proposal's Video Call Minutes: <span class="float-right"><?= $_SESSION['c_proposal_minutes']; ?> Minutes</span></h6>
					<?php } ?>
					<hr class="processing-fee">
					<h6 class="processing-fee">Processing Fee: <span class="float-right"><?= $s_currency; ?><?= $processing_fee; ?></span></h6>

					<?php if(isset($numberToAdd) and $coupon_usage == "used"){ ?>
					<hr>
					<h6>Coupon Discount : <span class="float-right"><?= $s_currency; ?><?= $numberToAdd; ?></span> </h6>
					<?php } ?>

					<hr>
					<h6>Appy Coupon Code:</h6>
					<form class="input-group" method="post">
						<input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
					  	<input type="hidden" name="proposal_price" value="<?= $proposal_price; ?>">
						<input type="hidden" name="proposal_qty" value="<?= $proposal_qty; ?>">
						<?php if(isset($_POST['package_id'])){ ?>
						<input type="hidden" name="package_id" value="<?= $input->post('package_id');?>">
						<?php } ?>
						<?php if(isset($_POST['proposal_extras'])){ ?>
						<input type="hidden" name="proposal_extras" value="<?= base64_encode(serialize($proposal_extras));?>">
						<?php } ?>
						<input type="text" name="code" class="form-control apply-disabled" placeholder="Enter Coupon Code">
						<button type="submit" name="coupon_submit" class="input-group-addon btn btn-success">Apply</button>
					</form>
         			
         	<?php if($coupon_usage == "not_valid"){ ?>
					<p class="coupon-response mt-2 p-2 bg-danger text-white"> Your Coupon Code Is Not Valid. </p>
          <?php }elseif($coupon_usage == "used"){ ?>
					<p class="coupon-response mt-2 p-2 bg-success text-white">Your coupon code has been applied successfully.</p>
					<?php }elseif($coupon_usage == "expired"){ ?>
					<p class="coupon-response mt-2 p-2 bg-danger text-white"> Your Coupon Code Is Expired. </p>
					<?php }elseif($coupon_usage == "a_used"){ ?>
					<p class="coupon-response mt-2 p-2 bg-success text-white"> Your Coupon Code Is Already Used. </p>
					<?php } ?>
					<hr>
					<h5 class="font-weight-bold">
					Proposal's Total: <span class="float-right total-price"><?= $s_currency; ?><?= $total; ?></span>
					</h5>
					<hr>
			    <?php //include("checkoutPayMethods.php"); ?>          
				</div>
				<?php if($proposal_id == @$_SESSION['r_proposal_id']){ ?>
				<div class="card-footer">Referred By : <b><?= $referrer_user_name; ?></b></div>
				<?php } ?>
			</div>
		</div>
	</div>
</div> -->
<script>
$(document).ready(function(){	
	$('#paypal-form').hide();
<?php if($current_balance >= $sub_total){ ?>	
$('.total-price').html('<?= $s_currency; ?><?= $sub_total; ?>');
$('.processing-fee').hide();
<?php }else{ ?>
$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
$('.processing-fee').show();
<?php } ?>
<?php if($current_balance >= $sub_total){ ?>
	$('#paypal-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#coinpayments-form').hide();
$('#paypal-form').hide();
$('#paystack-form').hide();
$('#credit-card-form').hide();
$('#2checkout-form').hide();
$('#weaccept-form').show();
$('#weaccept-cash').hide();
$('#weaccept-valu').hide();
$('#weaccept-kiosk').show();
<?php }else{ ?>
$('#shopping-balance-form').hide();
<?php } ?>	
<?php if($current_balance < $sub_total){ ?>
<?php if($enable_paypal == "yes"){ ?>
<?php }else{ ?>
$('#paypal-form').hide();
<?php } ?>
<?php } ?>

<?php if($current_balance < $sub_total){ ?>
<?php if($enable_paypal == "yes"){ ?>
$('#credit-card-form').hide();
$('#2checkout-form').hide();
$('#mobile-money-form').hide();
$('#payza-form').hide();
$('#coinpayments-form').hide();
$('#paystack-form').hide();
$('#weaccept-form').show();
$('#weaccept-cash').hide();
$('#weaccept-valu').hide();
$('#weaccept-kiosk').show();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "yes"){ ?>
$('#2checkout-form').hide();
$('#coinpayments-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "yes") { ?>
$('#coinpayments-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "yes") { ?>
$('#coinpayments-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "yes") { ?>
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "yes") { ?>
$('#mobile-money-form').hide();
<?php } ?>
<?php } ?>

$('#shopping-balance').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $sub_total; ?>');
	$('.processing-fee').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').show();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#paypal').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').show();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#credit-card').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').show();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#2checkout').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#mobile-money').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').show();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#coinpayments').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#2checkout-form').hide();
	$('#payza-form').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').show();
	$('#paystack-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#paystack').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#payza').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#weacceptWallet').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#weacceptCash').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').show();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
$('#weacceptValU').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').show();
	$('#weaccept-kiosk').show();
});
$('#weacceptKiosk').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
});
$(document).on("click","#terms",function(){
    if($(this).prop("checked") == true){
    	$('#edit_info').prop('disabled', false);
    }
    else if($(this).prop("checked") == false){
    	$('#edit_info').prop('disabled', true);
    }
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
$('#cash_info').submit(function(e){

	e.preventDefault();
	var mobile_number =$('#mobile_number').val();
	var address =$('#address').val();
	var apartment_number =$('#apartment_number').val();
	var floor_number =$('#floor_number').val();
	var country =$('#country').val();
	var state =$('#state-list').val();
	var city =$('#city-list').val();
		var obj = [mobile_number, address, apartment_number,floor_number,country,state,city ];
	var myJSON = obj;
	$.ajax({
		url : 'edit_cash_info.php?data='+myJSON,
		type : 'get',
	
 	}).done(function(data){

        $('#wait').removeClass("loader");
        if(data == "error"){
          swal({type: 'warning',text: 'You Must Need To Fill Out All Fields Before Updating The Details.'});

        }else{
          swal({type: 'success',text: 'Changes Saved.'});
        }

      });
});
</script>
<?php } ?>
<?php require_once("includes/footer.php"); ?>
</body>
</html>
<?php
}}elseif(isset($_POST['add_cart'])){

	$proposal_id = $input->post('proposal_id');	
	if(isset($_POST['proposal_minutes'])){
		$proposal_qty = $input->post('proposal_minutes');	
		$video = 1;
	}else{
		$proposal_qty = $input->post('proposal_qty');
		$video = 0;	
	}
	$select_proposal = $db->select("proposals",array("proposal_id"=>$proposal_id));
	$row_proposal = $select_proposal->fetch();
	$proposal_price = $row_proposal->proposal_price;

	if(isset($_POST['package_id'])){
		$get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_id"=>$input->post('package_id')));
		$proposal_price = $get_p_1->fetch()->price;
	}else{
		$proposal_price = $row_proposal->proposal_price;
	}
	$proposal_url = $row_proposal->proposal_url;
	$proposal_seller_id = $row_proposal->proposal_seller_id;
	$select_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));
	$row_seller = $select_seller->fetch();
	$seller_user_name = $row_seller->seller_user_name;
	$count_cart = $db->count("cart",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id));
	if($count_cart == 1){
		echo "<script>
		alert('This proposal/service is already in your cart.');
		window.open('proposals/$seller_user_name/$proposal_url','_self');
		</script>";
	}else{
		if(isset($_POST['proposal_extras'])){
			$proposal_extras = $input->post('proposal_extras');
			foreach($proposal_extras as $value){
				$get_extras = $db->select("proposals_extras",array("id"=>$value));
				$row_extras = $get_extras->fetch();
				$name = $row_extras->name;
				$price = $row_extras->price;
				$insert_extra = $db->insert("cart_extras",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id,"name"=>$name,"price"=>$price));
			}
		}
		$insert_cart = $db->insert("cart",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id,"proposal_price"=>$proposal_price,"proposal_qty"=>$proposal_qty,"video"=>$video));
		echo "<script>window.open('proposals/$seller_user_name/$proposal_url','_self');</script>";
	}
}