<?php

session_start();
require_once("includes/db.php");
require_once("functions/functions.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_image = $row_login_seller->seller_image;

?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
	<title><?php echo $site_name; ?> - Favorites</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
	
  <!--====== Bootstrap css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?php echo $site_url; ?>/assets/css/style1.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?php echo $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
  
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
  <!-- <link href="styles/styles.css" rel="stylesheet"> -->
  <?php if($row_general_settings->knowledge_bank == 'yes'): ?>
  <link href="styles/knowledge_bank.css" rel="stylesheet">
  <?php endif ?>
  <?php if(!empty($site_favicon)){ ?>
  <!-- <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon" /> -->
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">
  <?php } ?>
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.dil {color: #ff2b2b !important;}.fit-svg-icon path {fill: #ffbf00;}.header-menu .mainmenu ul li a {font-size: 15px;}
  .favourite-gigs .favourite-gigs-list .gigs-list-item .single-gigs .gigs-content .gigs-title{
    height: 32px;
  }
  </style>
</head>

<body class="all-content">
<?php 
  if(!isset($_SESSION['seller_user_name'])){
    require_once("includes/header.php");
  }else{
    require_once("includes/buyer-header.php");
  }
?>

<main class="emongez-content-main">
  <!-- FAVOURITE -->
  <div class="container-fluid favourite-gigs">
    <div class="row">
      <div class="container">
        <?php
          $get_favorites = $db->select("favorites",array("seller_id" => $login_seller_id));
          $count_favorites = $get_favorites->rowCount();
          if(isset($_GET['add_favorites'])){
           while($row_favorites = $get_favorites->fetch()){
            $proposal_id = $row_favorites->proposal_id;
            $select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
            $row_proposals = $select_proposals->fetch();
            $proposal_price = $row_proposals->proposal_price;
            if($proposal_price == 0){
            $get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
            $proposal_price = $get_p_1->fetch()->price;
            }
            $insert_cart = $db->insert("cart",array("seller_id" => $login_seller_id,"proposal_id" => $proposal_id,"proposal_price" => $proposal_price,"proposal_qty" => 1));
          }
          $delete_favorites = $db->delete("favorites",array("seller_id" => $login_seller_id));
          if($delete_favorites){
            echo "<script>window.open('cart','_self')</script>";
          }
          }
        ?>
        <div class="favourite-gigs-header d-flex flex-column flex-sm-row-reverse justify-content-between align-items-center">
          <div class="favourite-gigs-header-user align-items-center d-flex flex-row justify-content-start">
            <div class="image">
              <?php if(!empty($login_seller_image)){ ?>
              <img class="img-fluid d-block" src="<?= $site_url; ?>/user_images/<?php echo $login_seller_image; ?>" alt="profile">
              <?php }else{ ?>
              <img class="img-fluid d-block" src="assets/img/seller-profile/profile-img.png" alt="profile">
              <?php } ?>
            </div>
            <div class="text d-flex flex-column">
              <span>Created by</span>
              <span><?php echo $login_seller_user_name; ?></span>
            </div>
          </div>
          <div class="favourite-gigs-header-text d-flex flex-column">
            <h3>Services I Love <span>(<?php echo $count_favorites; ?> Services)</span></h3>
            <p>Welcome to your default list. If you saved a Service without choosing a specific list, you can find it here.</p>
          </div>
        </div>
        <!-- Favourite gigs header -->
        <div class="favourite-gigs-social d-none flex-wrap align-items-center justify-content-end">
          <a class="favourite-gigs-social-item facebook" href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a>
          <a class="favourite-gigs-social-item twitter" href="javascript:void(0);"><i class="fab fa-twitter"></i></a>
          <a class="favourite-gigs-social-item linkedin" href="javascript:void(0);"><i class="fab fa-linkedin-in"></i></a>
          <a class="favourite-gigs-social-item instagram" href="javascript:void(0);"><i class="fab fa-instagram"></i></a>
        </div>
        <!-- Favourite gigs social -->
        <div class="favourite-gigs-list">
          <div class="all-gigs-small mt-30">
            <div class="row">
              <?php
                $get_favorites = $db->select("favorites",array("seller_id" => $login_seller_id));
                while($row_favorites = $get_favorites->fetch()){
                $favorite_proposal_id = $row_favorites->proposal_id;
                $get_proposals = $db->select("proposals",array("proposal_id" => $favorite_proposal_id));
                $row_proposals = $get_proposals->fetch();
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
                $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
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
            <?php 
              if($count_favorites == 0){
                echo "<span class='text-center'><h3 class='pt-5 pb-5'><i class='fa fa-meh-o'></i> Your favorites page is empty</h3></span>";
              }
            ?>
          </div>
          <!-- Small gigs item for mobile -->
          <div class="row d-none d-lg-flex">
            <?php
              $get_favorites = $db->select("favorites",array("seller_id" => $login_seller_id));
              while($row_favorites = $get_favorites->fetch()){
              $favorite_proposal_id = $row_favorites->proposal_id;
              $get_proposals = $db->select("proposals",array("proposal_id" => $favorite_proposal_id));
              $row_proposals = $get_proposals->fetch();
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
              $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
              if($count_favorites == 0){
              $show_favorite_class = "proposal-favorite dil1";
              }else{
              $show_favorite_class = "proposal-unfavorite dil";
              }
            ?>
            <div class="gigs-list-item">
              <div class="single-gigs mt-30">
                <div class="gigs-image verified-rebon">
                  <img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" alt="Gigs Image">
                </div>
                <div class="gigs-content">
                  <div class="gigs-author d-flex align-items-center">
                    <div class="author-image">
                      <?php if(!empty($seller_image)){ ?>
                      <img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" alt="">
                      <?php }else{ ?>
                      <img src="assets/img/gigs/author-1.jpg" alt="">
                      <?php } ?>
                    </div>
                    <div class="author-name media-body">
                      <h4 class="name"><a href="<?= $site_url; ?>/<?= $seller_user_name; ?>"><?= $seller_user_name; ?></a></h4>
                    </div>
                  </div>
                  <?php 
                    $string = strip_tags($proposal_title);
                    if (strlen($string) > 50) {

                        // truncate string
                        $stringCut = substr($string, 0, 48);
                        $endPoint = strrpos($stringCut, ' ');

                        //if the string doesn't contain any space then it will cut without word basis.
                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                        $string .= '....';
                    }
                    // echo $string;

                  ?>
                  <h4 class="gigs-title"><a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>"><?= $string; ?></a></h4>
                  <div class="gigs-rating d-flex">
                    <ul>
                      <?php
                        for($seller_i=0; $seller_i<$proposal_buyer_rating; $seller_i++){
                          echo "<li><i class='fa fa-star'></i></li>";
                        }
                        for($seller_i=$proposal_buyer_rating; $seller_i<5; $seller_i++){
                          echo "<li><i class='fa fa-star-o'></i></li>";
                        }
                      ?>&nbsp;
                      <strong><?php if($proposal_rating == "0"){ echo "0.0"; }else{ printf("%.1f", $average_rating); } ?></strong>
                    </ul>
                    <span>(<?= $count_reviews; ?>)</span>
                  </div>
                </div>
                <div class="gigs-meta d-flex justify-content-between align-items-center">
                  <div class="meta-left">
                    <?php if(isset($_SESSION['seller_user_name'])){ ?>
                      <?php if($proposal_seller_id != $login_seller_id){ ?>
                      <a href="javascript:void(0);"><i data-id="<?= $proposal_id; ?>" href="#" class="fa fa-heart <?= $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorite"></i></a>
                      <?php } ?>
                      <?php }else{ ?>
                        <a href="<?= $site_url; ?>/login.php"><i class="fa fa-heart"></i></a>
                      <?php } ?>
                  </div>
                  <div class="meta-right">
                    <?php if($to == 'EGP'){ ?>
                      <span>
                        <?= $to; ?> <?= $proposal_price; ?>
                      </span>
                    <?php } elseif($to == 'USD'){ ?>
                      <span><?= $to; ?> <?= round($cur_amount * $proposal_price,2) ?></span>
                    <?php
                      }else{?>
                        <span><?= $s_currency; ?> <?= $proposal_price; ?></span>
                      <?php }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <!-- Each item -->
            <?php 
              if($count_favorites == 0){
                echo "<span class='text-center'><h3 class='pt-5 pb-5'><i class='fa fa-meh-o'></i> Your favorites page is empty</h3></span>";
              }
            ?>
          </div>
        </div>
        <!-- Favourite gigs list -->
      </div>
    </div>
  </div>
  <!-- FAVOURITE END -->
</main>

<?php require_once("includes/footer.php"); ?>
</body>
</html>