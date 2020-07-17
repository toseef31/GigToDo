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
$seller_id = $row_orders->seller_id;
$buyer_id = $row_orders->buyer_id;
$order_price = $row_orders->order_price;
$order_number = $row_orders->order_number;
$proposal_id = $row_orders->proposal_id;
$order_status = $row_orders->order_status;
$complete_time = $row_orders->complete_time;
$order_industry = $row_orders->order_industry;
$order_description = $row_orders->order_description;


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
  <!-- <link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet"> -->
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
  <link href="styles/bootstrap.css" rel="stylesheet">
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

  <?php require_once("orderIncludes/orderDetails.php"); ?>
  <?php //require_once("orderIncludes/orderStatusBar.php"); ?>

  <?php if ($login_seller_type == 'seller') { ?>
   <main>
      <section class="container-fluid order-view">
        <div class="row">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                <div class="order-card">
                  <div class="order-gig-selected d-flex flex-wrap">
                    <div class="order-user-image">
                      <?php if ($proposal_img1 == ''){ ?>
                        <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                      <?php }else{ ?>
                        <img class="img-fluid d-block" src="proposals/proposal_files/<?= $proposal_img1; ?>" />
                      <?php } ?>
                    </div>
                    <div class="order-gig-detail">
                      <div class="order-gig-detail-title d-flex flex-row justify-content-between">
                        <span class="title"><?= $proposal_title; ?></span>
                        <span class="price"><?= $s_currency.$order_price; ?>.00</span>
                      </div>
                      <div class="order-gig-expand">
                        <ul class="list-inline d-flex flex-wrap">
                          <li class="list-inline-item">Buyer: <a href="profile?user_name=<?= $buyer_user_name; ?>"><?= ucfirst($buyer_user_name); ?></a></li>
                          <li class="list-inline-item">Order Number: #<?= $order_number; ?></li>
                          <li class="list-inline-item"><?= $order_date; ?></li>
                          <li class="list-inline-item">Processing Fee: <?= $s_currency.' '.$order_fee; ?></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Order card -->
                <div class="order-card">
                  <div class="order-require d-flex flex-column">
                    <div class="order-require-header d-flex flex-wrap align-items-start">
                      <div class="icon">
                        <img alt="" class="img-fluid d-block" src="assets/img/order/order-require-icon.png" />
                      </div>
                      <div class="text">
                        <span>Order Requirements</span>
                        <span>You’ve filled out the requirements</span>
                      </div>
                      <div class="show-hide active" data-toggle="collapse" data-target="#showHide" aria-expanded="true" aria-controls="showHide">
                        <span class="before">+ Show Requirements</span>
                        <span class="after">- Hide Requirements</span>
                      </div>
                    </div>
                    <div class="collapse show" id="showHide">
                      <div class="order-require-body">
                        <div class="order-require-items">
                          <div class="order-require-item">
                            <h4>1. What industry does this order relate to? (Optional)</h4>
                            <p><?= $order_industry; ?></p>
                          </div>
                          <!-- Each item -->
                          <div class="order-require-item">
                            <h4>2. Kindly send your business details here.</h4>
                            <p><?= $order_description; ?></p>
                          </div>
                          <!-- Each item -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Order card -->
                <?php require_once("orderIncludes/orderTimeCounterBuyerInstruction.php"); ?>
                <!-- Count down timer -->
                
                <div class="order-message-card">
                  <div class="message-content-card">
                    <?php require_once("orderIncludes/order_conversations.php"); ?>
                    <!-- <div class="message-content-card-item d-flex flex-column">
                      <div class="d-flex flex-row align-items-start">
                        <div class="user-image">
                          <img src="assets/img/emongez_cube.png" />
                        </div>
                        <div class="messages-text d-flex flex-column">
                          <div class="username d-flex flex-row align-items-start justify-content-between">
                            <span>snazzydegreat</span>
                            <span class="timestamp">1 month ago</span>
                          </div>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                      </div>
                    </div> -->
                    <!-- Each item -->
                    <!-- <div class="message-content-card-item d-flex flex-column">
                      <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
                        <div class="image-icon">
                          <img class="img-fluid d-block" src="assets/img/order/box-icon.png" />
                        </div>
                        <h5 class="text-center">Order Requirements</h5>
                        <p>This order will be marked as complete in 3 days.</p>
                      </div>
                      <div class="d-flex flex-row align-items-start">
                        <div class="user-image">
                          <img src="assets/img/emongez_cube.png" />
                        </div>
                        <div class="messages-text d-flex flex-column">
                          <div class="username d-flex flex-row align-items-start justify-content-between">
                            <span>snazzydegreat</span>
                            <span class="timestamp">1 month ago</span>
                          </div>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                          <h5>Delivered Files</h5>
                          <div class="file-attachment d-flex flex-row align-items-center">
                            <span><i class="fas fa-arrow-circle-down"></i></span>
                            <span class="file-name">Egyptlanc...docx</span>
                            <span>(602kb)</span>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <!-- Each item -->
                    <!-- <div class="message-content-card-item d-flex flex-column">
                      <div class="d-flex flex-row align-items-start">
                        <div class="user-image">
                          <img src="assets/img/emongez_cube.png" />
                        </div>
                        <div class="messages-text d-flex flex-column">
                          <div class="username d-flex flex-row align-items-start justify-content-between">
                            <span>snazzydegreat</span>
                            <span class="timestamp">1 month ago</span>
                          </div>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                      </div>
                    </div> -->
                    <!-- Each item -->
                    <?php require_once("orderIncludes/orderDeliverButton.php"); ?>
                    <!-- <div class="message-content-card-item d-flex flex-column">
                      <div class="d-flex flex-wrap justify-content-center">
                        <a class="d-flex flex-row align-items-center justify-content-center button button-red" data-toggle="modal" href="#exampleModalCenter">Deliver Now</a>
                      </div>
                    </div> -->
                    <!-- Each item -->
                  </div>
                  <!-- Message content card -->
                  <?php require_once("orderIncludes/insertMessageBox.php"); ?>
                  <!-- <div class="message-sender-area">
                    <form method="post" action="">
                      <textarea class="message-text" placeholder="Type your message here..."></textarea>
                      <div class="d-flex flex-column flex-sm-row justify-content-between">
                        <div class="attachment d-flex flex-row align-items-center">
                          <label for="attach-file">
                            <input type="file" hidden name="" id="attach-file" />
                            <div class="d-flex flex-row align-items-center">
                              <i class="fal fa-paperclip"></i>
                              Attach File
                            </div>
                          </label>
                          <div class="file-size">Max Size 30MB</div>
                        </div>
                        <button class="send-message" type="submit" role="button">SEND</button>
                      </div>
                    </form>
                  </div> -->
                  <!-- Message send area -->
                </div>
                <!-- Order message card -->
              </div>
              <div class="col-12 col-lg-4">
                <div class="order-affix">
                  <div class="order-resolution-card">
                    <div class="order-resolution-text">
                      <i class="fas fa-exclamation-circle"></i>
                      <p>Having issues with your order? Visit the<br /><a href="resolution-center?order_id=<?= $order_id ?>">Resolution Center</a></p>
                    </div>
                  </div>
                  <!-- Order resolution card -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  <?php } ?>
  <?php if ($login_seller_type == 'buyer') { ?>
  <main>
    <section class="container-fluid order-view">
      <div class="row">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="order-card">
                <div class="order-gig-selected d-flex flex-wrap">
                  <div class="order-user-image">
                    <?php if ($proposal_img1 == ''){ ?>
                      <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                    <?php }else{ ?>
                      <img class="img-fluid d-block" src="proposals/proposal_files/<?= $proposal_img1; ?>" />
                    <?php } ?>
                  </div>
                  <div class="order-gig-detail">
                    <div class="order-gig-detail-title d-flex flex-row justify-content-between">
                      <span class="title"><?= $proposal_title; ?></span>
                      <span class="price"><?= $s_currency.$order_price; ?>.00</span>
                    </div>
                    <div class="order-gig-expand">
                      <ul class="list-inline d-flex flex-wrap">
                        <li class="list-inline-item">Seller: <a href="<?= $seller_user_name; ?>"><?= ucfirst($seller_user_name); ?></a></li>
                        <li class="list-inline-item">Order Number: #<?= $order_number; ?></li>
                        <li class="list-inline-item"><?= $order_date; ?></li>
                        <li class="list-inline-item">Processing Fee: <?= $s_currency.' '.$order_fee; ?></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Order card -->
              <div class="order-card">
                <div class="order-require d-flex flex-column">
                  <div class="order-require-header d-flex flex-wrap align-items-start">
                    <div class="icon">
                      <img alt="" class="img-fluid d-block" src="assets/img/order/order-require-icon.png" />
                    </div>
                    <div class="text">
                      <span>Order Requirements</span>
                      <span>You’ve filled out the requirements</span>
                    </div>
                    <div class="show-hide active" data-toggle="collapse" data-target="#showHide" aria-expanded="true" aria-controls="showHide">
                      <span class="before">+ Show Requirements</span>
                      <span class="after">- Hide Requirements</span>
                    </div>
                  </div>
                  <div class="collapse show" id="showHide">
                    <div class="order-require-body">
                      <div class="order-require-items">
                        <div class="order-require-item">
                          <h4>1. What industry does this order relate to? (Optional)</h4>
                          <p><?= $order_industry; ?></p>
                        </div>
                        <!-- Each item -->
                        <div class="order-require-item">
                          <h4>2. Kindly send your business details here.</h4>
                          <p><?= $order_description; ?></p>
                        </div>
                        <!-- Each item -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Order card -->
              
              <?php require_once("orderIncludes/orderTimeCounterBuyerInstruction.php"); ?>
              <!-- Count down timer -->
              
              <div class="order-message-card">
                <div class="message-content-card">
                  <?php require_once("orderIncludes/order_conversations.php"); ?>
                  <!-- Each item -->
                  <!-- <div class="message-content-card-item d-flex flex-column">
                    <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
                      <div class="image-icon">
                        <img class="img-fluid d-block" src="assets/img/order/box-icon.png" />
                      </div>
                      <h5 class="text-center">Order Requirements</h5>
                      <p>This order will be marked as complete in 3 days.</p>
                    </div>
                    <div class="d-flex flex-row align-items-start">
                      <div class="user-image">
                        <img src="assets/img/emongez_cube.png" />
                      </div>
                      <div class="messages-text d-flex flex-column">
                        <div class="username d-flex flex-row align-items-start justify-content-between">
                          <span>snazzydegreat</span>
                          <span class="timestamp">1 month ago</span>
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        <h5>Delivered Files</h5>
                        <div class="file-attachment d-flex flex-row align-items-center">
                          <span><i class="fas fa-arrow-circle-down"></i></span>
                          <span class="file-name">Egyptlanc...docx</span>
                          <span>(602kb)</span>
                        </div>
                        <div class="d-flex flex-wrap justify-content-start">
                          <a class="d-flex flex-row align-items-center justify-content-center button button-white" href="javascript:void(0);">Request Revision</a>
                          <a class="d-flex flex-row align-items-center justify-content-center button button-red" href="javascript:void(0);">Accept & Review Order</a>
                        </div>
                      </div>
                    </div>                    
                  </div> -->
                  <!-- Each item -->
                  <!-- <div class="message-content-card-item d-flex flex-column">
                    <div class="d-flex flex-row align-items-start">
                      <div class="user-image">
                        <img src="assets/img/emongez_cube.png" />
                      </div>
                      <div class="messages-text d-flex flex-column">
                        <div class="username d-flex flex-row align-items-start justify-content-between">
                          <span>snazzydegreat</span>
                          <span class="timestamp">1 month ago</span>
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                      </div>
                    </div>
                  </div> -->
                  <!-- Each item -->
                  <?php require_once("orderIncludes/orderDeliverButton.php"); ?>
                </div>
                <!-- Message content card -->
                <?php require_once("orderIncludes/insertMessageBox.php"); ?>
                <!-- <div class="message-sender-area">
                  <form method="post" action="">
                    <textarea class="message-text" placeholder="Type your message here..."></textarea>
                    <div class="d-flex flex-column flex-sm-row justify-content-between">
                      <div class="attachment d-flex flex-row align-items-center">
                        <label for="attach-file">
                          <input type="file" hidden name="" id="attach-file" />
                          <div class="d-flex flex-row align-items-center">
                            <i class="fal fa-paperclip"></i>
                            Attach File
                          </div>
                        </label>
                        <div class="file-size">Max Size 30MB</div>
                      </div>
                      <button class="send-message" type="submit" role="button">SEND</button>
                    </div>
                  </form>
                </div> -->
                <!-- Message send area -->
              </div>
              <!-- Order message card -->
            </div>
            <div class="col-12 col-lg-4">
              <div class="order-affix">
                <div class="order-process-card">
                  <div class="order-process-items d-flex flex-column">
                    <div class="order-process-item d-flex flex-row align-items-center">
                      <div class="order-process-icon">
                        <i class="fal fa-check"></i>
                      </div>
                      <div class="order-process-text">Placed Order</div>
                    </div>
                    <!-- Each item -->
                    <div class="order-process-item d-flex flex-row align-items-center">
                      <div class="order-process-icon">
                        <i class="fal fa-check"></i>
                      </div>
                      <div class="order-process-text">Provide Requirements</div>
                    </div>
                    <!-- Each item -->
                    <div class="order-process-item d-flex flex-row align-items-center">
                      <div class="order-process-icon">
                        <i class="fal fa-check"></i>
                      </div>
                      <div class="order-process-text">Order in Progress</div>
                    </div>
                    <!-- Each item -->
                    <div class="order-process-item d-flex flex-row align-items-center">
                      <div class="order-process-icon">
                        <i class="fal fa-check"></i>
                      </div>
                      <div class="order-process-text">Review The Delivery</div>
                    </div>
                    <!-- Each item -->
                    <div class="order-process-item d-flex flex-row align-items-center">
                      <div class="order-process-icon">
                        <i class="fas fa-circle"></i>
                      </div>
                      <div class="order-process-text">Order Complete</div>
                    </div>
                    <!-- Each item -->
                  </div>
                  <p>Your order is completed! We hope you got everything you needed.</p>
                </div>
                <!-- Order process card -->
                <div class="order-resolution-card">
                  <div class="order-resolution-text">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Having issues with your order? Visit the<br /><a href="resolution-center?order_id=<?= $order_id ?>">Resolution Center</a></p>
                  </div>
                </div>
                <!-- Order resolution card -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php } ?>


<!-- <div class="container order-page mt-2">
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
</div> -->
<?php 
  $timee = $order_time;
   $new_time = strtotime($timee);
   
  $new_date = date('Y/m/d H:i:s',$new_time); 
  
?>
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

<script>
  $(function(){
    $('.order-gig-expand').readmore({
      speed: 75,
      moreLink: '<a href="#">+ Show more</a>',
      lessLink: '<a href="#">+ Show less</a>'
    });
    $('.show-hide').on('click', function(){
      $(this).toggleClass('active');
    });
    $(".countdown").flipTimer({
      // timeZone:+1,
      date:"<?php echo $new_date; ?>",
      borderRadius:2,
      bgColor:"#dddddd",
      dividerColor:"#ffffff",
      digitColor:"#202020",
      textColor:"#252525",
      boxShadow:true

    });
  });
</script>
<?php require_once("includes/footer.php"); ?>

</body>
</html>