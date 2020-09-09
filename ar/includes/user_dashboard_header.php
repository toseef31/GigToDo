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
  $seller_email = $row_seller->seller_email;
  $seller_verification = $row_seller->seller_verification;
  $seller_image = $row_seller->seller_image;
  $count_cart = $db->count("cart",array("seller_id" => $seller_id));
  $select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $seller_id));
  $row_seller_accounts = $select_seller_accounts->fetch();
  $current_balance = $row_seller_accounts->current_balance;
  $get_general_settings = $db->select("general_settings");   
  $row_general_settings = $get_general_settings->fetch();
  $enable_referrals = $row_general_settings->enable_referrals;
  $count_active_proposals = $db->count("proposals",array("proposal_seller_id"=>$seller_id,"proposal_status"=>'active'));
  }
  function get_real_user_ip(){
  	/// This is to check ip from shared internet network
  	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
  	$ip = $_SERVER['HTTP_CLIENT_IP'];
  	}
  	/// This is to check ip if it is passing from proxy network
  	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
  	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  	}
  	else{
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
<style>.activate-email-class #send-email{background-color: #ff0707; border-color: #ff0707;}
.total-user-count.count.c-notifications-header{left: -8px;top: -7px;}</style>
<link href="<?php echo $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
<link href="<?php echo $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">

  <!-- Header -->
  <header>
    <div class="header-top dashboard-page">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6 col-lg-4 col-md-3">
            <div class="logo <?php if(isset($_SESSION["seller_user_name"])){echo"loggedInLogo";} ?>">
              <a href="<?php echo $site_url; ?>/ar/dashboard">
                <img src="<?= $site_url; ?>/images/ar/<?= $arabic_sticky_logo; ?>" alt="">
              </a>
            </div>
          </div>
          <div class="col-6 col-lg-8 col-md-9">
            <div class="header-right d-flex align-items-center justify-content-end">
              <div class="menu-inner">
                <ul>
                  <li><a href="<?= $site_url; ?>/ar/dashboard">لوحة التحكم</a></li>
                  <li><a href="<?= $site_url; ?>/ar/proposals/view_proposals">الخدمات</a></li>
                  <li><a href="<?= $site_url; ?>/ar/requests/buyer_requests">المشرايع</a></li>
                </ul>
              </div>
              <?php if($language_switcher == 1){ ?>
              <div class="language-inner">
                <select name="" id="" onChange="window.location.href=this.value">
                  <option value="<?= $site_url?>/<?php echo $page_url; ?>">EN</option>
                  <option value="<?= $site_url?>/ar/<?php echo $page_url; ?>" selected="">AR</option>
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
              <div class="message-inner position-relative">
                <a class="message-inner-toggle" href="javascript:void(0);"><img src="<?php echo $site_url; ?>/assets/img/message-2.png" alt="">
                  <span class="total-user-count count c-notifications-header"></span></a>
              </div>
              <div class="menubar d-flex flex-row align-items-center">
                <div class="image">
                  <?php if(!empty($seller_image)){ ?>
                  <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="32" height="32" class="rounded-circle">
                  <?php }else{ ?>
                  <img src="<?php echo $site_url; ?>/assets/img/menu-left-logo-2.png" width="32" height="32">
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
        <div class="message-box" style="box-shadow: none;">
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
              <div class="mesagee-item-box messages-dropdown">
                
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
  </header>
  <!-- Header END-->
  <!-- Offcanvas-menu -->
  <div class="ofcanvas-menu">
    <div class="close-icon">
      <i class="fal fa-times"></i>
    </div>
    <div class="profile-inner">
      <?php if(!empty($seller_image)){ ?>
      <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="32" height="32" class="rounded-circle">
      <?php }else{ ?>
      <img src="assets/img/user2.png" alt="">
      <?php } ?>
      <h4>أهلا بيك من تاني<span><?php echo $_SESSION['seller_user_name']; ?></span></h4>
    </div>
    <div class="canvs-menu">
      <ul>
        <li>
          <a href="<?php echo $site_url; ?>/ar/<?php echo $_SESSION['seller_user_name']; ?>"> <img src="assets/img/icon/1.png" alt="">
            الملف الشخصي
          </a>
        </li>
        <li>
          <a href="<?= $site_url ?>/ar/settings"> <img src="assets/img/icon/2.png" alt="">
            الإعدادات
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/dashboard"> <img src="assets/img/icon/12.png" alt="">
            لوحة التحكم
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/proposals/view_proposals"> <img src="assets/img/icon/3.png" alt="">
            الخدمات
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/proposals/create_proposal"
                  onclick="dataLayer.push({
                    'event': 'Pageview'});"> <img src="assets/img/icon/13.png" alt="">
            انشر خدمة
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/requests/buyer_requests"> <img src="assets/img/icon/14.png" alt="">
            المشرايع
          </a>
        </li>
        <li>
          <a href="<?= $site_url ?>/ar/selling_orders"> <img src="assets/img/icon/5.png" alt="">
            الطلبات
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/revenue"> <img src="assets/img/icon/15.png" alt="">
            الرصيد
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/portfolio"> <img src="assets/img/icon/16.png" alt="">
            محفظة ملفّاتك
          </a>
        </li>
        <!-- <li><a href="javascript:void(0);"> <img src="assets/img/icon/6.png" alt=""> Purchases</a></li> -->
        <li>
          <a href="<?= $site_url; ?>/ar/invite_friend"> <img src="assets/img/icon/7.png" alt="">
            دعوة صديق
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/conversations/inbox"> <img src="assets/img/icon/indox.png" alt="">
           الرسائل
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/how-it-works-seller.php"> <img src="assets/img/icon/how-it-work.png" alt="">
            ازاي بيشتغل
          </a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/ar/logout.php"> <img src="assets/img/icon/logout.png" alt="">
            الخروج
          </a>
        </li>
      </ul>
    </div>
  </div>
  <!-- Close-overlay -->
  <div class="overlay-bg"></div>
  <!-- Offcanvas-menu END-->


  <div class="clearfix"></div>
  <?php //require_once("comp/user_nav.php"); ?>
  <div class="clearfix"></div>
  <?php //include("comp/mobile_menu.php"); ?>

  <?php if(isset($_GET['not_available'])) { ?>
  <div class="alert alert-danger text-center mb-0 h6">
  <!-- Alert to show wrong url or unregistered account start -->
  <i class="fa fa-exclamation-circle"></i> The page or user you searched for is no longer available.
  </div>
  <!-- Alert to show wrong url or unregistered account end -->
  <?php } ?>
  <?php if(isset($_SESSION['seller_user_name'])) { 
  if($seller_verification != "ok"){
  ?>
  <div class="alert alert-warning clearfix activate-email-class mb-0">
  <div class="float-left mt-2">
  <i style="font-size: 125%;" class="fa fa-exclamation-circle"></i> 
  <?php 
  $message = $lang['popup']['email_confirm']['text'];
  $message = str_replace('{seller_email}', $seller_email, $message);
  $message = str_replace('{link}', "$site_url/customer_support", $message);
  echo $message;
  ?>
  </div>
  <div class="float-right">
  <button id="send-email" class="btn btn-success float-right text-white">إعادة إرسال البريد الإلكتروني</button>
  </div>
  </div>
  <script>
  $(document).ready(function(){
  $("#send-email").click(function(){
  $.ajax({
  method: "POST",
  url: "<?php echo $site_url; ?>/includes/send_email",
  success:function(){
  $("#send-email").html("Resend Email");
  swal({
    type: 'success',
  text: 'Confirmation email sent. Please check your email.',
  });
  }
  });
  });
  });
  </script>
  <?php  } } ?>