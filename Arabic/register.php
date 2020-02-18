<?php

session_start();

require_once("includes/db.php");

require_once("social-config.php");

if(isset($_SESSION['seller_user_name'])){
	
	echo "<script> window.open('index.php','_self'); </script>";
	
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("$dir/functions/email.php");

$get_general_settings = $db->select("general_settings");   
$row_general_settings = $get_general_settings->fetch();
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;
$site_name = $row_general_settings->site_name;
$signup_email = $row_general_settings->signup_email;
$referral_money = $row_general_settings->referral_money;
?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>

	<title><?php echo $site_name; ?> - <?php echo $lang['titles']['login']; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Login or register for an account on <?php echo $site_name; ?>, a fast growing freelance marketplace, where sellers provide their services at extremely affordable prices.">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">

	<!--====== Favicon Icon ======-->
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/png">

	<!-- ==============Google Fonts============= -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

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

	<!--====== Default css ======-->
	<link href="assets/css/default.css" rel="stylesheet">

	<!--====== Style css ======-->
	<link href="assets/css/style.css" rel="stylesheet">

	<!--====== Responsive css ======-->
	<link href="assets/css/responsive.css" rel="stylesheet">

	<link href="styles/sweat_alert.css" rel="stylesheet">
	<link href="styles/animate.css" rel="stylesheet">
	<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
	<script src="js/ie.js"></script>
	<script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}</style>
</head>

<body class="home-content">


<?php //require_once("includes/header.php"); ?>
	<!-- Preloader Start -->
	<div class="proloader">
		<div class="loader">
			<img src="assets/img/emongez_cube.png" />
		</div>
	</div>
	<!-- Preloader End -->
	<!-- Header -->
	<header>
		<div class="header-top">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-md-3 d-flex flex-row">
						<div class="logo">
							<a class="home-logo" href="index.html"><img src="assets/img/signin-logo.png" alt=""></a>
						</div>
					</div>
					<div class="col-6 col-md-9">
						<div class="header-right d-flex align-items-center justify-content-end">
							<div class="menu-inner">
								<ul>
                  <li><a href="javascript:void(0);">نشر طلب</a></li>
                  <li><a href="javascript:void(0);">كيف تعمل</a></li>
                </ul>
							</div>
							<div class="language-inner">
                <select name="" id="" onChange="window.location.href=this.value">
                  <option value="<?= $site_url?>">EN</option>
                  <option value="" selected="">AR</option>
                </select>
              </div>
							<div class="usd-inner">
								<select name="" id="">
									<option value="">USD</option>
									<option value="">EGP</option>
								</select>
							</div>
							<div class="Login-button">
                <a href="login.php">تسجيل الدخول</a>
                <a href="register.php">نضم الان</a>
              </div>
							<div class="menubar d-lg-none">
								<div class="d-flex flex-row align-items-center">
									<div class="image">
										<img src="assets/img/menu-left-logo.png" alt="">
									</div>
									<div class="icon">
										<span></span>
										<span></span>
										<span></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Header END-->

	<!-- Offcanvas-menu -->
	<div class="ofcanvas-menu pre-login">
		<div class="close-icon">
			<i class="fal fa-times"></i>
		</div>
		<div class="canvs-menu">
			<ul class="d-flex flex-column">
				<li>
          <a href="javascript:void(0);">نشر طلب</a>
        </li>
        <li>
          <a href="javascript:void(0);">كيف تعمل</a>
        </li>
				<li class="d-flex flex-row">
					<div class="menu-action">
            <select name="" id="" onChange="window.location.href=this.value">
              <option value="<?= $site_url?>">EN</option>
              <option value="" selected="">AR</option>
            </select>
					</div>
					<div class="menu-action">
						<select name="" id="">
							<option value="">USD</option>
							<option value="">EGP</option>
						</select>
					</div>
				</li>
				<li class="mb-20">
          <a class="button login-button" href="login.php">
            الدخول
          </a>
        </li>
        <li>
          <a class="button join-button" href="register.php">
            انضم دلوقتي
          </a>
        </li>
			</ul>
		</div>
	</div>
	<!-- Close-overlay -->
	<div class="overlay-bg"></div>
	<!-- Offcanvas-menu END-->
	<!-- Main content -->
	<main>
		<section class="container-fluid login-signup">
			<div class="row">
				<div class="container">
					<div class="login-signup-wrapper signup-wrapper">
						<div class="login-signup-header">
							<h3 class="text-center">التسجيل</h3>
							<p class="text-center">عندك حساب أصلا ؟ <a href="login.php">الدخول</a></p>
						</div>
						<?php if($enable_social_login == "yes"){ ?>
						<div class="login-by-social d-flex flex-column flex-lg-row align-items-center justify-content-center">
							<a class="social-button facebook d-flex flex-row align-items-center" href="javascript:void(0);">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
								<span>التسجيل عن طريق Facebook</span>
							</a>
							<a class="social-button linkedin d-flex flex-row align-items-center" href="javascript:void(0);">
								<span>
									<i class="fab fa-linkedin-in"></i>
								</span>
								<span>التسجيل عن طريقlinkedin</span>
							</a>
							<a class="social-button google d-flex flex-row align-items-center" href="javascript:void(0);">
								<span>
									<i class="fab fa-google"></i>
								</span>
								<span>التسجيل عن طريقGoogle</span>
							</a>
						</div>
					<?php } ?>
						<div class="login-with-credentials">
							<?php 
							  $form_errors = Flash::render("register_errors");
							  $form_data = Flash::render("form_data");
							  if(is_array($form_errors)){
							  ?>
							<div class="alert alert-danger">
							  <!--- alert alert-danger Starts --->
							  <ul class="list-unstyled mb-0">
							    <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
							    <li class="list-unstyled-item"><?= $i ?>. <?= ucfirst($error); ?></li>
							    <?php } ?>
							  </ul>
							</div>
							<script type="text/javascript">
			          $(document).ready(function(){
			            $('#register-modal').modal('show');
			          });
			        </script>
			        <?php } ?>
							<form action="" method="POST">
								<div class="form-group">
									<label class="control-label">الاسم الأول</label>
									<input class="form-control" type="text" name="name" placeholder="Enter Your Full Name" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>" required="" />
								</div>
								<!-- <div class="form-group">
									<label class="control-label">Last Name</label>
									<input class="form-control" type="text" name="" />
								</div> -->
								<div class="form-group">
									<label class="control-label">الاسم الأخير</label>
									<input class="form-control" type="text" name="u_name" placeholder="Enter Your Username" value="<?php if(isset($_SESSION['u_name'])) echo $_SESSION['u_name']; ?>" required="" />
									<small class="form-text text-muted">Note: You will not be able to change username once your account has been created.</small>
									<?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
									<?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
									<?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
								</div>
								<div class="form-group">
									<label class="control-label">الإيميل</label>
									<input class="form-control" type="email" name="email" placeholder="Enter Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>" required="">
            			<?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
								</div>
								<div class="form-group">
									<label class="control-label">الباسوورد</label>
									<input class="form-control" type="password" name="pass" placeholder="Enter Password" required="" />
								</div>
								<div class="form-group">
								  <label class="control-label"> Confirm Password: </label>
								  <input type="password" class="form-control" name="con_pass" placeholder="Confirm Password" required="">
								  <?php if(in_array("Passwords don't match. Please try again.", $error_array)) echo "<span style='color:red;'>Passwords don't match. Please try again.</span> <br>"; ?>
								</div>
								<?php if(isset($_GET['referral'])){ ?>
			          <input type="hidden" class="form-control" name="referral" value="<?= $input->get('referral'); ?>">
			          <?php }else{ ?>
			          <input type="hidden" class="form-control" name="referral" value="">
			          <?php } ?>
			          <input type="hidden" name="timezone" value="">
								<div class="row">
									<div class="col-12">
										<label class="control-label">نوع الحساب</label>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label for="customRadio1" class="custom-control custom-radio">
												<input type="radio" hidden id="customRadio1" name="accountType" class="custom-control-input" value="buyer">
												<div class="custom-control-label">مشترى</div>
											</label>
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label for="customRadio2" class="custom-control custom-radio">
												<input type="radio" hidden id="customRadio2" name="accountType" class="custom-control-input" value="seller">
												<div class="custom-control-label">بائع</div>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group d-flex flex-row align-items-center justify-content-between">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" style="text-transform: none;" for="customCheck1">اوافق على  <a href="javascript:void(0);">الشروط والأحكام</a></label>
									</div>
								</div>
								<div class="form-group">
									<button class="login-button" role="button" type="submit" name="register">التسجيل</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<!-- Main content end -->


<?php
if(isset($_POST['register'])){
	
	$rules = array(
	"name" => "required",
	"u_name" => "required",
	"email" => "email|required",
	"pass" => "required",
	"con_pass" => "required",
	"accountType" => "required");

	$messages = array("name" => "Full Name Is Required.","u_name" => "User Name Is Required.","pass" => "Password Is Required.","con_pass" => "Confirm Password Is Required.", "accountType" => "Account Tyoe Is Required.");
	$val = new Validator($_POST,$rules,$messages);

	if($val->run() == false){
		$_SESSION['error_array'] = array();
		Flash::add("register_errors",$val->get_all_errors());
		Flash::add("form_data",$_POST);
		echo "<script>window.open('index','_self')</script>";
	}else{
		$error_array = array();
		$name = strip_tags($input->post('name'));
		$name = strip_tags($name);
		$name = ucfirst(strtolower($name));
		$_SESSION['name']= $name;
		$u_name = strip_tags($input->post('u_name'));
		$u_name = strip_tags($u_name);
		$_SESSION['u_name']= $u_name;
		$email = strip_tags($input->post('email'));
		$email = strip_tags($email);
		$_SESSION['email']=$email;
		$pass = strip_tags($input->post('pass'));
		$con_pass = strip_tags($input->post('con_pass'));
		$accountType = strip_tags($input->post('accountType'));
		$referral = strip_tags($input->post('referral'));
		// $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
		// $country = $xml->geoplugin_countryName;
		$country = '';
		$regsiter_date = date("F d, Y");
		$date = date("F d, Y");

	
		$check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
		$check_seller_email = $db->count("sellers",array("seller_email" => $email));
		if(preg_match('/[اأإء-ي]/ui', $input->post('u_name'))){
		  array_push($error_array, "Foreign characters are not allowed in username, Please try another one.");
		}
		if($check_seller_username > 0 ){
		  array_push($error_array, "Opps! This username has already been taken. Please try another one");
		}
		if($check_seller_email > 0){
		  array_push($error_array, "Email has already been taken. Try logging in instead.");
		}
		if($pass != $con_pass){
      array_push($error_array, "Passwords don't match. Please try again.");
		}
    
		if(empty($error_array)){

			$referral_code = mt_rand();

			if($signup_email == "yes"){
				$verification_code = mt_rand();
			}else{
				$verification_code = "ok";
			}

			$encrypted_password = password_hash($pass, PASSWORD_DEFAULT);
			
			$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_pass" => $encrypted_password,"account_type" => $accountType,"seller_country"=>$country,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online'));
					
			$regsiter_seller_id = $db->lastInsertId();
			if($insert_seller){
				
		    $_SESSION['seller_user_name'] = $u_name;
				$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));

				if($insert_seller_account){

					if(!empty($referral)){
				    $sel_seller = $db->select("sellers",array("seller_referral" => $referral));		
						$row_seller = $sel_seller->fetch();
						$seller_id = $row_seller->seller_id;	
						$seller_ip = $row_seller->seller_ip;
						if($seller_ip == $ip){
							echo "<script>alert('You Cannot Referral Yourself To Make Money.');</script>";
						}else{
							$count_referrals = $db->count("referrals",array("ip" => $ip));	
							if($count_referrals == 1){
						    echo "<script>alert('You are trying to referral yourself more then one time.');</script>";
							}else{
								$insert_referral = $db->insert("referrals",array("seller_id" => $seller_id,"referred_id" => $regsiter_seller_id,"comission" => $referral_money,"date" => $date,"ip" => $ip,"status" => 'pending'));
							}
						}	
					}

					if($signup_email == "yes"){
						userSignupEmail($email);
				  }

					echo "
					<script>
					swal({
					type: 'success',
					text: 'Successfully Registered! Welcome onboard, $name. ',
					timer: 6000,
					onOpen: function(){
					swal.showLoading()
					}
					}).then(function(){
					if (
					// Read more about handling dismissals
					window.open('$site_url','_self')
					) {
					console.log('Successful Registration')
					}
					})
					</script>
					";
					$_SESSION['name'] = "";
					$_SESSION['u_name']="";
					$_SESSION['email']= "";
					$_SESSION['error_array'] = array();
						
				}
					
			}
					
		}
			
		if(!empty($error_array)){
			$_SESSION['error_array'] = $error_array;
			echo "
			<script>
			swal({
			type: 'warning',
			html: $('<div>').text('Opps! There are some errors on the form. Please try again.'),
			animation: false,
			customClass: 'animated tada'
			}).then(function(){
			window.open('index','_self')
			});
			</script>";
		}

	}
	
}
    
?>

<?php require_once("includes/footer.php"); ?>
<?php require_once("includes/footerJs.php"); ?>



</body>

</html>