<?php
session_start();
require_once("includes/db.php");
require_once("functions/email.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_name = $row_login_seller->seller_name;
$login_seller_email = $row_login_seller->seller_email;
$login_seller_paypal_email = $row_login_seller->seller_paypal_email;
$login_seller_payoneer_email = $row_login_seller->seller_payoneer_email;
$login_seller_image = $row_login_seller->seller_image;
$login_seller_cover_image = $row_login_seller->seller_cover_image;
$login_seller_headline = $row_login_seller->seller_headline;
$login_seller_country = $row_login_seller->seller_country;
$login_seller_timzeone = $row_login_seller->seller_timezone;
$login_seller_language = $row_login_seller->seller_language;
$login_seller_about = $row_login_seller->seller_about;
$login_seller_account_number = $row_login_seller->seller_m_account_number;
$login_seller_account_name = $row_login_seller->seller_m_account_name;
$login_seller_wallet = $row_login_seller->seller_wallet;
$login_seller_enable_sound = $row_login_seller->enable_sound;
$login_seller_verification = $row_login_seller->seller_verification;

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

if($lang_dir == "right"){
	$floatRight = "";
}else{
	$floatRight = "float-right";
}

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<title><?php echo $site_name; ?> - <?php echo $lang["settings"]; ?> </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
	
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
	<link href="assets/css/tagsinput.css" rel="stylesheet">
	<!--====== Default css ======-->
	<link href="assets/css/default.css" rel="stylesheet">
	<!--====== Style css ======-->
	<link href="assets/css/style.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet"> --> 
  <!-- Custom css code from modified in admin panel --->
	<!-- <link href="styles/styles.css" rel="stylesheet">
	<link href="styles/user_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
	<link href="styles/croppie.css" rel="stylesheet">
	<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/croppie.js"></script>
	<?php if($paymentGateway == 1){ ?>
	<script src="plugins/paymentGateway/javascript/script.js"></script>
	<?php } ?>
	<?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
	<script src="<?php echo $site_url; ?>/js/jquery.easy-autocomplete.min.js"></script>
	<link href="<?php echo $site_url; ?>/styles/easy-autocomplete.min.css" rel="stylesheet">
	<style>
		.profile-edit-step-item{
			cursor: pointer;
		}
		.icontext{
			left: -webkit-calc(50% - (33px / 2));
	    left: -moz-calc(50% - (33px / 2));
	    left: calc(50% - (33px / 2));
	    position: absolute;
	    top: -webkit-calc(50% - (33px / 2));
	    top: -moz-calc(50% - (33px / 2));
	    top: calc(50% - (33px / 2));
		}
		.remove{
			position: absolute;
    	top: 10px;
    	left: 30px;
		}
		.edit-profile .profile-edit-card .edit-profile-image .cover-image-label{
			padding: 20px 0;
		}
		.edit-profile .profile-edit-card  .custom_nice .nice-select .list {
	    width: 100%;
	    height: 300px;
	    overflow: auto;
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
	<?php require_once("includes/buyer-header.php"); ?>

	<main>
		<section class="container-fluid edit-profile">
			<div class="row">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h1 class="heading-title">
								تعديل الملف الشخصى
							</h1>
						</div>
					</div>
					<!-- Row -->
					<div class="row">
						<div class="col-12 col-lg-8">
							<div class="profile-edit-card">
								<div class="row">
									<div class="col-12">
										<div class="profile-edit-steps d-flex flex-row justify-content-between">
											<div class="profile-edit-step-item active" id="profile_tab">
												<span class="step">1</span>
												<span class="text">
													المعلومات الاساسية
												</span>
											</div>
											<div class="profile-edit-step-item" id="verification_tab">
												<span class="step">2</span>
												<span class="text">
													التأكيد & التحقق
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-content">
									<div id="profile_settings" class="tab-pane fade <?php if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){ echo "show active"; } if(isset($_GET['profile_settings'])){ echo "show active"; } ?>">
										<!-- Row -->
										<div class="row">
											<div class="col-12">
												<?php require_once("profile_settings.php") ?>
											</div>
										</div>
										<!-- Row -->
									</div>
									<div id="account_verification" class="tab-pane fade ">
										<!-- Row -->
										<div class="row">
											<div class="col-12">
												<div class="profile-verifications">
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-facebook-f"></i></span>
														<span>
															الفيس بوك
														</span>
														<span class="mr-auto d-flex flex-row align-items-center facebook">
															<span><i class="fab fa-facebook-f"></i></span>
															<span>
																متصل
															</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-linkedin-in"></i></span>
														<span>LinkedIn</span>
														<span class="mr-auto d-flex flex-row align-items-center linkedin">
															<span><i class="fab fa-linkedin-in"></i></span>
															<span>
																متصل
															</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-google"></i></span>
														<span>Google</span>
														<span class="mr-auto d-flex flex-row align-items-center google">
															<span><i class="fab fa-google"></i></span>
															<span>
																متصل
															</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><i class="fas fa-envelope"></i></span>
														<span>
															الإيميل
														</span>
														<span class="mr-auto d-flex flex-row align-items-center email">
															<span>
																اتحقق
															</span>
														</span>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
														<span>
															الدفع
														</span>
														<span class="mr-auto d-flex flex-row align-items-center payment">
															<span><i class="fal fa-check"></i></span>
															<span>
																اتحققنا منه
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<!-- Row -->
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="howitwork-card">
								<div class="howitwork-card-title d-flex align-items-center">
									طور ملفك الشخصي
								</div>
								<div class="howitwork-list d-flex flex-column">
									<div class="howitwork-list-item d-flex flex-row align-items-start">
										<div class="howitwork-list-icon">
											<img alt="Post a gig" class="img-fluid d-block" src="assets/img/edit-profile/profile-photo-icon.png" />
										</div>
										<div class="howitwork-list-content">
											<h3>1. صورة الملف الشخصي و الغلاف</h3>
											<p>
												مجتمع الفريلانسنج عبارة عن أسرة صغيرة متماسكة تابعة لمبادئ التعاطف و النزاهة و كمان الولاء. أكيد لما تحمل صورة لملفك الشخصي و الغلاف هتبان لمجتمع الفريلانسرز إنك شخص حقيقي و إنك ملتزم بتكوين علاقات مهنية احترافية و بجودة عالية.
											</p>
										</div>
									</div>
									<!-- How it work each item -->
									<div class="howitwork-list-item d-flex flex-row align-items-start">
										<div class="howitwork-list-icon">
											<img alt="Get Hired" class="img-fluid d-block" src="assets/img/edit-profile/text-edit-icon.png" />
										</div>
										<div class="howitwork-list-content">
											<h3>2. كلمنا عن نفسك</h3>
											<p>
												احنا عايزين نعرف انت مين ! كلمنا عن البيزنس بتاعك، أهدافك، أحلامك، و أي شيء عايز تشاركه معانا. عشان كدة كتابة جزء من سيرتك الذاتية بتتكلم عنك هتساعد الفريلانسرز ياخدوا صورة إيجابية عن الحاجة اللي بتدور عليها في مشروعك.
											</p>
										</div>
									</div>
									<!-- How it work each item -->
									<div class="howitwork-list-item d-flex flex-row align-items-start">
										<div class="howitwork-list-icon">
											<img alt="Work" class="img-fluid d-block" src="assets/img/edit-profile/verifiy-icon.png" />
										</div>
										<div class="howitwork-list-content">
											<h3>3. اتحقق من حسابك</h3>
                      <p>
                          ابني ثقة لبروفايلك عن طريق ربطه بحسابات السوشيال ميديا بتاعتك المختلفة. دة هيزود بنسبة كبيرة فرص استقبالك لعروض أكتر وعروض جودتها أحسن من المواهب الأفضل على eMongez.
                      </p>
										</div>
									</div>
									<!-- How it work each item -->
								</div>
							</div>
							<!-- How it work -->
						</div>
					</div>
				</div>
			</div>
			<!-- Row -->
		</section>

	</main>
	<!-- Customer Order Puppup Start-->


<!-- <div class="container-fluid mt-5 mb-5">
	<div class="row terms-page" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
		<div class="col-md-3 mb-3">
			<div class="card">
				<div class="card-body">
					<ul class="nav nav-pills flex-column mt-2">
						<li class="nav-item">
						<a data-toggle="pill" href="#profile_settings" class="nav-link
						<?php
						if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){
						echo "active";
						}
						if(isset($_GET['profile_settings'])){ echo "active"; }
						?>">
						<?php echo $lang["titles"]["settings"]["profile_settings"]; ?>
						</a>
						</li>
						<li class="nav-item">
							<a data-toggle="pill" href="#account_settings" class="nav-link
              <?php
	              if(isset($_GET['account_settings'])){
	              	echo "active";
	              }
              ?>
              ">
							 <?php echo $lang["titles"]["settings"]["account_settings"]; ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="tab-content">
					<div id="profile_settings" class="tab-pane fade <?php if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){ echo "show active"; } if(isset($_GET['profile_settings'])){ echo "show active"; } ?>">
						<h2 class="mb-4"><?php echo $lang["titles"]["settings"]["profile_settings"]; ?></h2>
            <?php //require_once("profile_settings.php") ?>
					</div>
					<div id="account_settings" class="tab-pane fade <?php if(isset($_GET['account_settings'])){ echo "show active"; } ?>">
						<h2 class="mb-4"><?php echo $lang["titles"]["settings"]["account_settings"]; ?></h2>
						<?php //require_once("account_settings.php") ?>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<div id="insertimageModal" class="modal" role="dialog">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Image <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="image_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type" value="">
      <button class="btn btn-success crop_image">Crop Image</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div id="insertCoverModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Cover <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="cover_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type_cover" value="">
      <button class="btn btn-success crop_image_cover">Crop Image</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>
<div id="wait"></div>
<script>
	$('#verification_tab').click(function(){
		$('#account_verification').addClass('show active');
		$('#profile_settings').removeClass('show active');
		$('#verification_tab').addClass('active');
	});
	$('#profile_tab').click(function(){
		$('#account_verification').removeClass('show active');
		$('#profile_settings').addClass('show active');
		$('#verification_tab').removeClass('active');
	});
</script>
<?php require_once("includes/footer.php"); ?>
</body>
</html>