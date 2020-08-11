<?php
session_start();
require_once("includes/db.php");
require_once("social-config.php");
require_once("functions/functions.php");

if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;

  $login_user_type = $row_login_seller->account_type;
  $login_seller_name = $row_login_seller->seller_name;
  $login_user_name = $row_login_seller->seller_user_name;
  $login_seller_offers = $row_login_seller->seller_offers;
  $gmail_verification = $row_login_seller->gmail_verification;
  $fb_verification = $row_login_seller->fb_verification;
  $seller_verification = $row_login_seller->seller_verification;
  $occuption = $row_login_seller->occuption;

  $relevant_requests = $row_general_settings->relevant_requests;

  if(isset($_GET['delete_language'])){
    $delete_language_id = $input->get('delete_language');
    $delete_language = $db->delete("languages_relation",array("relation_id"=>$delete_language_id,"seller_id"=>$login_seller_id));
    if($delete_language->rowCount() == 1){
      echo "<script>alert('One Language has been deleted.')</script>";
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }else{
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }
  }
  if(isset($_GET['delete_skill'])){
    $delete_skill_id = $input->get('delete_skill');
    $delete_skill = $db->delete("skills_relation",array("relation_id"=>$delete_skill_id,"seller_id"=>$login_seller_id));
    if($delete_skill->rowCount() == 1){
      echo "<script>alert('One skill has been deleted.')</script>";
      echo "<script> window.open('edit_profile?professional_info','_self') </script>";
    }else{
      echo "<script> window.open('edit_profile?professional_info','_self') </script>";
    }
  }
}


$get_seller_user_name = $input->get('seller_user_name');
$select_seller = $db->query("select * from sellers where seller_user_name=:u_name AND NOT seller_status='deactivated' AND NOT seller_status='block-ban'",array("u_name"=>$get_seller_user_name));
$count_seller = $select_seller->rowCount();
if($count_seller == 0){
  echo "<script>window.open('index?not_available','_self');</script>";
}

$get_requests = $db->select("buyer_requests",array("seller_id" => $seller_id,"request_status" => "active"),"DESC");                      
$count_requests = $get_requests->rowCount();

?>
<?php
$get_seller_user_name = $input->get('seller_user_name');

$select_seller = $db->select("sellers",array("seller_user_name" => $get_seller_user_name)); 
$row_seller = $select_seller->fetch();
$get_seller_id = $row_seller->seller_id;

$get_seller_user_name = $row_seller->seller_user_name;
$get_seller_image = $row_seller->seller_image;
$get_seller_cover_image = $row_seller->seller_cover_image;
if(empty($seller_cover_image)){ 
$get_seller_cover_image = "images/user-background.jpg";
}else{
$get_seller_cover_image = "cover_images/".rawurlencode($seller_cover_image)."";
}
$get_seller_country = $row_seller->seller_country;
$get_seller_state = $row_seller->seller_state;
$get_seller_city = $row_seller->seller_city;
$get_seller_headline = $row_seller->seller_headline;
$get_seller_about = $row_seller->seller_about;
$get_seller_level = $row_seller->seller_level;
$get_seller_lang = explode(',', $row_seller->seller_language);

$get_seller_rating = $row_seller->seller_rating;
$get_seller_register_date = $row_seller->seller_register_date;
$get_seller_recent_delivery = $row_seller->seller_recent_delivery;

$gmail_verification = $row_seller->gmail_verification;
$fb_verification = $row_seller->fb_verification;
$seller_verification = $row_seller->seller_verification;
$seller_paypal_email = $row_seller->seller_paypal_email;
$seller_payoneer_email = $row_seller->seller_payoneer_email;
$occuption = $row_seller->occuption;

$get_seller_status = $row_seller->seller_status;
$select_buyer_reviews = $db->select("buyer_reviews",array("review_seller_id"=>$get_seller_id)); 
$count_reviews = $select_buyer_reviews->rowCount();
if(!$count_reviews == 0){
  $rattings = array();
  while($row_buyer_reviews = $select_buyer_reviews->fetch()){
    $buyer_rating = $row_buyer_reviews->buyer_rating;
    array_push($rattings,$buyer_rating);
  }
  $total = array_sum($rattings);
  @$average = $total/count($rattings);
  $average_rating = substr($average ,0,1);
}else{
 $average = "0";  
 $average_rating = "0";
}
$level_title = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
$count_proposals = $db->count("proposals",array("proposal_seller_id" => $get_seller_id,"proposal_status" => 'active'));

$count_orders = $db->count("orders",array("seller_id" => $get_seller_id, "order_status" => 'completed'));
$delivered = $db->count("orders",array("seller_id"=>$get_seller_id,"order_status"=>'delivered'));

$total_buyer = $db->count("orders",array("seller_id"=>$get_seller_id));

if(!isset($_SESSION['seller_user_name'])){
$update_profile_views = $db->query("update sellers set profile_views=profile_views+1 where seller_id='$get_seller_id'");
}
if(isset($_SESSION['seller_user_name'])){
  if($get_seller_id != $login_seller_id ){
  $update_profile_views = $db->query("update sellers set profile_views=profile_views+1 where seller_id='$get_seller_id'");
  }
}


?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - <?php echo ucfirst($get_seller_user_name) . "'s Profile"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  
  <!--====== Favicon Icon ======-->
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <!--====== Bootstrap css ======-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <!-- <link href="styles/proposalStyles.css" rel="stylesheet">
  <link href="styles/categories_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="<?php echo $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
  <link href="<?php echo $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <style>.sub_cat .nice-select{display: none;}
    #file_name span{
      width: 130px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      display: inline-block;
    }
    #category{
      display: block !important;
    }
  </style>
</head>
<body class="all-content">  
  <!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
      <img src="assets/img/emongez_cube.png" />
    </div>
  </div>
  <!-- Preloader End -->      
<?php //require_once("includes/header.php");
  if(isset($_SESSION['seller_user_name'])){ 
    if($login_user_type == 'seller'){ 
      require_once('includes/user_header.php');
    }else{
      require_once("includes/buyer-header.php");
    }
  }else{
    require_once("includes/header_with_categories.php");
  }
?>


<!--  SELLER PROFILE area -->

  <div class="seller-profile-area pt-80 pb-80">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="profile-card text-center">
            <div class="profile">
              <?php if(check_status($get_seller_id) == "Online"){ ?>
              <div class="profile-status online">Online</div>
              <?php } ?>
              <div class="profile-image">
                <?php if(!empty($get_seller_image)){ ?>
                <img src="<?= $site_url; ?>/user_images/<?= $get_seller_image; ?>" class="rounded-circle" alt="profile">
                <?php }else { ?>
                <img src="assets/img/seller-profile/profile-img.png" alt="profile">
                <?php } ?>
              </div>
              <div class="profile-content mt-30">
                <h4 class="profile-name"><?= ucfirst($get_seller_user_name); ?></h4>
                <ul class="reting">
                  <?php
                    for($seller_i=0; $seller_i<$average_rating; $seller_i++){
                      echo " <li><i class='fa fa-star'></i></li> ";
                    }
                    for($seller_i=$average_rating; $seller_i<5; $seller_i++){
                      echo "<li><i class='fa fa-star-o'></i></li> ";
                    }
                    ?>
                  <li><span>(<?= $count_reviews; ?>) Reviews)</span></li>
                </ul>
                <p class="mb-0 mt-3"><?= $occuption; ?></p>
                <?php if(isset($_SESSION['seller_user_name'])){ ?>
                  <?php if($_SESSION['seller_user_name'] != $get_seller_user_name){ ?>
                    <ul class="profile-btn pt-20">
                      <li><a class="p-btn-1" href="<?= $site_url; ?>/conversations/message?seller_id=<?= $get_seller_id ?>">Contact me</a></li>
                      <li><a class="p-btn-2" href="javascript:void(0);" data-toggle="modal" data-target="#custom_order">Custom order</a></li>
                    </ul>
                  <?php } }else{ ?>
                    <ul class="profile-btn pt-20">
                      <li><a class="p-btn-1" href="<?= $site_url; ?>/register">Contact me</a></li>
                      <li><a class="p-btn-2" href="<?= $site_url; ?>/register">Custom order</a></li>
                    </ul>
                  <?php }  ?>
                <!-- <div class="setup-accunt-progressbar profile-progressbar">
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 19%;" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100">19%</div>
                  </div>
                </div> -->
                <?php if(isset($_SESSION['seller_user_name'])){ ?>
                <?php if($_SESSION['seller_user_name'] == $get_seller_user_name){ ?>
                <a href="edit_profile" class="edit-btn">Edit Profile</a>
                <?php } } ?>
              </div>
            </div>
            <div class="profile-meta d-flex justify-content-between">
              <div class="profile-location">
                <p class="text"><img src="assets/img/seller-profile/icon-1.png" alt=""> From</p>
              </div>
              <?php if(!empty($get_seller_country)){ ?>
              <div class="profile-address">
                <p class="text"><?= $get_seller_city; ?> , <?= $get_seller_country; ?></p>
              </div>
              <?php } ?>
            </div>
          </div>

          <div class="profile-stats mt-20">
            <div class="profile-title">
              <h4 class="title"><img src="assets/img/seller-profile/icon-2.png" alt="icon"> Seller Stats</h4>
            </div>
            <div class="profile-stats-content pt-20">
              <ul>
                <li><a href="javascript:void(0);"><img src="assets/img/seller-profile/icon-3.png" alt=""> Project Completed <span><?= $count_orders; ?></span></a></li>
                <li><a href="javascript:void(0);"><img src="assets/img/seller-profile/icon-4.png" alt=""> Services delivered <span><?= $delivered; ?></span></a></li>
                <li><a href="javascript:void(0);"><img src="assets/img/seller-profile/icon-5.png" alt=""> Buyer Worked with <span><?= $total_buyer; ?></span></a></li>
              </ul>
            </div>
          </div>

          <div class="profile-verifi mt-20">
            <div class="profile-title">
              <h4 class="title"><img src="assets/img/seller-profile/icon-2.png" alt="icon"> Verifications</h4>
            </div>
            <?php if(isset($_SESSION['seller_user_name'])){ ?>
              <?php if($_SESSION['seller_user_name'] == $get_seller_user_name){ ?>
                <div class="profile-verifi-content profile-verifi-2 pt-20">
                  <ul>
                    <?php if($fb_verification == 0){ ?>
                    <li><i class="fab fa-facebook-f"></i> Facebook Connected <span class="facebook"  onclick="window.location='<?php echo $fLoginURL ?>';"><i class="fab fa-facebook-f"></i> Connect</span></li>
                    <?php }else{ ?>
                    <li><i class="fab fa-facebook-f"></i> Facebook Connected <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                    <!-- <li><i class="fab fa-linkedin-in"></i> LinkedIn Joined <span class="linkdin"><i class="fab fa-linkedin-in"></i> Connect</span></li> -->
                    <?php if($gmail_verification == 0){ ?>
                    <li><i class="fab fa-google"></i> Google Connected <span class="google" onclick="window.location = '<?php echo $gLoginURL ?>';"><i class="fab fa-google"></i> Connect</span></li>
                    <?php }else{ ?>
                    <li><i class="fab fa-google"></i> Google Connected <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                    <?php if($seller_verification != 'ok'){ ?>
                    <li><i class="fa fa-envelope"></i> Email Verified <span class="verify">Verify</span></li>
                    <?php }else{ ?>
                    <li><i class="fa fa-envelope"></i> Email Verified <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                    <?php if($seller_paypal_email != '' or $seller_payoneer_email != ''){ ?>
                    <li><i class="fas fa-dollar-sign"></i> Payment Verified <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } elseif($seller_paypal_email == '' and $seller_payoneer_email == ''){ ?>
                    <li onclick="window.open('settings?account_settings');"><i class="fas fa-dollar-sign"></i> Payment Verified <span class="verify">Verify</span></li>
                    <?php } ?>
                    
                  </ul>
                </div>
              <?php }else { ?>
                <div class="profile-verifi-content profile-verifi-2 pt-20">
                  <ul>
                    <?php if($fb_verification != 0){ ?>
                    <li><i class="fab fa-facebook-f"></i> Facebook Connected <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                    <!-- <li><i class="fab fa-linkedin-in"></i> LinkedIn Joined <span class="linkdin"><i class="fab fa-linkedin-in"></i> Connect</span></li> -->
                    <?php if($gmail_verification != 0){ ?>
                    <li><i class="fab fa-google"></i> Google Connected <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                    <?php if($seller_verification == 'ok'){ ?>
                    <li><i class="fa fa-envelope"></i> Email Verified <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                    <?php if($seller_paypal_email != '' or $seller_payoneer_email != ''){ ?>
                    <li><i class="fas fa-dollar-sign"></i> Payment Verified <span class="check"><i class="fa fa-check"></i></span></li>
                    <?php } ?>
                  </ul>
                </div>
            <?php } } ?>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="profile-about">
            <div class="about-add d-flex align-items-center justify-content-between">
              <div class="profile-title">
                <h4 class="title">About Me</h4>
              </div>
              <?php if(isset($_SESSION['seller_user_name'])){ ?>
                <?php if($_SESSION['seller_user_name'] != $get_seller_user_name){ ?>
                <div class="profile-add">
                  <a href="javascript:void(0);"><i class="fa fa-heart"></i>Add to Favourite</a>
                </div>
                <?php }}else{?>
                <div class="profile-add">
                  <a href="<?= $site_url; ?>/login"><i class="fa fa-heart"></i>Add to Favourite</a>
                </div>
              <?php } ?>
            </div>
            <div class="about-text clearfix pt-20">
              <p class="text"><?= $get_seller_about; ?> </p>
              <a href="javascript:void(0);">+ Show More</a>
            </div>
            <div class="profile-skills pt-20">
              <div class="profile-title border-bottom pb-15">
                <h4 class="title">Skills</h4>
              </div>
              <div class="skills-list pt-10">
                <ul>
                  <?php
                  $select_skills_relation = $db->select("skills_relation",array("seller_id" => $get_seller_id));
                  while($row_skills_relation = $select_skills_relation->fetch()){
                    $relation_id = $row_skills_relation->relation_id;
                    $skill_id = $row_skills_relation->skill_id;
                    $skill_level = $row_skills_relation->skill_level;
                    
                    $get_skill = $db->select("seller_skills",array("skill_id" => $skill_id));
                    $row_skill = $get_skill->fetch();
                    $skill_title = $row_skill->skill_title;
                  ?>
                  <li><a href="javascript:void(0);"><?php echo $skill_title; ?></a></li>
                  <?php } ?>
                  <!-- <li><a href="javascript:void(0);">Logo Design</a></li>
                  <li><a href="javascript:void(0);">Brochure Design</a></li>
                  <li><a href="javascript:void(0);">Illustration</a></li>
                  <li><a href="javascript:void(0);">Packaging Design</a></li> -->
                </ul>
              </div>
            </div>
            <div class="profile-languages pt-40">
              <div class="profile-title border-bottom pb-15">
                <h4 class="title">Languages </h4>
              </div>
              <div class="languages-list pt-10">
                <ul>
                  <!-- <?php
                  $select_languages_relation = $db->select("languages_relation",array("seller_id" => $get_seller_id));
                  while($row_languages_relation = $select_languages_relation->fetch()){

                    $relation_id = $row_languages_relation->relation_id;
                    $language_id = $row_languages_relation->language_id;
                    $language_level = $row_languages_relation->language_level;
                    $get_language = $db->select("seller_languages",array("language_id" => $language_id));
                    $row_language = $get_language->fetch();
                    $language_title = $row_language->language_title;
                  ?>
                  <li><?php echo $language_title; ?> - <span><?php echo $language_level; ?></span></li>
                  <?php } ?> -->
                  <?php
                    foreach ($get_seller_lang as $key => $lang){
                    $get_language = $db->select("seller_languages",array("language_id" => $lang));
                    while($row_language = $get_language->fetch()){
                    $language_title = $row_language->language_title;
                  ?>
                  <li><?php echo $language_title; ?> - <span><?php echo $language_level; ?></span></li>
                  <?php } }?>
                </ul>
              </div>
            </div>
            <div class="profile-education pt-40">
              <div class="profile-title border-bottom pb-15">
                <h4 class="title">Education </h4>
              </div>
              <?php 
                $get_seller_education = $db->select("seller_education",array("seller_id" => $get_seller_id));
                while($row_seller_education = $get_seller_education->fetch()){
                $education = @json_decode($row_seller_education->education_data);
              ?>
              <div class="education-content pt-20">
                <h6 class="education-title"><?= $education->major ?></h6>
                <p class="text"><?= $education->institute ?>, <?= $education->country ?>, Graduated <?= $education->degree_year ?></p>
              </div>
              
              <?php }?>
            </div>
          </div>

          <div class="profile-gigs mt-30">
            <div class="profile-title-2">
              <h3 class="title">Services </h3>
            </div>
            <div class="all-gigs-small mt-30">
              <div class="row">
                <?php
                $get_proposals = $db->select("proposals",array("proposal_seller_id" => $get_seller_id,"proposal_status" => "active"));
                $count_proposals = $get_proposals->rowCount();
                if($count_proposals == 0){
                ?>  
                <div class="col-md-12">
                <?php if(isset($_SESSION['seller_user_name']) AND $get_seller_user_name == $_SESSION['seller_user_name']) { ?>
                <h3 class=" text-center mb-5 p-2">
                <i class="fa fa-smile-o"></i> Hey <?php echo ucfirst($get_seller_user_name); ?>! you have no proposals/services displayed here at the moment. Click <a href="<?php echo $site_url; ?>/proposals/create_proposal.php" class="text-success">here</a> to create a proposal/service.
                </h3>
                <?php }else{ ?>
                <h3 class="text-center mb-5 p-2">
                <i class="fa fa-smile-o"></i> <?php echo ucfirst($get_seller_user_name); ?> does not have any proposals/services to display at the moment.
                </h3>
                <?php } ?>
                </div>
                <?php   
                }
                while($row_proposals = $get_proposals->fetch()){
                $proposal_id = $row_proposals->proposal_id;
                $proposal_title = $row_proposals->proposal_title;
                $proposal_price = $row_proposals->proposal_price;
                if($proposal_price == 0){
                $get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
                $proposal_price = $get_p_1->fetch()->price;
                }
                $proposal_img1 = $row_proposals->proposal_img1;
                $proposal_video = $row_proposals->proposal_video;
                $proposal_seller_id = $row_proposals->proposal_seller_id;
                $proposal_rating = $row_proposals->proposal_rating;
                $proposal_url = $row_proposals->proposal_url;
                $proposal_featured = $row_proposals->proposal_featured;
                $proposal_enable_referrals = $row_proposals->proposal_enable_referrals;
                $proposal_referral_money = $row_proposals->proposal_referral_money;
                if(empty($proposal_video)){
                    $video_class = "";
                }else{
                    $video_class = "video-img";
                }
                $get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
                $row_seller = $get_seller->fetch();
                $seller_user_name = $row_seller->seller_user_name;
                $seller_image = $row_seller->seller_image;
                $seller_level = $row_seller->seller_level;
                $seller_status = $row_seller->seller_status;
                if(empty($seller_image)){
                $seller_image = "empty-image.png";
                }
                // Select Proposal Seller Level
                @$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
                $proposal_reviews = array();
                $select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
                $count_reviews = $select_buyer_reviews->rowCount();
                while($row_buyer_reviews = $select_buyer_reviews->fetch()){
                    $proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
                    array_push($proposal_reviews,$proposal_buyer_rating);
                }
                $total = array_sum($proposal_reviews);
                @$average_rating = $total/count($proposal_reviews);
                @$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
                if($count_favorites == 0){
                $show_favorite_class = "proposal-favorite dil1";
                }else{
                $show_favorite_class = "proposal-unfavorite dil";
                }
                ?>
                  <?php require("includes/proposals_mobile.php"); ?>
                <?php } ?>
                <!-- Each item -->
              </div>
            </div>
            <!-- Small gigs item for mobile -->
            <div class="row d-none d-lg-flex">
              <?php
              $get_proposals = $db->select("proposals",array("proposal_seller_id" => $get_seller_id,"proposal_status" => "active"));
              $count_proposals = $get_proposals->rowCount();
              if($count_proposals == 0){
              ?>  
              <div class="col-md-12">
              <?php if(isset($_SESSION['seller_user_name']) AND $get_seller_user_name == $_SESSION['seller_user_name']) { ?>
              <h3 class=" text-center mb-5 p-2">
              <i class="fa fa-smile-o"></i> Hey <?php echo ucfirst($get_seller_user_name); ?>! you have no proposals/services displayed here at the moment. Click <a href="<?php echo $site_url; ?>/proposals/create_proposal.php" class="text-success">here</a> to create a proposal/service.
              </h3>
              <?php }else{ ?>
              <h3 class="text-center mb-5 p-2">
              <i class="fa fa-smile-o"></i> <?php echo ucfirst($get_seller_user_name); ?> does not have any proposals/services to display at the moment.
              </h3>
              <?php } ?>
              </div>
              <?php   
              }
              while($row_proposals = $get_proposals->fetch()){
              $proposal_id = $row_proposals->proposal_id;
              $proposal_title = $row_proposals->proposal_title;
              $proposal_price = $row_proposals->proposal_price;
              if($proposal_price == 0){
              $get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
              $proposal_price = $get_p_1->fetch()->price;
              }
              $proposal_img1 = $row_proposals->proposal_img1;
              $proposal_video = $row_proposals->proposal_video;
              $proposal_seller_id = $row_proposals->proposal_seller_id;
              $proposal_rating = $row_proposals->proposal_rating;
              $proposal_url = $row_proposals->proposal_url;
              $proposal_featured = $row_proposals->proposal_featured;
              $proposal_enable_referrals = $row_proposals->proposal_enable_referrals;
              $proposal_referral_money = $row_proposals->proposal_referral_money;
              if(empty($proposal_video)){
                  $video_class = "";
              }else{
                  $video_class = "video-img";
              }
              $get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
              $row_seller = $get_seller->fetch();
              $seller_user_name = $row_seller->seller_user_name;
              $seller_image = $row_seller->seller_image;
              $seller_level = $row_seller->seller_level;
              $seller_status = $row_seller->seller_status;
              if(empty($seller_image)){
              $seller_image = "empty-image.png";
              }
              // Select Proposal Seller Level
              @$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
              $proposal_reviews = array();
              $select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
              $count_reviews = $select_buyer_reviews->rowCount();
              while($row_buyer_reviews = $select_buyer_reviews->fetch()){
                  $proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
                  array_push($proposal_reviews,$proposal_buyer_rating);
              }
              $total = array_sum($proposal_reviews);
              @$average_rating = $total/count($proposal_reviews);
              @$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
              if($count_favorites == 0){
              $show_favorite_class = "proposal-favorite dil1";
              }else{
              $show_favorite_class = "proposal-unfavorite dil";
              }
              ?>
              <div class="col-lg-4 col-sm-6">
                <?php require("includes/proposals.php"); ?>
              </div>
              <?php } ?>
              <?php if(isset($_SESSION['seller_user_name']) AND $_SESSION['seller_user_name'] == $get_seller_user_name AND $count_proposals > 0) { ?>
              <a href="proposals/create_proposal" class="col-lg-4 col-md-6 col-sm-6 mb-3">
               <div class="single-gigs mt-30 all-gigs">
                <div class="proposal-card-base mp-proposal-card add-new-proposal">
                 Create A New Service
                </div>
               </div>
              </a>
            <?php } ?>
            </div>
          </div>

          <div class="profile-portfolio mt-30">
            <div class="profile-title-2">
              <h3 class="title">Portfolio </h3>
            </div>
            <div class="row">
              <?php 
                $select_portfolio = $db->select("seller_portfolio",array("seller_id" => $get_seller_id)); 
                while($row_portfolio = $select_portfolio->fetch()){
                  $portfolio_id = $row_portfolio->portfolio_id;
                  $portfolio_img = $row_portfolio->portfolio_img;
                  $img_name_tmp = explode('.',$portfolio_img );
                  $img_name = $img_name_tmp[0];
              ?>
              <div class="col-md-4">
                <div class="single-portfolio mt-30">
                  <img src="<?= $site_url; ?>/portfolio_images/<?= $portfolio_img ?>" alt="">
                </div>
              </div>
              <?php } ?>
            </div>
          </div>

          <div class="profile-review mt-30">
            <div class="review-seller d-sm-flex justify-content-between align-items-center">
              <div class="review-text mt-10">
                <h5 class="review-title">Reviews As Seller 
                  <?php 
                    $select_buyer_reviews = $db->select("buyer_reviews",array("review_seller_id"=>$get_seller_id)); 
                    $count_reviews = $select_buyer_reviews->rowCount();

                    if(!$count_reviews == 0){
                      $rattings = array();
                      $communication_rate = array();
                      $service_rate = array();
                      $recommend_rate = array();
                      while($row_buyer_reviews = $select_buyer_reviews->fetch()){
                        $buyer_rating = $row_buyer_reviews->buyer_rating;
                        $communication_rating = $row_buyer_reviews->communication_rating;
                        $service_rating = $row_buyer_reviews->service_rating;
                        $recommend_rating = $row_buyer_reviews->recommend_rating;

                        array_push($rattings,$buyer_rating);
                        array_push($communication_rate,$communication_rating);
                        array_push($service_rate,$service_rating);
                        array_push($recommend_rate,$recommend_rating);
                      }
                      $total = array_sum($rattings);
                      $total_communication = array_sum($communication_rate);
                      $total_service = array_sum($service_rate);
                      $total_recommend = array_sum($recommend_rate);


                      @$average = $total/count($rattings);
                      $average_rating = substr($average ,0,3);
                      
                      @$average_communication = $total_communication/count($communication_rate);
                      $average_rating_communi = substr($average_communication ,0,3);
                      
                      @$average_service = $total_service/count($service_rate);
                      $average_rating_service = substr($average_service ,0,3);
                      
                      @$average_recommend = $total_recommend/count($recommend_rate);
                      $average_rating_recomd = substr($average_recommend ,0,3);
                    }else{
                     $average = "0";  
                     $average_rating = "0";
                     $average_communication = "0";  
                     $average_rating_communi = "0";
                     $average_service = "0";  
                     $average_rating_service = "0";
                     $average_recommend = "0";  
                     $average_rating_recomd = "0";
                    }
                  ?>
                  <span><i class="fa fa-star"></i> <?= $average_rating ?></span> (<?= $count_reviews; ?>)</h5>
              </div>
              <!-- <div class="review-dropdown mt-10 clearfix">
                <select>
                  <option value="0">Most Recent</option>
                  <option value="1">Most Recent 01</option>
                  <option value="2">Most Recent 02</option>
                  <option value="3">Most Recent 03</option>
                  <option value="4">Most Recent 04</option>
                </select>
              </div> -->
            </div>
            <div class="review-communication pt-20">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <div class="single-communication mt-15">
                    <h5 class="title">Seller communication leval</h5>
                    <span><i class="fa fa-star"></i> <?= $average_rating_communi ?></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="single-communication mt-15">
                    <h5 class="title">Recommend to a friend</h5>
                    <span><i class="fa fa-star"></i> <?= $average_rating_service ?></span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="single-communication mt-15">
                    <h5 class="title">Service as described</h5>
                    <span><i class="fa fa-star"></i> <?= $average_rating_service ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="review-comment pt-30">
              <ul>
                <?php 
                  $select_buyer_reviews = $db->select("buyer_reviews",array("review_seller_id"=>$get_seller_id)); 
                  $count_reviews = $select_buyer_reviews->rowCount();
                  
                    $rattings = array();
                    while($row_buyer_reviews = $select_buyer_reviews->fetch()){
                      $buyer_rating = $row_buyer_reviews->buyer_rating;
                      $buyer_review = $row_buyer_reviews->buyer_review;
                      $review_date = $row_buyer_reviews->review_date;
                      $review_buyer_id = $row_buyer_reviews->review_buyer_id;
                      $get_buyer = $db->select("sellers", array('seller_id' => $review_buyer_id ));
                      while ($row_buyer_data = $get_buyer->fetch()) {
                        $buyer_name = $row_buyer_data->seller_name;
                        $buyer_image = $row_buyer_data->seller_image;
                      }

                      array_push($rattings,$buyer_rating);

                    $total = array_sum($rattings);
                    @$average = $total/count($rattings);
                    $average_rating = substr($average ,0,3);
                  
                  if(!$count_reviews == 0){
                ?>
                <li>
                  <div class="single-review-comment d-flex">
                    <div class="comment-image">
                      <?php if(!empty($buyer_image)){ ?>
                        <img src="user_images/<?= $buyer_image ?>" width="50" height="50" alt="author">
                      <?php }else{ ?>
                        <img src="assets/img/seller-profile/author-2.jpg" alt="author">
                      <?php } ?>
                    </div>
                    <div class="comment-content media-body">
                      <h6 class="comment-name"><?= $buyer_name; ?> 
                        <span>
                        <?php
                          for($seller_i=0; $seller_i<$buyer_rating; $seller_i++){
                            echo " <i class='fa fa-star'></i> ";
                          }
                          for($seller_i=$average_rating; $seller_i<5; $seller_i++){
                            echo "<i class='fa fa-star-o'></i>";
                          }
                        ?>
                        <?= $buyer_rating; ?></span></h6>
                      <p class="text"><?= $buyer_review; ?></p>
                      <span class="date"><?= $review_date; ?></span>
                    </div>
                  </div>
                </li>
              <?php } } ?>
              </ul>
              <!-- <div class="review-more mt-25">
                <a href="javascript:void(0);">+ Show More</a>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--  SELLER PROFILE END -->
  <!-- Customer Order Puppup Start-->
  <!-- Modal -->
  <div class="modal fade" id="custom_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered customer-order" role="document">
      <div class="modal-content">
        <div class="modal-header align-items-center">
          <h5 class="modal-title" id="exampleModalCenterTitle">Request a Quote</h5>
          <a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
            <img src="assets/img/seller-profile/popup-close-icon.png" />
          </a>
        </div>
        <div class="modal-body">
          <div class="customer-profile d-flex align-items-start align-items-md-center">
            <div class="profile-img">
              <?php if(!empty($get_seller_image)){ ?>
              <img src="user_images/<?= $get_seller_image; ?>" alt="profile" class="rounded-circle">
              <?php }else { ?>
              <img src="assets/img/seller-profile/profile-img.png" alt="profile">
              <?php } ?>
            </div>
            <div class="profile-content media-body">
              <h6 class="profile-name"><?= ucfirst($get_seller_user_name); ?></h6>
              <p class="text">Hi. please provide your request details below and i’ll get back to you.</p>
            </div>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label class="control-label d-flex align-items-start">
                <span><img src="assets/img/post-request/icon-1.png" alt="Icon"></span>
                <span>Describe the service you’re looking to purchase</span>
              </label>
              <textarea class="form-control" id="textarea" name="request_description" placeholder="I’m looking for..." rows="5"></textarea>
              <div class="bottom-label d-flex flex-row align-items-center justify-content-between mb-30 mt-15">
                <div class="attach-file d-flex flex-row align-items-center">
                  <label for="file">
                    <input type="file" id="file" name="request_file" hidden="">
                    <span class="file d-flex flex-row align-items-center">
                      <span><img src="assets/img/post-request/attach.png" alt=""></span>
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
                <span><img src="assets/img/post-request/icon-2.png" alt="Icon"></span>
                <span>Choose a category</span>
              </div>
              <div class="row">
                <div class="col-12 col-sm-6 mb-30 sub_cat">
                  <select name="cat_id" class="form-control" id="category" style="display: block !important;">
                    <option value="" class="hidden"> Select A Category </option>
                  <?php 
                  // $db->select("proposals",array("proposal_seller_id"=>$get_seller_id,"proposal_status" => "active"));
                  $select_proposal = $db->query("select DISTINCT(proposal_cat_id) from proposals where proposal_seller_id = '$get_seller_id' AND proposal_status = 'active'");
                  $i=0;
                  $d_proposal_cat_id = array();

                  while($row_proposal = $select_proposal->fetch()){
                    $d_proposal_cat_id['proposal_cat_id'][] = $row_proposal->proposal_cat_id;
                    $proposal[$i] =
                      $row_proposal;

                    $proposal_cat = array($proposal[0]->proposal_cat_id);
                    
                    
                    $propsal_cats_id = ($d_proposal_cat_id['proposal_cat_id']);
                    $cat_array = array_unique(($propsal_cats_id[$i]));
                   
                  

                  $get_cats = $db->select("categories",array("cat_id" => $propsal_cats_id[$i]));
                  while($row_cats = $get_cats->fetch()){
                  $cat_id = $row_cats->cat_id;
                  $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
                  $row_meta = $get_meta->fetch();
                  $cat_title = $row_meta->cat_title;
                  ?>
                    <option value="<?= $cat_id; ?>"> <?= $cat_title; ?> </option>
                  <?php $i++; } }?>
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
                <span><img src="assets/img/post-request/icon-3.png" alt="Icon"></span>
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
                <span><img src="assets/img/post-request/icon-6.png" alt="Icon"></span>
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
  <script>
    $(document).ready(function(){
      $("#textarea").keydown(function(){
      var textarea = $("#textarea").val();
      $(".descCount").text(textarea.length);  
      }); 

      $("#sub-category").hide();

      $("#category").change(function(){
        $("#sub-category").show();  
        var category_id = $(this).val();
        $.ajax({
        url:"fetch_subcategory",
        method:"POST",
        data:{category_id:category_id},
        success:function(data){
        $("#sub-category").html(data);
        }
        });
      });
      $('#file').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file')[0].files[0].name;
        
        $('#file_name').html('<span>'+file+'</span>');
        // $(this).prev('label').text(file);
      });
      $('#file').bind('change', function() {
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
    });
  </script>
  <?php 
    if(isset($_POST['send_request'])){
      // $buyer_id = $login_seller_id;
      // $order_price = $input->post('order_price');

      
      $request_description = $input->post('request_description');
      $cat_id = $input->post('cat_id');
      $child_id = $input->post('child_id');
      $request_budget = $input->post('request_budget');
      $delivery_time = $input->post('delivery_time');

      echo "You have selected :" .$delivery_time;
      $request_file = $_FILES['request_file']['name'];
      $request_file_tmp = $_FILES['request_file']['tmp_name'];
      $request_date = date("F d, Y");
      $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
      $file_extension = pathinfo($request_file, PATHINFO_EXTENSION);
      if(!empty($request_file)){
        if(!in_array($file_extension,$allowed)){
          echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
          echo "<script>window.open('<?= ucfirst($get_seller_user_name); ?>','_self')</script>";
          exit();
        }
        $request_file = pathinfo($request_file, PATHINFO_FILENAME);
        $request_file = $request_file."_".time().".$file_extension";
        move_uploaded_file($request_file_tmp,"requests/request_files/$request_file");
      }
      
      $insert_request = $db->insert("buyer_requests",array("seller_id"=>$login_seller_id,"user_id"=>$get_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'active'));
      if($insert_request){
        echo "<script>
            swal({
              type: 'success',
              text: 'Your request has been submitted successfully!',
              timer: 3000,
              onOpen: function(){
                swal.showLoading()
              }
            }).then(function(){
                window.open('conversations/message?seller_id=$get_seller_id','_self');
            });
        </script>";
      }
    }
  ?>
<!-- <?php //require_once("includes/user_profile_header.php"); ?>
<div class="container">  -->
  <!-- Container starts -->
  <!-- <div class="row">
    <div class="col-md-4 mt-4">
      <?php //require_once("includes/user_sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card mt-4 mb-4 rounded-0">
            <div class="card-body">
              <h2><?php echo ucfirst($get_seller_user_name); ?>'s Proposals/Services</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <?php
        $get_proposals = $db->select("proposals",array("proposal_seller_id" => $seller_id,"proposal_status" => "active"));
        $count_proposals = $get_proposals->rowCount();
        if($count_proposals == 0){
        ?>  
        <div class="col-md-12">
        <?php if(isset($_SESSION['seller_user_name']) AND $seller_user_name == $_SESSION['seller_user_name']) { ?>
        <h3 class=" text-center mb-5 p-2">
        <i class="fa fa-smile-o"></i> Hey <?php echo ucfirst($get_seller_user_name); ?>! you have no proposals/services displayed here at the moment. Click <a href="<?php echo $site_url; ?>/proposals/create_proposal.php" class="text-success">here</a> to create a proposal/service.
        </h3>
        <?php }else{ ?>
        <h3 class="text-center mb-5 p-2">
        <i class="fa fa-smile-o"></i> <?php echo ucfirst($get_seller_user_name); ?> does not have any proposals/services to display at the moment.
        </h3>
        <?php } ?>
        </div>
        <?php   
        }
        while($row_proposals = $get_proposals->fetch()){
        $proposal_id = $row_proposals->proposal_id;
        $proposal_title = $row_proposals->proposal_title;
        $proposal_price = $row_proposals->proposal_price;
        if($proposal_price == 0){
        $get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
        $proposal_price = $get_p_1->fetch()->price;
        }
        $proposal_img1 = $row_proposals->proposal_img1;
        $proposal_video = $row_proposals->proposal_video;
        $proposal_seller_id = $row_proposals->proposal_seller_id;
        $proposal_rating = $row_proposals->proposal_rating;
        $proposal_url = $row_proposals->proposal_url;
        $proposal_featured = $row_proposals->proposal_featured;
        $proposal_enable_referrals = $row_proposals->proposal_enable_referrals;
        $proposal_referral_money = $row_proposals->proposal_referral_money;
        if(empty($proposal_video)){
            $video_class = "";
        }else{
            $video_class = "video-img";
        }
        $get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
        $row_seller = $get_seller->fetch();
        $seller_user_name = $row_seller->seller_user_name;
        $seller_image = $row_seller->seller_image;
        $seller_level = $row_seller->seller_level;
        $seller_status = $row_seller->seller_status;
        if(empty($seller_image)){
        $seller_image = "empty-image.png";
        }
        // Select Proposal Seller Level
        @$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
        $proposal_reviews = array();
        $select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
        $count_reviews = $select_buyer_reviews->rowCount();
        while($row_buyer_reviews = $select_buyer_reviews->fetch()){
            $proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
            array_push($proposal_reviews,$proposal_buyer_rating);
        }
        $total = array_sum($proposal_reviews);
        @$average_rating = $total/count($proposal_reviews);
        @$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
        if($count_favorites == 0){
        $show_favorite_class = "proposal-favorite dil1";
        }else{
        $show_favorite_class = "proposal-unfavorite dil";
        }
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
        <?php //require("includes/proposals.php"); ?>
        </div>
       <?php } ?>
       <?php if(isset($_SESSION['seller_user_name']) AND $_SESSION['seller_user_name'] == $get_seller_user_name AND $count_proposals > 0) { ?>
       <a href="proposals/create_proposal" class="col-lg-4 col-md-6 col-sm-6 mb-3">
        <div class="proposal-card-base mp-proposal-card add-new-proposal">
        Create A New Proposal
        </div>
       </a>
       <?php } ?>
      </div>
      <?php //include("includes/user_footer.php"); ?>
    </div>
  </div>
</div> --> <!-- Container ends -->
<?php require_once("includes/footer.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
$('#good').hide();
$('#bad').hide();
$('.all').click(function(){
$("#dropdown-button").html("Most Recent");
$(".all").attr('class','dropdown-item all active');
$(".bad").attr('class','dropdown-item bad');
$(".good").attr('class','dropdown-item good');
$("#all").show();
$("#good").hide();
$("#bad").hide();
}); 
$('.good').click(function(){
$("#dropdown-button").html("Positive Reviews");
$(".all").attr('class','dropdown-item all');
$(".bad").attr('class','dropdown-item bad');
$(".good").attr('class','dropdown-item good active');
$("#all").hide();
$("#good").show();
$("#bad").hide();
}); 
$('.bad').click(function(){
$("#dropdown-button").html("Negative Reviews");
$(".all").attr('class','dropdown-item all');
$(".bad").attr('class','dropdown-item bad active');
$(".good").attr('class','dropdown-item good');
$("#all").hide();
$("#good").hide();
$("#bad").show();
}); 
});
</script>
</body>
</html>