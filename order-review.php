<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("includes/db.php");
require_once("functions/email.php");
require_once("functions/functions.php");

if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";  
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_timezone = $row_login_seller->seller_timezone;
$login_seller_type = $row_login_seller->account_type;

$order_id = $input->get("order_id");

$get_orders = $db->query("select * from orders where (seller_id=$login_seller_id or buyer_id=$login_seller_id) AND order_id=:o_id",array("o_id"=>$order_id));
$count_orders = $get_orders->rowCount();

if($count_orders == 0){
  echo "<script>window.open('index.php?not_available','_self')</script>";
}

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

//// Select Order Proposal Details ///
$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));
$row_proposal = $select_proposal->fetch();
$proposal_title = $row_proposal->proposal_title;
$proposal_img1 = $row_proposal->proposal_img1;
$proposal_url = $row_proposal->proposal_url;
$buyer_instruction = $row_proposal->buyer_instruction;

$get_p = $db->select("proposal_packages",array("proposal_id"=>$proposal_id));
$row_p = $get_p->fetch();
$delivery_time = $row_p->delivery_time;
$revisions = $row_p->revisions;
$description = $row_p->description;
// print_r($row_p);

$get_buyer_instructions = $db->query("select buyer_instruction from proposals where proposal_id='$proposal_id'");
$count_buyer_instruction = $get_buyer_instructions->rowCount();
if($count_buyer_instruction == 0){
  $update_order = $db->update("orders",array("order_status"=>"progress"),array("order_id"=>$order_id));
}


if($videoPlugin == 1){
  require_once("plugins/videoPlugin/order_details.php");  
}else{
  $enableVideo = 0;
  $count_schedule = 0;
}

$get_site_logo_image = $row_general_settings->site_logo_image;
$order_auto_complete = $row_general_settings->order_auto_complete;

if($order_status == "delivered"){
  $currentDate = new DateTime("now");
  if(!empty($complete_time)){
    $endDate = new DateTime($complete_time);
    if($currentDate >= $endDate){
      require_once("orderIncludes/orderComplete.php");
    }
  }
}

if($seller_id == $login_seller_id){
  $receiver_id = $buyer_id;
}else{
  $receiver_id = $seller_id;
}
// print_r($receiver_id);
$get_buyer_reviews = $db->select("buyer_reviews",array("order_id"=>$order_id));
$count_buyer_reviews = $get_buyer_reviews->rowCount();
$row_buyer_reviews = $get_buyer_reviews->fetch();

if($count_buyer_reviews == 1){
$buyer_rating = $row_buyer_reviews->buyer_rating;
$buyer_review = $row_buyer_reviews->buyer_review;
$review_buyer_id = $row_buyer_reviews->review_buyer_id;
$review_date = $row_buyer_reviews->review_date;

$select_buyer = $db->select("sellers",array("seller_id" => $review_buyer_id));
$row_buyer = $select_buyer->fetch();
$buyer_user_name = $row_buyer->seller_user_name;
$buyer_image = $row_buyer->seller_image;
}
?>

<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
  <title><?= $site_name; ?> - Resolution Select Issue</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?= $site_desc; ?>">
  <meta name="keywords" content="<?= $site_keywords; ?>">
  <meta name="author" content="<?= $site_author; ?>">
  <!--====== Favicon Icon ======-->
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="<?= $site_url; ?>/images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <!--====== Bootstrap css ======-->
  <link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ===-->
  <link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Rateyo css ======-->
  <link href="<?= $site_url; ?>/assets/css/jquery.rateyo.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
  <link href="styles/fontawesome-stars.css" rel="stylesheet">
  <!-- <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <!-- <link href="styles/proposalStyles.css" rel="stylesheet"> -->
  <!-- <link href="styles/user_nav_styles.css" rel="stylesheet"> -->
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
  <script type="text/javascript" src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.barrating.min.js"></script>
  <script type="text/javascript" src="js/jquery.sticky.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
  <?php } ?>

  <script>
  function alert_success(text,url){
    swal({
    type: 'success',
    timer : 3000,
    text: text,
    onOpen: function(){
      swal.showLoading()
    }
    }).then(function(){
      if(url != ""){
      window.open(url,'_self');
    }
    });
  }

</script>

</head>

<body class="all-content">
  <!-- Preloader Start -->
    <div class="proloader">
      <div class="loader">
        <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
      </div>
    </div>
    <!-- Preloader End -->
  <?php
    if ($login_seller_type == 'buyer') {
      require_once("includes/buyer-header.php"); 
   }else{
      require_once("includes/user_header.php");
   } 
  ?>

  <main>
      <section class="container-fluid order-view">
        <div class="row">
          <div class="container">
            <!-- Row -->
            <div class="row">
              <div class="col-12 col-lg-8">
                <div class="order-card">
                  <div class="order-require">
                    <div class="order-require-header d-flex flex-wrap align-items-start">
                      <div class="icon">
                        <img alt="" class="img-fluid d-block" src="assets/img/order/feedback-icon.png" />
                      </div>
                      <div class="text">
                        <span>Public Feedback</span>
                        <span>Share your experience with the community, to help them make better decisions.</span>
                      </div>
                    </div>
                  </div>
                  <div class="rating-container d-flex flex-column">
                    <div class="rating-items d-flex flex-row align-items-start justify-content-between">
                      <div class="rating-content">
                        <h4>Overall rating</h4>
                        <p>How was the seller during the process?</p>
                      </div>
                      <div class="star-rating"></div>
                    </div>
                    <!-- Each item -->
                    <div class="rating-items d-flex flex-row align-items-start justify-content-between">
                      <div class="rating-content">
                        <h4>Communication with seller</h4>
                        <p>How responsive was the seller during the process?</p>
                      </div>
                      <div class="communication-rating"></div>
                    </div>
                    <!-- Each item -->
                    <div class="rating-items d-flex flex-row align-items-start justify-content-between">
                      <div class="rating-content">
                        <h4>Service as described</h4>
                        <p>Did the result match the gig’s description?</p>
                      </div>
                      <div class="service-rating"></div>
                    </div>
                    <!-- Each item -->
                    <div class="rating-items d-flex flex-row align-items-start justify-content-between">
                      <div class="rating-content">
                        <h4>Buy again or recommend</h4>
                        <p>Would you recommend buying this gig?</p>
                      </div>
                      <div class="buy-rating"></div>
                    </div>
                    <!-- Each item -->
                    <div class="rating-items d-flex flex-wrap align-items-start">
                      <div class="rating-content">
                        <h4>What was it like working with this seller?</h4>
                      </div>
                      <form method="POST">
                        
                        <input type="hidden" name="buyer_rating">
                        <input type="hidden" name="communication_rating">
                        <input type="hidden" name="service_rating">
                        <input type="hidden" name="recommend_rating">
                        <div class="row flex-row-reverse">
                          <div class="col-12 col-sm-4">
                            <div class="selected-gig-item d-flex flex-column">
                              <div class="image">
                                <?php if ($proposal_img1 != '') { ?>
                                  <img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>">
                                <?php }else{ ?>
                                <img src="assets/img/checkout/summary-thumb.jpg" alt="">
                                <?php } ?>
                                <div class="gig-active">
                                  <i class="fal fa-check"></i>
                                </div>
                              </div>
                              <div class="text">Add to your review</div>
                            </div>
                          </div>
                          <div class="col-12 col-sm-8">
                            <textarea class="form-control" placeholder="Why did you buy this gig? Did the seller help you achieve your goal?" rows="5" name="review"><?= $buyer_review ?></textarea>
                            <label class="bottom-label">0/350 Characters</label>
                          </div>
                        </div>
                        <?php if($count_buyer_reviews == 0){ ?>
                        <div class="row">
                          <div class="col-12 col-sm-8 d-flex flex-row justify-content-end">
                            <button class="button button-red" type="submit" name="buyer_review_submit">Submit</button>
                          </div>
                        </div>
                        <?php } ?>
                      </form>
                      <?php

                      if(isset($_POST['buyer_review_submit'])){

                      $rating = $input->post('buyer_rating');
                      $communication_rating = $input->post('communication_rating');
                      $service_rating = $input->post('service_rating');
                      $recommend_rating = $input->post('recommend_rating');

                      $review = $input->post('review');

                      $date = date("M d Y");

                      $insert_review = $db->insert("buyer_reviews",array("proposal_id"=>$proposal_id,"order_id"=>$order_id,"review_buyer_id"=>$buyer_id,"buyer_rating"=>$rating,"communication_rating"=>$communication_rating,"service_rating"=>$service_rating,"recommend_rating"=>$recommend_rating,"buyer_review"=>$review,"review_seller_id"=>$receiver_id,"review_date"=>$date));

                      $last_update_date = date("F d, Y");

                      $insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $buyer_id,"order_id" => $order_id,"reason" => "buyer_order_review","date" => $last_update_date,"status" => "unread"));

                      $ratings = array();


                      $sel_proposal_reviews = $db->select("buyer_reviews",array("proposal_id"=>$proposal_id));
                          
                      while($row_proposals_reviews = $sel_proposal_reviews->fetch()){
                        
                        $proposal_buyer_rating = $row_proposals_reviews->buyer_rating;
                        
                        array_push($ratings,$proposal_buyer_rating);
                        
                      }
                        
                      array_push($ratings,$rating);
                        
                      $total = array_sum($ratings);
                        
                      $avg = $total/count($ratings);
                        
                      $updated_propoasl_rating = substr($avg,0,1);


                      if($rating == "5"){

                      if($order_seller_rating == "100"){

                      }else{

                      $review_rating = $order_seller_rating+7; if($review_rating > 100){ $review_rating = 100; }
                      $update_seller_rating = $db->query("update sellers set seller_rating=$review_rating where seller_id='$receiver_id'");  

                      }


                      }elseif($rating == "4"){

                      if($order_seller_rating == "100"){

                      }else{

                      $review_rating = $order_seller_rating+2; if($review_rating > 100){ $review_rating = 100; }
                      $update_seller_rating = $db->query("update sellers set seller_rating=$review_rating where seller_id='$receiver_id'");  

                      }

                      }elseif($rating == "3"){

                      $review_rating = $order_seller_rating-3; if($review_rating < 0){ $review_rating = 0; }
                      $update_seller_rating = $db->query("update sellers set seller_rating=$review_rating where seller_id='$receiver_id'");  

                      }elseif($rating == "2"){

                      $review_rating = $order_seller_rating-5; if($review_rating < 0){ $review_rating = 0; }
                      $update_seller_rating = $db->query("update sellers set seller_rating=$review_rating where seller_id='$seller_id'");  

                      }elseif($rating == "1"){

                      $review_rating = $order_seller_rating-7; if($review_rating < 0){ $review_rating = 0; }
                      $update_seller_rating = $db->query("update sellers set seller_rating=$review_rating where seller_id='$receiver_id'");  

                      }

                      $update_proposal_rating = $db->update("proposals",array("proposal_rating" => $updated_propoasl_rating),array("proposal_id" => $proposal_id));

                      if($update_proposal_rating){

                      echo "<script>

                                swal({
                                  type: 'success',
                                  text: 'Review submitted successfully!',
                                  timer: 3000,
                                  onOpen: function(){
                                  swal.showLoading()
                                  }
                                  }).then(function(){
                                   window.open('order_details?order_id=$order_id','_self')
                                });

                              </script>";

                      }


                      }

                      ?>
                    </div>
                    <!-- Each item -->
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="checkout-summary">
                  <div class="summary-header">
                    Summary
                  </div>
                  <div class="cummary-body">
                    <div class="summary-card d-flex flex-row align-items-start">
                      <div class="image">
                        <?php if ($proposal_img1 != '') { ?>
                          <img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>">
                        <?php }else{ ?>
                        <img src="assets/img/checkout/summary-thumb.jpg" alt="">
                        <?php } ?>
                      </div>
                      <div class="text">
                        <p><?= $description; ?></p>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <h4>All the items included in package</h4>
                      <ul class="list-inline d-flex flex-wrap">
                        <li class="list-inline-item d-flex flex-row align-items-start">
                          <span>
                            <img class="img-fluid d-block" src="assets/img/checkout/check-icon.png" />
                          </span>
                          <span><?= $revisions ?> Revisions</span>
                        </li>
                      </ul>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <div class="processing-fee d-flex flex-row justify-content-between">
                        <span>Processing Fee</span>
                        <span><?= $order_fee; ?></span>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card">
                      <div class="processing-fee d-flex flex-row justify-content-between">
                        <span>No GST</span>
                        <span>&nbsp;</span>
                      </div>
                    </div>
                    <!-- Each item -->
                    <div class="summary-card d-flex flex-column">
                      <div class="totoal-fee d-flex flex-row justify-content-between">
                        <span>Total</span>
                        <span><?= $s_currency; ?> <?= $total ?></span>
                      </div>
                      <div class="delivery-time d-flex flex-row justify-content-between">
                        <span>Total Delivery Time</span>
                        <span><?= $delivery_time ?></span>
                      </div>
                    </div>
                    <!-- Each item -->
                  </div>
                </div>
                <!-- Checkout summary -->
              </div>
            </div>
            <!-- Row -->
          </div>
        </div>
      </section>
    </main>

<script>
  $('#continue_buyer_issue').click(function(){
    var reason = $("input[name='customRadio_buyer']:checked").val();
    // alert(reason);
    $("input[name='cancellation_reason']").val(reason);
    $('#buyer-submit').addClass('active');
    $('#buyer_select_issue').hide();
    $('#submit-issue').show();
  });
  $('#continue_seller_issue').click(function(){
    var reason_seller = $("input[name='customRadio_seller']:checked").val();
    // alert(reason_seller);
    $("input[name='cancellation_reason']").val(reason_seller);
    $('#step-2').addClass('active');
    $('#seller_select_issue').hide();
    $('#submit_issue_seller').show();
  });
</script>
<script>
  $(function(){
    $(".star-rating").rateYo({
      rating: 0,
      starWidth: "20px"
    });
    $(".communication-rating").rateYo({
      rating: 0,
      starWidth: "20px"
    });
    $(".service-rating").rateYo({
      rating: 0,
      starWidth: "20px"
    });
    $(".buy-rating").rateYo({
      rating: 0,
      starWidth: "20px"
    });
    $('.star-rating').click(function(){
      var $rateYo = $(".star-rating").rateYo();
      var rating = $rateYo.rateYo("rating");
      // alert(rating);
      $("input[name='buyer_rating']").val(rating);
    });
    $('.communication-rating').click(function(){
      var $rateYo = $(".communication-rating").rateYo();
      var communication_rating = $rateYo.rateYo("rating");
      $("input[name='communication_rating']").val(communication_rating);
      // alert(rating);
    });
    $('.service-rating').click(function(){
      var $rateYo = $(".service-rating").rateYo();
      var service_rating = $rateYo.rateYo("rating");
      $("input[name='service_rating']").val(service_rating);
      // alert(service_rating);
    });
    $('.buy-rating').click(function(){
      var $rateYo = $(".buy-rating").rateYo();
      var buy_rating = $rateYo.rateYo("rating");
      $("input[name='recommend_rating']").val(buy_rating);
      // alert(buy_rating);
    });
  });
  
</script>
<?php require_once("includes/footer.php"); ?>

</body>
</html>