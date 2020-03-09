<?php
require_once("db.php");
require_once("extra_script.php");
if(!isset($_SESSION['error_array'])){ $error_array = array(); }else{ $error_array = $_SESSION['error_array']; }

if(isset($_SESSION['seller_user_name'])){
  require_once("seller_levels.php");
  $seller_user_name = $_SESSION['seller_user_name'];
  $get_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));
  $row_seller = $get_seller->fetch();
  $seller_id = $row_seller->seller_id;
  $seller_email = $row_seller->seller_email;
  $seller_verification = $row_seller->seller_verification;
  $seller_image = $row_seller->seller_image;
  $count_cart = $db->count("cart",array("seller_id" => $seller_id));
  $select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $seller_id));
  $count_seller_accounts = $select_seller_accounts->rowCount();
  if ($count_seller_accounts == 0) {
    $db->insert("seller_accounts",array("seller_id" => $seller_id));
  }
  $row_seller_accounts = $select_seller_accounts->fetch();
  $current_balance = $row_seller_accounts->current_balance;
  
  $get_general_settings = $db->select("general_settings");   
  $row_general_settings = $get_general_settings->fetch();
  $enable_referrals = $row_general_settings->enable_referrals;
  $count_active_proposals = $db->count("proposals",array("proposal_seller_id"=>$seller_id,"proposal_status"=>'active'));
}

function get_real_user_ip(){
  //This is to check ip from shared internet network
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

$ip = get_real_user_ip();

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

<!-- New Header Design -->
<!-- Header -->
<header>
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-lg-2">
          <div class="logo">
            <a href="index.html"><img src="<?= $site_url; ?>/images/<?= $site_logo_image; ?>" alt="" width="150"></a>
          </div>
        </div>
        <div class="col-6 d-block d-lg-none">
          <div class="header-right d-flex flex-row align-items-center justify-content-end">
            <div class="menubar d-flex flex-row align-items-center">
              <div class="image"><img src="assets/img/menu-left-logo.png" alt=""></div>
              <div class="icon">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-5 col-xl-4">
          <div class="header-search-box">
            <form action="" class="d-flex flex-row" id="gnav-search" method="POST">
              <input id="search-query" class="rounded" name="search_query"
                  placeholder="<?php echo $lang['search']['placeholder']; ?>" value="<?php echo @$_SESSION["search_query"]; ?>"  autocomplete="off">
              <button name="search" type="submit" value="Search">
                <?php echo $lang['search']['button']; ?>
                </button>
                <ul class="search-bar-panel d-none"></ul>
            </form>
            <?php
              if (isset($_POST['search'])) {
                  $search_query = $input->post('search_query');
                  $_SESSION['search_query'] = $search_query;
                  echo "<script>window.open('$site_url/search.php','_self')</script>";
              }
            ?>
          </div>
        </div>
        <div class="col-12 col-lg-5 col-xl-6 d-none d-lg-block">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="menu-inner">
              <ul>
                <li><a href="<?= $site_url ?>/requests/post-request.php">Post a Request</a></li>
                <li><a href="<?= $site_url ?>/how-it-works.php">How it Works</a></li>
              </ul>
            </div>
            <?php if($language_switcher == 1){ ?>
            <div class="language-inner">
              <select name="" id="" onChange="window.location.href=this.value">
                <option value="" selected="">EN</option>
                <option value="<?= $site_url?>/ar/<?php echo $page_url; ?>">AR</option>
              </select>
            </div>
            <?php } ?>
            <div class="usd-inner">
              <select name="" id="">
                <option value="">USD</option>
                <option value="">EGP</option>
              </select>
            </div>
            <div class="Login-button">
              <a href="<?= $site_url; ?>/login.php">Login</a>
              <a href="<?= $site_url; ?>/register.php">Join Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Header-menu -->
  <div class="header-menu">
    <?php include("comp/categories_nav.php"); ?>
    <!-- <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <div class="mainmenu">
            <nav>
              <ul>
                <li><a href="javascript:void(0);">Graphics & Design</a></li>
                <li><a href="javascript:void(0);">Digital Marketing</a></li>
                <li><a href="javascript:void(0);">Writing & Translation</a></li>
                <li><a href="javascript:void(0);">Programming & Tech</a></li>
                <li><a href="javascript:void(0);">Music & Audio</a></li>
                <li><a href="javascript:void(0);">Video & Animation</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div> -->
  </div>
  <!-- Header-menu END-->
</header>
<!-- Header END-->
<!-- Offcanvas-menu -->
<div class="ofcanvas-menu pre-login">
  <div class="close-icon">
    <i class="fal fa-times"></i>
  </div>
  <div class="canvs-menu">
    <ul class="d-flex flex-column">
      <li>
        <a href="javascript:void(0);">Post A Request</a>
      </li>
      <li>
        <a href="<?= $site_url ?>/how-it-works.php">How it Works</a>
      </li>
      <li class="d-flex flex-row">
        <?php if($language_switcher == 1){ ?>
        <div class="menu-action">
          <select name="" id="" onChange="window.location.href=this.value">
            <option value="" selected="">EN</option>
            <option value="<?= $site_url?>/ar/<?php echo $page_url; ?>">AR</option>
          </select>
        </div>
        <?php } ?>
        <div class="menu-action">
          <select name="" id="">
            <option value="">USD</option>
            <option value="">EGP</option>
          </select>
        </div>
      </li>
      <li class="mb-20">
        <a class="button login-button" href="<?= $site_url ?>/login.php">Login</a>
      </li>
      <li>
        <a class="button join-button" href="<?= $site_url ?>/register.php">Join Now</a>
      </li>
    </ul>
  </div>
</div>
<!-- Close-overlay -->
<div class="overlay-bg"></div>
<!-- Offcanvas-menu END-->