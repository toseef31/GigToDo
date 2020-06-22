<?php
	session_start();
	require_once("../../includes/db.php");
	require_once("../../functions/functions.php");
	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('../../login','_self')</script>";
	}

	$login_seller_user_name = $_SESSION['seller_user_name'];
	
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_account_type = $row_login_seller->account_type;


	$message_group_id = $input->post('message_group_id');

	$get_inbox_sellers = $db->select("inbox_sellers",array("message_group_id"=>$message_group_id));
	$row_inbox_sellers = $get_inbox_sellers->fetch();
	$offer_id = $row_inbox_sellers->offer_id;
	$sender_id = $row_inbox_sellers->sender_id;
	$receiver_id = $row_inbox_sellers->receiver_id;
	$message_status = $row_inbox_sellers->message_status;
	
	if($login_seller_id == $sender_id){
	
	$seller_id = $receiver_id;
	
	}else{
	
	$seller_id = $sender_id;
	
	}

	$count_active_proposals = $db->count("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));

	$select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
	$row_seller = $select_seller->fetch();
	$seller_account_type = $row_seller->account_type;
	$seller_image = @$row_seller->seller_image;
	$seller_user_name = @$row_seller->seller_user_name;
	$seller_status = @$row_seller->seller_status;


	if(check_status($seller_id) == "Online"){
		$statusClass = " font-weight-bold active";
	}else{	
		$statusClass = "text-muted font-weight-bold"; 
	}

	$date = date("M d, h:i A");


	$select_starred = $db->select("starred_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));

	$count_starred = $select_starred->rowCount();

	if($count_starred == 1){ 

	$star = "unstar"; 
	
	$star_i = "fa-star"; 

	}else{ 

	$star = "star"; 

	$star_i = "fa-star-o"; 

	}



	$select_unread = $db->select("unread_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));

	$count_unread = $select_unread->rowCount();

	if($count_unread == 1){ 

	$unread = "read"; 

	$unread_i = "fa-envelope-o";

	}else{ 

	$unread = "unread";

	$unread_i = "fa-envelope-open-o";

	}



	$select_archived = $db->select("archived_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));

	$count_archived = $select_archived->rowCount();

	if($count_archived == 1){ 

	$archive = "unarchive"; 
	
	$archive_i = "fa-upload";

	}else{ 

	$archive = "archive"; 

	$archive_i = "fa-download";

	}


?>
<div class="message-body-header d-flex flex-wrap align-items-center justify-content-between">
	<p class="user-status d-flex flex-column bg-white <?php echo $statusClass; ?>">
		<?php if ($seller_account_type == "seller") { ?>
		<a href="<?= $site_url; ?>/<?= $seller_user_name; ?>" style="display: contents;">
			<i class="fal fa-angle-left"></i>
			<span class="username"><?php echo ucfirst(strtolower($seller_user_name)); ?></span>
			<?php if (check_status($seller_id) == "Online") { ?>
				<span class="text-success">Online</span>
			<?php }else{ ?>
				<span class="timestamp">Last seen <?php echo $date; ?> ago</span>
			<?php } ?>
		</a>
		<?php }else{ ?>
			<a href="<?= $site_url; ?>/profile?user_name=<?= $seller_user_name; ?>" style="display: contents;">
				<i class="fal fa-angle-left"></i>
				<span class="username"><?php echo ucfirst(strtolower($seller_user_name)); ?></span>
				<?php if (check_status($seller_id) == "Online") { ?>
					<span class="text-success">Online</span>
				<?php }else{ ?>
					<span class="timestamp">Last seen <?php echo $date; ?> ago</span>
				<?php } ?>
			</a>
		<?php } ?>
	</p>
	<p class="float-right">

	<?php if($message_status != "empty"){ ?>

		<a href="inbox<?php echo "?$star=$message_group_id"; ?>" class="btn <?=$star;?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo ucfirst($star); ?>">

			<i class="fa <?=$star_i;?>"></i>
		
		</a>

		<a href="inbox<?php echo "?$unread=$message_group_id"; ?>" class="btn unread" data-toggle="tooltip" data-placement="bottom" title="Mark As <?php echo ucfirst($unread); ?>">

			<i class="fa <?=$unread_i;?>"></i>

		</a>

		<a href="inbox<?php echo "?$archive=$message_group_id"; ?>" class="btn <?=$archive;?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo ucfirst($archive); ?>">

			<i class="fa <?=$archive_i;?>"></i>
			
		</a>

		<a href="inbox?hide_seller=<?php echo $seller_id; ?>" class="btn" data-toggle="tooltip" data-placement="bottom" title="Delete">
			<i class="fa fa-trash-o"></i>
		</a>

		<?php } ?>
		
		<div class="dropdown float-right d-block d-sm-block d-md-none mt-2">
			
			<a class="dropdown-toggle closeMsgIcon" href="#" role="button" data-toggle="dropdown">
				
				<i class="mr-3 fa fa-2x fa-ellipsis-v"></i>
			
			</a>

			<div class="dropdown-menu pt-1 pb-1" style="margin-right: 15px; max-width: 30px !important; min-width: 150px !important; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 38px, 0px);" x-placement="bottom-start">
				
				<a href="inbox?hide_seller=<?php echo $sender_id; ?>" class="dropdown-item">
				<i class="fa fa-trash-o"></i> Delete
				</a>

				<a href="#" class="dropdown-item closeMsg">
				<i class="fa fa-times"></i> Close
				</a>

			</div>
		</div>
	</p>
	<?php if($login_seller_account_type != 'buyer'){ ?>
	<?php if($count_active_proposals > 0){ ?>

	<button type="button" id="send-offer" class="offer-hire-button">Create An Offer</button>
	<?php } } else{ ?>
		<a class="offer-hire-button" data-toggle="modal" data-target="#custom_order">hire freelancer</a>
	<?php } ?>
	<!-- <a class="offer-hire-button" data-toggle="modal" href="#exampleModalCenter">Custom Offer</a> -->
</div>

<!-- <p class="float-left pb-0 mb-0">
	
	<strong class="ml-0 pl-0"><?php echo ucfirst(strtolower($seller_user_name)); ?></strong>
	
	<br>
	
	<span class="text-muted">

	<span <?php echo $statusClass; ?>><?php echo check_status($seller_id); ?></span> 
	
	| Local Time <i class="fa fa-clock-o"></i> <?php echo $date; ?>
	
	</span>

</p> -->

<!-- <p class="float-right">

<?php if($message_status != "empty"){ ?>

	<a href="inbox<?php echo "?$star=$message_group_id"; ?>" class="btn <?=$star;?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo ucfirst($star); ?>">

		<i class="fa <?=$star_i;?>"></i>
	
	</a>

	<a href="inbox<?php echo "?$unread=$message_group_id"; ?>" class="btn unread" data-toggle="tooltip" data-placement="bottom" title="Mark As <?php echo ucfirst($unread); ?>">

		<i class="fa <?=$unread_i;?>"></i>

	</a>

	<a href="inbox<?php echo "?$archive=$message_group_id"; ?>" class="btn <?=$archive;?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo ucfirst($archive); ?>">

		<i class="fa <?=$archive_i;?>"></i>
		
	</a>

	<a href="inbox?hide_seller=<?php echo $seller_id; ?>" class="btn" data-toggle="tooltip" data-placement="bottom" title="Delete">
		<i class="fa fa-trash-o"></i>
	</a>

	<?php } ?>
	
	<div class="dropdown float-right d-block d-sm-block d-md-none mt-2">
		
		<a class="dropdown-toggle closeMsgIcon" href="#" role="button" data-toggle="dropdown">
			
			<i class="mr-3 fa fa-2x fa-ellipsis-v"></i>
		
		</a>

		<div class="dropdown-menu pt-1 pb-1" style="margin-right: 15px; max-width: 30px !important; min-width: 150px !important; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 38px, 0px);" x-placement="bottom-start">
			
			<a href="inbox?hide_seller=<?php echo $sender_id; ?>" class="dropdown-item">
			<i class="fa fa-trash-o"></i> Delete
			</a>

			<a href="#" class="dropdown-item closeMsg">
			<i class="fa fa-times"></i> Close
			</a>

		</div>
	</div>
</p> -->
<!-- Modal -->
<div class="modal fade" id="custom_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered customer-order" role="document">
    <div class="modal-content">
      <div class="modal-header align-items-center">
        <h5 class="modal-title" id="exampleModalCenterTitle">Request a Quote</h5>
        <a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
          <img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png" />
        </a>
      </div>
      <div class="modal-body">
        <div class="customer-profile d-flex align-items-start align-items-md-center">
          <div class="profile-img">
            <?php if(!empty($get_seller_image)){ ?>
            <img src="user_images/<?= $get_seller_image; ?>" alt="profile" class="rounded-circle">
            <?php }else { ?>
            <img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="profile">
            <?php } ?>
          </div>
          <div class="profile-content media-body">
            <h6 class="profile-name"><?= ucfirst($seller_user_name); ?></h6>
            <p class="texts">Hi. please provide your request details below and i’ll get back to you.</p>
          </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="control-label d-flex align-items-start">
              <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-1.png" alt="Icon"></span>
              <span>Describe the service you’re looking to purchase</span>
            </label>
            <textarea class="form-control" id="textarea" name="request_description" placeholder="I’m looking for..." rows="5"></textarea>
            <div class="bottom-label d-flex flex-row align-items-center justify-content-between mb-30 mt-15">
              <div class="attach-file d-flex flex-row align-items-center">
                <label for="file">
                  <input type="file" id="file" name="request_file" hidden="">
                  <span class="file d-flex flex-row align-items-center">
                    <span><img src="<?= $site_url; ?>/assets/img/post-request/attach.png" alt=""></span>
                    <span>Attach File</span>
                  </span>
                </label>
                <span id="file_name"></span>
                <span class="max-size">Max Size 30MB</span>
              </div>
              <span class="chars-max"><span class="descCount">0</span>/2500 Chars Max</span>
            </div>
          </div>
          <div class="form-group">
            <div class="control-label d-flex align-items-start">
              <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-2.png" alt="Icon"></span>
              <span>Choose a category</span>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mb-30 sub_cat">
                <select name="cat_id" class="form-control" id="category" style="display: block !important;">
                  <option value="" class="hidden"> Select A Category </option>
                <?php 
                // $db->select("proposals",array("proposal_seller_id"=>$get_seller_id,"proposal_status" => "active"));
                // $select_proposal = $db->query("select DISTINCT(proposal_cat_id) from proposals where proposal_seller_id = '$get_seller_id' AND proposal_status = 'active'");
                // $i=0;
                // $d_proposal_cat_id = array();

                // while($row_proposal = $select_proposal->fetch()){
                //   $d_proposal_cat_id['proposal_cat_id'][] = $row_proposal->proposal_cat_id;
                //   $proposal[$i] =
                //     $row_proposal;

                //   $proposal_cat = array($proposal[0]->proposal_cat_id);
                  
                  
                //   $propsal_cats_id = ($d_proposal_cat_id['proposal_cat_id']);
                //   $cat_array = array_unique(($propsal_cats_id[$i]));
                 
                

                $get_cats = $db->select("categories");
                while($row_cats = $get_cats->fetch()){
                $cat_id = $row_cats->cat_id;
                $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
                $row_meta = $get_meta->fetch();
                $cat_title = $row_meta->cat_title;
                ?>
                  <option value="<?= $cat_id; ?>"> <?= $cat_title; ?> </option>
                <?php  } ?>
                </select>
              </div>
              <div class="col-12 col-sm-6 mb-30 sub_cat">
                <select class="form-control" name="child_id" id="sub-category" required="">
                  
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="control-label d-flex align-items-start">
              <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-3.png" alt="Icon"></span>
              <span>When would you like your Service Delivered?</span>
            </div>
            <div class="deliver-time d-flex flex-wrap mb-15">
              <?php
                $get_delivery_times = $db->select("delivery_times");
                while($row_delivery_times = $get_delivery_times->fetch()){
                $delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
                $delivery_id = $row_delivery_times->delivery_id;
              ?>
              <label class="deliver-time-item" for="hourss<?= $delivery_id; ?>">
                <input id="hourss<?= $delivery_id; ?>"  value="<?= $delivery_proposal_title; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title){ echo "checked"; } ?> type="radio" name="delivery_time" hidden />
                <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
                  <span class="color-icon">
                    <span>-</span>
                    <span>+</span>
                  </span>
                  <span class="d-flex flex-row align-items-end time">
                    <span><?= $delivery_proposal_title; ?></span>
                    <!-- <span>HRS</span> -->
                  </span>
                </div>
              </label>
            <?php } ?>
              <label class="deliver-time-item" for="days30">
                <input id="days30" type="radio" name="delivery_time" hidden />
                <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
                  <span class="color-icon">
                    <span>-</span>
                    <span>+</span>
                  </span>
                  <span class="d-flex flex-row align-items-end time">
                    <span>Custom</span>
                    <input autofocus="autofocus" class="input-number" maxlength="2" type="text" pattern="[0-9]{2}" />
                  </span>
                </div>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="control-label d-flex align-items-start">
              <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
              <span>What is your budget?</span>
            </div>
            <input class="form-control mb-30" name="request_budget" type="text" placeholder="$ 5 Minimum" />
          </div>
          <div class="form-group d-flex flex-row align-items-center justify-content-between">
            <button class="button" name="send_request" type="submit" role="button">Send a request</button>
            <button class="button-close" type="button" role="button" data-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php 

  if(isset($_POST['send_request'])){
    // $buyer_id = $login_seller_id;
    // $order_price = $input->post('order_price');
  	
    
    $request_description = $input->post('request_description');
    $cat_id = $input->post('cat_id');
    $child_id = $input->post('child_id');
    $request_budget = $input->post('request_budget');
    $delivery_time = $input->post('delivery_time');

    echo "You have selected :" .$delivery_time;
    $request_file = $_FILES['request_file']['name'];
    $request_file_tmp = $_FILES['request_file']['tmp_name'];
    // $request_date = date("F d, Y");
    $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
    $file_extension = pathinfo($request_file, PATHINFO_EXTENSION);
    if(!empty($request_file)){
      if(!in_array($file_extension,$allowed)){
        echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
        echo "<script>window.open('<?= ucfirst($get_seller_user_name); ?>','_self')</script>";
        exit();
      }
      $request_file = pathinfo($request_file, PATHINFO_FILENAME);
      $request_file = $request_file."_".time().".$file_extension";
      move_uploaded_file($request_file_tmp,"requests/request_files/$request_file");
    }
    
    $insert_request = $db->insert("messages_requests",array("sender_id"=>$login_seller_id,"receiver_id"=>$seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"request_budget"=>$request_budget,"request_status"=>'active'));
    print_r($_POST['send_request']);die();
    $last_offer_id = $db->lastInsertId();
    if($insert_request){
        $message_date = date("h:i: F d, Y");
        $dateAgo = date("Y-m-d H:i:s");
        $message_status = "unread";
        $time = time();

        $get_inbox_sellers = $db->query("select * from inbox_sellers where sender_id='$login_seller_id' and receiver_id=:r_id or sender_id=:s_id and receiver_id='$login_seller_id'",array("r_id"=>$seller_id,"s_id"=>$seller_id));
        $row_inbox_sellers = $get_inbox_sellers->fetch();
        $message_group_id = $row_inbox_sellers->message_group_id;

        $insert_message = $db->insert("inbox_messages",array("message_sender" => $login_seller_id,"message_receiver" => $seller_id,"message_offer_id" => $last_offer_id,"message_group_id" => $message_group_id,"message_desc" => $message,"message_file" => $file,"message_date" => $message_date,"dateAgo" => $dateAgo,"bell" => 'active',"message_status" => $message_status));
        $last_message_id = $db->lastInsertId();

        $update_inbox_sellers = $db->update("inbox_sellers",array("sender_id" => $login_seller_id,"receiver_id" => $seller_id,"message_status" => $message_status,"time"=>$time,"message_id" => $last_message_id,'popup'=>'1'),array("message_group_id" => $message_group_id));

        if($update_inbox_sellers){

          $select_hide_seller_messages = $db->delete("hide_seller_messages",array("hider_id"=>$login_seller_id,"hide_seller_id"=>$seller_id)); 
          $count_hide_seller_messages = $select_hide_seller_messages->rowCount();
          if($count_hide_seller_messages == 1){
          $delete_hide_seller_messages = $db->delete("hide_seller_messages",array("hider_id"=>$login_seller_id,"hide_seller_id"=>$get_seller_id)); 
          }

          $site_email_address = $row_general_settings->site_email_address;
          $site_logo = $row_general_settings->site_logo;
          $get_seller = $db->select("sellers",array("seller_id" => $get_seller_id));
          $row_seller = $get_seller->fetch();
          $seller_user_name = $row_seller->seller_user_name;
          $seller_email = $row_seller->seller_email;
          require '../vendor/autoload.php';
          
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
          $mail->Subject = "You've received a message from $login_seller_user_name";
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
          </style>
          </head>
          <body class='is-responsive'>
          <div class='container'>
          <div class='box'>
          <center>
          <img src='$site_url/images/$site_logo' width='100'>
          <h2> You've received a message from $login_seller_user_name </h2>
          </center>
          <hr>
          <p class='lead'> Dear $seller_user_name, </p>
          <p class='lead'> $login_seller_user_name left you a message in your inbox. </p>
          <p class='lead'> $message </p>
          <center>
          <a href='$site_url/conversations/inbox?single_message_id=$message_group_id' class='btn'>View & Reply</a>
          </center>
          </div>
          </div>
          </body>
          </html>";
          $mail->send();
          }catch(Exception $e){
          }
          echo "<script>window.open('inbox?single_message_id=$message_group_id','_self')</script>";
          
        }

      // echo "<script>
      //     swal({
      //       type: 'success',
      //       text: 'Your request has been submitted successfully!',
      //       timer: 3000,
      //       onOpen: function(){
      //         swal.showLoading()
      //       }
      //      }).then(function(){
      //          window.open('conversations/message?seller_id=$get_seller_id','_self');
      //       });
      // </script>";
    }
  }
?>
<!-- Customer Order Puppup END-->
<script>
	
	$('[data-toggle="tooltip"]').tooltip();

	$("#sub-category").hide();

$("#category").change(function(){
  $("#sub-category").show();  
  var category_id = $(this).val();
  $.ajax({
  url:"../fetch_subcategory",
  method:"POST",
  data:{category_id:category_id},
  success:function(data){
  $("#sub-category").html(data);
  }
  });
});
$('#file').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#file')[0].files[0].name;
  
  $('#file_name').html('<span>'+file+'</span>');
  // $(this).prev('label').text(file);
});
$('#file').bind('change', function() {
  var totalSize = this.files[0].size;
  var totalSizeMb = totalSize  / Math.pow(1024,2);

  $('.max-size').text(totalSizeMb.toFixed(2) + " MB");
});
$('.input-number').keyup(function(){
  var custom_btn = $('.input-number').val();
  $('#days30').val(custom_btn);
});
$(".input-number").keypress(function (e) {
  //if the letter is not digit then display error and don't type anything
  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //display error message
    $("#errmsg").html("Digits Only").show().fadeOut("slow");
           return false;
  }
});
</script>