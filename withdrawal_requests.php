<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login.php','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

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
	<title><?= $site_name; ?> - Revenue Earned</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?= $site_desc; ?>">
	<meta name="keywords" content="<?= $site_keywords; ?>">
	<meta name="author" content="<?= $site_author; ?>">

	<!--====== Favicon Icon ======-->
	<?php if(!empty($site_favicon)){ ?>
	<link rel="shortcut icon" href="<?= $site_url; ?>/images/<?php echo $site_favicon; ?>" type="image/x-icon">
	<?php } ?>
	<!--====== Bootstrap css ======-->
	<link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<!--====== PreLoader css ======-->
	<link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
	<!--====== Animate css ======-->
	<link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
	<!--====== Fontawesome css ======-->
	<link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
	<!--====== Owl carousel css ======-->
	<link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
	<!--====== Nice select css ======-->
	<link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
	<!--====== Range Slider css ======-->
	<link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
	<!--====== Default css ======-->
	<link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
	<!--====== Style css ======-->
	<link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
	<link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet"> 
  <!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">
	<link href="styles/user_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.min.js"></script>

</head>

<body class="all-content">

<?php include("includes/user_header.php"); ?>

<div class="container"><!-- container Starts -->

<div class="row"><!-- row Starts -->

<div class="col-md-12 mt-5"><!-- col-md-12 mt-5 Starts -->

<h1 class="mb-4"> Withdrawal Requests </h1>

<div class="table-responsive box-table"><!-- table-responsive box-table Starts -->

<table class="table table-hover"><!-- table table-hover Starts -->

<thead>

<tr>

<th>No</th>

<th>Ref No</th>

<th>Date</th>

<th>Amount</th>

<th>Method</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$i = 0;

$get = $db->select("payouts",array('seller_id'=>$login_seller_id),"DESC");

while($row = $get->fetch()){

$id = $row->id;
$ref = $row->ref;
$seller_id = $row->seller_id;
$amount = $row->amount;
$method = $row->method;
$date = $row->date;
$status = $row->status;

if($method == "bank_transfer") {
	$m_text = "Bank Transfer";
}else{
	$m_text = ucfirst($method);
}

$i++;
?>

<tr>

<td> <?= $i; ?> </td>

<td class="text-danger"> <?= $ref; ?> </td>

<td> <?= $date; ?> </td>

<td class="text-success"> <?= "$s_currency$amount.00"; ?>  </td>

<td class="text-success"> <?= $m_text; ?>  </td>

<td class="<?php if($status == "pending" OR $status == "declined"){ echo "text-danger"; }else{ echo "text-success"; } ?>"> 

<?= ucfirst($status); ?>

<?php if($method == "moneygram" and $status == "completed" and $paymentGateway == 1){ ?>
<a href="#" data-toggle="modal" data-target="#ref-<?= $id; ?>" class="float-right small">View Ref No</a>
<?php } ?>

<?php if($status == "declined"){ ?>

<a href="#" data-toggle="modal" data-target="#reason-<?= $id; ?>" class="float-right small">View Reason</a>

<?php } ?>

</td>

</tr>

<?php
if($paymentGateway == 1){
	include("plugins/paymentGateway/refModal.php");
}
?>

<div id="reason-<?= $id; ?>" class="modal fade" ><!-- reason modal fade Starts -->

<div class="modal-dialog"><!-- modal-dialog Starts -->

<div class="modal-content"><!-- modal-content Starts -->

<div class="modal-header"><!-- modal-header Starts -->

<h5 class="modal-title"> Reason </h5> 

<button class="close" data-dismiss="modal"> <span> &times; </span> </button>

</div><!-- modal-header Ends -->

<div class="modal-body text-center"><!-- modal-body Starts -->

<p><?= $row->message; ?></p>

</div><!-- modal-body Ends -->

</div><!-- modal-content Ends -->

</div><!-- modal-dialog Ends -->

</div><!-- reason modal fade Ends -->

<?php if(isset($_GET['id']) and $_GET['id'] == $id){ ?>

<script type="text/javascript">
$(document).ready(function(){

	<?php if($status == "completed" and $method == "moneygram" and $paymentGateway == 1){ ?>
		$('#ref-<?= $id; ?>').modal('show');
	<?php }elseif($status == "declined"){ ?>
		$('#reason-<?= $id; ?>').modal('show');
	<?php } ?>

});
</script>

<?php } ?>


<?php } ?>

</tbody>

</table><!-- table table-hover Ends -->

</div><!-- table-responsive box-table Ends -->

</div><!-- col-md-12 mt-5 Ends -->

</div><!-- row Ends -->

</div><!-- container Ends -->

<?php include("includes/footer.php"); ?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
</html>