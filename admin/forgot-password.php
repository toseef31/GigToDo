<?php
session_start();
include("includes/db.php");
require_once("../functions/email.php");

if(isset($_SESSION['admin_email'])){
echo "<script>window.open('index?dashboard','_self');</script>";
}
?>
<!doctype html>
<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TF82RTH');</script>
	<!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name; ?> Admin - Forgot Password</title>
    <meta name="description" content="<?php echo $site_name; ?> admin, Reset your password.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/scss/style.css">
	<link rel="stylesheet" href="assets/css/sweat_alert.css">
    <script type="text/javascript" src="assets/js/sweat_alert.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body class="bg-dark">
<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo pb-4">
                <a href="<?php echo $site_url; ?>/admin/login.php">
                    <h2 class="text-white"> <?php echo $site_name; ?> <span class="badge badge-success p-2 font-weight-bold">ADMIN</span></h2>
                </a>
			<p class="lead text-white" style=" margin-top:15px; margin-bottom:-18px;">
				Enter your email to receive a password reset link.
				</p>
            </div>
            <div class="login-form">
                <form method="post">
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="forgot_email" class="form-control" placeholder="Email">
                    </div>
                    <button type="submit" name="submit" class="btn btn-success btn-flat m-b-15">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/main.js"></script>
<?php
if(isset($_POST['submit'])){
	$forgot_email = $input->post('forgot_email');
	$select_admin = $db->select("admins",array("admin_email" => $forgot_email));
	$count_admin_email = $select_admin->rowCount();
	if($count_admin_email == 0){
		echo "<script>
	    swal({
	    type: 'warning',
	    text: 'Hmm! We don\'t seem to have this email in our system.',
	    })
	  </script>";
	}else{
		if(send_admin_forgot_password()){
			echo "
			<script>
			swal({
			type: 'success',
			text: 'An email has been sent to your email address with instructions on how to change your password.',
			});
			</script>";
		}else{
			echo "
			<script>
			swal({
			type: 'warning',
			text: 'sorry,email could not be sent.',
			});
			</script>";
		}
	}
}
?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
</html>
