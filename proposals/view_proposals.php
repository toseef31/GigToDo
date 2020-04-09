<?php
session_start();
require_once("../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_vacation = $row_login_seller->seller_vacation;
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<title><?php echo $site_name; ?> - View My Gigs.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
  <!-- ==============Google Fonts============= -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
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
 	<!--====== Range Slider css ======-->
 	<link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
 	<!--====== Default css ======-->
 	<link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
 	<!--====== Style css ======-->
 	<link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
 	<!--====== Responsive css ======-->
 	<link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="../styles/bootstrap.css" rel="stylesheet"> -->
    <link href="../styles/custom.css" rel="stylesheet"> 
    <!-- Custom css code from modified in admin panel --->
	<link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet">
	<!-- <link href="../styles/user_nav_styles.css" rel="stylesheet">
	<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="../styles/owl.carousel.css" rel="stylesheet">
	<link href="../styles/owl.theme.default.css" rel="stylesheet"> -->
	<script type="text/javascript" src="../js/jquery.min.js"></script>
    <link href="../styles/sweat_alert.css" rel="stylesheet">
    <link href="../styles/animate.css" rel="stylesheet">
    <script type="text/javascript" src="../js/ie.js"></script>
    <script type="text/javascript" src="../js/sweat_alert.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
    <style>
    	@media(min-width: 767px){
    		.page-height{
    			position: relative;
    			min-height: 80%;
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
<?php require_once("../includes/user_header.php"); ?>

<main class="page-height">
		<section class="container-fluid list-page">
			<div class="row">
				<div class="container">
					<div class="row align-items-start">
						<div class="col-12 col-sm-6">
							<h1 class="list-page-title">List Of Gigs</h1>
						</div>
						<div class="col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-end">
							<a class="button button-red" href="create_proposal">Create a New Gig</a>
						</div>
					</div>
					<!-- Row -->
					<div class="list-page-filter">
						<div class="row flex-md-row-reverse">
							<div class="col-12 col-md-6">
								<ul class="pagination">
									<li class="pagination-item">
										<a class="pagination-link" href="javascript:void(0);">
											<i class="fal fa-angle-left"></i>
										</a>
									</li>
									<li class="pagination-item">
										<a class="pagination-link" href="javascript:void(0);">1</a>
									</li>
									<li class="pagination-item">
										<div class="pagination-status d-flex flex-row align-items-center">
											<span>Of</span>
											<span>1</span>
										</div>
									</li>
									<li class="pagination-item">
										<a class="pagination-link" href="javascript:void(0);">
											<i class="fal fa-angle-right"></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="col-12 col-md-6">
								<nav class="list-page-nav">
									<div class="nav nav-tabs" id="nav-tab" role="tablist">
										<?php
									    $count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'active'));
										?>
										<a class="nav-item nav-link limerick active" id="active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="true">Active <span class="badge"><?php echo $count_proposals; ?></span></a>
										<?php
									    $count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'pause'));
										?>
										<a class="nav-item nav-link selective-yellow" id="paused-tab" data-toggle="tab" href="#nav-paused" role="tab" aria-controls="nav-paused" aria-selected="false">Paused <span class="badge"><?php echo $count_proposals; ?></span></a>
										<?php
									    $count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'draft'));
										?>
										<a class="nav-item nav-link deep-sky-blue" id="draft-tab" data-toggle="tab" href="#nav-draft" role="tab" aria-controls="nav-draft" aria-selected="false">Draft <span class="badge"><?php echo $count_proposals; ?></span></a>
										<?php
									    $count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'modification'));
										?>
										<a class="nav-item nav-link deep-red" id="modification-tab" data-toggle="tab" href="#nav-modification" role="tab" aria-controls="nav-modification" aria-selected="false">Modification <span class="badge"><?php echo $count_proposals; ?></span></a>
									</div>
								</nav>
							</div>
						</div>
						<!-- Row -->
					</div>
					<div class="row">
						<div class="col-12">
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-active" role="tabpanel" aria-labelledby="active-tab">
									<div class="all-gigs-small">
										<div class="row">
                      <?php
                        $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
                        $count_proposals = $select_proposals->rowCount();
                        while($row_proposals = $select_proposals->fetch()){
                        $proposal_id = $row_proposals->proposal_id;
                        $proposal_title = $row_proposals->proposal_title;
                        $proposal_views = $row_proposals->proposal_views;
                        $proposal_price = $row_proposals->proposal_price;
                        $proposals_rating = $row_proposals->proposal_rating;
                        $proposal_status = $row_proposals->proposal_status;
                        $proposal_date = $row_proposals->proposal_date;
												if($proposal_price == 0){
												$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
												$proposal_price = $get_p->fetch()->price;
												}
												
                        $proposal_img1 = $row_proposals->proposal_img1;
                        $proposal_url = $row_proposals->proposal_url;
                        $proposal_featured = $row_proposals->proposal_featured;
												$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                      ?>
											<div class="col-12">
												<div class="small-gigs-item limerick d-flex flex-column">
													<div class="small-gigs-item-header d-flex justify-content-between">
														<div class="small-gigs-image">
															<img class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="100" height="109" />
														</div>
														<div class="small-gigs-content d-flex justify-content-between">
															<div class="content d-flex flex-column justify-content-between">
																<h3 class="title">
																	<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>"><?php echo $proposal_title; ?></a>
																</h3>
																<ul class="list-inline">
																	<li class="list-inline-item"><?= $proposal_date; ?></li>
																	<li class="list-inline-item">Reviews (<?php echo $proposals_rating; ?>)</li>
																</ul>
															</div>
															<div class="icon d-flex flex-row">
																<div class="dropdown">
																	<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		<i class="far fa-cog"></i>
																	</a>
																	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
																		<a class="dropdown-item" href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>">Pause</a>
																		<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
																		<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
																		<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="small-gigs-item-footer d-flex flex-column">
														<div class="d-flex flex-wrap gigs-status">
															<div class="gig-status-item d-flex flex-column">
																<span>Page Views</span>
																<span><?php echo $proposal_views; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Sales</span>
																<span><?php echo $count_orders; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Cancellations</span>
																<span>0</span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Status</span>
																<span><?php echo $proposal_status; ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<?php
									     if($count_proposals == 0){
								         echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-meh-o'></i> You currently have no gig to sell.</h3></center>";
									     }
											?>
											<!-- Each item -->
										</div>
									</div>
									<!-- Small gigs item for mobile -->
									<div class="gigs-list d-none d-lg-flex flex-column">
                    <?php
                      $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
                      $count_proposals = $select_proposals->rowCount();
                      while($row_proposals = $select_proposals->fetch()){
                      $proposal_id = $row_proposals->proposal_id;
                      $proposal_title = $row_proposals->proposal_title;
                      $proposal_views = $row_proposals->proposal_views;
                      $proposal_price = $row_proposals->proposal_price;
                      $proposals_rating = $row_proposals->proposal_rating;
                      $proposal_status = $row_proposals->proposal_status;
                      $proposal_date = $row_proposals->proposal_date;
											if($proposal_price == 0){
											$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
											$proposal_price = $get_p->fetch()->price;
											}
											
                      $proposal_img1 = $row_proposals->proposal_img1;
                      $proposal_url = $row_proposals->proposal_url;
                      $proposal_featured = $row_proposals->proposal_featured;
											$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                    ?>
										<div class="gig-item limerick d-flex flex-wrap align-items-start">
											<div class="gig-item-image">
												<img alt="" class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="85" height="92" style="height: 92px" />
											</div>
											<div class="gig-item-content d-flex flex-column">
												<div class="d-flex flex-row justify-content-between">
													<div class="title-info">
														<h4><?php echo $proposal_title; ?></h4>
														<ul class="list-inline">
															<li class="list-inline-item">Created On: <?= $proposal_date; ?></li>
															<li class="list-inline-item">Reviews (<?php echo $proposals_rating; ?>)</li>
														</ul>
													</div>
													<div class="dropdown">
														<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
															<a class="dropdown-item" href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>">Pause</a>
															<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
															<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
															<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
														</div>
													</div>
												</div>
												<div class="d-flex flex-wrap gigs-status">
													<div class="gig-status-item d-flex flex-column">
														<span>Page Views</span>
														<span><?php echo $proposal_views; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Sales</span>
														<span><?php echo $count_orders; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Cancellations</span>
														<span>0</span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Status</span>
														<span><?php echo $proposal_status; ?></span>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php
								     if($count_proposals == 0){
							         echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-meh-o'></i> You currently have no gig to sell.</h3></center>";
								     }
										?>
										<!-- Each item -->
									</div>
									<!-- Gigs list end -->
								</div>
								<div class="tab-pane fade" id="nav-paused" role="tabpanel" aria-labelledby="paused-tab">
									<div class="all-gigs-small">
										<div class="row">
	                    <?php
	                      $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'pause'));
	                      $count_proposals = $select_proposals->rowCount();
	                      while($row_proposals = $select_proposals->fetch()){
	                      $proposal_id = $row_proposals->proposal_id;
	                      $proposal_title = $row_proposals->proposal_title;
	                      $proposal_views = $row_proposals->proposal_views;
	                      $proposal_price = $row_proposals->proposal_price;
	                      $proposals_rating = $row_proposals->proposal_rating;
	                      $proposal_status = $row_proposals->proposal_status;
	                      $proposal_date = $row_proposals->proposal_date;
												if($proposal_price == 0){
												$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
												$proposal_price = $get_p->fetch()->price;
												}
												
	                      $proposal_img1 = $row_proposals->proposal_img1;
	                      $proposal_url = $row_proposals->proposal_url;
	                      $proposal_featured = $row_proposals->proposal_featured;
												$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
	                    ?>
											<div class="col-12">
												<div class="small-gigs-item selective-yellow d-flex flex-column">
													<div class="small-gigs-item-header d-flex justify-content-between">
														<div class="small-gigs-image">
															<img class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="100" height="109" />
														</div>
														<div class="small-gigs-content d-flex justify-content-between">
															<div class="content d-flex flex-column justify-content-between">
																<h3 class="title">
																	<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>"><?= $proposal_title; ?></a>
																</h3>
																<ul class="list-inline">
																	<li class="list-inline-item"><?= $proposal_date; ?></li>
																	<li class="list-inline-item">Reviews (<?= $proposals_rating; ?>)</li>
																</ul>
															</div>
															<div class="icon d-flex flex-row">
																<div class="dropdown">
																	<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		<i class="far fa-cog"></i>
																	</a>
																	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
																		<a class="dropdown-item" href="activate_proposal?proposal_id=<?php echo $proposal_id; ?>">Activate Gig</a>
																		<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
																		<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
																		<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="small-gigs-item-footer d-flex flex-column">
														<div class="d-flex flex-wrap gigs-status">
															<div class="gig-status-item d-flex flex-column">
																<span>Page Views</span>
																<span><?php echo $proposal_views; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Sales</span>
																<span><?php echo $count_orders; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Cancellations</span>
																<span>0</span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Status</span>
																<span><?php echo $proposal_status; ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<?php
									      if($count_proposals == 0){
								         echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no paused gig.</h3></center>";
									      }
											?>
											<!-- Each item -->
										</div>
									</div>
									<!-- Small gigs item for mobile -->
									<div class="gigs-list d-none d-lg-flex flex-column">
                    <?php
                      $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'pause'));
                      $count_proposals = $select_proposals->rowCount();
                      while($row_proposals = $select_proposals->fetch()){
                      $proposal_id = $row_proposals->proposal_id;
                      $proposal_title = $row_proposals->proposal_title;
                      $proposal_views = $row_proposals->proposal_views;
                      $proposal_price = $row_proposals->proposal_price;
                      $proposals_rating = $row_proposals->proposal_rating;
                      $proposal_status = $row_proposals->proposal_status;
                      $proposal_date = $row_proposals->proposal_date;
											if($proposal_price == 0){
											$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
											$proposal_price = $get_p->fetch()->price;
											}
											
                      $proposal_img1 = $row_proposals->proposal_img1;
                      $proposal_url = $row_proposals->proposal_url;
                      $proposal_featured = $row_proposals->proposal_featured;
											$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                    ?>
										<div class="gig-item selective-yellow d-flex flex-wrap align-items-start">
											<div class="gig-item-image">
												<img alt="" class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="85" height="92" style="height: 92px" />
											</div>
											<div class="gig-item-content d-flex flex-column">
												<div class="d-flex flex-row justify-content-between">
													<div class="title-info">
														<h4><?= $proposal_title; ?></h4>
														<ul class="list-inline">
															<li class="list-inline-item">Created On: <?= $proposal_date; ?></li>
															<li class="list-inline-item">Reviews (<?= $proposals_rating; ?>)</li>
														</ul>
													</div>
													<div class="dropdown">
														<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
															<a class="dropdown-item" href="activate_proposal?proposal_id=<?php echo $proposal_id; ?>">Activate Gig</a>
															<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
															<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
															<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
														</div>
													</div>
												</div>
												<div class="d-flex flex-wrap gigs-status">
													<div class="gig-status-item d-flex flex-column">
														<span>Page Views</span>
														<span><?php echo $proposal_views; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Sales</span>
														<span><?php echo $count_orders; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Cancellations</span>
														<span>0</span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Status</span>
														<span><?php echo $proposal_status; ?></span>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php
								      if($count_proposals == 0){
							         echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no paused gig.</h3></center>";
								      }
										?>
										<!-- Each item -->
									</div>
									<!-- Gigs list end -->
								</div>
								<div class="tab-pane fade" id="nav-draft" role="tabpanel" aria-labelledby="draft-tab">
									<div class="all-gigs-small">
										<div class="row">
                      <?php
												$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'draft'));
												$count_proposals = $select_proposals->rowCount();
                        while($row_proposals = $select_proposals->fetch()){
                        $proposal_id = $row_proposals->proposal_id;
                        $proposal_title = $row_proposals->proposal_title;
                        $proposal_views = $row_proposals->proposal_views;
                        $proposal_price = $row_proposals->proposal_price;
                        $proposals_rating = $row_proposals->proposal_rating;
                      	$proposal_status = $row_proposals->proposal_status;
                      	$proposal_date = $row_proposals->proposal_date;
												if($proposal_price == 0){
												$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
												$proposal_price = $get_p->fetch()->price;
												}
                        $proposal_img1 = $row_proposals->proposal_img1;
                        $proposal_url = $row_proposals->proposal_url;
                        $proposal_featured = $row_proposals->proposal_featured;
												$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                      ?>
											<div class="col-12">
												<div class="small-gigs-item deep-sky-blue d-flex flex-column">
													<div class="small-gigs-item-header d-flex justify-content-between">
														<div class="small-gigs-image">
															<img class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="100" height="109" />
														</div>
														<div class="small-gigs-content d-flex justify-content-between">
															<div class="content d-flex flex-column justify-content-between">
																<h3 class="title">
																	<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>"><?= $proposal_title; ?></a>
																</h3>
																<ul class="list-inline">
																	<li class="list-inline-item"><?= $proposal_date; ?></li>
																	<li class="list-inline-item">Reviews (<?= $proposal_rating; ?>)</li>
																</ul>
															</div>
															<div class="icon d-flex flex-row">
																<div class="dropdown">
																	<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		<i class="far fa-cog"></i>
																	</a>
																	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
																		<a class="dropdown-item" href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>">Pause</a>
																		<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
																		<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
																		<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="small-gigs-item-footer d-flex flex-column">
														<div class="d-flex flex-wrap gigs-status">
															<div class="gig-status-item d-flex flex-column">
																<span>Page Views</span>
																<span><?php echo $proposal_views; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Sales</span>
																<span><?php echo $count_orders; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Cancellations</span>
																<span>0</span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Status</span>
																<span><?php echo $proposal_status; ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<?php
											 if($count_proposals == 0){
											   echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no gig in draft.</h3></center>";
											 }
											?>
											<!-- Each item -->
										</div>
									</div>
									<!-- Small gigs item for mobile -->
									<div class="gigs-list d-none d-lg-flex flex-column">
                    <?php
											$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'draft'));
											$count_proposals = $select_proposals->rowCount();
                      while($row_proposals = $select_proposals->fetch()){
                      $proposal_id = $row_proposals->proposal_id;
                      $proposal_title = $row_proposals->proposal_title;
                      $proposal_views = $row_proposals->proposal_views;
                      $proposal_price = $row_proposals->proposal_price;
                      $proposals_rating = $row_proposals->proposal_rating;
                    	$proposal_status = $row_proposals->proposal_status;
                    	$proposal_date = $row_proposals->proposal_date;
											if($proposal_price == 0){
											$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
											$proposal_price = $get_p->fetch()->price;
											}
                      $proposal_img1 = $row_proposals->proposal_img1;
                      $proposal_url = $row_proposals->proposal_url;
                      $proposal_featured = $row_proposals->proposal_featured;
											$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                    ?>
										<div class="gig-item deep-sky-blue d-flex flex-wrap align-items-start">
											<div class="gig-item-image">
												<img alt="" class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="85" height="92" style="height: 92px" />
											</div>
											<div class="gig-item-content d-flex flex-column">
												<div class="d-flex flex-row justify-content-between">
													<div class="title-info">
														<h4><?= $proposal_title; ?></h4>
														<ul class="list-inline">
															<li class="list-inline-item">Created On: <?= $proposal_date; ?></li>
															<li class="list-inline-item">Reviews (<?= $proposals_rating; ?>)</li>
														</ul>
													</div>
													<div class="dropdown">
														<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
															<a class="dropdown-item" href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>">Pause</a>
															<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
															<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
															<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
														</div>
													</div>
												</div>
												<div class="d-flex flex-wrap gigs-status">
													<div class="gig-status-item d-flex flex-column">
														<span>Page Views</span>
														<span><?php echo $proposal_views; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Sales</span>
														<span><?php echo $count_orders; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Cancellations</span>
														<span>0</span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Status</span>
														<span><?php echo $proposal_status; ?></span>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php
										 if($count_proposals == 0){
										   echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no gig in draft.</h3></center>";
										 }
										?>
										<!-- Each item -->
									</div>
									<!-- Gigs list end -->
								</div>
								<div class="tab-pane fade" id="nav-modification" role="tabpanel" aria-labelledby="modification-tab">
									<div class="all-gigs-small">
										<div class="row">
                      <?php
												$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'modification'));
												$count_proposals = $select_proposals->rowCount();
                        while($row_proposals = $select_proposals->fetch()){
                        $proposal_id = $row_proposals->proposal_id;
                        $proposal_title = $row_proposals->proposal_title;
                        $proposal_views = $row_proposals->proposal_views;
                        $proposal_price = $row_proposals->proposal_price;
                        $proposals_rating = $row_proposals->proposal_rating;
                      	$proposal_status = $row_proposals->proposal_status;
                      	$proposal_date = $row_proposals->proposal_date;
												if($proposal_price == 0){
												$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
												$proposal_price = $get_p->fetch()->price;
												}
                        $proposal_img1 = $row_proposals->proposal_img1;
                        $proposal_url = $row_proposals->proposal_url;
                        $proposal_featured = $row_proposals->proposal_featured;
												$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                      ?>
											<div class="col-12">
												<div class="small-gigs-item deep-red d-flex flex-column">
													<div class="small-gigs-item-header d-flex justify-content-between">
														<div class="small-gigs-image">
															<img class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="100" height="109" />
														</div>
														<div class="small-gigs-content d-flex justify-content-between">
															<div class="content d-flex flex-column justify-content-between">
																<h3 class="title">
																	<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>"><?= $proposal_title; ?></a>
																</h3>
																<ul class="list-inline">
																	<li class="list-inline-item"><?= $proposal_date; ?></li>
																	<li class="list-inline-item">Reviews (<?= $proposal_rating; ?>)</li>
																</ul>
															</div>
															<div class="icon d-flex flex-row">
																<div class="dropdown">
																	<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		<i class="far fa-cog"></i>
																	</a>
																	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
																		<a class="dropdown-item" href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>">Pause</a>
																		<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
																		<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
																		<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="small-gigs-item-footer d-flex flex-column">
														<div class="d-flex flex-wrap gigs-status">
															<div class="gig-status-item d-flex flex-column">
																<span>Page Views</span>
																<span><?php echo $proposal_views; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Sales</span>
																<span><?php echo $count_orders; ?></span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Cancellations</span>
																<span>0</span>
															</div>
															<div class="gig-status-item d-flex flex-column">
																<span>Status</span>
																<span><?php echo $proposal_status; ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
											<?php
											 if($count_proposals == 0){
											   echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no gig in Modification.</h3></center>";
											 }
											?>
											<!-- Each item -->
										</div>
									</div>
									<!-- Small gigs item for mobile -->
									<div class="gigs-list d-none d-lg-flex flex-column">
                    <?php
											$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'modification'));
											$count_proposals = $select_proposals->rowCount();
                      while($row_proposals = $select_proposals->fetch()){
                      $proposal_id = $row_proposals->proposal_id;
                      $proposal_title = $row_proposals->proposal_title;
                      $proposal_views = $row_proposals->proposal_views;
                      $proposal_price = $row_proposals->proposal_price;
                      $proposals_rating = $row_proposals->proposal_rating;
                    	$proposal_status = $row_proposals->proposal_status;
                    	$proposal_date = $row_proposals->proposal_date;
											if($proposal_price == 0){
											$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
											$proposal_price = $get_p->fetch()->price;
											}
                      $proposal_img1 = $row_proposals->proposal_img1;
                      $proposal_url = $row_proposals->proposal_url;
                      $proposal_featured = $row_proposals->proposal_featured;
											$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                    ?>
										<div class="gig-item deep-red d-flex flex-wrap align-items-start">
											<div class="gig-item-image">
												<img alt="" class="img-fluid d-block" src="../proposals/proposal_files/<?= $proposal_img1 ?>" width="85" height="92" style="height: 92px" />
											</div>
											<div class="gig-item-content d-flex flex-column">
												<div class="d-flex flex-row justify-content-between">
													<div class="title-info">
														<h4><?= $proposal_title; ?></h4>
														<ul class="list-inline">
															<li class="list-inline-item">Created On: <?= $proposal_date; ?></li>
															<li class="list-inline-item">Reviews (<?= $proposals_rating; ?>)</li>
														</ul>
													</div>
													<div class="dropdown">
														<a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-1">
															<a class="dropdown-item" href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>">Pause</a>
															<a class="dropdown-item" href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>">Delete</a>
															<a class="dropdown-item" href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>">Preview</a>
															<a class="dropdown-item" href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>">Edit</a>
														</div>
													</div>
												</div>
												<div class="d-flex flex-wrap gigs-status">
													<div class="gig-status-item d-flex flex-column">
														<span>Page Views</span>
														<span><?php echo $proposal_views; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Sales</span>
														<span><?php echo $count_orders; ?></span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Cancellations</span>
														<span>0</span>
													</div>
													<div class="gig-status-item d-flex flex-column">
														<span>Status</span>
														<span><?php echo $proposal_status; ?></span>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php
										 if($count_proposals == 0){
										   echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no gig in Modification.</h3></center>";
										 }
										?>
										<!-- Each item -->
									</div>
									<!-- Gigs list end -->
								</div>
							</div>
						</div>
					</div>
					<!-- Row -->
				</div>
			</div>
			<!-- Row -->
		</section>
	</main>


<!-- <div class="container-fluid view-proposals"> -->
	<!-- container-fluid view-proposals Starts -->
<!-- <div class="row"> -->
	<!-- row Starts -->
<!-- <div class="col-md-12 mt-5 mb-3"> -->
	<!-- col-md-12 mt-5 mb-3 Starts -->
        <!-- <h1 class="pull-left"><?php echo $lang["titles"]["view_proposals"]; ?></h1>
        <label class="pull-right lead"> -->
        	<!-- pull-right lead Starts -->
           <!--  Vacation Mode:
            <?php if($login_seller_vacation == "off"){ ?>
            <button id="turn_on_seller_vaction" data-toggle="button" class="btn btn-lg btn-toggle">
                <div class="toggle-handle"></div>
            </button>
            <?php }else{ ?>
            <button id="turn_off_seller_vaction" data-toggle="button" class="btn btn-lg btn-toggle active">
            <div class="toggle-handle"></div>
            </button>
            <?php } ?>
        </label> --><!-- pull-right lead Ends -->
       <!--  <script>
            $(document).ready(function(){
            $(document).on('click','#turn_on_seller_vaction', function(){
            seller_id = "<?php echo $login_seller_id; ?>";
            $.ajax({
            method:"POST",
            url: "seller_vacation_modal",
            data: { seller_id: seller_id, turn_on: 'on' }
            }).done(function(data){
            $('.append-modal').html(data);
            });
            });
            $(document).on('click','#turn_off_seller_vaction', function(){
            seller_id = "<?php echo $login_seller_id; ?>";
            $.ajax({
            method:"POST",
            url: "seller_vacation",
            data: { seller_id: seller_id, turn_off: 'off' }
            }).done(function(){
            $("#turn_off_seller_vaction").attr('id','turn_on_seller_vaction');
              swal({
              type: 'success',
              text: 'Vacation switched OFF.',
              padding: 40,
              });
            });
            });
            });
        </script>
</div>
<div class="append-modal"></div>
		<div class="col-md-12">
			<a href="create_proposal" class="btn btn-success pull-right">
               <i class="fa fa-plus-circle"></i> Add New Proposal
			</a>
			<div class="clearfix"></div>
			<ul class="nav nav-tabs flex-column flex-sm-row mt-4">
                <?php
                    $count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'active'));
                ?>
				<li class="nav-item">
					<a href="#active-proposals" data-toggle="tab" class="nav-link active make-black">
						<?= $lang['tabs']['active_proposals']; ?> <span class="badge badge-success"><?php echo $count_proposals; ?></span>
					</a>
				</li>
                <?php
                    $count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'pause'));
                ?>
				<li class="nav-item">
					<a href="#pause-proposals" data-toggle="tab" class="nav-link make-black">
						<?= $lang['tabs']['pause_proposals']; ?> <span class="badge badge-success"><?php echo $count_proposals; ?></span>
					</a>
				</li>
                <?php
				$count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'pending'));
                ?>
				<li class="nav-item">
					<a href="#pending-proposals" data-toggle="tab" class="nav-link make-black">
					<?= $lang['tabs']['pending_proposals']; ?> <span class="badge badge-success"><?php echo $count_proposals; ?></span>
					</a>
				</li>
                <?php
				$count_proposals = $db->count("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'modification'));
                ?>
				<li class="nav-item">
					<a href="#modification-proposals" data-toggle="tab" class="nav-link make-black">
					<?= $lang['tabs']['requires_modification']; ?> <span class="badge badge-success"><?php echo $count_proposals; ?></span>
					</a>
				</li>
                <?php
				$count_proposals = $db->count("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'draft'));
                ?>
				<li class="nav-item">
					<a href="#draft-proposals" data-toggle="tab" class="nav-link make-black">
					Draft <span class="badge badge-success"><?php echo $count_proposals; ?></span>
					</a>
				</li>
                <?php
				$count_proposals = $db->count("proposals",array("proposal_seller_id" => $login_seller_id, "proposal_status" => 'declined'));
                ?>
				<li class="nav-item">
					<a href="#declined-proposals" data-toggle="tab" class="nav-link make-black">
					Declined <span class="badge badge-success"><?php echo $count_proposals; ?></span>
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="active-proposals" class="tab-pane fade show active">
                   <div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
								<th>Proposal's Title</th>
								<th>Proposal's Price </th>
								<th>Views</th>
								<th>Orders</th>
								<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
                                    $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
                                    $count_proposals = $select_proposals->rowCount();
                                    while($row_proposals = $select_proposals->fetch()){
                                    $proposal_id = $row_proposals->proposal_id;
                                    $proposal_title = $row_proposals->proposal_title;
                                    $proposal_views = $row_proposals->proposal_views;
                                    $proposal_price = $row_proposals->proposal_price;
									if($proposal_price == 0){
									$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
									$proposal_price = $get_p->fetch()->price;
									}
                                    $proposal_img1 = $row_proposals->proposal_img1;
                                    $proposal_url = $row_proposals->proposal_url;
                                    $proposal_featured = $row_proposals->proposal_featured;
									$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                                ?>
								<tr>
									<td class="proposal-title"> <?php echo $proposal_title; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $proposal_price; ?> </td>
									<td><?php echo $proposal_views; ?></td>
									<td><?php echo $count_orders; ?></td>
									<td class="text-center">
										<div class="dropdown">
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
										<div class="dropdown-menu">
										<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>" class="dropdown-item"> Preview </a>
                                        <?php if($proposal_featured == "no"){ ?>
										<a href="#" class="dropdown-item" id="featured-button-<?php echo $proposal_id; ?>">Make Proposal Featured</a>
                                        <?php }else{ ?>
                                        <a href="#" class="dropdown-item text-success">Already Featured </a>
                                        <?php } ?>
										<a href="pause_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Deactivate Proposal</a>
                                        <a href="view_coupons?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> View Coupons</a>
                                        <a href="view_referrals?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> View Referrals</a>
										<a href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Edit </a>
										<a href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Delete </a>
										</div>
										</div>
										<script>
										$("#featured-button-<?php echo $proposal_id; ?>").click(function(){
										proposal_id = "<?php echo $proposal_id; ?>";
										$.ajax({
										  method: "POST",
										  url: "pay_featured_listing",
										  data: {proposal_id: proposal_id }
										}).done(function(data){
										$("#featured-proposal-modal").html(data);	
										});	
										});
										</script>
									</td>
								</tr>
                                <?php } ?>
							</tbody>
						</table>
                       <?php
                            if($count_proposals == 0){
                                echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-meh-o'></i> You currently have no proposals/services to sell.</h3></center>";
                            }
                       ?>
					</div>
				</div>
					<div id="pause-proposals" class="tab-pane fade show">
                   <div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Proposal's Title</th>
									<th>Proposal's Price </th>
									<th>Views</th>
									<th>Orders</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
								$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'pause'));
                                $count_proposals = $select_proposals->rowCount();
                                while($row_proposals = $select_proposals->fetch()){
                                $proposal_id = $row_proposals->proposal_id;
                                $proposal_title = $row_proposals->proposal_title;
                                $proposal_views = $row_proposals->proposal_views;
                                $proposal_price = $row_proposals->proposal_price;
								if($proposal_price == 0){
								$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
								$proposal_price = $get_p->fetch()->price;
								}
                                $proposal_img1 = $row_proposals->proposal_img1;
                                $proposal_url = $row_proposals->proposal_url;
                                $proposal_featured = $row_proposals->proposal_featured;
								$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                                ?>
								<tr>
									<td class="proposal-title"> <?php echo $proposal_title; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $proposal_price; ?> </td>
									<td><?php echo $proposal_views; ?></td>
									<td><?php echo $count_orders; ?></td>
									<td class="text-center">
										<div class="dropdown">
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
										<div class="dropdown-menu">
										<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>" class="dropdown-item"> Preview </a>
										<a href="activate_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Activate Proposal </a>
										<a href="view_referrals?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> View Referrals</a>
										<a href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Edit </a>
										<a href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Delete </a>
										</div>
										</div>
									</td>
								</tr>
                              <?php } ?>
							</tbody>
						</table>
                       <?php
                            if($count_proposals == 0){
                                echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no paused proposals/services.</h3></center>";
                            }
                       ?>
					</div>
				</div>
				<div id="pending-proposals" class="tab-pane fade show">
                   <div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Proposal's Title</th>
									<th>Proposal's Price </th>
									<th>Views</th>
									<th>Orders</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
									$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'pending'));
									$count_proposals = $select_proposals->rowCount();
                                    while($row_proposals = $select_proposals->fetch()){
                                    $proposal_id = $row_proposals->proposal_id;
                                    $proposal_title = $row_proposals->proposal_title;
                                    $proposal_views = $row_proposals->proposal_views;
                                    $proposal_price = $row_proposals->proposal_price;
									if($proposal_price == 0){
									$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
									$proposal_price = $get_p->fetch()->price;
									}
                                    $proposal_img1 = $row_proposals->proposal_img1;
                                    $proposal_url = $row_proposals->proposal_url;
                                    $proposal_featured = $row_proposals->proposal_featured;
									$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                                ?>
								<tr>
									<td class="proposal-title"> <?php echo $proposal_title; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $proposal_price; ?> </td>
									<td><?php echo $proposal_views; ?></td>
									<td><?php echo $count_orders; ?></td>
									<td class="text-center">
										<div class="dropdown">
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
										<div class="dropdown-menu">
										<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>" class="dropdown-item"> Preview </a>
										<a href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Edit </a>
										<a href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Delete </a>
										</div>
										</div>
									</td>
								</tr>
                              <?php } ?>
							</tbody>
						</table>
                        <?php
                            if($count_proposals == 0){
                                echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no proposals/services pending.</h3></center>";
                            }
                       ?>
					</div>
				</div>
         	<div id="modification-proposals" class="tab-pane fade show">
                   <div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Modification Proposal Title</th>
									<th>Modification Message</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
									$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'modification'));
                                    $count_proposals = $select_proposals->rowCount();
                                    while($row_proposals = $select_proposals->fetch()){
                                    $proposal_id = $row_proposals->proposal_id;
                                    $proposal_title = $row_proposals->proposal_title;
                                    $proposal_url = $row_proposals->proposal_url;
									$select_modification = $db->select("proposal_modifications",array("proposal_id"=>$proposal_id));
                                    $row_modification = $select_modification->fetch();
                                    $modification_message = $row_modification->modification_message;
                                ?>
								<tr>
									<td class="proposal-title"> <?php echo $proposal_title; ?> </td>
									<td> <?php echo $modification_message; ?></td>
									<td class="text-center">
										<div class="dropdown">
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
										<div class="dropdown-menu">
										<a href="submit_approval?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Submit For Approval </a>
										<a href="<?php echo $login_seller_user_name; ?>/<?php echo $proposal_url; ?>" class="dropdown-item"> Preview </a>
										<a href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Edit </a>
										<a href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Delete </a>
										</div>
										</div>
									</td>
								</tr>
                                <?php } ?>
							</tbody>
						</table>
                       <?php
                            if($count_proposals == 0){
                                echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no modifications requested.</h3></center>";
                            }
                       ?>
					</div>
				</div>
				<div id="draft-proposals" class="tab-pane fade show">
                   <div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Proposal's Title</th>
									<th>Proposal's Price </th>
									<th>Views</th>
									<th>Orders</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
									$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'draft'));
									$count_proposals = $select_proposals->rowCount();
                                    while($row_proposals = $select_proposals->fetch()){
                                    $proposal_id = $row_proposals->proposal_id;
                                    $proposal_title = $row_proposals->proposal_title;
                                    $proposal_views = $row_proposals->proposal_views;
                                    $proposal_price = $row_proposals->proposal_price;
									if($proposal_price == 0){
									$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
									$proposal_price = $get_p->fetch()->price;
									}
                                    $proposal_img1 = $row_proposals->proposal_img1;
                                    $proposal_url = $row_proposals->proposal_url;
                                    $proposal_featured = $row_proposals->proposal_featured;
									$count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                                ?>
								<tr>
									<td class="proposal-title"> <?php echo $proposal_title; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $proposal_price; ?> </td>
									<td><?php echo $proposal_views; ?></td>
									<td><?php echo $count_orders; ?></td>
									<td class="text-center">
										<div class="dropdown">
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
										<div class="dropdown-menu">
										<a href="edit_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Edit </a>
										<a href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Delete </a>
										</div>
										</div>
									</td>
								</tr>
                              <?php } ?>
							</tbody>
						</table>
                       <?php
                        if($count_proposals == 0){
                          echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no proposals/services in draft.</h3></center>";
                        }
                       ?>
					</div>
				</div>
				<div id="declined-proposals" class="tab-pane fade show">
                   <div class="table-responsive box-table mt-4">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Proposal's Title</th>
									<th>Proposal's Price </th>
									<th>Views</th>
									<th>Orders</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                <?php
								$select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'declined'));
                                $count_proposals = $select_proposals->rowCount();
                                while($row_proposals = $select_proposals->fetch()){
                                $proposal_id = $row_proposals->proposal_id;
                                $proposal_title = $row_proposals->proposal_title;
                                $proposal_views = $row_proposals->proposal_views;
                                $proposal_price = $row_proposals->proposal_price;
								if($proposal_price == 0){
								$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
								$proposal_price = $get_p->fetch()->price;
								}
                                $proposal_img1 = $row_proposals->proposal_img1;
                                $proposal_url = $row_proposals->proposal_url;
                                $proposal_featured = $row_proposals->proposal_featured;
                                $count_orders = $db->count("orders",array("proposal_id"=>$proposal_id));
                                ?>
								<tr>
									<td class="proposal-title"> <?php echo $proposal_title; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $proposal_price; ?> </td>
									<td><?php echo $proposal_views; ?></td>
									<td><?php echo $count_orders; ?></td>
									<td class="text-center">
										<div class="dropdown">
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
										<div class="dropdown-menu">
										<a href="delete_proposal?proposal_id=<?php echo $proposal_id; ?>" class="dropdown-item"> Delete </a>
										</div>
										</div>
									</td>
								</tr>
                              <?php } ?>
							</tbody>
						</table>
                        <?php
                            if($count_proposals == 0){
                                echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no proposals/services declined.</h3></center>";
                            }
                       ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->
<div id="featured-proposal-modal"></div>
<?php require_once("../includes/footer.php"); ?>
</body>
</html>