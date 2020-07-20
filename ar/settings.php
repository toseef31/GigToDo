<?php
session_start();
require_once("includes/db.php");
require_once("functions/email.php");
require_once("social-config.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_user_type = $row_login_seller->account_type;
$login_seller_name = $row_login_seller->seller_name;
$login_seller_email = $row_login_seller->seller_email;
$login_seller_paypal_email = $row_login_seller->seller_paypal_email;
$login_seller_payoneer_email = $row_login_seller->seller_payoneer_email;
$login_seller_image = $row_login_seller->seller_image;
$login_seller_cover_image = $row_login_seller->seller_cover_image;
$login_seller_headline = $row_login_seller->seller_headline;
$login_seller_country = $row_login_seller->seller_country;
$login_seller_state = $row_login_seller->seller_state;
$login_seller_city = $row_login_seller->seller_city;
$login_seller_timzeone = $row_login_seller->seller_timezone;
$login_seller_language = $row_login_seller->seller_language;
$login_seller_about = $row_login_seller->seller_about;
$login_seller_account_number = $row_login_seller->seller_m_account_number;
$login_seller_account_name = $row_login_seller->seller_m_account_name;
$login_seller_wallet = $row_login_seller->seller_wallet;
$login_seller_enable_sound = $row_login_seller->enable_sound;
$login_seller_verification = $row_login_seller->seller_verification;
$login_seller_inbox_message = $row_login_seller->inbox_message;
$login_seller_order_message = $row_login_seller->order_message;
$login_seller_order_update = $row_login_seller->order_update;
$login_seller_buyer_request = $row_login_seller->buyer_request;
$login_seller_my_gigs = $row_login_seller->my_gigs;
$login_seller_my_account = $row_login_seller->my_account;
$login_seller_to_dos = $row_login_seller->to_dos;
$gmail_verification = $row_login_seller->gmail_verification;
$fb_verification = $row_login_seller->fb_verification;
$seller_verification = $row_login_seller->seller_verification;

$get_seller_lang = explode(',', $row_login_seller->seller_language);

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

if($lang_dir == "right"){
	$floatRight = "";
}else{
	$floatRight = "float-right";
}

$select_seller_payment = $db->select('seller_payment_account',array("seller_id" => $login_seller_id));
$row_seller_payment = $select_seller_payment->fetch();
$seller_account_id = $row_seller_payment->seller_id;
$mobile_number = $row_seller_payment->mobile_number;
$address = $row_seller_payment->address;
$apartment_number = $row_seller_payment->apartment_number;
$floor_number = $row_seller_payment->floor_number;
$country = $row_seller_payment->country;
$state = $row_seller_payment->state;
$city = $row_seller_payment->city;
$card_number = $row_seller_payment->card_number;
$card_name = $row_seller_payment->card_name;
$expiry_date = $row_seller_payment->expiry_date;
$security_code = $row_seller_payment->security_code;
$account_full_name = $row_seller_payment->account_full_name;
$iban = $row_seller_payment->iban;
$bank_name_address = $row_seller_payment->bank_name_address;
$swift_code = $row_seller_payment->swift_code;
$local_mobile_number = $row_seller_payment->local_mobile_number;
$local_email = $row_seller_payment->local_email;

$count_account = $select_seller_payment->rowCount();
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
	<link href="<?php echo $site_url; ?>/assets/css/select2.min.css" rel="stylesheet" />
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
		.crop_image , .crop_image_cover{
		  background-color: #ff0707;
		  border-color: #ff0707;
		  color: white; 
		}
		#insertimageModal .modal-header .close {
		  padding: 1rem;
		  margin: -1rem -1rem auto;
		}
		#state-list , #city-list, #country, .language{
      height: 54px;
      display: block !important;
    }
    .state_box .nice-select{
      display: none;
    }
    /* The message box is shown when the user clicks on the password field */
    #message {
      display:none;
      /*background: #f1f1f1;*/
      color: #000;
      position: relative;
      padding: 20px;
      margin-top: 0px;
    }
    #message p {
      padding: 0px 35px;
      font-size: 14px;
    }
    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
      color: green;
    }
    .valid:before {
      position: relative;
      left: 35px;
      content: "✔";
    }
    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
      color: red;
    }
    .invalid:before {
      position: relative;
      left: 35px;
      content: "✖";
    }
    .select2.select2-container:last-Child{
    	display: none;
    }
    .select2-container{
    	width: 100% !important;
    }
    .select2-container .select2-selection--multiple{
    	min-height: 54px;

    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
    	margin-top: 10px;
	    padding: 5px 10px;
	    float: right;
    }
    .edit-profile .profile-edit-card .edit-profile-image .profile-image{
    	padding: 0;
    }
    @media(max-width: 768px){
    	.edit-profile .profile-edit-card .edit-profile-image .cover-image-label{
    		height: auto;
    		padding: 0;
    	}
    	.empty-cover{
    		height: 135px !important;
    	}
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
	<?php 
		if($login_user_type == 'seller'){ 
		  require_once('includes/user_header.php');
		}else{
		  require_once("includes/buyer-header.php");
		}
	?>
	<?php if(!isset($_GET['account_settings'])){  ?>
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
													    بالفيس بوك
													  </span>
													  <?php if($fb_verification == 0){ ?>
													  <span class="mr-auto d-flex flex-row align-items-center facebook" onclick="window.location='<?php echo $fLoginURL ?>';">
													    <span><i class="fab fa-facebook-f"></i></span>
													    <span>
													      متصل
													    </span>
													  </span>
													  <?php }else{ ?>
													  <span class="mr-auto d-flex flex-row align-items-center payment">
													    <span><i class="fal fa-check"></i></span>
													    <span>
																اتحققنا منه
															</span>
													  </span>
													  <?php } ?>
													</div>
													<!-- <div class="profile-verification-item d-flex flex-row">
														<span><i class="fab fa-linkedin-in"></i></span>
														<span>LinkedIn</span>
														<span class="mr-auto d-flex flex-row align-items-center linkedin">
															<span><i class="fab fa-linkedin-in"></i></span>
															<span>
																متصل
															</span>
														</span>
													</div> -->
													<div class="profile-verification-item d-flex flex-row">
				                    <span><i class="fab fa-google"></i></span>
				                    <span>Google</span>
				                    <?php if($gmail_verification == 0){ ?>
				                    <span class="mr-auto d-flex flex-row align-items-center google" onclick="window.location = '<?php echo $gLoginURL ?>';">
				                      <span><i class="fab fa-google"></i></span>
				                      <span>
				                        متصل
				                      </span>
				                    </span>
				                    <?php }else{ ?>
				                    <span class="mr-auto d-flex flex-row align-items-center payment">
				                      <span><i class="fal fa-check"></i></span>
				                      <span>
																اتحققنا منه
															</span>
				                    </span>
				                    <?php } ?>
				                  </div>
													<div class="profile-verification-item d-flex flex-row">
													  <span><i class="fas fa-envelope"></i></span>
													  <span>
													    اتحققنا
													  </span>
													  <?php if($seller_verification != 'ok'){ ?>
													  <span class="mr-auto d-flex flex-row align-items-center email">
													    <span>
													      اتحقق
													    </span>
													  </span>
													  <?php }else{ ?>
													  <span class="mr-auto d-flex flex-row align-items-center payment">
													    <span><i class="fal fa-check"></i></span>
													    <span>
													    	اتحققنا منه
													    </span>
													  </span>
													  <?php } ?>
													</div>
													<div class="profile-verification-item d-flex flex-row">
														<span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
														<span>
															الدفع
														</span>
														<?php if ($count_account > 0 or $login_seller_paypal_email != ''){ ?>
														<span class="mr-auto d-flex flex-row align-items-center payment">
															<span><i class="fal fa-check"></i></span>
															<span>
																اتحققنا منه
															</span>
														</span>
														<?php }elseif($count_account == 0 and $login_seller_paypal_email == ''){ ?>
														<span class="mr-auto d-flex flex-row align-items-center email" onclick="window.open('settings?account_settings')">
														  <span>
													      اتحقق
													    </span>
														</span>
														<?php } ?>
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
	<?php } elseif(isset($_GET['account_settings'])){?>
	<main>
			<section class="container-fluid profile-setting">
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<h1 class="heading-title">
									الأمان
								</h1>
							</div>
						</div>
						<!-- Row -->
						<div class="row">
							<div class="col-12 col-lg-4">
								<div class="profile-setting-breadcrumb nav nav-tabs d-flex flex-column" id="setting-tab" role="tablist">
									<a href="#security" id="security-tab" data-toggle="tab" aria-controls="security" aria-selected="true" class="nav-item nav-link profile-setting-breadcrumb-item active d-flex flex-row align-items-center">
										<span>
											<img class="img-fluid before-icon" src="assets/img/setting/security-icon-before.png" />
											<img class="img-fluid after-icon" src="assets/img/setting/security-icon-after.png" />
										</span>
										<span class="text">
											الأمان
										</span>
									</a>
									<!-- Each item -->
									<a href="#notification" id="notification-tab" data-toggle="tab" aria-controls="notification" aria-selected="false" class="nav-item nav-link profile-setting-breadcrumb-item d-flex flex-row align-items-center">
										<span>
											<img class="img-fluid before-icon" src="assets/img/setting/notifications-icon-before.png" />
											<img class="img-fluid after-icon" src="assets/img/setting/notifications-icon-after.png" />
										</span>
										<span class="text">
											الإشعارات
										</span>
									</a>
									<!-- Each item -->
									<a href="#payments" id="payments-tab" data-toggle="tab" aria-controls="payments" aria-selected="false" class="nav-item nav-link profile-setting-breadcrumb-item d-flex flex-row align-items-center">
										<span>
											<img class="img-fluid before-icon" src="assets/img/setting/payments-icon-before.png" />
											<img class="img-fluid after-icon" src="assets/img/setting/payments-icon-after.png" />
										</span>
										<span class="text">
											المدفوعات
										</span>
									</a>
									<!-- Each item -->
								</div>
							</div>
							<div class="col-12 col-lg-8">
								<div class="tab-content" id="setting-tabContent">
									<div class="tab-pane fade show active" id="security" role="tabpanel" aria-labelledby="security-tab">
										<div class="profile-setting-card d-flex flex-column">
											<div class="profile-setting-card-header">
												<div class="icon-title d-flex flex-row align-items-center">
													<span>
														<img src="assets/img/setting/password-icon.png" />
													</span>
													<span>
														الباسوورد
													</span>
												</div>
												<div class="title">
													حدث الباسوورد
												</div>
												<div class="icon d-flex flex-row">
													<!-- <button type="button" role="button">
														<i class="fas fa-check-circle"></i>
													</button>
													<button type="button" role="button">
														<i class="fal fa-times-circle"></i>
													</button> -->
												</div>
											</div>
											<!-- Profile setting card header -->
											<div class="profile-setting-card-body">
												<form class="clearfix" method="post">
													<div class="row">
														<div class="col-12">
															<div class="form-group d-flex flex-column">
																<label class="control-label">
																	الباسوورد الحالية
																</label>
																<input type="password" class="form-control" name="old_pass" />
															</div>
														</div>
														<div class="col-12">
															<div class="form-group d-flex flex-column">
																<label class="control-label">
																	باسوورد جديدة
																</label>
																<input type="password" class="form-control" id="psw" name="new_pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن يحتوي على رقم واحد على الأقل وحرف واحد كبير وحرف صغير ، وعلى الأقل 8 أحرف أو أكثر" />
															</div>
														</div>
														<div id="message">
														  <!-- <h3>Password must contain the following:</h3> -->
														  <p id="letter" class="invalid"><b>حرف  </b> صغير </p>
														  <p id="capital" class="invalid"><b>العاصمة (الأحرف الكبيرة) </b> غير  </p>
														  <p id="number" class="invalid"><b>رقم</b></p>
														  <p id="length" class="invalid">الحد الأدنى  <b>8 أحرف</b></p>
														</div>
														<div class="col-12">
															<div class="form-group d-flex flex-column">
																<label class="control-label">
																	اكتب الباسوورد مرة كمان
																</label>
																<input type="password" class="form-control" id="confirm_pass" name="new_pass_again" />
															</div>
														</div>
														<span id="match" class="pr-3"></span>
														<div class="col-12">
															<div class="form-group d-flex flex-column">
																<p class="mb-0">
																	لازم الباسوورد تتكون من 8 حروف على الأقل، و تضم على الأٌقل رقم واحد و حرف كابيتال
																</p>
															</div>
														</div>
														<div class="col-12">
															<div class="form-group d-flex flex-row justify-content-end mb-0">
																<button class="button button-white" type="button" role="button">
																	إلغاء
																</button>
																<button class="button button-red" type="submit"  name="change_password">
																	حفظ
																</button>
															</div>
														</div>
													</div>
												</form>
												<?php 
												  if(isset($_POST['change_password'])){
												  $rules = array(
												  "old_pass" => "required",
												  "new_pass" => "required",
												  "new_pass_again" => "required");
												  $messages = array("old_pass" => "Old Password Is Required.","new_pass" => "New Password Is Required.","new_pass_again"=>"New Password Again Is Required.");
												  $val = new Validator($_POST,$rules,$messages);
												  if($val->run() == false){
												    Flash::add("change_pass_errors",$val->get_all_errors());
												    Flash::add("form_data",$_POST);
												    echo "<script> window.open('settings?account_settings','_self');</script>";
												  }else{
												    $old_pass = $input->post('old_pass');
												    $new_pass = $input->post('new_pass');
												    $new_pass_again = $input->post('new_pass_again');
												    $get_seller = $db->select("sellers",array("seller_id"=>$login_seller_id));
												    $row_seller = $get_seller->fetch();
												    $hash_password = $row_seller->seller_pass;
												    $decrypt_password = password_verify($old_pass,$hash_password);
												    if($decrypt_password == 0){
												    echo "<script>
												      swal({
												      type: 'warning',
												      html: $('<div>').addClass('some-class').text('كلمة المرور القديمة غير صالحة ، يرجى المحاولة مرة أخرى!.'),
												      animation: false,
												      customClass: 'animated tada'
												      });
												      </script>";
												    }else{
												      if($new_pass!=$new_pass_again){
												       echo "<script>alert('كلمة المرور الجديدة لا تتطابق.');</script>";
												      }else{
												        $encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);
												        $update_pass = $db->update("sellers",array("seller_pass" => $encrypted_password),array("seller_id" => $login_seller_id));
												        echo "<script>
												        swal({
												          type: 'success',
												          text: 'تم تحديث كلمة المرور بنجاح ، قم بتسجيل الدخول باستخدام كلمة المرور الجديدة.',
												          timer: 3000,
												          onOpen: function(){
												            swal.showLoading();
												          }
												        }).then(function(){
												          // Read more about handling dismissals
												          window.open('settings?account_settings','_self')
												        });
												        </script>";
												      }
												    }
												    }
												  }
												  ?>
											</div>
										</div>
									</div>
									<!-- Security Tab Panel -->
									<div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
										<div class="profile-setting-card d-flex flex-column">
											<div class="profile-setting-card-header">
												<div class="icon-title d-flex flex-row align-items-center">
													<span>
														<img src="assets/img/setting/notification-icon.png" />
													</span>
													<span>
														الإشعارات
													</span>
												</div>
												<div class="title">
													تعديل الإشعارات
												</div>
												<div class="icon d-flex flex-row">
													<!-- <button type="button" role="button">
														<i class="fas fa-check-circle"></i>
													</button>
													<button type="button" role="button">
														<i class="fal fa-times-circle"></i>
													</button> -->
												</div>
											</div>
											<!-- Profile setting card header -->
											<div class="profile-setting-card-body">
												<form action="" method="POST">
													<div class="notifications-group d-flex flex-column">
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																الرسايل الواردة
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="inbox_message" class="custom-control-input" id="customCheck1" <?php if($login_seller_inbox_message == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck1">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																رسايل الطلبات
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="order_message" class="custom-control-input" id="customCheck2" <?php if($login_seller_order_message == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck2">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																تحديثات الطلبات
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="order_update" class="custom-control-input" id="customCheck3" <?php if($login_seller_order_update == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck3">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																طلبات المشتري
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="buyer_request" class="custom-control-input" id="customCheck4" <?php if($login_seller_buyer_request == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck4">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																خدماتى
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="my_gigs" class="custom-control-input" id="customCheck5" <?php if($login_seller_my_gigs == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck5">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																حسابى
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="my_account" class="custom-control-input" id="customCheck6" <?php if($login_seller_my_account == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck6">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
														<div class="notification-item d-flex flex-row align-items-center justify-content-between">
															<span>
																لدوس
															</span>
															<div class="custom-control custom-checkbox">
																<input type="checkbox" name="to_dos" class="custom-control-input" id="customCheck7" <?php if($login_seller_to_dos == 'on'){ echo "checked";} ?>>
																<label class="custom-control-label" for="customCheck7">&nbsp;</label>
															</div>
														</div>
														<!-- Each item -->
													</div>
													<div class="form-group d-flex flex-row justify-content-end mb-0">
														<button class="button button-white" type="button" role="button">
															إلغاء
														</button>
														<button class="button button-red" type="submit" name="save_notification">
															حفظ
														</button>
													</div>
												</form>
												<?php 
													if(isset($_POST['save_notification'])){
														$inbox_message = $input->post('inbox_message');
														$order_message = $input->post('order_message');
														$order_update = $input->post('order_update');
														$buyer_request = $input->post('buyer_request');
														$my_gigs = $input->post('my_gigs');
														$my_account = $input->post('my_account');
														$to_dos = $input->post('to_dos');
														
														$update_notification = $db->update('sellers',array("inbox_message" => $inbox_message, "order_message" => $order_message, "order_update" => $order_update, "buyer_request" => $buyer_request, "my_gigs" => $my_gigs, "my_account" => $my_account, "to_dos" => $to_dos),array("seller_id" => $login_seller_id));
														if($update_notification){
															echo "<script>
															swal({
															type: 'success',
															text: 'تم تحديث الإشعارات بنجاح',
															timer: 3000,
															onOpen: function(){
															swal.showLoading()
															}
															}).then(function(){
															  if (
															    // Read more about handling dismissals
															    window.open('settings?account_settings','_self')
															  ) {
															    console.log('تم تحديث الإشعارات بنجاح')
															  }
															});</script>";
														}

													}
												?>
											</div>
										</div>
									</div>
									<!-- Notification Tab Panel -->
									<?php if($login_user_type == 'seller'){ ?>
									<!-- Notification Tab Panel -->
									<div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
										<div class="profile-setting-card d-flex flex-column">
											<div class="profile-setting-card-header">
												<div class="icon-title d-flex flex-row align-items-center">
													<span>
														<img src="assets/img/setting/payments-icon.png" />
													</span>
													<span>
														المدفوعات
													</span>
												</div>
												<div class="title">
													زود طريقة دفع إضافية
												</div>
												<div class="icon d-flex flex-row">&nbsp;</div>
											</div>
											<!-- Profile setting card header -->
											<div class="profile-setting-card-body">
												<form action="" method="POST">
													<h4>
														ايه الطريقة اللي عايز تدفع بيها على منجز؟
													</h4>
													<ul class="nav nav-tabs pyments-tab" id="pymentsTab" role="tablist">
														<li class="nav-item">
															<a class="nav-link active" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="true">
																<span><img class="img-fluid d-block" src="assets/img/setting/paypal.png" /></span>
																<span>PayPal</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="false">
																<span><img class="img-fluid d-block" src="assets/img/setting/bank-transfer.png" /></span>
																<!-- <span>
																	حوالة بنكية
																</span> -->
																<span>Payoneer</span>
															</a>
														</li>
													</ul>
													<div class="tab-content" id="paymentsTabContent">
														<div class="tab-pane fade show active" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
															<form method="post" class="clearfix">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				الإيميل
																			</label>
																			<input type="email" name="seller_paypal_email" value="<?= $login_seller_paypal_email; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">
																				تعديل
																			</button>
																			<button class="button button-red" type="submit"  name="submit_paypal_email">
																				تقديم
																			</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php

															if(isset($_POST['submit_paypal_email'])){
															  $seller_paypal_email = strip_tags($input->post('seller_paypal_email'));
															  $update_seller = $db->update("sellers",array("seller_paypal_email" => $seller_paypal_email),array("seller_id" => $login_seller_id));
															  if($update_seller){
															    echo "<script>
															    swal({
															    type: 'success',
															    text: 'تم تحديث بريد PayPal الإلكتروني بنجاح!',
															    timer: 3000,
															    onOpen: function(){
															    swal.showLoading()
															    }
															    }).then(function(){
															      if (
															        // Read more about handling dismissals
															        window.open('settings?account_settings','_self')
															      ) {
															        console.log('تم تحديث البريد الإلكتروني بنجاح')
															      }
															    });</script>";
															  }
															}

															if($paymentGateway == 1){ 
															  include("plugins/paymentGateway/account_settings.php");
															} 

															?>
														</div>
														<div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
															<form method="post" class="clearfix">
																<input type="hidden" name="account_type" value="bank_transfer">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				أدخل بريد Payoneer الإلكتروني
																			</label>
																			<input type="text" name="seller_payoneer_email" value="<?= $login_seller_payoneer_email; ?>" class="form-control" />
																		</div>
																	</div>
																	<!-- <div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				اسم الحساب بالكامل
																			</label>
																			<input type="text" name="account_full_name" value="<?= $account_full_name; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				رقم IBAN
																			</label>
																			<input type="text" name="iban" value="<?= $iban ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				اسم البنك & العنوان
																			</label>
																			<input type="text" name="bank_name_address" value="<?= $bank_name_address ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				الكود البريدى
																			</label>
																			<input type="text" name="swift_code" value="<?= $swift_code ?>" class="form-control" />
																		</div>
																	</div> -->
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">
																				تعديل
																			</button>
																			<!-- <button class="button button-red" type="submit" name="submit_bank_info">
																				تقديم
																			</button> -->
																			<button class="button button-red" type="submit" name="submit_payoneer_email">
																				تقديم
																			</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php 
																// if(isset($_POST['submit_bank_info'])){
																// 	$account_type = strip_tags($input->post('account_type'));
																// 	$account_full_name = strip_tags($input->post('account_full_name'));
																// 	$iban = strip_tags($input->post('iban'));
																// 	$bank_name_address = strip_tags($input->post('bank_name_address'));
																// 	$swift_code = strip_tags($input->post('swift_code'));
																	
																// 	if (count($seller_account_id) == 0) {
																// 		$update_bank_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"account_full_name" => $account_full_name,"iban" => $iban, "bank_name_address" => $bank_name_address, "swift_code" => $swift_code));
																// 	}else{
																// 		$update_bank_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"account_full_name" => $account_full_name,"iban" => $iban, "bank_name_address" => $bank_name_address, "swift_code" => $swift_code),array("seller_id" => $login_seller_id));	
																// 	}
																	
																	
																// 	if($update_bank_info){
																// 	echo "<script>
																// 	swal({
																// 	type: 'success',
																// 	text: 'تم تحديث تفاصيل الحساب المصرفي بنجاح!',
																// 	timer: 3000,
																// 	onOpen: function(){
																// 	swal.showLoading()
																// 	}
																// 	}).then(function(){
																// 	window.open('settings?account_settings','_self')
																// 	});
																// 	</script>";
																// 	}
																// }
																if(isset($_POST['submit_payoneer_email'])){
																  $seller_payoneer_email = strip_tags($input->post('seller_payoneer_email'));
																  $update_seller = $db->update("sellers",array("seller_payoneer_email" => $seller_payoneer_email),array("seller_id" => $login_seller_id));
																  if($update_seller){
																  echo "<script>
																    swal({
																      type: 'success',
																      text: 'Payoneer email updated successfully!',
																      timer: 3000,
																      onOpen: function(){
																        swal.showLoading()
																      }
																    }).then(function(){
																        // Read more about handling dismissals
																        window.open('settings?account_settings','_self')
																    });</script>";
																  }
																}
															?>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- Payments Tab Panel -->
									<?php }else { ?>
									<div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
										<div class="profile-setting-card d-flex flex-column">
											<div class="profile-setting-card-header">
												<div class="icon-title d-flex flex-row align-items-center">
													<span>
														<img src="assets/img/setting/payments-icon.png" />
													</span>
													<span>
														المدفوعات
													</span>
												</div>
												<div class="title">
													زود طريقة دفع إضافية
												</div>
												<div class="icon d-flex flex-row">&nbsp;</div>
											</div>
											<!-- Profile setting card header -->
											<div class="profile-setting-card-body">
												<form action="" method="POST">
													<h4>
														ايه الطريقة اللي عايز تدفع بيها على موقع منجز؟
													</h4>
													<ul class="nav nav-tabs pyments-tab" id="pymentsTab" role="tablist">
														<li class="nav-item">
															<a class="nav-link active" id="online-tab" data-toggle="tab" href="#online" role="tab" aria-controls="online" aria-selected="true">
																<span><img class="img-fluid d-block" src="assets/img/setting/online.png" /></span>
																<span>أونلاين</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="mobile-tab" data-toggle="tab" href="#mobile" role="tab" aria-controls="mobile" aria-selected="false">
																<span><img class="img-fluid d-block" src="assets/img/setting/mobile.png" /></span>
																<span>
																	محفظة الموبايل
																</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="false">
																<span><img class="img-fluid d-block" src="assets/img/setting/cash.png" /></span>
																<span>
																	كاش
																</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="local-tab" data-toggle="tab" href="#local" role="tab" aria-controls="local" aria-selected="false">
																<span><img class="img-fluid d-block" src="assets/img/setting/local.png" /></span>
																<span>
																	محلى
																</span>
															</a>
														</li>
													</ul>
													<div class="tab-content" id="paymentsTabContent">
														<div class="tab-pane fade show active" id="online" role="tabpanel" aria-labelledby="online-tab">
															<div class="online-tab d-flex flex-column">
																<div class="custom-control custom-radio">
																	<input hidden data-toggle="collapse" data-target="#credit-card" aria-controls="credit-card" type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
																	<label class="custom-control-label" for="customRadio1">
																		<span>
																			<img class="img-fluid before-icon" src="assets/img/setting/cradit-card-before.png" />
																			<img class="img-fluid after-icon" src="assets/img/setting/cradit-card-after.png" />
																		</span>
																		<span>
																			بطاقة ائتمان ولا خصم
																		</span>
																	</label>
																	<div class="collapse mt-30" id="credit-card">
																		<form method="post" class="clearfix">
																			<input type="hidden" name="account_type" value="card_info">
																			<div class="row">
																				<div class="col-12 col-md-6">
																					<div class="form-group">
																						<label class="control-label">
																							رقم البطاقة
																						</label>
																						<input type="text" name="card_number" value="<?= $card_number; ?>" class="form-control ccFormatMonitor" />
																					</div>
																				</div>
																				<div class="col-12 col-md-6">
																					<div class="form-group">
																						<label class="control-label">
																							الاسم على البطاقة
																						</label>
																						<input type="text" name="card_name" value="<?= $card_name; ?>" class="form-control" />
																					</div>
																				</div>
																				<div class="col-12 col-md-6">
																					<div class="form-group">
																						<label class="control-label">
																							تاريخ الانتهاء
																						</label>
																						<input type="text" id="inputExpDate" name="expiry_date" value="<?= $expiry_date; ?>" class="form-control" />
																					</div>
																				</div>
																				<div class="col-12 col-md-6">
																					<div class="form-group">
																						<label class="control-label">
																							الكود السرى
																						</label>
																						<input type="text" name="security_code" value="<?= $security_code; ?>" pattern="[0-9]{3}" class="form-control cvv" />
																					</div>
																				</div>
																				<div class="col-12">
																					<div class="form-group d-flex flex-row mb-0">
																						<button class="button button-white" type="button" role="button">
																							تعديل
																						</button>
																						<button class="button button-red" type="submit" name="submit_card_info">
																							تقديم
																						</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php 
																			if(isset($_POST['submit_card_info'])){
																				$account_type = strip_tags($input->post('account_type'));
																				$card_name = strip_tags($input->post('card_name'));
																				$card_number = strip_tags($input->post('card_number'));
																				$expiry_date = strip_tags($input->post('expiry_date'));
																				$security_code = strip_tags($input->post('security_code'));
																				// print_r($login_seller_id);die();
																				if (count($seller_account_id) == 0) {
																					$update_bank_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"card_name" => $card_name,"card_number" => $card_number, "expiry_date" => $expiry_date, "security_code" => $security_code));
																				}else{
																				$update_bank_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"card_name" => $card_name,"card_number" => $card_number, "expiry_date" => $expiry_date, "security_code" => $security_code),array("seller_id" => $login_seller_id));
																				// print_r($update_bank_info);die();
																				}
																				if($update_bank_info){
																				echo "<script>
																				swal({
																				type: 'success',
																				text: 'تم تحديث تفاصيل البطاقة بنجاح!',
																				timer: 3000,
																				onOpen: function(){
																				swal.showLoading()
																				}
																				}).then(function(){
																				window.open('settings?account_settings','_self')
																				});
																				</script>";
																				}
																			}
																		?>
																	</div>
																</div>
																<div class="custom-control custom-radio">
																	<input hidden data-toggle="collapse" data-target="#paypal" aria-controls="paypal" type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
																	<label class="custom-control-label" for="customRadio2">
																		<span>
																			<img class="img-fluid before-icon" src="assets/img/setting/paypal-before.png" />
																			<img class="img-fluid after-icon" src="assets/img/setting/paypal-after.png" />
																		</span>
																		<span>Paypal</span>
																	</label>
																	<div class="collapse mt-30" id="paypal">
																		<form method="post" class="clearfix">
																			<div class="row">
																				<div class="col-12">
																					<div class="form-group">
																						<label class="control-label">
																							الإيميل
																						</label>
																						<input type="email" name="seller_paypal_email" value="<?= $login_seller_paypal_email; ?>" placeholder="أدخل البريد الإلكتروني paypal" class="form-control" required />
																					</div>
																				</div>
																				<div class="col-12">
																					<div class="form-group d-flex flex-row mb-0">
																						<button class="button button-white" type="button" role="button">
																							تعديل
																						</button>
																						<button class="button button-red" type="submit" name="submit_paypal_email">
																							تقديم
																						</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php

																		if(isset($_POST['submit_paypal_email'])){
																		  $seller_paypal_email = strip_tags($input->post('seller_paypal_email'));
																		  $update_seller = $db->update("sellers",array("seller_paypal_email" => $seller_paypal_email),array("seller_id" => $login_seller_id));
																		  if($update_seller){
																		    echo "<script>
																		    swal({
																		    type: 'success',
																		    text: 'تم تحديث بريد PayPal الإلكتروني بنجاح!',
																		    timer: 3000,
																		    onOpen: function(){
																		    swal.showLoading()
																		    }
																		    }).then(function(){
																		      if (
																		        // Read more about handling dismissals
																		        window.open('settings?account_settings','_self')
																		      ) {
																		        console.log('تم تحديث البريد الإلكتروني بنجاح')
																		      }
																		    });</script>";
																		  }
																		}

																		if($paymentGateway == 1){ 
																		  include("plugins/paymentGateway/account_settings.php");
																		} 

																		?>
																	</div>
																</div>
																<div class="custom-control custom-radio">
																	<input hidden type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
																	<label class="custom-control-label" for="customRadio3">
																		<span>
																			<img class="img-fluid before-icon" src="assets/img/setting/em-wallet.png" />
																			<img class="img-fluid after-icon" src="assets/img/setting/em-wallet.png" />
																		</span>
																		<span>
																			محفظة منجز
																		</span>
																	</label>
																</div>
															</div>
														</div>
														<div class="tab-pane fade" id="mobile" role="tabpanel" aria-labelledby="mobile-tab">
															<form method="post" class="clearfix mb-3">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">رقم حساب </label>
																			<input type="text" name="m_account_number" value="<?= $login_seller_account_number; ?>" placeholder="أدخل رقم الحساب" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">اسم الحساب / المالك </label>
																			<input type="text" name="m_account_name" value="<?= $login_seller_account_name; ?>" placeholder="أدخل اسم الحساب / المالك" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">Edit</button>
																			<button class="button button-red" type="submit" name="update_mobile_money">Submit</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php 
															  if(isset($_POST['update_mobile_money'])){
															  $m_account_number = strip_tags($input->post('m_account_number'));
															  $m_account_name = strip_tags($input->post('m_account_name'));
															  $update_seller = $db->update("sellers",array("seller_m_account_number" => $m_account_number,"seller_m_account_name" => $m_account_name),array("seller_id" => $login_seller_id));
															  if($update_seller){
															  echo "<script>
															  swal({
															  type: 'success',
															  text: 'تم تحديث أموال الهاتف المحمول بنجاح!',
															  timer: 3000,
															  onOpen: function(){
															  swal.showLoading()
															  }
															  }).then(function(){
															  window.open('settings?account_settings','_self')
															  });
															  </script>";
															  }
															  }
															?>
														</div>
														<div class="tab-pane fade" id="cash" role="tabpanel" aria-labelledby="cash-tab">
															<form method="post" class="clearfix">
																<input type="hidden" name="account_type" value="cash_info">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				رقم الموبايل
																			</label>
																			<input type="text" name="mobile_number" value="<?= $mobile_number; ?>"  class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				العنوان
																			</label>
																			<input type="text" name="address" value="<?= $address; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label class="control-label">
																				رقم المنزل
																			</label>
																			<input type="text" name="apartment_number" value="<?= $apartment_number; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group">
																			<label class="control-label">
																				رقم الدور
																			</label>
																			<input type="text" name="floor_number" value="<?= $floor_number; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group d-flex flex-column state_box">
																			<label class="control-label">بلد </label>
																			<select class="form-control wide" name="country" onChange="getState(this.value);" id="country">
																				<option>حدد الدولة </option>
																				<?php
			                                    $get_countries = $db->select("countries");
			                                    while($row_countries = $get_countries->fetch()){
			                                      $id = $row_countries->id;
			                                      $name = $row_countries->name;
			                                      echo "<option value='$name'".($name == $country ? "selected" : "").">$name</option>";
			                                    }
			                                    ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12 col-md-6">
																		<div class="form-group d-flex flex-column state_box">
																			<label class="control-label">
																				البلد
																			</label>
																			<select class="form-control wide" name="state" onChange="getCity(this.value);" id="state-list">
																				<option>
																					اختار البلد
																				</option>
																				<?php if(!empty($state)){ ?>
										 											<option selected><?= $state; ?></option>
										 										<?php } ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-column state_box">
																			<label class="control-label">
																				المدينة
																			</label>
																			<select class="form-control wide" name="city" required="" id="city-list">
																				<option>
																					اختار المدينة
																				</option>
																				<?php if(!empty($city)){ ?>
										 											<option selected><?= $city; ?></option>
										 										<?php } ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">
																				تعديل
																			</button>
																			<button class="button button-red" type="submit" name="submit_cash_info">
																				تقديم
																			</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php 
																if(isset($_POST['submit_cash_info'])){
																	$account_type = strip_tags($input->post('account_type'));
																	$mobile_number = strip_tags($input->post('mobile_number'));
																	$address = strip_tags($input->post('address'));
																	$apartment_number = strip_tags($input->post('apartment_number'));
																	$floor_number = strip_tags($input->post('floor_number'));
																	$country = strip_tags($input->post('country'));
																	$state = strip_tags($input->post('state'));
																	$city = strip_tags($input->post('city'));
																	// print_r($login_seller_id);die();
																	if (count($seller_account_id) == 0) {
																		$update_cash_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"mobile_number" => $mobile_number,"address" => $address, "apartment_number" => $apartment_number, "floor_number" => $floor_number, "country" => $country, "state" => $state, "city" => $city));
																	}else{
																		$update_cash_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"mobile_number" => $mobile_number,"address" => $address, "apartment_number" => $apartment_number, "floor_number" => $floor_number, "country" => $country, "state" => $state, "city" => $city),array("seller_id" => $login_seller_id));	
																	}
																	
																	// print_r($update_bank_info);die();
																	if($update_cash_info){
																	echo "<script>
																	swal({
																	type: 'success',
																	text: 'تم تحديث التفاصيل النقدية بنجاح!',
																	timer: 3000,
																	onOpen: function(){
																	swal.showLoading()
																	}
																	}).then(function(){
																	window.open('settings?account_settings','_self')
																	});
																	</script>";
																	}
																}
															?>
														</div>
														<div class="tab-pane fade" id="local" role="tabpanel" aria-labelledby="local-tab">
															<form class="clearfix" method="post">
																<input type="hidden" name="account_type" value="local_payment">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				رقم الموبايل
																			</label>
																			<input type="text" name="local_mobile_number" value="<?= $local_mobile_number; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group">
																			<label class="control-label">
																				الإيميل
																			</label>
																			<input type="email" name="local_email" value="<?= $local_email; ?>" class="form-control" />
																		</div>
																	</div>
																	<div class="col-12">
																		<div class="form-group d-flex flex-row mb-0">
																			<button class="button button-white" type="button" role="button">
																				تعديل
																			</button>
																			<button class="button button-red" type="submit" name="local_payment_info">
																				تقديم
																			</button>
																		</div>
																	</div>
																</div>
															</form>
															<?php 
																if(isset($_POST['local_payment_info'])){
																	$account_type = strip_tags($input->post('account_type'));
																	$local_mobile_number = strip_tags($input->post('local_mobile_number'));
																	$local_email = strip_tags($input->post('local_email'));
																	// print_r($login_seller_id);die();
																	if (count($seller_account_id) == 0) {
																		$update_cash_info = $db->insert("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"local_mobile_number" => $local_mobile_number,"local_email" => $local_email));
																	}else{
																		$update_cash_info = $db->update("seller_payment_account",array("seller_id" => $login_seller_id,"account_type" => $account_type,"local_mobile_number" => $local_mobile_number,"local_email" => $local_email),array("seller_id" => $login_seller_id));	
																	}
																	
																	// print_r($update_bank_info);die();
																	if($update_cash_info){
																	echo "<script>
																	swal({
																	type: 'success',
																	text: 'تم تحديث تفاصيل المدفوعات المحلية بنجاح!',
																	timer: 3000,
																	onOpen: function(){
																	swal.showLoading()
																	}
																	}).then(function(){
																	window.open('settings?account_settings','_self')
																	});
																	</script>";
																	}
																}
															?>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- Payments Tab Panel -->
									<?php } ?>
								</div>
							</div>
						</div>
						<!-- Row -->
					</div>
				</div>
				<!-- Row -->
			</section>
		</main>
	<?php } ?>
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
	$('#country option[value="Egypt"]').insertBefore('#country option[value="Afghanistan"]');
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
	function getState(val) {
	  $.ajax({
	    type: "POST",
	    url: "get-state",
	    data:'country_name='+val,
	    beforeSend: function() {
	      $("#state-list").addClass("loader");
	    },
	    success: function(data){
	      // console.log(data);
	      $("#state-list").html(data);
	      $('#city-list').find('option[value]').remove();
	      $("#state-list").removeClass("loader");
	    }
	  });
	}
	function getCity(val) {
	  // alert(val);
	  $.ajax({
	    type: "POST",
	    url: "get-city",
	    data:'state_name='+val,
	    beforeSend: function() {
	      $("#city-list").addClass("loader");
	    },
	    success: function(data){
	      $("#city-list").html(data);
	      $("#city-list").removeClass("loader");
	    }
	  });
	}
</script>
<script>
	$(document).ready(function() {
		$('.js-example-basic-multiple').select2();
	});
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
$('#confirm_pass').on('keyup', function () {
  if ($('#psw').val() == $('#confirm_pass').val()) {
    $('#match').html('مطابقة كلمة المرور').css('color', 'green');
  } else 
    $('#match').html('كلمة المرور غير متطابقة').css('color', 'red');
});
$('#creditCardText').keyup(function() {
  var foo = $(this).val().split("-").join(""); // remove hyphens
  if (foo.length > 0) {
    foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
  }
  $(this).val(foo);
});
var app;

(function() {
  'use strict';
  
  app = {
    monthAndSlashRegex: /^\d\d \/ $/, // regex to match "MM / "
    monthRegex: /^\d\d$/, // regex to match "MM"
    
    el_cardNumber: '.ccFormatMonitor',
    el_expDate: '#inputExpDate',
    el_cvv: '.cvv',
    el_ccUnknown: 'cc_type_unknown',
    el_ccTypePrefix: 'cc_type_',
    el_monthSelect: '#monthSelect',
    el_yearSelect: '#yearSelect',
    
    cardTypes: {
      'American Express': {
        name: 'American Express',
        code: 'ax',
        security: 4,
        pattern: /^3[47]/,
        valid_length: [15],
        formats: {
          length: 15,
          format: 'xxxx xxxxxxx xxxx'
        }
      },
      'Visa': {
				name: 'Visa',
				code: 'vs',
        security: 3,
				pattern: /^4/,
				valid_length: [16],
				formats: {
						length: 16,
						format: 'xxxx xxxx xxxx xxxx'
					}
			},
      'Maestro': {
				name: 'Maestro',
				code: 'ma',
        security: 3,
				pattern: /^(50(18|20|38)|5612|5893|63(04|90)|67(59|6[1-3])|0604)/,
				valid_length: [16],
				formats: {
						length: 16,
						format: 'xxxx xxxx xxxx xxxx'
					}
			},
      'Mastercard': {
				name: 'Mastercard',
				code: 'mc',
        security: 3,
				pattern: /^5[1-5]/,
				valid_length: [16],
				formats: {
						length: 16,
						format: 'xxxx xxxx xxxx xxxx'
					}
			} 
    }
  };
  
  app.addListeners = function() {
      $(app.el_expDate).on('keydown', function(e) {
        app.removeSlash(e);
      });

      $(app.el_expDate).on('keyup', function(e) {
        app.addSlash(e);
      });

      $(app.el_expDate).on('blur', function(e) {
        app.populateDate(e);
      });

      $(app.el_cvv +', '+ app.el_expDate).on('keypress', function(e) {
        return e.charCode >= 48 && e.charCode <= 57;
      });  
  };
  
  app.addSlash = function (e) {
    var isMonthEntered = app.monthRegex.exec(e.target.value);
    if (e.key >= 0 && e.key <= 9 && isMonthEntered) {
      e.target.value = e.target.value + " / ";
    }
  };
  
  app.removeSlash = function(e) {
    var isMonthAndSlashEntered = app.monthAndSlashRegex.exec(e.target.value);
    if (isMonthAndSlashEntered && e.key === 'Backspace') {
      e.target.value = e.target.value.slice(0, -3);
    }
  };
  
  app.populateDate = function(e) {
    var month, year;
    
    if (e.target.value.length == 7) {
      month = parseInt(e.target.value.slice(0, -5));
      year = "20" + e.target.value.slice(5);
      
      if (app.checkMonth(month)) {
        $(app.el_monthSelect).val(month);
      } else {
        $(app.el_monthSelect).val(0);
      }
      
      if (app.checkYear(year)) {
        $(app.el_yearSelect).val(year);
      } else {
        $(app.el_yearSelect).val(0);
      }
      
    }
  };
  
  app.checkMonth = function(month) {
    if (month <= 12) {
      var monthSelectOptions = app.getSelectOptions($(app.el_monthSelect));
      month = month.toString();
      if (monthSelectOptions.includes(month)) {
        return true; 
      }
    }
  };
  
  app.checkYear = function(year) {
    var yearSelectOptions = app.getSelectOptions($(app.el_yearSelect));
    if (yearSelectOptions.includes(year)) {
      return true; 
    }
  };
          
  app.getSelectOptions = function(select) {
    var options = select.find('option');
    var optionValues = [];
    for (var i = 0; i < options.length; i++) {
      optionValues[i] = options[i].value;
    }
    return optionValues;
  };
  
  app.setMaxLength = function ($elem, length) {
    if($elem.length && app.isInteger(length)) {
      $elem.attr('maxlength', length);
    }else if($elem.length){
      $elem.attr('maxlength', '');
    }
  };
  
  app.isInteger = function(x) {
    return (typeof x === 'number') && (x % 1 === 0);
  };

  app.createExpDateField = function() {
    $(app.el_monthSelect +', '+ app.el_yearSelect).hide();
    $(app.el_monthSelect).parent().prepend('<input type="text" class="ccFormatMonitor">');
  };
  
  
  app.isValidLength = function(cc_num, card_type) {
    for(var i in card_type.valid_length) {
      if (cc_num.length <= card_type.valid_length[i]) {
        return true;
      }
    }
    return false;
  };

  app.getCardType = function(cc_num) {
    for(var i in app.cardTypes) {
      var card_type = app.cardTypes[i];
      if (cc_num.match(card_type.pattern) && app.isValidLength(cc_num, card_type)) {
        return card_type;
      }
    }
  };

  app.getCardFormatString = function(cc_num, card_type) {
    for(var i in card_type.formats) {
      var format = card_type.formats[i];
      if (cc_num.length <= format.length) {
        return format;
      }
    }
  };

  app.formatCardNumber = function(cc_num, card_type) {
    var numAppendedChars = 0;
    var formattedNumber = '';
    var cardFormatIndex = '';

    if (!card_type) {
      return cc_num;
    }

    var cardFormatString = app.getCardFormatString(cc_num, card_type);
    for(var i = 0; i < cc_num.length; i++) {
      cardFormatIndex = i + numAppendedChars;
      if (!cardFormatString || cardFormatIndex >= cardFormatString.length) {
        return cc_num;
      }

      if (cardFormatString.charAt(cardFormatIndex) !== 'x') {
        numAppendedChars++;
        formattedNumber += cardFormatString.charAt(cardFormatIndex) + cc_num.charAt(i);
      } else {
        formattedNumber += cc_num.charAt(i);
      }
    }

    return formattedNumber;
  };

  app.monitorCcFormat = function($elem) {
    var cc_num = $elem.val().replace(/\D/g,'');
    var card_type = app.getCardType(cc_num);
    $elem.val(app.formatCardNumber(cc_num, card_type));
    app.addCardClassIdentifier($elem, card_type);
  };

  app.addCardClassIdentifier = function($elem, card_type) {
    var classIdentifier = app.el_ccUnknown;
    if (card_type) {
      classIdentifier = app.el_ccTypePrefix + card_type.code;
      app.setMaxLength($(app.el_cvv), card_type.security);
    } else {
      app.setMaxLength($(app.el_cvv));
    }

    if (!$elem.hasClass(classIdentifier)) {
      var classes = '';
      for(var i in app.cardTypes) {
        classes += app.el_ccTypePrefix + app.cardTypes[i].code + ' ';
      }
      $elem.removeClass(classes + app.el_ccUnknown);
      $elem.addClass(classIdentifier);
    }
  };

  
  app.init = function() {

    $(document).find(app.el_cardNumber).each(function() {
      var $elem = $(this);
      if ($elem.is('input')) {
        $elem.on('input', function() {
          app.monitorCcFormat($elem);
        });
      }
    });
    
    app.addListeners();
    
  }();
  
})();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<?php require_once("includes/footer.php"); ?>
</body>
</html>