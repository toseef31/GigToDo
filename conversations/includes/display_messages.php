<?php
	@session_start();
	require_once("../../includes/db.php");
	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('../../login','_self')</script>";
	}

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;

	if(isset($_POST["message_group_id"])){
		$message_group_id = $input->post("message_group_id");
  }

	$get_inbox_messages = $db->select("inbox_messages",array("message_group_id" => $message_group_id));
	while($row_inbox_messages = $get_inbox_messages->fetch()){
	$message_id = $row_inbox_messages->message_id;
	$message_sender = $row_inbox_messages->message_sender;
	$message_receiver = $row_inbox_messages->message_receiver;
	$message_desc = $row_inbox_messages->message_desc;
	$message_date = $row_inbox_messages->message_date;
	$message_file = $row_inbox_messages->message_file;
	$message_offer_id = $row_inbox_messages->message_offer_id;
	$message_request_id = $row_inbox_messages->message_request_id;



	if(!$message_offer_id == 0){
		$select_offer = $db->select("messages_offers",array("offer_id" => $message_offer_id));	
		$row_offer = $select_offer->fetch();
		$offer_id_msg = $row_offer->offer_id;
		$sender_id = $row_offer->sender_id;
		$proposal_id = $row_offer->proposal_id;
		$description = $row_offer->description;
		$order_id = $row_offer->order_id;
		$delivery_time = $row_offer->delivery_time;
		$amount = $row_offer->amount;
		$revision = $row_offer->revision_time;
		$offer_status = $row_offer->status;
		$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
		$row_proposals = $select_proposals->fetch();
		$proposal_title = $row_proposals->proposal_title;
    	$proposal_img1 = $row_proposals->proposal_img1;
    	
	}

	if(!$message_request_id == 0){
		$select_request = $db->select("messages_requests",array("message_request_id" => $message_request_id));	
		$row_request = $select_request->fetch();
		$request_id_msg = $row_request->message_request_id;
		$sender_id = $row_request->sender_id;
		$receiver_id = $row_request->receiver_id;
		$request_description = $row_request->request_description;
		$order_id = $row_request->order_id;
		$delivery_time = $row_request->delivery_time;
		$request_budget = $row_request->request_budget;
		$revision = $row_request->revision_time;
		$request_status = $row_request->request_status;
	}
	$select_request_offer = $db->select('messages_offers', array("request_id"=>$message_request_id));
	$offer_request_id = $select_request_offer->fetch()->request_id;
	// print_r($offer_request_id);

  $select_sender = $db->select("sellers",array("seller_id" => $message_sender));
  $row_sender = $select_sender->fetch();
  $sender_user_name = $row_sender->seller_user_name;
  $sender_image = $row_sender->seller_image;
                
	if($login_seller_id == $message_sender){
		$sender_user_name = "Me";
	}

	$allowed = array('jpeg','jpg','gif','png');


	?>
	<div class="message-content-card-item d-flex flex-row align-items-start inboxMsg media inboxMsg">
		<div class="user-image">
			<?php if(!empty($sender_image)){ ?>
			<img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle" width="60" />
			<?php } else{ ?>
			<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
			<?php } ?>
		</div>
		<div class="messages-text d-flex flex-column">
			<div class="username d-flex flex-row align-items-start justify-content-between">
				<span><?php echo $sender_user_name; ?></span>
				<span class="timestamp"><?php echo $message_date; ?></span>
			</div>
			<p><?php echo $message_desc; ?></p>
      <?php if(!empty($message_file)){ ?>
      <?php if(in_array(pathinfo($message_file,PATHINFO_EXTENSION),$allowed)){ ?>
      <br>
      <img src="conversations_files/<?php echo $message_file; ?>" alt="..." class="img-thumbnail" width="100">
      <?php } ?>
			<a href="conversations_files/<?php echo $message_file; ?>" download class="d-block mt-2 ml-1"  style="color: #ff0707;">
			<i class="fa fa-download"></i> <?php echo $message_file; ?>
			</a>
			<?php } ?>
		</div>
	</div>
	<?php if(!$message_offer_id == 0){ ?>
	<div class="message-content-card-item d-flex flex-column inboxMsg media inboxMsg" id="offer-<?= $message_offer_id; ?>">
		<div class="freelancer-offer d-flex flex-row align-items-start">
			<div class="user-image">
				<?php if(!empty($sender_image)){ ?>
			    <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle mr-3" width="60">
				<?php }else{ ?>
				<img src="assets/img/emongez_cube.png" />
				<?php } ?>
			</div>
			<div class="messages-text d-flex flex-column">
				<div class="offer-title-price d-flex flex-row align-items-center justify-content-between">
					<span class="title"><?php echo $proposal_title; ?></span>
					<span class="price"><?php echo $s_currency; ?><?php echo $amount; ?></span>
				</div>
				<div class="offer-summary"><?php echo $description; ?></div>
				<h5>Your offer includes:</h5>
				<ul class="d-flex flex-wrap">
					<li class="d-flex flex-row align-items-center">
						<span>
							<img src="<?= $site_url; ?>/assets/img/messages/revision-icon.png" />
						</span>
						<span>Revision : <?php echo $revision; ?></span>
					</li>
					<li class="d-flex flex-row align-items-center">
						<span>
							<img src="<?= $site_url; ?>/assets/img/messages/time-icon.png" />
						</span>
						<span>Deliver Time : <?php echo $delivery_time; ?></span>
					</li>
				</ul>
				<div class="d-flex flex-row justify-content-end align-items-center">
					<?php if($offer_status == "active"){ ?>
					<?php if($login_seller_id == $sender_id){ ?>
					<a class="withdraw-offer" type="button" href="delete_offer?offer_id=<?php echo $offer_id_msg; ?>">Withdraw offer</a>
					<?php }else{ ?>
					<!-- <button class="cancel-offer" id="cancel-offer-<?= $message_offer_id; ?>" type="button">no thanks</button> -->
					<button id="accept-offer-<?php echo $message_offer_id; ?>" class="accepte-offer  float-right">
					Order Now 
					</button>
					<script>
					$("#accept-offer-<?php echo $message_offer_id; ?>").click(function(){
						single_message_id = "<?php echo $message_group_id; ?>";
						offer_id = "<?php echo $message_offer_id; ?>";
						$.ajax({
						method: "POST",
						url: "accept_offer_modal",
						data: {single_message_id: single_message_id, offer_id: offer_id}
						})
						.done(function(data){
							$("#accept-offer-div").html(data);
						});
					});
					</script>
					<?php } ?>
					<?php }elseif($offer_status == "accepted"){ ?>
					<a href="../order_details.php?order_id=<?php echo $order_id; ?>" class="mt-2 mr-3  rounded-0 float-right accepte-offer">
					View Order
					</a>
					<button class="withdraw-offer rounded-0 mt-2 float-right" disabled="true">
					Offer Accepted
					</button>
					
					<?php } ?>
					<!-- <button class="withdraw-offer" type="button" role="button">Withdraw offer</button> -->
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- Each item -->
	<?php if ($message_request_id != 0){ ?>
		<div class="message-content-card-item d-flex flex-column inboxMsg media inboxMsg" id="offer-<?= $message_offer_id; ?>">
			<div class="freelancer-offer d-flex flex-row align-items-start">
				<div class="user-image">
					<?php if(!empty($sender_image)){ ?>
				    <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle mr-3" width="60">
					<?php }else{ ?>
					<img src="assets/img/emongez_cube.png" />
					<?php } ?>
				</div>
				<div class="messages-text d-flex flex-column">
					<div class="offer-title-price d-flex flex-row align-items-center justify-content-between">
						<span class="title"><?php echo $request_description; ?></span>
						<span class="price"><?php echo $s_currency; ?><?php echo $request_budget; ?></span>
					</div>
					<!-- <div class="offer-summary"><?php echo $description; ?></div> -->
					<h5>Your Request includes:</h5>
					<ul class="d-flex flex-wrap">
						<!-- <li class="d-flex flex-row align-items-center">
							<span>
								<img src="<?= $site_url; ?>/assets/img/messages/revision-icon.png" />
							</span>
							<span>Revision : <?php echo $revision; ?></span>
						</li> -->
						<li class="d-flex flex-row align-items-center">
							<span>
								<img src="<?= $site_url; ?>/assets/img/messages/time-icon.png" />
							</span>
							<span>Deliver Time : <?php echo $delivery_time; ?></span>
						</li>
					</ul>
					<div class="d-flex flex-row justify-content-end align-items-center">
						<?php if($request_status == "active"){ ?>
						<?php if($login_seller_id == $sender_id){ ?>
						<!-- <a class="withdraw-offer" type="button" href="delete_offer?offer_id=<?php echo $offer_id_msg; ?>">Withdraw offer</a> -->
						<?php }else{ if($offer_request_id != $request_id_msg){ ?>
						<button class="cancel-offer" id="cancel-offer-<?= $message_offer_id; ?>" type="button">no thanks</button>
						<button id="send-offer-<?php echo $message_request_id; ?>" class="accepte-offer  float-right">
						Send Offer <?= $offer_request_id; ?><?= $request_id_msg; ?>
						</button>
						<script>
						$("#send-offer-<?php echo $message_request_id; ?>").click(function(){
							receiver_id = "<?php echo $receiver_id; ?>"
							request_id = "<?php echo $message_request_id; ?>";
							message = $("#message").val();
							file = $("#file").val();
							$.ajax({
							method: "POST",
							url: "send_offer_modal",
							data: {receiver_id: receiver_id, request_id: request_id, message: message, file: file}
							})
							.done(function(data){
								$("#send-offer-div").html(data);
							});
						});
						</script>
						<?php } else{ ?>
						
							<button id="" class="accepte-offer  float-right" disabled="">
							Offer Sent 
							</button>
						<?php } } ?>
						<?php }elseif($request_status == "accepted"){ ?>
						<a href="../order_details.php?order_id=<?php echo $order_id; ?>" class="mt-2 mr-3  rounded-0 float-right accepte-offer">
						View Order
						</a>
						<button class="withdraw-offer rounded-0 mt-2 float-right" disabled="true">
						Offer Accepted
						</button>
						
						<?php } ?>
						<!-- <button class="withdraw-offer" type="button" role="button">Withdraw offer</button> -->
					</div>
				</div>
			</div>
		</div>
	<?php }?>
<?php } ?>
<!-- <?php 
		$get_custom_offer = $db->query("select * from buyer_requests where seller_id='$login_seller_id' OR user_id='$message_receiver'");

	
	while($row_custom_offer = $get_custom_offer->fetch()){ 
		$request_id = $row_custom_offer->request_id;
		$request_type = $row_custom_offer->request_type;
		$request_seller_id = $row_custom_offer->seller_id;
		$request_title = $row_custom_offer->request_title;
		$request_description = $row_custom_offer->request_description;
		$delivery_time = $row_custom_offer->delivery_time;
		$request_budget = $row_custom_offer->request_budget;
		
?>
	<?php if($request_type == "MessageOffer"){ ?>
	<div class="message-content-card-item d-flex flex-column inboxMsg media inboxMsg">
		<div class="freelancer-offer d-flex flex-row align-items-start">
			<div class="user-image">
				<?php if(!empty($sender_image)){ ?>
			    <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle mr-3" width="60">
				<?php }else{ ?>
				<img src="assets/img/emongez_cube.png" />
				<?php } ?>
			</div>
			<div class="messages-text d-flex flex-column">
				<div class="offer-title-price d-flex flex-row align-items-center justify-content-between">
					<span class="title"><?php echo $request_title; ?></span>
					<span class="price"><?php echo $s_currency; ?><?php echo $request_budget; ?></span>
				</div>
				<div class="offer-summary"><?php echo $request_description; ?></div>
				<h5>Your offer includes:</h5>
				<ul class="d-flex flex-wrap">
					<li class="d-flex flex-row align-items-center">
						<span>
							<img src="<?= $site_url; ?>/assets/img/messages/revision-icon.png" />
						</span>
						<span>Price / Amount : <?php echo $s_currency; ?><?php echo $request_budget; ?></span>
					</li>
					<li class="d-flex flex-row align-items-center">
						<span>
							<img src="<?= $site_url; ?>/assets/img/messages/time-icon.png" />
						</span>
						<span>Deliver Time : <?php echo $delivery_time; ?></span>
					</li>
				</ul>

				<div class="d-flex flex-row justify-content-end align-items-center">
					<?php if($offer_status == "active"){ ?>
					<?php if($login_seller_id == $request_seller_id){ ?>
					
					<?php }else{ ?>
					<button id="send-offer-<?= $request_id; ?>" class="accepte-offer  float-right">
					Send Offer
					</button>
					<script>
					$("#send-offer-<?= $request_id; ?>").click(function(){
						receiver_id = "<?= $request_seller_id; ?>";
						alert(receiver_id);
						message = $("#message").val();
						file = $("#file").val();
						if(file == ""){
							message_file = file;
						}else{
							message_file = document.getElementById("file").files[0].name;
						}
						$.ajax({
							method: 'POST',
							url: 'send_offer_modal',
							data: {receiver_id: receiver_id, message: message, file: message_file}
						}).done(function(data){
							$("#send-offer-div").html(data);
						});
					});
					</script>
					<?php } ?>
					<?php }elseif($offer_status == "accepted"){ ?>
					<button class="withdraw-offer rounded-0 mt-2 float-right" disabled>
					Offer Accepted
					</button>
					<a href="../order_details.php?order_id=<?php echo $order_id; ?>" class="mt-3 mr-3 float-right text-success">
					View Order
					</a>
					<?php } ?>
					
				</div>

			</div>
		</div>
	</div>
<?php } } ?> -->
