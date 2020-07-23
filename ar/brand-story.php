<?php
session_start();
require_once("includes/db.php");
// if(!isset($_SESSION['seller_user_name'])){
	
// echo "<script>window.open('login','_self')</script>";

// }
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_type = $row_login_seller->account_type;
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
	<head>
		<title><?= $site_name; ?> - Brand Story</title>
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
						<div class="row justify-content-between">
							<div class="col-12 col-md-6 col-lg-5 mt-md-3 mb-md-3">
								<div class="about-item">
									<h2>قصة العلامة التجارية:</h2>
									<p>شايف إنه صعب إنك تلاقي شغل من البيت؟</p>
									<p>شايف إنه صعب إنك تلاقي المرشح المثالي لمشروعك؟</p>
									<p>لو إجابتك كانت نعم، يبقى أنت وصلت للمنصة المثالية اللي هتحللك مشكلتك!</p>
									<p>الموضوع بدأ لما لاحظنا المشكلة اللي موجودة في مجال العمل الحر، بدئنا فورًا نطور منصة تكنولوجية عشان نسهلك العملية. أي وقت هتدور فيه على موقع فريلانس، هتلاقي موقع عالمي وده هيسببلك مشكلة إنك تكون ظاهر وسط الموقع.</p>
									<p>دلوقتي تقدر تشيل كل مخاوفك، الموقع العربي بتاعنا الخاص بالشرق الأوسط هيساعدك تلاقي شغل وتوصل لأصحاب الأعمال الأفضل اللي محتاجين ناس تشتغل.</p>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-6 mt-md-3 mb-md-3">
								<img alt="" class="img-fluid d-block ml-auto mr-auto" src="<?= $site_url; ?>/ar/assets/img/about/about-image.png" />
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>

		<?php require_once("includes/footer.php"); ?>
	</body>
</html>