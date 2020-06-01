<?php
session_start();

require_once("includes/db.php");
require_once("functions/functions.php");
if(strpos($_SERVER["REQUEST_URI"], 'index') !== false){
	header("location: $site_url");
}
require_once("social-config.php");
$site_title = $row_general_settings->site_title;

?>
<?php 
	if(isset($_SESSION['seller_user_name'])){
	  $login_seller_user_name = $_SESSION['seller_user_name'];
	  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	  $row_login_seller = $select_login_seller->fetch();
	  $login_user_type = $row_login_seller->account_type;
	  // print_r($login_user_type);
	}
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<title><?php echo $site_title; ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
  <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
	<link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
	<!-- <link href="styles/styles.css" rel="stylesheet">
	<link href="styles/categories_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
	<link href="styles/sweat_alert.css" rel="stylesheet">
	<link href="styles/animate.css" rel="stylesheet"> -->
	<!-- New Design -->
	<!-- ==============Google Fonts============= -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	<!--====== Bootstrap css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/bootstrap.min.css" rel="stylesheet">
	<!--====== PreLoader css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/preloader.css" rel="stylesheet">
	<!--====== Animate css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/animate.min.css" rel="stylesheet">
	<!--====== Fontawesome css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/fontawesome.min.css" rel="stylesheet">
	<!--====== Owl carousel css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/owl.carousel.min.css" rel="stylesheet">
	<!--====== Nice select css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/nice-select.css" rel="stylesheet">
	<!--====== Default css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
	<!--====== Style css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="<?php echo $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
  <?php if($row_general_settings->knowledge_bank == 'yes'): ?>
	<link href="styles/knowledge_bank.css" rel="stylesheet">
	<?php endif ?>
	<?php if(!empty($site_favicon)){ ?>
	<link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon" />
	<!--====== Favicon Icon ======-->
	<link rel="shortcut icon" href="<?php echo $site_url; ?>/ar/assets/img/favicon.ico" type="image/png">
	<?php } ?>
	<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
	<script src="js/ie.js"></script>
	<script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.dil {color: #ff2b2b !important;}.fit-svg-icon path {fill: #ffbf00;}</style>
	<style>
		.messagePopup {
		    position: fixed;
		    top: 90px;
		    right: 0px;
		    z-index: 5000;
		    font-size: 15px;
		    direction: rtl;
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

if(!isset($_SESSION['seller_user_name'])){
	require_once("includes/header.php");
}else{
	require_once("includes/buyer-header.php");
}
if(!isset($_SESSION['seller_user_name'])){
	require_once("home.php");
}else{  
	if($login_user_type == 'buyer'){  
		require_once("user_home.php");
	}else {
		echo "<script> window.open('dashboard','_self') </script>"; 
	}
}
require_once("includes/footer.php"); 

?>
<!-- <?php if($row_general_settings->knowledge_bank == 'yes'): ?>
<div class="sm popup-support-wrap">
	<div class="popup-support">
		<header class="hero-container" style="background-color: rgb(29, 191, 115); color: rgb(255, 255, 255);">
			<div class="hero">
				<h1 class="main-title"><a href="#" class="sm-back"><i class="pull-left fa fa-angle-left"></i></a> Knowledge Bank</h1>
				<a class="support-nav" href="#">Our how to guides</a>
				<h2 class="sub-title"></h2>
				<div class="search-box">
					<div class="search-placeholder">
						<span class="svg-icon search-magnifier"><i class="fa fa-search"></i></span>
				  </div>
			    <input type="text" id="sm-search" value="">
		  	</div>
	  	</div>
  	</header>
		<div class="search-results">
			<div class="pull-left search-articles">
			<h3></h3>
			<ul></ul>
			</div>
			<div class="pull-left search-single">
			<div class="breadcrumbs"><a href="#" class="home-link" data-id=""><i class="fa fa-home"></i> <i class="fa fa-angle-right"></i> &nbsp;<span class="sm-category"></span></a></div>
			<div class="sm-title"></div>
			<div class="img imgtop"></div>
			<div class="sm-content"></div>
			<div class="img imgright"></div>
			<div class="img imgbottom"></div>
			</div>
		</div>
	</div>
</div>
<a class="support-que close pull-right">
	<i class="open-popup fa fa-question"></i>
	<i class="close-popup fa fa-remove"></i>
</a>
<script>var site_url='<?php echo $site_url; ?>';</script>
<script type="text/javascript" src="js/knowledge-bank.js"></script>
<?php endif; ?> -->
</body>
</html>