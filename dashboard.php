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
  if(empty($login_seller_country)){
    $login_seller_country = "&nbsp;";
  }

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

  <!-- New Design -->
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
  <!--====== Range Slider css ======-->
  <link href="assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="assets/css/responsive.css" rel="stylesheet">
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="styles/user_nav_styles.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
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
      right: 10px;
      top: 10px;
    }
  </style>
</head>
<body class="all-content ddashborad">
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
              <p>Today <span>0.0 <?= $s_currency; ?></span></p>
            </div>
            <div class="day-item">
              <p>Yesterday <span>0.0 <?= $s_currency; ?></span></p>
            </div>
            <div class="day-item">
              <p>last 7 days <span>0.0 <?= $s_currency; ?></span></p>
            </div>
            <div class="day-item">
              <p>last 30 days <span><?= $month_earnings; ?> <?= $s_currency; ?></span></p>
            </div>
            <div class="day-item">
              <p>last 365 days <span>0.0 <?= $s_currency; ?></span></p>
            </div>
            <div class="day-item">
              <p>All time <span><?= $current_balance; ?> <?= $s_currency; ?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="profile-chart-area mb-30">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg1.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/user.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4><?= $login_seller_view; ?> <span>Profile Views</span></h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg2.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/clip.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4><?= $total_gigs_view; ?> <span>Gig Views</span></h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg3.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/filter.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4>0 <span>Conversion Rates </span></h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="profile-chart-item" style="background-image: url(assets/img/img/dash-bg4.png);">
                <div class="profile-cart-icon">
                  <img src="assets/img/img/cal.png" alt="">
                </div>
                <div class="profile-cart-text">
                  <h4><?= round($average,2); ?> <span>Average Cost of Gigs </span></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="all-project-chart">
            <h2>All Projects</h2>
            <?php $count_orders = $db->count("orders",array("seller_id" => $login_seller_id)); 
            if($count_orders == 0){
            ?>
            <img src="assets/img/img/all-chart2.png" alt="">
            <?php }else{ ?>
            <div id="chartContainer" style="height: 250px; width: 100%;"></div>
            <?php } ?>
            <!-- <img src="assets/img/img/all-chart.png" alt=""> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dash-chart-area pb-50">
    <div class="container">
      <div class="row">
        <div class="col-12 col-xl-6">
          <div class="message-notification">
            <div class="message-title">
              <?php
                $select_all_inbox_sellers = $db->query("select * from inbox_sellers where (receiver_id='$login_seller_id' or sender_id='$login_seller_id') AND NOT message_status='empty'");
                $count_all_inbox_sellers = $select_all_inbox_sellers->rowCount();
              ?>
              Messages <!-- <span class="badge badge-success"><?= $count_all_inbox_sellers; ?></span> --> & Notifications 
            </div>
            <div class="messge-noti-box">
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
              <div class="messge-item <?= $msgClass; ?>">
                <div class="msg-logo">
                  <a href="conversations/inbox?single_message_id=<?= $message_group_id; ?>">
                  <?php if(!empty($sender_image)){ ?>
                  <img src="user_images/<?= $sender_image; ?>" width="60" height="60" class="rounded-circle">
                  <?php }else{ ?>
                  <img src="assets/img/img/logoogo.png" width="60" height="60" class="rounded-circle">
                  <?php } ?>
                  </a>
                </div>
                <div class="msg-text">
                  <h5><?= $sender_user_name; ?> <span>posted a message</span></h5>
                  <p class="text-muted date"><i class="fal fa-clock"></i> <?= $message_date; ?></p>
                  <p class="message text-truncate"><i class="fas fa-external-link-alt"></i> <?= $message_desc; ?></p>
                </div>
              </div>
              <?php } ?>

              <?php
                $count_notifications = $db->count("notifications",array("receiver_id" => $login_seller_id));
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
              <div class="messge-item <?php if($status == "unread"){ echo "header-message-div-unread"; }else{ echo "header-message-div"; } ?>">
                <a href="dashboard?delete_notification=<?= $notification_id; ?>" class="float-right delete text-danger">
                <i class="fa fa-times-circle fa-lg"></i>  
                </a>
                <div class="msg-logo">
                  <a href="dashboard?n_id=<?= $notification_id; ?>">
                  <?php if(!empty($sender_image)){ ?>
                  <?php if(strpos($sender_id, "admin_") !== false){ ?>
                    <img src="admin/admin_images/<?= $sender_image; ?>" width="60" height="60" class="rounded-circle">
                  <?php }else{ ?>
                    <img src="user_images/<?= $sender_image; ?>" width="60" height="60" class="rounded-circle">
                  <?php } ?>
                  <?php }else{ ?>
                  <img src="user_images/empty-image.png" width="60" height="60" class="rounded-circle">
                  <?php } ?>
                  </a>
                </div>
                <div class="msg-text">
                  <a href="dashboard?n_id=<?= $notification_id; ?>">
                    <h5><?= $sender_user_name; ?></h5>
                    <p class="text-muted date"><i class="fal fa-clock"></i> <?= $date; ?></p>
                    <p class="message text-truncate"><i class="fas fa-external-link-alt"></i> <?= include("includes/comp/notification_reasons.php"); ?></p>
                  </a>
                </div>
              </div>
              <?php } ?>
              <!-- <?php if($count_all_inbox_sellers > 0){ ?>
              <div class="p-3">
                <a href="<?= $site_url; ?>/conversations/inbox" class="btn btn-success btn-block">
                <?= $lang['see_all']; ?>
                </a>
              </div>
              <?php } ?> -->
              <!-- <div class="messge-item">
                <div class="msg-logo">
                  <img src="assets/img/img/logoogo.png" alt="">
                </div>
                <div class="msg-text">
                  <h5>Frends Marks <span>posted a message</span></h5>
                  <p><i class="fal fa-clock"></i> 03-02-2016</p>
                  <p><i class="fas fa-external-link-alt"></i> Hello World</p>
                </div>
              </div>
              <div class="messge-item">
                <div class="msg-logo">
                  <img src="assets/img/img/logoogo.png" alt="">
                </div>
                <div class="msg-text">
                  <h5>Frends Marks <span>posted a message</span></h5>
                  <p><i class="fal fa-clock"></i> 03-02-2016</p>
                  <p><i class="fas fa-external-link-alt"></i> Hello World</p>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-6">
          <div class="income-chart">
            <div class="income-chart-title">
              <h5>Income by date</h5>
              <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#altime" role="tab" aria-controls="home" aria-selected="true">All time</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#lastyear" role="tab" aria-controls="profile" aria-selected="false">Last Year</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#last30day" role="tab" aria-controls="contact" aria-selected="false">Last 30 days </a>
                </li>
              </ul>
            </div>
            <div class="income-chart-box">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="altime" role="tabpanel" aria-labelledby="home-tab">
                  <?php $count_orders = $db->count("orders",array("seller_id" => $login_seller_id)); 
                  if($count_orders == 0){
                  ?>
                  <img src="assets/img/img/income-chart3.png" alt="">
                <?php }else{ ?>
                  <img src="assets/img/img/income-chart1.png" alt="">
                  <?php } ?>
                </div>
                <div class="tab-pane fade" id="lastyear" role="tabpanel" aria-labelledby="profile-tab">
                  <canvas id="chartHours" width="400" height="100"></canvas>
                </div>
                <div class="tab-pane fade" id="last30day" role="tabpanel" aria-labelledby="contact-tab">
                  <?php $count_orders = $db->count("orders",array("seller_id" => $login_seller_id)); 
                  if($count_orders == 0){
                  ?>
                  <img src="assets/img/img/income-chart3.png" alt="">
                <?php }else{ ?>
                  <img src="assets/img/img/income-chart1.png" alt="">
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="income-chart border-top-none border-bottom-1">
            <div class="income-chart-title">
              <h5>Projects completed</h5>
              <ul class="nav" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#altime2" role="tab" aria-controls="home" aria-selected="true">All time</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#lastyear2" role="tab" aria-controls="profile" aria-selected="false">Last Year</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#last30day2" role="tab" aria-controls="contact" aria-selected="false">Last 30 days </a>
                </li>
              </ul>
            </div>
            <div class="income-chart-box">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="altime2" role="tabpanel" aria-labelledby="home-tab">
                  <?php $count_orders = $db->count("orders",array("seller_id" => $login_seller_id)); 
                  if($count_orders == 0){
                  ?>
                  <img src="assets/img/img/income-chart3.png" alt="">
                <?php }else{ ?>
                  <img src="assets/img/img/income-chart2.png" alt="">
                  <?php } ?>
                </div>
                <div class="tab-pane fade" id="lastyear2" role="tabpanel" aria-labelledby="profile-tab">
                  <?php $count_orders = $db->count("orders",array("seller_id" => $login_seller_id)); 
                  if($count_orders == 0){
                  ?>
                  <img src="assets/img/img/income-chart3.png" alt="">
                <?php }else{ ?>
                  <img src="assets/img/img/income-chart2.png" alt="">
                  <?php } ?>
                </div>
                <div class="tab-pane fade" id="last30day2" role="tabpanel" aria-labelledby="contact-tab">
                  <?php $count_orders = $db->count("orders",array("seller_id" => $login_seller_id)); 
                  if($count_orders == 0){
                  ?>
                  <img src="assets/img/img/income-chart3.png" alt="">
                <?php }else{ ?>
                  <img src="assets/img/img/income-chart2.png" alt="">
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashborad-area-start END-->
  




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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php require_once("includes/footer.php"); ?>
</body>
</html>