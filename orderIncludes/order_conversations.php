<?php

@session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dir = str_replace(array("orderIncludes"), '',__DIR__);
require_once("$dir/includes/db.php");
require_once("$dir/functions/functions.php");

if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

@$order_id = $input->get('order_id');

$site_email_address = $row_general_settings->site_email_address;  
$site_logo = $row_general_settings->site_logo;
$order_auto_complete = $row_general_settings->order_auto_complete;

$get_orders = $db->select("orders",array("order_id" => $order_id));
$row_orders = $get_orders->fetch();
$seller_id = $row_orders->seller_id;
$buyer_id = $row_orders->buyer_id;
$order_price = $row_orders->order_price;
$order_status = $row_orders->order_status;
$order_complete_time = new DateTime($row_orders->complete_time);
$i = 0;
$get_order_conversations =  $db->select("order_conversations",array("order_id" => $order_id));

while($row_order_conversations = $get_order_conversations->fetch()){

$c_id = $row_order_conversations->c_id;
$sender_id = $row_order_conversations->sender_id;
$message = $row_order_conversations->message;
$file = $row_order_conversations->file;
$date = $row_order_conversations->date;
$status = $row_order_conversations->status;

$select_seller = $db->select("sellers",array("seller_id" => $sender_id));
$row_seller = $select_seller->fetch();
$seller_user_name = $row_seller->seller_user_name;
$seller_image = $row_seller->seller_image;

if($seller_id == $sender_id){
  $receiver_name = "Buyer";
}else{
  $receiver_name = "Seller";
}

if($seller_id == $login_seller_id){
  $receiver_id = $buyer_id;
}else{
  $receiver_id = $seller_id;
}

$last_update_date = date("h:i: M d, Y");
$n_date = date("F d, Y");
$i++;
?>


<?php if($status == "message"){ ?>
<!-- <div class="
  <?php
  if($sender_id == $login_seller_id){
    
  echo "message-div-hover";
    
  }else{
    
  echo "message-div";
    
  }
  ?>">
  
  <?php if(!empty($seller_image)){ ?>
  <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="50" height="50" class="message-image">
  <?php }else{ ?>
  <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="message-image">
  <?php } ?>
  <h5>
  <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>
  </h5>
  <p class="message-desc">
    <?php echo $message; ?>
    <?php if(!empty($file)){ ?>
    <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>
      <i class="fa fa-download"></i> <?php echo $file; ?>
    </a>
    <?php }else{ ?>
    <?php } ?>
  </p>
  <p class="text-right text-muted mb-0" style="font-size: 14px;">
    <?php echo $date; ?>
    <?php if($login_seller_id != $sender_id){ ?>
    <?php if($login_seller_id == $buyer_id){ ?>
    | <a href="#" data-toggle="modal" data-target="#report-modal" class="text-muted"><i class="fa fa-flag"></i> Report</a>
    <?php }else{ ?>
    | <a href="#" data-toggle="modal" data-target="#report-modal" class="text-muted"><i class="fa fa-flag"></i> Report</a>
    <?php } ?>
    <?php } ?>
  </p>
  </div> -->
  <div class="message-content-card-item d-flex flex-column">
    <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
      <!-- <?php if($i == 1){?>
      <div class="image-icon">
        <img class="img-fluid d-block" src="assets/img/order/box-icon.png" />
      </div>
      <?php 
      $remain = $order_complete_time->diff(new DateTime());
      if($remain->d < 1){ $remain->d = 1; }
      ?>
      <h5 class="text-center">Order Requirements</h5>
      <p>This order will be marked as complete in <?php echo $remain->d; ?> days.</p>
      <?php } ?> -->
    </div>
    <div class="d-flex flex-row align-items-start">
      <div class="user-image">
        <?php if(!empty($seller_image)){ ?>
        <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>"  width="60" height="60" class="message-image" />
        <?php }else{ ?>
          <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
        <?php } ?>
      </div>
      <div class="messages-text d-flex flex-column">
        <div class="username d-flex flex-row align-items-start justify-content-between">
          <span><?php echo $seller_user_name; ?></span>
          <span class="timestamp"><?php echo $date; ?></span>
        </div>
        <p><?php echo $message; ?></p>
        <?php if(!empty($file)){ ?>
        <h5>Delivered Files</h5>
        <div class="file-attachment d-flex flex-row align-items-center">
          <span><i class="fas fa-arrow-circle-down"></i></span>
          <a href="order_files/<?php echo $file; ?>" download><span class="file-name"><?php echo $file; ?></span></a>
          <!-- <span>(602kb)</span> -->
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php }elseif($status == "delivered"){ ?>
  <!-- <?php
  $remain = $order_complete_time->diff(new DateTime());
  if($remain->d < 1){ $remain->d = 1; }
  ?>
  <div class="card mt-4">
    <div class="card-body">
      <h5 class="text-center"><i class="fa fa-archive"></i> Order Delivered</h5>
      <?php if($seller_id == $login_seller_id){ ?>
      <p class="text-center font-weight-bold pb-0">The buyer has <?php echo $remain->d; ?> day(s) to complete/respond to this order, otherwise it will be automatically marked as completed.</p>
      <?php } else { ?>
      <p class="text-center font-weight-bold pb-0">You have <?php echo $remain->d; ?> day(s) to complete/respond to this order, otherwise it will be automatically marked as completed.</p>
      
      <?php } ?>
    </div>
  </div>
  <div class="
    <?php
    if($sender_id == $login_seller_id){
      
    echo "message-div-hover";
      
    }else{
      
    echo "message-div";
      
    }
    ?>
    ">
    <?php if(!empty($seller_image)){ ?>
    <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="50" height="50" class="message-image">
    <?php }else{ ?>
    <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="message-image">
    <?php } ?>
    
    <h5>
    <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>
    </h5>
    <p class="message-desc">
      <?php echo $message; ?>
      <?php if(!empty($file)){ ?>
      <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>
        <i class="fa fa-download"></i> <?php echo $file; ?>
      </a>
      <?php }else{ ?>
      <?php } ?>
    </p>
    <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>
    </div>
    <?php if($order_status == "delivered"){ ?>
    <?php if($buyer_id == $login_seller_id){ ?>
    <center class="pb-4 mt-4">
    <form method="post">
      <button name="complete" type="submit" class="btn btn-success">
      Accept & Review Order
      </button>
      &nbsp;&nbsp;&nbsp;
      <button type="button" data-toggle="modal" data-target="#revision-request-modal" class="btn btn-success">
      Request A Revision
      </button>
    </form>
    <?php
    if(isset($_POST['complete'])){
    //require_once("orderIncludes/orderComplete.php");
    }
    ?>
    </center>
    <?php } ?>
    <?php } ?> -->
      <?php
      $remain = $order_complete_time->diff(new DateTime());
      if($remain->d < 1){ $remain->d = 1; }
      ?>
    <div class="message-content-card-item d-flex flex-column">
      <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
        <div class="image-icon">
          <img class="img-fluid d-block" src="assets/img/order/box-icon.png" />
        </div>
        <h5 class="text-center">Order Delivered</h5>
        <?php if($seller_id == $login_seller_id){ ?>
        <p class="text-center font-weight-bold pb-0">The buyer has <?php echo $remain->d; ?> day(s) to complete/respond to this order, otherwise it will be automatically marked as completed.</p>
        <?php } else { ?>
        <p class="text-center font-weight-bold pb-0">You have <?php echo $remain->d; ?> day(s) to complete/respond to this order, otherwise it will be automatically marked as completed.</p>
        
        <?php } ?>
      </div>
      <div class="d-flex flex-row align-items-start">
        <div class="user-image">
          <?php if(!empty($seller_image)){ ?>
          <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>"  width="60" height="60" class="message-image" />
          <?php }else{ ?>
            <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
          <?php } ?>
        </div>
        <div class="messages-text d-flex flex-column">
          <div class="username d-flex flex-row align-items-start justify-content-between">
            <span><?php echo $seller_user_name; ?></span>
            <span class="timestamp"><?php echo $date; ?></span>
          </div>
          <p><?php echo $message; ?></p>
          <?php if(!empty($file)){ ?>
          <h5>Delivered Files</h5>
          <div class="file-attachment d-flex flex-row align-items-center">
            <span><i class="fas fa-arrow-circle-down"></i></span>
            <a href="order_files/<?php echo $file; ?>" download><span class="file-name"><?php echo $file; ?></span></a>
            <!-- <span>(602kb)</span> -->
          </div>
          <?php } ?>
          <?php if($order_status == "delivered"){ ?>
          <?php if($buyer_id == $login_seller_id){ ?>
          <div class="d-flex flex-wrap justify-content-start">
            <form method="post" style="display: contents;">
              <button type="button" data-toggle="modal" data-target="#revision-request-modal" class="d-flex flex-row align-items-center justify-content-center button button-white" href="javascript:void(0);">Request Revision</button>
              <button name="complete" type="submit" class="d-flex flex-row align-items-center justify-content-center button button-red">Accept & Review Order</button>
            </form>
            <?php
            if(isset($_POST['complete'])){
              require_once("orderIncludes/orderComplete.php");
            }
            ?>
          </div>
          <?php } ?>
          <?php } ?>
        </div>
      </div>

    </div>
    <?php }elseif($status == "revision"){ ?>
      <div class="message-content-card-item d-flex flex-column">
        <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
          <div class="image-icon">
            <img class="img-fluid d-block" src="assets/img/order/box-icon.png" />
          </div>
          <?php 
          $remain = $order_complete_time->diff(new DateTime());
          if($remain->d < 1){ $remain->d = 1; }
          ?> 
          <h5 class="text-center">Revison Request</h5>
          <p><i class="fa fa-pencil-square-o"></i> Revison Requested By <?php echo $seller_user_name; ?></p>
        </div>
        <div class="d-flex flex-row align-items-start">
          <div class="user-image">
            <?php if(!empty($seller_image)){ ?>
            <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>"  width="60" height="60" class="message-image" />
            <?php }else{ ?>
              <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
            <?php } ?>
          </div>
          <div class="messages-text d-flex flex-column">
            <div class="username d-flex flex-row align-items-start justify-content-between">
              <span><?php echo $seller_user_name; ?></span>
              <span class="timestamp"><?php echo $date; ?></span>
            </div>
            <p><?php echo $message; ?></p>
            <?php if(!empty($file)){ ?>
            <h5>Delivered Files</h5>
            <div class="file-attachment d-flex flex-row align-items-center">
              <span><i class="fas fa-arrow-circle-down"></i></span>
              <a href="order_files/<?php echo $file; ?>" download><span class="file-name"><?php echo $file; ?></span></a>
              <!-- <span>(602kb)</span> -->
            </div>
            <?php } ?>
          </div>
        </div>
      </div>

    <!-- <div class="card mt-4">
      <div class="card-body">
        <h5 class="text-center"><i class="fa fa-pencil-square-o"></i> Revison Requested By <?php echo $seller_user_name; ?> </h5>
      </div>
    </div>
    <div class="
      <?php
      if($sender_id == $login_seller_id){
        
      echo "message-div-hover";
        
      }else{
        
      echo "message-div";
        
      }
      ?>">
      <?php if(!empty($seller_image)){ ?>
      <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="50" height="50" class="message-image">
      <?php }else{ ?>
      <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="message-image">
      <?php } ?>
      
      <h5><a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a></h5>
      <p class="message-desc">
        <?php echo $message; ?>
        <?php if(!empty($file)){ ?>
        <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>
          <i class="fa fa-download"></i> <?php echo $file; ?>
        </a>
        <?php }else{ ?>
        <?php } ?>
      </p>
      <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>
      </div> -->

      <?php }elseif($status == "cancellation_request"){ ?>
        <div class="message-content-card-item d-flex flex-column">
          <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
            <div class="image-icon">
              <i class="fal fa-exclamation-circle"></i>
            </div>
            <?php 
            $remain = $order_complete_time->diff(new DateTime());
            if($remain->d < 1){ $remain->d = 1; }
            ?> 
            <h5 class="text-center">Order Request</h5>
            <p><i class="fa fa-trash-o"></i> Cancellation Requested By <?php echo $seller_user_name; ?></p>
          </div>
          <div class="d-flex flex-row align-items-start">
            <div class="user-image">
              <?php if(!empty($seller_image)){ ?>
              <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>"  width="60" height="60" class="message-image" />
              <?php }else{ ?>
                <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
              <?php } ?>
            </div>
            <div class="messages-text d-flex flex-column">
              <div class="username d-flex flex-row align-items-start justify-content-between">
                <span><?php echo $seller_user_name; ?></span>
                <span class="timestamp"><?php echo $date; ?></span>
              </div>
              <p><?php echo $message; ?></p>
              
              <?php if(!empty($file)){ ?>
              <h5>Delivered Files</h5>
              <div class="file-attachment d-flex flex-row align-items-center">
                <span><i class="fas fa-arrow-circle-down"></i></span>
                <a href="order_files/<?php echo $file; ?>" download><span class="file-name"><?php echo $file; ?></span></a>
                <!-- <span>(602kb)</span> -->
              </div>
              <?php } ?>
              <div class="extend-delivery">
                <h6><?php echo $seller_user_name; ?> has requested to cancel the order.</h6>
                <!-- <p>
                  Please respond within the next 4 days,<br />or the request will be automatically withdrawn.
                </p> -->
                <!-- <table class="table">
                  <thead>
                    <tr role="row">
                      <th role="column">Item</th>
                      <th role="column">Quantity</th>
                      <th role="column">Duration</th>
                      <th role="column">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr role="row">
                      <td data-label="Item" role="column">Extended Delivery</td>
                      <td data-label="Quantity" role="column">1</td>
                      <td data-label="Duration" role="column">3 days</td>
                      <td data-label="Amount" role="column">No Change</td>
                    </tr>
                  </tbody>
                </table> -->
                <div class="d-flex flex-row justify-content-center">
                  <!-- <div class="respond">you responded to Spxmac’s request</div> -->
                </div>
                <!-- <p>20:04 April 18, 2018</p> -->
                <?php if($sender_id == $login_seller_id){ ?>
                <?php }else{ ?>
                <div class="d-flex flex-wrap justify-content-center mt-15">
                  <form method="post">
                    <button name="decline_request" class="align-items-center justify-content-center button button-white" href="javascript:void(0);">Decline Request</button>
                    <button name="accept_request" class=" align-items-center justify-content-center button button-red">Accept Request</button>
                  </form>
                </div>
              </div>
              
             


      

<?php

if(isset($_POST['accept_request'])){

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try{
  if($enable_smtp == "yes"){
  $mail->isSMTP();
  $mail->Host = $s_host;
  $mail->Port = $s_port;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = $s_secure;
  $mail->Username = $s_username;
  $mail->Password = $s_password;
  }
  $mail->setFrom($site_email_address,$site_name);
  $mail->addAddress($seller_email);
  $mail->addReplyTo($site_email_address,$site_name);
  $mail->isHTML(true);
  $mail->Subject = "$site_name: Order Has Been Cancelled.";
  $mail->Body = "
  <html>
  <head>
  <style>
   .container {
        background: rgb(238, 238, 238);
        padding: 80px;
      }
      @media only screen and (max-device-width: 690px) {
      .container {
        background: rgb(238, 238, 238);
      width:100%;
      padding:1px;
      }
      }
      .box {
        background: #fff;
        margin: 0px 0px 30px;
        padding: 8px 20px 20px 20px;
        border:1px solid #e6e6e6;
        box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
      }
      h2 {
      margin-top: 0px;
      margin-bottom: 10px;
      }
      .lead {
      margin-top: 0px;
      font-size:16px;
      }
      .btn{
        background:green;
        margin-top:20px;
        color:white !important;
        text-decoration:none;
        padding:10px 16px;
        font-size:18px;
        border-radius:3px;
      }
      hr{
        margin-top:10px;
        margin-bottom:20px;
        border:1px solid #eee;
      }
     @media only screen and (max-device-width: 690px) {
      .container {
      background: rgb(238, 238, 238);
      width:100%;
      padding:1px;
      }
      .btn{
        background:green;
        margin-top:15px;
        color:white !important;
        text-decoration:none;
        padding:10px;
        font-size:14px;
        border-radius:3px;
      }
      .lead {
      font-size:14px;
      }
      }
  </style>
  </head>
  <body class='is-responsive'>
  <div class='container'>
  <div class='box'>
  <center>
  <img class='logo' src='$site_url/images/$site_logo' width='100' >
  <h2> Hi Dear $seller_user_name </h2>
  <p class='lead'> Your Order Has Been Cancelled And All Funds Returned To Buyer. </p>
  <hr>
  <a href='$site_url/order_details?order_id=$order_id' class='btn'>
  Click Here To View Order
  </a>
  </center>
  </div>
  </div>
  </body>
  </html>
  ";
  $mail->send();
}catch(Exception $e){
  // 
}

$mail = new PHPMailer(true);
try{
  if($enable_smtp == "yes"){
  $mail->isSMTP();
  $mail->Host = $s_host;
  $mail->Port = $s_port;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = $s_secure;
  $mail->Username = $s_username;
  $mail->Password = $s_password;
  }

  $mail->setFrom($site_email_address,$site_name);
  $mail->addAddress($buyer_email);
  $mail->addReplyTo($site_email_address,$site_name);
  $mail->isHTML(true);

  $mail->Subject = "$site_name: Order Has Been Cancelled.";

  $mail->Body = "

  <html>

  <head>

  <style>

  .container {
  background: rgb(238, 238, 238);
  padding: 80px;

  }

  @media only screen and (max-device-width: 690px) {

  .container {
  background: rgb(238, 238, 238);
  width:100%;
  padding:1px;

  }

  }

  .box {
  background: #fff;
  margin: 0px 0px 30px;
  padding: 8px 20px 20px 20px;
  border:1px solid #e6e6e6;
  box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      

  }

  h2 {

  margin-top: 0px;
  margin-bottom: 10px;

  }

  .lead {
  margin-top: 0px;
  font-size:16px;

  }

  .btn{
  background:green;
  margin-top:20px;
  color:white !important;
  text-decoration:none;
  padding:10px 16px;
  font-size:18px;
  border-radius:3px;

  }

  hr{
  margin-top:10px;
  margin-bottom:20px;
  border:1px solid #eee;

  }


  @media only screen and (max-device-width: 690px) {

  .container {
  background: rgb(238, 238, 238);
  width:100%;
  padding:1px;

  }

  .btn{
  background:green;
  margin-top:15px;
  color:white !important;
  text-decoration:none;
  padding:10px;
  font-size:14px;
  border-radius:3px;

  }

  .lead {

  font-size:14px;

  }

  }

  </style>

  </head>

  <body class='is-responsive'>


  <div class='container'>

  <div class='box'>

  <center>

  <img class='logo' src='$site_url/images/$site_logo' width='100' >

  <h2> Hi Dear $buyer_user_name </h2>

  <p class='lead'> Your Order Has Been Cancelled And All Funds Returned To Your Shopping Balance. </p>

  <hr>

  <a href='$site_url/order_details?order_id=$order_id' class='btn'>

  Click Here To View Order

  </a>

  </center>

  </div>

  </div>


  </body>

  </html>

  ";

  $mail->send();

}catch(Exception $e){
  // 
}

$update_messages = $db->update("order_conversations",array("status"=>"accept_cancellation_request"),array("order_id"=>$order_id,"status"=>"cancellation_request"));


$update_order = $db->update("orders",array("order_status"=>'cancelled',"order_active"=>'no'),array("order_id"=>$order_id));

$insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "accept_cancellation_request","date" => $n_date,"status" => "unread"));
	

$update_my_buyers = $db->update("my_buyers",array("completed_orders"=>'completed_orders-1',"amount_spent"=>"amount_spent-$order_price"),array("buyer_id"=>$buyer_id,"seller_id"=>$seller_id));


$update_my_sellers = $db->update("my_sellers",array("completed_orders"=>'completed_orders-1',"amount_spent"=>"amount_spent-$order_price"),array("seller_id"=>$seller_id,"buyer_id"=>$buyer_id));


$purchase_date = date("F d, Y");

$insert_purchase = $db->insert("purchases",array("seller_id" => $buyer_id,"order_id" => $order_id,"amount" => $order_price,"date" => $purchase_date,"method" => "order_cancellation"));

$update_seller_account = $db->query("update seller_accounts set used_purchases=used_purchases-:minus,current_balance=current_balance+:plus where seller_id='$buyer_id'",array("minus"=>$order_price,"plus"=>$order_price));

echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
	
}


if(isset($_POST['decline_request'])){

$update_messages = $db->update("order_conversations",array("status"=>"decline_cancellation_request"),array("order_id"=>$order_id,"status"=>"cancellation_request"));


$update_order = $db->update("orders",array("order_status"=>'progress'),array("order_id"=>$order_id));


$insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "decline_cancellation_request","date" => $n_date,"status" => "unread"));

echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";

}


?>

<?php } ?>

<!-- <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p> -->
  </div>
      </div>
    </div>
  </div>
<!--- message-div Ends --->


<?php }elseif($status == "decline_cancellation_request"){ ?>

  <div class="message-content-card-item d-flex flex-column">
    <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
      <div class="image-icon">
        <img class="img-fluid d-block" src="assets/img/order/box-icon.png" />
      </div>
      <?php 
      $remain = $order_complete_time->diff(new DateTime());
      if($remain->d < 1){ $remain->d = 1; }
      ?> 
      <h5 class="text-center">Request Declined</h5>
      <p>You rejected <?php echo $seller_user_name; ?> offer for resolution</p>
    </div>
    <div class="d-flex flex-row align-items-start">
      <div class="user-image">
        <?php if(!empty($seller_image)){ ?>
        <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>"  width="60" height="60" class="message-image" />
        <?php }else{ ?>
          <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
        <?php } ?>
      </div>
      <div class="messages-text d-flex flex-column">
        <div class="username d-flex flex-row align-items-start justify-content-between">
          <span><?php echo $seller_user_name; ?></span>
          <span class="timestamp"><?php echo $date; ?></span>
        </div>
        <p><?php echo $message; ?></p>
        <?php if(!empty($file)){ ?>
        <h5>Delivered Files</h5>
        <div class="file-attachment d-flex flex-row align-items-center">
          <span><i class="fas fa-arrow-circle-down"></i></span>
          <a href="order_files/<?php echo $file; ?>" download><span class="file-name"><?php echo $file; ?></span></a>
          <!-- <span>(602kb)</span> -->
        </div>
        <?php } ?>
        <div class="extend-delivery">
          <h6><?php echo $seller_user_name; ?> has requested to cancel the order.</h6>
          <!-- <p>
            Please respond within the next 4 days,<br />or the request will be automatically withdrawn.
          </p> -->
          <!-- <table class="table">
            <thead>
              <tr role="row">
                <th role="column">Item</th>
                <th role="column">Quantity</th>
                <th role="column">Duration</th>
                <th role="column">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr role="row">
                <td data-label="Item" role="column">Extended Delivery</td>
                <td data-label="Quantity" role="column">1</td>
                <td data-label="Duration" role="column">3 days</td>
                <td data-label="Amount" role="column">No Change</td>
              </tr>
            </tbody>
          </table> -->
          <div class="d-flex flex-row justify-content-center">
            <div class="respond">Cancellation Request Declined By <?php echo $receiver_name; ?></div>
          </div>
          <!-- <p>20:04 April 18, 2018</p> -->
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="message-content-card-item d-flex flex-column">
    <div class="d-flex flex-wrap justify-content-start mt-15">
      <h5 class="text-danger"><i class="fa fa-times fa-3x text-danger"></i>
        Cancellation Request Declined By <?php echo $receiver_name; ?>
      </h5>
    </div>
  </div> -->

  <!-- <div class="card mt-4">
    <div class="card-body">
      <h5 class="text-center"><i class="fa fa-trash-o"></i> Cancellation Request Declined By <?php echo $seller_user_name; ?></h5>
    </div>
  </div>
  <div class="
    <?php
    if($sender_id == $login_seller_id){
      
    echo "message-div-hover";
      
    }else{
      
    echo "message-div";
      
    }
    ?>
    ">
    <?php if(!empty($seller_image)){ ?>
    <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="50" height="50" class="message-image">
    <?php }else{ ?>
    <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="message-image">
    <?php } ?>
    
    <h5>
    <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>
    </h5>
    <p class="message-desc">
      <?php echo $message; ?>
      <?php if(!empty($file)){ ?>
      <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>
        <i class="fa fa-download"></i> <?php echo $file; ?>
      </a>
      <?php }else{ ?>
      <?php } ?>
    </p>
    <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>
    </div>
    <div class="order-status-message">
    <i class="fa fa-times fa-3x text-danger"></i>
    <h5 class="text-danger">
    Cancellation Request Declined By <?php echo $receiver_name; ?>
    </h5>
    </div> -->
    <?php }elseif($status == "accept_cancellation_request"){ ?>

    <div class="message-content-card-item d-flex flex-column">
      <div class="d-flex flex-column align-items-center justify-content-center message-requirements">
        <div class="image-icon">
          <img class="img-fluid d-block" src="assets/img/order/accepted-icon.png" />
        </div>
        <h5 class="text-center">Resoultion Accepted</h5>
        <p>You accepted <?php echo $seller_user_name; ?> offer for resolution.</p>
      </div>
      <div class="d-flex flex-row align-items-start">
        <div class="user-image">
          <?php if(!empty($seller_image)){ ?>
          <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>"  width="60" height="60" class="message-image" />
          <?php }else{ ?>
            <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
          <?php } ?>
        </div>
        <div class="messages-text d-flex flex-column">
          <div class="username d-flex flex-row align-items-start justify-content-between">
            <span><?php echo $seller_user_name; ?></span>
            <span class="timestamp"><?php echo $date; ?></span>
          </div>
          <p><?php echo $message; ?></p>
          <?php if(!empty($file)){ ?>
          <h5>Delivered Files</h5>
          <div class="file-attachment d-flex flex-row align-items-center">
            <span><i class="fas fa-arrow-circle-down"></i></span>
            <a href="order_files/<?php echo $file; ?>" download><span class="file-name"><?php echo $file; ?></span></a>
            <!-- <span>(602kb)</span> -->
          </div>
          <?php } ?>
          <div class="extend-delivery">
            <h6><?php echo $seller_user_name; ?> has requested to cancel the order.</h6>
            <!-- <p>
              Please respond within the next 4 days,<br />or the request will be automatically withdrawn.
            </p> -->
            <!-- <table class="table">
              <thead>
                <tr role="row">
                  <th role="column">Item</th>
                  <th role="column">Quantity</th>
                  <th role="column">Duration</th>
                  <th role="column">Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr role="row">
                  <td data-label="Item" role="column">Extended Delivery</td>
                  <td data-label="Quantity" role="column">1</td>
                  <td data-label="Duration" role="column">3 days</td>
                  <td data-label="Amount" role="column">No Change</td>
                </tr>
              </tbody>
            </table> -->
            <div class="d-flex flex-row justify-content-center">
              <?php if($seller_id == $login_seller_id){ ?>
              <div class="message-content-card-item d-flex flex-column">
                <div class="d-flex flex-wrap justify-content-center mt-15 respond" style="height: auto;">
                  <h5 class="text-danger"><i class="fa fa-times fa-2x text-danger"></i> Order Cancelled By Mutual Agreement. </h5>
                  <p>
                  Order Was Cancelled By A Mutual Agreement Between You and Your Buyer. <br>
                  Funds have been refunded to buyer's account.
                  </p>
                </div>
              </div>
              <?php }else{ ?>
              <div class="message-content-card-item d-flex flex-column">
                <div class="d-flex flex-wrap justify-content-center mt-15 respond" style="height: auto;">
                  <h5 class="text-danger"><i class="fa fa-times fa-2x text-danger"></i> Order Cancelled By Mutual Agreement. </h5>
                  <p>
                    Order was cancelled by a mutual agreement between you and your seller.<br>
                    The order funds have been refunded to your Shopping Balance.
                  </p>
                </div>
              </div>
              <?php } ?>
              <!-- <div class="respond">Cancellation Request Declined By <?php echo $receiver_name; ?></div> -->
            </div>
            <!-- <p>20:04 April 18, 2018</p> -->
          </div>
        </div>
      </div>
    </div>
    


    <!-- <div class="card mt-4">
      <div class="card-body">
        <h5 class="text-center"><i class="fa fa-trash-o"></i> Cancellation Request By <?php echo $seller_user_name; ?></h5>
      </div>
    </div>
    <div class="
      <?php
      if($sender_id == $login_seller_id){
        
      echo "message-div-hover";
        
      }else{
        
      echo "message-div";
        
      }
      ?>
      ">
      <?php if(!empty($seller_image)){ ?>
      <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="50" height="50" class="message-image">
      <?php }else{ ?>
      <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="message-image">
      <?php } ?>
      
      <h5>
      <a href="#" class="seller-buyer-name"> <?php echo $seller_user_name; ?> </a>
      </h5>
      <p class="message-desc">
        <?php echo $message; ?>
        <?php if(!empty($file)){ ?>
        <a href="order_files/<?php echo $file; ?>" class="d-block mt-2 ml-1" download>
          <i class="fa fa-download"></i> <?php echo $file; ?>
        </a>
        <?php }else{ ?>
        <?php } ?>
      </p>
      <p class="text-right text-muted mb-0"> <?php echo $date; ?> </p>
      </div>
      <?php if($seller_id == $login_seller_id){ ?>
      <div class="order-status-message">
      <i class="fa fa-times fa-3x text-danger"></i>
      <h5 class="text-danger"> Order Cancelled By Mutual Agreement. </h5>
      <p>
        Order Was Cancelled By A Mutual Agreement Between You and Your Buyer. <br>
        Funds have been refunded to buyer's account.
      </p>
      </div>
      <?php }else{ ?>
      <div class="order-status-message">
      <i class="fa fa-times fa-3x text-danger"></i>
      <h5 class="text-danger"> Order Cancelled By Mutual Agreement. </h5>
      <p>
        Order was cancelled by a mutual agreement between you and your seller.<br>
        The order funds have been refunded to your Shopping Balance.
      </p>
      </div>
      <?php } ?> -->

      <?php }elseif($status == "cancelled_by_customer_support"){ ?>

      <?php if($seller_id == $login_seller_id){ ?>
      <div class="message-content-card-item d-flex flex-column">
        <div class="d-flex flex-wrap justify-content-start mt-15">
          <h5 class="text-danger">Order Cancelled By Admin. </h5>
          <p>
          Payment For This Order Was Refunded To Buyer's Shopping Balance. <br>
          For Any Further Assistance, Please Contact Our <a href="/customer_support.php" class="link">
          Customer Support.</a>
          </p>
        </div>
      </div>
      <?php }else{ ?>
      <div class="message-content-card-item d-flex flex-column">
        <div class="d-flex flex-wrap justify-content-start mt-15">
          <h5 class="text-danger">Order Cancelled By Customer Support. </h5>
          <p>
            Payment For This Order Has Been Refunded To Your
        <a href="revenue.php" class="link"> Shopping balance. </a>.
          </p>
        </div>
      </div>
      <?php } ?>


      <!-- <?php if($seller_id == $login_seller_id){ ?>
      <div class="order-status-message">
      <i class="fa fa-times fa-3x text-danger"></i>
      <h5 class="text-danger"> Order Cancelled By Admin. </h5>
      <p>
        Payment For This Order Was Refunded To Buyer's Shopping Balance. <br>
        For Any Further Assistance, Please Contact Our <a href="/customer_support.php" class="link">
        Customer Support.</a>
      </p>
      </div>
      <?php }else{ ?>
      <div class="order-status-message">
      <i class="fa fa-times fa-3x text-danger"></i>
      <h5 class="text-danger"> Order Cancelled By Customer Support. </h5>
      <p>
        Payment For This Order Has Been Refunded To Your
        <a href="revenue.php" class="link"> Shopping balance. </a>.
      </p>
      </div> -->

<?php } ?>

<?php } ?>

<?php } ?>
