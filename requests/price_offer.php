<?php
session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}
$price = $input->post('price');
$request_id = $input->post('request_id');
// print_r($price);die();
?>
<div class="col-12">
	<?php if($count_offers == "0"){ ?>
	<div class="offer-items d-flex flex-wrap rounded-0 mb-3">
		<div class="card-body">
			<h3 class="text-center"> <i class="fa fa-frown-o"></i> Unfortunately, no offers yet. Please wait a little longer.</h3>
		</div>
	</div>
	<?php }else{ ?>
	<?php 
		if ($price == 1) {
			$get_offers = $db->select("send_offers",array("request_id" => $request_id, "status" => 'active'));
		}else{
			$get_offers = $db->select("send_offers",array("request_id" => $request_id, "status" => 'active', "amount" => $price));
		}
		$count_offers = $get_offers->rowCount();
		while($row_offers = $get_offers->fetch()){
		$offer_id = $row_offers->offer_id;
		$proposal_id = $row_offers->proposal_id;
		$description = $row_offers->description;
		$delivery_time = $row_offers->delivery_time;
		$amount = $row_offers->amount;
		$sender_id = $row_offers->sender_id;
		$select_sender = $db->select("sellers",array("seller_id" => $sender_id));
		$row_sender = $select_sender->fetch();
		$sender_user_name = $row_sender->seller_user_name;
		$sender_level = $row_sender->seller_level;
		$sender_image = $row_sender->seller_image;
		$sender_status = $row_sender->seller_status;
		$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
		$row_proposals = $select_proposals->fetch();
		$proposal_title = $row_proposals->proposal_title;
		$proposal_url = $row_proposals->proposal_url;
		$proposal_img1 = $row_proposals->proposal_img1;
	?>
	<div class="offer-items d-flex flex-wrap offer-<?= $offer_id; ?>">
		<div class="offer-item-image">
			<?php if (!empty($proposal_img1)){ ?>
			<img class="img-fluid d-block" src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" />
			<?php }else{ ?>
			<img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
			<?php } ?>
		</div>
		<div class="offer-item-content d-flex flex-column">
			<div class="d-flex flex-row align-items-start justify-content-between">
				<div class="d-flex flex-row align-items-center">
					<div class="offer-item-user-image position-relative">
						<?php if(!empty($sender_image)){ ?>
            <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle" >
            <?php if($sender_status == "online"){ ?>
            <span class="active"></span>
          	<?php } ?>
            <?php }else{ ?>
            <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
              <?php if($sender_status == "online"){ ?>
              <span class="active"></span>
            	<?php } ?>
            <?php } ?>
					</div>
					<div class="offer-item-user-content d-flex flex-column justify-content-start">
						<span class="user-name"><?php echo $sender_user_name; ?></span>
						<a href="../conversations/message?seller_id=<?php echo $sender_id; ?>&offer_id=<?php echo $offer_id; ?>" class="d-flex flex-row align-items-center">
							<span>
								<img src="<?= $site_url; ?>/assets/img/offer/mail-icon.png">
							</span>
							<span>Contact Me</span>
						</a>
					</div>
				</div>
				<div class="d-flex flex-column offer-item-budget">
					<span>Budget</span>
					<span><?php if ($to == 'EGP'){ echo $to.' '; echo $amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $amount,2);}else{  echo $s_currency.' '; echo $amount; } ?></span>
				</div>
			</div>
			<p><?php echo $description; ?></p>
			<div class="row">
				<div class="col-12 col-lg-6">
					<ul class="list-inline d-flex flex-wrap">
						<li class="list-inline-item d-flex flex-row align-items-center">
							<span><i class="fal fa-clock"></i></span>
							<span>Deliver Time: <strong><?php echo $delivery_time; ?></strong></span>
						</li>
						<li class="list-inline-item d-flex flex-row align-items-center">
							<span><i class="fal fa-sync"></i></span>
							<span>Unlimited Revisions</span>
						</li>
					</ul>
				</div>
				<div class="col-12 col-lg-6">
					<div class="d-flex flex-row justify-content-lg-end">
						<a class="button button-transparent" href="javascript:void(0);" onclick="hideOffer(<?= $offer_id; ?>)">Remove Offer</a>
						<form method="post" action="../offer-checkout" id="offer<?= $offer_id; ?>">
							<input type="hidden" name="request_id" value="<?= $request_id; ?>">
							<input type="hidden" name="offer_id" value="<?= $offer_id; ?>">
							<input type="hidden" name="proposal_qty" value="1">
							<button class="button button-red" name="add_order">Order Now</button>
						</form>
					</div>
				</div>
			</div>
			<!-- Row -->
		</div>
	</div>
	<!-- Each item -->
<?php } }?>
</div>