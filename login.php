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
									<li><a href="javascript:void(0);">Post a Request</a></li>
									<li><a href="javascript:void(0);">How it Works</a></li>
								</ul>
							</div>
							<div class="language-inner">
								<select name="" id="">
									<option value="">EN</option>
									<option value="">AR</option>
								</select>
							</div>
							<div class="usd-inner">
								<select name="" id="">
									<option value="">USD</option>
									<option value="">EGP</option>
								</select>
							</div>
							<div class="Login-button d-none d-lg-flex">
								<a href="javascript:void(0);">Login</a>
								<a href="javascript:void(0);">Join Now</a>
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
					<a href="javascript:void(0);">Post A Request</a>
				</li>
				<li>
					<a href="javascript:void(0);">How it Works</a>
				</li>
				<li class="d-flex flex-row">
					<div class="menu-action">
						<select name="" id="">
							<option value="">EN</option>
							<option value="">AR</option>
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
					<a class="button login-button" href="javascript:void(0);">Login</a>
				</li>
				<li>
					<a class="button join-button" href="javascript:void(0);">Join Now</a>
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
					<div class="login-signup-wrapper login-wrapper">
						<div class="login-signup-header">
							<h3 class="text-center">Welcome Back, Sign-In to your Account</h3>
							<p class="text-center">Don't have an account? <a href="javascript:void(0);">Sign Up</a></p>
						</div>
						<div class="login-by-social d-flex flex-column align-items-center justify-content-center">
							<a class="social-button facebook d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location='<?php echo $fLoginURL ?>';">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
								<span>Login with Facebook</span>
							</a>
							<a class="social-button linkedin d-flex flex-row align-items-center" href="javascript:void(0);">
								<span>
									<i class="fab fa-linkedin-in"></i>
								</span>
								<span>Login with Linkedin</span>
							</a>
							<a class="social-button google d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?php echo $gLoginURL ?>';">
								<span>
									<i class="fab fa-google"></i>
								</span>
								<span>Login with Google</span>
							</a>
						</div>
						<div class="login-with-credentials">
							<?php 

							$form_errors = Flash::render("login2_errors");
							$form_data = Flash::render("form_data");
							if(is_array($form_errors)){

							?>

							<div class="alert alert-danger"><!--- alert alert-danger Starts --->

							<ul class="list-unstyled mb-0">
							<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
							<li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
							<?php } ?>
							</ul>

							</div><!--- alert alert-danger Ends --->
							<?php } ?>
							<form action="" method="POST">
								<div class="form-group">
									<label class="control-label">Username</label>
									<input class="form-control" type="text" placeholder="Enter Username"  name="seller_user_name" value= "<?php if(isset($_SESSION['seller_user_name'])) echo $_SESSION['seller_user_name']; ?>" required=""/>
								</div>
								<div class="form-group">
									<label class="control-label">Password</label>
									<input class="form-control" type="password" name="seller_pass" placeholder="Enter Password" required=""/>
								</div>
								<div class="form-group d-flex flex-row align-items-center justify-content-between">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Remember me</label>
									</div>
									<a class="fogot-password" href="javascript:void(0);">Forgot password?</a>
								</div>
								<div class="form-group">
									<button class="login-button" role="button" type="submit" name="access">Sign in</button>
								</div>
								<div class="form-group">
									<p class="text-center">By clicking Log In, Facebook or LinkedIn<br />you agree to our new <a href="javascript:void(0);">T&C's</a></p>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<!-- Main content end -->

<div class="container mt-5">

	<div class="row justify-content-center">

		<div class="col-lg-5 col-md-7">

			<h2 class="text-center"><?php echo str_replace('{site_name}',$site_name,$lang['login']['title']); ?></h2>

			<div class="box-login mt-4">

				<h2 class="text-center mb-3 mt-3"><i class="fa fa-unlock-alt" ></i></h2>

				<?php 

				$form_errors = Flash::render("login2_errors");

				if(is_array($form_errors)){

				?>

				<div class="alert alert-danger"><!--- alert alert-danger Starts --->

				<ul class="list-unstyled mb-0">
				<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
				<li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
				<?php } ?>
				</ul>

				</div><!--- alert alert-danger Ends --->
				<?php } ?>

				<form action="" method="post">

					<div class="form-group">

						<input type="text" name="seller_user_name" class="form-control" placeholder= "Username" required>
					
                    </div>

                    <div class="form-group">

						<input type="password" name="seller_pass" class="form-control" placeholder="Password" required>
					
                    </div>


                    <div class="form-group">

						<input type="submit" name="access" class="btn btn-success btn-block" value="Login" required>
					
                    </div>

				</form>
				<?php if($enable_social_login == "yes"){ ?>

				<div class="text-center pt-2 pb-2"><?php echo $lang['modals']['login']['or']; ?></div>

				<hr class="mb-0 mt-0">

				<div class="line mt-3"><span></span></div>

				<div class="text-center">

				<a href="#" onclick="window.location='<?php echo $fLoginURL ?>';" class="btn btn-primary text-white" >

				<i class="fa fa-facebook"></i> FACEBOOK

				</a>

				<a href="#" onclick="window.location = '<?php echo $gLoginURL ?>';" class="btn btn-danger text-white">

				<i class="fa fa-google-plus"></i> GOOGLE

				</a>
				
				</div>			

				<div class="clearfix"></div>

                <?php } ?>
            
				<div class="text-center mt-3">

					<a href="#" data-toggle="modal" data-target="#register-modal">

					<i class="fa fa-user-plus"></i> <?php echo $lang['modals']['login']['not_registerd']; ?>

                    </a>

					&nbsp; &nbsp; | &nbsp; &nbsp;

                    <a href="#" data-toggle="modal" data-target="#forgot-modal">

                    	<i class="fa fa-meh-o"></i>	<?php echo $lang['modals']['login']['forgot_password']; ?>

                    </a>

             </div>
   
            </div>


		</div>

	</div>

</div>
    
<?php
    
    if(isset($_POST['access'])){
	
	$rules = array(
	"seller_user_name" => "required",
	"seller_pass" => "required");

	$messages = array("seller_user_name" => "Username Is Required.","seller_pass" => "Password Is Required.");

	$val = new Validator($_POST,$rules,$messages);

	if($val->run() == false){

	Flash::add("login2_errors",$val->get_all_errors());

	echo "<script>window.open('login','_self')</script>";

	}else{

	$seller_user_name = $input->post('seller_user_name');
	
	$seller_pass = $input->post('seller_pass');

	$select_seller = $db->query("select * from sellers where binary seller_user_name like :u_name",array(":u_name"=>$seller_user_name));
		
	$row_seller = $select_seller->fetch();
	
	@$hashed_password = $row_seller->seller_pass;

	@$seller_status = $row_seller->seller_status;
	
	$decrypt_password = password_verify($seller_pass, $hashed_password);
	
	if($decrypt_password == 0){
		
		echo "
			
		<script>
    
            swal({
              type: 'warning',
              html: $('<div>')
                .text('Opps! password or username is incorrect. Please try again.'),
              animation: false,
              customClass: 'animated tada'
            })

    </script>
		
		";
		
	}else{
		
	if($seller_status == "block-ban"){
			
		echo "
			
		<script>
    
            swal({
              type: 'warning',
              html: $('<div>')
                .text('You Have Been Blocked By Admin Please Contact Customer Support.'),
              animation: false,
              customClass: 'animated tada'
            });

    	</script>";
		
	}elseif($seller_status == "deactivated"){
		echo "
		<script>
		swal({
		  type: 'warning',
		  html: $('<div>').text('You have deactivated your account, please contact us for more details.'),
		  animation: false,
		  customClass: 'animated tada'
		})
		</script>";
	}else{

		$select_seller = $db->select("sellers",array("seller_user_name"=>$seller_user_name,"seller_pass"=>$hashed_password));

			if($select_seller){
				$update_seller = $db->update("sellers",array("seller_status"=>'online',"seller_ip"=>$ip),array("seller_user_name"=>$seller_user_name,"seller_pass"=>$hashed_password));
				$_SESSION['sessionStart'] = $seller_user_name;
				echo "
				<script>
				swal({
					type: 'success',
					text: 'Successfully Logging you in...',
					timer: 4000,
					onOpen: function(){
					swal.showLoading()
					}
				}).then(function(){
					window.open('$site_url','_self')
				})
				</script>";
			}

		}
		
	}
	
	}
	
}


    
?>

<?php require_once("includes/footer.php"); ?>



</body>

</html>