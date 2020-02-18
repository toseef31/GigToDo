<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php if($seller_id == $login_seller_id){ ?>
<div id="deliver-order-modal" class="modal fade">
  <!--- deliver-order-modal Starts --->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Deliver Your Order Now </h5>
        <button class="close" data-dismiss="modal"> <span>&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="font-weight-bold" > Message </label>
            <textarea name="delivered_message" placeholder="Type Your Message Here..." class="form-control mb-2"></textarea>
          </div>
          <div class="form-group clearfix">
            <input type="file" name="delivered_file" class="mt-1">
            <input type="submit" name="submit_delivered" value="Deliver Order" class="btn btn-success float-right">
          </div>
        </form>
        <?php
          if(isset($_POST['submit_delivered'])){
          $d_message = $input->post('delivered_message');
          $d_file = $_FILES['delivered_file']['name'];
          $d_file_tmp = $_FILES['delivered_file']['tmp_name'];
          $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
          $file_extension = pathinfo($d_file, PATHINFO_EXTENSION);
          if(!in_array($file_extension,$allowed) & !empty($d_file)){
            echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
            echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
          }else{
            move_uploaded_file($d_file_tmp,"order_files/$d_file");
            $last_update_date = date("h:m: M d Y");
            $update_messages = $db->update("order_conversations",array("status" => "message"),array("order_id" => $order_id,"status" => "delivered"));
            $insert_delivered_message = $db->insert("order_conversations",array("order_id" => $order_id,"sender_id" => $seller_id,"message" => $d_message,"file" => $d_file,"date" => $last_update_date,"status" => "delivered"));
            if($insert_delivered_message){
              $insert_notification = $db->insert("notifications",array("receiver_id" => $buyer_id,"sender_id" => $seller_id,"order_id" => $order_id,"reason" => "order_delivered","date" => $n_date,"status" => "unread"));
              $site_logo = $row_general_settings->site_logo;
              $order_auto_complete = $row_general_settings->order_auto_complete;
              $date_time = date("M d, Y H:i:s");
              $complete_time = date("M d, Y H:i:s",strtotime($date_time." + $order_auto_complete days"));
              $update_order = $db->update("orders",array("order_status" => "delivered","complete_time" => $complete_time),array("order_id" => $order_id));

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
                $mail->addAddress($buyer_email);
                $mail->addReplyTo($site_email_address,$site_name);
                $mail->isHTML(true);
                $mail->Subject = "$site_name: Congrats! $login_seller_user_name has delivered your order.";
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
                .lead {
                  font-size:16px;
                }
                .btn{
                  background:green;
                  margin-top:50px;
                  color:white !important;
                  text-decoration:none;
                  padding:10px 16px;
                  font-size:18px;
                  border-radius:3px;
                }
                hr{
                  margin-top:20px;
                  margin-bottom:20px;
                  border:1px solid #eee;
                }
                </style>
                </head>
                <body class='is-responsive'>
                <div class='container'>
                <div class='box'>
                <center>
                <img src='$site_url/images/$site_logo' width='100' >
                <h2> $login_seller_user_name has delivered your order. </h2>
                </center>
                <hr>
                <p class='lead'> Dear $login_seller_user_name, </p>
                <p class='lead'> $d_message </p><br>
                <center>
                <a href='$site_url/order_details?order_id=$order_id' class='btn'>
                View Your Order
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
              echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
            }
          }
          }
          ?>
      </div>
    </div>
  </div>
</div>
<?php }elseif($buyer_id == $login_seller_id){ ?>
<div id="revision-request-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Submit Your Revision Request Here </h5>
        <button class="close" data-dismiss="modal"> <span>&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="font-weight-bold" > Request Message </label>
            <textarea name="revison_message" placeholder="Type Your Message Here..." class="form-control mb-2" required=""></textarea>
          </div>
          <div class="form-group clearfix">
            <input type="file" name="revison_file" class="mt-1">
            <input type="submit" name="submit_revison" value="Submit Request" class="btn btn-success float-right">
          </div>
        </form>
        <?php
          if(isset($_POST['submit_revison'])){
          $revison_message = $input->post('revison_message');
          $revison_file = $_FILES['revison_file']['name'];
          $revison_file_tmp = $_FILES['revison_file']['tmp_name'];
          $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
          $file_extension = pathinfo($revison_file, PATHINFO_EXTENSION);
          if(!in_array($file_extension,$allowed) & !empty($revison_file)){
          echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
          echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
          }else{
          move_uploaded_file($revison_file_tmp,"order_files/$revison_file");
          $last_update_date = date("h:i: M d, Y");
          $update_messages = $db->update("order_conversations",array("status"=>"message"),array("order_id" => $order_id,"status" => "delivered"));
          $insert_revision_message = $db->insert("order_conversations",array("order_id"=>$order_id,"sender_id"=>$buyer_id,"message"=>$revison_message,"file"=>$revison_file,"date"=>$last_update_date,"status" =>"revision"));
          if($insert_revision_message){
          $insert_notification = $db->insert("notifications",array("receiver_id" => $seller_id,"sender_id" => $buyer_id,"order_id" => $order_id,"reason" => "order_revision","date" => $n_date,"status" => "unread"));
          $update_order = $db->update("orders",array("order_status"=>"revision requested"),array("order_id"=>$order_id));

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
            $mail->Subject = "$site_name - Revison Requested By $buyer_user_name";
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
            .lead {
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
              margin-top:20px;
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
            margin-top:25px;
            color:white !important;
            text-decoration:none;
            padding:10px;
            font-size:14px;
            border-radius:3px;
            }
            .lead { font-size:14px; }
            }
            </style>
            </head>
            <body class='is-responsive'>
            <div class='container'>
            <div class='box'>
            <center>
            <img class='logo' src='$site_url/images/$site_logo' width='100' >
            <h2> Revison Request For Your Order. </h2>
            </center>
            <hr>
            <p class='lead'> Dear $seller_user_name </p>
            <p class='lead'> You just received an revision request from $buyer_user_name for your order. </p>
            <br>
            <center>
            <a href='$site_url/order_details?order_id=$order_id' class='btn'>Click to view order</a>
            </center>
            </div>
            </div>
            </body>
            </html>";
            $mail->send();
            echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
          }catch(Exception $e){
            // 
          }

          }
          }
          }
          ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
