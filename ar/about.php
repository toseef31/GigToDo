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
		<title><?= $site_name; ?> - About</title>
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
						<div class="row">
							<div class="col-12">
								<h1 class="text-center">معلومات عننا</h1>
							</div>
						</div>
						<div class="row justify-content-between">
							<div class="col-12 col-md-6 col-lg-5">
								<div class="about-item">
									<h2>المهمة</h2>
									<p>مهمتنا إننا نساعد في تصحيح الشذوذ الإجتماعي اللي واضح بشكل كبير في البطالة اللي موجودة داخل شريحة الطبقة العاملة. بنحاول نقضي على الفقر ونخفف من قسوة الإقتصاد الضعيف على معظم الناس عن طريق إننا نساعد بتوصيلهم بالناس الي محتاجه خدماتهم والمهارات اللي بيمتلكوها. مهمتنا إننا نوفر موقع بيقدم خدمات فريلانس موثوقة ومحترفة لمساعدة الأعمال والشركات والأفراد و المؤسسات الغير ربحية إنها تشتغل بشكل مستدام. إحنا عايزين نبني شركة رائدة في العمل الحر تقدر تنافس بشكل إيجابي مع العلامات التجارية الأخرى الرائدة في مجال العمل الحر</p>
								</div>
								<div class="about-item">
									<h2>الرؤية</h2>
									<p>رؤيتنا إننا نعمل منصة يتقابل فيها كل اللي بيبحثوا عن وظيفة وكل اللي بيبحثوا عن مقدمي خدمة عشان يقضوا احتياجاتهم بشكل فوري. منصة تقدر توفر للمصريين فرصة إنهم يعينوا مصريين عندهم الكفاءة والمهارة عشان يخلصوا وظيفة معينة. هيستفيد أصحاب الأعمال إن شغلهم هيخلص عن طريق أفراد مهره اتعينوا على أساس مخصص من خلال منصتنا، برضو الباحثين عن عمل هيخلصو الشغل مقابل مبلغ هيدفع في المحفظة بتاعتهم على منصتنا في نهاية كل مهمة أو مشروع. رؤيتنا إننا نخلق عالم من غير حد عاطل، على الأقل مشغول بحاجة يعملها بدل القعدة على الفاضي. نتصور إننا هنكون أكتر منصة أعمال حرة مستخدمة في الشرق الأوسط من الناس اللي عايزه</p>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-6">
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