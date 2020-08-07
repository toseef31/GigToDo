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
$login_seller_type = $row_login_seller->account_type;

$order_id = $input->get("order_id");

$get_orders = $db->query("select * from orders where (seller_id=$login_seller_id or buyer_id=$login_seller_id) AND order_id=:o_id",array("o_id"=>$order_id));
$count_orders = $get_orders->rowCount();

if($count_orders == 0){
  echo "<script>window.open('index.php?not_available','_self')</script>";
}

$row_orders = $get_orders->fetch();
$order_id = $row_orders->order_id;
$order_number = $row_orders->order_number;
if($videoPlugin == 1){
  $order_minutes = $row_orders->order_minutes;
}
$proposal_id = $row_orders->proposal_id;
$seller_id = $row_orders->seller_id;
$buyer_id = $row_orders->buyer_id;
$order_price = $row_orders->order_price;
$order_qty = $row_orders->order_qty;
$order_date = $row_orders->order_date;
$order_duration = $row_orders->order_duration;
$order_time = $row_orders->order_time;
$order_fee = $row_orders->order_fee;
$order_desc = $row_orders->order_description;
$order_status = $row_orders->order_status;
$total = $order_price+$order_fee;

//// Select Order Proposal Details ///
$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));
$row_proposal = $select_proposal->fetch();
$proposal_title = $row_proposal->proposal_title;
$proposal_img1 = $row_proposal->proposal_img1;
$proposal_url = $row_proposal->proposal_url;
$buyer_instruction = $row_proposal->buyer_instruction;

$get_p = $db->select("proposal_packages",array("proposal_id"=>$proposal_id));
$row_p = $get_p->fetch();
$delivery_time = $row_p->delivery_time;
$revisions = $row_p->revisions;
$description = $row_p->description;
// print_r($row_p);

$get_buyer_instructions = $db->query("select buyer_instruction from proposals where proposal_id='$proposal_id'");
$count_buyer_instruction = $get_buyer_instructions->rowCount();
if($count_buyer_instruction == 0){
  $update_order = $db->update("orders",array("order_status"=>"progress"),array("order_id"=>$order_id));
}


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
  <title><?= $site_name; ?> - Resolution Select Issue</title>
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
  <!-- <link href="styles/proposalStyles.css" rel="stylesheet"> -->
  <!-- <link href="styles/user_nav_styles.css" rel="stylesheet"> -->
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

<body class="all-content">
  <!-- Preloader Start -->
    <div class="proloader">
      <div class="loader">
        <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
      </div>
    </div>
    <!-- Preloader End -->
  <?php
    if ($login_seller_type == 'buyer') {
      require_once("includes/buyer-header.php"); 
   }else{
      require_once("includes/user_header.php");
   } 
  ?>


  <?php if ($login_seller_type == 'seller') { ?>
   <main>
      <div class="container-fluid resolution-center">
        <div class="row">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h1 class="page-heading">Resolution Center</h1>
                <p class="page-paragraph">Welcome Here, You can Resolve Issues With Your Buyer With Regards To Your Order.</p>
              </div>
            </div>
            <!-- Row -->
            <div class="row">
              <div class="col-12 col-lg-8">
                <div class="resolution-center-card">
                  <div class="row">
                    <div class="col-12">
                      <div class="resolution-steps wide d-flex flex-row justify-content-between">
                        <div class="resolution-step-item active">
                          <span class="step">1</span>
                          <span class="text">Select Issue</span>
                        </div>
                        <div class="resolution-step-item" id="step-2">
                          <span class="step">2</span>
                          <span class="text">Submit Resolution</span>
                        </div>
                        <div class="resolution-step-item" id="step-3" style="display: none;">
                          <span class="step">3</span>
                          <span class="text">Submit</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Row -->
                  <div class="row" id="seller_select_issue">
                    <div class="col-12">
                      <h4>What issues are you having with this order?</h4>
                      <div>
                        <div class="form-group d-flex flex-column">
                          <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio1" name="customRadio_seller" class="custom-control-input" value="Buyer is not responding">
                          <label class="custom-control-label" for="customRadio1">Buyer is not responding</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio2" name="customRadio_seller" class="custom-control-input" value="Buyer is extremely rude">
                          <label class="custom-control-label" for="customRadio2">Buyer is extremely rude.</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio3" name="customRadio_seller" class="custom-control-input" value="Buyer requested that I cancel this order.">
                          <label class="custom-control-label" for="customRadio3">Buyer requested that I cancel this order.</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio4" name="customRadio_seller" class="custom-control-input" value="Buyer expects more than what this proposal can offer.">
                          <label class="custom-control-label" for="customRadio4">Buyer expects more than what this proposal can offer.</label>
                        </div>
                        <!-- Each item -->
                        <!-- <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio8" name="customRadio" class="custom-control-input">
                          <label class="custom-control-label" for="customRadio8">Other</label>
                        </div> -->
                          <!-- Each item -->
                        </div>
                        <div class="form-group d-flex flex-row mb-0">
                          <button id="continue_seller_issue"  class="button button-red">Continue</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Row -->
                  <!-- Step 2  -->
                  <div class="row" id="step-2-seller" style="display: none;">
                    <div class="col-12">
                      <h4>How would you like to resolve this issue?</h4>
                      <form method="POST" action="">
                        <div class="form-group d-flex flex-column">
                          <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Modify the order</label>
                          </div>
                          <!-- Each item -->
                          <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">Extend the delivery time</label>
                          </div>
                          <!-- Each item -->
                        </div>
                        <div class="form-group d-flex flex-row mb-0">
                          <button class="button goback" type="submit" role="button">
                            <span><i class="far fa-long-arrow-left"></i></span>
                            <span>GO Back</span>
                          </button>
                          <button class="button button-red" type="submit" role="button">Continue</button>
                        </div>
                      </form>
                      
                    </div>
                  </div>
                  <!-- End step 2 -->
                  <!-- step 3 -->
                  <div class="row" id="submit_issue_seller" style="display: none;">
                    <div class="col-12">
                      <form method="POST" action="">
                        <input type="hidden" name="cancellation_reason" value="">
                        <!-- <h4>Select the number of days you would like to add to your delivery time</h4>
                        <div class="form-group d-flex flex-column">
                          <select class="form-control wide">
                            <option>1 Days</option>
                            <option value="1">2 Days</option>
                            <option value="2">5 Days</option>
                            <option value="3">7 Days</option>
                            <option value="4">15 Days</option>
                          </select>
                          <label class="bottom-label">The order should be delivered by <strong>Sep 13, 2017</strong></label>
                        </div> -->
                        <h4>Explain why you would like to cancel the order</h4>
                        <div class="form-group d-flex flex-column">
                          <textarea class="form-control" placeholder="Sir Please..." rows="5" name="cancellation_message"></textarea>
                          <label class="bottom-label text-right">0/2500 Chars Max</label>
                        </div>
                        <!-- <div class="form-group">
                          <p class="mb-0">If you find yourself using this tool for most of your orders, Consider changing your original order deliver time.</p>
                        </div> -->
                        <div class="form-group d-flex flex-row mb-0">
                          <button class="button goback" type="submit" role="button">
                            <span><i class="far fa-long-arrow-left"></i></span>
                            <span>GO Back</span>
                          </button>
                          <button class="button button-red" type="submit" name="submit_request_seller">Send</button>
                        </div>
                      </form>
                      <?php 
                        if(isset($_POST['submit_request_seller'])){
                          $cancellation_message = $input->post('cancellation_message');
                          $cancellation_reason = $input->post('cancellation_reason');
                          $last_update_date = date("h:i: M d, Y");
                          if($seller_id == $login_seller_id){
                          $receiver_id = $buyer_id;
                          }else{
                          $receiver_id = $seller_id;
                          }

                          if(send_cancellation_request($order_id,$order_number,$login_seller_id,$row_orders->proposal_id,$row_orders->seller_id,$row_orders->buyer_id,$last_update_date)){
                            $insert_order_conversation = $db->insert("order_conversations",array("order_id" => $order_id,"sender_id" => $login_seller_id,"message" => $cancellation_message,"date" => $last_update_date,"reason" => $cancellation_reason,"status" => "cancellation_request"));
                        
                            if($insert_order_conversation){
                              $insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "cancellation_request","date" => $n_date,"status" => "unread"));
                              $update_order = $db->update("orders",array("order_status" => "cancellation requested"),array("order_id" => $order_id));
                              echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
                            }
                          }
                        }
                      ?>
                    </div>
                  </div>
                  <!-- End step 3 -->
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="checkout-summary">
                  <div class="summary-header">
                    Summary
                  </div>
                  <div class="cummary-body">
                    <div class="summary-card d-flex flex-row align-items-start">
                      <div class="image">
                        <?php if ($proposal_img1 != '') { ?>
                          <img src="proposals/proposal_files/<?= $proposal_img1; ?>">
                        <?php }else{ ?>
                        <img src="assets/img/checkout/summary-thumb.jpg" alt="">
                        <?php } ?>
                      </div>
                      <div class="text">
                        <p><?= $description; ?></p>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <h4>All the items included in package</h4>
                      <ul class="list-inline d-flex flex-wrap">
                        <li class="list-inline-item d-flex flex-row align-items-start">
                          <span>
                            <img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
                          </span>
                          <span><?= $revisions ?> Revisions</span>
                        </li>
                      </ul>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <div class="processing-fee d-flex flex-row justify-content-between">
                        <span>Processing Fee</span>
                        <span><?= $order_fee; ?></span>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <div class="processing-fee d-flex flex-row justify-content-between">
                        <span>No GST</span>
                        <span>&nbsp;</span>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card d-flex flex-column">
                      <div class="totoal-fee d-flex flex-row justify-content-between">
                        <span>Total</span>
                        <span><?= $s_currency; ?> <?= $total ?></span>
                      </div>
                      <div class="delivery-time d-flex flex-row justify-content-between">
                        <span>Total Delivery Time</span>
                        <span><?= $delivery_time; ?></span>
                      </div>
                    </div>
                    <!-- Each item -->
                  </div>
                </div>
                <!-- Checkout summary -->
              </div>
            </div>
            <!-- Row -->
          </div>
        </div>
      </div>
    </main>
  <?php } ?>
  <?php if ($login_seller_type == 'buyer') { ?>
  <main>
      <section class="container-fluid resolution-center">
        <div class="row">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h1 class="page-heading">Resolution Center</h1>
                <p class="page-paragraph">Welcome Here, You can Resolve Issues With Your Seller With Regards To Your Order.</p>
              </div>
            </div>
            <!-- Row -->
            <div class="row">
              <div class="col-12 col-lg-8">
                <div class="resolution-center-card">
                  <div class="row">
                    <div class="col-12">
                      <div class="resolution-steps wide d-flex flex-row justify-content-between">
                        <div class="resolution-step-item active">
                          <span class="step">1</span>
                          <span class="text">Select Issue</span>
                        </div>
                        <div class="resolution-step-item" id="buyer-submit">
                          <span class="step">2</span>
                          <span class="text">Submit Resolution</span>
                        </div>
                        <div class="resolution-step-item" style="display: none;">
                          <span class="step">3</span>
                          <span class="text">Submit</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Row -->
                  <div class="row" id="buyer_select_issue">
                    <div class="col-12">
                      <h4>What issues are you having with this order?</h4>
                      <div>
                        <div class="form-group d-flex flex-column">
                          <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio1" name="customRadio_buyer" class="custom-control-input" value="Seller is not responding">
                          <label class="custom-control-label" for="customRadio1">Seller is not responding.</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio2" name="customRadio_buyer" class="custom-control-input" value="Seller is extremely rude">
                          <label class="custom-control-label" for="customRadio2">Seller is extremely rude</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio3" name="customRadio_buyer" class="custom-control-input" value="Order does meet requirements">
                          <label class="custom-control-label" for="customRadio3">Order does meet requirements</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio4" name="customRadio_buyer" class="custom-control-input" value="Seller asked me to cancel">
                          <label class="custom-control-label" for="customRadio4">Seller asked me to cancel</label>
                        </div>
                        <!-- Each item -->
                        <div class="custom-control custom-radio">
                          <input type="radio" id="customRadio5" name="customRadio_buyer" class="custom-control-input" value="Seller cannot do required task">
                          <label class="custom-control-label" for="customRadio5">Seller cannot do required task</label>
                        </div>
                        <!-- Each item -->
                        </div>
                        <div class="form-group d-flex flex-row mb-0">
                          <button class="button button-red" role="button" id="continue_buyer_issue">Continue</button>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <!-- Row -->
                  <!-- Step 2  -->
                  <div class="row" id="step-2-issue" style="display: none;">
                    <div class="col-12">
                      <h4>How would you like to resolve this issue?</h4>
                      <form method="POST" action="">
                        <div class="form-group d-flex flex-column">
                          <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Modify the order</label>
                          </div>
                          <!-- Each item -->
                          <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">Extend the delivery time</label>
                          </div>
                          <!-- Each item -->
                        </div>
                        <div class="form-group d-flex flex-row mb-0">
                          <button class="button goback" type="submit" role="button">
                            <span><i class="far fa-long-arrow-left"></i></span>
                            <span>GO Back</span>
                          </button>
                          <button class="button button-red" type="submit" role="button">Continue</button>
                        </div>
                      </form>
                      
                    </div>
                  </div>
                  <!-- End step 2 -->
                  <!-- step 3 -->
                  <div class="row" id="submit-issue" style="display: none;">
                    <div class="col-12">
                      <form method="POST" action="">
                        <input type="hidden" name="cancellation_reason" value="">
                        <!-- <h4>Select the number of days you would like to add to your delivery time</h4>
                        <div class="form-group d-flex flex-column">
                          <select class="form-control wide">
                            <option>1 Days</option>
                            <option value="1">2 Days</option>
                            <option value="2">5 Days</option>
                            <option value="3">7 Days</option>
                            <option value="4">15 Days</option>
                          </select>
                          <label class="bottom-label">The order should be delivered by <strong>Sep 13, 2017</strong></label>
                        </div> -->
                        <h4>Explain why you would like to cancel the order</h4>
                        <div class="form-group d-flex flex-column">
                          <textarea class="form-control" placeholder="Sir Please..." rows="5" name="cancellation_message"></textarea>
                          <label class="bottom-label text-right">0/2500 Chars Max</label>
                        </div>
                        <div class="form-group">
                          <p class="mb-0">If you find yourself using this tool for most of your orders, Consider changing your original order deliver time.</p>
                        </div>
                        <div class="form-group d-flex flex-row mb-0">
                          <button class="button goback" type="submit" role="button">
                            <span><i class="far fa-long-arrow-left"></i></span>
                            <span>GO Back</span>
                          </button>
                          <button class="button button-red" type="submit" name="submit_request_buyer">Send</button>
                        </div>
                      </form>
                      <?php 
                        if(isset($_POST['submit_request_buyer'])){
                          $cancellation_message = $input->post('cancellation_message');
                          $cancellation_reason = $input->post('cancellation_reason');
                          $last_update_date = date("h:i: M d, Y");
                          if($seller_id == $login_seller_id){
                          $receiver_id = $buyer_id;
                          }else{
                          $receiver_id = $seller_id;
                          }

                          if(send_cancellation_request($order_id,$order_number,$login_seller_id,$row_orders->proposal_id,$row_orders->seller_id,$row_orders->buyer_id,$last_update_date)){
                            $insert_order_conversation = $db->insert("order_conversations",array("order_id" => $order_id,"sender_id" => $login_seller_id,"message" => $cancellation_message,"date" => $last_update_date,"reason" => $cancellation_reason,"status" => "cancellation_request"));
                        
                            if($insert_order_conversation){
                              $insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "cancellation_request","date" => $n_date,"status" => "unread"));
                              $update_order = $db->update("orders",array("order_status" => "cancellation requested"),array("order_id" => $order_id));
                              echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
                            }
                          }
                        }
                      ?>
                    </div>
                  </div>
                  <!-- End step 3 -->
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="checkout-summary">
                  <div class="summary-header">
                    Summary
                  </div>
                  <div class="cummary-body">
                    <div class="summary-card d-flex flex-row align-items-start">
                      <div class="image">
                        <?php if ($proposal_img1 != '') { ?>
                          <img src="proposals/proposal_files/<?= $proposal_img1; ?>">
                        <?php }else{ ?>
                        <img src="assets/img/checkout/summary-thumb.jpg" alt="">
                        <?php } ?>
                      </div>
                      <div class="text">
                        <p><?= $description; ?></p>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <h4>All the items included in package</h4>
                      <ul class="list-inline d-flex flex-wrap">
                        <li class="list-inline-item d-flex flex-row align-items-start">
                          <span>
                            <img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
                          </span>
                          <span><?= $revisions ?> Revisions</span>
                        </li>
                      </ul>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <div class="processing-fee d-flex flex-row justify-content-between">
                        <span>Processing Fee</span>
                        <span><?= $order_fee; ?></span>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <div class="processing-fee d-flex flex-row justify-content-between">
                        <span>No GST</span>
                        <span>&nbsp;</span>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card d-flex flex-column">
                      <div class="totoal-fee d-flex flex-row justify-content-between">
                        <span>Total</span>
                        <span><?= $s_currency; ?> <?= $total ?></span>
                      </div>
                      <div class="delivery-time d-flex flex-row justify-content-between">
                        <span>Total Delivery Time</span>
                        <span><?= $delivery_time ?></span>
                      </div>
                    </div>
                    <!-- Each item -->
                  </div>
                </div>
                <!-- Checkout summary -->
              </div>
            </div>
            <!-- Row -->
          </div>
        </div>
      </section>
    </main>
  <?php } ?>

<script>
  $('#continue_buyer_issue').click(function(){
    var reason = $("input[name='customRadio_buyer']:checked").val();
    // alert(reason);
    $("input[name='cancellation_reason']").val(reason);
    $('#buyer-submit').addClass('active');
    $('#buyer_select_issue').hide();
    $('#submit-issue').show();
  });
  $('#continue_seller_issue').click(function(){
    var reason_seller = $("input[name='customRadio_seller']:checked").val();
    // alert(reason_seller);
    $("input[name='cancellation_reason']").val(reason_seller);
    $('#step-2').addClass('active');
    $('#seller_select_issue').hide();
    $('#submit_issue_seller').show();
  });
</script>
<?php require_once("includes/footer.php"); ?>

</body>
</html>