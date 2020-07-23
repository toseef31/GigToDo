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
	<title><?= $site_name; ?> - Blog List</title>
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
	<!-- Main content -->
			<main class="emongez-content-main">
				<section class="container-fluid blog-list">
					<div class="row">
						<div class="container">
							<div class="row">
								<div class="col-12 col-md-8">
									<div class="blog-list-item d-flex flex-column">
										<div class="blog-list-item-image d-flex flex-column">
											<a class="d-block" href="javascript:void(0);">
												<img alt="Successful marketing stories" class="img-fluid d-block" src="https://loremflickr.com/1024/500/beach,girl" />
											</a>
										</div>
										<div class="blog-list-item-content d-flex flex-row">
											<div class="blog-list-item-date">
												<div class="date d-flex flex-column">
													<span>15</span>
													<span>Jan</span>
												</div>
											</div>
											<div class="blog-list-item-text d-flex flex-column">
												<div class="blog-author-item d-flex flex-wrap">
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-user"></i></span>
														<span>By Jhon Doe</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-folder"></i></span>
														<span>Writing & Translation</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-clock"></i></span>
														<span>September 4, 2019</span>
													</div>
													<!-- Each item -->
												</div>
												<div class="blog-list-item-description">
													<h2><a href="javascript:void(0);">Successful marketing stories</a></h2>
													<div class="description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</div>
													<a class="continue-button d-flex flex-row align-items-center" href="javascript:void(0);">
														<span>Continue</span>
														<span><i class="fal fa-long-arrow-right"></i></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
									<div class="blog-list-item d-flex flex-column">
										<div class="blog-list-item-image d-flex flex-column">
											<a class="d-block" href="javascript:void(0);">
												<img alt="7 tips ensure a remarkable job application in social media" class="img-fluid d-block" src="https://loremflickr.com/1024/500/beach,girl" />
											</a>
										</div>
										<div class="blog-list-item-content d-flex flex-row">
											<div class="blog-list-item-date">
												<div class="date d-flex flex-column">
													<span>15</span>
													<span>Jan</span>
												</div>
											</div>
											<div class="blog-list-item-text d-flex flex-column">
												<div class="blog-author-item d-flex flex-wrap">
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-user"></i></span>
														<span>By Jhon Doe</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-folder"></i></span>
														<span>Writing & Translation</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-clock"></i></span>
														<span>September 4, 2019</span>
													</div>
													<!-- Each item -->
												</div>
												<div class="blog-list-item-description">
													<h2><a href="javascript:void(0);">7 tips ensure a remarkable job application in social media</a></h2>
													<div class="description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</div>
													<a class="continue-button d-flex flex-row align-items-center" href="javascript:void(0);">
														<span>Continue</span>
														<span><i class="fal fa-long-arrow-right"></i></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
									<div class="blog-list-item d-flex flex-column">
										<div class="blog-list-item-image d-flex flex-column">
											<a class="d-block" href="javascript:void(0);">
												<img alt="8 mobile UI design tips for a better user experience" class="img-fluid d-block" src="https://loremflickr.com/1024/500/beach,girl" />
											</a>
										</div>
										<div class="blog-list-item-content d-flex flex-row">
											<div class="blog-list-item-date">
												<div class="date d-flex flex-column">
													<span>15</span>
													<span>Jan</span>
												</div>
											</div>
											<div class="blog-list-item-text d-flex flex-column">
												<div class="blog-author-item d-flex flex-wrap">
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-user"></i></span>
														<span>By Jhon Doe</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-folder"></i></span>
														<span>Writing & Translation</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-clock"></i></span>
														<span>September 4, 2019</span>
													</div>
													<!-- Each item -->
												</div>
												<div class="blog-list-item-description">
													<h2><a href="javascript:void(0);">8 mobile UI design tips for a better user experience</a></h2>
													<div class="description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</div>
													<a class="continue-button d-flex flex-row align-items-center" href="javascript:void(0);">
														<span>Continue</span>
														<span><i class="fal fa-long-arrow-right"></i></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
									<div class="blog-list-item d-flex flex-column">
										<div class="blog-list-item-image d-flex flex-column">
											<a class="d-block" href="javascript:void(0);">
												<img alt="A look inside Zellene Guanlao's colorful work & illustration process" class="img-fluid d-block" src="https://loremflickr.com/1024/500/beach,girl" />
											</a>
										</div>
										<div class="blog-list-item-content d-flex flex-row">
											<div class="blog-list-item-date">
												<div class="date d-flex flex-column">
													<span>15</span>
													<span>Jan</span>
												</div>
											</div>
											<div class="blog-list-item-text d-flex flex-column">
												<div class="blog-author-item d-flex flex-wrap">
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-user"></i></span>
														<span>By Jhon Doe</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-folder"></i></span>
														<span>Writing & Translation</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-clock"></i></span>
														<span>September 4, 2019</span>
													</div>
													<!-- Each item -->
												</div>
												<div class="blog-list-item-description">
													<h2><a href="javascript:void(0);">A look inside Zellene Guanlao's colorful work & illustration process</a></h2>
													<div class="description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</div>
													<a class="continue-button d-flex flex-row align-items-center" href="javascript:void(0);">
														<span>Continue</span>
														<span><i class="fal fa-long-arrow-right"></i></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
									<div class="blog-list-item d-flex flex-column">
										<div class="blog-list-item-image d-flex flex-column">
											<a class="d-block" href="javascript:void(0);">
												<img alt="10 helpful mini-tutorials to quickly boost your design skills" class="img-fluid d-block" src="https://loremflickr.com/1024/500/beach,girl" />
											</a>
										</div>
										<div class="blog-list-item-content d-flex flex-row">
											<div class="blog-list-item-date">
												<div class="date d-flex flex-column">
													<span>15</span>
													<span>Jan</span>
												</div>
											</div>
											<div class="blog-list-item-text d-flex flex-column">
												<div class="blog-author-item d-flex flex-wrap">
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-user"></i></span>
														<span>By Jhon Doe</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-folder"></i></span>
														<span>Writing & Translation</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-clock"></i></span>
														<span>September 4, 2019</span>
													</div>
													<!-- Each item -->
												</div>
												<div class="blog-list-item-description">
													<h2><a href="javascript:void(0);">10 helpful mini-tutorials to quickly boost your design skills</a></h2>
													<div class="description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</div>
													<a class="continue-button d-flex flex-row align-items-center" href="javascript:void(0);">
														<span>Continue</span>
														<span><i class="fal fa-long-arrow-right"></i></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
									<div class="blog-list-item d-flex flex-column">
										<div class="blog-list-item-image d-flex flex-column">
											<a class="d-block" href="javascript:void(0);">
												<img alt="Create a compelling graphic design portfolio that lands work" class="img-fluid d-block" src="https://loremflickr.com/1024/500/beach,girl" />
											</a>
										</div>
										<div class="blog-list-item-content d-flex flex-row">
											<div class="blog-list-item-date">
												<div class="date d-flex flex-column">
													<span>15</span>
													<span>Jan</span>
												</div>
											</div>
											<div class="blog-list-item-text d-flex flex-column">
												<div class="blog-author-item d-flex flex-wrap">
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-user"></i></span>
														<span>By Jhon Doe</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-folder"></i></span>
														<span>Writing & Translation</span>
													</div>
													<!-- Each item -->
													<div class="blog-author--item d-flex flex-row">
														<span><i class="fal fa-clock"></i></span>
														<span>September 4, 2019</span>
													</div>
													<!-- Each item -->
												</div>
												<div class="blog-list-item-description">
													<h2><a href="javascript:void(0);">Create a compelling graphic design portfolio that lands work</a></h2>
													<div class="description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</div>
													<a class="continue-button d-flex flex-row align-items-center" href="javascript:void(0);">
														<span>Continue</span>
														<span><i class="fal fa-long-arrow-right"></i></span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<!-- Each item -->
									<div class="blog-pagination">
										<ul class="pagination">
											<li class="page-item previous disabled">
												<a class="page-link" href="javascript:void(0);" tabindex="-1" aria-disabled="true"><i class="fal fa-angle-left"></i></a>
											</li>
											<li class="page-item active" aria-current="page">
												<a class="page-link" href="javascript:void(0);">1</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="javascript:void(0);">2</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="javascript:void(0);">3</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="javascript:void(0);">4</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="javascript:void(0);">5</a>
											</li>
											<li class="page-item next">
												<a class="page-link" href="javascript:void(0);"><i class="fal fa-angle-right"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<!-- Column 1 -->
								<div class="col-12 col-md-4">
									<div class="blog-categories d-flex flex-column">
										<div class="blog-categories-header">Categories</div>
										<div class="blog-categories-lists d-flex flex-column">
											<?php
											  $get_cats = $db->select("article_cat",array("language_id" => $siteLanguage));
											  while($row_cats = $get_cats->fetch()){
											  $article_cat_id = $row_cats->article_cat_id;
											  $article_cat_title = $row_cats->article_cat_title;
											?>
											<a class="blog-categories-item" href="javascript:void(0);"> <?php echo $article_cat_title; ?></a>
											<?php } ?>
											<!-- <a class="blog-categories-item" href="javascript:void(0);">Web & Mobile Design (8)</a>
											<a class="blog-categories-item" href="javascript:void(0);">Desktop Software Development (5)</a>
											<a class="blog-categories-item" href="javascript:void(0);">Writing & Translation (4)</a>
											<a class="blog-categories-item" href="javascript:void(0);">Graphics & Design (3)</a>
											<a class="blog-categories-item" href="javascript:void(0);">Video & Animation (1)</a>
											<a class="blog-categories-item" href="javascript:void(0);">Uncategorized (3)</a> -->
										</div>
									</div>
									<div class="blog-recent-posts d-flex flex-column">
										<div class="blog-recent-posts-header">Recent Post</div>
										<div class="blog-recent-posts-body d-flex flex-column">
											<?php 
												$get_articles = $db->select("knowledge_bank");
												while($row_articles = $get_articles->fetch()){
												$article_id = $row_articles->article_id;
												$article_url = $row_articles->article_url;
												$article_heading = $row_articles->article_heading;
												$article_body = $row_articles->article_body;
												$right_image = $row_articles->right_image;
												$top_image = $row_articles->top_image;
												$bottom_image = $row_articles->bottom_image;
												if($lang_dir == "right"){
												  $floatRight = "float-right";
												}else{
												  $floatRight = "float-left";
												}
											?>
											<a class="blog-recent-posts-item d-flex flex-row" href="article/<?php echo $article_url; ?>">
												<div class="image">
													<img alt="7 tips ensure a remarkable job application in social media" class="img-fluid d-block" src="<?= $site_url; ?>/article/article_images/<?= $top_image; ?>" />
												</div>
												<div class="text"><?= $article_heading ?></div>
											</a>
											<?php } ?>
											<!-- Each item -->
										</div>
									</div>
								</div>
								<!-- Column 2 -->
							</div>
						</div>
					</div>
				</section>
			</main>
			<!-- Main content end -->	
		<?php require_once("includes/footer.php"); ?>
	</body>
</html>