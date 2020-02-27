<?php
  session_start([
    'cookie_lifetime' => 86400,
  ]);
  if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";
  }
  require_once("includes/db.php");
  require_once("social-config.php");

  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_name = $row_login_seller->seller_name;
  $login_user_name = $row_login_seller->seller_user_name;
  $login_seller_offers = $row_login_seller->seller_offers;
  $relevant_requests = $row_general_settings->relevant_requests;

  //print_r($row_login_seller);
  ?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title> <?php echo $site_name; ?> - Buyer </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">
    <!-- ==============Google Fonts============= -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
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
    <!--====== Default css ======-->
    <link href="assets/css/default.css" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="assets/css/style.css" rel="stylesheet">
    <!--====== Responsive css ======-->
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link href="styles/animate.css" rel="stylesheet">
    <link href="styles/styles.css" rel="stylesheet">
    <link href="styles/styles.css" rel="stylesheet">
    <link href="styles/categories_nav_styles.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="styles/owl.carousel.css" rel="stylesheet">
    <link href="styles/owl.theme.default.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link href="styles/animate.css" rel="stylesheet">  
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    
    <link href="<?= $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">
    <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.swal2-popup .swal2-select{display: none;}.cat-nav .top-nav-item{margin-top: 0;}.header-menu .mainmenu ul li a{padding: 18px 0;}.cat-nav .top-nav-item.active {border-bottom: 3px solid #ff0000;}</style>
  </head>
  <body class="all-content">
    <!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
        <img src="assets/img/emongez_cube.png" />
      </div>
    </div>
    <!-- Preloader End -->
    <!-- Header Include -->
    <?php require_once('includes/buyer-header.php'); ?>
    <!-- Main Content -->
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
              <div class="single-slide-item" style="background-image: url(assets/img/slider/1.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/2.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/2.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/3.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/4.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/1.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/2.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/2.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/3.jpg);"></div>
              <div class="single-slide-item" style="background-image: url(assets/img/slider/4.jpg);"></div>
            </div>
            <!-- Home-slider  END-->
          </div>
        </div>
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
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                </div>
              </div>
              <!-- Small gigs item for mobile -->
              <div class="row d-none d-lg-flex">
                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/1.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/2.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/3.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- Featured-gig-area  END-->

            <!-- Similar-to-recent -->
            <div class="featured-gig-area pt-40 pb-40">


              <div class="row">
                <div class="col-12">
                  <div class="section-title">
                    <h2>Similar to recently viewed </h2>
                  </div>
                </div>
              </div>
              <div class="all-gigs-small mt-30">
                <div class="row">
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                </div>
              </div>
              <!-- Small gigs item for mobile -->
              <div class="row d-none d-lg-flex">
                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/4.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/5.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/5.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

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
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                  <div class="col-12">
                    <div class="small-gigs-item d-flex flex-column">
                      <div class="small-gigs-item-header d-flex justify-content-between">
                        <div class="small-gigs-image">
                          <img class="img-fluid d-block" src="https://loremflickr.com/g/460/500/gig" />
                        </div>
                        <div class="small-gigs-content d-flex justify-content-between">
                          <div class="content d-flex flex-column justify-content-between">
                            <h3 class="title">
                              <a href="javascript:void(0);">I will do sensational, professional logo design in 12 hours</a>
                            </h3>
                            <div class="rating d-flex flex-row align-items-center">
                              <span><i class="fas fa-star"></i></span>
                              <span>4.8</span>
                              <span>(1k+)</span>
                            </div>
                          </div>
                          <div class="icon d-flex flex-column align-items-end justify-content-between">
                            <a href="javascript:void(0);">
                              <i class="fas fa-heart"></i>
                            </a>
                            <div class="verified-tag">Verified</div>
                          </div>
                        </div>
                      </div>
                      <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="small-gigs-seller d-flex flex-row align-items-center">
                          <div class="user-image">
                            <img class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                          </div>
                          <div class="user-name">abcd</div>
                        </div>
                        <div class="small-gigs-pricing d-flex flex-row">
                          <a href="javascript:void(0);">$25</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Each item -->
                </div>
              </div>
              <!-- Small gigs item for mobile -->
              <div class="row d-none d-lg-flex">
                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/7.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/8.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4 col-lg-6 col-xl-4">
                  <div class="product-single-item">
                    <div class="product-img">
                      <div class="verified">
                        <img src="assets/img/verifired.png" alt="">
                      </div>
                      <img src="assets/img/product/9.jpg" alt="">
                    </div>
                    <div class="product-text">
                      <div class="product-author">
                        <img src="assets/img/user.png" alt="">
                        <span>bossdesigners</span>
                      </div>
                      <h5>I will design the best logo</h5>
                      <div class="rating">
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span class="star-count">(25)</span>
                      </div>
                      <div class="product-price">
                        <i class="fas fa-heart"></i>
                        <span>$25</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- Shopping-trend-gigs  END-->

          </div>
          <!-- Right-sidebar START -->
          <div class="col-12 col-lg-4">
            <!-- .Sidebar-box  START-->

            <div class="sidebar-box">
              <div class="sidebar-title">
                <h4>Favourite <a href="javascript:void(0);">See All</a></h4>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/1.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/2.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/3.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/4.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/5.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>
            </div>

            <!-- Recent-view -->
            <div class="sidebar-box mb-40">
              <div class="sidebar-title">
                <h4>Recently viewed <a href="javascript:void(0);">See All</a></h4>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/6.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/7.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/8.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/9.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>

              <div class="sidebar-single-item">
                <div class="sidebar-img">
                  <img src="assets/img/sidebar/10.png" alt="">
                </div>
                <div class="sidebar-content">
                  <a href="javascript:void(0);">I will create businessperfect logo design</a>
                </div>
              </div>
            </div>

            <!-- .Sidebar-box  END-->
          </div>

        </div>
      </div>
    </div>
    <?php require_once("includes/footer.php"); ?>
    <?php require_once("includes/footerJs.php"); ?>
  </body>
</html>