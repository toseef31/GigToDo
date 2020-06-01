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

?>

<!DOCTYPE html>
<html lang="en" class="ui-toolkit">

<head>

	<title><?php echo $site_name; ?> - <?php echo $lang["titles"]["manage_requests"]; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">

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
  <link href="../styles/custom.css" rel="stylesheet">  -->
    <!-- Custom css code from modified in admin panel --->
	<link href="../styles/styles.css" rel="stylesheet">
	<!-- <link href="../styles/user_nav_styles.css" rel="stylesheet"> -->
	<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../styles/sweat_alert.css" rel="stylesheet">
  <link href="../styles/animate.css" rel="stylesheet">
  <script type="text/javascript" src="../js/sweat_alert.js"></script>
	<script type="text/javascript" src="../js/jquery.min.js"></script>

</head>

<body class="all-content">

<?php require_once("../includes/buyer-header.php"); ?>

	<main>
		<section class="container-fluid list-page">
			<div class="row">
				<div class="container">
					<div class="row align-items-start">
						<div class="col-12 col-sm-6">
							<h1 class="list-page-title"> إدارة الوظائف </h1>
						</div>
						<div class="col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-end">
							<a class="button button-red" href="post-request">
								انشر طلب
							</a>
						</div>
					</div>
					<!-- Row -->
					<div class="list-page-filter">
						<div class="row flex-md-row-reverse">
							<div class="col-12 col-md-6">
								<!-- <ul class="pagination">
									<li class="pagination-item">
										<a class="pagination-link" href="javascript:void(0);">
											<i class="fal fa-angle-right"></i>
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
											<i class="fal fa-angle-left"></i>
										</a>
									</li>
								</ul> -->
							</div>
							<div class="col-12 col-md-6">
								<nav class="list-page-nav">
									<div class="nav nav-tabs" id="nav-tab" role="tablist">
										<a class="nav-item nav-link limerick active" id="active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="true">نشيط <span class="badge">3</span></a>
										<a class="nav-item nav-link selective-yellow" id="paused-tab" data-toggle="tab" href="#nav-paused" role="tab" aria-controls="nav-paused" aria-selected="false">متوقف <span class="badge">2</span></a>
										<?php
                    	$count_requests = $db->count("buyer_requests",array("seller_id" => $login_seller_id, "request_status" => 'pending'));
                		?>
										<a class="nav-item nav-link selective-blue" id="pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="false">ما زال يحتاج بتصدير  <span class="badge"><?php echo $count_requests; ?></span></a>
										<?php
										  $count_requests = $db->count("buyer_requests",array("seller_id" => $login_seller_id, "request_status" => 'unapproved'))
										?>
										<a class="nav-item nav-link selective-red" id="unapproved-tab" data-toggle="tab" href="#nav-unapproved" role="tab" aria-controls="nav-unapproved" aria-selected="false">غير معتمد <span class="badge"><?php echo $count_requests; ?></span></a>
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
									<table class="table managerequest-table limerick" cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr role="row">
												<th role="column">
													التاريخ
												</th>
												<th role="column">
													الطلب
												</th>
												<th role="column">
													العروض
												</th>
												<th role="column">
													التسليم
												</th>
												<th role="column">
													الميزانية
												</th>
												<th role="column">
													الأحداث
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "active"),"DESC");
											
											$count_requests = $get_requests->rowCount();
											while($row_requests = $get_requests->fetch()){
											$request_id = $row_requests->request_id;
											$request_title = $row_requests->request_title;
											$request_description = $row_requests->request_description;
											$request_date = $row_requests->request_date;
											$request_budget = $row_requests->request_budget;
											$request_delivery = $row_requests->delivery_time;
											$request_skills = explode(',', $row_requests->skills_required);
											
											$count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
											?>
											<tr role="row">
												<td data-label="التاريخ">
													<?php echo $request_date; ?>
												</td>
												<td data-label="الطلب">
													<p><?php echo $request_description; ?></p>
													<div class="tags">
														<?php foreach ($request_skills as $key => $skills) { ?>
															<a href="javascript:void(0);" class="taga-item"><?php echo $skills; ?></a>
														<?php } ?>
													</div>
												</td>
												<td data-label="العروض">
													<a href="javascript:void(0);" class="offers-button">
														<?php echo $count_offers; ?> عروض
													</a>
												</td>
												<td data-label="التسليم">
													<?php echo $request_delivery; ?>
												</td>
												<td data-label="الميزانية">
													<?php echo $s_currency; ?><?php echo $request_budget; ?>
												</td>
												<td data-label="الأحداث">
													<div class="dropdown">
														<a class="action-link dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuLink">
															<a class="dropdown-item" href="view_offers?request_id=<?php echo $request_id; ?>">
																عرض العروض
															</a>
															<a class="dropdown-item" href="pause_request?request_id=<?php echo $request_id; ?>">
																وقفة
															</a>
															<a class="dropdown-item" href="delete_request?request_id=<?php echo $request_id; ?>">
																حذف
															</a>
														</div>
													</div>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php
									  if($count_requests == 0){   
									      echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-meh-o'></i> لم تنشر أي طلبات في الوقت الحالي. </h3></center>";
									  }
									?>
								</div>
								<div class="tab-pane fade" id="nav-paused" role="tabpanel" aria-labelledby="paused-tab">
									<table class="table managerequest-table selective-yellow" cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr role="row">
												<th role="column">
													التاريخ
												</th>
												<th role="column">
													الطلب
												</th>
												<th role="column">
													العروض
												</th>
												<th role="column">
													التسليم
												</th>
												<th role="column">
													الميزانية
												</th>
												<th role="column">
													الأحداث
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "pause"),"DESC");
										
											   $count_requests = $get_requests->rowCount();

											   while($row_requests = $get_requests->fetch()){
											   $request_id = $row_requests->request_id;
											   $request_title = $row_requests->request_title;
											   $request_description = $row_requests->request_description;
											   $request_date = $row_requests->request_date;
											   $request_budget = $row_requests->request_budget;
											   $request_delivery = $row_requests->delivery_time;
											   $request_skills = explode(',', $row_requests->skills_required);

											   $count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
											?>
											<tr role="row">
												<td data-label="التاريخ">
													<?php echo $request_date; ?>
												</td>
												<td data-label="الطلب">
													<p><?php echo $request_description; ?></p>
													<div class="tags">
														<?php foreach ($request_skills as $key => $skills) { ?>
															<a href="javascript:void(0);" class="taga-item"><?php echo $skills; ?></a>
														<?php } ?>
													</div>
												</td>
												<td data-label="العروض">
													<a href="javascript:void(0);" class="offers-button">
														<?php echo $count_offers; ?> عروض
													</a>
												</td>
												<td data-label="التسليم">
													<?php echo $request_delivery; ?>
												</td>
												<td data-label="الميزانية">
													<?php echo $s_currency; ?><?php echo $request_budget; ?>
												</td>
												<td data-label="الأحداث">
													<div class="dropdown">
														<a class="action-link dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuLink">
															<a class="dropdown-item" href="active_request?request_id=<?php echo $request_id; ?>">
																تفعيل
															</a>
															<a class="dropdown-item" href="delete_request?request_id=<?php echo $request_id; ?>">
																حذف
															</a>
														</div>
													</div>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php
									  if($count_requests == 0){
									    echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> ليس لديك حاليًا أي طلبات متوقفة مؤقتًا. </h3></center>";
									  }
									?>
								</div>
								<div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="pending-tab">
									<table class="table managerequest-table selective-blue" cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr role="row">
												<th role="column">
													التاريخ
												</th>
												<th role="column">
													الطلب
												</th>
												<th role="column">
													العروض
												</th>
												<th role="column">
													التسليم
												</th>
												<th role="column">
													الميزانية
												</th>
												<th role="column">
													الأحداث
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "pending"),"DESC");
										
											   $count_requests = $get_requests->rowCount();

											   while($row_requests = $get_requests->fetch()){
											   $request_id = $row_requests->request_id;
											   $request_title = $row_requests->request_title;
											   $request_description = $row_requests->request_description;
											   $request_date = $row_requests->request_date;
											   $request_budget = $row_requests->request_budget;
											   $request_delivery = $row_requests->delivery_time;
											   $request_skills = explode(',', $row_requests->skills_required);

											   $count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
											?>
											<tr role="row">
												<td data-label="التاريخ">
													<?php echo $request_date; ?>
												</td>
												<td data-label="الطلب">
													<p><?php echo $request_description; ?></p>
													<div class="tags">
														<?php foreach ($request_skills as $key => $skills) { ?>
															<a href="javascript:void(0);" class="taga-item"><?php echo $skills; ?></a>
														<?php } ?>
													</div>
												</td>
												<td data-label="العروض">
													<a href="javascript:void(0);" class="offers-button">
														<?php echo $count_offers; ?> عروض
													</a>
												</td>
												<td data-label="التسليم">
													<?php echo $request_delivery; ?>
												</td>
												<td data-label="الميزانية">
													<?php echo $s_currency; ?><?php echo $request_budget; ?>
												</td>
												<td data-label="الأحداث">
													<div class="dropdown">
														<a class="action-link dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuLink">
															<a class="dropdown-item" href="delete_request?request_id=<?php echo $request_id; ?>">
																حذف
															</a>
														</div>
													</div>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php
									  if($count_requests == 0){
									    echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i>ليس لديك حاليا أي طلبات معلقة.</h3></center>";
									  }
									?>
								</div>
								<div class="tab-pane fade" id="nav-unapproved" role="tabpanel" aria-labelledby="unapproved-tab">
									<table class="table managerequest-table selective-red" cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr role="row">
												<th role="column">
													التاريخ
												</th>
												<th role="column">
													الطلب
												</th>
												<th role="column">
													العروض
												</th>
												<th role="column">
													التسليم
												</th>
												<th role="column">
													الميزانية
												</th>
												<th role="column">
													الأحداث
												</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "unapproved"),"DESC");
										
											   $count_requests = $get_requests->rowCount();

											   while($row_requests = $get_requests->fetch()){
											   $request_id = $row_requests->request_id;
											   $request_title = $row_requests->request_title;
											   $request_description = $row_requests->request_description;
											   $request_date = $row_requests->request_date;
											   $request_budget = $row_requests->request_budget;
											   $request_delivery = $row_requests->delivery_time;
											   $request_skills = explode(',', $row_requests->skills_required);

											   $count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
											?>
											<tr role="row">
												<td data-label="التاريخ">
													<?php echo $request_date; ?>
												</td>
												<td data-label="الطلب">
													<p><?php echo $request_description; ?></p>
													<div class="tags">
														<?php foreach ($request_skills as $key => $skills) { ?>
															<a href="javascript:void(0);" class="taga-item"><?php echo $skills; ?></a>
														<?php } ?>
													</div>
												</td>
												<td data-label="العروض">
													<a href="javascript:void(0);" class="offers-button">
														<?php echo $count_offers; ?> عروض
													</a>
												</td>
												<td data-label="التسليم">
													<?php echo $request_delivery; ?>
												</td>
												<td data-label="الميزانية">
													<?php echo $s_currency; ?><?php echo $request_budget; ?>
												</td>
												<td data-label="الأحداث">
													<div class="dropdown">
														<a class="action-link dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="far fa-cog"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuLink">
															<a class="dropdown-item" href="delete_request?request_id=<?php echo $request_id; ?>">
																حذف
															</a>
														</div>
													</div>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php
									  if($count_requests == 0){
									    echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> ليس لديك حاليًا أي طلبات غير معتمدة.</h3></center>";
									  }
									?>
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

<!-- <div class="container-fluid mt-5">
	<div class="row">
		<div class="col-md-12 mb-4">
			<h1 class="pull-left"> <?php echo $lang["titles"]["manage_requests"]; ?> </h1>
			<a href="post_request" class="btn btn-success pull-right">
				<i class="fa fa-plus-circle"></i> Post New Request
			</a>
		</div>
		<div class="col-md-12">
			<ul class="nav nav-tabs flex-column flex-sm-row  mt-4">
				
				<?php
				$count_requests = $db->count("buyer_requests",array("seller_id" => $login_seller_id, "request_status" => 'active'));
				?>
				<li class="nav-item">
					<a href="#active" data-toggle="tab" class="nav-link active make-black">
						
						<?= $lang['tabs']['active_requests']; ?> <span class="badge badge-success"><?php echo $count_requests; ?></span>
						
					</a>
				</li>
				<?php
				$count_requests = $db->count("buyer_requests",array("seller_id" => $login_seller_id, "request_status" => 'pause'));
				?>
				<li class="nav-item">
					<a href="#pause" data-toggle="tab" class="nav-link make-black">
						<?= $lang['tabs']['pause_requests']; ?> <span class="badge badge-success"><?php echo $count_requests; ?></span>
					</a>
				</li>
				<?php
				$count_requests = $db->count("buyer_requests",array("seller_id" => $login_seller_id, "request_status" => 'pending'));
				?>
				<li class="nav-item">
					<a href="#pending" data-toggle="tab" class="nav-link make-black">
						<?= $lang['tabs']['pending_approval']; ?> <span class="badge badge-success"><?php echo $count_requests; ?></span>
						
					</a>
				</li>
				<?php
				$count_requests = $db->count("buyer_requests",array("seller_id" => $login_seller_id, "request_status" => 'unapproved'))
				?>
				<li class="nav-item">
					<a href="#unapproved" data-toggle="tab" class="nav-link make-black">
						<?= $lang['tabs']['unapproved']; ?> <span class="badge badge-success"><?php echo $count_requests; ?></span>
						
					</a>
					
				</li>
				
			</ul>
			<div class="tab-content mt-4">
				<div id="active" class="tab-pane fade show active">
					<div class="table-responsive box-table">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Title</th>
									<th>Description</th>
									<th>Date</th>
									<th>Offers</th>
									<th>Budget</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
								$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "active"),"DESC");
								
								$count_requests = $get_requests->rowCount();
								while($row_requests = $get_requests->fetch()){
								$request_id = $row_requests->request_id;
								$request_title = $row_requests->request_title;
								$request_description = $row_requests->request_description;
								$request_date = $row_requests->request_date;
								$request_budget = $row_requests->request_budget;
								$count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
								?>
								<tr>
									<td> <?php echo $request_title; ?> </td>
									<td>
										<?php echo $request_description; ?>
									</td>
									<td> <?php echo $request_date; ?> </td>
									<td> <?php echo $count_offers; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $request_budget; ?> </td>
									<td class="text-center">
										<div class="dropdown">
											<button class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
											<div class="dropdown-menu">
												<a href="view_offers?request_id=<?php echo $request_id; ?>" target="blank" class="dropdown-item">
													View Offers
												</a>
												<a href="pause_request?request_id=<?php echo $request_id; ?>" class="dropdown-item">
													Pause
												</a>
												<a href="delete_request?request_id=<?php echo $request_id; ?>" class="dropdown-item">
													Delete
												</a>
											</div>
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php
						if($count_requests == 0){
						echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-meh-o'></i> You've posted no requests at the moment.</h3></center>";
						}
						?>
					</div>
				</div>
				<div id="pause" class="tab-pane fade">
					<div class="table-responsive box-table">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Title</th>
									<th>Description</th>
									<th>Date</th>
									<th>Offers</th>
									<th>Budget</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "pause"),"DESC");
								
								$count_requests = $get_requests->rowCount();
								while($row_requests = $get_requests->fetch()){
								$request_id = $row_requests->request_id;
								$request_title = $row_requests->request_title;
								$request_description = $row_requests->request_description;
								$request_date = $row_requests->request_date;
								$request_budget = $row_requests->request_budget;
								$count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
								?>
								<tr>
									<td> <?php echo $request_title; ?> </td>
									<td>
										<?php echo $request_description; ?>
									</td>
									<td> <?php echo $request_date; ?></td>
									<td><?php echo $count_offers; ?> </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $request_budget; ?> </td>
									<td class="text-center">
										<div class="dropdown">
											<button class="btn btn-success dropdown-toggle" data-toggle="dropdown" ></button>
											<div class="dropdown-menu">
												<a href="active_request?request_id=<?php echo $request_id; ?>" class="dropdown-item">
													Activate
												</a>
												<a href="delete_request?request_id=<?php echo $request_id; ?>" class="dropdown-item">
													Delete
												</a>
											</div>
										</div>
									</td>
								</tr>
								
								<?php } ?>
							</tbody>
						</table>
						
						<?php
						
						if($count_requests == 0){
						
						echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no requests paused.</h3></center>";
						}
						?>
					</div>
				</div>
				<div id="pending" class="tab-pane fade">
					<div class="table-responsive box-table">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Title</th>
									<th>Description</th>
									<th>Date</th>
									<th>Offers</th>
									<th>Budget</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "pending"),"DESC");
								
								$count_requests = $get_requests->rowCount();
								while($row_requests = $get_requests->fetch()){
								$request_id = $row_requests->request_id;
								$request_title = $row_requests->request_title;
								$request_description = $row_requests->request_description;
								$request_date = $row_requests->request_date;
								$request_budget = $row_requests->request_budget;
								?>
								<tr>
									<td> <?php echo $request_title; ?> </td>
									<td>
										<?php echo $request_description; ?>
									</td>
									<td> <?php echo $request_date; ?>  </td>
									<td> 0  </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $request_budget; ?>  </td>
									<td>
										<a href="delete_request?request_id=<?php echo $request_id; ?>" class="btn btn-outline-danger">
											Delete
										</a>
									</td>
								</tr>
								
								<?php } ?>
							</tbody>
						</table>
						
						<?php
						
						if($count_requests == 0){
						
						echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no requests pending.</h3></center>";
						}
						
						
						
						?>
					</div>
				</div>
				<div id="unapproved" class="tab-pane fade">
					<div class="table-responsive box-table">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Title</th>
									<th>Description</th>
									<th>Date</th>
									<th>Offers</th>
									<th>Budget</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "unapproved"),"DESC");
								
								$count_requests = $get_requests->rowCount();
								while($row_requests = $get_requests->fetch()){
								$request_id = $row_requests->request_id;
								$request_title = $row_requests->request_title;
								$request_description = $row_requests->request_description;
								$request_date = $row_requests->request_date;
								$request_budget = $row_requests->request_budget;
								?>
								<tr>
									<td> <?php echo $request_title; ?> </td>
									<td>
										<?php echo $request_description; ?>
									</td>
									<td><?php echo $request_date; ?> </td>
									<td> 0 </td>
									<td class="text-success"> <?php echo $s_currency; ?><?php echo $request_budget; ?> </td>
									<td>
										<a href="delete_request?request_id=<?php echo $request_id; ?>" class="btn btn-outline-danger">
											Delete
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php
						if($count_requests == 0){
						
						echo "<center><h3 class='pt-4 pb-4'><i class='fa fa-smile-o'></i> You currently have no unapproved requests.</h3></center>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->
<?php require_once("../includes/footer.php"); ?>
</body>
</html>