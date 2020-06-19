<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("includes/db.php");
require_once("functions/email.php");
require_once("functions/functions.php");

if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";  
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_timezone = $row_login_seller->seller_timezone;

$order_id = $input->get("order_id");

$get_orders = $db->query("select * from orders where (seller_id=$login_seller_id or buyer_id=$login_seller_id) AND order_id=:o_id",array("o_id"=>$order_id));
$count_orders = $get_orders->rowCount();

if($count_orders == 0){
  echo "<script>window.open('index.php?not_available','_self')</script>";
}

$row_orders = $get_orders->fetch();
$seller_id = $row_orders->seller_id;
$buyer_id = $row_orders->buyer_id;
$order_price = $row_orders->order_price;
$order_number = $row_orders->order_number;
$proposal_id = $row_orders->proposal_id;
$order_status = $row_orders->order_status;
$complete_time = $row_orders->complete_time;

if($videoPlugin == 1){
  require_once("plugins/videoPlugin/order_details.php");  
}else{
  $enableVideo = 0;
  $count_schedule = 0;
}

$get_site_logo_image = $row_general_settings->site_logo_image;
$order_auto_complete = $row_general_settings->order_auto_complete;

if($order_status == "delivered"){
  $currentDate = new DateTime("now");
  if(!empty($complete_time)){
    $endDate = new DateTime($complete_time);
    if($currentDate >= $endDate){
      require_once("orderIncludes/orderComplete.php");
    }
  }
}

if($seller_id == $login_seller_id){
  $receiver_id = $buyer_id;
}else{
  $receiver_id = $seller_id;
}

?>

<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
  <title><?= $site_name; ?> - Order Management For: #<?= $order_number; ?></title>
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
  <!--====== Fontawesome css ===-->
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
  <!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
  <link href="styles/fontawesome-stars.css" rel="stylesheet">
  <!-- <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <link href="styles/proposalStyles.css" rel="stylesheet">
  <link href="styles/user_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
  <script type="text/javascript" src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.barrating.min.js"></script>
  <script type="text/javascript" src="js/jquery.sticky.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
  <?php } ?>

  <script>
  function alert_success(text,url){
    swal({
    type: 'success',
    timer : 3000,
    text: text,
    onOpen: function(){
      swal.showLoading()
    }
    }).then(function(){
      if(url != ""){
      window.open(url,'_self');
    }
    });
  }

</script>

</head>

<body class="is-responsive">
<?php require_once("includes/user_header.php"); ?>
<?php require_once("orderIncludes/orderDetails.php"); ?>
<?php require_once("orderIncludes/orderStatusBar.php"); ?>

<div class="container order-page mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          <ul class="nav nav-tabs mb-3 mt-3">
            <li class="nav-item">
              <a href="#order-activity" data-toggle="tab" class="nav-link active make-black ">Order Activity</a>
            </li>
            <?php if($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested"){ ?>
            <li class="nav-item">
              <a href="#resolution-center" data-toggle="tab" class="nav-link make-black">Resolution Center</a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-12 tab-content mt-2 mb-4">
      <div id="order-activity" class="tab-pane fade show active">
        <div class="row">
          <div class="col-md-10 offset-md-1">

            <?php require_once("orderIncludes/orderDetailsCard.php"); ?>
            <?php require_once("orderIncludes/orderTimeCounterBuyerInstruction.php"); ?>
            <?php 
              if($videoPlugin == 1){
                require_once("plugins/videoPlugin/videoCall/setVideoSessionTime.php");
              }
            ?>
            <div id="order-conversations" class="mt-3">
              <?php require_once("orderIncludes/order_conversations.php"); ?>
            </div>

            <?php require_once("orderIncludes/orderDeliverButton.php"); ?>
            
            <div class="proposal_reviews mt-5">
              <?php 
                if($order_status == "completed"){ 
                 include("orderIncludes/orderReviews.php");
                } 
              ?>
            </div>
          <?php require_once("orderIncludes/insertMessageBox.php"); ?>
          </div>
        </div>
      </div>
      <div id="resolution-center" class="tab-pane fade">
        <?php require_once("orderIncludes/resolutionCenter.php"); ?>
      </div>
    </div>
  </div>
</div>

<?php require_once("orderIncludes/modals/reportModal.php"); ?>
<?php if($videoPlugin == 1){ require_once("plugins/videoPlugin/videoCall/videoCallModal.php"); } ?>
<?php require_once("orderIncludes/modals/deliverOrderRevisionRequestModal.php"); ?>
<?php require_once("orderIncludes/javascript/orderjs.php"); ?>
<?php if($videoPlugin == 1){ ?>
  
<script type="text/javascript" src="plugins/videoPlugin/js/browser.js"></script>
<script 
type="text/javascript" 
id="call-js"
src="plugins/videoPlugin/js/orderVideoCall.js"
data-base-url="<?= $site_url; ?>"
data-order-id="<?= $order_id; ?>"
data-proposal-id="<?= $proposal_id; ?>"
data-login-seller-id="<?= $login_seller_id; ?>"
data-seller-id="<?= $seller_id; ?>"
data-buyer-id="<?= $buyer_id; ?>"
data-start-call="<?= (isset($_GET['start_call']))?1:0; ?>" 
data-warning-message="<?= $warning_message; ?>" 
data-order-call-time="<?= (new DateTime() >= $orderCallTime)?1:0; ?>" 
data-video-session-time="<?= $videoSessionTime; ?>" 
></script>

<?php } ?>

<?php require_once("includes/footer.php"); ?>

</body>
</html>