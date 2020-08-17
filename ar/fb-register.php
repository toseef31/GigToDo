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
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF82RTH');</script>
<!-- End Google Tag Manager -->
<title> <?php echo $site_name; ?> - Facebook Registration </title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="<?php echo $site_author; ?>">
<link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet" >
<link href="styles/bootstrap.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
<link href="styles/categories_nav_styles.css" rel="stylesheet">
<link href="styles/sweat_alert.css" rel="stylesheet">
<!--- Stylesheet width modifications --->
<link href="styles/custom.css" rel="stylesheet">
<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
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

						<label class="form-control-label font-weight-bold"> الاسم الكامل </label>

						<input type="text" class="form-control" name="name" value="<?php echo $_SESSION['userData']['first_name'] . " " . $_SESSION['userData']['last_name'] ?>" placeholder="Enter Your Full Name" required>

					</div><!-- form-group Ends -->


					<div class="form-group"><!-- form-group Starts -->

						<label class="form-control-label font-weight-bold"> اسم المستخدم </label>

						<input type="text" class="form-control" name="u_name" placeholder="أدخل اسم المستخدم الخاص بك" required>

						<small class="form-text text-muted">

							ملاحظة: لا يمكن تغيير أسماء المستخدمين بمجرد تسجيل الحساب.

						</small>

					</div><!-- form-group Ends -->
					<span class="form-text text-danger"><?php echo ucfirst(@$form_errors['u_name']); ?></span>



					<div class="form-group"><!-- form-group Starts -->

						<label class="form-control-label font-weight-bold"> البريد الإلكتروني </label>

						<input type="email" class="form-control" disabled name="email" value="<?php echo $_SESSION['userData']['email'] ?>" placeholder="Enter Your Email" required>

					</div><!-- form-group Ends -->
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
						<input type="submit" name="continue" class="login-button" value="استمر">
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
	"u_name" => "required",
	"accountType" => "required");

	$messages = array("name" => "Full Name Is Required.","u_name" => "User Name Is Required.", "accountType" => "نوع الحساب مطلوب.");

	$val = new Validator($_POST,$rules,$messages);

	if($val->run() == false){

	Flash::add("fb_errors",$val->get_all_errors());

	Flash::add("form_data",$_POST);

	echo "<script>window.open('fb-register','_self')</script>";

	}else{


	$name = $input->post('name');
	
	$u_name = $input->post('u_name');
	$account_type = $input->post('accountType');
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
						

		$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"account_type" => $account_type,"seller_image" => $image,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online',"fb_verification" => 1));
		
		$regsiter_seller_id = $db->lastInsertId();
		
		if($insert_seller){
		
        $_SESSION['seller_user_name'] = $u_name;
				
		$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));

		if($insert_seller_account){
			
			unset($_SESSION['userData']);
			unset($_SESSION['access_token']);
			
	    $get_seller = $db->select("sellers",array("seller_id" => $regsiter_seller_id));		
			$seller_meta = $get_seller->fetch();
			//print_r($seller_meta); die();
			if($seller_meta->account_type == 'buyer'){
			
			echo "
        <script>
          swal({
            type: 'success',
            text: 'Hey $u_name, welcome. ',
            timer: 2000,
            onOpen: function(){
            	swal.showLoading()
            }
          }).then(function(){
          
            // Read more about handling dismissals
            window.open('$site_url/ar/','_self')

          });
        </script>";
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
      }
			
		}
			
		}
						
		}
		
		}

	}
	
	}

?>

<?php require_once("includes/footer.php"); ?>

</body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</html>