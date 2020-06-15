<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once("includes/db.php");
require_once("functions/email.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_account_type = $row_login_seller->account_type;
$login_seller_name = $row_login_seller->seller_name;
$login_seller_referral = $row_login_seller->seller_referral;
$referral_money = $row_general_settings->referral_money;
?>
<!DOCTYPE html>
<html  dir="rtl" lang="ar" class="ui-toolkit">
	<head>
		<title><?php echo $site_name; ?> - Invite a Friend </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php echo $site_desc; ?>">
		<meta name="keywords" content="<?php echo $site_keywords; ?>">
		<meta name="author" content="<?php echo $site_author; ?>">
		<!--====== Favicon Icon ======-->
		<?php if(!empty($site_favicon)){ ?>
		<link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
		<?php } ?>
		<!--====== Bootstrap css ======-->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!--====== PreLoader css ======-->
		<link href="assets/css/preloader.css" rel="stylesheet">
		<!--====== Animate css ======-->
		<link href="assets/css/animate.min.css" rel="stylesheet">
		<!--====== Fontawesome css ======-->
		<link href="assets/css/fontawesome.min.css" rel="stylesheet">
		<!--====== Owl carousel css ======-->
		<link href="assets/css/owl.carousel.min.css" rel="stylesheet">
		<!--====== Nice select css ======-->
		<link href="assets/css/nice-select.css" rel="stylesheet">
		<!--====== Range Slider css ======-->
		<link href="assets/css/ion.rangeSlider.min.css" rel="stylesheet">
		<!--====== Default css ======-->
		<link href="assets/css/default.css" rel="stylesheet">
		<!--====== Style css ======-->
		<link href="assets/css/style.css" rel="stylesheet">
		<!--====== Responsive css ======-->
		<link href="assets/css/responsive.css" rel="stylesheet">
		<link href="styles/bootstrap.css" rel="stylesheet">
		<link href="styles/custom.css" rel="stylesheet">
		<!-- Custom css code from modified in admin panel --->
		<link href="styles/styles.css" rel="stylesheet">
		<link href="styles/user_nav_styles.css" rel="stylesheet">
		<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.min.js"></script>
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
			if ($login_seller_account_type == "seller") {
				require_once("includes/user_header.php"); 
			}else{
				require_once("includes/buyer-header.php");
			}
		?>

		<main>
				<section class="container-fluid invite-friends" style="background-image: url(assets/img/invite/background-image.png);">
					<div class="row">
						<div class="container">
							<div class="row align-items-end">
								<div class="col-12 col-md-5 d-none d-md-block">
									<img class="img-fluid d-block ml-auto mr-auto" src="assets/img/invite/invite-firends-img.png" />
								</div>
								<div class="col-12 col-md-7">
									<div class="d-flex flex-column align-items-center">
										<h1 class="text-center">قم بدعوة اصدقائك واحصل على 5 $</h1>
										<p class="text-center">احصل على خصم 20 جنيه مصرى على عملية شرائك القادمة</p>
										<form method="POST" action="">
											<input type="hidden" name="referral_link" value="<?php echo $site_url; ?>?referral=<?php echo $login_seller_referral; ?>">
											<div class="input-group flex-nowrap flex-row">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<img class="img-fluid d-block" src="assets/img/invite/email-icon.png" />
													</div>
												</div>
												<input type="text" name="email_addresses" class="form-control" />
												<div class="input-group-prepend">
													<button type="submit" name="send_email">البحث</button>
												</div>
											</div>
											<label class="text-center control-label">افصل رسائل البريد الالكترونى بفواصل</label>
										</form>
										<p class="text-center">شارك مع العديد من الاصدقاء واكسب المزيد من المال</p>
										<ul class="list-inline d-flex flex-row align-items-center justify-content-center">
											<li class="list-inline-item">
												<a class="list-inline-link facebook" href="javascript:void(0)">
													<i class="fab fa-facebook-f"></i>
												</a>
											</li>
											<li class="list-inline-item">
												<a class="list-inline-link twitter" href="javascript:void(0)">
													<i class="fab fa-twitter"></i>
												</a>
											</li>
											<li class="list-inline-item">
												<a class="list-inline-link youtube" href="javascript:void(0)">
													<i class="fab fa-youtube"></i>
												</a>
											</li>
											<li class="list-inline-item">
												<a class="list-inline-link linkedin" href="javascript:void(0)">
													<i class="fab fa-linkedin-in"></i>
												</a>
											</li>
											<li class="list-inline-item">
												<a class="list-inline-link instagram" href="javascript:void(0)">
													<i class="fab fa-instagram"></i>
												</a>
											</li>
										</ul>
										<h6 class="text-center">برنامج الإحالة <a href="javascript:void(0);">الشروط والأحكام</a></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</main>

		<!-- <div class="container-fluid">
			<div class="row">
				<div class="col-lg-10 col-md-10 mt-5 mb-5">
					<div class="card rounded-0">
						<div class="card-body">
							<h1> <?php echo $lang["titles"]["my_referrals"]; ?> </h1>
							<p class="lead">
								<?php
								$tr = $lang['my_referrals']['desc'];
								$tr = str_replace("{s_currency}",$s_currency, $tr);
								$tr = str_replace("{referral_money}",$referral_money, $tr);
								echo $tr;
								?>
							</p>
							<h4 class="border border-primary rounded p-3">
							<?= $lang['my_referrals']['link']; ?>
							<mark> <?php echo $site_url; ?>?referral=<?php echo $login_seller_referral; ?> </mark>
							</h4>
							<p class="lead text-danger"><?= $lang['my_referrals']['note']; ?></p>
							<div class="row">
								<div class="col-md-4 mb-3">
									<div class="card text-white border-success">
										<div class="card-header text-center bg-success">
											<div class="display-4"> <?php echo $s_currency; ?><?php
												$select = $db->query("SELECT SUM(comission) AS total FROM referrals where seller_id='$login_seller_id' AND status='approved'");
												$total = $select->fetch()->total;
												echo $total > 0 || $total!==null ? $total : "0";
												?>
												
											</div>
											<div class="font-weight-bold"><?= $lang['referrals']['approved']; ?></div>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="card text-white border-secondary">
										<div class="card-header text-center bg-secondary">
											<div class="display-4"> <?php echo $s_currency; ?><?php
												$select = $db->query("SELECT SUM(comission) AS total FROM referrals where seller_id='$login_seller_id' AND status='pending'");
												$total = $select->fetch()->total;
												echo $total > 0 || $total!==null ? $total : "0";
												?>
											</div>
											<div class="font-weight-bold"><?= $lang['referrals']['pending']; ?></div>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="card text-white border-danger">
										<div class="card-header text-center bg-danger">
											<div class="display-4"> <?php echo $s_currency; ?><?php
												$select = $db->query("SELECT SUM(comission) AS total FROM referrals where seller_id='$login_seller_id' AND status='declined'");
												$total = $select->fetch()->total;
												echo $total > 0 || $total!==null ? $total : "0";
												?>
												
											</div>
											<div class="font-weight-bold"><?= $lang['referrals']['declined']; ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="table-responsive border border-secondary rounded">
								<table class="table table-bordered">
									<thead>
										<tr class="card-header">
											<th>Username</th>
											<th>Signup Date</th>
											<th>Your Commision</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										
										<?php
										$sel_referrals = $db->select("referrals",array("seller_id" => $login_seller_id),"DESC");
										$count_referrals = $sel_referrals->rowCount();
										if($count_referrals == 0){
										echo "
										<tr>
											<td class='text-center' colspan='4'>
												<h3 class='pb-2 pt-2'><i class='fa fa-meh-o'></i> You have not refered anyone yet.</h3>
											</td>
										</tr>
											";
										}else{
										while($row_referrals = $sel_referrals->fetch()){
										$referred_id = $row_referrals->referred_id;
										$comission = $row_referrals->comission;
										$date = $row_referrals->date;
										$status = $row_referrals->status;
																	$select_seller = $db->select("sellers",array("seller_id" => $referred_id));
																	$row_seller = $select_seller->fetch();
																		$seller_user_name = $row_seller->seller_user_name;
										?>
										<tr>
											<td><?php echo $seller_user_name; ?></td>
											<td><?php echo $date; ?></td>
											<td><?php echo $s_currency; ?><?php echo $comission; ?></td>
											<td class="font-weight-bold
												
												<?php
												if($status == "approved"){
												echo "text-success";
												}elseif($status == "pending"){
												echo "text-secondary";
												}elseif($status == "declined"){
												echo "text-danger";
												}
												?>
												"> <?php echo $status; ?>
												
											</td>
										</tr>
										
										<?php } } ?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
<?php 
	if (isset($_POST['send_email'])) {
		$referral_link = $input->post('referral_link');
		$email_addresses = $input->post('email_addresses');	
		$username = $login_seller_name;

		inviteEmail($email_addresses,$referral_link,$username);
	}
?>
		<?php require_once("includes/footer.php"); ?>
	</body>
</html>