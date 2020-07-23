<?php
session_start();
require_once("includes/db.php");

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_type = $row_login_seller->account_type;
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
	<head>
		<title><?= $site_name; ?> - Contact Us</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="keywords" content="<?= $site_keywords; ?>">
		<meta name="author" content="<?= $site_author; ?>">
		<?php if(!empty($site_favicon)){ ?>
		<link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
		<?php } ?>
		<!--====== Favicon Icon ======-->
		<?php if(!empty($site_favicon)){ ?>
			<link rel="shortcut icon" href="<?= $site_url; ?>/images/<?= $site_favicon; ?>" type="image/x-icon">
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
		<link href="<?= $site_url; ?>/ar/assets/css/style1.css" rel="stylesheet">
		<!--====== Responsive css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
		<!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
		<!-- <link href="styles/custom.css" rel="stylesheet">  -->
		<!-- Custom css code from modified in admin panel --->
		<link href="<?= $site_url; ?>/ar/styles/styles.css" rel="stylesheet">
		<link href="styles/user_nav_styles.css" rel="stylesheet">
		<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
		<link href="styles/owl.carousel.css" rel="stylesheet">
		<link href="styles/owl.theme.default.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.min.js"></script>
	<style>
		.select-error .nice-select{display: none;}.select-error select{display: block !important;}
	</style>
	</head>
	<body class="all-content">
		<?php
	    if(!isset($_SESSION['seller_user_name'])){
	      require_once("includes/header_with_categories.php");
	    }else{
	    	if($login_seller_type == 'buyer'){
	      	require_once("includes/buyer-header.php");
	    	}else{
	    		require_once("includes/user_header.php");
	    	}
	    } 
	  ?>
		<!-- Preloader Start -->
		<div class="proloader">
			<div class="loader">
				<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
			</div>
		</div>
		<!-- Preloader End -->
		<main class="emongez-content-main">
			
			<section class="container-fluid contactus">
				<div class="row">
					<div class="container">
						<div class="row justify-content-between">
							<div class="col-12 col-md-7">
								<div class="contactus-form">
									<h1>اتصل بنا</h1>
									<form action="index.html" class="d-flex flex-column" method="POST">
										<div class="form-group select-error">
											<label class="control-label" for="relevantSubject">حدد موضوع الاستفسار ذي الصلة</label>
											<select class="form-control" name="relevant-subject" id="relevantSubject">
												<option value="1">الإبلاغ عن خطأ</option>
												<option value="2">الإبلاغ عن خطأ</option>
												<option value="3">الإبلاغ عن خطأ</option>
												<option value="4">الإبلاغ عن خطأ</option>
												<option value="5">الإبلاغ عن خطأ</option>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label" for="subject">موضوع</label>
											<input type="text" name="subject" id="subject" class="form-control" />
										</div>
										<div class="form-group">
											<label class="control-label" for="message">رسالة</label>
											<textarea class="form-control" id="message" name="message" rows="7"></textarea>
										</div>
										<div class="form-group">
											<label class="control-label" for="attachment">المرفق</label>
											<input type="file" name="attachment" id="attachment" class="form-control" />
										</div>
										<div class="form-group">
											<button class="contactus-form-button" type="submit" role="button">تقديم الطلب</button>
										</div>
									</form>
								</div>
							</div>
							<div class="col-12 col-md-7 col-lg-4">
								<div class="contact-location">
									<h2>نحن دائما هنا اساعدك!</h2>
									<div class="address-item d-flex flex-row">
										<div class="icon">
											<img alt="Address" class="img-fluid d-block" src="assets/img/contact/map-marker.png" />
										</div>
										<div class="text">
											<h4>عنوان</h4>
											<h5>مصر</h5>
											<address>
												4 ش جهينة الدقى الدقى الجيزة<br />
												محافظة 12311 مصر
											</address>
											<h5>أستراليا</h5>
											<address>
												1409/200 شارع سبنسر نيو 200 ،<br />
												ملبورن VIC 3000
											</address>
										</div>
									</div>
									<!-- Each item -->
									<div class="address-item d-flex flex-row">
										<div class="icon">
											<img alt="Email" class="img-fluid d-block" src="assets/img/contact/mail-icon.png" />
										</div>
										<div class="text">
											<h4>البريد الإلكتروني</h4>
											<p><a href="mailto:emongez@emongez.com">emongez@emongez.com</a></p>
										</div>
									</div>
									<!-- Each item -->
								</div>
							</div>
						</div>
						<!-- Row -->
						<div class="row">
							<div class="col-12">
								<div class="contactus-map">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.970234789631!2d31.21043481569234!3d30.037711781884774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145846d4ecbeb8f5%3A0xd00525dc3aa4c477!2s4%20Johayna%20St%2C%20Ad%20Doqi%20A%2C%20Dokki%2C%20Giza%20Governorate%2012311%2C%20Egypt!5e0!3m2!1sen!2sbd!4v1592425184858!5m2!1sen!2sbd" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
								</div>
							</div>
						</div>
						<!-- Row -->
					</div>
				</div>
			</section>

		</main>
		<?php require_once("includes/footer.php"); ?>
	</body>
</html>