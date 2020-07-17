<?php
	session_start();
	require_once("includes/db.php");
	require_once("functions/processing_fee.php");

	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('login','_self')</script>";
	}

	

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	
	$order_id = $input->get("order_id");

	$get_orders = $db->select("orders",array("order_id"=>$order_id));
	$count_orders = $get_orders->rowCount();

	$row_orders = $get_orders->fetch();
	$order_id = $row_orders->order_id;
	$order_number = $row_orders->order_number;
	if($videoPlugin == 1){
	  $order_minutes = $row_orders->order_minutes;
	}
	$proposal_id = $row_orders->proposal_id;
	$seller_id = $row_orders->seller_id;
	$buyer_id = $row_orders->buyer_id;
	$order_price = $row_orders->order_price;
	$order_qty = $row_orders->order_qty;
	$order_date = $row_orders->order_date;
	$order_duration = $row_orders->order_duration;
	$order_time = $row_orders->order_time;
	$order_fee = $row_orders->order_fee;
	$order_desc = $row_orders->order_description;
	$order_status = $row_orders->order_status;
	$total = $order_price+$order_fee;



	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
	$row_proposals = $select_proposals->fetch();
	$buyer_instruction = $row_proposals->buyer_instruction;

	
	$get_p = $db->select("proposal_packages",array("proposal_id"=>$proposal_id));
	$row_p = $get_p->fetch();
	$proposal_price = $row_p->price;
	$single_price = $row_p->price;
	$proposal_description = $row_p->description;
	$proposal_revision = $row_p->revisions;
	$proposal_delivery_time = $row_p->delivery_time;
	
	$proposal_title = $row_proposals->proposal_title;
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	$proposal_url = $row_proposals->proposal_url;
	$proposal_img1 = $row_proposals->proposal_img1;

	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
	$row_seller = $select_seller->fetch();
	$proposal_seller_user_name = $row_seller->seller_user_name;
	$proposal_seller_vacation = $row_seller->seller_vacation;
	$login_seller_account_number = $row_login_seller->seller_m_account_number;

	if($row_proposals->proposal_seller_id == $login_seller_id or $proposal_seller_vacation == "on"){
		echo "<script>window.open('index','_self')</script>";
	}

	$sub_total = $proposal_price;

	$processing_fee = processing_fee($sub_total);
	$gst = 3;
	$total = $processing_fee + $sub_total + $gst;

	$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
	$row_seller_accounts = $select_seller_accounts->fetch();
	$current_balance = $row_seller_accounts->current_balance;
	
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">

<head>
	<title><?= $site_name; ?> - Checkout</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?= $site_author; ?>">
	<!--====== Bootstrap css ======-->
  <link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
	<link href="styles/styles.css" rel="stylesheet">
	<!-- <link href="styles/categories_nav_styles.css" rel="stylesheet"> -->
	<!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet"> -->
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
	<link href="styles/sweat_alert.css" rel="stylesheet">
	<script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<?php if(!empty($site_favicon)){ ?>
	<link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
	<?php } ?>
</head>
<body class="all-content">
<?php
require_once("includes/buyer-header.php");?>

	<!-- checkout bar START-->
	<div class="checkout-bar pt-60">
		<div class="container position-relative">
			<div class="border"></div>
			<div class="row no-gutters">
				<div class="col-lg-4 col-4">
					<div class="checkout-bar-area text-center">
						<img src="assets/img/checkout/bar-icon-1.png" alt=""><br>
						<span>1</span>
						<p>Order Details</p>
					</div>
				</div>
				<div class="col-lg-4 col-4">
					<div class="checkout-bar-area text-center">
						<img src="assets/img/checkout/bar-icon-2.png" alt=""><br>
						<span>2</span>
						<p>Review and Pay</p>
					</div>
				</div>
				<div class="col-lg-4 col-4">
          <div class="checkout-bar-area text-center">
            <img src="assets/img/checkout/bar-icon-3.2.png" alt=""><br>
            <span>3</span>
            <p>Submit Requirements and Start Order</p>
          </div>
      	</div>
			</div>
		</div>
	</div>
	<!-- checkout bar END-->
	<!-- checkout payment START-->
	<div class="checkout-payment-area gray-bg">
		<div class="container  pb-45">
			<div class="row">
				<!-- Step 3 start -->
				<div class="col-12 col-lg-8" id="submit_requirement">
          <div class="checkout-requirement-area bg-white mt-30">
            <form method="post">
            	<div class="checkout-requirement-title">
            	    <h4 class="title">Submit Requirements to Start Your Order</h4>
            	</div>
            	<div class="checkout-requirement-content pb-35">
            	    <span>The seller needs the following information to start working on your order:</span>
            	    <p>1. what industry does this order relate to? (optional)</p>
            	    <input type="text" name="order_industry" class="form-control">
            	</div>
            	<div class="checkout-requirement-content-2">
            	    <span>2. hello your royal awesomeness!</span>
            	    <p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
            	    <div class="checkout-requirement-textarea">
            	        <span>1st order?</span>
            	        <p>Please let us know your first name and a few words about you if you want! (optional)</p>
            	        <textarea name="order_description" id="#" cols="30" rows="10" placeholder="Type your message here..."></textarea>
            	        <!-- <div class="pusrchase-form d-flex justify-content-between align-items-center">
            	            <div class="attach-file">
            	                <input type="file" id="file">
            	                <label for="file"><img src="assets/img/post-request/attach.png" alt="">Attach File</label>
            	                <span class="max-size">Max Size 30MB</span>
            	            </div>
            	            <div class="chars-max">
            	                <p class="text">0/2500 Chars Max</p>
            	            </div>
            	        </div> -->
            	    </div>
            	</div>
            	<div class="checkout-requirement-content-3">
            	    <span>3. Instructions</span>
            	    <p><?= $buyer_instruction ?></p>
            	    <button type="submit" name="submit_requirement">submit</button>
            	</div>
            </form>
            <?php 
              if(isset($_POST['submit_requirement'])){
                $order_industry = $input->post('order_industry');
                $order_description = $input->post('order_description');
                
                $update_order = $db->update("orders",array("order_industry" => $order_industry, "order_description" => $order_description),array("order_id" => $order_id));
                if($update_order){
                	echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
                }
              }
            ?>
          </div>
      </div>
				<!-- Step 3 end -->
				<div class="col-12 col-lg-4">
					<div class="checkout-summary mt-30">
						<div class="summary-header">
							Summary
						</div>
						<div class="cummary-body">
							<div class="summary-card d-flex flex-row align-items-start">
								<div class="image">
									<img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" alt="">
								</div>
								<div class="text">
									<p><?= $proposal_description; ?></p>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<h4>All the items included in package</h4>
								<ul class="list-inline d-flex flex-wrap">
									<!-- <li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>Commercial Use</span>
									</li>
									<li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>300 Words Included</span>
									</li> -->
									<li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span><?= $proposal_revision; ?> Revisions</span>
									</li>
									<!-- <li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>Source File</span>
									</li>
									<li class="list-inline-item d-flex flex-row align-items-start">
										<span>
											<img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
										</span>
										<span>Topic Research</span>
									</li> -->
								</ul>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<div class="processing-fee d-flex flex-row justify-content-between">
									<span>Processing Fee</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $processing_fee;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $processing_fee,2);}else{  echo $s_currency.' '; echo $processing_fee; } ?></span>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<div class="processing-fee d-flex flex-row justify-content-between">
									<span>GST</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $gst;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $gst,2);}else{  echo $s_currency.' '; echo $gst; } ?></span>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card d-flex flex-column">
								<div class="totoal-fee d-flex flex-row justify-content-between">
									<span>Total</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $total;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $total,2);}else{  echo $s_currency.' '; echo $total; } ?></span>
								</div>
								<div class="delivery-time d-flex flex-row justify-content-between">
									<span>Total Delivery Time</span>
									<span><?= $proposal_delivery_time; ?> Days</span>
								</div>
							</div>
							<!-- Each item -->
						</div>
					</div>
					<!-- Checkout summary -->
				</div>
			</div>
		</div>
	</div>
	<!-- checkout payment END-->
<?php require_once("includes/footer.php"); ?>
</body>
</html>