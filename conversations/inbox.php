<?php
session_start();
require_once("../includes/db.php");
require_once("../functions/email.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('../login','_self');</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;
$login_seller_account_type = $row_login_seller->account_type;
require("includes/inboxFunctions.php");



  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
       $url = "https://";   
  else  
       $url = "http://";   
  // Append the host(domain name, ip) to the URL.   
  $url.= $_SERVER['HTTP_HOST'];   

  // Append the requested resource location to the URL   
  $url.= $_SERVER['REQUEST_URI'];    
  $full_url = $_SERVER['REQUEST_URI'];

  $page_url = substr("$full_url", 15);


?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - <?php echo $lang["titles"]["inbox"]; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  
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
  <!-- <link href="../styles/bootstrap.css" rel="stylesheet">
  <link href="../styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="../styles/inbox-style.css" rel="stylesheet"> 
  <!-- Custom css code from modified in admin panel - -->
  <link href="../styles/styles.css" rel="stylesheet">
  <link href="../styles/user_nav_styles.css" rel="stylesheet">
  <link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../styles/sweat_alert.css" rel="stylesheet">
  <link href="../styles/emoji.css" rel="stylesheet">
  <script type="text/javascript" src="../js/sweat_alert.js"></script>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script src="https://checkout.stripe.com/checkout.js"></script>
  <script src="../js/emoji.js<?php echo '?v='.mt_rand(); ?>"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <style>.media.selected{background-color: #f7f7f7 !important;}.user-status{background: transparent !important; padding: 0 !important; margin-bottom: 0;}.message-sender-area{padding: 0 30px 20px !important;}.header-top{background-color: white;}#send_offer_modal{display: none !important;}</style>
</head>
<body class="all-content">

<?php
  if ($login_seller_account_type == 'seller') {
    require_once("../includes/user_header.php");
  }else{
    require_once("../includes/buyer-header.php");
  }
 //require_once("../includes/user_header-inbox.php"); ?>

  <main>
    <section class="container-fluid messages-wrapper">
      <div class="row">
        <div class="container">
          <div class="messages-container d-flex flex-wrap">
            <?php require_once("includes/sidebar.php"); ?>
            <?php require_once("includes/body.php"); ?>
          </div>
        </div>
      </div>
    </section>
  </main>


<!-- <div class="container-fluid pl-md-5 pr-md-5 p-0">
  <div class="row mr-0 ml-0 mt-sm-0 mt-md-4 mb-md-4 box-inbox">
    <?php //require_once("includes/sidebar.php"); ?>
    <?php //require_once("includes/body.php"); ?>
  </div>
</div> -->
<!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
      <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
    </div>
  </div>
  <!-- Preloader End -->
<div id="upload_file_div"></div>
<div id="accept-offer-div"></div>
<div id="send-offer-div"></div>
<!-- Customer Order Puppup Start-->
<!-- Modal -->
<div class="modal fade" id="custom_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            <?php if(!empty($get_seller_image)){ ?>
            <img src="user_images/<?= $get_seller_image; ?>" alt="profile" class="rounded-circle">
            <?php }else { ?>
            <img src="<?= $site_url; ?>/assets/img/seller-profile/profile-img.png" alt="profile">
            <?php } ?>
          </div>
          <div class="profile-content media-body">
            <h6 class="profile-name"><?= ucfirst($seller_user_name); ?></h6>
            <p class="texts">Hi. please provide your request details below and i’ll get back to you.</p>
          </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="control-label d-flex align-items-start">
              <span><img src="<?= $site_url; ?>/assets/img/post-request/icon-1.png" alt="Icon"></span>
              <span>Describe the service you’re looking to purchase</span>
            </label>
            <textarea class="form-control" id="textarea" name="request_description" placeholder="I’m looking for..." rows="5"></textarea>
            <div class="bottom-label d-flex flex-row align-items-center justify-content-between mb-30 mt-15">
              <div class="attach-file d-flex flex-row align-items-center">
                <label for="file">
                  <input type="file" id="file" name="request_file" hidden="">
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
                $get_delivery_times = $db->select("delivery_times");
                while($row_delivery_times = $get_delivery_times->fetch()){
                $delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
                $delivery_id = $row_delivery_times->delivery_id;
              ?>
              <label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
                <input id="hours<?= $delivery_id; ?>"  value="<?= $delivery_proposal_title; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title){ echo "checked"; } ?> type="radio" name="delivery_time" hidden />
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
</div>
<!-- Customer Order Puppup END-->
<?php require_once("includes/javascript.php"); ?>
<?php require_once("../includes/footerInbox.php"); ?>
</body>
</html>