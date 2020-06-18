<?php

session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
	echo "<script>window.open('../login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));

$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;

$login_seller_image = $rows_login_seller->seller_image;


$request_id = $input->post('request_id');


$get_requests = $db->select("buyer_requests",array("request_id" => $request_id));

$row_requests = $get_requests->fetch();

$request_title = $row_requests->request_title;

$request_description = $row_requests->request_description;

$request_budget = $row_requests->request_budget;

$child_id = $row_requests->child_id;

$request_seller_id = $row_requests->seller_id;



$select_request_seller = $db->select("sellers",array("seller_id" => $request_seller_id));

$row_request_seller = $select_request_seller->fetch();

$request_seller_image = $row_request_seller->seller_image;

?>

<!-- <div class="modal fade" id="send-offer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered customer-order" role="document">
			<div class="modal-content">
				<div class="modal-header align-items-center">
					<h5 class="modal-title" id="exampleModalCenterTitle">Send Offer</h5>
					<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
						<img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png" />
					</a>
				</div>
				<div class="modal-body">
					<form id="proposal-details-form">
						<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

						<input type="hidden" name="request_id" value="<?php echo $request_id; ?>">
						<div class="customer-profile mb-30">
							<div class="d-flex align-items-start align-items-md-center pt-15 pb-15">
								<div class="profile-img">
									<?php if(!empty($login_seller_image)){ ?>
									<img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="50" height="50" class="rounded-circle">
									<?php }else{ ?>
									<img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="">
									<?php } ?>
								</div>
								<div class="profile-content media-body">
									<h6 class="text-danger mb-1"> <?php echo $request_title; ?> </h6>
									<div class="form-group p-0 m-0">
										<textarea rows="4" class="form-control bg-white" readonly=""><?php echo $request_description; ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group mb-0">
							<div class="control-label d-flex align-items-start">
								<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
								<span>Total Budget</span>
							</div>
							<input class="form-control mb-30 bg-white" type="text" value="<?= $s_currency; ?> <?= $request_budget; ?>" placeholder="$ 5 Minimum" readonly="" />
						</div>
						<div class="customer-profile mb-30">
							<div class="d-flex align-items-start align-items-md-center pt-15 pb-15">
								<div class="profile-img">
									<?php if(!empty($request_seller_image)){ ?>
									<img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="50" height="50" class="rounded-circle">
									<?php }else{ ?>
									<img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="">
									<?php } ?>
								</div>
								<div class="profile-content media-body">
									<div class="form-group p-0 m-0">
										<textarea rows="4" class="form-control" name="description" placeholder="Enter Text Here..." required=""></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="deliver-time d-flex flex-wrap mb-15">
								<?php 

								$get_delivery_times = $db->select("delivery_times");

								while($row_delivery_times = $get_delivery_times->fetch()){

								$delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
								$delivery_id = $row_delivery_times->delivery_id;
								?>
								<label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
									<input id="hours<?= $delivery_id; ?>" type="radio" name="delivery_time" value="<?= $delivery_proposal_title; ?>" hidden />
									<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
										<span class="color-icon">
											<span>-</span>
											<span>+</span>
										</span>
										<span class="d-flex flex-row align-items-end time">
											<span><?= $delivery_proposal_title; ?></span>
										</span>
									</div>
								</label>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<div class="control-label d-flex align-items-start">
								<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
								<span>Total Amount</span>
							</div>
							<input class="form-control mb-30" type="text" name="amount" placeholder="$ 5 Minimum" />
						</div>
						<div class="form-group d-flex flex-row align-items-center justify-content-between">
							<button class="button" id="submit-proposal" type="submit">Send Offer</button>
							<button class="button-close" type="button" role="button" data-dismiss="modal" aria-label="Close">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<div id="insert_offer"></div> -->
<div id="send-offer-modal" class="modal fade">
	<div class="modal-dialog modal-dialog-centered customer-order" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Select A Proposal/Service To Offer</h5>
				<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
					<img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png" />
				</a>
				
			</div>
			<div class="modal-body p-0">
				<div class="customer-profile mb-30">
					<div class="d-flex align-items-start align-items-md-center pt-15 pb-15">
						<div class="profile-img">
							<?php if(!empty($request_seller_image)){ ?>
							<img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="80" height="80" class="rounded-circle">
							<?php }else{ ?>
							<img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="">
							<?php } ?>
						</div>
						<div class="profile-content media-body">
							<h6 class="text-danger mb-1"> <?php echo $request_title; ?> </h6>
							<div class="form-group p-0 m-0">
								<textarea rows="4" class="form-control bg-white" readonly=""><?php echo $request_description; ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="request-summary">
					
					<?php if(!empty($request_seller_image)){ ?>
					<img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="50" height="50" class="rounded-circle">
					<?php }else{ ?>
					<img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="rounded-circle">
					<?php } ?>
					<div id="request-description">
						<h6 class="text-success mb-1"> <?php echo $request_title; ?> </h6>
						<p><?php echo $request_description; ?></p>
					</div>
					
				</div> -->
				<div class="request-proposals-list form-group">
					
					<?php
					$get_proposals = $db->select("proposals",array("proposal_child_id"=>$child_id,"proposal_seller_id"=>$login_seller_id,"proposal_status"=>"active"));
										while($row_proposals = $get_proposals->fetch()){
										$proposal_id = $row_proposals->proposal_id;
										$proposal_title = $row_proposals->proposal_title;
										$proposal_img1 = $row_proposals->proposal_img1;
					?>
					<div class="proposal-picture">
						<input type="radio" id="radio-<?php echo $proposal_id; ?>" class="radio-custom" name="proposal_id" value="<?php echo $proposal_id; ?>" required>
						<label for="radio-<?php echo $proposal_id; ?>" class="radio-custom-label"></label>
						<img src="<?php echo $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" width="50" height="50" style="border-radius: 2% !important;">
					</div>
					<div class="proposal-title">
						<p><?php echo $proposal_title; ?></p>
					</div>
					<hr>
					
					<?php } ?>
				</div>
				<div class="form-group d-flex flex-row align-items-center justify-content-between">
					<button class="button-close" data-dismiss="modal"> Close</button>
					<button class="button" id="submit-proposal" data-toggle="modal" data-dismiss="modal" data-target="#submit-proposal-details" title="Choose an offer before clicking continue">Continue</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="submit-proposal-details" class="modal fade">
	<div class="modal-dialog modal-dialog-centered customer-order" role="document">
	</div>
</div>
 <!-- Continue end -->

<script>

$(document).ready(function(){
	
	$("#send-offer-modal").modal("show");
	
	$("#submit-proposal").attr("disabled", "disabled");
	
	$(".radio-custom-label").click(function(){
		
		$("#submit-proposal").removeAttr("disabled");
		
	});
	
 
   $("#submit-proposal").click(function(){
	   
   proposal_id = document.querySelector('input[name="proposal_id"]:checked').value;	   
	
   request_id = "<?php echo $request_id; ?>";
   
   $.ajax({
	   
	method: "POST",   
	
	url: "<?php echo $site_url; ?>/requests/submit_proposal_details",
	
	data: { proposal_id: proposal_id, request_id: request_id }
	   
   })
   
   .done(function(data){
	   
	   $("#submit-proposal-details .modal-dialog").html(data);
	   
   });
	
	
   });
	
});
// $(document).ready(function(){
// 	$("#send-offer-modal").modal("show");
		
	
// $("#proposal-details-form").submit(function(event){

// event.preventDefault();


// request_id = "<?php echo $request_id; ?>";

// description = $("textarea[name='description']").val();

// delivery_time = $("input[name='delivery_time']:checked").val();


// amount = $("input[name='amount']").val();

// if(description == "" | delivery_time == "" | amount == ""){

// swal({
// type: 'warning',
// text: 'You Must Need To Fill Out All Fields Before Submitting Offer.'
// });

// }else{


// $.ajax({
	
// method: "POST",
// url: "<?php echo $site_url; ?>/requests/insert_offer",
// data: $('#proposal-details-form').serialize()

// }).done(function(data){
// $("#send-offer-modal").modal('hide');

// $("#insert_offer").html(data);
	
// });
	

// }

// });
	
	
// });

</script>