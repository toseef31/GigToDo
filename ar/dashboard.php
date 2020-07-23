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
  $login_seller_level = $row_login_seller->seller_level;
  $login_seller_rating = $row_login_seller->seller_rating;
  $login_seller_recent_delivery = $row_login_seller->seller_recent_delivery;
  $login_seller_country = $row_login_seller->seller_country;
  $login_seller_register_date = $row_login_seller->seller_register_date;
  $login_seller_image = $row_login_seller->seller_image;
  $login_seller_payouts = $row_login_seller->seller_payouts;
  $login_seller_view = $row_login_seller->profile_views;
  $login_seller_cover = $row_login_seller->seller_cover_image;
  $login_seller_image = $row_login_seller->seller_image;
  $login_seller_country = $row_login_seller->seller_country;
  $login_seller_state = $row_login_seller->seller_state;
  $login_seller_language = $row_login_seller->seller_language;
  $login_seller_about = $row_login_seller->seller_about;
  if(empty($login_seller_country)){
    $login_seller_country = "&nbsp;";
  }

  $request_cat_ids = array();
  // $select_proposals = $db->query("select DISTINCT proposal_child_id from proposals where proposal_seller_id='$login_seller_id' and proposal_status='active'");
  $select_proposals = $db->query("select DISTINCT proposal_cat_id from proposals where proposal_seller_id='$login_seller_id' and proposal_status='active'");
  while($row_proposals = $select_proposals->fetch()){
   $proposal_cat_id = $row_proposals->proposal_cat_id;
   array_push($request_cat_ids, $proposal_cat_id);
  }
  
  $where_cat_id = array();
  foreach($request_cat_ids as $cat_id){
   $where_cat_id[] = "cat_id=" . $cat_id; 
  }
  
  if(count($where_cat_id) > 0){
   $requests_query = " and (" . implode(" or ", $where_cat_id) . ")";
   $child_cats_query = "(" . implode(" or ", $where_cat_id) . ")";
  }
  $relevant_requests = $row_general_settings->relevant_requests;


  $select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
  $row_seller_accounts = $select_seller_accounts->fetch();
  $current_balance = $row_seller_accounts->current_balance;
  $month_earnings = $row_seller_accounts->month_earnings;

  if(isset($_GET['n_id'])){
    $notification_id = $input->get('n_id');
    $get_notification = $db->select("notifications",array("notification_id" => $notification_id,"receiver_id" => $login_seller_id));
    if($get_notification->rowCount() == 0){echo "<script>window.open('dashboard','_self')</script>";}else{
    $row_notification = $get_notification->fetch();
    $order_id = $row_notification->order_id;
    $reason = $row_notification->reason;
    $update_notification = $db->update("notifications",array("status" => 'read'),array("notification_id" => $notification_id));
    if($update_notification){
      if($reason == "modification" or $reason == "approved" or $reason == "declined"){
        echo "<script>window.open('proposals/view_proposals','_self');</script>";
      }else if($reason == "offer"){
      echo "<script>window.open('$site_url/requests/view_offers?request_id=$order_id','_self')</script>";
      }elseif($reason == "approved_request" or $reason == "unapproved_request"){
       echo "<script>window.open('requests/manage_requests','_self');</script>";
      }elseif($reason == "withdrawal_approved" or $reason == "withdrawal_declined"){
       echo "<script>window.open('withdrawal_requests?id=$order_id','_self');</script>";
      }else{
        echo "<script>window.open('order_details?order_id=$order_id','_self');</script>";
      }
    }
    }
  }
  
  if(isset($_GET['delete_notification'])){
  $delete_id = $input->get('delete_notification');
  $delete_notification = $db->delete("notifications",array('notification_id' => $delete_id,"receiver_id" => $login_seller_id)); 
  if($delete_notification->rowCount() == 1){
  echo "<script>alert('One notification has been deleted.')</script>";
  echo "<script>window.open('dashboard','_self')</script>";
  }else{ echo "<script>window.open('dashboard','_self')</script>"; }
  }

  $select = $db->select("seller_payment_settings",["level_id"=>$login_seller_level]);
  $row = $select->fetch();
  $payout_day = $row->payout_day;
  $payout_time = $row->payout_time;
  $payout_anyday = $row->payout_anyday;
  $payout_date = date("F $payout_day, Y")." $payout_time";
  $payout_date = new DateTime($payout_date);

  $p_date="";
  if(empty($payout_anyday) and $login_seller_payouts == 0 and date("d") <= $payout_day){
    $p_date = $payout_date->format("F d, Y H:i A");
  }else if($login_seller_payouts > 1){
    $interval = new DateInterval('P1M');
    $payout_date->add($interval);
    $p_date = $payout_date->format("F d, Y H:i A");
  }
  $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
  $count_proposals = $select_proposals->rowCount();
  if(!$count_proposals == 0){
    $total_view = array();
    while($row_proposals = $select_proposals->fetch()){
      $proposal_views = $row_proposals->proposal_views;
      array_push($total_view,$proposal_views);
    }
    $total_gigs_view = array_sum($total_view);

  }else{
   $total_gigs_view = "0"; 
  }
  // $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
  // $count_gigs = $select_proposals->rowCount();
  // if(!$count_gigs == 0){
  //   $total_price = array();
  //   while($row_proposals = $select_proposals->fetch()){
  //     $proposal_prices = $row_proposals->proposal_price;
  //     array_push($total_price,$proposal_prices);
  //   }
  //   $total_price_gig= array_sum($total_price);
  //   @$average = $total_price_gig/count($total_price);
  //   $average_price = substr($average ,0,1);
  // }else{
  //   $average = "0";
  //   $average_price = "0";
  // }


  $select_proposals = $db->select("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
  $count_gigs = $select_proposals->rowCount();
  // print_r($count_gigs);
  if(!$count_gigs == 0){
    $total_price = array();
    while($row_proposals = $select_proposals->fetch()){
      // print_r($row_proposals);
      $proposal_id = $row_proposals->proposal_id;
      $select_proposals_packg = $db->select("proposal_packages",array("proposal_id"=>$proposal_id));
      while($row_proposals_packg = $select_proposals_packg->fetch()){
        $package_dec = $row_proposals_packg->description;
        // print_r($package_dec);
        if ($package_dec != '') {
          $package_price = $row_proposals_packg->price;
          // print_r($package_price);
          array_push($total_price,$package_price);
        }
      }
    }
    $total_price_gig= array_sum($total_price);
    @$average = $total_price_gig/$count_gigs;
    $average_price = substr($average ,0,1);
  }else{
    $average = "0";
    $average_price = "0";
  }
?>
<?php

  $count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_status" => 'completed'));
   
  $in_progress = $db->count("orders",array("seller_id" => $login_seller_id, "order_active" => 'yes'));
  $delivered = $db->count("orders",array("seller_id"=>$login_seller_id,"order_status"=>'delivered'));
  $canceled_orders = $db->count("orders",array("seller_id"=>$login_seller_id,"order_status"=>'cancelled'));

  $dataPoints = array(
    array("label"=>"Completed", "symbol" => "Complete","y"=> $count_orders),
    array("label"=>"In Progress", "symbol" => "Progress","y"=> $in_progress),
    array("label"=>"Delivered", "symbol" => "Deliver","y"=> $delivered),
    array("label"=>"Cancelled", "symbol" => "Cancel","y"=> $canceled_orders),
   
  )
 
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?= $site_name; ?> - <?= $lang["titles"]["dashboard"]; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?= $site_desc; ?>">
  <meta name="keywords" content="<?= $site_keywords; ?>">
  <meta name="author" content="<?= $site_author; ?>">

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
  <link href="assets/css/style2.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet"> -->
  <!-- Custom css code from modified in admin panel --->
  <link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet">
  <!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet">
  <link href="styles/user_nav_styles.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet"> -->
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/chartjs.min.js"></script>
  <script type="text/javascript" src="assets/js/chart.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
   <script>
   window.onload = function() {
    
   var chart = new CanvasJS.Chart("chartContainer", {
    theme: "light2",
    animationEnabled: true,
    title: {
      // text: "Average Composition of Magma"
    },
    data: [{
      type: "doughnut",
      indexLabel: "{symbol} - {y}",
      yValueFormatString: "#,##0\"\"",
      showInLegend: true,
      legendText: "{label} : {y}",
      dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
   });
   chart.render();
    
   }
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
  <style>
    .canvasjs-chart-credit{
      display: none;
    }
    .float-right.delete{
      position: absolute;
      left: 10px;
      top: 10px;
    }
    .messge-noti-box{
      max-height: 470px;
      overflow: auto;
    }
    /* width */
    .messge-noti-box::-webkit-scrollbar {
      width: 4px;
    }
    /* Track */
    .messge-noti-box::-webkit-scrollbar-track {
      background: rgb(255, 255, 255);
    }
    .messge-noti-box::-webkit-scrollbar-thumb {
      background: rgb(255, 7, 7);
    }
    /* Handle on hover */
    .messge-noti-box::-webkit-scrollbar-thumb:hover {
      background: rgb(255, 7, 7);
    }
    .attachment a {
        color: #ff0707;
    }
  </style>
</head>
<body class="all-content">
  <!-- Preloader Start -->
    <div class="proloader">
        <div class="loader">
            <img src="assets/img/emongez_cube.png" />
        </div>
    </div>
    <!-- Preloader End -->
  <?php require_once("includes/user_dashboard_header.php") ?>

  <!-- Dashborad-area-start -->
  <div class="dashborad-day mt-35 mb-15">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="dashborad-box">
            <div class="day-item">
              <p>اليوم <span>0 <?php if ($to == 'EGP'){ echo $to;}elseif($to == 'USD'){ echo $to;}else{ echo $s_currency; } ?></span></p>
            </div>
            <div class="day-item">
              <p>امبارح <span>0 <?php if ($to == 'EGP'){ echo $to;}elseif($to == 'USD'){ echo $to;}else{ echo $s_currency; } ?></span></p>
            </div>
            <div class="day-item">
              <p>آخر 7 آيام <span>0 <?php if ($to == 'EGP'){ echo $to;}elseif($to == 'USD'){ echo $to;}else{ echo $s_currency; } ?></span></p>
            </div>
            <div class="day-item">
              <p>آخر 30 يوم <span><?php if ($to == 'EGP'){ echo $month_earnings.' '; echo $to;}elseif($to == 'USD'){ echo round($cur_amount * $month_earnings,2).' '; echo $to;}else{ echo $month_earnings.' '; echo $s_currency; } ?></span></p>
            </div>
            <div class="day-item">
              <p>آخر 365 يوم <span>0 <?php if ($to == 'EGP'){ echo $to;}elseif($to == 'USD'){ echo $to;}else{ echo $s_currency; } ?></span></p>
            </div>
            <div class="day-item">
              <p>كل الأوقات <span><?php if ($to == 'EGP'){ echo $current_balance.' '; echo $to;}elseif($to == 'USD'){ echo round($cur_amount * $current_balance,2).' '; echo $to;}else{ echo $current_balance.' '; echo $s_currency; } ?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="profile-chart-area mb-30">
    <div class="container">
      <div class="row">
        
        <div class="col-12">
          
        </div>
        <div class="col-12 col-md-4 d-flex flex-row">
          <div class="userprofile d-flex flex-column">
            <div class="userprofile-header d-flex flex-row align-items-center">
              <div class="userprofile-logo">
                <?php if(!empty($login_seller_image)){ ?>
                <img src="<?= $site_url; ?>/user_images/<?= $login_seller_image; ?>" alt="">
                <?php }else{ ?>
                <img src="<?= $site_url; ?>/assets/img/user1.png"  class="img-fluid rounded-circle mb-3">
                <?php } ?>
              </div>
              <div class="userprofile-text d-flex flex-column">
                <span>مرحبا بك مرة اخري</span>
                <span class="username"><?= ucfirst(strtolower($login_seller_user_name)); ?></span>
              </div>
            </div>
            <div class="userprofile-progress d-flex flex-column">
              <span>أنشئ حسابك</span>
              <div class="userprofile-progressbar">
                <?php if ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language == '0') { ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language == '0') { ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language == '0') { ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 35%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">35%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                <?php } elseif ($login_seller_cover == '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image == '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country == '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language == '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about == '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state == '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                <?php } elseif ($login_seller_cover != '' && $login_seller_state != '' && $login_seller_country != '' && $login_seller_image != '' && $login_seller_about != '' && $login_seller_language != '0') {  ?>
                  <div class="userprofile-progressbar-inner" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                <?php } ?>
                <!-- <div class="progress-bar" role="progressbar" style="width: 19%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div> -->
              </div>
              <!-- <div class="userprofile-progressbar">
                <div class="userprofile-progressbar-inner" style="max-width: 19%;">19%</div>
              </div> -->
            </div>
            <div class="userprofile-footer d-flex flex-column">
              <a class="userprofile-button d-flex flex-row align-items-center justify-content-center" href="<?= $site_url; ?>/ar/proposals/create_proposal">أضف خدمة</a>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-md-8">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg1.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/user.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4><?= $login_seller_view; ?> <span>مشاهدة للملف الشخصي</span></h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg2.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/clip.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4><?= $total_gigs_view; ?> <span>مشاهدة للخدمة</span></h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg3.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/filter.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4>0 <span>مشاهدة للمحادثات </span></h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg4.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/cal.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4><?php if ($to == 'EGP'){ echo round($average,2);}elseif($to == 'USD'){ echo round($cur_amount * $average,2);}else{ echo round($average,2); } ?> <span>متوسط تكلفة الخدمة </span></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="container-fluid list-page">
    <div class="row">
      <div class="container">
        <div class="row align-items-start">
          <div class="col-12 col-sm-6">
            <h1 class="list-page-title">
              طلب المشتري
            </h1>
          </div>
          <div class="col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-end">
            <a class="button button-red" href="../proposals/create_proposal">
              انشر خدمة
            </a>
          </div>
        </div>
        <!-- Row -->
        <div class="list-page-filter">
          <div class="row flex-md-row-reverse">
            <div class="col-12 col-md-6">
              <select id="sub-category" class="form-control float-left sort-by">
                <option value="all"> All Categories </option>
                <?php
                  if(count($where_cat_id) > 0){
                  $get_c_cats = $db->query("select * from categories where ".$child_cats_query);
                  while($row_c_cats = @$get_c_cats->fetch()){
                  $cat_id = $row_c_cats->cat_id;
                  $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
                  $row_meta = $get_meta->fetch();
                  $cat_title = $row_meta->cat_title;
                  $arabic_title = $row_meta->arabic_title;
                  echo "<option value='$cat_id'> $arabic_title </option>";
                  }
                  }
                  ?>
              </select>
              <!-- <ul class="pagination">
                <li class="pagination-item">
                  <a class="pagination-link" href="javascript:void(0);">
                    <i class="fal fa-angle-right"></i>
                  </a>
                </li>
                <li class="pagination-item">
                  <a class="pagination-link" href="javascript:void(0);">1</a>
                </li>
                <li class="pagination-item">
                  <div class="pagination-status d-flex flex-row align-items-center">
                    <span>Of</span>
                    <span>1</span>
                  </div>
                </li>
                <li class="pagination-item">
                  <a class="pagination-link" href="javascript:void(0);">
                    <i class="fal fa-angle-left"></i>
                  </a>
                </li>
              </ul> -->
            </div>
            <div class="col-12 col-md-6">
              <nav class="list-page-nav">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link limerick active" id="active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="true">نشيط <span class="badge">
                    <?php 
                      $i_requests = 0;
                      $i_send_offers = 0;
                      if($relevant_requests == "no"){ $requests_query = ""; }
                      if(!empty($requests_query) or $relevant_requests == "no"){
                      $get_requests = $db->query("select * from buyer_requests where request_status='active'" . $requests_query . " AND NOT seller_id='$login_seller_id' order by request_id DESC");
                      while($row_requets = $get_requests->fetch()){
                      $request_id = $row_requets->request_id;
                      $count_offers = $db->count("send_offers",array("request_id" => $request_id,"sender_id" => $login_seller_id));
                      if($count_offers == 1){
                      $i_send_offers++;
                      }
                      $i_requests++;
                      }
                      }
                    ?>
                    <?php echo $i_requests-$i_send_offers; ?>
                  </span></a>
                  <?php $count_offers = $db->count("send_offers",array("sender_id" => $login_seller_id)); ?>
                  <a class="nav-item nav-link selective-yellow" id="paused-tab" data-toggle="tab" href="#nav-paused" role="tab" aria-controls="nav-paused" aria-selected="false">ابعت عرض <span class="badge"><?php echo $count_offers; ?></span></a>
                </div>
              </nav>
            </div>
          </div>
          <!-- Row -->
        </div>
        <div class="row">
          <div class="col-12">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-active" role="tabpanel" aria-labelledby="active-tab">
                <table class="table managerequest-table limerick" cellpadding="0" cellspacing="0" border="0">
                  <thead>
                    <tr role="row">
                      <th role="column">
                        المشترى
                      </th>
                      <th role="column">
                        الطلب
                      </th>
                      <th role="column">العروض</th>
                      <th role="column">
                        التسليم
                      </th>
                      <th role="column">
                        الميزانية
                      </th>
                    </tr>
                  </thead>
                  <tbody id="load-data">
                    <?php 
                      if(!empty($requests_query) or $relevant_requests == "no"){
                      $select_requests = $db->query("select * from buyer_requests where request_status='active'".$requests_query." AND NOT seller_id='$login_seller_id' order by 1 DESC");
                      $count_requests = $select_requests->rowCount();
                      while($row_requests = $select_requests->fetch()){
                      $request_id = $row_requests->request_id;
                      $seller_id = $row_requests->seller_id;
                      $cat_id = $row_requests->cat_id;
                      $child_id = $row_requests->child_id;
                      $request_title = $row_requests->request_title;
                      $request_description = $row_requests->request_description;
                      $delivery_time = $row_requests->delivery_time;
                      $request_budget = $row_requests->request_budget;
                      $request_file = $row_requests->request_file;
                      $request_date = $row_requests->request_date;
                      $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
                      $row_meta = $get_meta->fetch();
                      $cat_title = $row_meta->cat_title;
                      $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                      $row_meta = $get_meta->fetch();
                      $child_title = $row_meta->child_title;
                      $select_request_seller = $db->select("sellers",array("seller_id" => $seller_id));
                      $row_request_seller = $select_request_seller->fetch();
                      $request_seller_user_name = $row_request_seller->seller_user_name;
                      $request_seller_image = $row_request_seller->seller_image;
                      $count_send_offers = $db->count("send_offers",array("request_id" => $request_id));
                      $count_offers = $db->count("send_offers",array("request_id" => $request_id,"sender_id" => $login_seller_id));
                      if($count_offers == 0){
                      ?>
                    <tr role="row">
                      <td data-label="المشترى">
                        <div class="d-flex flex-column align-items-center">
                          <div class="buyer-image">
                            <?php if(!empty($request_seller_image)){ ?>
                            <img alt class="img-fluid d-block request-img rounded-circle" src="<?= $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" />
                            <?php }else{ ?>
                            <img alt class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
                            <?php } ?>
                          </div>
                          <div class="buyer-id"><?php echo $request_seller_user_name; ?></div>
                          <span><?php echo $request_date; ?></span>
                        </div>
                      </td>
                      <td data-label="الطلب">
                        <p><?php echo $request_description; ?></p>
                        <div class="attachment d-flex flex-row align-items-center">
                          <?php if(!empty($request_file)){ ?>
                          <a href="<?= $site_url; ?>/requests/request_files/<?php echo $request_file; ?>" download>
                          <span><i class="fal fa-paperclip"></i></span> <span><?php echo $request_file; ?></span>
                          </a>
                          <?php } ?>
                        </div>
                        <div class="tags">
                          <a href="javascript:void(0);" class="taga-item"><?php echo $cat_title; ?></a>
                          <a href="javascript:void(0);" class="taga-item"><?php echo $child_title; ?></a>
                        </div>
                      </td>
                      <td data-label="العروض">
                        <div class="offers-button">
                          <?php echo $count_send_offers; ?> عروض
                        </div>
                      </td>
                      <td data-label="التسليم">
                        <?php echo $delivery_time; ?>
                      </td>
                      <td data-label="الميزانية">
                        <div class="d-flex flex-column">
                          <?php if(!empty($request_budget)){ ?> 
                          <span><?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget,2);}else{  echo $s_currency.' '; echo $request_budget; } ?></span>
                          <?php }else{ ?> ----- <?php } ?>
                          <?php if($login_seller_offers == "0"){ ?>
                            <a class="send-offer send_button_<?php echo $request_id; ?>" data-toggle="modal" data-target="#quota-finish">إرسال العرض   </a>
                          <!-- <button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>" data-toggle="modal" data-target="#quota-finish">Send Offer</button> -->
                          <?php }else{ ?>
                            <a class="send-offer send_button_<?php echo $request_id; ?>">إرسال العرض   </a>
                          <!-- <button class="btn btn-success btn-sm mt-4 send_button_<?php echo $request_id; ?>">Send Offer</button> -->
                          <?php } ?>
                        </div>
                      </td>
                      <script>
                        $(".remove_request_<?php echo $request_id; ?>").click(function(event){
                        event.preventDefault();
                        $("#request_tr_<?php echo $request_id; ?>").fadeOut().remove();
                        });
                        <?php if($login_seller_offers == "0"){ ?>
                        <?php }else{ ?>
                        $(".send_button_<?php echo $request_id; ?>").click(function(){
                        request_id = "<?php echo $request_id; ?>";
                        $.ajax({
                        method: "POST",
                        url: "requests/send_offer_modal",
                        data: {request_id: request_id}
                        })
                        .done(function(data){
                        $(".append-modal").html(data);
                        });
                        });
                        <?php } ?>
                      </script>
                    </tr>
                    <?php } } } ?>
                  </tbody>
                </table>
                <?php
                  if(empty($count_requests)){
                  echo"<center><h3 class='pb-4 pt-4'><i class='fa fa-frown-o'></i> لا توجد طلبات تطابق أي من مقترحاتك / خدماتك حتى الآن!</h3></center>";
                  }
                ?>
              </div>
              <div class="tab-pane fade" id="nav-paused" role="tabpanel" aria-labelledby="paused-tab">
                <table class="table managerequest-table selective-yellow" cellpadding="0" cellspacing="0" border="0">
                  <thead>
                    <tr role="row">
                      <th role="column" style="display: none;">
                        تاجر
                      </th>
                      <th role="column">عرض</th>
                      <!-- <th role="column">العروض</th> -->
                      <th role="column">
                        التسليم
                      </th>
                      <th role="column">
                        الميزانية
                      </th>
                      <th role="column">
                        الطلب
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $select_offers = $db->select("send_offers",array("sender_id"=>$login_seller_id),"DESC");
                      $count_offers = $select_offers->rowCount();
                      while($row_offers = $select_offers->fetch()){
                      $request_id = $row_offers->request_id;
                      $proposal_id = $row_offers->proposal_id;
                      $description = $row_offers->description;
                      $delivery_time = $row_offers->delivery_time;
                      $amount = $row_offers->amount;
                      $select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
                      $row_proposals = $select_proposals->fetch();
                      $proposal_title = @$row_proposals->proposal_title;
                      $get_requests = $db->select("buyer_requests",array("request_id"=>$request_id));
                      $row_requests = $get_requests->fetch();
                      $request_id = $row_requests->request_id;
                      $seller_id = $row_requests->seller_id;
                      $cat_id = $row_requests->cat_id;
                      $child_id = $row_requests->child_id;
                      $request_title = $row_requests->request_title;
                      $request_description = $row_requests->request_description;
                      $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
                      $row_meta = $get_meta->fetch();
                      $cat_title = $row_meta->cat_title;
                      $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                      $row_meta = $get_meta->fetch();
                      $child_title = $row_meta->child_title;
                      $select_request_seller = $db->select("sellers",array("seller_id" => $seller_id));
                      $row_request_seller = $select_request_seller->fetch();
                      $request_seller_user_name = $row_request_seller->seller_user_name;
                      $request_seller_image = $row_request_seller->seller_image;
                    ?>
                    <tr role="row">
                      <td data-label="المشترى  " style="display: none;">
                        <div class="d-flex flex-column align-items-center">
                          <div class="buyer-image">
                            <?php if(!empty($login_seller_image)){ ?>
                            <img alt class="img-fluid d-block request-img rounded-circle" src="<?= $site_url; ?>/user_images/<?php echo $login_seller_image; ?>" />
                            <?php }else{ ?>
                            <img alt class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
                            <?php } ?>
                          </div>
                          <div class="buyer-id"><?php echo $login_seller_user_name; ?></div>
                          <!-- <span><?php echo $request_date; ?></span> -->
                        </div>
                      </td>
                      <td data-label="الطلب">
                        <p><?php echo $description; ?></p>
                        
                      </td>
                      <!-- <td data-label="العروض">
                        <div class="offers-button">
                          4 عروض
                        </div>
                      </td> -->
                      <td data-label="التسليم"><?php echo $delivery_time; ?></td>
                      <td data-label="الميزانية">
                        <div class="d-flex flex-column">
                          <span><?php if ($to == 'EGP'){ echo $to.' '; echo $amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $amount,2);}else{  echo $s_currency.' '; echo $amount; } ?></span>
                          
                        </div>
                      </td>
                      <td data-label="لمشترى ">
                        <div class="d-flex flex-column align-items-center">
                          <div class="buyer-image">
                            <?php if(!empty($request_seller_image)){ ?>
                            <img alt class="img-fluid d-block request-img rounded-circle" src="<?= $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" />
                            <?php }else{ ?>
                            <img alt class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
                            <?php } ?>
                          </div>
                          <strong> <?php echo $request_seller_user_name; ?></strong>
                        </div>
                          <p>
                            <?php echo $request_description; ?>
                          </p>
                          <div class="attachment d-flex flex-row">
                          <?php if(!empty($request_file)){ ?>
                          <a href="<?= $site_url; ?>/requests/request_files/<?php echo $request_file; ?>" download>
                          <span><i class="fal fa-paperclip"></i></span> <span><?php echo $request_file; ?></span>
                          </a>
                          <?php } ?>
                          <!-- <span><i class="fal fa-paperclip"></i></span>
                          <span>attatchme...jpg</span>
                          <span>(1048KB)</span> -->
                        </div>
                        <div class="tags">
                          <a href="javascript:void(0);" class="taga-item"><?php echo $cat_title; ?></a>
                          <a href="javascript:void(0);" class="taga-item"><?php echo $child_title; ?></a>
                        </div>
                        
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <?php
                  if($count_offers == 0){
                  echo"<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> لم ترسل أي عروض حتى الآن!</h3></center>";
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex flex-row justify-content-end">
            <a class="offer-left" href="javascript:void(0);">
              <span><i class="fas fa-exclamation-circle"></i></span>
              <span>
                <?php echo $login_seller_offers; ?> عروض موجودة النهاردة
              </span>
            </a>
          </div>
        </div>
        <!-- Row -->
      </div>
    </div>
    <!-- Row -->
  </section>
  <div class="append-modal"></div>
  <div id="quota-finish" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h5"><i class="fa fa-frown-o fa-move-up"></i> Request Quota Reached</h5>
          <button class="close" data-dismiss="modal"> &times; </button>
        </div>
        <div class="modal-body">
          <center>
            <h5>You can only send a max of 10 offers per day. Today you've maxed out. Try again tomorrow. </h5>
          </center>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashborad-area-END -->

<!-- <div class="container mt-4 mb-5" style="max-width: 1200px !important;">
<div class="row">
  <div class="col-md-4 <?=($lang_dir == "right" ? 'order-2 order-sm-1':'')?>">
    <?php require_once("includes/dashboard_sidebar.php"); ?>
  </div>
  <div class="col-md-8">
   <div class="card rounded-0">
      <div class="card-body p-0">
        <div class="row p-2">
          <div class="col-lg-3 col-sm-12 text-center pt-2">
            <?php if(!empty($login_seller_image)){ ?>
            <img src="user_images/<?= $login_seller_image; ?>" class="rounded-circle img-thumbnail" width="130">
            <?php }else{ ?>
            <img src="user_images/empty-image.png" class="rounded-circle img-thumbnail" width="130">
            <?php } ?>
          </div>
          <div class="col-lg-9 col-sm-12 text-lg-left text-center <?=($lang_dir == "right" ? 'order-1 order-sm-2':'')?>">
            <div class="row mb-2">
              <div class="col-6 col-lg-4 mt-3">
                <h6><i class="fa fa-globe pr-1"></i> Country</h6>
                <h6><i class="fa fa-star pr-1"></i> Positive Ratings</h6>
              </div>
              <div class="col-6 col-lg-8 mt-3">
                <h6 class="text-muted"><?= $login_seller_country; ?></h6>
                <h6 class="text-muted"> <?= $login_seller_rating; ?>%</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-6 col-sm-4">
                <h6><i class="fa fa-truck pr-1"></i> Recent Delivery</h6>
                <h6><i class="fa fa-clock-o pr-1"></i> Member Since</h6>
              </div>
              <div class="col-6 col-lg-8">
                <h6 class="text-muted"><?= $login_seller_recent_delivery; ?></h6>
                <h6 class="text-muted"><?= $login_seller_register_date; ?></h6>
              </div>
            </div>
            <?php if(empty($payout_anyday)){ ?>
            <div class="row mt-2">
              <div class="col-6 col-sm-4">
                <h6><i class="fa fa-money pr-1"></i> Payout Date</h6>
              </div>
              <div class="col-6 col-lg-8">
                <h6 class="text-muted"><?= $p_date; ?></h6>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <hr>
        <div class="row pl-3 pr-3 pb-2 pt-2 mt-4">
          <div class="col-md-4 text-center border-box">
            <?php
              $count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_status" => 'completed'));
              ?>
              <img width="" src="images/comp/completed.png" alt="completed">
            <h5 class="text-muted pt-2">Orders Completed</h5>
            <h3 class="text-success"><?= $count_orders; ?></h3>
          </div>
          <div class="col-md-4 text-center border-box">
            <?php $count_orders = $db->count("orders",array("seller_id"=>$login_seller_id,"order_status"=>'delivered')); ?>
            <img width="" src="images/comp/box.png" alt="box">
            <h5 class="text-muted pt-2">Delivered Orders</h5>
            <h3 class="text-success"><?= $count_orders; ?></h3>
          </div>
          <div class="col-md-4 text-center border-box">
            <?php $count_orders = $db->count("orders",array("seller_id"=>$login_seller_id,"order_status"=>'cancelled'));?>
            <img width="" src="images/comp/cancellation.png" alt="cancellation">
            <h5 class="text-muted pt-2">Orders Cancelled</h5>
            <h3 class="text-success"><?= $count_orders; ?></h3>
          </div>
        </div>
        <hr>
        <div class="row pl-3 pr-3 pb-2 pt-2">
          <div class="col-md-3 text-center border-box">
            <?php
              $count_orders = $db->count("orders",array("seller_id" => $login_seller_id, "order_active" => 'yes'));
            ?>
            <img width="" src="images/comp/debt.png" alt="debt">
            <h5 class="text-muted pt-2"> Sales In Queue</h5>
            <h3 class="text-success"><?= $count_orders; ?></h3>
          </div>
          <div class="col-md-3 text-center border-box">
            <?php $count_orders = $db->count("orders",array("buyer_id" => $login_seller_id, "order_active" => 'yes')); ?>
              <img width="" src="images/comp/shopping-bags.png" alt="shopping-bags">
            <h5 class="text-muted pt-2"> Open Purchases</h5>
            <h3 class="text-success"><?= $count_orders; ?> </h3>
          </div>
          <div class="col-md-3 text-center border-box">
            <img width="" src="images/comp/accounting.png" alt="accounting">
            <h5 class="text-muted pt-2"> Balance</h5>
            <h3 class="text-success"><?= $s_currency; ?><?= $current_balance; ?></h3>
          </div>
          <div class="col-md-3 text-center border-box">
            <img width="" src="images/comp/financial.png" alt="financial">
            <h5 class="text-muted pt-2"> Earnings(Month)</h5>
            <h3 class="text-success"><?= $s_currency; ?><?= $month_earnings; ?></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="card rounded-0 mt-3 bottom-tabs-dash">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <?php $count_notifications = $db->count("notifications",array("receiver_id" => $login_seller_id));?>
            <a href="#notifications" data-toggle="tab" class="nav-link make-black active">
            <?= $lang['notifications']; ?> <span class="badge badge-success"><?= $count_notifications; ?> </span>
            </a>
          </li>
          <li class="nav-item">
            <?php
              $select_all_inbox_sellers = $db->query("select * from inbox_sellers where (receiver_id='$login_seller_id' or sender_id='$login_seller_id') AND NOT message_status='empty'");
              $count_all_inbox_sellers = $select_all_inbox_sellers->rowCount();
            ?>
            <a href="#inbox" data-toggle="tab" class="nav-link make-black">
            <?= $lang['messages']; ?> <span class="badge badge-success"><?= $count_all_inbox_sellers; ?></span>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body p-0">
        <div class="tab-content dashboard">
          <div id="notifications" class="tab-pane fade show active mt-3">
            <?php
              if($count_notifications == 0){
                echo "<h5 class='text-center mb-3'> No Notifications Are Available </h5>";
              }
              
              $get_notifications = $db->query("select * from notifications where receiver_id='$login_seller_id' order by 1 DESC limit 0,5");
              while($row_notifications = $get_notifications->fetch()){
              $notification_id = $row_notifications->notification_id;
              $sender_id = $row_notifications->sender_id;
              $order_id = $row_notifications->order_id;
              $reason = $row_notifications->reason;
              $date = $row_notifications->date;
              $status = $row_notifications->status;

              // Select Sender Details
              $select_sender = $db->select("sellers",array("seller_id" => $sender_id));
              $row_sender = $select_sender->fetch();
              $sender_user_name = @$row_sender->seller_user_name;
              $sender_image = @$row_sender->seller_image;
              if(strpos($sender_id,'admin') !== false){
                $admin_id = trim($sender_id, "admin_");
                $get_admin = $db->select("admins",array("admin_id" => $admin_id));
                $sender_user_name = "Admin";
                $sender_image = $get_admin->fetch()->admin_image;
              }
            ?>
            <div class="<?php if($status == "unread"){ echo "header-message-div-unread"; }else{ echo "header-message-div"; } ?>">
              <a href="dashboard?delete_notification=<?= $notification_id; ?>" class="float-right delete text-danger">
              <i class="fa fa-times-circle fa-lg"></i>	
              </a>
              <a href="dashboard?n_id=<?= $notification_id; ?>">
                <?php if(!empty($sender_image)){ ?>
                <?php if(strpos($sender_id, "admin_") !== false){ ?>
                  <img src="admin/admin_images/<?= $sender_image; ?>" width="50" height="50" class="rounded-circle">
                <?php }else{ ?>
                  <img src="user_images/<?= $sender_image; ?>" width="50" height="50" class="rounded-circle">
                <?php } ?>
                <?php }else{ ?>
                <img src="user_images/empty-image.png" width="50" height="50" class="rounded-circle">
                <?php } ?>
                <strong class="heading"><?= $sender_user_name; ?></strong>
                <p class="message"><?= include("includes/comp/notification_reasons.php"); ?></p>
                <p class="date text-muted"> <?= $date; ?></p>
              </a>
            </div>
            <?php } ?>
            <?php if($count_notifications > 0){ ?>
            <div class="p-3">
              <a href="<?= $site_url; ?>/notifications" class="btn btn-success btn-block">
              <?= $lang['see_all']; ?>
              </a>
            </div>
            <?php } ?>
          </div>
          <div id="inbox" class="tab-pane fade mt-3">
            <?php
            
            if($count_all_inbox_sellers == 0){
            echo "<h5 class='text-center mb-3'> No Messages. </h5>";
            }

            $select_inbox_sellers = $db->query("select * from inbox_sellers where (receiver_id='$login_seller_id' or sender_id='$login_seller_id') AND NOT message_status='empty' order by 1 DESC LIMIT 0,4");
            while($row_inbox_sellers = $select_inbox_sellers->fetch()){

            $inbox_seller_id = $row_inbox_sellers->inbox_seller_id;
            $message_group_id = $row_inbox_sellers->message_group_id;
            $sender_id = $row_inbox_sellers->sender_id;
            $receiver_id = $row_inbox_sellers->receiver_id;
            $message_id = $row_inbox_sellers->message_id;

            /// Ids
            if($login_seller_id == $sender_id){
            $sender_id = $receiver_id;
            }else{
            $sender_id = $sender_id;
            }

            /// Select Sender Information
            $select_sender = $db->select("sellers",array("seller_id" => $sender_id));
            $row_sender = $select_sender->fetch();
            $sender_user_name = $row_sender->seller_user_name;
            $sender_image = $row_sender->seller_image;

            $select_inbox_message = $db->select("inbox_messages",array("message_id" => $message_id));
            $row_inbox_message = $select_inbox_message->fetch();
            $message_desc = strip_tags($row_inbox_message->message_desc);
            $message_date = $row_inbox_message->message_date;
            $message_status = $row_inbox_message->message_status;

            if($message_desc == ""){
              $message_desc = "Sent you an offer";
            }

            if($message_status == 'unread'){ 
              if($login_seller_id == $receiver_id){
                $msgClass = "header-message-div-unread"; 
              }else{ 
                $msgClass = "header-message-div"; 
              } 
            }else{ 
              $msgClass = "header-message-div"; 
            }

            ?>
            <div class="<?= $msgClass; ?>"> 
              <a href="conversations/inbox?single_message_id=<?= $message_group_id; ?>">
                <?php if(!empty($sender_image)){ ?>
                <img src="user_images/<?= $sender_image; ?>" width="50" height="50" class="rounded-circle">
                <?php }else{ ?>
                <img src="user_images/empty-image.png" width="50" height="50" class="rounded-circle">
                <?php } ?>
                <strong class="heading"><?= $sender_user_name; ?></strong>
                <p class="message text-truncate"><?= $message_desc; ?></p>
                <p class="text-muted date"><?= $message_date; ?></p>
              </a>
            </div>
            <?php } ?>
            <?php if($count_all_inbox_sellers > 0){ ?>
            <div class="p-3">
              <a href="<?= $site_url; ?>/conversations/inbox" class="btn btn-success btn-block">
              <?= $lang['see_all']; ?>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> -->
<script>
  $(document).ready(function(){
  $('#search-input').keyup(function(){
  var search = $(this).val();
  $('#load-data').html("");
  $.ajax({
  url:"requests/load_search_data",
  method:"POST",
  data:{search:search},
  success:function(data){
    console.log(data);
  $('#load-data').html(data);
  }
  });
  });
  $('#sub-category').change(function(){
  var cat_id = $(this).val();
  $('#load-data').html("");
  $.ajax({
  url:"requests/load_category_data",
  method:"POST",
  data:{cat_id:cat_id},
  success:function(data){
  $('#load-data').html(data);
  }
  });
  });
  });
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php require_once("includes/footer.php"); ?>
</body>
</html>