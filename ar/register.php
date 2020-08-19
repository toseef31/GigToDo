<?php

session_start();

require_once("includes/db.php");

require_once("social-config.php");

if(isset($_SESSION['seller_user_name'])){
	
	echo "<script> window.open('home.php','_self'); </script>";
	
}
$recaptcha_site_key = $row_general_settings->recaptcha_site_key;
$recaptcha_secret_key = $row_general_settings->recaptcha_secret_key;
?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF82RTH');</script>
<!-- End Google Tag Manager -->
	<title><?php echo $site_name; ?> - <?php echo $lang['titles']['login']; ?></title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Login or register for an account on <?php echo $site_name; ?>, a fast growing freelance marketplace, where sellers provide their services at extremely affordable prices.">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">

	<!--====== Favicon Icon ======-->
	<link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">

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
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #ff0707;}.swal2-popup .swal2-select{display: none;}
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
	</style>
</head>

<body class="home-content">


<?php require_once("includes/header-top.php"); ?>
	<!-- Preloader Start -->
	<div class="proloader">
		<div class="loader">
			<img src="assets/img/emongez_cube.png" />
		</div>
	</div>
	<!-- Preloader End -->
	<!-- Main content -->
	<main>
		<section class="container-fluid login-signup">
			<div class="row">
				<div class="container">
					<div class="login-signup-wrapper signup-wrapper">
						<div class="login-signup-header">
							<h3 class="text-center">التسجيل</h3>
							<p class="text-center">عندك حساب ؟ <a href="login.php">الدخول</a></p>
						</div>
						<?php if($enable_social_login == "yes"){ ?>
						<div class="login-by-social d-flex flex-column flex-lg-row align-items-center justify-content-center">
							<a class="social-button facebook d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?= $fLoginURL ?>';">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
								<span>التسجيل عن طريق فيسبوك</span>
							</a>
							<!-- <a class="social-button linkedin d-flex flex-row align-items-center" href="javascript:void(0);">
								<span>
									<i class="fab fa-linkedin-in"></i>
								</span>
								<span>التسجيل عن طريقlinkedin</span>
							</a> -->
							<a class="social-button google d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?= $gLoginURL ?>';">
								<span>
									<i class="fab fa-google"></i>
								</span>
								<span>التسجيل عن طريق جوجل</span>
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
							<?php } ?>
							<form action="" method="POST">
								<!-- <div class="form-group">
									<label class="control-label">الاسم الأول</label>
									<input class="form-control" type="text" name="name" placeholder="أدخل اسمك الكامل" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>" />
									<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['name']); ?></span>
								</div> -->
								<!-- <div class="form-group">
										<label class="control-label">Last Name</label>
										<input class="form-control" type="text" name="" />
								</div> -->
								<div class="form-group">
									<label class="control-label">اسم المستخدم</label>
									<input class="form-control" type="text" name="u_name" placeholder="أدخل اسم المستخدم الخاص بك" value="<?php if(isset($_SESSION['u_name'])) echo $_SESSION['u_name']; ?>" />
									<small class="form-text text-muted">ملاحظة: لن تتمكن من تغيير اسم المستخدم بمجرد إنشاء حسابك</small>
									<?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
									<?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
									<?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
									<?php if(in_array("يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.", $error_array)) echo "<span style='color:red;'>يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.</span> <br>"; ?>
									<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['u_name']); ?></span>
									<span id="space_error" class="form-text text-danger"></span>
								</div>
								<div class="form-group">
									<label class="control-label">الإيميل</label>
									<input class="form-control" type="email" name="email" placeholder="أدخل البريد الإلكتروني" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
									<?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
									<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['email']); ?></span>
								</div>
								<div class="form-group">
									<label class="control-label">كلمة المرور</label>
									<input class="form-control" type="password" name="pass" id="psw" placeholder="أدخل كلمة المرور"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="يجب أن يحتوي على رقم واحد على الأقل وحرف واحد كبير وحرف صغير ، وعلى الأقل 8 أحرف أو أكثر" />
									<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['pass']); ?></span>
								</div>
								<div id="message">
								  <!-- <h3>Password must contain the following:</h3> -->
								  <!-- <p id="letter" class="invalid"><b>حرف  </b> صغير </p>
								  <p id="capital" class="invalid"><b>العاصمة (الأحرف الكبيرة) </b> غير  </p> -->
								  <p id="number" class="invalid"><b>رقم</b></p>
								  <p id="length" class="invalid">الحد الأدنى  <b>8 أحرف</b></p>
								</div>
								<div class="form-group">
									<label class="control-label"> تاكيد كلمة المرور</label>
									<input type="password" class="form-control" id="confirm_pass" name="con_pass" placeholder="تأكيد كلمة المرور">
									<?php if(in_array("Passwords don't match. Please try again.", $error_array)) echo "<span style='color:red;'>Passwords don't match. Please try again.</span> <br>"; ?>
									<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['con_pass']); ?></span>
									<span id="match" class="pr-3"></span>
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
									<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['accountType']); ?></span>
								</div>
								<div class="form-group">
                  <label>يرجى التحقق من أنك جزء من الإنسانية.</label>
                  <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
                </div>
								<div class="form-group d-flex flex-row align-items-center justify-content-between mb-0">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" name="term" id="terms">
										<label class="custom-control-label" style="text-transform: none;" for="terms">اوافق على  <a href="javascript:void(0);">الشروط والأحكام</a></label>
									</div>
								</div>
								<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['term']); ?></span>
								<div class="form-group">
									<button class="login-button" role="button" type="submit" name="register" >انضم</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<!-- Main content end -->


<script>
// $(document).on("click","#terms",function(){
// 		if($(this).prop("checked") == true){
// 			$(':input[type="submit"]').prop('disabled', false);
// 		}
// 		else if($(this).prop("checked") == false){
// 			$(':input[type="submit"]').prop('disabled', true);
// 		}
// 	});
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
  // var lowerCaseLetters = /[a-z]/g;
  // if(myInput.value.match(lowerCaseLetters)) {  
  //   letter.classList.remove("invalid");
  //   letter.classList.add("valid");
  // } else {
  //   letter.classList.remove("valid");
  //   letter.classList.add("invalid");
  // }
  
  // Validate capital letters
  // var upperCaseLetters = /[A-Z]/g;
  // if(myInput.value.match(upperCaseLetters)) {  
  //   capital.classList.remove("invalid");
  //   capital.classList.add("valid");
  // } else {
  //   capital.classList.remove("valid");
  //   capital.classList.add("invalid");
  // }

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
$("input[name='u_name']").keyup(function(e) {   
   if (e.which === 32)  {
     // alert('you entered space');
     $("#space_error").html("يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.");
   }
});
</script>
<?php 
	if(isset($_POST['register'])){
		$rules = array(
		"u_name" => "required",
		"email" => "email|required",
		"pass" => "required",
		"con_pass" => "required",
		"accountType" => "required",
		"term" => "required");

		$messages = array("name" => "الإسم الكامل ضروري.","u_name" => "اسم المستخدم مطلوب.","pass" => "كلمة المرور مطلوبة.","con_pass" => "تأكيد كلمة المرور مطلوب.", "accountType" => "نوع الحساب مطلوب.", 'email' => 'البريد الالكتروني مطلوب' , "term" => "يرجى التحقق من الشروط والأحكام");
		$val = new Validator($_POST,$rules,$messages);

		if($val->run() == false){
			$_SESSION['error_array'] = array();
			Flash::add("register_errors",$val->get_all_errors());
			Flash::add("form_data",$_POST);
			echo "<script>window.open('register','_self')</script>";
		}else{
			$error_array = array();
			$secret_key = "$recaptcha_secret_key";
	    $response = $input->post('g-recaptcha-response');
	    $remote_ip = $_SERVER['REMOTE_ADDR'];
	    $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$remote_ip");
	    $result = json_decode($url, TRUE);
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
			$geoplugin = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
			$country = $geoplugin['geoplugin_countryName'];
			if(empty($country)){ $country = ""; }
			$regsiter_date = date("F d, Y");
			$date = date("F d, Y");
		
			$check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
			$check_seller_email = $db->count("sellers",array("seller_email" => $email));
			// if(preg_match('/[اأإء-ي]/ui', $input->post('u_name'))){
			//   array_push($error_array, "الأحرف الأجنبية غير مسموح بها في اسم المستخدم ، يرجى تجربة حرف آخر.");
			// }
			// if ( preg_match('/\s/',$input->post('u_name')) ){
			// 	array_push($error_array, "يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.");
			// }
			if($check_seller_username > 0 ){
			  array_push($error_array, "عذراً! وقد تم بالفعل اتخاذ هذا المستخدم. يرجى تجربة واحدة أخرى");
			}
			if($check_seller_email > 0){
			  array_push($error_array, "لقد اخذ الايميل من قبل. حاول تسجيل الدخول بدلاً من ذلك.");
			}
			if($pass != $con_pass){
	     	  array_push($error_array, "كلمتا المرور غير متطابقتين. حاول مرة اخرى.");
			}
	    
			if(empty($error_array)){

				$referral_code = mt_rand();
				if($signup_email == "yes"){
					$verification_code = mt_rand();
				}else{
					$verification_code = "ok";
				}
				$encrypted_password = password_hash($pass, PASSWORD_DEFAULT);
				$seller_activity = date("Y-m-d H:i:s");
				
				// This is just an example. In application this will come from Javascript (via an AJAX or something)
				$timezone_offset_minutes = $input->post('timezone');  // $_GET['timezone_offset_minutes']
				// Convert minutes to seconds and get timezone
				$timezone = timezone_name_from_abbr("", $timezone_offset_minutes*60, false);
				
				$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_pass" => $encrypted_password,"account_type" => $accountType,"seller_country"=>$country,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_activity"=>$seller_activity,"seller_timezone"=>$timezone,"seller_status" => 'online'));
						
				$regsiter_seller_id = $db->lastInsertId();
				if($insert_seller){
				  $_SESSION['seller_user_name'] = $u_name;
					$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));
					if($paymentGateway == 1){
						$insert_seller_settings = $db->insert("seller_settings",array("seller_id" => $regsiter_seller_id));
					}
					if($insert_seller_account){
						if(!empty($referral)){
					    $sel_seller = $db->select("sellers",array("seller_referral" => $referral));		
							$row_seller = $sel_seller->fetch();
							$seller_id = $row_seller->seller_id;	
							$seller_ip = $row_seller->seller_ip;
							if($seller_ip == $ip){
								echo "<script>alert('You Cannot Refer Yourself.');</script>";
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
					      $get_seller = $db->select("sellers",array("seller_id" => $regsiter_seller_id));		
					  		$seller_meta = $get_seller->fetch();
					  		//print_r($seller_meta); die();
					  		if($seller_meta->account_type == 'buyer'){

			           
			           
			          echo "
			          <script>
			          swal({
			          type: 'success',
			          text: 'سجلت بنجاح! مرحبًا بكم على متن   $name. ',
			          timer: 6000,
			          onOpen: function(){
			          swal.showLoading()
			          }
			          }).then(function(){
			          if (
			          // Read more about handling dismissals
			          window.open('$site_url/ar/','_self')
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
					      }else{

							echo "
							<script>
							swal({
							type: 'success',
							text: 'سجلت بنجاح! مرحبًا بكم على متن   $name. ',
							timer: 6000,
							onOpen: function(){
							swal.showLoading()
							}
							}).then(function(){
							if (
							// Read more about handling dismissals
							window.open('$site_url/ar/dashboard','_self')
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
			}
			if(!empty($error_array)){
				$_SESSION['error_array'] = $error_array;
				echo "
				<script>
				swal({
					type: 'warning',
					html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
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

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

</body>

</html>