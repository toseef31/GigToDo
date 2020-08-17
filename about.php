<?php

session_start();
require_once("includes/db.php");

// if(!isset($_SESSION['seller_user_name'])){
	
// 	echo "<script>window.open('login','_self')</script>";
	
// }

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_type = $row_login_seller->account_type;
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TF82RTH');</script>
	<!-- End Google Tag Manager -->
	<title><?= $site_name; ?> - About</title>
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
				<section class="container-fluid about">
					<div class="row">
						<div class="container">
							<div class="row">
								<div class="col-12">
									<h1 class="text-center">About Us</h1>
								</div>
							</div>
							<div class="row justify-content-between">
								<div class="col-12 col-md-6 col-lg-5">
									<div class="about-item">
										<h2>Mission</h2>
										<p>Our mission is to help in correcting the social anomaly particularly stressed in the unemployment of the people within the working class bracket. We seek to eradicate poverty and mitigate the harshness of poor economy on most people by helping them reach out to hirers who need their services and the skills they possess. Our mission is to provide professional and trusted freelancing website that assists businesses, individuals and non-profit organizations in operating sustainably. We want to build a top freelancing company that can favorably compete with other leading brands in the freelancing industry</p>
									</div>
									<div class="about-item">
										<h2>Vision</h2>
										<p>Our vision is to create a platform for both hirers and job seekers to meet and get their immediate needs attended to. A platform that will offer Egyptians the opportunity to hire Egyptians who are skilled to execute a particular task. The hirers get their work done by skilled individuals hired on an ad-hoc basis through our platform and the job seekers also get something done in exchange for some amount which is paid into their wallet on our platform on the completion of their project and assignments. Our vision is to create a world where everybody is employed, at least, busy with a thing or the other instead of sitting idly doing nothing. We are envisioned towards becoming the most used freelancing platform in the Middles East by all who want to hire people for their jobs on an ad-hoc basis and for all who want to make a means through it.</p>
									</div>
								</div>
								<div class="col-12 col-md-6 col-lg-6">
									<img alt="" class="img-fluid d-block ml-auto mr-auto" src="<?= $site_url; ?>/assets/img/about/about-image.png" />
								</div>
							</div>
						</div>
					</div>
				</section>
			</main>	
		<?php require_once("includes/footer.php"); ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	</body>
</html>