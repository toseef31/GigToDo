<?php
session_start([
	'cookie_lifetime' => 86400,
  ]);
require_once("../includes/db.php");
// if(!isset($_SESSION['seller_user_name'])){
// 	echo "<script>window.open('../login','_self')</script>";
// }
$seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_name = $row_login_seller->seller_name;
$login_user_name = $row_login_seller->seller_user_name;
$login_seller_offers = $row_login_seller->seller_offers;
$relevant_requests = $row_general_settings->relevant_requests;
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
	<head>
		<title><?= $site_name; ?> - <?= $lang["titles"]["post_request"]; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?= $site_desc; ?>">
		<meta name="keywords" content="<?= $site_keywords; ?>">
		<meta name="author" content="<?= $site_author; ?>">
		<?php if(!empty($site_favicon)){ ?>
		<!--====== Favicon Icon ======-->
		<link rel="shortcut icon" href="../images/<?= $site_favicon; ?>" type="image/png">
		<?php } ?>
		<!-- ==============Google Fonts============= -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
		<!--====== Bootstrap css ======-->
		<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!--====== PreLoader css ======-->
		<link href="../assets/css/preloader.css" rel="stylesheet">
		<!--====== Animate css ======-->
		<link href="../assets/css/animate.min.css" rel="stylesheet">
		<!--====== Fontawesome css ======-->
		<link href="../assets/css/fontawesome.min.css" rel="stylesheet">
		<!--====== Owl carousel css ======-->
		<link href="../assets/css/owl.carousel.min.css" rel="stylesheet">
		<!--====== Nice select css ======-->
		<link href="../assets/css/nice-select.css" rel="stylesheet">
		<link href="../assets/css/tagsinput.css" rel="stylesheet">
		<!--====== Default css ======-->
		<link href="../assets/css/default.css" rel="stylesheet">
		<!--====== Style css ======-->
		<link href="../assets/css/style.css" rel="stylesheet">
		<!--====== Responsive css ======-->
		<link href="../assets/css/responsive.css" rel="stylesheet">
		<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
		<link href="../styles/bootstrap.css" rel="stylesheet">
		<link href="../styles/custom.css" rel="stylesheet"> --> 
		<!-- Custom css code from modified in admin panel --->
		<link href="../styles/styles.css" rel="stylesheet">
		<!-- <link href="../styles/user_nav_styles.css" rel="stylesheet"> -->
		<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../styles/sweat_alert.css" rel="stylesheet">
		<link href="../styles/animate.css" rel="stylesheet">
		<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
		<script src="../js/ie.js"></script>
		<script type="text/javascript" src="../js/sweat_alert.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<style>
			.gig-category .nice-select:nth-Child(2){
				display: none;
			}
			/*#category{
				display: block !important;
				width: 47%;
				margin-right: 8px;
			}*/
			.post-register-form h4, .post-register-form p{
				padding-left: 30px;
			}
			.post-register-form span{
				padding-left: 0 !important;
			}
			.post-register-form .form-group{
				border-bottom: 0 !important;
				margin-bottom: 0 !important;
			}
			.nice-select.swal2-select{
				display: none;
			}
			
			/*.gig-category-select .text {
				color: white;
				font-size: 18px;
				font-family: 'Montserrat', sans-serif;
				font-weight: 600;
				line-height: 24px;
				margin-top: 10px;
				text-align: center;
			}*/
			.gig-category-item{
				display: -webkit-box;
				display: -webkit-flex;
				display: -moz-box;
				display: -ms-flexbox;
				display: flex;
				-webkit-flex-wrap: wrap;
				-ms-flex-wrap: wrap;
				flex-wrap: wrap;
				-webkit-flex-basis: 100%;
				-ms-flex-preferred-size: 100%;
				flex-basis: 100%;
				-webkit-box-pack: justify;
				-webkit-justify-content: space-between;
				-moz-box-pack: justify;
				-ms-flex-pack: justify;
				justify-content: space-between;
				max-width: 100%;
				margin: 0;
				-webkit-flex-basis: -webkit-calc(100% - 10px) !important;
			-ms-flex-preferred-size: calc(100% - 10px) !important;
			flex-basis: -moz-calc(100% - 10px) !important;
			flex-basis: calc(100% - 10px) !important;
			max-width: -webkit-calc(100% - 10px) !important;
			max-width: -moz-calc(100% - 10px) !important;
			max-width: calc(100% - 10px) !important;
			}
			.gig-category-select{
				-webkit-flex-basis: -webkit-calc(100% - 10px);
			-ms-flex-preferred-size: calc(100% - 10px);
			flex-basis: -moz-calc(100% - 10px);
			flex-basis: calc(100% - 10px);
			max-width: -webkit-calc(100% - 10px);
			max-width: -moz-calc(100% - 10px);
			max-width: calc(100% - 10px);
			}
			.cat_item-content{
				-webkit-flex-basis: -webkit-calc(50% - 10px) !important;
			-ms-flex-preferred-size: calc(50% - 10px) !important;
			flex-basis: -moz-calc(50% - 10px) !important;
			flex-basis: calc(50% - 10px) !important;
			max-width: -webkit-calc(50% - 10px) !important;
			max-width: -moz-calc(50% - 10px) !important;
			max-width: calc(50% - 10px) !important;
			}
			.cat_item-content.item-active .gig-category-select {
				-webkit-flex-basis: -webkit-calc(50% - 10px);
				-ms-flex-preferred-size: calc(50% - 10px);
				flex-basis: -moz-calc(50% - 10px);
				flex-basis: calc(100% - 0px);
				max-width: -webkit-calc(50% - 10px);
				max-width: -moz-calc(50% - 10px);
				max-width: calc(100% - 0px);
			}
			.postarequest .create-request .form-group .gig-category .cat_item-content.item-active {
				display: -webkit-box;
				display: -webkit-flex;
				display: -moz-box;
				display: -ms-flexbox;
				display: flex;
				-webkit-flex-wrap: wrap;
				-ms-flex-wrap: wrap;
				flex-wrap: wrap;
				-webkit-flex-basis: 100%;
				-ms-flex-preferred-size: 100%;
				flex-basis: 100%;
				-webkit-box-pack: justify;
				-webkit-justify-content: space-between;
				-moz-box-pack: justify;
				-ms-flex-pack: justify;
				justify-content: space-between;
				max-width: 100%;
				margin: 0;
			}
			.postarequest .create-request .form-group .gig-category .cat_item-content.item-active .gig-category-select {
				-webkit-flex-basis: -webkit-calc(100% - 10px);
				-ms-flex-preferred-size: calc(100% - 10px);
				flex-basis: -moz-calc(100% - 10px);
				flex-basis: calc(100% - 10px);
				max-width: -webkit-calc(100% - 10px);
				max-width: -moz-calc(100% - 10px);
				max-width: calc(100% - 10px);
			}
			.postarequest .create-request .form-group .gig-category .cat_item-content.item-active .gig-category-tags {
				-webkit-flex-basis: -webkit-calc(50% - 10px);
				-ms-flex-preferred-size: calc(50% - 10px);
				flex-basis: -moz-calc(50% - 10px);
				flex-basis: calc(50% - 10px);
				margin-bottom: 20px;
				height: auto;
				max-width: -webkit-calc(50% - 10px);
				max-width: -moz-calc(50% - 10px);
				max-width: calc(50% - 10px);
			}
			.postarequest .create-request .form-group .gig-category .cat_item-content.item-removed {
				display: none;
			}
			.postarequest .create-request .form-group .gig-category .cat_item-content.item-active .backto-main {
				display: -webkit-box;
				display: -webkit-flex;
				display: -moz-box;
				display: -ms-flexbox;
				display: flex;
			}
			#file_name span{
				width: 130px;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				display: inline-block;
			}
			/*.postarequest .create-request .form-group .gig-category .cat_item-content.item-active .gig-category-select {
			background-color: white;
			}*/
			.bootstrap-tagsinput.focus{
				border-color: #ff0707 !important;
			}
			@media(min-width: 767px){
				.page-height{
					position: relative;
					min-height: 60vh;
				}
			}
			@media(max-width: 768px){
				.gig-category-item{
					-webkit-flex-basis: -webkit-calc(100% - 0px) !important;
				-ms-flex-preferred-size: calc(100% - 0px) !important;
				flex-basis: -moz-calc(100% - 0px) !important;
				flex-basis: calc(100% - 0px) !important;
				max-width: -webkit-calc(100% - 0px) !important;
				max-width: -moz-calc(100% - 0px) !important;
				max-width: calc(100% - 0px) !important;
				}
				.gig-category-select{
					-webkit-flex-basis: -webkit-calc(100% - 0px);
				-ms-flex-preferred-size: calc(100% - 0px);
				flex-basis: -moz-calc(100% - 0px);
				flex-basis: calc(100% - 0px);
				max-width: -webkit-calc(100% - 0px);
				max-width: -moz-calc(100% - 0px);
				max-width: calc(100% - 0px);
				}
				.cat_item-content{
					-webkit-flex-basis: -webkit-calc(100% - 0px) !important;
				-ms-flex-preferred-size: calc(100% - 0px) !important;
				flex-basis: -moz-calc(100% - 0px) !important;
				flex-basis: calc(100% - 0px) !important;
				max-width: -webkit-calc(100% - 0px) !important;
				max-width: -moz-calc(100% - 0px) !important;
				max-width: calc(100% - 0px) !important;
				}
				.cat_item-content.item-active .gig-category-select {
				-webkit-flex-basis: -webkit-calc(100% - 0px);
				-ms-flex-preferred-size: calc(100% - 0px);
				flex-basis: -moz-calc(100% - 0px);
				flex-basis: calc(100% - 0px);
				max-width: -webkit-calc(100% - 0px);
				max-width: -moz-calc(100% - 0px);
				max-width: calc(100% - 0px);
				}
				.postarequest .create-request .form-group .gig-category .cat_item-content.item-active .gig-category-select {
				-webkit-flex-basis: -webkit-calc(100% - 0px);
				-ms-flex-preferred-size: calc(100% - 0px);
				flex-basis: -moz-calc(100% - 0px);
				flex-basis: calc(100% - 0px);
				max-width: -webkit-calc(100% - 0px);
				max-width: -moz-calc(100% - 0px);
				max-width: calc(100% - 0px);
				}
				.postarequest .create-request .form-group .gig-category .cat_item-content.item-active .gig-category-tags {
				-webkit-flex-basis: -webkit-calc(100% - 0px);
				-ms-flex-preferred-size: calc(100% - 0px);
				flex-basis: -moz-calc(100% - 0px);
				flex-basis: calc(100% - 0px);
				max-width: -webkit-calc(100% - 0px);
				max-width: -moz-calc(100% - 0px);
				max-width: calc(100% - 0px);
				}
			}
		</style>
	</head>
	<body class="all-content">
		<!-- Preloader Start -->
	<div class="proloader">
		<div class="loader">
			<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
		</div>
	</div>
	<!-- Preloader End -->
		<?php
		if(!isset($_SESSION['seller_user_name'])){
			require_once("../includes/header_with_categories.php");
		}else{
			require_once("../includes/buyer-header.php");
		}
		if($seller_verification != "ok" && isset($_SESSION['seller_user_name'])){
		echo "<main style='min-height:80%'>
		<div class='alert alert-danger rounded-0 mt-0 text-center'>
			Please confirm your email to use this feature.
		</div></main>
		";
		}else{
		?>
		<!-- Main content -->
		<main>
			<section class="container-fluid postarequest">
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<h2>Post Your Job For Free</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-lg-8">
								<div class="row">
									<div class="col-12 col-md-8">
										<!-- <?php 
										$form_errors = Flash::render("form_errors");
										$form_data = Flash::render("form_data");
										if(is_array($form_errors)){
										?>
										<div class="alert alert-danger">
										<ul>
											<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
											<li><?= $i ?>. <?= ucfirst($error); ?></li>
											<?php } ?>
										</ul>
										</div>
										<?php } ?> -->
										<form action="" class="create-request" method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/create-gig-icon.png" />
													</span>
													<span>title of your request</span>
												</label>
												<input type="text" name="request_title" placeholder="Request Title" class="form-control input-lg" value="<?= $form_data['request_title']; ?>">
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['request_title']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														Write the meaningful title of your job. The more specific you are, the more accurate of a job your freelancer can do for you.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/create-gig-icon.png" />
													</span>
													<span>Describe the service you’re looking to purchase</span>
												</label>

												<textarea class="form-control" name="request_description" id="textarea" placeholder="I’m looking for..." rows="5"><?= $form_data['request_description']; ?></textarea>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['request_description']); ?></span>
												<div id="file_name"></div>
												<div class="bottom-label d-flex flex-row align-items-center justify-content-between mt-15">
													<div class="attach-file d-flex flex-row align-items-center">
														<label for="file">
															<input type="file" id="file" name="request_file[]" hidden="" multiple="multiple">
															<span class="file d-flex flex-row align-items-center">
																<span><img src="<?= $site_url;?>/assets/img/post-request/attach.png" alt=""></span>
																<span>Attach File</span>
															</span>
														</label>
														<div id="file_name"></div>
														<span class="max-size">Max Size 30MB</span>
													</div>
													<span class="chars-max"><span class="descCount">0</span>/2500 Chars Max</span>
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														Describe everything you need in detail. The more specific you are, the more accurate of a job your freelancer can do for you.
													</p>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/category-icon.png" />
													</span>
													<span>Choose a category</span>
												</label>
												<div class="gig-category d-flex flex-wrap align-items-start">
													<?php 
														$get_cats = $db->select("categories");
														while($row_cats = $get_cats->fetch()){
														
														$cat_id = $row_cats->cat_id;
														$cat_icon = $row_cats->cat_icon;
														$get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
														$row_meta = $get_meta->fetch();
														$cat_title = $row_meta->cat_title;
														
													?>
													<!-- <label class="gig-category-item" for="categoryItem-<?= $cat_id; ?>"> -->
														
														<!-- <div class="backto-main flex-row">
															<a href="javascript:void(0)" class="d-flex flex-row align-items-center">
																<span>
																	<i class="fal fa-angle-left"></i>
																</span>
																<span>Go Back</span>
															</a>
														</div> -->
													<!-- </label> -->
													
													
													<div class="gig-category-item">
														<?php
															$get_cats = $db->select("categories");
															while($row_cats = $get_cats->fetch()){
															$cat_id = $row_cats->cat_id;
															$cat_image = $row_cats->cat_image;
															$cat_icon = $row_cats->cat_icon;

															$get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
															$row_meta = $get_meta->fetch();
															$cat_title = $row_meta->cat_title;

															if($cat_id == 1){
															$cat_class= "gd";
															}elseif ($cat_id == 2) {
																$cat_class = "dm";
															}elseif ($cat_id == 3) {
																$cat_class = "wt";
															}elseif ($cat_id == 4) {
																$cat_class = "va";
															}elseif ($cat_id == 7) {
																$cat_class = "ma";
															}elseif ($cat_id == 6) {
																$cat_class = "pt";
															}elseif($cat_id == 8){
																$cat_class= "va";
															}else{
																$cat_class= "ma";
															}
															?>
															<div class="cat_item-content" data-id="<?= $cat_class; ?>">
																<div class="gig-category-select <?php echo $cat_class; ?> d-flex flex-column align-items-center justify-content-between" onclick="categoryItem(<?= $cat_id; ?>);">
																	
																	<label for="categoryItem-<?= $cat_id; ?>" class="d-flex flex-column align-items-center justify-content-between">
											  <input id="categoryItem-<?= $cat_id; ?>" class="cat_value" value="<?= $cat_id; ?>" type="radio" name="cat_id" hidden />
											  <span class="icon">
												  <img class="img-fluid white-icon" src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" width="75" height="75" />
												  <img class="img-fluid color-icon" src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" width="75" height="75" />
											  </span>
											  <span class="text"><?= $cat_title; ?></span>
																	</label>
																</div>
															</div>
														<?php } ?>

														<!-- <select class="form-control" name="child_id" required="" style="display: none;">
															
														</select> -->
														<div class="gig-category-tags"  id="sub-category" style="display: none;">
															
														</div>
														<div class="backto-main flex-row">
															<a href="javascript:void(0)" class="d-flex flex-row align-items-center">
																<span>
																	<i class="fal fa-angle-left"></i>
																</span>
																<span>Go Back</span>
															</a>
														</div>
													</div>
												<?php } ?>
													<!-- <div class="gig-category-item">
															<div>
																<?php
																$get_cats = $db->select("categories");
																while($row_cats = $get_cats->fetch()){
																$cat_id = $row_cats->cat_id;
																$get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
																$row_meta = $get_meta->fetch();
																$cat_title = $row_meta->cat_title;
																?>
																<label for="<?= $cat_id; ?>">
																	<input id="<?= $cat_id; ?>" value="<?= $cat_id; ?>" type="radio" name="cat_id" hidden />
																	<div class="gig-category-select gd d-flex flex-column align-items-center justify-content-between">
																		<span class="icon">
																			<img class="img-fluid white-icon" src="<?= $site_url; ?>assets/img/post-a-gig/graphic-design-white.png" />
																			<img class="img-fluid color-icon" src="assets/img/post-a-gig/graphic-design-color.png" />
																		</span>
																		<span class="text"><?= $cat_title; ?></span>
																	</div>
																  </label>
																	<?php } ?>
																							</div>
																					<div class="gig-category-tags gd">
																						<label class="gig-category-tag" for="cat1">
																							<input type="radio" name="cat" id="cat1"> Logo
																						</label>
																						<label class="gig-category-tag" for="cat2">
																							<input type="radio" name="cat" id="cat2"> Logo
																						</label>
															  <a class="gig-category-tag" href="javascript:void(0);">Logos</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															  <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
															</div>
															<div class="backto-main flex-row">
																<a href="javascript:void(0)" class="d-flex flex-row align-items-center">
																	<span>
																		<i class="fal fa-angle-left"></i>
																	</span>
																	<span>Go Back</span>
																</a>
															</div>
														</div> -->
													<!-- Each item -->
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['cat_id']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														Selecting the appropriate category will help the correct freelancers find your project requirements.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/passage-of-time.png" />
													</span>
													<span>when do you want the work delivered ?</span>
												</label>
												<div class="deliver-time d-flex flex-wrap">
													<?php
														$get_delivery_times = $db->select("delivery_times");
														while($row_delivery_times = $get_delivery_times->fetch()){
														$delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
														$delivery_id = $row_delivery_times->delivery_id;
													?>
													<label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
														<input id="hours<?= $delivery_id; ?>" type="radio" name="delivery_time" value="<?= $delivery_proposal_title; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title){ echo "checked"; } ?> hidden />
														<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
															<span class="color-icon">
																<span>-</span>
																<span>+</span>
															</span>
															<span class="d-flex flex-row align-items-end time">
																<span><?= $delivery_proposal_title; ?></span>
																<!-- <span>HRS</span> -->
															</span>
														</div>
													</label>
													<?php } ?>
													<label class="deliver-time-item" for="days30">
														<input id="days30" type="radio" name="delivery_time" hidden />
														<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
															<span class="color-icon">
																<span>-</span>
																<span>+</span>
															</span>
															<span class="d-flex flex-row align-items-end time">
																<span>Custom</span>
																<input autofocus="autofocus" class="input-number" maxlength="2" type="text" pattern="[0-9]{2}" />
															</span>
														</div>
													</label>
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['delivery_time']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														Never sacrifice quality for a rushed delivery. Try to give your freelancer the appropriate time necessary to deliver quality work.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-request/icon-4.png" />
													</span>
													<span>What skills are required?</span>
												</label>
												<div class="postarequest-tags">
													<input type="text" name="skills_required" data-role="tagsinput" value="">
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['skills_required']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>List all skills that are relevant for your work to be completed. The more specific and detailed you can go, the higher chance you will attract the right talent for your work</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-request/icon-5.png" />
													</span>
													<span>Languages</span>
												</label>
												<div class="postarequest-tags">
													<input type="text" name="languages" data-role="tagsinput" value="">
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['languages']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>List all languages required for the work to be completed. Being transparent about the professional language required allows for successful completion of your work</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/price-icon.png" />
													</span>
													<span>For How much?</span>
												</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<select class="form-control">
															<option value="1">USD</option>
															<option value="2">EGP</option>
														</select>
													</div>
													<input class="form-control" type="number" name="request_budget" value="<?= $form_data['request_budget']; ?>" />
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['request_budget']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														Setting the appropriate budget for your project will allow freelancers to see how much you are willing to spend on your project.
													</p>
												</div>
											</div>

											<!-- Registration Process -->
											<?php if(!isset($_SESSION['seller_user_name'])){ ?>
											<!-- Register Form -->
											<div class="post-register-form register-form" style="display: none;">
												

												<h4>Signup as Buyer</h4>
												<!-- <div class="form-group">
													<label class="control-label"><span>Full Name</span></label>
													<input class="form-control" type="text" name="name" placeholder="Enter Your Full Name" value="" />
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['name']); ?></span>
												</div> -->
												<div class="form-group">
													<label class="control-label"><span>Username</span></label>
													<input class="form-control" type="text" name="u_name" placeholder="Enter Your Username" value="" />
													<small class="form-text text-muted">Note: You will not be able to change username once your account has been created.</small>
													<?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
													<?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
													<?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['u_name']); ?></span>
												</div>
												<div class="form-group">
													<label class="control-label"><span>YOUR EMAIL ADDRESS</span></label>
													<input class="form-control" type="email" name="email" placeholder="Enter Email" value="">
										<?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
										<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['email']); ?></span>
												</div>
												<div class="form-group">
													<label class="control-label"><span>Password</span></label>
													<input class="form-control" type="password" name="pass" placeholder="Enter Password"/>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['pass']); ?></span>
												</div>
												<p>Already have an account? <a href="javascript:void(0);" id="showLogin">Log In</a></p>
											</div>
											<!-- Login Form -->
											<div class="post-register-form login-form">
												<?php 

												$form_errors = Flash::render("login_errors");
												$form_data = Flash::render("form_data");
												if(is_array($form_errors)){

												?>

												<div class="alert alert-danger"><!--- alert alert-danger Starts --->

												<ul class="list-unstyled mb-0">
												<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
												<li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
												<?php } ?>
												</ul>

												</div><!--- alert alert-danger Ends --->
												<?php } ?>
												<h4>Signin as Buyer</h4>
												<div class="form-group">
													<label class="control-label"><span>Username or Email</span></label>
													<input class="form-control" type="text" placeholder="Enter Username or email"  name="seller_user_name" value= "<?php if(isset($_SESSION['seller_user_name'])) echo $_SESSION['seller_user_name']; ?>"/>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['seller_user_name']); ?></span>
												</div>
												<div class="form-group">
													<label class="control-label"><span>Password</span></label>
													<input class="form-control" type="password" name="seller_pass" placeholder="Enter Password"/>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['seller_pass']); ?></span>
												</div>
												<p>Don't have an account? <a href="javascript:void(0);" id="showRegister">Sign Up</a></p>
											</div>
											<!-- End Login Form -->
											<?php } ?>
											<!-- End Registration Process -->

											<div class="form-group mb-0">
												<button class="button" role="button" type="submit" name="submit">Post</button>
											</div>
										</form>
									</div>
									<div class="col-12 col-md-4" id="popupWidth"></div>
								</div>
							</div>
							<div class="col-12 col-lg-4">
								<div class="howitwork-card">
									<div class="howitwork-card-title d-flex align-items-center">How it Works</div>
									<div class="howitwork-list d-flex flex-column">
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/find.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>1. Discover</h3>
												<p>Share your project on our platform to be connected with professional freelancers ready to build something great for you.</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/gethired.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>2. Hire</h3>
												<p>Review expert credentials from dozens of freelancers. Have the power to select the most qualified seller that matches the requirements of your project.</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Work" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/work.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>3. Work</h3>
												<p>Communicate and lay the foundation for a successful collaboration. Share ideas, approve outlines, send files, and manage the entire project from our easy-to-use platform.</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/getpaid.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>4. Pay</h3>
												<p>Once you have found the perfect freelancer for your project, send the payment through our safe and secure payment portal. Enjoy peace of mind with a 100% money back guarantee.</p>
											</div>
										</div>
										<!-- How it work each item -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		<!-- Main content end -->
<?php } ?>
<script>
		$(function(){
			$(window).on('load resize', function(){
				var popupWidth = $('#popupWidth').outerWidth();
				$('.popup').css({
					'width': popupWidth + 30 + 'px'
				});
			});
			$('.gig-category-select').on('click', function(){
				$('.cat_item-content').addClass('item-removed');
				$('.gig-category-item').addClass('item-removed');
				$(this).parents('.cat_item-content').removeClass('item-removed');
				$(this).parents('.cat_item-content').addClass('item-active');
				$(this).parents('.gig-category-item').removeClass('item-removed');
				$(this).parents('.gig-category-item').addClass('item-active');
			});
			$('.gig-category-tag').on('click', function(){
				$(this).toggleClass('tag-selected');
			});
			$('.backto-main').on('click', function(){
				$('.gig-category-item').removeClass('item-active');
				$('.gig-category-item').removeClass('item-removed');
				$('.cat_item-content').removeClass('item-active');
				$('.cat_item-content').removeClass('item-removed');
				$('.gig-category-tag').removeClass('tag-selected');
				$('.gig-category-item').find('input[type="radio"]').prop('checked', false);
			});
			$('.deliver-time-item[for="days30"]').on('click', function(){
				$('.input-number').focus();
			});
			$(".gig-category-select").on('click', function(){
				var cat_class = $(this).parents('.cat_item-content').attr("data-id");
					$(".gig-category-tags").removeAttr('class').addClass('gig-category-tags '+cat_class);
					// $('.gig-category-tags').addClass(cat_class);
			});
		});
	</script>
<script>
$(document).ready(function(){
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");

	$('.container-fluid').hover(function(){
	$('.h-1').css("visibility", "visible");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-1').mouseover(function(){
	$('.h-1').css("visibility", "visible");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-2').mouseover(function(){
	$('.h-1').css("visibility", "hidden");
	$('.h-2').css("visibility", "visible");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-3').mouseover(function(){
	$('.h-1').css("visibility", "hidden");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "visible");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-4').mouseover(function(){
	$('.h-1').css("visibility", "hidden");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "visible");
	});

	$('.row-2,.row-3,.row-4').mouseout(function(){
	$('.h-1').css("visibility", "visible");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$("#textarea").keydown(function(){
	var textarea = $("#textarea").val();
	$(".descCount").text(textarea.length);	
	});	


	$(".input-number").keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        $("#errmsg").html("Digits Only").show().fadeOut("slow");
	               return false;
	    }
	   });

	// $("#sub-category").hide();
	$(".gig-category-tags  .nice-select.form-control").remove();

	
	$("#sub-category").hide();

	// $("#category").click(function(){
	// 	$("#sub-category").show();	
	// 	var category_id = $(".cat_value").val();
	// 	alert(category_id);
	// 	$.ajax({
	// 	url:"fetch_subcategory",
	// 	method:"POST",
	// 	data:{category_id:category_id},
	// 	success:function(data){
	// 	$("#sub-category").html(data);
	// 	}
	// 	});
	// });

	// $('#file').change(function() {

	//   var i = $(this).prev('label').clone();
	//   var file = $('#file')[0].files[0].name;
	  
	//   $('#file_name').html('<span>'+file+'</span>');
	  // $(this).prev('label').text(file);
	// });
	// $('#file').bind('change', function() {
	//   var totalSize = this.files[0].size;
	//   var totalSizeMb = totalSize  / Math.pow(1024,2);
  
	//   $('.max-size').text(totalSizeMb.toFixed(2) + " MB");
	// });

	$('#file').on('change', function() {
	    var input = document.getElementById('file');
	    var output = document.getElementById('file_name');
	    var children = "";
	    var totalSizeMb = 0;
	    for (var i = 0; i < input.files.length; ++i) {
	        children += '<li>' + input.files.item(i).name + '</li>';
	        var totalSize = input.files[i].size;

	        var totalSizeMb = totalSize  / Math.pow(1024,2);
	        
	    }
	    totalSizeMb += totalSizeMb;
	    output.innerHTML = '<ul>'+children+'</ul>';
      $('.max-size').text(totalSizeMb.toFixed(2) + " MB");
			// if(totalSizeMb > 30){
			// 	alert("File size must not be more than 30 MB")
			// }
	});



	$('.input-number').keyup(function(){
		var custom_btn = $('.input-number').val();
		$('#days30').val(custom_btn);
	});


});
	function categoryItem(id){
		$("#sub-category").show();	
		var category_id =  id;
		$.ajax({
		url:"fetch_subcategory",
		method:"POST",
		data:{category_id:category_id},

		success:function(data){
			console.log(data);
		$("#sub-category").html(data);
		}
		});
	}

$('#showLogin').click(function(){
	$('.register-form').hide();
	$('.login-form').show();
});
$('#showRegister').click(function(){
	$('.register-form').show();
	$('.login-form').hide();
});
</script>
<?php
if(isset($_POST['submit'])){

	if(!isset($_SESSION['seller_user_name'])){

		$seller_user_name = $input->post('seller_user_name');
		$seller_pass = $input->post('seller_pass');

		$count_seller = $db->count("sellers", array("seller_user_name"=>$seller_user_name));

		if($count_seller == 1){

				$rules = array(
				"seller_user_name" => "required",
				"seller_pass" => "required"
				);
				$messages = array("seller_user_name" => "Username or email Is Required.","seller_pass" => "Password Is Required.");

				$val = new Validator($_POST,$rules,$messages);

				if($val->run() == false){
					Flash::add("form_errors",$val->get_all_errors());
					Flash::add("form_data",$_POST);
					echo "<script>window.open('index','_self')</script>";
				}else{

					$seller_user_name = $input->post('seller_user_name');
					$seller_pass = $input->post('seller_pass');
					// $select_seller = $db->query("select * from sellers where binary seller_user_name like :u_name",array(":u_name"=>$seller_user_name));
					$select_seller = $db->query("select * from sellers where (seller_user_name = '".$seller_user_name."' OR seller_email = '".$seller_user_name."')");
					$row_seller = $select_seller->fetch();
					@$user_name = $row_seller->seller_user_name;
					@$hashed_password = $row_seller->seller_pass;
					@$seller_status = $row_seller->seller_status;
					$decrypt_password = password_verify($seller_pass, $hashed_password);
					
					if($decrypt_password == 0){
						echo "
						<script>
					swal({
					  type: 'warning',
					  html: $('<div>')
						.text('Opps! password or username is incorrect. Please try again.'),
					  animation: false,
					  customClass: 'animated tada'
					})
					</script>
						";
					}else{
						if($seller_status == "block-ban"){
							echo "
							<script>
								swal({
								  type: 'warning',
								  html: $('<div>')
									.text('You have been blocked by the Admin. Please contact customer support.'),
								  animation: false,
								  customClass: 'animated tada'
								})
							</script>";
						}elseif($seller_status == "deactivated"){
							echo "
							<script>
							swal({
							  type: 'warning',
							  html: $('<div>').text('You have deactivated your account, please contact us for more details.'),
							  animation: false,
							  customClass: 'animated tada'
							})
							</script>";
						}else{
							$select_seller = $db->select("sellers",array("seller_user_name"=>$user_name,"seller_pass"=>$hashed_password));
							if($select_seller){
								$row_seller = $select_seller->fetch();
							$_SESSION['seller_user_name'] = $user_name;
							$login_seller_id = $row_seller->seller_id;


							if(isset($_SESSION['seller_user_name']) and $_SESSION['seller_user_name'] === $user_name){
									$update_seller_status = $db->update("sellers",array("seller_status"=>'online',"seller_ip"=>$ip),array("seller_user_name"=>$seller_user_name,"seller_pass"=>$hashed_password));
							  $seller_user_name = ucfirst(strtolower($seller_user_name));
									$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

									
						  $rules = array(
							"request_title" => "required",
							"request_description" => "required",
							"cat_id" => "required",
							"request_budget" => "number|required",
							
							"skills_required" => "required",
							"languages" => "required");
							$messages = array("cat_id" => "please select a category and sub category","request_title" => "please enter request title", "request_description" => "please enter description", "request_budget" => "please enter budget amount", "delivery_time" => "please select delivery time", "skills_required" => "please enter required skills", "languages" => "please enter languages");
						  $val = new Validator($_POST,$rules,$messages);
						  if($val->run() == false){
							Flash::add("form_errors",$val->get_all_errors());
							Flash::add("form_data",$_POST);
							echo "<script> window.open('post-request','_self');</script>";
						  }else{
							$request_title = $input->post('request_title');
							$request_description = $input->post('request_description');
							$cat_id = $input->post('cat_id');
							$child_id = $input->post('child_id');
							$request_budget = $input->post('request_budget');
							$delivery_time = $input->post('delivery_time');

							echo "You have selected :" .$delivery_time;
							$skills_required = $input->post('skills_required');
							$languages = $input->post('languages');
							// $request_file = $_FILES['request_file']['name'];
							
							$countfiles = count($_FILES['request_file']['name']);


							
							$request_filee = array();
							for($i=0;$i<$countfiles;$i++){

								$request_filee[] = $_FILES['request_file']['name'][$i];
								// $request_file_tmp = $_FILES['request_file']['tmp_name'][$i];
								
								// $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
								// $file_extension = pathinfo($request_file, PATHINFO_EXTENSION);
								// if(!empty($request_file)){
								// 	if(!in_array($file_extension,$allowed)){
								// 		echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
								// 		echo "<script>window.open('post-request','_self')</script>";
								// 		exit();
								// 	}
								// 	$request_file = pathinfo($request_file, PATHINFO_FILENAME);
								// 	$request_file = $request_file."_".time().".$file_extension";
									move_uploaded_file($_FILES['request_file']['tmp_name'][$i],"request_files/$request_file");
								}
							// }
								$request_file = implode("," , $request_filee);
								
							$request_date = date("F d, Y");
							$insert_request = $db->insert("buyer_requests",array("seller_id"=>$login_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
							if($insert_request){
								echo "<script>
									swal({
									  type: 'success',
									  text: 'Your request has been submitted successfully!',
									  timer: 3000,
									  onOpen: function(){
										swal.showLoading()
									  }
									}).then(function(){
										window.open('$site_url','_self');
									});
								</script>";
							}
						  }
						}
							}
						}
				  }
						
				}

	 	} //elseif($count_seller == 0){

	// 		echo "
	// 					<script>
	// 				swal({
	// 				  type: 'warning',
	// 				  html: $('<div>')
	// 					.text('Opps! password or username is incorrect. Please try again.'),
	// 				  animation: false,
	// 				  customClass: 'animated tada'
	// 				})
	// 				$('.proloader').hide();
	// 				$('.register-form').show();
	// 				$('.login-form').hide();
	// 				</script>
	// 					";
	// }
	 		else {
				$rules = array(
				"u_name" => "required",
				"email" => "email|required",
				"pass" => "required",
				"request_title" => "required",
			  "request_description" => "required",
			  "cat_id" => "required",
			  "request_budget" => "number|required",
				
				"skills_required" => "required",
				"languages" => "required");

				$messages = array("name" => "Full Name Is Required.","u_name" => "User Name Is Required.","pass" => "Password Is Required.", "email" => "Email is Required.","cat_id" => "please select a category and sub category","request_title" => "please enter request title", "request_description" => "please enter description", "request_budget" => "please enter budget amount", "delivery_time" => "please select delivery time", "skills_required" => "please enter required skills", "languages" => "please enter languages");
				$val = new Validator($_POST,$rules,$messages);

				if($val->run() == false){
					$_SESSION['error_array'] = array();
					Flash::add("form_errors",$val->get_all_errors());
					Flash::add("form_data",$_POST);
					echo "<script>window.open('post-request','_self')</script>";
				}else{
					$error_array = array();
					$name = strip_tags($input->post('name'));
					$name = strip_tags($name);
					$name = ucfirst(strtolower($name));
					$_SESSION['name']= $name;
					$u_name = strip_tags($input->post('u_name'));
					$u_name = strip_tags($u_name);
					$_SESSION['u_name']= $u_name;
					$email = strip_tags($input->post('email'));
					$email = strip_tags($email);
					$_SESSION['email']=$email;
					$pass = strip_tags($input->post('pass'));
					$accountType = 'buyer';

					$country = '';
					$regsiter_date = date("F d, Y");
					$date = date("F d, Y");

					
					$check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
					$check_seller_email = $db->count("sellers",array("seller_email" => $email));
					if(preg_match('/[اأإء-ي]/ui', $input->post('u_name'))){
					  array_push($error_array, "Foreign characters are not allowed in username, Please try another one.");
					}
					if($check_seller_username > 0 ){
					  array_push($error_array, "Opps! This username has already been taken. Please try another one");
					}
					if($check_seller_email > 0){
					  array_push($error_array, "Email has already been taken. Try logging in instead.");
					}

					if(empty($error_array)){
						$referral_code = mt_rand();

						if($signup_email == "yes"){
							$verification_code = mt_rand();
						}else{
							$verification_code = "ok";
						}

						$encrypted_password = password_hash($pass, PASSWORD_DEFAULT);
						
						$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_pass" => $encrypted_password,"account_type" => $accountType,"seller_country"=>$country,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online'));
								
						$regsiter_seller_id = $db->lastInsertId();
						
						if($insert_seller){
							
						$_SESSION['seller_user_name'] = $u_name;
							$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));

							if($insert_seller_account){

								if(!empty($referral)){
								$sel_seller = $db->select("sellers",array("seller_referral" => $referral));		
									$row_seller = $sel_seller->fetch();
									$seller_id = $row_seller->seller_id;	
									$seller_ip = $row_seller->seller_ip;
									if($seller_ip == $ip){
										echo "<script>alert('You Cannot Referral Yourself To Make Money.');</script>";
									}else{
										$count_referrals = $db->count("referrals",array("ip" => $ip));	
										if($count_referrals == 1){
										echo "<script>alert('You are trying to referral yourself more then one time.');</script>";
										}else{
											$insert_referral = $db->insert("referrals",array("seller_id" => $seller_id,"referred_id" => $regsiter_seller_id,"comission" => $referral_money,"date" => $date,"ip" => $ip,"status" => 'pending'));
										}
									}	
								}

								if($signup_email == "yes"){
									userSignupEmail($email);
							  }

								$rules = array(
								"request_title" => "required",
							  "request_description" => "required",
							  "cat_id" => "required",
							  "request_budget" => "number|required",
								
								"skills_required" => "required",
								"languages" => "required");
							  $messages = array("cat_id" => "please select a category and sub category","request_title" => "please enter request title", "request_description" => "please enter description", "request_budget" => "please enter budget amount", "delivery_time" => "please select delivery time", "skills_required" => "please enter required skills", "languages" => "please enter languages");
								$val = new Validator($_POST,$rules,$messages);
								if($val->run() == false){
									Flash::add("form_errors",$val->get_all_errors());
									Flash::add("form_data",$_POST);
									echo "<script> window.open('post-request','_self');</script>";
								}else{
									$request_title = $input->post('request_title');
									$request_description = $input->post('request_description');
									$cat_id = $input->post('cat_id');
									$child_id = $input->post('child_id');
									$request_budget = $input->post('request_budget');
									$delivery_time = $input->post('delivery_time');

									echo "You have selected :" .$delivery_time;
									$skills_required = $input->post('skills_required');
									$languages = $input->post('languages');
									// $request_file = $_FILES['request_file']['name'];
									
									$countfiles = count($_FILES['request_file']['name']);
									
									$request_filee = array();
									for($i=0;$i<$countfiles;$i++){

										$request_filee[] = $_FILES['request_file']['name'][$i];
										// $request_file_tmp = $_FILES['request_file']['tmp_name'][$i];
										
										// $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
										// $file_extension = pathinfo($request_file, PATHINFO_EXTENSION);
										// if(!empty($request_file)){
										// 	if(!in_array($file_extension,$allowed)){
										// 		echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
										// 		echo "<script>window.open('post-request','_self')</script>";
										// 		exit();
										// 	}
										// 	$request_file = pathinfo($request_file, PATHINFO_FILENAME);
										// 	$request_file = $request_file."_".time().".$file_extension";
											move_uploaded_file($_FILES['request_file']['tmp_name'][$i],"request_files/$request_file");
										}
									// }
										$request_file = implode("," , $request_filee);

									$request_date = date("F d, Y");
									$insert_request = $db->insert("buyer_requests",array("seller_id"=>$regsiter_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
									if($insert_request){
										echo "<script>
											swal({
											  type: 'success',
											  text: 'Your request has been submitted successfully!',
											  timer: 3000,
											  onOpen: function(){
												swal.showLoading()
											  }
											}).then(function(){
												window.open('$site_url','_self');
											});
										</script>";
									}
								}
									
							}
								
						}
					}
					if(!empty($error_array)){
						$_SESSION['error_array'] = $error_array;
						echo "
						<script>
						swal({
						type: 'error',
						html: $('<div>').text('Opps! There are some errors on the form. Please try again.'),
						animation: false,
						customClass: 'animated tada'
						}).then(function(){
						window.open('post-request.php','_self')
						});
						</script>";
					}
				}
			}


	}else{
		$rules = array(
	  "request_title" => "required",
	  "request_description" => "required",
	  "cat_id" => "required",
	  "request_budget" => "number|required",
		
		"skills_required" => "required",
		"languages" => "required");
	  $messages = array("cat_id" => "please select a category and sub category","request_title" => "please enter request title", "request_description" => "please enter description", "request_budget" => "please enter budget amount", "delivery_time" => "please select delivery time", "skills_required" => "please enter required skills", "languages" => "please enter languages");
		$val = new Validator($_POST,$rules,$messages);
		if($val->run() == false){
			Flash::add("form_errors",$val->get_all_errors());
			Flash::add("form_data",$_POST);
			echo "<script> window.open('post-request','_self');</script>";
		}else{
			$request_title = $input->post('request_title');
			$request_description = $input->post('request_description');
			$cat_id = $input->post('cat_id');
			$child_id = $input->post('child_id');
			$request_budget = $input->post('request_budget');
			$delivery_time = $input->post('delivery_time');

			echo "You have selected :" .$delivery_time;
			$skills_required = $input->post('skills_required');
			$languages = $input->post('languages');
			// $request_file = $_FILES['request_file']['name'];
			// $request_file_tmp = $_FILES['request_file']['tmp_name'];
			$request_date = date("F d, Y");
			// $request_file = $_FILES['request_file']['name'];
												
			$countfiles = count($_FILES['request_file']['name']);
			
			// print_r("total file" .$countfiles);die("die at line 1225 ");

			$request_filee = array();
			for($i=0;$i<$countfiles;$i++){

				$request_filee[] = $_FILES['request_file']['name'][$i];
				// $request_file_tmp = $_FILES['request_file']['tmp_name'][$i];
				
				// $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
				// $file_extension = pathinfo($request_file, PATHINFO_EXTENSION);
				// if(!empty($request_file)){
				// 	if(!in_array($file_extension,$allowed)){
				// 		echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
				// 		echo "<script>window.open('post-request','_self')</script>";
				// 		exit();
				// 	}
				// 	$request_file = pathinfo($request_file, PATHINFO_FILENAME);
				// 	$request_file = $request_file."_".time().".$file_extension";
					move_uploaded_file($_FILES['request_file']['tmp_name'][$i],"request_files/$request_file");
				}
			// }
				$request_file = implode("," , $request_filee);
				// var_dump($request_file); die();


			$insert_request = $db->insert("buyer_requests",array("seller_id"=>$login_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
			if($insert_request){
				echo "<script>
					swal({
					  type: 'success',
					  text: 'Your request has been submitted successfully!',
					  timer: 3000,
					  onOpen: function(){
						swal.showLoading()
					  }
					}).then(function(){
						window.open('manage_requests.php','_self');
					});
				</script>";
			}
		}
	}
}
?>
<?php require_once("../includes/footer.php"); ?>
<?php require_once("../includes/footerJs.php"); ?>

</body>
</html>