<?php
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_name = $row_login_seller->seller_name;
$login_user_name = $row_login_seller->seller_user_name;
$login_seller_offers = $row_login_seller->seller_offers;
$relevant_requests = $row_general_settings->relevant_requests;

?>
<link href="styles/styles.css" rel="stylesheet">
<!-- New Design -->
<div class="main-box">
  <div class="container">
    <div class="row flex-lg-row-reverse">
      <div class="col-12 col-lg-4">
        <div class="user-profile mt-40">
          <div class="user-image">
            <?php if(!empty($seller_image)){ ?>
            <img src="user_images/<?= $seller_image; ?>" alt="">
            <?php }else{ ?>
            <img src="<?= $site_url; ?>/assets/img/user1.png"  class="img-fluid rounded-circle mb-3">
            <?php } ?>
            <h5><?= $lang['welcome']; ?> back, <span><?= ucfirst(strtolower($login_user_name)); ?></span></h5>
          </div>
          <div class="setup-accunt-progressbar">
            <p>Set up your account</p>
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: 19%;" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100">19%</div>
            </div>
          </div>
          <a href="requests/post-request.php" class="request-btn">Post a request</a>
        </div>
      </div>
      <div class="col-12 col-lg-8">
        <!-- Home-slider -->
        <div class="home-slide-active pt-40 owl-carousel">
          <?php
            $count_slides = $db->count("slider",array("language_id" => $siteLanguage));
            $i = 0;
            $get_slides = $db->query("select * from slider where language_id='$siteLanguage' LIMIT 1,$count_slides");
            while($row_slides = $get_slides->fetch()){
            $i++;
            ?>
          <?php } ?>
          <?php
            $get_slides = $db->query("select * from slider where language_id='$siteLanguage' LIMIT 0,$count_slides");
            while($row_slides = $get_slides->fetch()){
            $slide_image = $row_slides->slide_image;
            $slide_name = $row_slides->slide_name;
            $slide_desc = $row_slides->slide_desc;
            $slide_url = $row_slides->slide_url;
            ?>
          <div class="single-slide-item" style="background-image: url('slides_images/<?= $slide_image; ?>');"></div>
          <?php } ?>
        </div>
        <!-- Home-slider  END-->
      </div>
    </div>
    <!-- Gigs -->
    <div class="row">
      <!-- Left-sidebar START -->
      <div class="col-12 col-lg-8">
        <!-- Featured-gig-area -->
        <div class="featured-gig-area pt-40">
          <div class="row">
            <div class="col-12">
              <div class="section-title">
                <h2>Featured gigs</h2>
              </div>
            </div>
          </div>
          <div class="all-gigs-small mt-30">
            <div class="row">
              <?php
                $get_proposals = $db->query("select * from proposals where proposal_featured='yes' AND proposal_status='active' LIMIT 0,9");
                $count_proposals = $get_proposals->rowCount();
                if($count_proposals == 0){
                    echo "
                    <div class='col-md-12 text-center'>
                    <p class='text-muted'><i class='fa fa-frown-o'></i> {$lang['user_home']['no_featured_proposals']} </p>
                    </div>";
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
                $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
                if($count_favorites == 0){
                $show_favorite_class = "proposal-favorite dil1";
                }else{
                $show_favorite_class = "proposal-unfavorite dil";
                }
                ?>
              <!-- Each Item -->
              <?php require("includes/proposals_mobile.php"); ?>
              <!-- Each item -->
              <?php } ?>
            </div>
          </div>
          <!-- Small gigs item for mobile -->
          <!-- Gigs for Desktop -->
          <div class="row d-none d-lg-flex">
            <?php
              $get_proposals = $db->query("select * from proposals where proposal_featured='yes' AND proposal_status='active' LIMIT 0,9");
              $count_proposals = $get_proposals->rowCount();
              if($count_proposals == 0){
                  echo "
                  <div class='col-md-12 text-center'>
                  <p class='text-muted'><i class='fa fa-frown-o'></i> {$lang['user_home']['no_featured_proposals']} </p>
                  </div>";
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
              $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
              if($count_favorites == 0){
              $show_favorite_class = "proposal-favorite dil1";
              }else{
              $show_favorite_class = "proposal-unfavorite dil";
              }
              ?>
            <div class="col-12 col-md-4 col-lg-6 col-xl-4">
              <?php require("includes/user_gigs.php"); ?>
            </div>
            <?php } ?>
          </div>
          <!-- Gigs for desktop end -->
        </div>
        <!-- Featured-gig-area  END-->
        
        <!-- Similar-to-recent -->
        <div class="featured-gig-area pt-40 pb-40">
          <div class="row">
            <div class="col-12">
              <div class="section-title">
                <h2>Similar to recently viewed</h2>
              </div>
            </div>
          </div>
          <div class="all-gigs-small mt-30">
            <div class="row">
              <?php
                $get_proposals = $db->query("select * from proposals where proposal_status='active' order by rand() LIMIT 0,9");
                $count_proposals = $get_proposals->rowCount();
                if($count_proposals == 0){
                    echo "
                    <div class='col-md-12 text-center'>
                    <p class='text-muted'><i class='fa fa-frown-o'></i> {$lang['user_home']['no_random_proposals']} </p>
                    </div>";
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
                $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
                if($count_favorites == 0){
                $show_favorite_class = "proposal-favorite dil1";
                }else{
                $show_favorite_class = "proposal-unfavorite dil";
                }
                ?>
              <!-- Each Item -->
              <?php require("includes/proposals_mobile.php"); ?>
              <!-- Each item -->
              <?php } ?>
            </div>
          </div>
          <!-- Small gigs item for mobile -->
          <!-- Gigs for Desktop -->
          <div class="row d-none d-lg-flex">
            <?php
              $get_proposals = $db->query("select * from proposals where proposal_status='active' order by rand() LIMIT 0,9");
              $count_proposals = $get_proposals->rowCount();
              if($count_proposals == 0){
                  echo "
                  <div class='col-md-12 text-center'>
                  <p class='text-muted'><i class='fa fa-frown-o'></i> {$lang['user_home']['no_random_proposals']} </p>
                  </div>";
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
              $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
              if($count_favorites == 0){
              $show_favorite_class = "proposal-favorite dil1";
              }else{
              $show_favorite_class = "proposal-unfavorite dil";
              }
            ?>
            <div class="col-12 col-md-4 col-lg-6 col-xl-4">
              <?php require("includes/user_gigs.php"); ?>
            </div>
            <?php } ?>
          </div>
          <!-- Gigs for desktop end -->
        </div>
        <!-- Similar-to-recent  END-->

        <!-- Shopping-trend-gigs  -->
        <div class="featured-gig-area pb-40">
          <div class="row">
            <div class="col-12">
              <div class="section-title">
                <h2>Shopping trend gigs</h2>
              </div>
            </div>
          </div>
          <div class="all-gigs-small mt-30">
            <div class="row">
              <?php
                $topProposals = array();
                $select = $db->query("select * from top_proposals");
                while($row = $select->fetch()){
                  array_push($topProposals,  $row->proposal_id);
                }
                if(empty($topProposals)){
                $query_where2 = "where level_id='4' and proposal_status='active' ";
                }else{
                $topProposals = implode(",", $topProposals);
                $topRatedWhere = "level_id='4' and proposal_status='active'";
                $query_where2 = "where proposal_id in ($topProposals) or ($topRatedWhere) ";
                }
                $get_proposals = $db->query("select * from proposals $query_where2 LIMIT 0,8");
                $count_proposals = $get_proposals->rowCount();
                if($count_proposals == 0){
                  echo "
                  <div class='col-md-12 text-center'>
                  <p class='text-muted'><i class='fa fa-frown-o'></i> {$lang['user_home']['no_top_proposals']} </p>
                  </div>";
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
                $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
                if($count_favorites == 0){
                $show_favorite_class = "proposal-favorite dil1";
                }else{
                $show_favorite_class = "proposal-unfavorite dil";
                }
                ?>
              <!-- Each Item -->
              <?php require("includes/proposals_mobile.php"); ?>
              <!-- Each item -->
              <?php } ?>
            </div>
          </div>
          <!-- Small gigs item for mobile -->
          <!-- Gigs for Desktop -->
          <div class="row d-none d-lg-flex">
            <?php
              $topProposals = array();
              $select = $db->query("select * from top_proposals");
              while($row = $select->fetch()){
                array_push($topProposals,  $row->proposal_id);
              }
              if(empty($topProposals)){
              $query_where2 = "where level_id='4' and proposal_status='active' ";
              }else{
              $topProposals = implode(",", $topProposals);
              $topRatedWhere = "level_id='4' and proposal_status='active'";
              $query_where2 = "where proposal_id in ($topProposals) or ($topRatedWhere) ";
              }
              $get_proposals = $db->query("select * from proposals $query_where2 LIMIT 0,9");
              $count_proposals = $get_proposals->rowCount();
              if($count_proposals == 0){
                echo "
                <div class='col-md-12 text-center'>
                <p class='text-muted'><i class='fa fa-frown-o'></i> {$lang['user_home']['no_top_proposals']} </p>
                </div>";
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
              $count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
              if($count_favorites == 0){
              $show_favorite_class = "proposal-favorite dil1";
              }else{
              $show_favorite_class = "proposal-unfavorite dil";
              }
              ?>
            <div class="col-12 col-md-4 col-lg-6 col-xl-4">
              <?php require("includes/user_gigs.php"); ?>
            </div>
            <?php } ?>
          </div>
          <!-- Gigs for desktop end -->
        </div>
        <!-- Shopping-trend-gigs  END-->
      </div>
      <!-- Right-sidebar START -->
      <div class="col-12 col-lg-4">
        <!-- .Sidebar-box  START-->

        <div class="sidebar-box">
          <div class="sidebar-title">
            <h4>Favourite <a href="<?= $site_url; ?>/favorites.php">See All</a></h4>
          </div>
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
          <div class="sidebar-single-item">
            <div class="sidebar-img">
              <a href="proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>">
                <img src="proposals/proposal_files/<?= $proposal_img1; ?>" alt="">
              </a>
            </div>
            <div class="sidebar-content">
              <a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>"><?= $proposal_title; ?></a>
            </div>
          </div>
          <?php } ?>
          <?php 
            if($count_favorites == 0){
              echo "<span class='text-center'><span class='pt-5 pb-5'><i class='fa fa-meh-o'></i> Your favorites page is empty</span></span>";
            }
          ?>
          
        </div>

        <!-- Recent-view -->
        <div class="sidebar-box mb-40">
          <div class="sidebar-title">
            <h4>Recently viewed <a href="javascript:void(0);">See All</a></h4>
          </div>
            <?php
            $select_recent = $db->query("select * from recent_proposals where seller_id='$login_seller_id' order by 1 DESC LIMIT 0,1");
            $count_recent = $select_recent->rowCount();
            if($count_recent == 0){
              echo "<p class='text-muted'> <i class='fa fa-frown-o'></i> {$lang['no_recently_viewed']} </p>";
            }else{ 
            ?>
              <?php
              $select_recent = $db->query("select * from recent_proposals where seller_id='$login_seller_id' order by 1 DESC LIMIT  0,5");
              while($row_recent = $select_recent->fetch()){
              $proposal_id = $row_recent->proposal_id;
              $get_proposals = $db->query("select * from proposals where proposal_id='$proposal_id' AND proposal_status='active'");
              $count_proposals = $get_proposals->rowCount();
              if($count_proposals == 1){
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

              if($videoPlugin == 1){
                $proposal_videosettings =  $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
                $enableVideo = $proposal_videosettings->enable;
              }else{
                $enableVideo = 0;
              }

              ?>
            <div class="sidebar-single-item">
              <div class="sidebar-img">
                <a href="proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>">
                  <img src="proposals/proposal_files/<?= $proposal_img1; ?>" alt="">
                </a>
              </div>
              <div class="sidebar-content">
                <a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>"><?= $proposal_title; ?></a>
              </div>
            </div>
            <?php } ?>
          <?php } ?>
        <?php } ?>
        </div>

        <!-- .Sidebar-box  END-->
      </div>
    </div>
    <!-- End Gigs -->
  </div>
</div>
<!-- End New Design -->


<!-- Container ends -->
<br>
<div class="append-modal"></div>
<div id="quota-finish" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
  <h5 class="modal-title h5"><i class="fa fa-frown-o fa-move-up"></i> Request Quota Reached</h5>
  <button class="close" data-dismiss="modal"> &times; </button>
  </div>
  <div class="modal-body">
  <center>
  <h5>You can only send a max of 10 offers per day. Today you've maxed out. Try again tomorrow. </h5>
  </center>
  </div>
  <div class="modal-footer">
  <button class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</div>
