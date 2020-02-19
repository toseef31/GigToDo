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

<!-- Header -->
<header>
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-lg-2">
          <div class="logo">
            <a href="index.html"><img src="assets/img/logo.svg" alt=""></a>
          </div>
        </div>
        <div class="col-6 d-block d-lg-none">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="message-inner">
              <a class="message-inner-toggle" href="javascript:void(0);"><img src="assets/img/message.png" alt=""></a>
            </div>
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
        <div class="col-12 col-lg-6 col-xl-4">
          <div class="header-search-box">
            <form action="" class="d-flex flex-row" method="POST">
              <input type="text" placeholder="Find Services">
              <button type="submit">Search</button>
            </form>
          </div>
        </div>
        <div class="col-12 col-lg-4 col-xl-6 d-none d-lg-block">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="menu-inner">
              <ul>
                <li><a href="javascript:void(0);">Become a Seller</a></li>
                <li><a href="javascript:void(0);">Orders</a></li>
              </ul>
            </div>
            <div class="language-inner">
              <select name="" id="" onChange="window.location.href=this.value">
                <option value="" selected="">EN</option>
                <option value="<?= $site_url?>/Arabic/">AR</option>
              </select>
            </div>
            <div class="usd-inner">
              <select name="" id="">
                <option value="">USD</option>
                <option value="">EGP</option>
              </select>
            </div>
            <div class="message-inner">
              <a class="message-inner-toggle" href="javascript:void(0);"><img src="assets/img/message.png" alt=""></a>
            </div>
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
      </div>
      <!-- Message Box -->
      <div class="message-box">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
              <div class="m-item">
                <i class="fal fa-bell"></i>
                Notification
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
              <div class="m-item">
                <i class="far fa-comment-alt-dots"></i>
                Inbox
              </div>
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="mesagee-item-box">
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="mesagee-item-box">
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
              <div class="mesagee-single-item">
                <div class="notifiction-user-img">
                  <img src="assets/img/user3.png" alt="">
                </div>
                <h5><span>snazzydegreat delivered</span> your order</h5>
                <p>1 month ago . <span>Branding Services</span> <i class="fal fa-angle-right"></i></p>
                <div class="notifiction-right">
                  <img src="assets/img/message-img.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="notification-setting">
          <div class="row align-items-center">
            <div class="col-6">
              <div class="noti-option-icon">
                <button><i class="fal fa-cog"></i></button>
                <button><i class="fal fa-volume-up"></i></button>
              </div>
            </div>
            <div class="col-6 text-right">
              <a href="javascript:void(0);" class="see-all-noti">See All In Notification ></a>
            </div>
          </div>
        </div>
      </div>
      <!-- Message box end -->
    </div>
  </div>
  <!-- Header-menu -->
  <div class="header-menu">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <div class="mainmenu">
            <nav>
              <ul>
                <?php
                  $get_categories = $db->query("select * from categories where cat_featured='yes' ".($lang_dir == "right" ? 'order by 1 DESC LIMIT 6,6':' LIMIT 0,6')."");
                  while($row_categories = $get_categories->fetch()){
                  $cat_id = $row_categories->cat_id;
                  $cat_image = $row_categories->cat_image;
                  $cat_icon = $row_categories->cat_icon;
                  $cat_url = $row_categories->cat_url;
                  $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
                  $row_meta = $get_meta->fetch();
                  $cat_title = $row_meta->cat_title;
                  $cat_desc = $row_meta->cat_desc;
                ?>
                <li><a href="javascript:void(0);"><?= $cat_title ?></a></li>
                <?php } ?>
                <!-- <li><a href="javascript:void(0);">Digital Marketing</a></li>
                <li><a href="javascript:void(0);">Writing & Translation</a></li>
                <li><a href="javascript:void(0);">Programming & Tech</a></li>
                <li><a href="javascript:void(0);">Music & Audio</a></li>
                <li><a href="javascript:void(0);">Video & Animation</a></li> -->
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Header-menu END-->
</header>
<!-- Header END-->
<!-- Offcanvas-menu -->
<div class="ofcanvas-menu">
  <div class="close-icon">
    <i class="fal fa-times"></i>
  </div>
  <div class="profile-inner">
    <img src="assets/img/user2.png" alt="">
    <h4>Welcome back, <span>Morad11214</span></h4>
  </div>
  <div class="canvs-menu">
    <ul>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/1.png" alt=""> Profile</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/2.png" alt=""> Setting </a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/3.png" alt=""> Post a Job</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/4.png" alt=""> Manage Requests</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/5.png" alt=""> Orders</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/6.png" alt=""> Purchases</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/7.png" alt=""> Invite a Friend</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/indox.png" alt=""> Inbox</a></li>
      <li><a href="how-it-works-buyer.php"> <img src="assets/img/icon/how-it-work.png" alt=""> How it works</a></li>
      <li><a href="javascript:void(0);"> <img src="assets/img/icon/logout.png" alt=""> Logout</a></li>
    </ul>
  </div>
</div>
<!-- Close-overlay -->
<div class="overlay-bg"></div>
<!-- Offcanvas-menu END-->