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
<html lang="en" class="ui-toolkit">
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
	<!-- <link href="../styles/bootstrap.css" rel="stylesheet">
	<link href="../styles/custom.css" rel="stylesheet"> --> 
	<!-- Custom css code from modified in admin panel --->
	<!-- <link href="../styles/styles.css" rel="stylesheet"> -->
	<link href="../styles/user_nav_styles.css" rel="stylesheet">
	<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>

</head>
<body class="all-content">
<?php require_once("../includes/buyer-header.php"); ?>

	<main>
		<section class="container-fluid offers">
			<div class="row">
				<div class="container">
					<div class="row flex-sm-row-reverse">
						<div class="col-12 col-sm-8 d-flex flex-row align-items-start justify-content-sm-end">
							<a class="backtomain" href="<?= $site_url; ?>/requests/manage_requests">Back To Manage Request</a>
						</div>
						<div class="col-12 col-sm-4">
							<h1>Offers</h1>
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
										<i class="fal fa-angle-left"></i>
									</a>
									<span>Refine Results</span>
									<a class="clearfilter" href="javascript:void(0);">Clear All</a>
								</h3>
								<form action="" method="POST">
									<div class="offer-sidebar-card d-flex flex-column">
										<div class="offer-sidebar-header d-flex flex-row align-items-center">
											<span>
												<img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/offer/price-icon.png" />
											</span>
											<span>Price</span>
										</div>
										<div class="offer-sidebar-body">
											<input id="price" type="text" name="" value="" class="irs-hidden-input" tabindex="-1" readonly="">
										</div>
									</div>
									<!-- Each item -->
									<div class="offer-sidebar-card d-flex flex-column">
										<div class="offer-sidebar-header d-flex flex-row align-items-center">
											<span>
												<img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/offer/status-icon.png" />
											</span>
											<span>Status</span>
										</div>
										<div class="offer-sidebar-body d-flex flex-column">
											<div class="status-item d-flex flex-row align-items-center justify-content-between">
												<div class="status-text">
													<p class="text">Any</p>
												</div>
												<div class="status-switch">
													<div class="md_switch">
														<input class="switch" checked id="switch-1" type="checkbox">
														<label for="switch-1"></label>
													</div>
												</div>
											</div>
											<!-- Each item -->
											<div class="status-item d-flex flex-row align-items-center justify-content-between">
												<div class="status-text">
													<p class="text">Online</p>
												</div>
												<div class="status-switch">
													<div class="md_switch">
														<input class="switch" id="switch-2" type="checkbox">
														<label for="switch-2"></label>
													</div>
												</div>
											</div>
											<!-- Each item -->
											<div class="status-item d-flex flex-row align-items-center justify-content-between">
												<div class="status-text">
													<p class="text">Offline</p>
												</div>
												<div class="status-switch">
													<div class="md_switch">
														<input class="switch" id="switch-3" type="checkbox">
														<label for="switch-3"></label>
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
												<img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/offer/time-icon.png" />
											</span>
											<span>Delivery Time</span>
										</div>
										<div class="offer-sidebar-body">
											<ul class="radio_titme radio_style2">
												<?php
												  $get_offers_time = $db->query("select delivery_time from send_offers where request_id=:request_id AND status='active'",array("request_id"=>$request_id));
												  
												  while($row_delivery_time = $get_offers_time->fetch()){
												  $delivery_time = $row_delivery_time->delivery_time;
												  
												  if(!empty($delivery_time)){
												?>
												<li>
												  <input type="radio" name="radio_titme" checked="" id="time<?php echo $delivery_id; ?>" class="get_delivery_time" value="<?php echo $delivery_time; ?>" <?php if(isset($delivery_time[$delivery_id])){ echo "checked"; } ?> >
												  <label for="time<?php echo $delivery_id; ?>"><span></span><?php echo $delivery_time; ?></label>
												</li>
												<?php }} ?>

												<li>
													<input type="radio" checked="" name="radio1" id="radio1">
													<label for="radio1"><span></span>Up To 24 Hours (Urgent)</label>
												</li>
												<li>
													<input type="radio" name="radio1" id="radio2">
													<label for="radio2"><span></span>Up To 3 Days</label>
												</li>
												<li>
													<input type="radio" name="radio1" id="radio3">
													<label for="radio3"><span></span>Up To 1 Week</label>
												</li>
												<li>
													<input type="radio" name="radio1" id="radio4">
													<label for="radio4"><span></span>Any</label>
												</li>
											</ul>
										</div>
									</div>
									<!-- Each item -->
									<div class="offer-sidebar-card d-flex flex-column">
										<button class="button button-red" type="submit" role="button">Update Search</button>
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
														<h2>My Request</h2>
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
														<span>Deliver Time: <strong><?php echo $request_delivery_time; ?></strong></span>
													</li>
												</ul>
												<div class="budget d-flex flex-column">
													<span>Budget</span>
													<span><?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget,2);}else{  echo $s_currency.' '; echo $request_budget; } ?></span>
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
										<h3>My Request</h3>
										<p><?php echo $request_description; ?></p>
										<ul class="list-inline d-flex flex-wrap">
											<li class="list-inline-item d-flex flex-row align-items-center">
												<span><i class="fal fa-clock"></i></span>
												<span>Deliver Time: <strong><?php echo $request_delivery_time; ?></strong></span>
											</li>
										</ul>
									</div>
									<div class="budget">
										<span>Budget</span>
										<span><?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget,2);}else{  echo $s_currency.' '; echo $request_budget; } ?></span>
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
									<h3 class="offer-count"><?php echo $count_offers; ?> Offers</h3>
								</div>
							</div>
							<!-- Row -->
							<div class="all-gigs-small">
								<div class="row">
									<?php if($count_offers == "0"){ ?>
									<div class="col-12 rounded-0 mb-3">
										<div class="card-body">
											<h3 class="text-center"> <i class="fa fa-frown-o"></i> Unfortunately, no offers yet. Please wait a little longer.</h3>
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
													<img class="img-fluid d-block" src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" />
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
															<div class="offer-item-user-image">
																<?php if(!empty($sender_image)){ ?>
							                  <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle" >
							                  <?php }else{ ?>
							                  <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
								                <?php } ?>
															</div>
															<div class="offer-item-user-content d-flex flex-column justify-content-start">
																<span class="user-name"><?php echo $sender_user_name; ?></span>
																<a href="../conversations/message?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="d-flex flex-row align-items-center">
																	<span>
																		<img src="<?= $site_url; ?>/assets/img/offer/mail-icon.png">
																	</span>
																	<span>Contact Me</span>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<ul class="list-inline d-flex flex-wrap">
												<li class="list-inline-item d-flex flex-row align-items-center">
													<span><i class="fal fa-clock"></i></span>
													<span>Deliver Time: <strong><?php echo $delivery_time; ?></strong></span>
												</li>
												<li class="list-inline-item d-flex flex-row align-items-center">
													<span><i class="fal fa-sync"></i></span>
													<span>Unlimited Revisions</span>
												</li>
											</ul>
											<div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
												<div class="d-flex flex-row justify-content-lg-end">
													<a class="button button-transparent" href="javascript:void(0);" onclick="hideOffer(<?= $offer_id; ?>)">Remove Offer</a>
													<a class="button button-red" id="order-button-<?php echo $offer_id; ?>"  href="javascript:void(0);">Order Now</a>
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
								<div class="col-12">
									<?php if($count_offers == "0"){ ?>
									<div class="offer-items d-flex flex-wrap rounded-0 mb-3">
										<div class="card-body">
											<h3 class="text-center"> <i class="fa fa-frown-o"></i> Unfortunately, no offers yet. Please wait a little longer.</h3>
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
											<img class="img-fluid d-block" src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" />
											<?php }else{ ?>
											<img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
											<?php } ?>
										</div>
										<div class="offer-item-content d-flex flex-column">
											<div class="d-flex flex-row align-items-start justify-content-between">
												<div class="d-flex flex-row align-items-center">
													<div class="offer-item-user-image">
														<?php if(!empty($sender_image)){ ?>
					                  <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle" >
					                  <?php }else{ ?>
					                  <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
						                <?php } ?>
													</div>
													<div class="offer-item-user-content d-flex flex-column justify-content-start">
														<span class="user-name"><?php echo $sender_user_name; ?></span>
														<a href="../conversations/message?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="d-flex flex-row align-items-center">
															<span>
																<img src="<?= $site_url; ?>/assets/img/offer/mail-icon.png">
															</span>
															<span>Contact Me</span>
														</a>
													</div>
												</div>
												<div class="d-flex flex-column offer-item-budget">
													<span>Budget</span>
													<span><?php if ($to == 'EGP'){ echo $to.' '; echo $amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $amount,2);}else{  echo $s_currency.' '; echo $amount; } ?></span>
												</div>
											</div>
											<p><?php echo $description; ?></p>
											<div class="row">
												<div class="col-12 col-lg-6">
													<ul class="list-inline d-flex flex-wrap">
														<li class="list-inline-item d-flex flex-row align-items-center">
															<span><i class="fal fa-clock"></i></span>
															<span>Deliver Time: <strong><?php echo $delivery_time; ?></strong></span>
														</li>
														<li class="list-inline-item d-flex flex-row align-items-center">
															<span><i class="fal fa-sync"></i></span>
															<span>Unlimited Revisions</span>
														</li>
													</ul>
												</div>
												<div class="col-12 col-lg-6">
													<div class="d-flex flex-row justify-content-lg-end">
														<a class="button button-transparent" href="javascript:void(0);" onclick="hideOffer(<?= $offer_id; ?>)">Remove Offer</a>
														<a class="button button-red" id="order-button-desktop-<?php echo $offer_id; ?>" href="javascript:void(0);">Order Now</a>
													</div>
												</div>
											</div>
											<!-- Row -->
											<script>
							          $("#order-button-desktop-<?php echo $offer_id; ?>").click(function(){
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
<script>
	function hideOffer(id){
		$('.offer-'+id).remove();
	}
</script>
<?php require_once("../includes/footer.php"); ?>
</body>
</html>