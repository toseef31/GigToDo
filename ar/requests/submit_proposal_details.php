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


$proposal_id = $input->post('proposal_id');

$request_id = $input->post('request_id');



$get_requests = $db->select("buyer_requests",array("request_id" => $request_id));

$row_requests = $get_requests->fetch();

$request_title = $row_requests->request_title;

$request_description = $row_requests->request_description;
$request_budget = $row_requests->request_budget;

$request_seller_id = $row_requests->seller_id;



$select_request_seller = $db->select("sellers",array("seller_id" => $request_seller_id));

$row_request_seller = $select_request_seller->fetch();

$request_seller_image = $row_request_seller->seller_image;



$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposals = $select_proposals->fetch();

$proposal_title = $row_proposals->proposal_title;

?>


<div class="modal-content"><!--- modal-content Starts --->

<div class="modal-header"><!--- modal-header Starts --->

<h5 class="modal-title h5"> حدد تفاصيل العرض  </h5>

<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
	<img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png" />
</a>

</div><!--- modal-header Ends --->

<div class="modal-body p-0"><!--- modal-body p-0 Starts --->

<!-- <div class="request-summary">

<?php if(!empty($request_seller_image)){ ?>

<img src="<?php echo $site_url; ?>/user_images/<?php echo $request_seller_image; ?>" width="50" height="50" class="rounded-circle">

<?php }else{ ?>

<img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="50" height="50" class="rounded-circle">

<?php } ?>

<div id="request-description">

<h6 class="text-success mb-1"> <?php echo $request_title; ?> </h6>

<p> <?php echo $request_description; ?> </p>

</div>

</div> -->
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


<form id="proposal-details-form"><!--- proposal-details-form Starts --->

<div class="selected-proposal"><!--- selected-proposal p-3 Starts --->
	<div class="form-group pt-0">
		<div class="customer-profile px-0 border-bottom-0 pt-0">
			<h5> <?php echo $proposal_title; ?> </h5>
		</div>
	</div>
	<div class="form-group mb-0">
		<div class="control-label d-flex align-items-start">
			<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
			<span>
				الميزانية الكلية
			</span>
		</div>
		<input class="form-control mb-30" type="text" value="<?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget);}else{  echo $s_currency.' '; echo $request_budget; } ?>" placeholder="الحد الادني 5 دولار" readonly />
	</div>
	

<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

<input type="hidden" name="request_id" value="<?php echo $request_id; ?>">

<!-- <div class="form-group">

<label class="font-weight-bold"> Description :  </label>

<textarea name="description" class="form-control" required=""></textarea>

</div> -->
<div class="customer-profile mb-30">
	<div class="d-flex align-items-start align-items-md-center pt-15 pb-15">
		<div class="profile-img">
			<?php if(!empty($login_seller_image)){ ?>
			<img src="<?php echo $site_url; ?>/user_images/<?php echo $login_seller_image; ?>" width="50" height="50" class="rounded-circle">
			<?php }else{ ?>
			<img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="">
			<?php } ?>
		</div>
		<div class="profile-content media-body">
			<div class="form-group p-0 m-0">
				<textarea rows="4" class="form-control" name="description" placeholder="دخل الوصف هنا ..." required=""></textarea>
			</div>
		</div>
	</div>
</div>

<!-- <div class="form-group">

<label class="font-weight-bold"> Delivery Time :  </label>

<select class="form-control float-right" name="delivery_time">

<?php 

$get_delivery_times = $db->select("delivery_times");

while($row_delivery_times = $get_delivery_times->fetch()){

$delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
	
echo "<option value='$delivery_proposal_title'> $delivery_proposal_title </option>";
	
}

?>

</select>

</div> -->
<div class="form-group">
	<div class="deliver-time d-flex flex-wrap mb-15">
		<?php
			$get_delivery_times = $db->select("delivery_times");
			while($row_delivery_times = $get_delivery_times->fetch()){
			$delivery_proposal_title_arabic = $row_delivery_times->delivery_proposal_title_arabic;
			$delivery_id = $row_delivery_times->delivery_id;
		?>
		<label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
			<input id="hours<?= $delivery_id; ?>" type="radio" name="delivery_time" value="<?= $delivery_proposal_title_arabic; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title_arabic){ echo "checked"; } ?> hidden />
			<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
				<span class="color-icon">
					<span>-</span>
					<span>+</span>
				</span>
				<span class="d-flex flex-row align-items-end time">
					<span><?= $delivery_proposal_title_arabic; ?></span>
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
          <span>مخصص</span>
					<input autofocus="autofocus" class="input-number" type="text" name="" pattern="[0-9]{2}" />
				</span>
			</div>
		</label>
	</div>
</div>

<!-- 
<div class="form-group">

<label class="font-weight-bold"> Total Offer Amount :  </label>

<div class="input-group float-right">

<span class="input-group-addon font-weight-bold"> <?php echo $s_currency; ?> </span>

<input type="number" name="amount" class="form-control" min="5" placeholder="5 Minimum" required="">

</div>

</div> -->
<div class="form-group">
	<div class="control-label d-flex align-items-start">
		<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-6.png" alt="Icon"></span>
		<span>التكلفة الكلية</span>
	</div>
	<input class="form-control mb-30"  name="amount" type="text" min="5" placeholder="اقل مبلغ  <?php if ($to == 'EGP'){ echo $to.' '; echo "80";}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * 80);}else{  echo $s_currency.' '; echo "80"; } ?>"  required=""/>
</div>

<div class="form-group d-flex flex-column">
	<div class="control-label d-flex align-items-start">
		<span><img src="<?= $site_url; ?>/assets/img/post-request/icon-7.png" alt="Icon"></span>
		<span>
			المراجعات
		</span>
	</div>
	<select class="form-control wide mb-30" name="revision_time">
		<option>اختار</option>
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
	</select>
</div>

</div><!--- selected-proposal p-3 Ends --->

<div class="form-group d-flex flex-row align-items-center justify-content-between border-top pt-30"><!--- modal-footer Starts --->
<button type="submit" class="button">ابعت العرض</button>

<button type="button" class="button-close" data-dismiss="modal" data-toggle="modal" data-target="#send-offer-modal">عودة</button>


</div><!--- modal-footer Ends --->

</form><!--- proposal-details-form Ends --->

</div><!--- modal-body p-0 Ends --->

</div><!--- modal-content Ends --->

<div id="insert_offer"></div>


<script>
	$('.deliver-time-item[for="days30"]').on('click', function(){
		$('.input-number').focus();
	});
	$('.input-number').keyup(function(){
		var custom_btn = $('.input-number').val();
		$('#days30').val(custom_btn);
	});
$(document).ready(function(){
	
$("#proposal-details-form").submit(function(event){

event.preventDefault();

description = $("textarea[name='description']").val();

delivery_time = $("select[name='delivery_time']").val();

amount = $("input[name='amount']").val();

if(description == "" | delivery_time == "" | amount == ""){

swal({
type: 'warning',
text: 'You Must Need To Fill Out All Fields Before Submitting Offer.'
});

}else{


$.ajax({
	
method: "POST",
url: "<?php echo $site_url; ?>/requests/insert_offer",
data: $('#proposal-details-form').serialize()

}).done(function(data){
	
$("#submit-proposal-details").modal('hide');

$("#insert_offer").html(data);
	
});
	

}

});
	
	
});

</script>