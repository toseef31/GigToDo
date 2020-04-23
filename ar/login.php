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
	<style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #ff0707;}.swal2-popup .swal2-select{display: none;}</style>
	<style>
		#forgot-modal .form-group .form-control {
	    background-color: white;
	    border-color: #afafaf;
	    -webkit-border-radius: 5px;
	    -moz-border-radius: 5px;
	    border-radius: 5px;
	    border-style: solid;
	    border-width: 1px;
	    border: 1px solid #afafaf;
	    -webkit-box-shadow: none;
	    -moz-box-shadow: none;
	    box-shadow: none;
	    color: #424242;
	    font-size: 14px;
	    font-family: 'Montserrat', sans-serif;
	    font-weight: 400;
	    height: 60px;
	    padding: 12px 15px;
	    -webkit-transition: all 0.3s ease-in-out 0s;
	    -o-transition: all 0.3s ease-in-out 0s;
	    -moz-transition: all 0.3s ease-in-out 0s;
	    transition: all 0.3s ease-in-out 0s;
		}
		#forgot-modal .login-button {
	    background-color: #ff0707;
	    border: 2px solid #ff0707;
	    -webkit-border-radius: 5px;
	    -moz-border-radius: 5px;
	    border-radius: 5px;
	    color: white;
	    font-size: 16px;
	    font-family: 'Montserrat', sans-serif;
	    font-weight: 600;
	    height: 60px;
	    -webkit-transition: all 0.4s ease-in-out 0s;
	    -o-transition: all 0.4s ease-in-out 0s;
	    -moz-transition: all 0.4s ease-in-out 0s;
	    transition: all 0.4s ease-in-out 0s;
	    text-transform: uppercase;
	    width: 100%;
		}
		.modal-header .close {
	    padding: 1rem;
	    margin: -1rem auto -1rem -1rem;
		}
	</style>
</head>

<body class="all-content">

<?php require_once("includes/header-top.php"); ?>
	<!-- Preloader Start -->
	<div class="proloader">
		<div class="loader">
			<img src="assets/img/emongez_cube.png" />
		</div>
	</div>
	<!-- Preloader End -->

<!-- <div class="container mt-5">

	<div class="row justify-content-center">

		<div class="col-lg-5 col-md-7">

			<h2 class="text-center"><?php echo str_replace('{site_name}',$site_name,$lang['login']['title']); ?></h2>

			<div class="box-login mt-4">

				<h2 class="text-center mb-3 mt-3"><i class="fa fa-unlock-alt" ></i></h2>

				<?php 

				$form_errors = Flash::render("login2_errors");

				if(is_array($form_errors)){

				?>

				<div class="alert alert-danger"> -->
					<!--- alert alert-danger Starts --->

				<!-- <ul class="list-unstyled mb-0">
				<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
				<li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
				<?php } ?>
				</ul>

				</div> -->
				<!--- alert alert-danger Ends --->
				<?php } ?>

				<!-- <form action="" method="post">

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

</div> -->
    <!-- Main content -->
    <main>
    	<section class="container-fluid login-signup">
    		<div class="row">
    			<div class="container">
    				<div class="login-signup-wrapper login-wrapper">
    					<div class="login-signup-header">
    						<h3 class="text-center">
								أهلا بيك من تاني، سجل الدخوللحسابك
								</h3>
    						<p class="text-center">ماعندكش حساب؟ <a href="register.php">سجل</a></p>
    					</div>
    					<?php if($enable_social_login == "yes"){ ?>
    					<div class="login-by-social d-flex flex-column align-items-center justify-content-center">
    						<a class="social-button facebook d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location='<?php echo $fLoginURL ?>';">
    							<span>
    								<i class="fab fa-facebook-f"></i>
    							</span>
    							<span> تسجيل الدخول عن طريق  Facebook</span>
    						</a>
    						<a class="social-button linkedin d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?php echo $linkLoginURL; ?>'">
    							<span>
    								<i class="fab fa-linkedin-in"></i>
    							</span>
    							<span>تسجيل الدخول ب linkedin</span>
    						</a>
    						<a class="social-button google d-flex flex-row align-items-center" href="javascript:void(0);" onclick="window.location = '<?php echo $gLoginURL ?>';">
    							<span>
    								<i class="fab fa-google"></i>
    							</span>
    							<span>تسجيل الدخول ب Google</span>
    						</a>
    					</div>
    				<?php } ?>
    					<div class="login-with-credentials">
    						<?php 

    						$form_errors = Flash::render("login_errors");
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
    								<label class="control-label">الإيميل   أو   اسم المستخدم</label>
    								<input class="form-control" type="text" placeholder="أدخل اسم المستخدم أو البريد الإلكتروني"  name="seller_user_name" value= "<?php if(isset($_SESSION['seller_user_name'])) echo $_SESSION['seller_user_name']; ?>"/>
    								<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['seller_user_name']); ?></span>
    							</div>
    							<div class="form-group">
    								<label class="control-label">الباسوورد</label>
    								<input class="form-control" type="password" name="seller_pass" placeholder="أدخل كلمة المرور" />
    								<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['seller_pass']); ?></span>
    							</div>
    							<div class="form-group d-flex flex-row align-items-center justify-content-between">
    								<div class="custom-control custom-checkbox">
    									<input type="checkbox" class="custom-control-input" name="remember" id="customCheck1">
    									<label class="custom-control-label" for="customCheck1">افتكرني</label>
    								</div>
    								<a class="fogot-password" href="javascript:void(0);" data-toggle="modal" data-target="#forgot-modal" data-dismiss="modal">نسيت الباسوورد ؟</a>
    							</div>
    							<div class="form-group">
    								<button class="login-button" role="button" type="submit" name="login">تسجيل الدخول</button>
    							</div>
    							<div class="form-group">
    								<p class="text-center">لما تضغط على تسجيل الدخول ، Facebook أو Linkedinأو Google<br />معناه إنك موافق على <a href="javascript:void(0);">شروطنا وأحكامنا الجديدة</a></p>
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
	if(isset($_POST['login'])){
		
		$rules = array(
		"seller_user_name" => "required",
		"seller_pass" => "required"
		);
		$messages = array("seller_user_name" => "أدخل اسم المستخدم أو البريد الإلكتروني","seller_pass" => "كلمة المرور مطلوبة.");

		$val = new Validator($_POST,$rules,$messages);

		if($val->run() == false){
			Flash::add("login_errors",$val->get_all_errors());
			Flash::add("form_data",$_POST);
			echo "<script>window.open('login','_self')</script>";
		}else{

			$seller_user_name = $input->post('seller_user_name');
			$seller_pass = $input->post('seller_pass');
			// $select_seller = $db->query("select * from sellers where seller_user_name=:u_name",array(":u_name"=>$seller_user_name));
			$select_seller = $db->query("select * from sellers where (seller_user_name = '".$seller_user_name."' OR seller_email = '".$seller_user_name."')");
			$row_seller = $select_seller->fetch();
			@$hashed_password = $row_seller->seller_pass;
			@$user_name = $row_seller->seller_user_name;
			@$seller_status = $row_seller->seller_status;
			$decrypt_password = password_verify($seller_pass, $hashed_password);
			
			if($decrypt_password == 0){
				echo "
				<script>
	        swal({
	          type: 'warning',
	          html: $('<div>')
	            .text('عذراً! كلمة المرور أو اسم المستخدم غير صحيح. حاول مرة اخرى.'),
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
                .text('لقد تم حظرك من قبل المشرف. يرجى الاتصال بدعم العملاء.'),
              animation: false,
              customClass: 'animated tada'
            })
			    	</script>";
				}elseif($seller_status == "deactivated"){
					echo "
					<script>
					swal({
					  type: 'warning',
					  html: $('<div>').text('لقد قمت بتعطيل حسابك ، يرجى الاتصال بنا للحصول على مزيد من التفاصيل.'),
					  animation: false,
					  customClass: 'animated tada'
					})
					</script>";
				}else{
					$select_seller = $db->select("sellers",array("seller_user_name"=>$user_name,"seller_pass"=>$hashed_password));
					if($select_seller){
						$_SESSION['seller_user_name'] = $user_name;
						if( ($_POST['remember']==1) || ($_POST['remember']=='on')) {
							$hour = time()+3600 *24 * 30;

							setcookie('seller_user_name', $user_name, $hour);
							setcookie('seller_pass', $hashed_password, $hour);
						}
						if(isset($_SESSION['seller_user_name']) and $_SESSION['seller_user_name'] === $user_name){
							$update_seller_status = $db->update("sellers",array("seller_status"=>'online',"seller_ip"=>$ip),array("seller_user_name"=>$seller_user_name,"seller_pass"=>$hashed_password));
							$seller_user_name = ucfirst(strtolower($seller_user_name));
					      if($row_seller->account_type == 'buyer'){

					      	$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		         
			          echo "
			          <script>
			                swal({
			                type: 'success',
			                text: 'رحبًا   $seller_user_name ، مرحبًا بك مرة أخرى!',
			                timer: 2000,
			                onOpen: function(){
			                  swal.showLoading()
			                }
			                }).then(function(){
			                  window.open('$url','_self')
			              });
			          </script>";
					      }else{
								$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			          echo "
			          <script>
			                swal({
			                type: 'success',
			                text: 'رحبًا   $seller_user_name ، مرحبًا بك مرة أخرى!',
			                timer: 2000,
			                onOpen: function(){
			                  swal.showLoading()
			                }
			                }).then(function(){
			                  window.open('dashboard','_self')
			              });
			          </script>";
			      	}
						}
					}
				}
		  }
				
		}
		
	}

	
    
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
<?php require_once("includes/footerJs.php"); ?>



</body>

</html>