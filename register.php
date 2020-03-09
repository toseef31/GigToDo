<?php

session_start();

require_once("includes/db.php");

require_once("social-config.php");

if(isset($_SESSION['seller_user_name'])){
	
	echo "<script> window.open('index.php','_self'); </script>";
	
}

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
	<style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.swal2-popup .swal2-select{display: none;}</style>
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
							<h3 class="text-center">Sign Up</h3>
							<p class="text-center">Already have an account? <a href="login.php">Log In</a></p>
						</div>
						<?php if($enable_social_login == "yes"){ ?>
						<div class="login-by-social d-flex flex-column flex-lg-row align-items-center justify-content-center">

							<a class="social-button facebook d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?= $fLoginURL ?>';">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
								<span>Sign up with Facebook</span>
							</a>
							<a class="social-button linkedin d-flex flex-row align-items-center" href="javascript:void(0);">
								<span>
									<i class="fab fa-linkedin-in"></i>
								</span>
								<span>Sign up with Linkedin</span>
							</a>
							<a class="social-button google d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?= $gLoginURL ?>';">
								<span>
									<i class="fab fa-google"></i>
								</span>
								<span>Sign up with Google</span>
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
									<label class="control-label">Full Name</label>
									<input class="form-control" type="text" name="name" placeholder="Enter Your Full Name" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>" required="" />
								</div>
								<!-- <div class="form-group">
									<label class="control-label">Last Name</label>
									<input class="form-control" type="text" name="" />
								</div> -->
								<div class="form-group">
									<label class="control-label">Username</label>
									<input class="form-control" type="text" name="u_name" placeholder="Enter Your Username" value="<?php if(isset($_SESSION['u_name'])) echo $_SESSION['u_name']; ?>" required="" />
									<small class="form-text text-muted">Note: You will not be able to change username once your account has been created.</small>
									<?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
									<?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
									<?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
								</div>
								<div class="form-group">
									<label class="control-label">YOUR EMAIL ADDRESS</label>
									<input class="form-control" type="email" name="email" placeholder="Enter Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>" required="">
            			<?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
								</div>
								<div class="form-group">
									<label class="control-label">Password</label>
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
										<label class="control-label">ACCOUNT TYPE</label>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label for="customRadio1" class="custom-control custom-radio">
												<input type="radio" hidden id="customRadio1" name="accountType" class="custom-control-input" value="buyer">
												<div class="custom-control-label">Buyer</div>
											</label>
										</div>
									</div>
									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label for="customRadio2" class="custom-control custom-radio">
												<input type="radio" hidden id="customRadio2" name="accountType" class="custom-control-input" value="seller">
												<div class="custom-control-label">Seller</div>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group d-flex flex-row align-items-center justify-content-between">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="terms">
										<label class="custom-control-label" style="text-transform: none;" for="terms">I agree to the <a href="javascript:void(0);">Terms & Conditions</a></label>
									</div>
								</div>
								<div class="form-group">
									<button class="login-button" role="button" type="submit" name="register" disabled>Sign up</button>
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
$(document).on("click","#terms",function(){
        if($(this).prop("checked") == true){
        	$(':input[type="submit"]').prop('disabled', false);
        }
        else if($(this).prop("checked") == false){
        	$(':input[type="submit"]').prop('disabled', true);
        }
    });
   $("#phone_number").intlTelInput({
		 initialCountry:"{ 'sg': 'Singapore' }",
// localized country names e.g. { 'de': 'Deutschland' }

	 });
</script>
<?php require_once("includes/footer.php"); ?>
<?php require_once("includes/footerJs.php"); ?>



</body>

</html>