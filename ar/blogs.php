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
		<title><?= $site_name; ?> - Blog List</title>
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
		<!-- <link href="styles/user_nav_styles.css" rel="stylesheet"> -->
		<!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet"> -->
		<!-- <link href="styles/owl.carousel.css" rel="stylesheet"> -->
		<!-- <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
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
		<main class="emongez-content-main">
			
			<section class="container-fluid blog-list">
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-12 col-md-8">
								<?php 
									
									 $get_articles = $db->select("knowledge_bank", array("language_id" => 1));
									 while($row_articles = $get_articles->fetch()){
									 $article_id = $row_articles->article_id;
									 $article_url = $row_articles->article_url;
									 $cat_id = $row_articles->cat_id;
									 $article_heading = $row_articles->article_heading;
									 $article_body = $row_articles->article_body;
									 $right_image = $row_articles->right_image;
									 $top_image = $row_articles->top_image;
									 $bottom_image = $row_articles->bottom_image;
									 $posted_date  = $row_articles->posted_date;
									 $timee = $posted_date;
									 $day = date("d", strtotime($posted_date));
									 $month = date("F", strtotime($posted_date));

									 $article_categories = $db->select("article_cat",array("article_cat_id" => $cat_id));
									 $cat_title = $article_categories->fetch()->article_cat_title;
								?>
								<div class="blog-list-item d-flex flex-column">
									<div class="blog-list-item-image d-flex flex-column">
										<a class="d-block" href="article/<?php echo $article_url; ?>">
											<img alt="Successful marketing stories" class="img-fluid d-block" src="<?= $site_url ?>/article/article_images/<?= $top_image ?>" />
										</a>
									</div>
									<div class="blog-list-item-content d-flex flex-row">
										<div class="blog-list-item-date">
											<div class="date d-flex flex-column">
												<span><?= $day ?></span>
												<span><?= $month ?></span>
											</div>
										</div>
										<div class="blog-list-item-text d-flex flex-column">
											<div class="blog-author-item d-flex flex-wrap">
												<div class="blog-author--item d-flex flex-row">
													<span><i class="fal fa-user"></i></span>
													<span>بقلم   Admin</span>
												</div>
												<!-- Each item -->
												<div class="blog-author--item d-flex flex-row">
													<span><i class="fal fa-folder"></i></span>
													<span><?= $cat_title ?></span>
												</div>
												<!-- Each item -->
												<div class="blog-author--item d-flex flex-row">
													<span><i class="fal fa-clock"></i></span>
													<span><?= $posted_date; ?></span>
												</div>
												<!-- Each item -->
											</div>
											<div class="blog-list-item-description">
												<h2><a href="article/<?php echo $article_url; ?>"><?= $article_heading ?></a></h2>
												<?php 
												  $string = strip_tags($article_body);
												  if (strlen($string) > 500) {
												      // truncate string
												      $stringCut = substr($string, 0, 500);
												      $endPoint = strrpos($stringCut, ' ');
												      //if the string doesn't contain any space then it will cut without word basis.
												      $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
												      $string .= '....';
												  }
												  // echo $string;
												?>
												<div class="description"><?= $string ?></div>
												<a class="continue-button d-flex flex-row align-items-center" href="article/<?php echo $article_url; ?>">
													<span>Continue</span>
													<span><i class="fal fa-long-arrow-left"></i></span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								<!-- Each item -->
								<!-- <div class="blog-pagination">
									<ul class="pagination">
										<li class="page-item previous disabled">
											<a class="page-link" href="javascript:void(0);" tabindex="-1" aria-disabled="true"><i class="fal fa-angle-right"></i></a>
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
											<a class="page-link" href="javascript:void(0);"><i class="fal fa-angle-left"></i></a>
										</li>
									</ul>
								</div> -->
							</div>
							<!-- Column 1 -->
							<div class="col-12 col-md-4">
								<div class="blog-categories d-flex flex-column">
									<div class="blog-categories-header">التصنيفات</div>
									<div class="blog-categories-lists d-flex flex-column">
										<?php
										  $get_cats = $db->select("article_cat",array("language_id" => 2));
										  while($row_cats = $get_cats->fetch()){
										  $article_cat_id = $row_cats->article_cat_id;
										  $article_cat_title = $row_cats->article_cat_title;

										   $count_categories = $db->select("knowledge_bank", array("cat_id" => $article_cat_id));
										   $count_article = $count_categories->rowCount();
										?>
										<a class="blog-categories-item" href="javascript:void(0);"><?php echo $article_cat_title; ?> (<?= $count_article ?>)</a>
										<?php } ?>
									</div>
								</div>
								<div class="blog-recent-posts d-flex flex-column">
									<div class="blog-recent-posts-header">المنشور الاخير</div>
									<div class="blog-recent-posts-body d-flex flex-column">
										<?php 
											$get_articles = $db->query("select * from knowledge_bank where language_id=2 order by 1 DESC LIMIT 0,3");
											// $get_articles = $db->select("knowledge_bank", array("language_id" => 1));
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
										<a class="blog-recent-posts-item d-flex flex-row" href="article/<?php echo $article_id; ?>">
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
		<?php require_once("includes/footer.php"); ?>
	</body>
</html>