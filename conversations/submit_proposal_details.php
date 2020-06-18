<?php

@session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));

$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;


$proposal_id = $input->post('proposal_id');

$message = $input->post('message');

$file = $input->post('file');

$receiver_id = $input->post('receiver_id');



$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposals = $select_proposals->fetch();

$proposal_title = $row_proposals->proposal_title;

?>
<style>
	.customer-order.modal-dialog .form-group .deliver-time .deliver-time-item input[type="radio"]:checked+.deliver-time-item-content {
	    background-color: #ff0707;
	}
</style>
<div class="modal-content"><!-- modal-content Starts -->

<div class="modal-header"><!-- modal-header Starts -->

<h5 class="modal-title"> Specify Your Proposal Details </h5>

<!-- <button class="close" data-dismiss="modal">
<span> &times; </span>
</button> -->
<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
	<img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png" />
</a>

</div><!-- modal-header Ends -->

<div class="modal-body p-0"><!-- modal-body p-0 Starts -->

<form id="proposal-details-form"><!--- proposal-details-form Starts --->

<div class="selected-proposal"><!--- selected-proposal p-3 Starts --->

	<div class="form-group">
		<div class="customer-profile px-0 border-bottom-0">
			<h5> <?php echo $proposal_title; ?> </h5>
		</div>
	</div>


<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

<input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">

<input type="hidden" name="message" value="<?php echo $message; ?>">

<input type="hidden" name="file" value="<?php echo $file; ?>">

<div class="form-group"><!--- form-group Starts --->
<div class="customer-profile px-0 border-bottom-0">
<label class="font-weight-bold"> Description :  </label>

<textarea name="description" class="form-control" required=""></textarea>
</div>
</div><!--- form-group Ends --->



<!-- <div class="form-group"> -->
	<!--- form-group Starts --->

<!-- <label class="font-weight-bold"> Delivery Time :  </label>

<select class="form-control float-right" name="delivery_time" required="">

<option value="1 Day"> 1 Day </option>

<option value="2 Days"> 2 Days </option>

<option value="3 Days"> 3 Days </option>

</select>

</div> -->
<!--- form-group Ends --->

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
		<label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
			<input id="hours<?= $delivery_id; ?>" type="radio" name="delivery_time" value="<?= $delivery_proposal_title; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title){ echo "checked"; } ?> hidden />
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
	</div>
</div>



<!-- <div class="form-group"> -->
	<!--- form-group Starts --->

<!-- <label class="font-weight-bold"> Total Offer Amount :  </label>

<div class="input-group float-right">

<span class="input-group-addon font-weight-bold"> <?php echo $s_currency; ?> </span>

<input type="number" name="amount" class="form-control" min="5" placeholder="5 Minimum" required="">

</div>

</div> -->
<!--- form-group Ends --->

<div class="form-group">
    <div class="control-label d-flex align-items-start">
        <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
        <span>What is your budget?</span>
    </div>
    <input class="form-control mb-30" type="text" name="amount" min="5" placeholder="$ 5 Minimum" required="" />
</div>


</div><!--- selected-proposal p-3 Ends --->

<div class="border-top"><!--- modal-footer Starts --->
<div class="form-group d-flex flex-row align-items-center justify-content-between">
<button type="button" class="button-close" data-dismiss="modal" data-toggle="modal" data-target="#send-offer-modal">Back</button>

<button type="submit" class="button">Submit Offer</button>
</div>

</div><!--- modal-footer Ends --->

</form><!--- proposal-details-form Ends --->

</div><!-- modal-body p-0 Ends -->

</div><!-- modal-content Ends -->


<div id="insert_offer"></div>


<script>

$(document).ready(function(){
	

$("#proposal-details-form").submit(function(event){
	
event.preventDefault();
	

description = $("textarea[name='description']").val();

delivery_time = $("input[name='delivery_time']:checked").val();


amount = $("input[name='amount']").val();

if(description == "" | delivery_time == "" | amount == ""){

swal({
type: 'warning',
text: 'You Must Need To Fill Out All Fields Before Submitting Offer.'
});

}else{

$.ajax({
	
method: "POST",
url: "<?php echo $site_url; ?>/conversations/insert_offer",
data: $('#proposal-details-form').serialize()

}).done(function(data){
	
$("#submit-proposal-details").modal('hide');

$("#insert_offer").html(data);
	
});

}
	
});

	
});

</script>
