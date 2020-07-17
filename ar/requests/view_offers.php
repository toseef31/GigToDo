<?php

session_start();
require_once("../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_image = $row_login_seller->seller_image;

$request_id = $input->get('request_id');
$get_requests = $db->select("buyer_requests",array("request_id" => $request_id,"seller_id"=>$login_seller_id,"request_status" => "active"));
if($get_requests->rowCount() == 0){ echo "<script>window.open('manage_requests','_self');</script>"; }
$row_requests = $get_requests->fetch();
$request_id = $row_requests->request_id;
$cat_id = $row_requests->cat_id;
$child_id = $row_requests->child_id;
$request_description = $row_requests->request_description;
$request_date = $row_requests->request_date;
$request_budget = $row_requests->request_budget;
$request_delivery_time = $row_requests->delivery_time;

$get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
$row_meta = $get_meta->fetch();
$request_cat_title = $row_meta->cat_title;
$get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
$row_meta = $get_meta->fetch();
$request_child_title = $row_meta->child_title;
$get_offers = $db->select("send_offers",array("request_id" => $request_id, "status" => 'active'));
$count_offers = $get_offers->rowCount();

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
<head>
	<title><?php echo $site_name; ?> - Offers</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
	<!--====== Favicon Icon ======-->
	<?php if(!empty($site_favicon)){ ?>
	<link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
	<?php } ?>
	<!--====== Bootstrap css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/bootstrap.min.css" rel="stylesheet">
	<!--====== PreLoader css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/preloader.css" rel="stylesheet">
	<!--====== Animate css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/animate.min.css" rel="stylesheet">
	<!--====== Fontawesome css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/fontawesome.min.css" rel="stylesheet">
	<!--====== Owl carousel css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/owl.carousel.min.css" rel="stylesheet">
	<!--====== Nice select css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/nice-select.css" rel="stylesheet">
	<!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/tagsinput.css" rel="stylesheet">
	<!--====== Range Slider css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
	<!--====== Default css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
	<!--====== Style css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="../styles/bootstrap.css" rel="stylesheet">
	<link href="../styles/custom.css" rel="stylesheet"> --> 
	<!-- Custom css code from modified in admin panel --->
	<!-- <link href="../styles/styles.css" rel="stylesheet"> -->
	<link href="../styles/user_nav_styles.css" rel="stylesheet">
	<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<style>
		.offer-item-user-image  .active{
			width: 12px;
	    height: 12px;
	    -webkit-border-radius: 50%;
	    -moz-border-radius: 50%;
	    border-radius: 50%;
	    display: inline-block;
	    background-color: #91ca2c;
	    border: 2px solid #fff;
	    position: absolute;
	    top: 5px;
	    left: 7px;
		}
		.price_section .irs.irs--flat:nth-child(2){
			display: none;
		}
	</style>
</head>
<body class="all-content">
<?php require_once("../includes/buyer-header.php"); ?>

	<main>
		<section class="container-fluid offers">
			<div class="row">
				<div class="container">
					<div class="row flex-sm-row-reverse">
						<div class="col-12 col-sm-8 d-flex flex-row align-items-start justify-content-sm-end">
							<a class="backtomain" href="<?= $site_url; ?>/ar/requests/manage_requests">الرجوع لإدارة الطلب</a>
						</div>
						<div class="col-12 col-sm-4">
							<h1>العروض</h1>
						</div>
					</div>
					<!-- Row -->
					<div class="row">
						<div class="col-12 col-lg-3">
							<button class="filter-results" type="button" role="button">
								<img src="<?= $site_url; ?>/assets/img/gigs/filter.png" alt="" />Filter by
							</button>
							<div class="offer-sidebar">
								<h3>
									<a id="backtomain" class="backtomain" href="javascript:void(0);">
										<i class="fal fa-angle-right"></i>
									</a>
									<span>
										حدد النتائج
									</span>
									<a class="clearfilter" href="javascript:void(0);">
										امسح الكل
									</a>
								</h3>
								<form action="" method="POST">
									<div class="offer-sidebar-card d-flex flex-column">
										<div class="offer-sidebar-header d-flex flex-row align-items-center">
											<span>
												<img alt="" class="img-fluid d-block" src="<?= $site_url ?>/ar/assets/img/offer/price-icon.png" />
											</span>
											<span>
												السعر
											</span>
										</div>
										<div class="offer-sidebar-body price_section">
											<input id="price" type="text" name="" value="" class="irs-hidden-input" tabindex="-1" readonly="">
											<input type="hidden" id="price_range" name="">
										</div>
									</div>
									<!-- Each item -->
									<div class="offer-sidebar-card d-flex flex-column">
										<div class="offer-sidebar-header d-flex flex-row align-items-center">
											<span>
												<img alt="" class="img-fluid d-block" src="<?= $site_url ?>/ar/assets/img/offer/status-icon.png" />
											</span>
											<span>الحالة</span>
										</div>
										<div class="offer-sidebar-body d-flex flex-column">
											<div class="status-item d-flex flex-row align-items-center justify-content-between">
												<div class="status-text">
													<p class="text">أى حاجة</p>
												</div>
												<div class="status-switch">
													<div class="md_switch">
														<input class="switch" value="any" checked id="any" type="checkbox">
														<label for="any"></label>
													</div>
												</div>
											</div>
											<!-- Each item -->
											<div class="status-item d-flex flex-row align-items-center justify-content-between">
												<div class="status-text">
													<p class="text">أونلاين</p>
												</div>
												<div class="status-switch">
													<div class="md_switch">
														<input class="switch" value="online" id="online" type="checkbox">
														<label for="online"></label>
													</div>
												</div>
											</div>
											<!-- Each item -->
											<div class="status-item d-flex flex-row align-items-center justify-content-between">
												<div class="status-text">
													<p class="text">أوفلاين</p>
												</div>
												<div class="status-switch">
													<div class="md_switch">
														<input class="switch" value="offline" id="offline" type="checkbox">
														<label for="offline"></label>
													</div>
												</div>
											</div>
											<!-- Each item -->
										</div>
									</div>
									<!-- Each item -->
									<div class="offer-sidebar-card d-flex flex-column">
										<div class="offer-sidebar-header d-flex flex-row align-items-center">
											<span>
												<img alt="" class="img-fluid d-block" src="<?= $site_url ?>/ar/assets/img/offer/time-icon.png" />
											</span>
											<span>
												وقت التسليم
											</span>
										</div>
										<div class="offer-sidebar-body">
											<ul class="radio_titme radio_style2">
												<li>
													<input type="radio" name="radio_titme" checked="" id="anytime" class="get_delivery_time" value="anytime">
													<label for="anytime"><span></span>أى حاجة</label>
												</li>
												<?php
												  $get_offers_time = $db->query("select DISTINCT delivery_time from send_offers where request_id=:request_id AND status='active'",array("request_id"=>$request_id));
												  
												  while($row_delivery_time = $get_offers_time->fetch()){
												  $delivery_time = $row_delivery_time->delivery_time;
												  
												  if(!empty($delivery_time)){
												?>
												<li>
													<input type="radio" name="radio_titme" id="time<?php echo $delivery_time; ?>" class="get_delivery_time" value="<?php echo $delivery_time; ?>">
													<label for="time<?php echo $delivery_time; ?>"><span></span><?php echo $delivery_time; ?></label>
												</li>
												<?php }} ?>
											</ul>
										</div>
									</div>
									<!-- Each item -->
									<div class="offer-sidebar-card d-flex flex-column">
										<button class="button button-red" type="submit" role="button">حدث البحث</button>
									</div>
									<!-- Each item -->
								</form>
							</div>
						</div>
						<div class="col-12 col-lg-9">
							<div class="all-gigs-small">
								<div class="row">
									<div class="col-12">
										<div class="small-gigs-item single-offer-request d-flex flex-column">
											<div class="small-gigs-item-header d-flex justify-content-between">
												<div class="small-gigs-image">
													<?php if(!empty($login_seller_image)){ ?>
														<img class="img-fluid d-block rounded-circle" src="<?= $site_url; ?>/user_images/<?= $login_seller_image; ?>" />
													<?php }else{ ?>
														
														<img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
													<?php } ?>
												</div>
												<div class="small-gigs-content d-flex justify-content-between">
													<div class="content d-flex flex-column justify-content-between">
														<h2>طلبى</h2>
														<h3 class="title">
															<span><?php echo $request_description; ?></span>
														</h3>
													</div>
												</div>
											</div>
											<div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
												<ul class="list-inline d-flex flex-wrap">
													<li class="list-inline-item d-flex flex-row align-items-center">
														<span><i class="fal fa-clock"></i></span>
														<span>وقت التسليم : <strong><?php echo $request_delivery_time; ?></strong></span>
													</li>
												</ul>
												<div class="budget d-flex flex-column">
													<span>الميزانية</span>
													<span><?php echo $s_currency; ?><?php echo $request_budget; ?></span>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
								</div>
							</div>
							<!-- Offer request mobile -->
							<div class="offer-request d-none d-lg-flex flex-wrap align-items-start">
								<div class="offer-request-image">
									<?php if(empty($login_seller_image)){ ?>
										<img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
									<?php }else{ ?>
										<img class="img-fluid d-block rounded-circle" src="<?= $site_url; ?>/user_images/<?= $login_seller_image; ?>" />
									<?php } ?>
								</div>
								<div class="offer-request-content d-flex flex-row align-items-start justify-content-between">
									<div class="text">
										<h3>طلبى</h3>
										<p><?php echo $request_description; ?></p>
										<ul class="list-inline d-flex flex-wrap">
											<li class="list-inline-item d-flex flex-row align-items-center">
												<span><i class="fal fa-clock"></i></span>
												<span>وقت التسليم : <strong><?php echo $request_delivery_time; ?></strong></span>
											</li>
										</ul>
									</div>
									<div class="budget">
										<span>الميزانية</span>
										<span><?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget);}else{  echo $s_currency.' '; echo $request_budget; } ?></span>
									</div>
								</div>
							</div>
							<!-- Offer Request -->
							<div class="row flex-md-row-reverse">
								<div class="col-12 col-md-8">
									<!-- <ul class="pagination">
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
									</ul> -->
								</div>
								<div class="col-12 col-md-4">
									<h3 class="offer-count"><?php echo $count_offers; ?> عرض</h3>
								</div>
							</div>
							<!-- Row -->
							<div class="all-gigs-small">
								<div class="row">
									<?php if($count_offers == "0"){ ?>
									<div class="col-12 rounded-0 mb-3">
										<div class="card-body">
											<h3 class="text-center"> <i class="fa fa-frown-o"></i> للأسف ، لا توجد عروض حتى الآن. يرجى الانتظار لفترة أطول قليلاً.</h3>
										</div>
									</div>
									<?php }else{ ?>
									<?php 
										$get_offers = $db->select("send_offers",array("request_id" => $request_id, "status" => 'active'));
										$count_offers = $get_offers->rowCount();
										while($row_offers = $get_offers->fetch()){
										$offer_id = $row_offers->offer_id;
										$proposal_id = $row_offers->proposal_id;
										$description = $row_offers->description;
										$delivery_time = $row_offers->delivery_time;
										$amount = $row_offers->amount;
										$sender_id = $row_offers->sender_id;
										$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
										$row_sender = $select_sender->fetch();
										$sender_user_name = $row_sender->seller_user_name;
										$sender_level = $row_sender->seller_level;
										$sender_image = $row_sender->seller_image;
										$sender_status = $row_sender->seller_status;
										$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
										$row_proposals = $select_proposals->fetch();
										$proposal_title = $row_proposals->proposal_title;
										$proposal_url = $row_proposals->proposal_url;
										$proposal_img1 = $row_proposals->proposal_img1;
									?>
									<div class="col-12 offer-<?= $offer_id; ?>">
										<div class="small-gigs-item small-offer-items d-flex flex-column">
											<div class="small-gigs-item-header d-flex justify-content-between">
												<div class="small-gigs-image">
													<?php if (!empty($proposal_img1)){ ?>
													<img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" />
													<?php }else{ ?>
													<img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
													<?php } ?>
												</div>
												<div class="small-gigs-content d-flex justify-content-between">
													<div class="content d-flex flex-column justify-content-between">
														<h3 class="title">
															<a href="javascript:void(0);"><?php echo $description; ?></a>
														</h3>
														<div class="d-flex flex-row align-items-center">
															<div class="offer-item-user-image position-relative">
																<?php if(!empty($sender_image)){ ?>
							                  <img src="<?= $site_url; ?>/user_images/<?php echo $sender_image; ?>" class="rounded-circle" >
							                  <?php }else{ ?>
							                  <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
								                <?php } ?>
							                  <?php if($sender_status == "online"){ ?>
							                  <span class="active"></span>
							                	<?php } ?>
															</div>
															<div class="offer-item-user-content d-flex flex-column justify-content-start">
																<span class="user-name"><?php echo $sender_user_name; ?></span>
																<a href="../conversations/message?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="d-flex flex-row align-items-center">
																	<span>
																		<img src="<?= $site_url; ?>/assets/img/offer/mail-icon.png">
																	</span>
																	<span>اتواصل معايا</span>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<ul class="list-inline d-flex flex-wrap">
												<li class="list-inline-item d-flex flex-row align-items-center">
													<span><i class="fal fa-clock"></i></span>
													<span>وقت التسليم : <strong><?php echo $delivery_time; ?></strong></span>
												</li>
												<li class="list-inline-item d-flex flex-row align-items-center">
													<span><i class="fal fa-sync"></i></span>
													<span>عدد لا نهائى من المراجعات</span>
												</li>
											</ul>
											<div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
												<div class="d-flex flex-row justify-content-lg-end">
													<a class="button button-transparent" href="javascript:void(0);" onclick="hideOffer(<?= $offer_id; ?>)">امسح العرض</a>
													<form method="post" action="../offer-checkout" id="offer<?= $offer_id; ?>">
														<input type="hidden" name="request_id" value="<?= $request_id; ?>">
														<input type="hidden" name="offer_id" value="<?= $offer_id; ?>">
														<input type="hidden" name="proposal_qty" value="1">
														<button class="button button-red"  name="add_order">اطلب دلوقتي</button>
													</form>
												</div>
												<div class="small-gigs-pricing d-flex flex-row">
													<a href="javascript:void(0);"><?php if ($to == 'EGP'){ echo $to.' '; echo $amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $amount,2);}else{  echo $s_currency.' '; echo $amount; } ?></a>
												</div>
											</div>
											<script>
							          $("#order-button-<?php echo $offer_id; ?>").click(function(){
							            request_id = "<?php echo $request_id; ?>";
							            offer_id = "<?php echo $offer_id; ?>";
							            $.ajax({
							              method: "POST",
							              url: "offer_submit_order",
							              data: {request_id: request_id, offer_id: offer_id}
							            }).done(function(data){
							               $("#append-modal").html(data);
							            });	
							          });
						          </script>
										</div>
									</div>
									<!-- Each item -->
									<?php } } ?>
								</div>
							</div>
							<!-- Small gigs item for mobile -->
							<div class="row d-none d-lg-flex">
								<div class="col-12" id="offers-data">
									<?php if($count_offers == "0"){ ?>
									<div class="offer-items d-flex flex-wrap rounded-0 mb-3">
										<div class="card-body">
											<h3 class="text-center"> <i class="fa fa-frown-o"></i> للأسف ، لا توجد عروض حتى الآن. يرجى الانتظار لفترة أطول قليلاً.</h3>
										</div>
									</div>
									<?php }else{ ?>
									<?php 
										$get_offers = $db->select("send_offers",array("request_id" => $request_id, "status" => 'active'));
										$count_offers = $get_offers->rowCount();
										while($row_offers = $get_offers->fetch()){
										$offer_id = $row_offers->offer_id;
										$proposal_id = $row_offers->proposal_id;
										$description = $row_offers->description;
										$delivery_time = $row_offers->delivery_time;
										$amount = $row_offers->amount;
										$sender_id = $row_offers->sender_id;
										$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
										$row_sender = $select_sender->fetch();
										$sender_user_name = $row_sender->seller_user_name;
										$sender_level = $row_sender->seller_level;
										$sender_image = $row_sender->seller_image;
										$sender_status = $row_sender->seller_status;
										$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
										$row_proposals = $select_proposals->fetch();
										$proposal_title = $row_proposals->proposal_title;
										$proposal_url = $row_proposals->proposal_url;
										$proposal_img1 = $row_proposals->proposal_img1;
									?>
									<div class="offer-items d-flex flex-wrap offer-<?= $offer_id; ?>">
										<div class="offer-item-image">
											<?php if (!empty($proposal_img1)){ ?>
											<img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" />
											<?php }else{ ?>
											<img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
											<?php } ?>
										</div>
										<div class="offer-item-content d-flex flex-column">
											<div class="d-flex flex-row align-items-start justify-content-between">
												<div class="d-flex flex-row align-items-center">
													<div class="offer-item-user-image position-relative">
														<?php if(!empty($sender_image)){ ?>
					                  <img src="<?= $site_url; ?>/user_images/<?php echo $sender_image; ?>" class="rounded-circle" >
					                  <?php }else{ ?>
					                  <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
						                <?php } ?>
					                  <?php if($sender_status == "online"){ ?>
					                  <span class="active"></span>
					                	<?php } ?>
													</div>
													<div class="offer-item-user-content d-flex flex-column justify-content-start">
														<span class="user-name"><?php echo $sender_user_name; ?></span>
														<a href="../conversations/message?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="d-flex flex-row align-items-center">
															<span>
																<img src="<?= $site_url; ?>/assets/img/offer/mail-icon.png">
															</span>
															<span>اتواصل معايا</span>
														</a>
													</div>
												</div>
												<div class="d-flex flex-column offer-item-budget">
													<span>الميزانية</span>
													<span><?php if ($to == 'EGP'){ echo $to.' '; echo $amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $amount,2);}else{  echo $s_currency.' '; echo $amount; } ?></span>
												</div>
											</div>
											<p><?php echo $description; ?></p>
											<div class="row">
												<div class="col-12 col-lg-6">
													<ul class="list-inline d-flex flex-wrap">
														<li class="list-inline-item d-flex flex-row align-items-center">
															<span><i class="fal fa-clock"></i></span>
															<span>وقت التسليم : <strong><?php echo $delivery_time; ?></strong></span>
														</li>
														<li class="list-inline-item d-flex flex-row align-items-center">
															<span><i class="fal fa-sync"></i></span>
															<span>عدد لا نهائى من المراجعات</span>
														</li>
													</ul>
												</div>
												<div class="col-12 col-lg-6">
													<div class="d-flex flex-row justify-content-lg-end">
														<a class="button button-transparent" href="javascript:void(0);" onclick="hideOffer(<?= $offer_id; ?>)">امسح العرض</a>
														<form method="post" action="../offer-checkout" id="offer<?= $offer_id; ?>">
															<input type="hidden" name="request_id" value="<?= $request_id; ?>">
															<input type="hidden" name="offer_id" value="<?= $offer_id; ?>">
															<input type="hidden" name="proposal_qty" value="1">
															<button class="button button-red" name="add_order">اطلب دلوقتي</button>
														</form>
													</div>
												</div>
											</div>
											<!-- Row -->
										</div>
									</div>
									<!-- Each item -->
								<?php } }?>
								</div>
							</div>
							<!-- Row -->
						</div>
					</div>
					<!-- Row -->
				</div>
			</div>
			<!-- Row -->
		</section>
	</main>


<!-- <div class="container mt-4 mb-4">
	<div class="row view-offers">
		<h2 class="mb-3 ml-3"> View Offers (<?php echo $count_offers; ?>) </h2>
		<div class="col-md-12">
			<div class="card mb-4 rounded-0">
				<div class="card-body">
					<h5 class="font-weight-bold"> Request Description: </h5>
					<p class="offer-p"><?php echo $request_description; ?></p>
					<p class="offer-p">
					<i class="fa fa-money"></i> <span> Request Budget: </span><span class="text-muted"> <?php echo $s_currency; ?><?php echo $request_budget; ?> </span><br>
					<i class="fa fa-calendar"></i> <span> Request Date: </span><span class="text-muted"> <?php echo $request_date; ?></span> <br>
					<i class="fa fa-clock-o"></i> <span> Request Duration: </span><span class="text-muted">  <?php echo $request_delivery_time; ?> </span>  <br>
					<i class="fa fa-archive"></i> <span> Request Category: </span><span class="text-muted"> <?php echo $request_cat_title; ?> / <?php echo $request_child_title; ?> </span>
					</p>
				</div>
			</div>
      <?php if($count_offers == "0"){ ?>
			<div class="card rounded-0 mb-3">
				<div class="card-body">
					<h3 class="text-center"> <i class="fa fa-frown-o"></i> Unfortunately, no offers yet. Please wait a little longer.</h3>
				</div>
			</div>
			<?php }else{ ?>
			<?php 
			while($row_offers = $get_offers->fetch()){
			$offer_id = $row_offers->offer_id;
			$proposal_id = $row_offers->proposal_id;
			$description = $row_offers->description;
			$delivery_time = $row_offers->delivery_time;
			$amount = $row_offers->amount;
			$sender_id = $row_offers->sender_id;
			$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
			$row_sender = $select_sender->fetch();
			$sender_user_name = $row_sender->seller_user_name;
			$sender_level = $row_sender->seller_level;
			$sender_image = $row_sender->seller_image;
			$sender_status = $row_sender->seller_status;
			$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
			$row_proposals = $select_proposals->fetch();
			$proposal_title = $row_proposals->proposal_title;
			$proposal_url = $row_proposals->proposal_url;
			$proposal_img1 = $row_proposals->proposal_img1;
			?>
			<div class="card rounded-0 mb-3">
				<div class="card-body">
					<div class="row">
						<div class="col-md-2">
							<img src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid" >
						</div>
						<div class="col-md-7">
							<h5 class="mt-md-0 mt-2">
							<a href="../proposals/<?php echo $sender_user_name; ?>/<?php echo $proposal_url; ?>" class="text-success"> <?php echo $proposal_title; ?></a>
							</h5>
							<p class="mb-1">
								<?php echo $description; ?>
							</p>
							<p class="offer-p">
								<i class="fa fa-money"></i> Offer Budget: <span class="font-weight-normal text-muted"> <?php echo $s_currency; ?><?php echo $amount; ?> </span><br>
								<i class="fa fa-calendar"></i> Offer Duration: <span class="font-weight-normal text-muted"> <?php echo $delivery_time; ?> </span>
							</p>
						</div>
						<div class="col-md-3 responsive-border pt-md-0 pt-3">
							<div class="offer-seller-picture">
								<?php if(!empty($sender_image)){ ?>
                  <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle" >
                  <?php }else{ ?>
                  <img src="../user_images/empty-image.png" class="rounded-circle" >
                <?php } ?>
                <?php if($sender_level == 2){ ?>
                <img src="../images/level_badge_1.png" class="level-badge" >
                <?php }elseif($sender_level == 3){ ?>
                <img src="../images/level_badge_2.png" class="level-badge" >
                <?php }elseif($sender_level == 4){ ?>
                <img src="../images/level_badge_3.png" class="level-badge" >
                <?php } ?>
							</div>
							<div class="offer-seller mb-4">
								<p class="font-weight-bold mb-1">
								<?php echo $sender_user_name; ?>  <small class="text-success"> <?php echo $sender_status; ?>  </small>
								</p>
								<p class="user-link">
								<a href="../<?php echo $sender_user_name; ?>" class="text-success" target="blank"> User Profile </a>
								</p>
							</div>
							<a href="../conversations/message?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="btn btn-sm btn-success rounded-0">
								Contact Now
							</a>
							<button id="order-button-<?php echo $offer_id; ?>" class="btn btn-sm btn-success rounded-0">
								Order Now
							</button>
						</div>
					</div>
					<script>
	          $("#order-button-<?php echo $offer_id; ?>").click(function(){
	            request_id = "<?php echo $request_id; ?>";
	            offer_id = "<?php echo $offer_id; ?>";
	            $.ajax({
	              method: "POST",
	              url: "offer_submit_order",
	              data: {request_id: request_id, offer_id: offer_id}
	            }).done(function(data){
	               $("#append-modal").html(data);
	            });	
	          });
          </script>
				</div>
			</div>
      <?php } ?>
      <?php } ?>
		</div>
	</div>
</div> -->

<div id="append-modal"></div>
<script src="<?= $site_url; ?>/assets/js/ion.rangeSlider.min.js"></script>
<script>
	function hideOffer(id){
		$('.offer-'+id).remove();
	}

	$('.get_delivery_time').click(function(){
	var time = $(this).val();
	var request_id = "<?php echo $request_id; ?>";

	$('#offers-data').html("");
	$.ajax({
	url:"offers",
	method:"POST",
	data:{time:time, request_id:request_id},
	success:function(data){
	$('#offers-data').html(data);
	}
	});
	});

	$('.switch').click(function(){
	var status = $(this).val();
	var request_id = "<?php echo $request_id; ?>";
	
	$('#offers-data').html("");
	$.ajax({
	url:"status_offer",
	method:"POST",
	data:{status:status, request_id:request_id},
	success:function(data){
	$('#offers-data').html(data);
	}
	});
	});

	$("#price").ionRangeSlider({
	  min: 0,
	  max: 300,
	  from: 1,
	  prefix: "EGP",
	  hide_min_max:false,
	  onChange: function(data) {
	      
	      var base_url = '<?php echo $site_url; ?>';
	      var request_id = "<?php echo $request_id; ?>";
	      $('#price_range').val(data.from);
	      $('#offers-data').html("");
	      var price = $('#price_range').val();
	      // alert(price);
	      $.ajax({
	        url:"price_offer",
	        method:"POST",
	        data:{price:price,  request_id:request_id},
	        success:function(data){
	          console.log(data);
	        $('#category_proposals').html('');  
	        
	        $('#offers-data').html(data); 
	      }
	      });
	    }
	});

</script>
<?php require_once("../includes/footer.php"); ?>
</body>
</html>