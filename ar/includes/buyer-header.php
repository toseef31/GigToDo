<?php
require_once("db.php");
require_once("extra_script.php");
require_once("change_currency.php");
if(!isset($_SESSION['error_array'])){ $error_array = array(); }else{ $error_array = $_SESSION['error_array']; }

if(isset($_SESSION['currency'])){
  $to = $_SESSION['currency'];
}

if(isset($_SESSION['seller_user_name'])){
  require_once("seller_levels.php");
  $seller_user_name = $_SESSION['seller_user_name'];
  $get_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));
  $row_seller = $get_seller->fetch();
  $seller_id = $row_seller->seller_id;
  $login_user_name = $row_seller->seller_user_name;
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

$page_url = substr("$full_url", 4);

$cur_amount = currencyConverter($to,1);
?>
<style>
  .ui-toolkit .text-body-larger{
    text-align: right;
  }
  @media(max-width: 768px){.total-user-count.count.c-notifications-header{left: -8px;top: -8px;}}
</style>
<!-- New Header Design -->
<header>
  <div class="header-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-lg-2">
          <div class="logo">
            <a href="<?php echo $site_url; ?>/ar"><img src="<?= $site_url; ?>/images/ar/<?= $site_arabic_logo; ?>" alt="" width="150"></a>
          </div>
        </div>
        <div class="col-6 d-block d-lg-none">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="message-inner position-relative">
              <a class="message-inner-toggle" href="javascript:void(0);"><img src="<?= $site_url; ?>/assets/img/message.png" alt=""><span class="total-user-count count c-notifications-header"></span></a>
            </div>
            <div class="menubar d-flex flex-row align-items-center">
              <div class="image">
                <?php if(!empty($seller_image)){ ?>
                <img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" alt="" class="img-fluid rounded-circle" height="32px" width="32px">
                <?php }else{ ?>
                <img src="<?= $site_url; ?>/assets/img/menu-left-logo.png"  class="img-fluid rounded-circle">
                <?php } ?>
              </div>
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
            <form action="" class="d-flex flex-row" id="gnav-search" method="POST">
              <input id="search-query" class="rounded" name="search_query"
                  placeholder="البحث عن الخدمات" value="<?php echo @$_SESSION["search_query"]; ?>"  autocomplete="off">
              <button name="search" type="submit" value="Search">
                البحث
                </button>
                <ul class="search-bar-panel d-none"></ul>
            </form>
            <?php
              if (isset($_POST['search'])) {
                  $search_query = $input->post('search_query');
                  $_SESSION['search_query'] = $search_query;
                  echo "<script>window.open('$site_url/ar/search.php','_self')</script>";
              }
            ?>
          </div>
        </div>
        <div class="col-12 col-lg-4 col-xl-6 d-none d-lg-block">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="menu-inner">
              <ul>
                <li><a href="<?= $site_url; ?>/ar/freelancers">فريلانسر</a></li>
                <li><a href="<?= $site_url; ?>/ar/buying_orders">الطلبات</a></li>
              </ul>
            </div>
            <?php if($language_switcher == 1){ ?>
            <div class="language-inner">
              <select name="" id="" onChange="window.location.href=this.value">
                <option value="<?= $site_url?>/<?php echo $page_url; ?>">EN</option>
                <option value="" selected="">AR</option>
              </select>
            </div>
            <?php } ?>
            <?php if($currency_switcher == 1){ ?>
            <div class="usd-inner">
              <select name="" id="curreny_convert" class="curreny_convert">
                <option value="EGP" <?php if($to == 'EGP'){ echo "selected";} ?> >EGP</option>
                <option value="USD" <?php if($to == 'USD'){ echo "selected";} ?>>USD</option>
              </select>
            </div>
            <?php } ?>
            <div class="message-inner">
              <a class="message-inner-toggle" href="javascript:void(0);"><img src="<?= $site_url; ?>/assets/img/message.png" alt=""><span class="total-user-count count c-notifications-header"></span></a>
            </div>
            <div class="menubar d-flex flex-row align-items-center">
              <div class="image">
                <?php if(!empty($seller_image)){ ?>
                <img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" alt="" class="img-fluid rounded-circle" width="40px" height="40px">
                <?php }else{ ?>
                <img src="<?= $site_url; ?>/assets/img/menu-left-logo.png"  class="img-fluid" width="40px" height="40px">
                <?php } ?>
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
      <!-- Message box -->
      <div class="message-box">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
              <div class="m-item">
                <i class="fal fa-bell"></i>
                صندوق الوارد
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
              <div class="m-item">
                <i class="far fa-comment-alt-dots"></i>
                إعلام
              </div>
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="mesagee-item-box notifications-dropdown">
              
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="mesagee-item-box  messages-dropdown">
              
            </div>
          </div>
        </div>
        <!-- <div class="notification-setting">
          <div class="row align-items-center">
            <div class="col-4 d-flex flex-row justify-content-end">
              <div class="noti-option-icon">
                <button><i class="fal fa-cog"></i></button>
                <button><i class="fal fa-volume-up"></i></button>
              </div>
            </div>
            <div class="col-8 d-flex flex-row justify-content-end">
              <a href="javascript:void(0);" class="see-all-noti">رؤية كل شيء في الإعلام ></a>
            </div>
          </div>
        </div> -->
      </div>
      <!-- Message box end -->
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
                  $arabic_title = $row_meta->arabic_title;
                  $arabic_desc = $row_meta->arabic_desc;
                ?>
                <li><a href="javascript:void(0);"><?= $arabic_title  ?></a></li>
                <?php } ?>
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
<div class="ofcanvas-menu">
  <div class="close-icon">
    <i class="fal fa-times"></i>
  </div>
  <div class="profile-inner">
    <?php if(!empty($seller_image)){ ?>
    <img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" alt="">
    <?php }else{ ?>
    <img src="<?= $site_url; ?>/assets/img/user2.png"  class="img-fluid rounded-circle mb-3">
    <?php } ?>
    <h4>أهلا بيك من تاني<span><?= ucfirst(strtolower($login_user_name)); ?></span></h4>
  </div>
  <div class="canvs-menu">
    <ul>
      <li><a href="<?php echo $site_url; ?>/ar/profile?user_name=<?php echo $_SESSION['seller_user_name']; ?>"> <img src="<?= $site_url; ?>/assets/img/icon/1.png" alt=""> الملف الشخصي</a></li>
      <li><a href="<?php echo $site_url; ?>/ar/settings?account_settings"> <img src="<?= $site_url; ?>/assets/img/icon/2.png" alt=""> ضبط </a></li>
      <li><a href="<?= $site_url ?>/ar/requests/post-request.php"> <img src="<?= $site_url; ?>/assets/img/icon/3.png" alt=""> انشر وظيفة</a></li>
      <li><a href="<?= $site_url; ?>/ar/requests/manage_requests"> <img src="<?= $site_url; ?>/assets/img/icon/4.png" alt=""> إدارة الوظائف </a></li>
      <li><a href="<?= $site_url; ?>/ar/buying_orders"> <img src="<?= $site_url; ?>/assets/img/icon/5.png" alt=""> أوامر</a></li>
      <li><a href="<?= $site_url; ?>/ar/purchases"> <img src="<?= $site_url; ?>/assets/img/icon/6.png" alt=""> المشتريات</a></li>
      <li><a href="<?= $site_url; ?>/ar/invite_friend"> <img src="<?= $site_url; ?>/assets/img/icon/7.png" alt=""> أدع صديقا</a></li>
      <li><a href="<?= $site_url; ?>/ar/conversations/inbox"> <img src="<?= $site_url; ?>/assets/img/icon/indox.png" alt=""> صندوق الوارد</a></li>
      <li><a href="<?= $site_url ?>/ar/how-it-works-buyer.php"> <img src="<?= $site_url; ?>/assets/img/icon/how-it-work.png" alt=""> كيف تعمل</a></li>
      <li><a href="<?= $site_url ?>/ar/logout.php"> <img src="<?= $site_url; ?>/assets/img/icon/logout.png" alt=""> الخروج</a></li>
    </ul>
  </div>
</div>
<!-- Close-overlay -->
<div class="overlay-bg"></div>
<!-- Offcanvas-menu END-->