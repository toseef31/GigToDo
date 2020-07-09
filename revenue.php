<?php
session_start();
require_once("includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_level = $row_login_seller->seller_level;
$login_seller_paypal_email = $row_login_seller->seller_paypal_email;
$login_seller_payoneer_email = $row_login_seller->seller_payoneer_email;
$login_seller_account_number = $row_login_seller->seller_m_account_number;
$login_seller_account_name = $row_login_seller->seller_m_account_name;
$login_seller_wallet = $row_login_seller->seller_wallet;
$seller_payouts = $row_login_seller->seller_payouts;
$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$withdrawal_limit = $row_payment_settings->withdrawal_limit;
$enable_paypal = $row_payment_settings->enable_paypal;
$enable_stripe = $row_payment_settings->enable_stripe;
$enable_dusupay = $row_payment_settings->enable_dusupay;
$enable_coinpayments = $row_payment_settings->enable_coinpayments;
$enable_paystack = $row_payment_settings->enable_paystack;
$enable_payoneer = $row_payment_settings->enable_payoneer;
$wish_do_manual_payouts = $row_general_settings->wish_do_manual_payouts;
if($paymentGateway == 1){
$enable_bank_transfer = $row_payment_settings->enable_bank_transfer;
$enable_moneygram = $row_payment_settings->enable_moneygram;
}else{
$enable_bank_transfer = "no";
$enable_moneygram = "no";
}
$select = $db->select("seller_payment_settings",["level_id"=>$login_seller_level]);;
$row = $select->fetch();
$payout_day = $row->payout_day;
$payout_time = $row->payout_time;
$payout_anyday = $row->payout_anyday;
$payout_date = date("F $payout_day, Y")." $payout_time";
$payout_date = new DateTime($payout_date);
$count_payout = 0;
$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;
$used_purchases = $row_seller_accounts->used_purchases;
$pending_clearance = $row_seller_accounts->pending_clearance;
$withdrawn = $row_seller_accounts->withdrawn;
if($current_balance < $withdrawal_limit AND empty($payout_anyday) & $seller_payouts == 0){
$withdrawLimitText = <<<EOT
onclick="return alert('You must have a minimum of at least $s_currency$withdrawal_limit to withdraw.');"
EOT;
}else{
$withdrawLimitText = "";
}
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
	<head>
		<title><?= $site_name; ?> - Revenue Earned</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?= $site_desc; ?>">
		<meta name="keywords" content="<?= $site_keywords; ?>">
		<meta name="author" content="<?= $site_author; ?>">
		<!--====== Favicon Icon ======-->
		<?php if(!empty($site_favicon)){ ?>
		<link rel="shortcut icon" href="<?= $site_url; ?>/images/<?php echo $site_favicon; ?>" type="image/x-icon">
		<?php } ?>
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
		<!-- <link href="styles/custom.css" rel="stylesheet">  -->
		<!-- Custom css code from modified in admin panel --->
		<link href="styles/styles.css" rel="stylesheet">
		<link href="styles/user_nav_styles.css" rel="stylesheet">
		<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		
	</head>
	<body class="all-content">
		<!-- Preloader Start -->
		<div class="proloader">
			<div class="loader">
				<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
			</div>
		</div>
		<!-- Preloader End -->
		<?php require_once("includes/user_header.php"); ?>

		<main>
			<div class="purchases-box">
				<!-- Purchases-area -->
				<div class="purchases-area">
					<?php if($current_balance != 0 And empty($payout_anyday) And $seller_payouts == 0 And date("d") <= $payout_day){ ?>
					<div class="alert alert-success mt-2 text-center h6"> <!-- Alert starts -->
					<i class="fa fa-exclamation-circle"></i> <?php printf($lang["availRevenue"],$s_currency.$current_balance,$payout_date->format("F d, Y H:i A")); ?>
					</div> <!-- Alert ends -->
					<?php }else if($seller_payouts > 0 And empty($payout_anyday)){ ?>
					<div class="alert alert-success mt-2 text-center h6"> <!-- Alert starts -->
					<i class="fa fa-exclamation-circle"></i>
					You will be able to withdraw or send next payout request of (<?php if ($to == 'EGP'){ echo $to.' '; echo $current_balance;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $current_balance,2);}else{  echo $s_currency.' '; echo $current_balance; } ?>) on the 
					<?php
					$interval = new DateInterval('P1M');
					$payout_date->add($interval);
					echo $payout_date->format("F d, Y H:i A");
					?>
					</div> <!-- Alert ends -->
					<?php } ?>
					<div class="container">
						<div class="row">
							<div class="col-12 col-md-6 d-flex flex-row justify-content-start align-items-start">
							  <div class="purchases-title">
							  	Revenue
							  </div>
							</div>
							<div class="col-12 col-md-6 align-items-end justify-content-end d-flex flex-row">
							  <div class="purchases-title" style="font-size: 32px;">
							  	Available For Withdrawal: <span class="font-weight-bold" style=" color: #FF0000;"> 	<?php if ($to == 'EGP'){ echo $to.' '; echo $current_balance;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $current_balance,2);}else{  echo $s_currency.' '; echo $current_balance; } ?></span>
								</div>
							</div>
							<!-- <div class="col-lg-6">
								<div class="purchases-title">
									Revenue
								</div>
							</div>
							<div class="col-lg-6">
								<div class="purchases-title">
									Revenue
								</div>
							</div> -->
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="purchases-item-box">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-6">
											<div class="purchases-blance-item">
												<div class="purchases-blance-table">
													<div class="purchases-icon">
														<img src="assets/img/img/icon5.png" alt="">
													</div>
													<div class="purchases-text">
														<h4>Total earned <span><?php if ($to == 'EGP'){ echo $to.' '; echo $used_purchases;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $used_purchases,2);}else{  echo $s_currency.' '; echo $used_purchases; } ?></span></h4>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-6">
											<div class="purchases-blance-item">
												<div class="purchases-blance-table">
													<div class="purchases-icon">
														<img src="assets/img/img/icon6.png" alt="">
													</div>
													<div class="purchases-text">
														<h4>Total withdrawn <span><?php if ($to == 'EGP'){ echo $to.' '; echo $withdrawn;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $withdrawn,2);}else{  echo $s_currency.' '; echo $withdrawn; } ?></span></h4>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-6">
											<div class="purchases-blance-item">
												<div class="purchases-blance-table">
													<div class="purchases-icon">
														<img src="assets/img/img/icon7.png" alt="">
													</div>
													<div class="purchases-text">
														<h4>pending for clearance <span><?php if ($to == 'EGP'){ echo $to.' '; echo $pending_clearance;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $pending_clearance,2);}else{  echo $s_currency.' '; echo $pending_clearance; } ?></span></h4>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-6">
											<div class="purchases-blance-item">
												<div class="purchases-blance-table">
													<div class="purchases-icon">
														<img src="assets/img/img/icon4.png" alt="">
													</div>
													<div class="purchases-text">
														<h4>available funds <span><?php if ($to == 'EGP'){ echo $to.' '; echo $current_balance;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $current_balance,2);}else{  echo $s_currency.' '; echo $current_balance; } ?></span></h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Purchases-area  END-->
				<div class="purchease-filer">
					<div class="container">
						<div class="row">
							<div class="col-12 col-md-6 col-lg-9 d-flex flex-row justify-content-start align-items-start">
								<!-- <div class="show-text">
									Show
								</div> -->
								<div class="d-flex flex-wrap align-items-start">
									<!-- <div class="show-filer">
										<select name="" id="">
											<option value="">select year</option>
											<option value="">select year</option>
											<option value="">select year</option>
											<option value="">select year</option>
										</select>
									</div>
									<div class="show-filer">
										<select name="" id="">
											<option value="">select month</option>
											<option value="">select month</option>
											<option value="">select month</option>
											<option value="">select month</option>
										</select>
									</div> -->
									<!-- <a class="withdraw-btn" href="javascript:void(0);">Withdraw</a> -->
									<?php if(($current_balance >= $withdrawal_limit AND !empty($payout_anyday)) OR ($current_balance >= $withdrawal_limit AND empty($payout_anyday) AND $seller_payouts == 0 & date("d") >= $payout_day)){ ?>

									<label class="lead pull-left withdraw-btn"> Withdraw To: </label>
									<?php if($enable_paypal == "yes"){ ?>
									<button class="btn btn-success ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#paypal_withdraw_modal">
										<i class="fa fa-paypal"></i> Paypal Account
									</button>
									<?php } ?>
									<?php if($wish_do_manual_payouts == 1 & $enable_payoneer == 1) { ?>
									<button class="btn btn-success ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#payoneer_withdraw_modal">
										<i class="fa fa-paper-plane-o"></i> Payoneer Account
									</button>
									<?php } ?>
									<?php if($wish_do_manual_payouts == 1 & $enable_bank_transfer == "yes"){ ?>
									<button class="btn btn-success ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#bank_account_modal">
										<i class="fa fa-university"></i> Bank Account
									</button>
									<?php } ?>
									<?php if($wish_do_manual_payouts == 1 & $enable_moneygram == "yes"){ ?>
									<button class="btn btn-success ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#moneygram_modal">
										<i class="fa fa-credit-card"></i> Moneygram
									</button>
									<?php } ?>
									<?php if($enable_dusupay == "yes"){ ?>
									<button class="btn btn-success ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#mobile_money_modal">
										<i class="fa fa-mobile"></i> Mobile Money 
									</button>
									<?php } ?>
									<?php if($enable_coinpayments == "yes"){ ?>
									<button class="btn btn-success ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#trx_wallet_modal">
										<i class="fa fa-bitcoin"></i> Bitcoin Wallet 
									</button>
									<?php } ?>

									<?php }else{ ?>

										<label class="lead pull-left withdraw-btn"> Withdraw To: </label>
										<?php if($enable_paypal == "yes"){ ?>
										<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#paypal_withdraw_modal">
											<i class="fa fa-paypal"></i> Paypal Account
										</button>
										<?php } ?>
										<?php if($wish_do_manual_payouts == 1 & $enable_payoneer == 1) { ?>
										<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#payoneer_withdraw_modal">
											<i class="fa fa-paper-plane-o"></i> Payoneer Account
										</button>
										<?php } ?>
										<?php if($wish_do_manual_payouts == 1 & $enable_bank_transfer == "yes"){ ?>
										<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#bank_account_modal">
											<i class="fa fa-university"></i> Bank Account
										</button>
										<?php } ?>
										<?php if($wish_do_manual_payouts == 1 & $enable_moneygram == "yes"){ ?>
										<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#moneygram_modal">
											<i class="fa fa-credit-card"></i> Moneygram
										</button>
										<?php } ?>
										<?php if($enable_dusupay == "yes"){ ?>
										<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#mobile_money_modal">
											<i class="fa fa-mobile"></i> Mobile Money 
										</button>
										<?php } ?>
										<?php if($enable_coinpayments == "yes"){ ?>
										<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" data-toggle="modal" data-target="#trx_wallet_modal">
											<i class="fa fa-bitcoin"></i> Bitcoin Wallet 
										</button>
										<?php } ?>

									<!-- <label class="lead pull-left withdraw-btn"> Withdraw To: </label>
									<?php if($enable_paypal == "yes"){ ?>
									<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" <?= $withdrawLimitText; ?>>
									<i class="fa fa-paypal"></i> Paypal Account
									</button>
									<?php } ?>
									<?php if($wish_do_manual_payouts == 1 & $enable_payoneer == 1) { ?>
									<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" <?= $withdrawLimitText; ?>>
									<i class="fa fa-paypal"></i> Payoneer Account
									</button>
									<?php } ?>
									
									<?php if($wish_do_manual_payouts == 1 & $enable_bank_transfer == "yes"){ ?>
									<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" <?= $withdrawLimitText; ?>>
										<i class="fa fa-university"></i> Bank Account
									</button>
									<?php } ?>

									<?php if($wish_do_manual_payouts == 1 & $enable_moneygram == "yes"){ ?>
									<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" <?= $withdrawLimitText; ?>>
										<i class="fa fa-credit-card"></i> Moneygram
									</button>
									<?php } ?>

									<?php if($enable_dusupay == "yes"){ ?>
									<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" <?= $withdrawLimitText; ?>>
										<i class="fa fa-mobile"></i> Mobile Money 
									</button>
									<?php } ?>
									<?php if($enable_coinpayments == "yes"){ ?>
									<button class="btn btn-default ml-2 py-2" style="color: #ff0707;" <?= $withdrawLimitText; ?>>
										<i class="fa fa-bitcoin"></i> Bitcoin Wallet 
									</button>
									<?php } ?> -->

									<?php } ?>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<!-- <div class="pagination-bar">
									<ul>
										<li><a href="javascript:void(0);"><i class="fas fa-caret-left"></i></a></li>
										<li><a href="javascript:void(0);">1</a></li>
										<li>Of <span>1</span></li>
										<li><a href="javascript:void(0);"><i class="fas fa-caret-right"></i></a></li>
									</ul>
								</div> -->
							</div>
						</div>
					</div>
				</div>
				<!-- Purchase-table-area -->
				<div class="purchases-table-area">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<table class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th scope="col">Date</th>
												<th scope="col">Title</th>
												<th scope="col" style="text-align: right;">Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$get_revenues = $db->select("revenues",array("seller_id"=>$login_seller_id),"DESC");
												while($row_revenues = $get_revenues->fetch()){
												$revenue_id = $row_revenues->revenue_id;
												$order_id = $row_revenues->order_id;
												$amount = $row_revenues->amount;
												$date = $row_revenues->date;
												$status = $row_revenues->status;
											?>
											<tr>
												<th scope="row"><?= $date; ?></th>
												<td>
													<?php if($status == "pending"){ ?>
													Order Revenue Pending Clearance (<a href="order_details?order_id=<?= $order_id; ?>" target="blank" style="color: #FF0000;"> View Order </a>)
													<?php }else{ ?>                             
													Order Revenue (<a href="order_details?order_id=<?= $order_id; ?>" target="blank" style="color: #FF0000;"> View Order </a>)
													<?php } ?>
												</td>
												<td style="text-align: right; color: #FF0000;">+<?php if ($to == 'EGP'){ echo $to.' '; echo $amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $amount,2);}else{  echo $s_currency.' '; echo $amount; } ?>.00</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- Purchase-table-area END -->
			</div>
		</main>

		<!-- <div class="container mt-5 mb-3">
			<div class="row">
				<div class="col-md-12">
					<h2 class="pull-left"><?= $lang["titles"]["revenue"]; ?></h2>
					<p class="lead pull-right">
						Available For Withdrawal: <span class="font-weight-bold text-success"> <?= $s_currency; ?><?= $current_balance; ?> </span>
					</p>
				</div>
				<div class="col-md-12">
					<?php if($current_balance != 0 And empty($payout_anyday) And $seller_payouts == 0 And date("d") <= $payout_day){ ?>
					<div class="alert alert-success mt-2 text-center h6"> 
					<i class="fa fa-exclamation-circle"></i> <?php printf($lang["availRevenue"],$s_currency.$current_balance,$payout_date->format("F d, Y H:i A")); ?>
					</div> 
					<?php }else if($seller_payouts > 0 And empty($payout_anyday)){ ?>
					<div class="alert alert-success mt-2 text-center h6">
					<i class="fa fa-exclamation-circle"></i>
					You will be able to withdraw or send next payout request of (<?= $s_currency.$current_balance; ?>) on the
					<?php
					$interval = new DateInterval('P1M');
					$payout_date->add($interval);
					echo $payout_date->format("F d, Y H:i A");
					?>
					</div> 
					<?php } ?>
					<div class="card mb-3 rounded-0">
						<div class="card-body">
							<div class="row">
								<div class="col-md-3 text-center border-box">
									<p> Withdrawals </p>
									<h2> <?= $s_currency; ?><?= $withdrawn; ?> </h2>
								</div>
								<div class="col-md-3 text-center border-box">
									<p> Used To Order Proposals/Services </p>
									<h2> <?= $s_currency; ?><?= $used_purchases; ?> </h2>
								</div>
								<div class="col-md-3 text-center border-box">
									<p> Pending Clearance </p>
									<h2> <?= $s_currency; ?><?= $pending_clearance; ?> </h2>
								</div>
								<div class="col-md-3 text-center border-box">
									<p> Available Income </p>
									<h2> <?= $s_currency; ?><?= $current_balance; ?>  </h2>
								</div>
							</div>
						</div>
					</div>
					<?php if(($current_balance >= $withdrawal_limit AND !empty($payout_anyday)) OR ($current_balance >= $withdrawal_limit AND empty($payout_anyday) AND $seller_payouts == 0 & date("d") >= $payout_day)){ ?>
					<label class="lead pull-left mt-1"> Withdraw To: </label>
					<?php if($enable_paypal == "yes"){ ?>
					<button class="btn btn-success ml-2" data-toggle="modal" data-target="#paypal_withdraw_modal">
					<i class="fa fa-paypal"></i> Paypal Account
					</button>
					<?php } ?>
					<?php if($wish_do_manual_payouts == 1 & $enable_payoneer == 1) { ?>
					<button class="btn btn-success ml-2" data-toggle="modal" data-target="#payoneer_withdraw_modal">
					<i class="fa fa-paper-plane-o"></i> Payoneer Account
					</button>
					<?php } ?>
					<?php if($wish_do_manual_payouts == 1 & $enable_bank_transfer == "yes"){ ?>
					<button class="btn btn-success ml-2" data-toggle="modal" data-target="#bank_account_modal">
					<i class="fa fa-university"></i> Bank Account
					</button>
					<?php } ?>
					<?php if($wish_do_manual_payouts == 1 & $enable_moneygram == "yes"){ ?>
					<button class="btn btn-success ml-2" data-toggle="modal" data-target="#moneygram_modal">
					<i class="fa fa-credit-card"></i> Moneygram
					</button>
					<?php } ?>
					<?php if($enable_dusupay == "yes"){ ?>
					<button class="btn btn-success ml-2" data-toggle="modal" data-target="#mobile_money_modal">
					<i class="fa fa-mobile"></i> Mobile Money
					</button>
					<?php } ?>
					<?php if($enable_coinpayments == "yes"){ ?>
					<button class="btn btn-success ml-2" data-toggle="modal" data-target="#trx_wallet_modal">
					<i class="fa fa-bitcoin"></i> Bitcoin Wallet
					</button>
					<?php } ?>
					<?php }else{ ?>
					<label class="lead pull-left mt-1"> Withdraw To: </label>
					<?php if($enable_paypal == "yes"){ ?>
					<button class="btn btn-default ml-2" <?= $withdrawLimitText; ?>>
					<i class="fa fa-paypal"></i> Paypal Account
					</button>
					<?php } ?>
					<?php if($wish_do_manual_payouts == 1 & $enable_payoneer == 1) { ?>
					<button class="btn btn-default ml-2" <?= $withdrawLimitText; ?>>
					<i class="fa fa-paypal"></i> Payoneer Account
					</button>
					<?php } ?>
					
					<?php if($wish_do_manual_payouts == 1 & $enable_bank_transfer == "yes"){ ?>
					<button class="btn btn-default ml-2" <?= $withdrawLimitText; ?>>
					<i class="fa fa-university"></i> Bank Account
					</button>
					<?php } ?>
					<?php if($wish_do_manual_payouts == 1 & $enable_moneygram == "yes"){ ?>
					<button class="btn btn-default ml-2" <?= $withdrawLimitText; ?>>
					<i class="fa fa-credit-card"></i> Moneygram
					</button>
					<?php } ?>
					<?php if($enable_dusupay == "yes"){ ?>
					<button class="btn btn-default ml-2" <?= $withdrawLimitText; ?>>
					<i class="fa fa-mobile"></i> Mobile Money
					</button>
					<?php } ?>
					<?php if($enable_coinpayments == "yes"){ ?>
					<button class="btn btn-default ml-2" <?= $withdrawLimitText; ?>>
					<i class="fa fa-bitcoin"></i> Bitcoin Wallet
					</button>
					<?php } ?>
					<?php } ?>
					<div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Date</th>
									<th>For</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$get_revenues = $db->select("revenues",array("seller_id"=>$login_seller_id),"DESC");
								while($row_revenues = $get_revenues->fetch()){
								$revenue_id = $row_revenues->revenue_id;
								$order_id = $row_revenues->order_id;
								$amount = $row_revenues->amount;
								$date = $row_revenues->date;
								$status = $row_revenues->status;
								?>
								<tr>
									<td> <?= $date; ?> </td>
									<td>
										<?php if($status == "pending"){ ?>
										Order Revenue Pending Clearance (<a href="order_details?order_id=<?= $order_id; ?>" target="blank" class="text-success"> View Order </a>)
										<?php }else{ ?>
										Order Revenue (<a href="order_details?order_id=<?= $order_id; ?>" target="blank" class="text-success"> View Order </a>)
										<?php } ?>
									</td>
									<td class="text-success"> +<?= $s_currency; ?><?= $amount; ?>.00 </td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> -->
		
		<div id="paypal_withdraw_modal" class="modal fade">
			<div class="modal-dialog modal-dialog-centered customer-order">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"> Withdraw/Transfer Funds To PayPal </h5>
						<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
              <img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png">
            </a>
					</div>
					<div class="modal-body"><!-- modal-body Starts -->
					<center><!-- center Starts -->
					<?php if(empty($login_seller_paypal_email)){ ?>
					<p class="lead">
						In order to transfer funds to your PayPal account, you will need to add your PayPal email in your
						<a href="<?= $site_url; ?>/settings?account_settings" class="text-success">
							account settings
						</a>
						tab.
					</p>
					<?php }else{ ?>
					<p class="lead">
						Your revenue funds will be transferred to:
						<br> <strong> <?= $login_seller_paypal_email; ?> </strong>
					</p>
					<form action="<?= ($wish_do_manual_payouts == 1)?"withdraw_manual":"paypal_adaptive"; ?>" method="post">
						<input type="hidden" name="method" value="paypal">
						<div class="form-group">
							<div class="control-label d-flex align-items-start">
								<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
								<span class="d-flex">Amount</span>
							</div>
							<input type="number" name="amount" class="form-control input-lg mb-30" min="<?= $withdrawal_limit; ?>" max="<?= $current_balance; ?>" placeholder="<?= $withdrawal_limit; ?> Minimum" required >
						</div>
						<div class="form-group">
							<input type="submit" name="withdraw" value="Transfer" class="button">
						</div>
					</form>
					<?php } ?>
					</center>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id="payoneer_withdraw_modal" class="modal fade">
		<div class="modal-dialog modal-dialog-centered customer-order">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"> Withdraw/Transfer Funds To Payoneer </h5>
					<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
            <img src="assets/img/seller-profile/popup-close-icon.png">
          </a>
				</div>
				<div class="modal-body"><!-- modal-body Starts -->
				<center><!-- center Starts -->
				<?php if(empty($login_seller_payoneer_email)){ ?>
				<p class="lead">
					In order to transfer funds to your Payoneer account, you will need to add your payoneer email in your
					<a href="<?= $site_url; ?>/settings?account_settings" class="text-success">account settings</a> tab.
				</p>
				<?php }else{ ?>
				<p class="lead">
					Your revenue funds will be transferred to : <br> <strong><?= $login_seller_payoneer_email; ?></strong>
				</p>
				<form action="withdraw_manual" method="post">
					<input type="hidden" name="method" value="payoneer">
					<div class="form-group">
						<div class="control-label d-flex align-items-start">
							<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
							<span class="d-flex">Amount</span>
						</div>
						<input type="number" name="amount" class="form-control input-lg mb-30" min="<?= $withdrawal_limit; ?>" max="<?= $current_balance; ?>" placeholder="<?= $withdrawal_limit; ?> Minimum" required >
					</div>
					<div class="form-group">
						<input type="submit" name="withdraw" value="Transfer" class="button" >
					</div>
				</form>
				<?php } ?>
				</center>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php
if($paymentGateway == 1){
	include("plugins/paymentGateway/revenueModals.php");
}
?>
<div id="mobile_money_modal" class="modal fade"><!-- mobile_money_modal modal fade Starts -->
<div class="modal-dialog modal-dialog-centered customer-order"><!-- modal-dialog Starts -->
<div class="modal-content"><!-- modal-content Starts -->
<div class="modal-header"><!-- modal-header Starts -->
<h5 class="modal-title"> Withdraw To Mobile Money Account </h5>
<button type="button" class="close" data-dismiss="modal">
<span>&times;</span>
</button>
</div><!-- modal-header Ends -->
<div class="modal-body text-center"><!-- modal-body Starts -->
<?php if(empty($login_seller_account_number) or empty($login_seller_account_name)){ ?>
<p class="modal-lead">
	For Withdraw Payments To Your Mobile Money Account Please Add Your Mobile Money Account Details In <a href="#" id="settings-link">Settings Tab</a>
</p>
<?php }else{ ?>
<p class="modal-lead">
	Your Payments Will Be Sent To Following Mobile Money Account:
	<p class="mb-1"> <strong> Account Number: </strong> <?= $login_seller_account_number; ?> </p>
	<p> <strong> Account/Owner Name: </strong> <?= $login_seller_account_name; ?> </p>
</p>
<form action="<?= ($wish_do_manual_payouts == 1)?"withdraw_manual":"withdraw"; ?>" method="post"><!-- withdraw form Starts -->
<input type="hidden" name="method" value="dusupay">
<div class="form-group row"><!-- form-group Starts -->
<label class="col-md-3 col-form-label"> Amount: </label>
<div class="col-md-8">
	<div class="input-group">
		<span class="input-group-addon font-weight-bold"> $ </span>
		<input type="number" name="amount" class="form-control" min="<?= $withdrawal_limit; ?>" max="<?= $current_balance; ?>" placeholder="<?= $withdrawal_limit; ?> Minimum" required>
		<input type="hidden" name="withdraw_method" value="mobile_money">
	</div>
</div>
</div><!-- form-group Ends -->
<div class="form-group row"><!-- form-group Starts -->
<div class="col-md-8 offset-md-3">
	<input type="submit" name="withdraw" value="Withdraw" class="btn btn-success form-control">
</div>
</div><!-- form-group Ends -->
</form><!-- withdraw form Ends -->
<?php } ?>
</div><!-- modal-body Ends -->
</div><!-- modal-content Ends -->
</div><!-- modal-dialog Ends -->
</div><!-- mobile_money_modal modal fade Ends -->
<div id="trx_wallet_modal" class="modal fade">
	<div class="modal-dialog modal-dialog-centered customer-order">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Withdraw/Transfer Funds To Bitcoin Wallet </h5>
				<button class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body"><!-- modal-body Starts -->
			<center><!-- center Starts -->
			<?php if(empty($login_seller_wallet)){ ?>
			<p class="lead">
				In order to transfer funds to your bitcoin wallet, you will need to add your wallet address in your
				<a href="<?= $site_url; ?>/settings?account_settings" class="text-success">
					account settings
				</a>
				tab.
			</p>
			<?php }else{ ?>
			<p class="lead">
				Your revenue funds will be transferred to:
				<br> <strong> <?= $login_seller_wallet; ?> </strong>
			</p>
			<form action="<?= ($wish_do_manual_payouts == 1)?"withdraw_manual":"withdraw_wallet"; ?>" method="post">
				<input type="hidden" name="method" value="bitcoin wallet">
				<div class="form-group row">
					<label class="col-md-3 col-form-label font-weight-bold">Amount</label>
					<div class="col-md-8">
						<div class="input-group">
							<span class="input-group-addon font-weight-bold"> $ </span>
							<input type="number" name="amount" class="form-control input-lg" min="<?= $withdrawal_limit; ?>" max="<?= $current_balance; ?>" placeholder="<?= $withdrawal_limit; ?> Minimum" required >
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-3">
						<input type="submit" name="withdraw" value="Transfer" class="btn btn-success form-control">
					</div>
				</div>
			</form>
			<?php } ?>
			</center>
		</div>
		<div class="modal-footer">
			<button class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
<?php require_once("includes/footer.php"); ?>
</body>
</html>