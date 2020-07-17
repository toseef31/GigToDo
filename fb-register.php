<?php
session_start();
require_once("includes/db.php");
require_once("social-config.php");
if(isset($_SESSION['seller_user_name'])){
	echo "<script> window.open('index','_self'); </script>";
}
if(!isset($_SESSION['access_token'])){
	echo "<script> window.open('index','_self'); </script>";
	exit();
}
function getRealUserIp(){
  //This is to check ip from shared internet network
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}
$ip = getRealUserIp();

$email = $_SESSION['userData']['email'];
$where = array("seller_email" => $email);
$get_seller_email = $db->select("sellers",$where);
$check_seller_email = $get_seller_email->rowCount();
if($check_seller_email > 0){
	$row_seller_email = $get_seller_email->fetch();
	$u_name = $row_seller_email->seller_user_name;
	$_SESSION['seller_user_name']=$u_name;
	unset($_SESSION['userData']['email']);
	unset($_SESSION['userData']['first_name']);
	unset($_SESSION['userData']['picture']['url']);
	unset($_SESSION['access_token']);
	if($db->update("sellers",array("seller_status"=>'online',"seller_ip"=>$ip),$where)){
		echo "<script> window.open('index.php','_self'); </script>";
		exit();
	}
}
?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
<title> <?php echo $site_name; ?> - Facebook Registration </title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
<link href="styles/styles.css" rel="stylesheet">
<!-- <link href="styles/categories_nav_styles.css" rel="stylesheet"> -->
<link href="styles/sweat_alert.css" rel="stylesheet">
<!--- Stylesheet width modifications --->
<!-- <link href="styles/custom.css" rel="stylesheet"> -->
<!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet"> -->
<script type="text/javascript" src="js/ie.js"></script>
<script type="text/javascript" src="js/sweat_alert.js"></script>
<script src="js/jquery.min.js"></script>
</head>

<body class="all-content">

<?php require_once("includes/header-top.php"); ?>

<div class="container-fluid login-signup"><!--- container mt-5 Starts -->
	<div class="login-signup-wrapper login-wrapper"><!--- row justify-content-center Starts -->
		<div><!--- col-lg-5 col-md-7 Starts -->
			<div class="box-login mt-4 login-with-credentials"><!--- box-login mt-4 Starts -->
				<h2 class="text-center"> Continue To <?php echo $site_name; ?> </h2>
				<img class="logo" src="<?php echo $_SESSION['userData']['picture']['url'] ?>">
				<?php
				$form_errors = Flash::render("fb_errors");
				if(is_array($form_errors)){
					?>
					<div class="alert alert-danger mt-2"><!--- alert alert-danger Starts --->
						<ul class="list-unstyled mb-0">
							<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
								<li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
							<?php } ?>
						</ul>
					</div><!--- alert alert-danger Ends --->
				<?php } ?>
				<form action="" method="post"><!-- form Starts -->
					<div class="form-group"><!-- form-group Starts -->
						<label class="form-control-label font-weight-bold"> Full Name </label>
						<input type="text" class="form-control" name="name" value="<?php echo $_SESSION['userData']['first_name'] . " " . $_SESSION['userData']['last_name'] ?>" placeholder="Enter Your Full Name" required>
					</div><!-- form-group Ends -->
					<div class="form-group"><!-- form-group Starts -->
						<label class="form-control-label font-weight-bold"> Username </label>
						<input type="text" class="form-control" name="u_name" placeholder="Enter Your Username" required>
						<small class="form-text text-muted">
							Note: Usernames cannot be changed once an account is registered.
						</small>
					</div><!-- form-group Ends -->
					<div class="form-group"><!-- form-group Starts -->
						<label class="form-control-label font-weight-bold"> Email </label>
						<input type="email" class="form-control" disabled name="email" value="<?php echo $_SESSION['userData']['email'] ?>" placeholder="Enter Your Email" required>
					</div><!-- form-group Ends -->
					<div class="form-group">
						<input type="submit" name="continue" class="login-button" value="Continue">
					</div>
				</form><!--- form Ends -->
			</div><!-- text-center mt-3 Ends -->
		</div><!--- box-login mt-4 Ends -->
	</div><!--- col-lg-5 col-md-7 Ends -->
</div><!--- row justify-content-center Ends -->
</div><!--- container mt-5 Ends -->

<?php

if(isset($_POST['continue'])){


	$rules = array(
	"name" => "required",
	"u_name" => "required");

	$messages = array("name" => "Full Name Is Required.","u_name" => "User Name Is Required.");

	$val = new Validator($_POST,$rules,$messages);

	if($val->run() == false){

	Flash::add("fb_errors",$val->get_all_errors());

	Flash::add("form_data",$_POST);

	echo "<script>window.open('fb-register','_self')</script>";

	}else{


	$name = $input->post('name');
	
	$u_name = $input->post('u_name');

	$email = $_SESSION['userData']['email'];
		
	$url = $_SESSION['userData']['picture']['url'];
	 
    $data = file_get_contents($url);
 
    $new = "user_images/" . $_SESSION['userData']['id'] . ".jpg";
 
    file_put_contents($new, $data);
	
	$image = $_SESSION['userData']['id'] . ".jpg";
	
	$regsiter_date = date("F d, Y");
	
	$date = date("F d, Y");
	

	$check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
	
	$check_seller_email = $db->count("sellers",array("seller_email" => $email));
	
	if($check_seller_username > 0 ){
		
		echo "
		
	   <script>
      
           swal({
           
          type: 'warning',
          text: 'This username has already been used. Please try another one.',

          });

        </script>
		
		";
		
	}else{
		
		if($check_seller_email > 0){
			$update_fb_status = $db->update("sellers",array("fb_verification" => 1),array("seller_email" => $email));
		echo "
		
		<script>
      
           swal({
           
          type: 'warning',
          text: 'This email has already been used. Please try another one.',

          });

        </script>";	
			
		}else{
				
		$referral_code = mt_rand();
		
		$verification_code = "ok";
						

		$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_image" => $image,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online',"fb_verification" => 1));
		
		$regsiter_seller_id = $db->lastInsertId();
		
		if($insert_seller){
		
        $_SESSION['seller_user_name'] = $u_name;
				
				$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));

				if($insert_seller_account){
					
					unset($_SESSION['userData']);
					unset($_SESSION['access_token']);
					
					echo "
					
		        <script>
		  
		           swal({
		          
		          type: 'success',
		          text: 'Hey $u_name, welcome onboard. ',
		          timer: 2000,
		          onOpen: function(){
		          swal.showLoading()
		          }
		          }).then(function(){

		            // Read more about handling dismissals
		            window.open('$site_url','_self')

		        })

		        </script>";
					
				}
		}
						
		}
		
		}

	}
	
	}

?>

<?php require_once("includes/footer.php"); ?>

</body>

</html>