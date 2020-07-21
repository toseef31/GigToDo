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
	$answer_type = $row_proposals->answer_type;

	
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
<html dir="rtl" lang="ar" class="ui-toolkit">

<head>
	<title><?= $site_name; ?> - Checkout</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?= $site_author; ?>">
	<!--====== Bootstrap css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
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
              <p>تفاصيل الطلب</p>
          </div>
    		</div>
      	<div class="col-lg-4 col-4">
          <div class="checkout-bar-area text-center">
              <img src="assets/img/checkout/bar-icon-2.png" alt=""><br>
              <span>2</span>
              <p>التقييم والدفع</p>
          </div>
      	</div>
    		<div class="col-lg-4 col-4">
          <div class="checkout-bar-area text-center">
              <img src="assets/img/checkout/bar-icon-3.2.png" alt=""><br>
              <span>3</span>
              <p>قدم متطلباتك وابدأ اطلب</p>
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
            <form method="post" enctype="multipart/form-data">
            	<div class="checkout-requirement-title">
            	    <h4 class="title">قدم متطلباتك وابدأ اطلب</h4>
            	</div>

            	<div class="checkout-requirement-content-2">
            	    <span>2. مرحبا بك الذهول الملكي!</span>
            	    <p class="text"><?= $buyer_instruction ?></p>
            	    <div class="checkout-requirement-textarea">
          	        <span>هل دة طلبك الاول؟</span>
            	    	<?php if ($answer_type == 'Free Text') { ?>
          	        <p>خلينا نعرف اسمك الأول و شوية معلومات عنك لو حابب ! (اختيارى)</p>
          	        <textarea name="order_description" id="#" cols="30" rows="10" placeholder="Type your message here..."></textarea>
          	        <?php } ?>
          	        <?php if ($answer_type == 'Attachment') { ?>
          	        <div class="pusrchase-form d-flex justify-content-between align-items-center">
          	            <div class="attach-file">
          	                <input type="file" id="file" name="order_require_file">
          	                <label for="file"><img src="assets/img/post-request/attach.png" alt="">Attach File</label>
          	                <span class="max-size">Max Size 30MB</span>
          	            </div>
          	            <!-- <div class="chars-max">
          	                <p class="text">0/2500 Chars Max</p>
          	            </div> -->
          	        </div>
            	  		<?php } ?>
            	    </div>
            	</div>
            	<div class="checkout-requirement-content-3">
            	    <span>3- التعليمات</span>
            	    <p><?= $buyer_instruction ?></p>
            	    <button type="submit" name="submit_requirement">التقديم</button>
            	</div>
            </form>
            <?php 
              if(isset($_POST['submit_requirement'])){
                // $order_industry = $input->post('order_industry');
                $order_description = $input->post('order_description');

                $order_require_file = $_FILES['order_require_file']['name'];
                // print_r($order_require_file);die();
                $order_require_file_tmp = $_FILES['order_require_file']['tmp_name'];
                
                $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
                $file_extension = pathinfo($order_require_file, PATHINFO_EXTENSION);
                if(!empty($order_require_file)){
                  if(!in_array($file_extension,$allowed)){
                    echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
                    echo "<script>window.open('checkout2?order_id=$order_id','_self')</script>";
                    exit();
                  }
                  $order_require_file = pathinfo($order_require_file, PATHINFO_FILENAME);
                  $order_require_file = $order_require_file."_".time().".$file_extension";
                  move_uploaded_file($order_require_file_tmp,"../order_files/$order_require_file");
                }
                
                $update_order = $db->update("orders",array("order_require_file" => $order_require_file, "order_description" => $order_description),array("order_id" => $order_id));
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
							الملخص
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
								<h4>كل العناصر اللي بتحتويها الباقة</h4>
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
									<span>رسوم التحويل</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $processing_fee;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $processing_fee,2);}else{  echo $s_currency.' '; echo $processing_fee; } ?></span>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card">
								<div class="processing-fee d-flex flex-row justify-content-between">
									<span>ضريبة البضائع والخدمات</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $gst;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $gst,2);}else{  echo $s_currency.' '; echo $gst; } ?></span>
								</div>
							</div>
							<!-- Each item -->
							<div class="summary-card d-flex flex-column">
								<div class="totoal-fee d-flex flex-row justify-content-between">
									<span>لاجمالى</span>
									<span><?php if ($to == 'EGP'){ echo $to.' '; echo $total;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $total,2);}else{  echo $s_currency.' '; echo $total; } ?></span>
								</div>
								<div class="delivery-time d-flex flex-row justify-content-between">
									<span>اجمالى وقت التسليم</span>
									<span><?= $proposal_delivery_time; ?> </span>
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