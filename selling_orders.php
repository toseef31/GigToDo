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
$used_purchases = $row_seller_accounts->used_purchases;
if ($used_purchases == '') {
	$used_purchases = '0';
}
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
	<head>
		<title><?php echo $site_name; ?> - Gigs Ordered By Your Customers</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php echo $site_desc; ?>">
		<meta name="keywords" content="<?php echo $site_keywords; ?>">
		<meta name="author" content="<?php echo $site_author; ?>">
		<!--====== Favicon Icon ======-->
		<?php if(!empty($site_favicon)){ ?>
			<link rel="shortcut icon" href="<?= $site_url; ?>/images/<?= $site_favicon; ?>" type="image/x-icon">
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
		<!--====== Nice select css ======-->
	  <link href="<?= $site_url; ?>/assets/css/tagsinput.css" rel="stylesheet">
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
		<link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet">
		<link href="styles/user_nav_styles.css" rel="stylesheet">
		<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
		<link href="styles/owl.carousel.css" rel="stylesheet">
		<link href="styles/owl.theme.default.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<style>
			.orders-list .orders-table tbody tr td .button.button-darkgray {
		    background-color: darkgray;
		    border-color: darkgray;
		    color: white;
			}
			.orders-list .orders-table tbody tr td .button:hover.button-darkgray {
		    background-color: white;
		    color: darkgray;
			}
		</style>
	</head>
	<body class="all-content">
		<?php require_once("includes/user_header.php"); ?>
		<!-- Preloader Start -->
		<div class="proloader">
			<div class="loader">
				<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
			</div>
		</div>
		<!-- Preloader End -->
		<main>
			<section class="container-fluid orders-list">
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<h1 class="title">Orders</h1>
							</div>
						</div>
						<!-- Row -->
						<div class="row">
							<div class="col-12">
								<div class="orders-summary d-flex flex-wrap">
									<div class="orders-summary-item d-flex flex-column align-items-center justify-content-between">
										<span class="image-icon">
											<img alt="" class="img-fluid d-block" src="assets/img/order/purchases-icon.png" />
										</span>
										<div class="d-flex flex-column">
											<span class="description">Total Earned</span>
											<span class="amount"><?= $s_currency; ?> <?= $used_purchases; ?></span>
										</div>
									</div>
									<!-- Each item -->
									<?php
								    $get_order = $db->select("orders",array("seller_id" => $login_seller_id, "order_status" => "completed"));
								    $completed_order_price = 0;
								    $order_amount_price = 0;
								    $order_fee_price = 0;
								    while($row_order = $get_order->fetch()){
								      $order_price = $row_order->order_price;
								      $order_fee = $row_order->order_fee;
								      $order_amount_price += $order_price;
								      $order_fee_price += $order_fee;
								      
								      $completed_order_price += $order_amount_price;
								    }
									?>
									<div class="orders-summary-item d-flex flex-column align-items-center justify-content-between">
										<span class="image-icon">
											<img alt="" class="img-fluid d-block" src="assets/img/order/completed-icon.png" />
										</span>
										<div class="d-flex flex-column">
											<span class="description">completed</span>
											<span class="amount"><?= $s_currency; ?> <?= $completed_order_price; ?></span>
										</div>
									</div>
									<!-- Each item -->
									<div class="orders-summary-item d-flex flex-column align-items-center justify-content-between">
										<span class="image-icon">
											<img alt="" class="img-fluid d-block" src="assets/img/order/review-icon.png" />
										</span>
										<div class="d-flex flex-column">
											<span class="description">awaiting review</span>
											<span class="amount">egp 0</span>
										</div>
									</div>
									<!-- Each item -->
									<?php
								    $get_order = $db->select("orders",array("seller_id" => $login_seller_id, "order_status" => "cancelled"));
								    $cancelled_order_price = 0;
								    $order_amount_price = 0;
								    $order_fee_price = 0;
								    while($row_order = $get_order->fetch()){
								      $order_price = $row_order->order_price;
								      $order_fee = $row_order->order_fee;
								      $order_amount_price += $order_price;
								      $order_fee_price += $order_fee;
								      
								      $cancelled_order_price += $order_amount_price;
								    }
									?>
									<div class="orders-summary-item d-flex flex-column align-items-center justify-content-between">
										<span class="image-icon">
											<img alt="" class="img-fluid d-block" src="assets/img/order/cancelled-icon.png" />
										</span>
										<div class="d-flex flex-column">
											<span class="description">cancelled</span>
											<span class="amount"><?= $s_currency; ?> <?= $cancelled_order_price; ?></span>
										</div>
									</div>
									<!-- Each item -->
									<div class="orders-summary-item d-flex flex-column align-items-center justify-content-between">
										<span class="image-icon">
											<img alt="" class="img-fluid d-block" src="assets/img/order/overdue-icon.png" />
										</span>
										<div class="d-flex flex-column">
											<span class="description">overdue</span>
											<span class="amount">egp 0</span>
										</div>
									</div>
									<!-- Each item -->
								</div>
							</div>
						</div>
						<!-- Row -->
						<div class="row">
							<div class="col-12">
								<!-- <div class="orders-header d-flex flex-column flex-md-row justify-content-between">
										<div class="orders-status d-flex flex-row align-items-center">
											<span>Show</span>
											<div>
												<select class="wide">
													<option>Everything</option>
													<option>order again</option>
													<option>in progress</option>
													<option>awaiting review</option>
													<option>cancelled</option>
													<option>overdue</option>
												</select>
											</div>
										</div>
										<div class="orders-pagination">
											<ul class="pagination">
												<li class="pagination-item">
													<a class="pagination-link" href="javascript:void(0);">
														<i class="fal fa-angle-left"></i>
													</a>
												</li>
												<li class="pagination-item">
													<a class="pagination-link" href="javascript:void(0);">1</a>
												</li>
												<li class="pagination-item">
													<div class="pagination-status d-flex flex-row align-items-center">
														<span>Of</span>
														<span>1</span>
													</div>
												</li>
												<li class="pagination-item">
													<a class="pagination-link" href="javascript:void(0);">
														<i class="fal fa-angle-right"></i>
													</a>
												</li>
											</ul>
										</div>
									</div> -->
							</div>
						</div>
						<!-- Row -->
						<div class="row">
							<div class="col-12">
								<?php require_once("manage_orders/order_all_selling.php") ?>
							</div>
						</div>
						<!-- Row -->
					</div>
				</div>
			</section>
		</main>

		<!-- <div class="container-fluid mt-5">
			<div class="row">
				<div class="col-md-12">
					<h1 class="<?=($lang_dir == "right" ? 'text-right':'')?>"><?php echo $lang["titles"]["selling_orders"]; ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-5 mb-3">
					<ul class="nav nav-tabs flex-column flex-sm-row ">
						<li class="nav-item">
							
							<?php
							$count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_active" => 'yes'));
							
							?>
							
							<a href="#active" data-toggle="tab" class="nav-link make-black active ">
								<?= $lang['tabs']['active']; ?> <span class="badge badge-success"><?php echo $count_orders; ?></span>
							</a>
						</li>
						<li class="nav-item">
							
							<?php
							$count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_status" => 'delivered'));
							?>
							<a href="#delivered" data-toggle="tab" class="nav-link make-black">
								<?= $lang['tabs']['delivered']; ?> <span class="badge badge-success"><?php echo $count_orders; ?></span>
								
							</a>
							
						</li>
						<li class="nav-item">
							
							<?php
							$count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_status" => 'completed'));
							?>
							<a href="#completed" data-toggle="tab" class="nav-link make-black">
								<?= $lang['tabs']['completed']; ?> <span class="badge badge-success"><?php echo $count_orders; ?></span>
							</a>
						</li>
						<li class="nav-item">
							
							<?php
									$count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_status" => 'cancelled'));
							?>
							<a href="#cancelled" data-toggle="tab" class="nav-link make-black">
								<?= $lang['tabs']['cancelled']; ?> <span class="badge badge-success"><?php echo $count_orders; ?></span>
								
							</a>
						</li>
						<li class="nav-item">
							
							<?php
							$count_orders = $db->count("orders",array("seller_id" => $login_seller_id));
							?>
							<a href="#all" data-toggle="tab" class="nav-link make-black">
								<?= $lang['tabs']['all']; ?> <span class="badge badge-success"><?php echo $count_orders; ?></span>
								
							</a>
						</li>
						
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="active">
							<?php require_once("manage_orders/order_active_selling.php") ?>
						</div>
						<div class="tab-pane" id="delivered">
							<?php require_once("manage_orders/order_delivered_selling.php") ?>
						</div>
						<div class="tab-pane" id="completed">
							<?php require_once("manage_orders/order_completed_selling.php") ?>
						</div>
						<div class="tab-pane" id="cancelled">
							<?php require_once("manage_orders/order_cancelled_selling.php") ?>
						</div>
						<div class="tab-pane" id="all">
							<?php require_once("manage_orders/order_all_selling.php") ?>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<?php require_once("includes/footer.php"); ?>
	</body>
</html>