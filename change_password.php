<?php

session_start();
require_once("includes/db.php");

if(isset($_SESSION['seller_user_name'])){
	echo "<script> window.open('index.php','_self'); </script>";
}

$code = $input->get('code');
$username = $input->get('username');

$select_seller = $db->select("sellers",array("seller_user_name" => $username));
$count_seller = $select_seller->rowCount();

if($count_seller == 0){
	
	echo "
	<script>
	  	alert('Your Change-Password Link Is Invalid.');
		window.open('index.php','_self');
	</script>";
	
}

$row_seller = $select_seller->fetch();
$seller_id = $row_seller->seller_id;
$seller_user_name = $row_seller->seller_user_name;

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
	<title><?php echo $site_name; ?> - Change Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">

	<!--====== Favicon Icon ======-->
	<?php if(!empty($site_favicon)){ ?>
	  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon"> 
	<?php } ?>
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
    <!-- <link href="styles/custom.css" rel="stylesheet">  -->
    <!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">

	<!-- <link href="styles/categories_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
   
  <script type="text/javascript" src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	
  <style>
  	.input-group-addon {
	    padding: 0.375rem 0.75rem;
	    margin-bottom: 0;
	    font-size: 1rem;
	    font-weight: 400;
	    line-height: 1.5;
	    color: #495057;
	    text-align: center;
	    background-color: #e9ecef;
	    border: 1px solid #ced4da;
	    border-radius: 0.25rem;
  	}
  	.login-button{
  		background-color: #ff0707;
      border: 2px solid #ff0707;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      font-family: 'Hacen Saudi Arabia', sans-serif;
      font-weight: bold;
      height: 60px;
      -webkit-transition: all 0.4s ease-in-out 0s;
      -o-transition: all 0.4s ease-in-out 0s;
      -moz-transition: all 0.4s ease-in-out 0s;
      transition: all 0.4s ease-in-out 0s;
      text-transform: uppercase;
  	}
  	.change-pass #pass_type {
	    margin-top: 7px;
  	}.swal2-popup .swal2-select{display: none;}
  	@media(min-width: 767px){
  		.page-height{
  			position: relative;
  			min-height: 80%;
  		}
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
<div class="container page-height"> <!-- Container starts -->

	<div class="row">

		<div class="col-md-12 mt-5 mb-5">

			<div class="card change-pass">

				<div class="card-header text-center make-white">

					<h3>Dear <?php echo $seller_user_name; ?>, you can change your password here.</h3>

				</div>

				<div class="card-body d-flex justify-content-center">

					<form class="col-md-8" method="post" action="">

						<div class="form-group">

							<label>Enter New Password</label>

							<div class="input-group">

								<span class="input-group-addon">
									
									<i class="fa fa-check tick1 text-success"></i>

									<i class="fa fa-times cross1 text-danger"></i>

								</span>

								   <input type="password" name="new_pass" id="password" class="form-control" required>

								   <span class="input-group-addon">

								   	<div id="meter_wrapper">

								   		<span id="pass_type"></span> <div id="meter"></div>

								   	</div>
								   	
								   </span>

							</div>	

						</div>



						<div class="form-group">

							<label>Confirm New Password</label>

							<div class="input-group">

								<span class="input-group-addon">

									<i class="fa fa-check tick2 text-success"></i>

									<i class="fa fa-times cross2 text-danger"></i>

								</span>

								 <input type="password" name="new_pass_again" id="confirm_password" class="form-control" required>

							</div>	

						</div>
						

						<div class="text-center">

							<button class="login-button btn-lg" type="submit" name="submit">

								<i class="far fa-edit"></i> Change Password
								
							</button>

						</div>

					</form>

				</div>

			</div>

		</div>

	</div>


</div> <!-- Container ends -->
    
<?php

if(isset($_POST['submit'])){
	
    $new_pass = $input->post('new_pass');
    
    $new_pass_again = $input->post('new_pass_again');

	if($new_pass != $new_pass_again){
		
		echo "
		
		<script>
    
        swal({
          type: 'warning',
          html: $('<div>')
            .text('Opps! Your passwords don\'t match. Please try again.'),
          animation: false,
          customClass: 'animated tada'
    	});
      
    </script>";
		
	}else{
	
    $encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);
	
	$update_password = $db->update("sellers",array("seller_pass"=>$encrypted_password),array("seller_id"=>$seller_id));
	
	if($update_password){
		
		echo "
		
		<script>
    
            swal({
              type: 'success',
              text: 'Your password has been updated successfully. Redirecting you to login page...',
              timer: 5000,
          	  onOpen: function(){
			  swal.showLoading()
			  }
              }).then(function(){
              
                // Read more about handling dismissals
                window.open('$site_url/login.php','_self')
             
            });

        </script>";
		
		
	}
		
	}
	
}

?>



<script>

$(document).ready(function(){

$("#password").keyup(function(){

check_pass();

});

});

function check_pass() {

var val = document.getElementById("password").value;

var meter = document.getElementById("meter");

var no=0;

if(val!=""){

// If the password length is less than or equal to 6
if(val.length<=6)no=1;

// If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
if(val.length>6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))no=2;

// If the password length is greater than 6 and contain alphabet,number,special character respectively
if(val.length>6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))no=3;

// If the password length is greater than 6 and must contain alphabets,numbers and special characters
if(val.length>6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))no=4;

if(no==1){

$("#meter").animate({width:'50px'},300);

meter.style.backgroundColor="red";

document.getElementById("pass_type").innerHTML="<span class='move-up-js'>Very Weak </span>";

}

if(no==2){

$("#meter").animate({width:'100px'},300);

meter.style.backgroundColor="#F5BCA9";

document.getElementById("pass_type").innerHTML="<span class='move-up-js'> Weak </span>";


}

if(no==3){

$("#meter").animate({width:'150px'},300);

meter.style.backgroundColor="#FF8000";

document.getElementById("pass_type").innerHTML="<span class='move-up-js'> Good </span>";


}

if(no==4){

$("#meter").animate({width:'200px'},300);

meter.style.backgroundColor="#00FF40";

document.getElementById("pass_type").innerHTML="<span class='move-up-js'>Strong</span>";


}

}

else{

meter.style.backgroundColor="";

document.getElementById("pass_type").innerHTML="";

}

}

</script>



<!-- Password Strength checker code Ends  -->


<!-- Tick and Cross code starts  -->

<script>

$(document).ready(function(){

$('.tick1').hide();

$('.cross1').hide();

$('.tick2').hide();

$('.cross2').hide();

$('#confirm_password').focusout(function(){

var password = $('#password').val();

var confirmPassword = $('#confirm_password').val();

if(password == confirmPassword){

$('.tick1').show();

$('.cross1').hide();

$('.tick2').show();

$('.cross2').hide();

}
else{

$('.tick1').hide();

$('.cross1').show();

$('.tick2').hide();

$('.cross2').show();

}

});

});

</script>
<?php require_once("includes/footer.php"); ?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>

</html>