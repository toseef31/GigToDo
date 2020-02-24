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

?>

<!-- New Header Design -->
<header>
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-md-3 d-flex flex-row">
          <div class="logo">
            <a class="home-logo" href="index.html"><img src="<?= $site_url; ?>/ar/assets/img/signin-logo.png" alt=""></a>
          </div>
        </div>
        <div class="col-6 col-md-9">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="menu-inner">
              <ul>
                <li><a href="javascript:void(0);">نشر طلب</a></li>
                <li><a href="how-it-works.php">كيف تعمل</a></li>
              </ul>
            </div>
            <div class="language-inner">
              <select name="" id="" onChange="window.location.href=this.value">
                <option value="<?= $site_url?>">EN</option>
                <option value="" selected="">AR</option>
              </select>
            </div>
            <div class="usd-inner">
              <select name="" id="">
                <option value="">USD</option>
                <option value="">EGP</option>
              </select>
            </div>
            <div class="Login-button d-none d-lg-flex">
              <a href="login.php">تسجيل الدخول</a>
              <a href="register.php">نضم الان</a>
            </div>
            <div class="menubar d-lg-none">
              <div class="d-flex flex-row align-items-center">
                <div class="image">
                  <img src="<?= $site_url; ?>/assets/img/menu-left-logo.png" alt="">
                </div>
                <div class="icon">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
        <a href="javascript:void(0);">نشر طلب</a>
      </li>
      <li>
        <a href="how-it-works.php">كيف تعمل</a>
      </li>
      <li class="d-flex flex-row">
        <div class="menu-action">
          <select name="" id="" onChange="window.location.href=this.value">
            <option value="<?= $site_url?>">EN</option>
            <option value="" selected="">AR</option>
          </select>
        </div>
        <div class="menu-action">
          <select name="" id="">
            <option value="">USD</option>
            <option value="">EGP</option>
          </select>
        </div>
      </li>
      <li class="mb-20">
        <a class="button login-button" href="login.php">
          الدخول
        </a>
      </li>
      <li>
        <a class="button join-button" href="register.php">
          انضم دلوقتي
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- Close-overlay -->
<div class="overlay-bg"></div>
<!-- Offcanvas-menu END-->