
<main>
    <section class="container-fluid gigs-single">
      <div class="row">
        <div class="container">
          <div class="row">
            <div class="left-card">
              <div class="gigs-single-card">
                <div class="gigs-single-card-header">
                  <h3><?= ucfirst($proposal_title); ?></h3>
                  
                  <ul class="list-inline">
                    <?php
                      for($proposal_i=0; $proposal_i<$proposal_rating; $proposal_i++){
                      echo "<li class='list-inline-item'> <i class='fas fa-star'></i></li> ";
                      }
                      for($proposal_i=$proposal_rating; $proposal_i<5; $proposal_i++){
                      echo "<li class='list-inline-item'> <i class='fas fa-star-o'></i></li>";
                      }
                    ?>
                    <li class="list-inline-item">(<?= $count_reviews; ?> Reviews)  &nbsp;<?= $proposal_order_queue; ?> Order(s) In Queue</li>
                  </ul>
                  <!-- <div class="sharethis-inline-share-buttons <?=($lang_dir == "right" ? 'float-left':'')?>" style="margin-top: -36px;"></div> -->
                  </div>
                
                <!-- Gigs single card header -->
                <div class="gigs-single-body">
                  <?php include("includes/proposal_slider.php"); ?>
                </div>
                <!-- Gigs single card body -->
              </div>
              <!-- Gigs single card -->
            </div>
            <div class="right-card">
              <div class="gigs-single-usercard d-flex flex-row align-items-center">
                <div class="image">
                  <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
                </div>
                <div class="text d-flex flex-column">
                  <span><a href="../../<?= $proposal_seller_user_name; ?>" style="color: #3A3A3A;"><?= ucfirst($proposal_seller_user_name); ?></a></span>
                  <span><?= $proposal_seller_country; ?></span>
                </div>
              </div>
              <!-- User card -->
              <div class="d-flex flex-wrap justify-content-between">
                <div class="gig-packages active-single-gig">
                  <?php
                    $get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic'));
                    $row_1 = $get_p_1->fetch();
                    $p_id_1 = $row_1->package_id;
                    $p_name_1 = $row_1->package_name;
                    $p_description_1 = $row_1->description;
                    $p_revisions_1 = $row_1->revisions;
                    $p_delivery_time_1 = $row_1->delivery_time;
                    $p_price_1 = $row_1->price;
                    
                    $get_p_2 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard'));
                    $row_2 = $get_p_2->fetch();
                    $p_id_2 = $row_2->package_id;
                    $p_name_2 = $row_2->package_name;
                    $p_description_2 = $row_2->description;
                    $p_revisions_2 = $row_2->revisions;
                    $p_delivery_time_2 = $row_2->delivery_time;
                    $p_price_2 = $row_2->price;

                    $get_p_3 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance'));
                    $row_3 = $get_p_3->fetch();
                    $p_id_3 = $row_3->package_id;
                    $p_name_3 = $row_3->package_name;
                    $p_description_3 = $row_3->description;
                    $p_revisions_3 = $row_3->revisions;
                    $p_delivery_time_3 = $row_3->delivery_time;
                    $p_price_3 = $row_3->price;

                    if($proposal_seller_vacation == "on"){
                      $disabled = "disabled='disabled'";
                    }else{
                      $disabled = "";
                    }
                  ?>
                  <?php if($p_description_2 == '' && $p_description_3 == ''){ ?>
                  <div class="single-package d-flex flex-column align-items-center justify-content-center" style="background-image: url(../../assets/img/post-a-gig/tryit-bg.png);">
                    <div class="packages-item d-flex flex-column">
                      <div class="image-icon d-flex flex-row align-items-center">
                        <span>
                          <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/gigs/gig-icon-basic.png" />
                        </span>
                        <span>Basic</span>
                      </div>
                      <p><?= $p_description_1; ?></p>
                      <a class="button button-red" href="javascript:void(0);"><?= $s_currency; ?> <?= $p_price_1; ?></a>
                    </div>
                  </div>
                <?php } else{ ?>
                  <!-- Single packages -->
                  <div class="packages-item d-flex flex-column">
                    <div class="image-icon d-flex flex-row align-items-center">
                      <span>
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/gigs/gig-icon-basic.png" />
                      </span>
                      <span>Basic</span>
                    </div>
                    <p><?= $p_description_1; ?></p>
                    <a class="button button-red" href="javascript:void(0);"><?= $s_currency; ?> <?= $p_price_1; ?></a>
                  </div>
                  <!-- Each item -->
                  <div class="packages-item d-flex flex-column">
                    <div class="image-icon d-flex flex-row align-items-center">
                      <span>
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/gigs/gig-icon-premium.png" />
                      </span>
                      <span>Standard</span>
                    </div>
                    <p><?= $p_description_2; ?></p>
                    <a class="button button-red" href="javascript:void(0);"><?= $s_currency; ?> <?= $p_price_2; ?></a>
                  </div>
                  <!-- Each item -->
                  <div class="packages-item d-flex flex-column">
                    <div class="image-icon d-flex flex-row align-items-center">
                      <span>
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/gigs/gig-icon-standard.png" />
                      </span>
                      <span>Premium</span>
                    </div>
                    <p><?= $p_description_3; ?></p>
                    <a class="button button-red" href="javascript:void(0);"><?= $s_currency; ?> <?= $p_price_3; ?></a>
                  </div>
                  <!-- Each item -->
                <?php } ?>
                </div>
                <!-- Gig packages -->
                <div class="payment-card">
                  <h4 class="text-center">Pay By</h4>
                  <div class="payment-items">
                    <div class="payment-item">
                      <img class="img-fluid d-block ml-auto mr-auto" src="<?= $site_url; ?>/assets/img/payment/online.png" />
                      <span>Online</span>
                    </div>
                    <!-- Each item -->
                    <div class="payment-item">
                      <img class="img-fluid d-block ml-auto mr-auto" src="<?= $site_url; ?>/assets/img/payment/mobile.png" />
                      <span>Mobile Wallet</span>
                    </div>
                    <!-- Each item -->
                    <div class="payment-item">
                      <img class="img-fluid d-block ml-auto mr-auto" src="<?= $site_url; ?>/assets/img/payment/cash.png" />
                      <span>Cash</span>
                    </div>
                    <!-- Each item -->
                    <div class="payment-item">
                      <img class="img-fluid d-block ml-auto mr-auto" src="<?= $site_url; ?>/assets/img/payment/local.png" />
                      <span>Local</span>
                    </div>
                    <!-- Each item -->
                  </div>
                </div>
                <!-- Payment item -->
              </div>
            </div>
          </div>
          <!-- Row -->
          <div class="row">
            <div class="left-card">
              <div class="packages-container d-flex flex-column">
                <?php
                  $get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic'));
                  $row_1 = $get_p_1->fetch();
                  $p_id_1 = $row_1->package_id;
                  $p_name_1 = $row_1->package_name;
                  $p_description_1 = $row_1->description;
                  $p_revisions_1 = $row_1->revisions;
                  $p_delivery_time_1 = $row_1->delivery_time;
                  $p_price_1 = $row_1->price;
                  
                  $get_p_2 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard'));
                  $row_2 = $get_p_2->fetch();
                  $p_id_2 = $row_2->package_id;
                  $p_name_2 = $row_2->package_name;
                  $p_description_2 = $row_2->description;
                  $p_revisions_2 = $row_2->revisions;
                  $p_delivery_time_2 = $row_2->delivery_time;
                  $p_price_2 = $row_2->price;

                  $get_p_3 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance'));
                  $row_3 = $get_p_3->fetch();
                  $p_id_3 = $row_3->package_id;
                  $p_name_3 = $row_3->package_name;
                  $p_description_3 = $row_3->description;
                  $p_revisions_3 = $row_3->revisions;
                  $p_delivery_time_3 = $row_3->delivery_time;
                  $p_price_3 = $row_3->price;

                  if($proposal_seller_vacation == "on"){
                    $disabled = "disabled='disabled'";
                  }else{
                    $disabled = "";
                  }
                ?>
                <div class="package-header d-flex flex-row">
                  <div class="package-header-item d-flex flex-column align-items-center">&nbsp;</div>
                  <!-- Each item -->
                  <div class="package-header-item">
                    <div class="package-icon">
                      <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/basic-icon.png" />
                    </div>
                    <span class="text">Basic</span>
                  </div>
                  <!-- Each item -->
                  <div class="package-header-item">
                    <div class="package-icon">
                      <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/standard-icon.png" />
                    </div>
                    <span class="text">Standard</span>
                  </div>
                  <!-- Each item -->
                  <div class="package-header-item">
                    <div class="package-icon">
                      <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/premium-icon.png" />
                    </div>
                    <span class="text">Premium</span>
                  </div>
                  <!-- Each item -->
                </div>
                <!-- Packages header -->
                <div class="package-body d-flex flex-column">
                  <div class="package-item d-flex flex-row">
                    <div class="package-item-single">
                      <span class="title">Description</span>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single">
                      <span class="package-title">Basic</span>
                      <p><?= $p_description_1; ?></p>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single">
                      <span class="package-title">Standard</span>
                      <p><?= $p_description_2; ?></p>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single">
                      <span class="package-title">Premium</span>
                      <p><?= $p_description_3; ?></p>
                    </div>
                    <!-- Each item -->
                  </div>
                  <!-- Package-item -->
                  <?php
                  $get_a = $db->select("package_attributes",array("package_id"=>$p_id_1));
                  while($row_a = $get_a->fetch()){
                  $a_id = $row_a->attribute_id;
                  $a_name = $row_a->attribute_name;
                  $a_value = $row_a->attribute_value;
                  ?>
                  <div class="package-item d-flex flex-row">
                    <div class="package-item-single">
                      <span class="title"><?= $a_name; ?></span>
                    </div>
                    <!-- Each item -->
                    <?php
                    $get_v = $db->query("select * from package_attributes where proposal_id='$proposal_id' and attribute_name='$a_name' and not attribute_id='$a_id'");
                    while($row_v = $get_v->fetch()){
                    $value = $row_v->attribute_value;
                    ?>
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $value; ?></p>
                    </div>
                    <?php } ?>
                    <!-- Each item -->
                  </div>
                  <!-- Package-item -->
                  <?php } ?>
                  <div class="package-item d-flex flex-row">
                    <div class="package-item-single">
                      <span class="title">Revisions</span>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $p_revisions_1; ?> Revisions</p>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $p_revisions_2; ?> Revisions</p>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $p_revisions_3; ?>  Revisions</p>
                    </div>
                    <!-- Each item -->
                  </div>
                  <!-- Package-item -->
                  <div class="package-item d-flex flex-row">
                    <div class="package-item-single">
                      <span class="title">Delivery Time</span>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $p_delivery_time_1; ?> Day</p>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $p_delivery_time_2; ?> Day</p>
                    </div>
                    <!-- Each item -->
                    <div class="package-item-single d-flex align-items-center justify-content-center">
                      <p class="text-center"><?= $p_delivery_time_3; ?> Day</p>
                    </div>
                    <!-- Each item -->
                  </div>
                  <!-- Package-item -->
                  <div class="package-item d-flex flex-row justify-content-end">
                    <form method="post" action="../../checkout" style="display: contents;">
                    <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
                    <input type="hidden" name="package_id" value="<?= $p_id_1; ?>">
                      <?php if($proposal_seller_id == @$login_seller_id){ ?>
                      <div class="package-item-single d-flex align-items-center justify-content-center">
                        <a class="button button-red" href="../edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing">Edit Package</a>
                      </div>
                      <?php }else{ ?>
                      <div class="package-item-single d-flex align-items-center justify-content-center">
                        <button class="button button-red" type="submit" name="add_order" <?= $disabled; ?>><?= $s_currency; ?><?= $p_price_1; ?></button>
                      </div>
                      <?php } ?>                      
                      <!-- Each item -->
                      
                      <?php if($proposal_seller_id == @$login_seller_id){ ?>
                      <div class="package-item-single d-flex align-items-center justify-content-center">
                        <a class="button button-red" href="../edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing">Edit Package</a>
                      </div>
                      <?php }else{ ?>
                      <div class="package-item-single d-flex align-items-center justify-content-center">
                        <button class="button button-red" type="submit" name="add_order" <?= $disabled; ?>><?= $s_currency; ?><?= $p_price_2; ?></button>
                      </div>
                      <?php } ?>
                      <!-- Each item -->
                      <?php if($proposal_seller_id == @$login_seller_id){ ?>
                      <div class="package-item-single d-flex align-items-center justify-content-center">
                        <a class="button button-red" href="../edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing">Edit Package</a>
                      </div>
                      <?php }else{ ?>
                      <div class="package-item-single d-flex align-items-center justify-content-center">
                        <button class="button button-red" type="submit" name="add_order" <?= $disabled; ?>><?= $s_currency; ?><?= $p_price_3; ?></button>
                      </div>
                      <?php } ?>
                      <!-- Each item -->
                    </form>
                  </div>
                  <!-- Package-item -->
                </div>
                <!-- Packages body -->
                <?php if($p_description_2 == '' && $p_description_3 == ''){ ?>
                <div class="tryit-overlay d-flex flex-column justify-content-center align-items-center" style="background-image: url(../../assets/img/post-a-gig/tryit-bg.png);">&nbsp;</div>
                <?php } ?>
                <!-- Try it overlay -->
              </div>
              <!-- Package contaner end -->
            </div>
            <div class="right-card">
              <div class="reviews-card">
                <div class="reviews-card-header d-flex flex-row">
                  <span>
                    <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/gigs/review-icon.png" />
                  </span>
                  <span>Latest Reviews</span>
                </div>
                <!-- Review card header -->
                <div class="reviews-card-body">
                  <?php
                  $select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
                  $count_reviews = $select_buyer_reviews->rowCount();
                  if($count_reviews == 0){
                  $rtl = ($lang_dir == "right" ? 'text-right':'');
                  echo "<div class='reviwed-item d-flex flex-row align-items-start'>
                  <h6 class='$rtl' align='center'> 
                  <i class='fa fa-frown-o'></i> This gigs has no reviews yet. Be the first to post in a review.
                  </h6>
                  </div>";
                  }
                  while($row_buyer_reviews = $select_buyer_reviews->fetch()){
                    $order_id = $row_buyer_reviews->order_id;
                    $review_buyer_id = $row_buyer_reviews->review_buyer_id;
                    $buyer_rating = $row_buyer_reviews->buyer_rating;
                    $buyer_review = $row_buyer_reviews->buyer_review;
                    $review_date = $row_buyer_reviews->review_date;
                    $select_buyer = $db->select("sellers",array("seller_id" => $review_buyer_id));
                    $row_buyer = $select_buyer->fetch();
                    $buyer_user_name = $row_buyer->seller_user_name;
                    $buyer_image = $row_buyer->seller_image;
                    $select_seller_review = $db->select("seller_reviews",array("order_id" => $order_id));
                    $count_seller_review =  $select_seller_review->rowCount();
                    $row_seller_review = $select_seller_review->fetch();
                    $seller_rating = @$row_seller_review->seller_rating;
                    $seller_review = @$row_seller_review->seller_review;
                  ?>
                  <div class="reviwed-item d-flex flex-row align-items-start">
                    <div class="image">
                      <?php if(!empty($buyer_image)){ ?>
                      <img src="../../user_images/<?php echo $buyer_image; ?>" width="40" height="40">
                      <?php } else{ ?>
                      <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
                      <?php } ?>
                    </div>
                    <div class="text">
                      <div class="user-name d-flex flex-row">
                        <span><?php echo $buyer_user_name; ?></span>
                        <span>
                          <?php
                          for($buyer_i=0; $buyer_i<$buyer_rating; $buyer_i++){
                          echo "<i class='fas fa-star'></i> ";
                          }
                          for($buyer_i=$buyer_rating; $buyer_i<5; $buyer_i++){
                          echo "<i class='fas fa-star-o'></i>";
                          }
                          ?>
                        </span>
                        <span><?= $buyer_rating; ?></span>
                      </div>
                      <p><?php echo $buyer_review; ?></p>
                      <div class="time-stamp"><?php echo $review_date; ?></div>
                    </div>
                  </div>
                  <?php } ?>
                  <!-- Each item -->
                </div>
                <!-- Review card body -->
                <div class="review-card-footer">+ Show More</div>
                <!-- Review footer -->
              </div>
            </div>
          </div>
          <!-- Row -->
        </div>
      </div>
      <!-- Row -->
    </section>
  </main>



<!-- <div class="mp-gig-top-nav">
  <nav>
    <ul class="container text-center" id="mainNav">
      <li class="selected">
        <a href="#introduction" class="gig-page-nav-link">Introduction</a>
      </li>
      <li>
        <a href="#details" class="gig-page-nav-link">Proposal Details</a>
      </li>
      <?php if($count_faq != 0){ ?>
      <li>
        <a href="#faq" class="gig-page-nav-link">FAQ</a>
      </li>
      <?php } ?>
      <li>
        <a href="#reviews" class="gig-page-nav-link">Reviews</a>
      </li>
      <li>
        <a href="#related" class="gig-page-nav-link">Related Proposals</a>
      </li>
      <?php if($proposal_seller_vacation == "off"){ ?>
      <li>
      <a href="#redirect" onclick="window.location.href='../../conversations/message.php?seller_id=<?= $proposal_seller_id; ?>'" class="gig-page-nav-link"> <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> Message the Seller</a>
      </li>
      <?php } ?>
      <?php if($proposal_price != 0){ ?>
      <li class="btns d-none float-right">
      <button class="order-now btn btn-secondary">Order Now (<?= $s_currency; ?><span class="total-price"><?= $proposal_price; ?></span>)</button>
      </li>
      <?php } ?>
      <li class="btns d-none float-right">
      <?php if(@$count_p_cart == 1){ ?>
      <button class="btn btn-secondary"><?php include("../images/svg/cart.svg"); ?> Already Added</button>
      <?php }else{ ?>
      <button class="add-to-cart btn btn-secondary"><?php include("../images/svg/cart.svg"); ?> Add To Cart</button>
      <?php } ?>
      </li>
    </ul>
  </nav>
</div>

<div class="container mt-5" id="introduction"> --> 
  <!-- Container starts -->
  <!-- <div class="row">
  <div class="col-lg-8 col-md-7 mb-3"> -->
    <!--- col-lg-8 col-md-7 mb-3 Starts --->
    <!-- <div class="card rounded-0 mb-5 border-0">
      <div class="card-body details pt-0">
        <div class="proposal-info <?=($lang_dir == "right" ? 'text-right':'')?>">
        <h3><?= ucfirst($proposal_title); ?></h3>
        <hr>
        <nav class="breadcrumbs h-text-truncate mb-2">
          <a href="../../">Home</a>
          <a href="../../categories/<?= $proposal_cat_url; ?>"> <?= $proposal_cat_title; ?> </a> 
          <a href="../../categories/<?= $proposal_cat_url; ?>/<?= $proposal_child_url; ?>">
          <?= $proposal_child_title; ?>
          </a>
        </nav>
        <?php
        for($proposal_i=0; $proposal_i<$proposal_rating; $proposal_i++){
        echo " <img class='mb-1' src='../../images/user_rate_full.png' > ";
        }
        for($proposal_i=$proposal_rating; $proposal_i<5; $proposal_i++){
        echo " <img class='mb-1' src='../../images/user_rate_blank.png' > ";
        }
        ?>
        <span class="text-muted span"> (<?= $count_reviews; ?>) &nbsp;<?= $proposal_order_queue; ?> Order(s) In Queue.</span>
        <div class="sharethis-inline-share-buttons <?=($lang_dir == "right" ? 'float-left':'')?>" style="margin-top: -36px;"></div>
        </div>
        <?php //include("includes/proposal_slider.php"); ?>
      </div>
    </div>
    <?php if($proposal_price == 0){ ?>
    <div class="card rounded-0 mb-3 <?=($lang_dir == "right" ? 'text-right':'')?>" id="compare">
    <div class="card-header"><h5>Compare Packages</h5></div>
    <div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-bordered mb-0" style="table-layout: fixed; width: 100%;">
    <tbody>
    <?php
    
    $get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic'));
    $row_1 = $get_p_1->fetch();
    $p_id_1 = $row_1->package_id;
    $p_name_1 = $row_1->package_name;
    $p_description_1 = $row_1->description;
    $p_revisions_1 = $row_1->revisions;
    $p_delivery_time_1 = $row_1->delivery_time;
    $p_price_1 = $row_1->price;
    
    $get_p_2 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard'));
    $row_2 = $get_p_2->fetch();
    $p_id_2 = $row_2->package_id;
    $p_name_2 = $row_2->package_name;
    $p_description_2 = $row_2->description;
    $p_revisions_2 = $row_2->revisions;
    $p_delivery_time_2 = $row_2->delivery_time;
    $p_price_2 = $row_2->price;

    $get_p_3 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance'));
    $row_3 = $get_p_3->fetch();
    $p_id_3 = $row_3->package_id;
    $p_name_3 = $row_3->package_name;
    $p_description_3 = $row_3->description;
    $p_revisions_3 = $row_3->revisions;
    $p_delivery_time_3 = $row_3->delivery_time;
    $p_price_3 = $row_3->price;

    if($proposal_seller_vacation == "on"){
      $disabled = "disabled='disabled'";
    }else{
      $disabled = "";
    }
    
    ?>
    <tr class="<?=($lang_dir == "right" ? 'text-right':'')?>">
    <td class="b-ccc">  </td>
    <td><h5><?= $lang['packages']['basic']; ?></h5></td>
    <td><h5><?= $lang['packages']['standard']; ?></h5></td>
    <td><h5><?= $lang['packages']['advance']; ?></h5></td>
    </tr>
    <tr class="<?=($lang_dir == "right" ? 'text-right':'')?>" width="20">
      <td class="b-ccc">Description</td>
      <td><?= $p_description_1; ?></td>
      <td><?= $p_description_2; ?></td>
      <td><?= $p_description_3; ?></td>
    </tr>

    <?php
    $get_a = $db->select("package_attributes",array("package_id"=>$p_id_1));
    while($row_a = $get_a->fetch()){
    $a_id = $row_a->attribute_id;
    $a_name = $row_a->attribute_name;
    $a_value = $row_a->attribute_value;
    ?>
    <tr>
      <td class="b-ccc" width="150"> <?= $a_name; ?> </td>
      <td><?= $a_value; ?> </td>
      <?php
      $get_v = $db->query("select * from package_attributes where proposal_id='$proposal_id' and attribute_name='$a_name' and not attribute_id='$a_id'");
      while($row_v = $get_v->fetch()){
      $value = $row_v->attribute_value;
      ?>
      <td><?= $value; ?> </td>
    <?php } ?>
    </tr>
    <?php } ?>
    
    <tr>
      <td class="b-ccc" width="150"> Revisions </td>
      <td><?= $p_revisions_1; ?></td>
      <td><?= $p_revisions_2; ?></td>
      <td><?= $p_revisions_3; ?></td>
    </tr>
    <tr>
      <td class="b-ccc" width="150"> Delivery Time </td>
      <td><?= $p_delivery_time_1; ?> Days</td>
      <td><?= $p_delivery_time_2; ?> Days</td>
      <td><?= $p_delivery_time_3; ?> Days</td>
    </tr>
    <tr>
      <td class="b-ccc"> Qty </td>
      <td>
        <form method="post" action="../../checkout">
          <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
          <input type="hidden" name="package_id" value="<?= $p_id_1; ?>">
          <select class="form-control mb-2" name="proposal_qty">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          </select>
          <?php if($proposal_seller_id == @$login_seller_id){ ?>
          <a class="btn btn-success text-white btn-block" href="../edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing">Edit Package</a>
          <?php }else{ ?>
          <button class="btn btn-success text-white btn-block" type="submit" name="add_order" <?= $disabled; ?>>Select <?= $s_currency; ?><?= $p_price_1; ?></button>
          <?php } ?>
        </form>
      </td>
      <td>
        <form method="post" action="../../checkout">
          <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
          <input type="hidden" name="package_id" value="<?= $p_id_2; ?>">
          <select class="form-control mb-2" name="proposal_qty">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          </select>
          <?php if($proposal_seller_id == @$login_seller_id){ ?>
          <a class="btn btn-success text-white btn-block" href="../edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing">Edit Package</a>
          <?php }else{ ?>
          <button class="btn btn-success text-white btn-block" type="submit" name="add_order" <?= $disabled; ?>>Select <?= $s_currency; ?><?= $p_price_2; ?></button>
          <?php } ?>
        </form>
      </td>
      <td>
        <form method="post" action="../../checkout">
          <input type="hidden" name="proposal_id" value="<?= $proposal_id; ?>">
          <input type="hidden" name="package_id" value="<?= $p_id_3; ?>">
          <select class="form-control mb-2" name="proposal_qty">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          </select>
          <?php if($proposal_seller_id == @$login_seller_id){ ?>
          <a class="btn btn-success text-white btn-block" href="../edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing">Edit Package</a>
          <?php }else{ ?>
          <button class="btn btn-success text-white btn-block" type="submit" name="add_order" <?= $disabled; ?>>Select <?= $s_currency; ?><?= $p_price_3; ?></button>
          <?php } ?>
        </form>
      </td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <?php } ?>

    <div class="card rounded-0 mb-5 <?=($lang_dir == "right" ? 'text-right':'')?>" id="details">
      <div class="card-header"><h4>About This Proposal</h4></div>
      <div class="card-body proposal-desc"><?= $proposal_desc; ?></div>
    </div>

    <?php if($count_faq > 0){ ?>

    <div class="card mb-5 <?=($lang_dir == "right" ? 'text-right':'')?> faqs" id="faq"> -->
      <!-- card Starts -->
    <!-- <div class="card-header"> -->
      <!-- card-header Starts -->
    <!-- <h4>Frequently Asked Questions</h4>
    </div> --><!-- card-header Ends -->
    <!-- <div class="card-body tabs pl-0 pr-0 pt-2"> -->
      <!-- card-body Starts -->
      <!-- <?php 
      while($row_faq = $get_faq->fetch()){
      $id = $row_faq->id;
      $title = $row_faq->title;
      $content = $row_faq->content;
      ?>
      <div class="tab"> -->
        <!-- tab rounded Starts -->
      <!-- <div class="tab-header" data-toggle="collapse" href="#tab-<?= $id; ?>">
      <?= $title; ?>
      </div>
      <div class="tab-body p-3 collapse" id="tab-<?= $id; ?>"><?= $content; ?></div>
      </div> -->
      <!-- tab rounded Ends -->
      <!-- <?php } ?>
      <div class="clearfix"></div>
    </div> -->
    <!-- card-body Ends -->
    <!-- </div> -->
    <!-- card mb-3 Ends -->
    <!-- <?php } ?>

    <div class="card proposal-reviews rounded-0 mb-5" id="reviews">
      <div class="card-header">
        <h4 class="mb-0 <?=($lang_dir == "right" ? 'text-right':'')?>">
        <div class="float-left">
        <span class="mr-2"> <?= $count_reviews; ?> Reviews </span>
        <?php
        for($proposal_i=0; $proposal_i<$proposal_rating; $proposal_i++){
        echo " <img class='mb-2' src='../../images/user_rate_full_big.png' > ";
        }
        for($proposal_i=$proposal_rating; $proposal_i<5; $proposal_i++){
        echo " <img class='mb-2' src='../../images/user_rate_blank_big.png' > ";
        }
        ?> <span class="text-muted ml-2"> <?php
        if($proposal_rating == "0"){
        echo "0.0"; 
        }else{
        printf("%.1f", $average_rating);
        }
        ?> </span>
        </div>
        <div class="float-right">
        <button id="dropdown-button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Most Recent </button>
        <ul class="dropdown-menu proposalDropdown" style="width: auto !important;">
        <li class="dropdown-item active all">Most Recent</li>
        <li class="dropdown-item  good">Positive Reviews</li>
        <li class="dropdown-item  bad">Negative Reviews</li>
        </ul>
        </div>
        </h4>
      </div>
      <div class="card-body <?=($lang_dir == "right" ? 'text-right':'')?>">
      <?php //include("includes/proposal_reviews.php") ?>
      </div>
    </div>
    <div class="proposal-tags-container mt-2 <?=($lang_dir == "right" ? 'text-right':'')?>"> -->
      <!--- proposal-tags-container Starts --->
     <!--  <?php
      $tags = explode(",", $proposal_tags);
      foreach($tags as $tag){
      ?>
      <div class="proposal-tag mb-3" style="<?=($lang_dir == "right" ? 'float: right;':'')?>"><a href="../../tags/<?= $tag; ?>"><span><?= $tag; ?></span></a></div>
      <?php } ?>
    </div> -->
    <!--- proposal-tags-container Ends --->

  <!-- </div> -->
  <!--- col-lg-8 col-md-7 mb-3 Ends --->

  <!-- <div class="col-lg-4 col-md-5 proposal-sidebar">  -->
    <!-- Col starts -->
  <!-- <?php// include("includes/proposal_sidebar.php"); ?> -->
  <!-- </div>  -->
  <!-- Col ends -->

  <!-- </div>
</div> -->
<!--Container ends -->

<script>
$(document).ready(function(){

  <?php if(!empty($proposal_video)){ ?>
    $(".carousel-indicators").css({"bottom": "60px"});
    $("#myCarousel").on('slide.bs.carousel', function(event){
     var eq = event.to;
     if(eq == 0){
        $(".carousel-indicators").css({"bottom": "60px"});
     }else{
        $(".carousel-indicators").css({"bottom": "20px"});
     }
    });
  <?php } ?>

  <?php if($proposal_price != 0){ ?>
    var form = "#checkoutForm";
  <?php }else{ ?>
    var form = "#checkoutForm2";
  <?php } ?>

  $(".order-now").click(function(){
    $('<input />').attr('type', 'hidden').attr('name', "add_order").attr('value', " ").appendTo(form);
    $(form).submit();
  });

  $(".add-to-cart").click(function(){
    $('<input />').attr('type', 'hidden').attr('name', "add_cart").attr('value', " ").appendTo(form);
    $(form).submit();
  });

  $(window).scroll(function(){
    var scrollTop = $(window).scrollTop();
    if(scrollTop > 0){
      $('.mp-gig-top-nav li.btns').removeClass("d-none");
      $('.mp-gig-top-nav').css({ position : 'fixed', zIndex : "100", top : "0px" });
    }else{
      $('.mp-gig-top-nav li.btns').addClass("d-none");
      $('.mp-gig-top-nav').css({ position : 'sticky', zIndex : "10" });
    }
  });

  <?php if(isset($_SESSION['seller_user_name'])){ ?>
  $(document).on("click", "#favorite_<?= $proposal_id; ?>", function(event){
    event.preventDefault();
    var seller_id = "<?= $login_seller_id; ?>";
    var proposal_id = "<?= $proposal_id; ?>";
    $.ajax({
      type: "POST",
      url: "../../includes/add_delete_favorite",
      data: { seller_id: seller_id, proposal_id: proposal_id, favorite: "add_favorite" },
      success: function(){
      $("#favorite_<?= $proposal_id; ?>").attr({id: "unfavorite_<?= $proposal_id; ?>",});
      $("#unfavorite_<?= $proposal_id; ?>").html("<i class='fa fa-heart dil'></i>");
      }
    });
  });

  $(document).on("click", "#unfavorite_<?= $proposal_id; ?>", function(event){
    event.preventDefault();
    var seller_id = "<?= $login_seller_id; ?>";
    var proposal_id = "<?= $proposal_id; ?>";
    $.ajax({
      type: "POST",
      url: "../../includes/add_delete_favorite",
      data: { seller_id: seller_id, proposal_id: proposal_id, favorite: "delete_favorite" },
      success: function(){
      $("#unfavorite_<?= $proposal_id; ?>").attr({id: "favorite_<?= $proposal_id; ?>"});
      $("#favorite_<?= $proposal_id; ?>").html("<i class='fa fa-heart dil1'></i>");
      }
    });
  });
  <?php } ?>

  $('.increase').click(function(){
    var current = parseInt($('.quantity').text());
    var num = current+1;
    var value = parseInt($('.total-price').first().text());
    $('.quantity').html(num);
    $('form input[name="proposal_qty"]').val(num);
  });

  $('.decrease').click(function(){
    var current = parseInt($('.quantity').text());
    if(current > 1){
    var num = current-1;
    var value = parseInt($('.total-price').first().text());
    $('.quantity').html(num);
    $('form input[name="proposal_qty"]').val(num);
    }
  });

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
$(function(){
    $('.owl-carousel').owlCarousel({
      loop: false,
      margin: 10,
      nav: true,
      items: 4,
      navText: ['<i class="fal fa-angle-left"></i>','<i class="fal fa-angle-right"></i>'],
      dots: false
    })
  });
</script>