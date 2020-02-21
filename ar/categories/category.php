<?php
  session_start();
  require_once("../includes/db.php");
  require_once("../functions/functions.php");
  if(isset($_GET['cat_url'])){
    unset($_SESSION['cat_child_id']);
    $get_cat = $db->select("categories",array('cat_url' => $input->get('cat_url')));
    $cat_id = $get_cat->fetch()->cat_id;
    $_SESSION['cat_id']=$cat_id;
  }
  if(isset($_GET['cat_child_url'])){
    unset($_SESSION['cat_id']);
    $get_cat = $db->select("categories",array('cat_url' => $input->get('cat_url')));
    $cat_id = $get_cat->fetch()->cat_id;
    $get_child = $db->select("categories_children",array('child_parent_id'=>$cat_id,'child_url'=>$input->get('cat_child_url')));
    $_SESSION['cat_child_id']= $get_child->fetch()->child_id;
  }
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
<head>
  <?php
    if(isset($_SESSION['cat_id'])){
    $cat_id = $_SESSION['cat_id'];
    $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
    $row_meta = $get_meta->fetch();
    $cat_title = $row_meta->cat_title;
    $cat_desc = $row_meta->cat_desc;
    ?>
  <title><?php echo $site_name; ?> - <?php echo $cat_title; ?>  </title>
  <meta name="description" content="<?php echo $cat_desc; ?>" >
  <?php } ?>
  <?php
    if(isset($_SESSION['cat_child_id'])){
    $cat_child_id = $_SESSION['cat_child_id'];
    $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
    $row_meta = $get_meta->fetch();
    $child_title = $row_meta->child_title;
    $child_desc = $row_meta->child_desc;
    ?>
  <title><?php echo $site_name; ?> - <?php echo $child_title; ?></title>
  <meta name="description" content="<?php echo $child_desc; ?>" >
  <?php } ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="<?php echo $site_author; ?>">
  
  <!-- ==============Google Fonts============= -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
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
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="<?= $site_url; ?>/styles/bootstrap.css" rel="stylesheet"> -->
  <!-- <link href="<?= $site_url; ?>/styles/custom.css" rel="stylesheet"> -->
  <!-- Custom css code from modified in admin panel --->
  <link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/styles/categories_nav_styles.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/styles/sweat_alert.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="<?= $site_url; ?>/js/ie.js"></script>
  <script type="text/javascript" src="<?= $site_url; ?>/js/sweat_alert.js"></script>
  <script type="text/javascript" src="<?= $site_url; ?>/js/jquery.min.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="<?= $site_url; ?>/images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.swal2-popup .swal2-select{display: none;}.cat-nav .top-nav-item{margin-top: 0;}.header-menu .mainmenu ul li a{font-size: 15px;}.cat-nav .top-nav-item.active {border-bottom: 3px solid #ff0000;}.ui-toolkit h1, .ui-toolkit .h1, .ui-toolkit h2, .ui-toolkit .h2, .ui-toolkit h3, .ui-toolkit .h3 {font-weight: 600 !important;}</style>
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
    if(isset($_SESSION['seller_user_name'])){
    require_once("../includes/buyer-header.php");
   }else{
    require_once("../includes/header-top.php");
   }
  ?>

<!-- all-gigs-area Start-->

  <div class="all-gigs-banner pt-30 pb-20">
    <div class="container">
      <div class="gigs-banner align-items-center d-sm-flex justify-content-between">
        <?php
          if(isset($_SESSION['cat_id'])){
          $cat_id = $_SESSION['cat_id'];
          $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $cat_title = $row_meta->cat_title;
          $cat_desc = $row_meta->cat_desc;
          ?>
          <div class="banner-title mt-20">
            <h3 class="title"><?php echo $cat_title; ?></h3>
          </div>
          <div class="banner-breadcrumb mt-20">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="javascript:void(0);">eMongez</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);"><?= $cat_title; ?></a></li>
            </ol>
          </div>
        <?php } ?>
        <?php
          if(isset($_SESSION['cat_child_id'])){
          $cat_child_id = $_SESSION['cat_child_id'];
          $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $child_title = $row_meta->child_title;
          $child_desc = $row_meta->child_desc;
        ?>
        <div class="banner-title mt-20">
          <h3 class="title"><?php echo $child_title; ?></h3>
        </div>
        <div class="banner-breadcrumb mt-20">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">eMongez</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);"><?= $child_title; ?></a></li>
          </ol>
        </div>
        <?php } ?>
        
        
      </div>
    </div>
  </div>

  <!-- all-gigs-area end -->
<!-- all-gigs-area Start-->

  <div class="all-gigs-area pb-60">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
          <button class="filter-results" type="button" role="button">
            <img src="assets/img/gigs/filter.png" alt="" />Filter by
          </button>
          <div class="gigs-sidebar">
            <h2 class="results-title">
              <a class="backtomain" href="javascript:void(0);">
                <i class="fal fa-angle-left"></i>
              </a>
              <span>Refine Results</span>
              <a class="clearfilter" href="javascript:void(0);">Clear All</a>
            </h2>
            <div class="gigs-sidebar-filter">
              <div class="gigs-sidebar-title">
                <h4 class="title"><img src="assets/img/gigs/filter.png" alt="">Filter by</h4>
              </div>
              <div class="gigs-filter-content ">
                <div class="single-filter clearfix">
                  <select>
                    <option value="0">Graphic & Design</option>
                    <option value="1">Graphic & Design 01</option>
                    <option value="2">Graphic & Design 02</option>
                    <option value="3">Graphic & Design 03</option>
                    <option value="4">Graphic & Design 04</option>
                  </select>
                </div>
                <div class="single-filter clearfix">
                  <select>
                    <option value="0">Logo Design</option>
                    <option value="1">Logo Design 01</option>
                    <option value="2">Logo Design 02</option>
                    <option value="3">Logo Design 03</option>
                    <option value="4">Logo Design 04</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="gigs-sidebar-price">
              <div class="gigs-sidebar-title">
                <h4 class="title"><img src="assets/img/gigs/price.png" alt="">Price</h4>
              </div>
              <div class="gigs-price-content ">
                <input id="price" type="text" name="" value="" class="irs-hidden-input" tabindex="-1" readonly="">
              </div>
            </div>
            
            <div class="gigs-sidebar-status">
              <div class="gigs-sidebar-title">
                <h4 class="title"><img src="assets/img/gigs/status.png" alt="">Status</h4>
              </div>
              <div class="gigs-status-content d-flex justify-content-between align-items-center">
                <div class="status-text pt-20">
                  <p class="text">Online</p>
                </div>
                <div class="status-switch pt-20">
                  <div class="md_switch">
                    <input class="switch" id="switch" type="checkbox">
                    <label for="switch"></label>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="gigs-sidebar-titme">
              <div class="gigs-sidebar-title">
                <h4 class="title"><img src="assets/img/gigs/time.png" alt="">Delivery Time</h4>
              </div>
              <div class="gigs-titme-content pt-20">
                <ul class="radio_titme radio_style2">
                  <li>
                    <input type="radio" checked="" name="radio1" id="radio1">
                    <label for="radio1"><span></span>Up To 24 Hours (Urgent)</label>
                  </li>
                  <li>
                    <input type="radio" name="radio1" id="radio2">
                    <label for="radio2"><span></span>Up To 3 Days</label>
                  </li>
                  <li>
                    <input type="radio" name="radio1" id="radio3">
                    <label for="radio3"><span></span>Up To 1 Week</label>
                  </li>
                  <li>
                    <input type="radio" name="radio1" id="radio4">
                    <label for="radio4"><span></span>Any</label>
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="gigs-sidebar-rating">
              <div class="gigs-sidebar-title">
                <h4 class="title"><img src="assets/img/gigs/star.png" alt="">Rating</h4>
              </div>
              <div class="gigs-rating-content">
                <div class="single-rating clearfix">
                  <select>
                    <option value="0">Logo Design</option>
                    <option value="1">Logo Design 01</option>
                    <option value="2">Logo Design 02</option>
                    <option value="3">Logo Design 03</option>
                    <option value="4">Logo Design 04</option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="gigs-sidebar-search">
              <div class="gigs-sidebar-title">
                <h4 class="title"><img src="assets/img/gigs/keyword.png" alt="">Keywords</h4>
              </div>
              <div class="gigs-search-content mt-20">
                <input type="search" placeholder="Search by Keywords">
              </div>
            </div>
            
            <div class="gigs-sidebar-button">
              <div class="gigs-button-content">
                <button>Update Search</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-9" id="category_proposals">
          <?php get_category_proposals(); ?>
          <div class="all-gigs-small hide">
            <div class="row">
              <div class="col-12">
                <div class="small-gigs-item d-flex flex-column">
                  <?php get_category_proposals(); ?>
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                        <img class="img-fluid d-block" src="<?= $site_url;?>assets/img/emongez_cube.png" />
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
                      <div class="icon d-flex flex-column justify-content-between align-items-end">
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
          <div class="all-gigs hide" style="display: none;">
            <div class="row">
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-1.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-1.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        c
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-2.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-2.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-3.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-3.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-4.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-4.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-5.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-1.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-6.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-2.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-7.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-3.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-8.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-4.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-9.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-1.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-10.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-2.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-11.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-3.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-12.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-4.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-13.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-1.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-14.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-2.jpg" alt="">
                        <span class="active"></span>
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-sm-6">
                <div class="single-gigs mt-30">
                  <div class="gigs-image verified-rebon">
                    <img src="assets/img/gigs/gigd-15.png" alt="Gigs Image">
                  </div>
                  <div class="gigs-content">
                    <div class="gigs-author d-flex align-items-center">
                      <div class="author-image">
                        <img src="assets/img/gigs/author-3.jpg" alt="">
                      </div>
                      <div class="author-name media-body">
                        <h4 class="name"><a href="javascript:void(0);">bossdesigners</a></h4>
                      </div>
                    </div>
                    <h4 class="gigs-title"><a href="javascript:void(0);">I will design the best logo</a></h4>
                    <ul class="gigs-rating d-flex">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                      <span>(25)</span>
                    </ul>
                  </div>
                  <div class="gigs-meta d-flex justify-content-between align-items-center">
                    <div class="meta-left">
                      <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                    </div>
                    <div class="meta-right">
                      <span>$25</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="gigs-more text-center mt-50">
                <a href="javascript:void(0);">Load more gigs</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- all-gigs-area end -->
<div class="container-fluid mt-5" style="display: none;">
  <!-- Container start -->
  <div class="row">
    <div class="col-md-12">
      <center>
        <?php
          if(isset($_SESSION['cat_id'])){
          $cat_id = $_SESSION['cat_id'];
          $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $cat_title = $row_meta->cat_title;
          $cat_desc = $row_meta->cat_desc;
          ?>
        <h1> <?php echo $cat_title; ?> </h1>
        <p class="lead"><?php echo $cat_desc; ?></p>
        <?php } ?>
        <?php
          if(isset($_SESSION['cat_child_id'])){
          $cat_child_id = $_SESSION['cat_child_id'];
          $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $child_title = $row_meta->child_title;
          $child_desc = $row_meta->child_desc;
          ?>
        <h1> <?php echo $child_title; ?> </h1>
        <p class="lead"><?php echo $child_desc; ?></p>
        <?php } ?>
      </center>
      <hr class="mt-5 pt-2">
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-3 col-md-4 col-sm-12 <?=($lang_dir == "right" ? 'order-2 order-sm-1':'')?>">
      <?php require_once("../includes/category_sidebar.php"); ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 <?=($lang_dir == "right" ? 'order-1 order-sm-2':'')?>">
      <div class="row flex-wrap <?=($lang_dir == "right" ? 'justify-content':'')?>" id="category_proposals">
        <?php get_category_proposals(); ?>
      </div>
      <div id="wait"></div>
      <br>
      <div class="row justify-content-center mb-5 mt-0">
        <!-- row justify-content-center Starts -->
        <nav>
          <!-- nav Starts -->
          <ul class="pagination" id="category_pagination">
            <?php get_category_pagination(); ?>
          </ul>
        </nav>
        <!-- nav Ends -->
      </div>
    </div>
  </div>
</div>
<!-- Container ends -->
<div class="append-modal"></div>
<?php require_once("../includes/footer.php"); ?>
<script>
  function get_category_proposals(){
  
  var sPath = ''; 
  
  var aInputs = $('li').find('.get_online_sellers');
  
  var aKeys   = Array();
  
  var aValues = Array();
  
  iKey = 0;
  
  $.each(aInputs,function(key,oInput){
  
  if(oInput.checked){
  	
  aKeys[iKey] =  oInput.value
  
  };
  
  iKey++;
  
  });
  
  if(aKeys.length>0){
  	
  var sPath = '';
  	
  for(var i = 0; i < aKeys.length; i++){
  
  sPath = sPath + 'online_sellers[]=' + aKeys[i]+'&';
  
  }
  
  }
  
  
  var cat_url = "<?php echo $input->get('cat_url'); ?>";
  
  sPath = sPath + 'cat_url=' + cat_url +'&';
  
  <?php if(isset($_REQUEST['cat_child_url'])){ ?>
  
  var cat_child_url = "<?php echo $input->get('cat_child_url'); ?>";
  
  sPath = sPath+ 'cat_child_url='+ cat_child_url +'&';
  
  var url_plus = "../";
  
  <?php }else{ ?>
  
  var url_plus = "";
  
  <?php } ?>
  
  
  var aInputs = Array();
  
  var aInputs = $('li').find('.get_delivery_time');
  
  var aKeys   = Array();
  
  var aValues = Array();
  
  iKey = 0;
  
  $.each(aInputs,function(key,oInput){
  
  if(oInput.checked){
  	
  aKeys[iKey] =  oInput.value
  
  };
  
  iKey++;
  
  });
  
  if(aKeys.length>0){
  
  for(var i = 0; i < aKeys.length; i++){
  	
  sPath = sPath + 'delivery_time[]=' + aKeys[i]+'&';
  
  }
  
  }
  
  var aInputs = Array();
  
  var aInputs = $('li').find('.get_seller_level');
  
  var aKeys   = Array();
  
  var aValues = Array();
  
  iKey = 0;
  
  $.each(aInputs,function(key,oInput){
  
  if(oInput.checked){
  	
  aKeys[iKey] =  oInput.value
  
  };
  
  iKey++;
  
  });
  
  if(aKeys.length>0){
  	
  for(var i = 0; i < aKeys.length; i++){
  	
  sPath = sPath + 'seller_level[]=' + aKeys[i]+'&';
  
  }
  
  }
  
  var aInputs = Array();
  
  var aInputs = $('li').find('.get_seller_language');
  
  var aKeys   = Array();
  
  var aValues = Array();
  
  iKey = 0;
  
  $.each(aInputs,function(key,oInput){
  
  if(oInput.checked){
  	
  aKeys[iKey] =  oInput.value
  
  };
  
  iKey++;
  
  });
  
  if(aKeys.length>0){
  	
  for(var i = 0; i < aKeys.length; i++){
  
  sPath = sPath + 'seller_language[]=' + aKeys[i]+'&';
  
  }
  
  }		
  
  $('#wait').addClass("loader");		
  
  $.ajax({  
  
  url: url_plus + "../category_load",  
  method:"POST",  
  data: sPath+'zAction=get_category_proposals',  
  success:function(data){
  
  $('#category_proposals').html('');  
  
  $('#category_proposals').html(data);
  
  $('#wait').removeClass("loader");
  
  }  
  
  });							  
  
  $.ajax({  
  
  url: url_plus + "../category_load",  
  method:"POST",  
  data: sPath+'zAction=get_category_pagination',  
  success:function(data){  
  
  $('#category_pagination').html('');  
  
  $('#category_pagination').html(data); 
  
  }  
  
  });
  
  }
  
  $('.get_online_sellers').click(function(){ 
  
  get_category_proposals(); 
  
  });
  
  $('.get_delivery_time').click(function(){ 
  
  get_category_proposals(); 
  
  }); 
  
  $('.get_seller_level').click(function(){ 
  
  get_category_proposals(); 
  
  }); 
  
  $('.get_seller_language').click(function(){ 
  
  get_category_proposals(); 
  
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".get_cat_id").click(function(){
      if($(".get_cat_id:checked").length > 0 ) {
        $(".clear_cat_id").show();
      }
      else{
        $(".clear_cat_id").hide();
      }
    });
    $(".get_delivery_time").click(function(){
      if($(".get_delivery_time:checked").length > 0 ) {
        $(".clear_delivery_time").show();
      }
      else{
        $(".clear_delivery_time").hide();
      }
    });
    $(".get_seller_level").click(function(){
      if($(".get_seller_level:checked").length > 0 ) {
        $(".clear_seller_level").show();
      }
      else{
        $(".clear_seller_level").hide();
      }
    });
    $(".get_seller_language").click(function(){
      if($(".get_seller_language:checked").length > 0 ) {
        $(".clear_seller_language").show();
      }
      else{
        $(".clear_seller_language").hide();
      }
    });
    $(".clear_cat_id").click(function(){
      $(".clear_cat_id").hide();
    });
    $(".clear_delivery_time").click(function(){
      $(".clear_delivery_time").hide();
    });
    $(".clear_seller_level").click(function(){
      $(".clear_seller_level").hide();
    });
    $(".clear_seller_language").click(function(){
      $(".clear_seller_language").hide();
    });
  });
  function clearCat(){
    $('.get_cat_id').prop('checked',false);
    get_category_proposals();
  }
  function clearDelivery(){
    $('.get_delivery_time').prop('checked',false);
    get_category_proposals();
  }
  function clearLevel(){
    $('.get_seller_level').prop('checked',false);
    get_category_proposals();
  }
  function clearLanguage(){
    $('.get_seller_language').prop('checked',false);
    get_category_proposals();
  }
</script>
</body>
</html>