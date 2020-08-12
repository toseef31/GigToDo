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
$login_seller_image = $row_login_seller->seller_image;

$receiver_id = $input->post('receiver_id');
$message = $input->post('message');
$file = $input->post('file');

$select_receiver_seller = $db->select("sellers",array("seller_id" => $receiver_id));
$row_receiver_seller = $select_receiver_seller->fetch();
$receiver_seller_id = $row_receiver_seller->seller_id;
$receiver_user_name = $row_receiver_seller->seller_user_name;
$receiver_image = $row_receiver_seller->seller_image;


?>
<div id="send-request-modal" class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true"><!-- send-offer-modal modal fade Starts -->
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
	          <?php if(!empty($receiver_image)){ ?>
	          <img src="<?= $site_url ?>/user_images/<?= $receiver_image; ?>" alt="profile" class="rounded-circle">
	          <?php }else { ?>
	          <img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="profile">
	          <?php } ?>
	        </div>
	        <div class="profile-content media-body">
	          <h6 class="profile-name"><?= ucfirst($receiver_user_name); ?></h6>
	          <p class="texts">Hi. please provide your request details below and i’ll get back to you.</p>
	        </div>
	      </div>
	      <form action="" method="post" id="request-detail-form" enctype="multipart/form-data">
	      	<input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
	      	<input type="hidden" name="message" value="<?= $message; ?>">
	      	<input type="hidden" name="file" value="<?= $file; ?>">
	        <div class="form-group pt-4">
	          <label class="control-label d-flex align-items-start">
	            <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-1.png" alt="Icon"></span>
	            <span>Describe the service you’re looking to purchase</span>
	          </label>
	          <textarea class="form-control" id="textarea" name="request_description" placeholder="I’m looking for..." rows="5"></textarea>
	          <div class="bottom-label d-flex flex-row align-items-center justify-content-between mb-30 mt-15">
	            <div class="attach-file d-flex flex-row align-items-center">
	              <label for="request_file">
	                <input type="file" id="request_file" name="request_file" hidden="">
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
	              $get_delivery_times = $db->select("delivery_times", array("type"=>''));
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
</div><!-- send-offer-modal modal fade Ends -->
<div id="insert_request"></div>

<textarea id="message" class="d-none"><?php echo $message; ?></textarea>
<script>
$(document).ready(function(){
	$("#send-request-modal").modal('show');

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
	$('#request_file').change(function() {
	  var i = $(this).prev('label').clone();
	  var file = $('#request_file')[0].files[0].name;
	  
	  $('#file_name').html('<span>'+file+'</span>');
	  // $(this).prev('label').text(file);
	});
	$('#request_file').bind('change', function() {
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

	$("#request-detail-form").submit(function(event){
		
		event.preventDefault();
		
		request_description = $("textarea[name='request_description']").val();
		delivery_time = $("input[name='delivery_time']:checked").val();
		request_budget = $("input[name='request_budget']").val();
		
		if(request_description == "" || delivery_time == undefined || request_budget == ""){
			swal({
				type: 'warning',
				text: 'You Must Need To Fill Out All Fields Before Submitting Offer.'
			});
		}else{
			$.ajax({	
				method: "POST",
				url: "<?php echo $site_url; ?>/conversations/insert_request",
				data: $('#request-detail-form').serialize()
			}).done(function(data){
				$("#send-request-modal").modal('hide');			
				$("#insert_request").html(data);
				
			});
		}
	});
});
</script>