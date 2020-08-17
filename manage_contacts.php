<?php

session_start();

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){

echo "<script>window.open('login','_self')</script>";

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
<title><?php echo $site_name; ?> - <?php echo $lang["titles"]["manage_contacts"]; ?>.</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="<?php echo $site_desc; ?>">
<meta name="keywords" content="<?php echo $site_keywords; ?>">
<meta name="author" content="<?php echo $site_author; ?>">

<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">

<link href="styles/bootstrap.css" rel="stylesheet">

<link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->

<link href="styles/styles.css" rel="stylesheet">

<link href="styles/user_nav_styles.css" rel="stylesheet">

<link href="font_awesome/css/font-awesome.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.min.js"></script>

	<?php if(!empty($site_favicon)){ ?>
   
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
       
    <?php } ?>

</head>

<body class="is-responsive">

<?php require_once("includes/user_header.php"); ?>

<div class="container-fluid">

<div class="row">

<div class="col-md-12 mt-5">

<h1> <?php echo $lang["titles"]["manage_contacts"]; ?> </h1>

<ul class="nav nav-tabs mt-5 mb-3"><!-- nav nav-tabs mt-5 mb-3 Starts -->

<?php

$count_my_buyers = $db->count("my_buyers",array("seller_id" => $login_seller_id));

?>

<li class="nav-item">

<a href="#my_buyers" data-toggle="tab" class="nav-link make-black 

<?php

if(!isset($_GET['my_buyers']) and !isset($_GET['my_sellers'])){

echo "active";

}

if(isset($_GET['my_buyers'])){

echo "active";

}

?>


">

<?= $lang['tabs']['my_buyers']; ?> <span class="badge badge-success"><?php echo $count_my_buyers; ?></span>

</a>

</li>

<?php

$count_my_sellers = $db->count("my_buyers",array("buyer_id" => $login_seller_id));

?>

<li class="nav-item">

<a href="#my_sellers" data-toggle="tab" class="nav-link make-black

<?php

if(isset($_GET['my_sellers'])){

echo "active";

}

?>

">

<?= $lang['tabs']['my_sellers']; ?> <span class="badge badge-success"><?php echo $count_my_sellers; ?></span>

</a>

</li>

</ul>

<div class="tab-content mt-2">


<div id="my_buyers" class="tab-pane fade 
<?php

if(!isset($_GET['my_buyers']) and !isset($_GET['my_sellers'])){

echo "show active";

}

if(isset($_GET['my_buyers'])){

echo "show active";

}

?>
">

<div class="table-responsive box-table">

<h4 class="mt-3 mb-3 ml-2"> <?= $lang['manage_contacts']['my_buyers']; ?> </h4>

<table class="table table-bordered"><!-- table table-hover Starts -->

<thead>

<tr>

<th>Buyer's Name</th>

<th> Completed Orders </th>

<th> Amount Spent </th>

<th> Last Order Date</th>

<th></th>

</tr>

</thead>

<tbody>

<?php

$sel_my_buyers =  $db->select("my_buyers",array("seller_id" => $login_seller_id));

while($row_my_buyers = $sel_my_buyers->fetch()){

$buyer_id = $row_my_buyers->buyer_id;

$completed_orders = $row_my_buyers->completed_orders;

$amount_spent = $row_my_buyers->amount_spent;

$last_order_date = $row_my_buyers->last_order_date;


$select_buyer = $db->select("sellers",array("seller_id" => $buyer_id));

$row_buyer = $select_buyer->fetch();

$buyer_user_name = $row_buyer->seller_user_name;

$buyer_image = $row_buyer->seller_image;


?>

<tr>

<td>

<?php if(!empty($buyer_image)){ ?>

<img src="user_images/<?php echo $buyer_image; ?>" class="rounded-circle contact-image" >

<?php }else{ ?>

<img src="user_images/empty-image.png" class="rounded-circle contact-image" >

<?php } ?>

<div class="contact-title">

<h6> <?php echo $buyer_user_name; ?> </h6>

<a href="<?php echo $buyer_user_name; ?>" target="blank" class="text-success" > User Profile </a> | 

<a href="buying_history?buyer_id=<?php echo $buyer_id; ?>" class="text-success"> History </a>

</div>

</td>

<td><?php echo $completed_orders; ?></td>

<td><?php echo $s_currency; ?><?php echo $amount_spent; ?></td>

<td>
<?php echo $last_order_date; ?>
</td>

<td class="text-center">

<a href="conversations/message?seller_id=<?php echo $buyer_id; ?>" target="blank" class="btn btn-success">

<i class="fa fa-comment"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php

if($count_my_buyers == 0){

echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> You currently have no buyers in your contact book</h3></center>";
}



?>


</div>

</div>

<div id="my_sellers" class="tab-pane fade
<?php

if(isset($_GET['my_sellers'])){

echo "show active";

}

?>
">


<div class="table-responsive box-table">

<h4 class="mt-3 mb-3 ml-2"> <?= $lang['manage_contacts']['my_sellers']; ?> </h4>

<table class="table table-bordered">

<thead>

<tr>

<th>Seller's Name</th>

<th> Completed Orders </th>

<th> Amount Spent </th>

<th> Last Order Date </th>

<th></th>

</tr>

</thead>

<tbody>

<?php

$sel_my_sellers =  $db->select("my_sellers",array("buyer_id" => $login_seller_id));

while($row_my_sellers = $sel_my_sellers->fetch()){

$seller_id = $row_my_sellers->seller_id;

$completed_orders = $row_my_sellers->completed_orders;

$amount_spent = $row_my_sellers->amount_spent;

$last_order_date = $row_my_sellers->last_order_date;


$select_seller = $db->select("sellers",array("seller_id" => $seller_id));

$row_seller = $select_seller->fetch();

$seller_image = @$row_seller->seller_image;

$seller_user_name = @$row_seller->seller_user_name;


?>

<tr>

<td>

<?php if(!empty($seller_image)){ ?>

<img src="user_images/<?php echo $seller_image; ?>" class="rounded-circle contact-image" >

<?php }else{ ?>

<img src="user_images/empty-image.png" class="rounded-circle contact-image" >

<?php } ?>

<div class="contact-title">

<h6> <?php echo $seller_user_name; ?> </h6>

<a href="<?php echo $seller_user_name; ?>" target="blank" class="text-success" > User Profile </a> | 

<a href="selling_history?seller_id=<?php echo $seller_id; ?>" target="blank" class="text-success" > History </a>

</div>

</td>

<td><?php echo $completed_orders; ?></td>

<td><?php echo $s_currency; ?><?php echo $amount_spent; ?></td>

<td>
<?php echo $last_order_date; ?>
</td>

<td class="text-center">

<a href="conversations/message?seller_id=<?php echo $seller_id; ?>" target="blank" class="btn btn-success">

<i class="fa fa-comment"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php

if($count_my_sellers == 0){

echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> You currently have no sellers in your contact book</h3></center>";
}



?>

</div>

</div>


</div>

</div>

</div>

</div>


<?php require_once("includes/footer.php"); ?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>

</html>