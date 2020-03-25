<?php
session_start();
require_once("includes/db.php");
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
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }else{
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
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
if(empty($get_seller_cover_image)){ 
$get_seller_cover_image = "images/user-background.jpg";
}else{
$get_seller_cover_image = "cover_images/".rawurlencode($seller_cover_image)."";
}
$get_seller_country = $row_seller->seller_country;
$get_seller_headline = $row_seller->seller_headline;
$get_seller_about = $row_seller->seller_about;
$get_seller_level = $row_seller->seller_level;
$get_seller_rating = $row_seller->seller_rating;
$get_seller_register_date = $row_seller->seller_register_date;
$get_seller_recent_delivery = $row_seller->seller_recent_delivery;

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

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
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
              <div class="profile-status online">عبر الانترنت</div>
              <?php } ?>
              <div class="profile-image">
                <?php if(!empty($get_seller_image)){ ?>
                <img src="user_images/<?= $get_seller_image; ?>" alt="profile">
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
                <?php if(isset($_SESSION['seller_user_name'])){ ?>
                  <?php if($_SESSION['seller_user_name'] != $get_seller_user_name){ ?>
                    <ul class="profile-btn pt-20">
                      <li><a class="p-btn-1" href="<?= $site_url; ?>/ar/conversations/message?seller_id=<?= $get_seller_id ?>">اتواصل معايا</a></li>
                      <li><a class="p-btn-2" href="javascript:void(0);" data-toggle="modal" data-target="#exampleModalCenter">حدد الطلب</a></li>
                    </ul>
                  <?php } }else{ ?>
                    <ul class="profile-btn pt-20">
                      <li><a class="p-btn-1" href="<?= $site_url; ?>/ar/login">Contact me</a></li>
                      <li><a class="p-btn-2" href="<?= $site_url; ?>/ar/login" data-toggle="modal" data-target="#exampleModalCenter">حدد الطلب</a></li>
                    </ul>
                  <?php }  ?>
                <!-- <div class="setup-accunt-progressbar profile-progressbar">
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 19%;" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100">19%</div>
                  </div>
                </div> -->
                <?php if(isset($_SESSION['seller_user_name'])){ ?>
                <?php if($_SESSION['seller_user_name'] == $get_seller_user_name){ ?>
                <a href="settings?profile_settings" class="edit-btn">تعديل الملف الشخصى</a>
                <?php } } ?>
              </div>
            </div>
            <div class="profile-meta d-flex justify-content-between">
              <div class="profile-location">
                <p class="text"><img src="assets/img/seller-profile/icon-1.png" alt=""> من</p>
              </div>
              <?php if(!empty($get_seller_country)){ ?>
              <div class="profile-address">
                <p class="text"><?= $get_seller_country; ?></p>
              </div>
              <?php } ?>
            </div>
          </div>

          <div class="profile-stats mt-20">
            <div class="profile-title">
              <h4 class="title"><img src="assets/img/seller-profile/icon-2.png" alt="icon"> إحصائيات مقدم الخدمة</h4>
            </div>
            <div class="profile-stats-content pt-20">
              <ul>
                <li><a href="javascript:void(0);"><img src="assets/img/seller-profile/icon-3.png" alt=""> المشروع اتصل <span><?= $count_orders; ?></span></a></li>
                <li><a href="javascript:void(0);"><img src="assets/img/seller-profile/icon-4.png" alt=""> الخدمات اللي اتسلمت <span><?= $delivered; ?></span></a></li>
                <li><a href="javascript:void(0);"><img src="assets/img/seller-profile/icon-5.png" alt=""> المشتري اشتغل مع <span><?= $total_buyer; ?></span></a></li>
              </ul>
            </div>
          </div>

          <div class="profile-verifi mt-20">
            <div class="profile-title">
              <h4 class="title"><img src="assets/img/seller-profile/icon-2.png" alt="icon"> التحقق</h4>
            </div>
            <div class="profile-verifi-content profile-verifi-2 pt-20">
              <ul>
                <li><i class="fab fa-facebook-f"></i> فيس بوك <span class="facebook"><i class="fab fa-facebook-f"></i> اتصال</span></li>
                <li><i class="fab fa-linkedin-in"></i> LinkedIn Joined <span class="linkdin"><i class="fab fa-linkedin-in"></i> اتصال</span></li>
                <li><i class="fab fa-google"></i> Google Connected <span class="google"><i class="fab fa-google"></i> اتصال</span></li>
                <li><i class="fa fa-envelope"></i> الإيميل <span class="verify">تأكيد</span></li>
                <li><i class="fas fa-dollar-sign"></i> اتحققنا من الدفع <span class="check"><i class="fa fa-check"></i></span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="profile-about">
            <div class="about-add d-flex align-items-center justify-content-between">
              <div class="profile-title">
                <h4 class="title">عني</h4>
              </div>
              <?php if(isset($_SESSION['seller_user_name'])){ ?>
                <?php if($_SESSION['seller_user_name'] != $get_seller_user_name){ ?>
                <div class="profile-add">
                  <a href="javascript:void(0);"><i class="fa fa-heart"></i>إضافة إلى المفضلة</a>
                </div>
                <?php }}else{?>
                <div class="profile-add">
                  <a href="<?= $site_url; ?>/ar/login"><i class="fa fa-heart"></i>إضافة إلى المفضلة</a>
                </div>
              <?php } ?>
            </div>
            <div class="about-text clearfix pt-20">
              <p class="text"><?= $get_seller_about; ?> </p>
              <a href="javascript:void(0);">+ اعرضلي أكتر</a>
            </div>
            <div class="profile-skills pt-20">
              <div class="profile-title border-bottom pb-15">
                <h4 class="title">المهارات</h4>
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
                <h4 class="title">اللغات </h4>
              </div>
              <div class="languages-list pt-10">
                <ul>
                  <?php
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
                  <?php } ?>
                </ul>
              </div>
            </div>
            <div class="profile-education pt-40">
              <div class="profile-title border-bottom pb-15">
                <h4 class="title">التعليم </h4>
              </div>
              <div class="education-content pt-20">
                <h6 class="education-title">B.A. - History</h6>
                <p class="text">Delhi University, India, Graduated 2005</p>
              </div>
            </div>
          </div>

          <div class="profile-gigs mt-30">
            <div class="profile-title-2">
              <h3 class="title">الخدمات </h3>
            </div>
            <div class="all-gigs-small mt-30">
              <div class="row">
                <?php
                $get_proposals = $db->select("proposals",array("proposal_seller_id" => $get_seller_id,"proposal_status" => "active"));
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
              <div class="col-lg-4 col-sm-6">
                <?php require("includes/proposals.php"); ?>
              </div>
              <?php } ?>
              <?php if(isset($_SESSION['seller_user_name']) AND $_SESSION['seller_user_name'] == $get_seller_user_name AND $count_proposals > 0) { ?>
              <a href="proposals/create_proposal" class="col-lg-4 col-md-6 col-sm-6 mb-3">
               <div class="single-gigs mt-30 all-gigs">
                <div class="proposal-card-base mp-proposal-card add-new-proposal">
                 Create A New Proposal
                </div>
               </div>
              </a>
            <?php } ?>
            </div>
          </div>

          <div class="profile-portfolio mt-30">
            <div class="profile-title-2">
              <h3 class="title">المحفظة</h3>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="single-portfolio mt-30">
                  <img src="assets/img/seller-profile/portfolio-1.jpg" alt="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="single-portfolio mt-30">
                  <img src="assets/img/seller-profile/portfolio-2.jpg" alt="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="single-portfolio mt-30">
                  <img src="assets/img/seller-profile/portfolio-3.jpg" alt="">
                </div>
              </div>
            </div>
          </div>

          <div class="profile-review mt-30">
            <div class="review-seller d-sm-flex justify-content-between align-items-center">
              <div class="review-text mt-10">
                <h5 class="review-title">التقييمات باعتبار إنك مقدم خدمة 
                  <?php 
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
                  ?>
                  <span><i class="fa fa-star"></i> <?= $average_rating ?></span> (<?= $count_reviews; ?>)</h5>
              </div>
              <div class="review-dropdown mt-10 clearfix">
                <select>
                  <option value="0">Most Recent</option>
                  <option value="1">Most Recent 01</option>
                  <option value="2">Most Recent 02</option>
                  <option value="3">Most Recent 03</option>
                  <option value="4">Most Recent 04</option>
                </select>
              </div>
            </div>
            <!-- <div class="review-communication pt-20">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <div class="single-communication mt-15">
                    <h5 class="title">Seller communication leval</h5>
                    <span><i class="fa fa-star"></i> 5</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="single-communication mt-15">
                    <h5 class="title">Recommend to a friend</h5>
                    <span><i class="fa fa-star"></i> 4.9</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="single-communication mt-15">
                    <h5 class="title">Service as described</h5>
                    <span><i class="fa fa-star"></i> 5</span>
                  </div>
                </div>
              </div>
            </div> -->
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
                    $average_rating = substr($average ,0,1);
                  
                  if(!$count_reviews == 0){
                ?>
                <li>
                  <div class="single-review-comment d-flex">
                    <div class="comment-image">
                      <?php if(!empty($buyer_image)){ ?>
                        <img src="user_images/$buyer_image" alt="author">
                      <?php }else{ ?>
                        <img src="assets/img/seller-profile/author-2.jpg" alt="author">
                      <?php } ?>
                    </div>
                    <div class="comment-content media-body">
                      <h6 class="comment-name"><?= $buyer_name; ?> 
                        <span>
                        <?php
                          for($seller_i=0; $seller_i<$average_rating; $seller_i++){
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
              <div class="review-more mt-25">
                <a href="javascript:void(0);">+ اعرضلي أكتر</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--  SELLER PROFILE END -->
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