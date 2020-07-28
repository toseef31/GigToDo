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
<html lang="en" class="ui-toolkit">
<head>
	<title><?= $site_name; ?> - User name search empty</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="<?= $site_keywords; ?>">
	<meta name="author" content="<?= $site_author; ?>">
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
	<link href="<?= $site_url; ?>/assets/css/style1.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
	<!-- <link href="styles/custom.css" rel="stylesheet">  -->
	<!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">
	<link href="styles/user_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<style>
		.blog-list-item-image{height: 420px;overflow: hidden;}
		.blog-recent-posts-item .image{height: 80px; overflow: hidden;}
		@media(max-width: 768px){.blog-list-item-image{height: 187px;overflow: hidden;}}
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
	<!-- Main content -->
		<main class="emongez-content-main">
			<section class="container-fluid empty-search-results">
				<div class="row">
					<div class="container">
						<div class="row justify-content-center">
							<div class="empty-search-results-wrapper d-flex flex-column">
								<div class="image">
									<img alt="" class="img-fluid d-block ml-auto mr-auto" src="assets/img/search/empty-search-image.png" />
								</div>
								<div class="text">
									<h2>No Service Found For Your Search</h2>
									<p>Try a new search or get a free quote for your project from our community of freelancers.</p>
									<div class="d-flex flex-row justify-content-center">
										<a class="empty-search-results-button d-flex flex-row align-items-center justify-content-center" href="javascript:void(0);">Search for Freelancers</a>
									</div>
								</div>
								<center class="pb-5 pt-5">
								  <a href="search-freelancers">Search Results username for "<?php echo @$_SESSION["search_query"]; ?>" </a>
								</center>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		<!-- Main content end -->	
	<?php require_once("includes/footer.php"); ?>
	</body>
</html>