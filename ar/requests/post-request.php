<?php
session_start([
    'cookie_lifetime' => 86400,
  ]);
require_once("../includes/db.php");
// if(!isset($_SESSION['seller_user_name'])){
// echo "<script>window.open('../login','_self')</script>";
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
<html dir="rtl" lang="ar" class="ui-toolkit">
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
		<link href="<?= $site_url; ?>/ar/assets/css/tagsinput.css" rel="stylesheet">
		<!--====== Default css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
		<!--====== Style css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
		<!--====== Responsive css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
		<!-- <link href="../styles/bootstrap.css" rel="stylesheet">
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
		<link href="<?= $site_url; ?>/assets/css/select2.min.css" rel="stylesheet" />
		<style>
			.gig-category .nice-select:nth-Child(2){
				display: none;
			}
			#category{
				display: block !important;
				width: 47%;
				margin-left: 8px;
			}
			.post-register-form h4, .post-register-form p{
				padding-right: 30px;
			}
			.post-register-form span{
				padding-right: 0 !important;
			}
			.post-register-form .form-group{
				border-bottom: 0 !important;
				margin-bottom: 0 !important;
			}
			.nice-select.swal2-select{
				display: none;
			}
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
		    direction: rtl;
			}
			.bootstrap-tagsinput.focus{
				border-color: #ff0707 !important;
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
			  left: 35px;
			  content: "✔";
			}
			/* Add a red text color and an "x" when the requirements are wrong */
			.invalid {
			  color: red;
			}
			.invalid:before {
			  position: relative;
			  left: 35px;
			  content: "✖";
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
			يرجى تأكيد بريدك الإلكتروني لاستخدام هذه الميزة.
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
								<h2>انشر إعلان الوظيفة بتاعتك مجانًا</h2>
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
													<span>عنوان طلبك</span>
												</label>
												<input type="text" name="request_title" placeholder="طلب عنوان...." class="form-control input-lg" value="<?= $form_data['request_title']; ?>">
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['request_title']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														اكتب عنوان عملك. كلما كنت أكثر تحديدًا ، كلما كان العمل الذي يمكن أن يقوم به صاحب العمل المستقل لك أكثر دقة.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/create-gig-icon.png" />
													</span>
													<span>اوصف الخدمة اللي عايز تشتريها</span>
												</label>

												<textarea class="form-control" name="request_description" id="textarea" placeholder="أنا بدور على...." rows="5"><?= $form_data['request_description']; ?></textarea>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['request_description']); ?></span>
												<div id="file_name"></div>
												<div class="bottom-label d-flex flex-row align-items-center justify-content-between mt-15">
													<div class="attach-file d-flex flex-row align-items-center">
														<label for="file">
															<input type="file" id="file" name="request_file[]" hidden="" multiple="multiple">
															<span class="file d-flex flex-row align-items-center">
																<span><img src="<?= $site_url;?>/assets/img/post-request/attach.png" alt=""></span>
																<span>أرفق ملف</span>
															</span>
														</label>
														<span class="max-size">بحد اقصي 30 ميجا</span>
													</div>
													<span class="chars-max"><span class="descCount">0</span>\2500 حرف بحد أقصى</span>
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														خلي كل الناس في مجتمع موقع منجز يعرفوا عن مشروعك. اوصف كل حاجة محتاجها بالتفصيل عشان كل ما تكون دقيق كل ما تكون الوظيفة اللي عايز الفريلانسر يعملهالك دقيقة أكتر.
													</p>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/category-icon.png" />
													</span>
													<span>اختار فئة</span>
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
														$arabic_title = $row_meta->arabic_title;
													?>
													<!-- <label class="gig-category-item" for="categoryItem-<?= $cat_id; ?>"> -->
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
																$arabic_title = $row_meta->arabic_title;

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
						                          <span class="text"><?= $arabic_title; ?></span>
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
															        <span>عد</span>
															    </a>
															</div>
														</div>
													<?php } ?>
														
														<!-- <div class="backto-main flex-row">
															<a href="javascript:void(0)" class="d-flex flex-row align-items-center">
																<span>
																	<i class="fal fa-angle-left"></i>
																</span>
																<span>Go Back</span>
															</a>
														</div> -->
													<!-- </label> -->
													<!-- Each item -->
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['cat_id']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														حسِّن طلبك و اختار الفئة الرئيسية و الفرعية المناسبة لمشروعك. اختيرارك للفئة المناسبة هيساعد الفريلانسرز يلاقوا مشروعك.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/passage-of-time.png" />
													</span>
													<span>عايز تستلم الخدمة امتى؟</span>
												</label>
												<div class="deliver-time d-flex flex-wrap">
													<?php
														$get_delivery_times = $db->select("delivery_times");
														while($row_delivery_times = $get_delivery_times->fetch()){
														$delivery_proposal_title_arabic = $row_delivery_times->delivery_proposal_title_arabic;
														$delivery_id = $row_delivery_times->delivery_id;
													?>
													<label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
														<input id="hours<?= $delivery_id; ?>" type="radio" name="delivery_time" value="<?= $delivery_proposal_title; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title_arabic){ echo "checked"; } ?> hidden />
														<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
															<span class="color-icon">
																<span>-</span>
																<span>+</span>
															</span>
															<span class="d-flex flex-row align-items-end time">
																<span><?= $delivery_proposal_title_arabic; ?></span>
																<!-- <span>HRS</span> -->
															</span>
														</div>
													</label>
													<?php } ?>
													<label class="deliver-time-item" id="custom_time_label" for="days30">
														<input id="days30" type="radio" name="delivery_time" hidden />
														<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
															<span class="color-icon">
																<span>-</span>
																<span>+</span>
															</span>
															<span class="d-flex flex-row align-items-end time">
																<span>مخصص</span>
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
														ميعاد التسليم اللي انت محتاج مشروعك يخلص فيه. دة هيديك انت و الفريلانسر ميعاد تسليم دقيق تشتغلوا على أساسه. من الأمور المتاحة هو طلب التسليم السريع للمشاريع اللي بتحتاج تتسلم في وقت أسرع.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-request/icon-4.png" />
													</span>
													<span>ايه هي المهارات المطلوبة ؟</span>
												</label>
												<div class="postarequest-tags">
													<!-- <input type="text" name="skills_required" data-role="tagsinput" value=""> -->
													<select class="wide form-control language js-example-basic-multiple" multiple name="skills_required[]" required="">
													  <option value=""> Select Skill </option>
													  <?php 
													    $get_seller_skills = $db->select("seller_skills");
													    while($row_seller_skills = $get_seller_skills->fetch()){
													    $skill_id = $row_seller_skills->skill_id;
													    $skill_title = $row_seller_skills->skill_title;
													  ?>
													  <option value="<?php echo $skill_title; ?>"> <?php echo $skill_title; ?> </option>
													<?php } ?>
													</select>
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['skills_required']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>حط كل المهارات اللى ليها علاقة بشغلك علشان تخلص ، كل ما كنت دقيق ومحدد كل ما زادت فرصتك فى انك تجذب الموهبة المناسبة لشغلك</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-request/icon-5.png" />
													</span>
													<span>اللغات</span>
												</label>
												<div class="postarequest-tags">
													<!-- <input type="text" name="languages" data-role="tagsinput" value=""> -->
													<select name="languages[]" class="form-control wide language js-example-basic-multiple" multiple>
													  <option class="hidden"> Select Language </option>
													  <?php 
													    $get_languages = $db->select("seller_languages");
													    while($row_languages = $get_languages->fetch()){
													    $language_id = $row_languages->language_id;
													    $language_title = $row_languages->language_title;
													    ?>
													  <option value="<?php echo $language_title; ?>"> <?php echo $language_title; ?> </option>
													  <?php } ?>
													</select>
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['languages']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>حط كل متطلبات اللغة المطلوبة علشان الشغل يخلص. لما تبقا شفاف بخصوص اللغة الاحترافية المطلوبة دة بيسمح لشغلك انه يخلص بنجاح</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/price-icon.png" />
													</span>
													<span>ايه هي ميزانيتك ؟</span>&nbsp; <small>(الرجاء إدخال المبلغ EGP)</small>
												</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<select class="form-control">
															<option value="2">EGP</option>
															<!-- <option value="1">USD</option> -->
														</select>
													</div>
													<input class="form-control" type="number" name="request_budget" value="<?= $form_data['request_budget']; ?>" />
												</div>
												<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['request_budget']); ?></span>
												<div class="popup">
													<img alt="" class="lamp-icon" src="assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														تحديد ميزانية كويسة للمشروع بتاعك هيسمح للفريلانسرز يشوفوا انت ناوي تصرف قد ايه عالمشروع و دة بيدعم الخبرة سواء للمشتري أو مقدم الخدمة
													</p>
												</div>
											</div>
											<!-- Registration Process -->
											<?php if(!isset($_SESSION['seller_user_name'])){ ?>
											<!-- Register Form -->
											<div class="post-register-form register-form" style="display: none;">
												

												<h4>الاشتراك كمشتري</h4>
												<!-- <div class="form-group">
													<label class="control-label"><span>الاسم الكامل</span></label>
													<input class="form-control" type="text" name="name" placeholder="أدخل اسمك الكامل" value="" />
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['name']); ?></span>
												</div> -->
												<div class="form-group">
													<label class="control-label"><span>اسم المستخدم</span></label>
													<input class="form-control" type="text" name="u_name" placeholder="أدخل اسم المستخدم الخاص بك" value="" />
													<small class="form-text text-muted">ملاحظة: لن تتمكن من تغيير اسم المستخدم بمجرد إنشاء حسابك.</small>
													<?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
													<?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
													<?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['u_name']); ?></span>
												</div>
												<div class="form-group">
													<label class="control-label"><span>عنوان بريدك الإلكتروني</span></label>
													<input class="form-control" type="email" name="email" placeholder="أدخل البريد الإلكتروني" value="">
				            			<?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
				            			<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['email']); ?></span>
												</div>
												<div class="form-group">
													<label class="control-label"><span>الباسوورد</span></label>
													<input class="form-control" type="password" name="pass" id="psw" placeholder="Enter Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن يحتوي على رقم واحد على الأقل وحرف واحد كبير وحرف صغير ، وعلى الأقل 8 أحرف أو أكثر" />
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['pass']); ?></span>
												</div>
												<div id="message">
												  <!-- <h3>Password must contain the following:</h3> -->
												  <p id="letter" class="invalid"><b>حرف  </b> صغير </p>
												  <p id="capital" class="invalid"><b>العاصمة (الأحرف الكبيرة) </b> غير  </p>
												  <p id="number" class="invalid"><b>رقم</b></p>
												  <p id="length" class="invalid">الحد الأدنى  <b>8 أحرف</b></p>
												</div>
												<p>عندك حساب أصلا ؟ <a href="javascript:void(0);" id="showLogin">الدخول</a></p>
											</div>
											<!-- Login Form -->
											<div class="post-register-form login-form">
												<h4>تسجيل الدخول كمشتري</h4>
												<div class="form-group">
													<label class="control-label"><span>الإيميل   أو   اسم المستخدم</span></label>
													<input class="form-control" type="text" placeholder="ادخل اسم المستخدم"  name="seller_user_name" value= "<?php if(isset($_SESSION['seller_user_name'])) echo $_SESSION['seller_user_name']; ?>"/>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['seller_user_name']); ?></span>
												</div>
												<div class="form-group">
													<label class="control-label"><span>الباسوورد</span></label>
													<input class="form-control" type="password" name="seller_pass" placeholder="الباسوورد"/>
													<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['seller_pass']); ?></span>
												</div>
												<p>ماعندكش حساب؟ <a href="javascript:void(0);" id="showRegister">سجل</a></p>
											</div>
											<!-- End Login Form -->
											<?php } ?>
											<!-- End Registration Process -->
											<div class="form-group mb-0">
												<button class="button" role="button" type="submit" name="submit">انشر</button>
											</div>
										</form>
									</div>
									<div class="col-12 col-md-4" id="popupWidth"></div>
								</div>
							</div>
							<div class="col-12 col-lg-4">
								<div class="howitwork-card">
									<div class="howitwork-card-title d-flex align-items-center">ازاي بيشتغل</div>
									<div class="howitwork-list d-flex flex-column">
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/find.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>1. استكشف</h3>
												<p> شارك مشروعك دلوقتي على منصتنا عشان تقدر تتواصل مع المحترفين من الموظفين المستقلين اللي مستعدين يقدموا حاجات رائعة ليك.</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/gethired.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>2. التوظيف</h3>
												<p> راجع اعتمادات عشرات الفريلانسرز عشان تقدر تحدد الشخص المناسب اللي عنده المؤهلات المطلوبة لمشروعك</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Work" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/work.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>3. الشغل</h3>
												<p>اتواصل و حدد الأساس عشان تحقق التعاون الناجح، شارك أفكارك، طور الخطوط العريضة، ابعت ملفات، و كمان تقدر تدير المشروع بالكامل من خلال منصتنا سهلة الاستخدام</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/getpaid.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>4. الدفع</h3>
												<p>بمجرد إنك تلاقي الموظف المثالي لمشروعك، عليك إنك تبعت المبلغ المطلوب من خلال بوابتنا الآمنة للدفع و تستمتع براحة البال لأن معاك ضمان باستعادة أموالك كاملة 100%</p>
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
        
        $(".gig-category-select").on('click', function(){
        	var cat_class = $(this).parents('.cat_item-content').attr("data-id");
        		$(".gig-category-tags").removeAttr('class').addClass('gig-category-tags '+cat_class);
        		// $('.gig-category-tags').addClass(cat_class);
        });

        $('.deliver-time-item[for="days30"]').on('click', function(){
        	$('.input-number').focus();
        });
        $('.input-number').keyup(function(){
        	var custom_btn = $('.input-number').val();
        	$('#days30').val(custom_btn);
        });
    });
</script>
<script>
$(document).ready(function(){
	$('.js-example-basic-multiple').select2();
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

	// $("#category").change(function(){
	// 	$("#sub-category").show();	
	// 	var category_id = $(this).val();
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
 //    var totalSize = this.files[0].size;
 //    var totalSizeMb = totalSize  / Math.pow(1024,2);

 //    $('.max-size').text(totalSizeMb.toFixed(2) + " MB");
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
				$messages = array("seller_user_name" => "اسم المستخدم مطلوب.","seller_pass" => "كلمة المرور مطلوبة.");

				$val = new Validator($_POST,$rules,$messages);

				if($val->run() == false){
					Flash::add("login_errors",$val->get_all_errors());
					Flash::add("form_data",$_POST);
					echo "<script>window.open('index','_self')</script>";
				}else{

					$seller_user_name = $input->post('seller_user_name');
					$seller_pass = $input->post('seller_pass');
					$select_seller = $db->query("select * from sellers where (seller_user_name = '".$seller_user_name."' OR seller_email = '".$seller_user_name."')");
					// $select_seller = $db->query("select * from sellers where binary seller_user_name like :u_name",array(":u_name"=>$seller_user_name));
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
			            .text('عذراً! كلمة المرور أو اسم المستخدم غير صحيح. حاول مرة اخرى.'),
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
		                .text('لقد تم حظرك من قبل المشرف. يرجى الاتصال بدعم العملاء.'),
		              animation: false,
		              customClass: 'animated tada'
		            })
					    	</script>";
						}elseif($seller_status == "deactivated"){
							echo "
							<script>
							swal({
							  type: 'warning',
							  html: $('<div>').text('لقد قمت بتعطيل حسابك ، يرجى الاتصال بنا للحصول على مزيد من التفاصيل.'),
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
				          $messages = array("cat_id" => "يرجى تحديد فئة وفئة فرعية","request_title" => "يرجى إدخال عنوان الطلب", "request_description" => "الرجاء إدخال الوصف", "request_budget" => "الرجاء إدخال مبلغ الميزانية", "delivery_time" => "الرجاء تحديد وقت التسليم", "skills_required" => "يرجى إدخال المهارات المطلوبة", "languages" => "الرجاء إدخال اللغات");
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
				          	$skills_required = implode(',', $input->post('skills_required'));
				          	$languages = implode(',', $input->post('languages'));
				          	// $request_file = $_FILES['request_file']['name'];
				          	// $request_file_tmp = $_FILES['request_file']['tmp_name'];
				          	$request_date = date("F d, Y");
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
				          	$insert_request = $db->insert("buyer_requests",array("seller_id"=>$login_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
				          	if($insert_request){
				          		echo "<script>
				          		    swal({
				          		      type: 'success',
				          		      text: 'وفد فدم طلبك بنجاح!',
				          		      timer: 3000,
				          		      onOpen: function(){
				          		      	swal.showLoading()
				          		      }
				          		    }).then(function(){
				          		      	window.open('$site_url/ar','_self');
				          		    });
				          		</script>";
				          	}
				          }
				        }
							}
						}
				  }
						
				}

		}else{
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

				$messages = array("name" => "الإسم الكامل ضروري.","u_name" => "اسم المستخدم مطلوب.","pass" => "كلمة المرور مطلوبة.", "email" => "البريد الالكتروني مطلوب" , "cat_id" => "يرجى تحديد فئة وفئة فرعية","request_title" => "يرجى إدخال عنوان الطلب", "request_description" => "الرجاء إدخال الوصف", "request_budget" => "الرجاء إدخال مبلغ الميزانية", "delivery_time" => "الرجاء تحديد وقت التسليم", "skills_required" => "يرجى إدخال المهارات المطلوبة", "languages" => "الرجاء إدخال اللغات");
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
					// if(preg_match('/[اأإء-ي]/ui', $input->post('u_name'))){
					//   array_push($error_array, "الأحرف الأجنبية غير مسموح بها في اسم المستخدم ، يرجى تجربة حرف آخر.");
					// }
					if($check_seller_username > 0 ){
					  array_push($error_array, "عذراً! وقد تم بالفعل اتخاذ هذا المستخدم. يرجى تجربة واحدة أخرى");
					}
					if($check_seller_email > 0){
					  array_push($error_array, "لقد اخذ الايميل من قبل. حاول تسجيل الدخول بدلاً من ذلك.");
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
								  $messages = array("cat_id" => "يرجى تحديد فئة وفئة فرعية","request_title" => "يرجى إدخال عنوان الطلب", "request_description" => "الرجاء إدخال الوصف", "request_budget" => "الرجاء إدخال مبلغ الميزانية", "delivery_time" => "الرجاء تحديد وقت التسليم", "skills_required" => "يرجى إدخال المهارات المطلوبة", "languages" => "الرجاء إدخال اللغات");
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
									$skills_required = implode(',', $input->post('skills_required'));
									$languages = implode(',', $input->post('languages'));
									// $request_file = $_FILES['request_file']['name'];
									// $request_file_tmp = $_FILES['request_file']['tmp_name'];
									$request_date = date("F d, Y");
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
									$insert_request = $db->insert("buyer_requests",array("seller_id"=>$regsiter_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
									if($insert_request){
										echo "<script>
										    swal({
										      type: 'success',
										      text: 'وفد فدم طلبك بنجاح!',
										      timer: 3000,
										      onOpen: function(){
										      	swal.showLoading()
										      }
										    }).then(function(){
										      	window.open('$site_url/ar','_self');
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
						html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
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
		  $messages = array("cat_id" => "يرجى تحديد فئة وفئة فرعية","request_title" => "يرجى إدخال عنوان الطلب", "request_description" => "الرجاء إدخال الوصف", "request_budget" => "الرجاء إدخال مبلغ الميزانية", "delivery_time" => "الرجاء تحديد وقت التسليم", "skills_required" => "يرجى إدخال المهارات المطلوبة", "languages" => "الرجاء إدخال اللغات");
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
			$skills_required = implode(',', $input->post('skills_required'));
			$languages = implode(',', $input->post('languages'));
			// $request_file = $_FILES['request_file']['name'];
			// $request_file_tmp = $_FILES['request_file']['tmp_name'];
			$request_date = date("F d, Y");
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
			$insert_request = $db->insert("buyer_requests",array("seller_id"=>$login_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
			if($insert_request){
				echo "<script>
				    swal({
				      type: 'success',
				      text: 'وفد فدم طلبك بنجاح!',
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