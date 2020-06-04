<!-- New Design -->
<div class="specfic col-md-3 p-md-0 <?=($lang_dir == "right" ? 'order-2 order-sm-1 border-left':'')?>">
	<div class="messages-sidebar">
		<div class="messages-sidebar-header d-flex flex-row">
			<div class="message-filter d-flex flex-row align-items-center">
				<span><img src="<?= $site_url; ?>/assets/img/messages/message-icon.png" /></span>
				<div class="dropdown select-message">
		    	<!--- dropdown float-left mt-1 Starts --->
					<a class="dropdown-toggle text-dark" href="#" data-toggle="dropdown">الوارد </a>
					<div class="dropdown-menu">
						<a href="#" class="dropdown-item" id="all">الوارد </a>
						<a href="#" class="dropdown-item" id="unread">Unread</a>
						<a href="#" class="dropdown-item" id="starred">Starred</a>
						<a href="#" class="dropdown-item" id="archived">Archived</a>
					</div>
			 	</div>
				<!-- <select class="select-message">
					<option value="1">Inbox</option>
					<option id="all">All Conversations</option>
					<option id="unread">Unread</option>
					<option id="starred">Starred</option>
					<option id="archived">Archived</option>
				</select> -->
			</div>
			<div class="message-search">
				<form action="" method="POST" class="d-flex flex-row search-bar">
					<input class="search-input" type="search" name="" placeholder="type username" />
					<button type="button" role="button" class="search-icon">
						<i class="far fa-search"></i>
					</button>
				</form>
			</div>
		</div>

		<div class="messages-user-list">
				<?php
				

				$inboxQuery = "select * from inbox_sellers where (receiver_id=:r_id or sender_id=:s_id) AND NOT message_status='empty' order by time DESC";
				$select_inbox_sellers = $db->query($inboxQuery,array("r_id"=>$login_seller_id,"s_id"=>$login_seller_id));
				$count_inbox_sellers = $select_inbox_sellers->rowCount();
				while($row_inbox_sellers = $select_inbox_sellers->fetch()){
				$message_sender = $row_inbox_sellers->sender_id;
				$message_receiver = $row_inbox_sellers->receiver_id;
				$message_id = $row_inbox_sellers->message_id;
				$message_status = $row_inbox_sellers->message_status;
				$message_group_id = $row_inbox_sellers->message_group_id;
				if($login_seller_id == $message_sender){
					$sender_id = $message_receiver;
				}else{
					$sender_id = $message_sender;
				}

				$select_inbox_message = $db->select("inbox_messages",array("message_id" => $message_id));
				$row_inbox_message = $select_inbox_message->fetch();
				$message_file = $row_inbox_message->message_file;
				$message_desc = strip_tags($row_inbox_message->message_desc,"<img>");
				$message_date = $row_inbox_message->message_date;

				

			 	$dateAgo = $row_inbox_message->dateAgo;
				if($message_desc == ""){
				  $message_desc = "Sent you an offer";  
				}
				$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
				$row_sender = $select_sender->fetch();
				$sender_user_name = $row_sender->seller_user_name;
				$sender_image = $row_sender->seller_image;
				if(empty($sender_image)){
					$sender_image = "empty-image.png";
				}
				$select_starred = $db->select("starred_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));
				$count_starred = $select_starred->rowCount();
				$starred = "";
				if($count_starred == 1){
				$starred = "starred";
				}
				$select_archived = $db->select("archived_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));
				$count_archived = $select_archived->rowCount();
				$archived = "";
				if($count_archived == 1){
				$archived = "archived";
				}
				$select_hide_seller_messages = $db->select("hide_seller_messages",array("hider_id"=>$login_seller_id,"hide_seller_id"=>$sender_id));
				$count_hide_seller_messages = $select_hide_seller_messages->rowCount();
				if($count_hide_seller_messages == 0){
				$selected="";
				if($login_seller_id == $message_receiver){
			    if($message_status == "unread"){
			    	$selected="unread selected";
			    }
			  	}
			  	if($message_group_id == @$_GET['single_message_id']){
			  	$selected = "selected";
			  	}
				$select_unread = $db->select("unread_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));
				$count_unread = $select_unread->rowCount();
				if($count_unread == 1){ 
				$selected = "unread selected";
				}
				?>
			<a class="user-list-item flex-row align-items-center message-recipients media <?= $selected; ?> <?= $starred; ?> <?= $archived; ?>" data-username="<?= $sender_user_name; ?>" data-id="<?= $message_group_id; ?>">
				<div class="user-image">
					<?php if (!empty($sender_image)) { ?>
					<img src="<?= $site_url; ?>/user_images/<?= $sender_image; ?>" class="rounded-circle" width="60">
					<?php }else{ ?>
					<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
					<?php } ?>
				</div>
				<div class="message-summary d-flex flex-column">
					<span class="username"><?= $sender_user_name; ?></span>
					<span class="timestamp"><?= time_ago($dateAgo); ?></span>
					<span class="text-msg"><?= $message_desc; ?></span>
				</div>
			</a>
			<?php } } ?>
			<?php
			$count_unread_inbox_messages = $db->count("inbox_messages",array("message_receiver"=>$login_seller_id,"message_status"=>'unread'));
			if($count_unread_inbox_messages == 0){
			?>
			<p class="lead mt-5 text-center d-none unreadMsg">There are no conversations under "Unread".</p>
			<?php } ?>
			<?php
			$count_starred = $db->count("starred_messages",array("seller_id" => $login_seller_id));
			if(@$count_starred == 0){
			?>
			<p class="lead mt-5 text-center d-none starredMsg">There are no conversations under "Starred".</p>
			<?php } ?>
			<?php
			$count_archived = $db->count("archived_messages",array("seller_id"=>$login_seller_id));
			if(@$count_archived == 0){
			?>
			<p class="lead mt-5 text-center d-none archivedMsg">There are no conversations under "Archived".</p>
			<?php } ?>	
			<?php
			if($count_inbox_sellers == 0){
			?>
			<p class="lead mt-5 text-center">There are no conversations are available.</p>
			<?php } ?>
		</div>
	</div>
</div>
<!-- End New Design -->


<!-- <div class="specfic col-md-3 p-md-0 <?=($lang_dir == "right" ? 'order-2 order-sm-1 border-left':'')?>">
<div class="card border-0 rounded-0 m-0">
  <div class="card-header bg-transparent inboxHeader">
	<div class="search-bar d-none"> -->
		<!--- search-bar Starts --->
	<!-- <div class="input-group"> -->
		<!--- input-group Starts --->
      <!-- <input type="text" class="form-control" placeholder="Search for a username">
      <span class="input-group-addon"> <a href="#">Close</a> </span>
    </div> -->
    <!--- input-group Ends --->
	<!-- </div> -->
	<!--- search-bar Ends --->
    <!-- <div class="dropdown float-left mt-1"> -->
    	<!--- dropdown float-left mt-1 Starts --->
			<!-- <a class="dropdown-toggle" href="#" data-toggle="dropdown">All Conversations</a>
			<div class="dropdown-menu">
				<a href="#" class="dropdown-item" id="all">All Conversations</a>
				<a href="#" class="dropdown-item" id="unread">Unread</a>
				<a href="#" class="dropdown-item" id="starred">Starred</a>
				<a href="#" class="dropdown-item" id="archived">Archived</a>
			</div>
	 </div> -->
	 <!--- dropdown float-left mt-1 Ends --->
	<!-- <div class="float-right mb-1"> -->
		<!--- float-right mb-1 Starts --->
	<!-- <a href="#" class="text-muted search-icon"> <i class="fa fa-lg fa-search"></i> </a>
	</div> -->
	<!--- float-right mb-1 Ends --->
  <!-- </div>
  <div class="card-body p-0">
	<ul class="list-unstyled">
	<?php

	$inboxQuery = "select * from inbox_sellers where (receiver_id=:r_id or sender_id=:s_id) AND NOT message_status='empty' order by time DESC";
	$select_inbox_sellers = $db->query($inboxQuery,array("r_id"=>$login_seller_id,"s_id"=>$login_seller_id));
	$count_inbox_sellers = $select_inbox_sellers->rowCount();
	while($row_inbox_sellers = $select_inbox_sellers->fetch()){
	$message_sender = $row_inbox_sellers->sender_id;
	$message_receiver = $row_inbox_sellers->receiver_id;
	$message_id = $row_inbox_sellers->message_id;
	$message_status = $row_inbox_sellers->message_status;
	$message_group_id = $row_inbox_sellers->message_group_id;
	if($login_seller_id == $message_sender){
		$sender_id = $message_receiver;
	}else{
		$sender_id = $message_sender;
	}

	$select_inbox_message = $db->select("inbox_messages",array("message_id" => $message_id));
	$row_inbox_message = $select_inbox_message->fetch();
	$message_file = $row_inbox_message->message_file;
	$message_desc = strip_tags($row_inbox_message->message_desc,"<img>");
	$message_date = $row_inbox_message->message_date;

 	$dateAgo = $row_inbox_message->dateAgo;
	if($message_desc == ""){
	  $message_desc = "Sent you an offer";  
	}
	$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
	$row_sender = $select_sender->fetch();
	$sender_user_name = $row_sender->seller_user_name;
	$sender_image = $row_sender->seller_image;
	if(empty($sender_image)){
		$sender_image = "empty-image.png";
	}
	$select_starred = $db->select("starred_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));
	$count_starred = $select_starred->rowCount();
	$starred = "";
	if($count_starred == 1){
	$starred = "starred";
	}
	$select_archived = $db->select("archived_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));
	$count_archived = $select_archived->rowCount();
	$archived = "";
	if($count_archived == 1){
	$archived = "archived";
	}
	$select_hide_seller_messages = $db->select("hide_seller_messages",array("hider_id"=>$login_seller_id,"hide_seller_id"=>$sender_id));
	$count_hide_seller_messages = $select_hide_seller_messages->rowCount();
	if($count_hide_seller_messages == 0){
	$selected="";
	if($login_seller_id == $message_receiver){
    if($message_status == "unread"){
    	$selected="unread selected";
    }
  	}
  	if($message_group_id == @$_GET['single_message_id']){
  	$selected = "selected";
  	}
	$select_unread = $db->select("unread_messages",array("seller_id"=>$login_seller_id,"message_group_id"=>$message_group_id));
	$count_unread = $select_unread->rowCount();
	if($count_unread == 1){ 
	$selected = "unread selected";
	}
	?>
	<a href="#" class="message-recipients media border-bottom <?= $selected; ?> <?= $starred; ?> <?= $archived; ?>" data-username="<?= $sender_user_name; ?>" data-id="<?= $message_group_id; ?>">
    <img src="../user_images/<?= $sender_image; ?>" class="rounded-circle mr-3" width="50">
    <div class="media-body nowrap">
      <h6 class="mt-0 mb-1">
      	<?= $sender_user_name; ?><small class="float-right text-muted"><?= time_ago($dateAgo); ?></small>
      </h6>
      <?= $message_desc; ?>
    </div>
	</a>
	<?php }} ?>
	</ul>
	<?php
	$count_unread_inbox_messages = $db->count("inbox_messages",array("message_receiver"=>$login_seller_id,"message_status"=>'unread'));
	if($count_unread_inbox_messages == 0){
	?>
	<p class="lead mt-5 text-center d-none unreadMsg">There are no conversations under "Unread".</p>
	<?php } ?>
	<?php
	$count_starred = $db->count("starred_messages",array("seller_id" => $login_seller_id));
	if(@$count_starred == 0){
	?>
	<p class="lead mt-5 text-center d-none starredMsg">There are no conversations under "Starred".</p>
	<?php } ?>
	<?php
	$count_archived = $db->count("archived_messages",array("seller_id"=>$login_seller_id));
	if(@$count_archived == 0){
	?>
	<p class="lead mt-5 text-center d-none archivedMsg">There are no conversations under "Archived".</p>
	<?php } ?>	
	<?php
	if($count_inbox_sellers == 0){
	?>
	<p class="lead mt-5 text-center">There are no conversations are available.</p>
	<?php } ?>
  </div>
</div>
</div> -->