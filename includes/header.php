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

$cur_amount = currencyConverter($to,1);

?>
<!-- <link href="<?= $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
<link href="<?= $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">
<div id="gnav-header" class="gnav-header global-nav clear gnav-3">
  <header id="gnav-header-inner" class="gnav-header-inner clear apply-nav-height col-group has-svg-icons body-max-width">
    <div class="col-xs-12">
      <div id="gigtodo-logo" class="apply-nav-height gigtodo-logo-svg gigtodo-logo-svg-logged-in <?php if(isset($_SESSION["seller_user_name"])){echo"loggedInLogo";} ?>">
        <a href="<?= $site_url; ?>">
        <?php if($site_logo_type == "image"){ ?>
        <img class="desktop" src="<?= $site_url; ?>/images/<?= $site_logo_image; ?>" width="150">
        <?php }else{ ?>
        <?= $site_logo_text; ?>
        <?php } ?>
        </a>
      </div>
      <button id="mobilemenu" class="unstyled-button mobile-catnav-trigger apply-nav-height icon-b-1 tablet-catnav-enabled <?php if(!isset($_SESSION["seller_user_name"])){ echo "left"; } ?>">
        <span class="screen-reader-only"></span>
        <div class="text-gray-lighter text-body-larger">
          <span class="gigtodo-icon hamburger-icon nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M20,6H4A1,1,0,1,1,4,4H20A1,1,0,0,1,20,6Z" />
              <path d="M20,13H4a1,1,0,0,1,0-2H20A1,1,0,0,1,20,13Z" />
              <path d="M20,20H4a1,1,0,0,1,0-2H20A1,1,0,0,1,20,20Z" />
            </svg>
          </span>
        </div>
      </button>
      <div class="catnav-search-bar search-browse-wrapper with-catnav">
        <div class="search-browse-inner">
          <form id="gnav-search" class="search-nav expanded-search apply-nav-height" method="post">
            <div class="gnav-search-inner clearable">
              <label for="search-query" class="screen-reader-only">Search for items</label>
              <div class="search-input-wrapper text-field-wrapper">
                <input id="search-query" class="rounded" name="search_query"
                  placeholder="<?= $lang['search']['placeholder']; ?>" value="<?= @$_SESSION["search_query"]; ?>"  autocomplete="off">
              </div>
              <div class="search-button-wrapper hide">
                <button class="btn btn-primary" name="search" type="submit" value="Search">
                <?= $lang['search']['button']; ?>
                </button>
              </div>
            </div>
            <ul class="search-bar-panel d-none"></ul>
          </form>
        </div>
      </div>
      <?php
      if (isset($_POST['search'])) {
        $search_query = $input->post('search_query');
        $_SESSION['search_query'] = $search_query;
        echo "<script>window.open('$site_url/search.php','_self')</script>";
      }
      ?>
      <ul class="account-nav apply-nav-height">
        <?php if (!isset($_SESSION["seller_user_name"])){ ?>
        <li class="register-link">
            <a href="<?= $site_url; ?>/freelancers.php">Freelancers</a>
        </li>
        <li class="sell-on-gigtodo-link d-none d-lg-block">
          <a href="#" data-toggle="modal" data-target="#register-modal">
          <span class="sell-copy">
          <?= $lang['become_seller']; ?>
          </span>
          <span class="sell-copy short">
          <?= $lang['become_seller']; ?>
          </span>
          </a>
        </li>
        <li class="register-link">
          <a href="#" data-toggle="modal" data-target="#login-modal"><?= $lang['sign_in']; ?></a>
        </li>
        <li class="sign-in-link mr-lg-0 mr-3">
          <a href="#" class="btn btn_join" style="color: white;" data-toggle="modal" data-target="#register-modal">
          <?php if ($deviceType == "phone") { echo $lang['mobile_join_now']; } else { echo $lang['join_now']; } ?>
          </a>
        </li>
        <?php 
        }else{
          require_once("comp/UserMenu.php");
        }
        ?>
      </ul>
    </div>
  </header>
</div> -->

<!-- <div class="clearfix"></div>
<?php //include("comp/categories_nav.php"); ?>
<div class="clearfix"></div> -->

<?php if(isset($_GET['not_available'])) { ?>
<!-- Alert to show wrong url or unregistered account end -->
<div class="alert alert-danger text-center mb-0 h6">
  <?= $lang['not_availble']; ?>
</div>
<?php } ?>

<?php 
  if(isset($_SESSION['seller_user_name'])) {
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
    <button id="send-email" class="btn btn-success btn-sm float-right text-white"><?= $lang["popup"]["email_confirm"]['button']; ?></button>
  </div>
</div>
<script>
  $(document).ready(function(){
  $("#send-email").click(function(){
  $.ajax({
  method: "POST",
  url: "<?= $site_url; ?>/includes/send_email",
  success:function(){
  $("#send-email").html("Resend Email");
  swal({
  type: 'success',
  text: 'Confirmation email sent. Please check your email.',
  })
  }
  });
  });
  });
</script>
<?php  } } ?>
<!-- Registration Modal starts -->
<div class="modal fade" id="register-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- modal-header Starts -->
        <i class="fa fa-user-plus"></i> 
        <h5 class="modal-title"> <?= $lang['modals']['register']['title']; ?> </h5>
        <button class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <!-- modal-header Ends -->
      <div class="modal-body">
        <!-- modal-body Starts -->
        <?php 
          $form_errors = Flash::render("register_errors");
          $form_data = Flash::render("form_data");
          if(is_array($form_errors)){
          ?>
        <div class="alert alert-danger">
          <!--- alert alert-danger Starts --->
          <ul class="list-unstyled mb-0">
            <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
            <li class="list-unstyled-item"><?= $i ?>. <?= ucfirst($error); ?></li>
            <?php } ?>
          </ul>
        </div>
        <!--- alert alert-danger Ends --->
        <script type="text/javascript">
          $(document).ready(function(){
            $('#register-modal').modal('show');
          });
        </script>
        <?php } ?>
        <form action="" method="post" class="pb-3">
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Full Name: </label>
            <input type="text" class="form-control" name="name" placeholder="Enter Your Full Name" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>" required="">
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Username: </label>
            <input type="text" class="form-control" name="u_name" placeholder="Enter Your Username" value="<?php if(isset($_SESSION['u_name'])) echo $_SESSION['u_name']; ?>" required="">
            <small class="form-text text-muted">Note: You will not be able to change username once your account has been created.</small>
            <?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
            <?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
            <?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Email: </label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>" required="">
            <?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Password: </label>
            <input type="password" class="form-control" name="pass" placeholder="Enter Password" required="">
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Confirm Password: </label>
            <input type="password" class="form-control" name="con_pass" placeholder="Confirm Password" required="">
            <?php if(in_array("Passwords don't match. Please try again.", $error_array)) echo "<span style='color:red;'>Passwords don't match. Please try again.</span> <br>"; ?>
          </div>
          <?php if(isset($_GET['referral'])){ ?>
          <input type="hidden" class="form-control" name="referral" value="<?= $input->get('referral'); ?>">
          <?php }else{ ?>
          <input type="hidden" class="form-control" name="referral" value="">
          <?php } ?>
          <input type="hidden" name="timezone" value="">
          <input type="submit" name="register" class="btn btn-success btn-block" value="Register Now">
        </form>
        <?php if($enable_social_login == "yes"){ ?>
        <div class="clearfix"></div>
        <div class="text-center">or, register with either:</div>
        <hr class="">
        <div class="line mt-3"><span></span></div>
        <div class="text-center">
          <a href="#" onclick="window.location = '<?= $fLoginURL ?>';" class="btn btn-primary btn-fb-connect" >
          <i class="fa fa-facebook"></i> FACEBOOK
          </a>
          <a href="#" onclick="window.location = '<?= $gLoginURL ?>';" class="btn btn-danger btn-gplus-connect " >
          <i class="fa fa-google-plus"></i> GOOGLE
          </a>
        </div>
        <div class="clearfix"></div>
        <?php } ?>
        <div class="text-center mt-3 text-muted">
          <?= $lang['modals']['register']['already_account']; ?>
          <a href="#" class="text-success" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In.</a>
        </div>
      </div>
      <!-- modal-body Ends -->
    </div>
  </div>
</div>
<!-- Registration modal ends -->
<!-- Login modal start -->
<div class="modal fade login" id="login-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- Modal header start -->
        <i class="fa fa-sign-in fa-log"></i> 
        <h5 class="modal-title"><?= $lang['modals']['login']['title']; ?></h5>
        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <!-- Modal header end -->
      <div class="modal-body">
        <!-- Modal body start -->
        <?php 
          $form_errors = Flash::render("login_errors");
          $form_data = Flash::render("form_data");
          if(is_array($form_errors)){
          ?>
        <div class="alert alert-danger">
          <!--- alert alert-danger Starts --->
          <ul class="list-unstyled mb-0">
            <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
            <li class="list-unstyled-item"><?= $i ?>. <?= ucfirst($error); ?></li>
            <?php } ?>
          </ul>
        </div>
        <!--- alert alert-danger Ends --->
        <script type="text/javascript">
          $(document).ready(function(){
            $('#login-modal').modal('show');
          });
        </script>
        <?php } ?>
        <form action="" method="post">
          <div class="form-group">
            <label class="form-group-label"> Username:</label>
            <input type="text" class="form-control" name="seller_user_name" placeholder="Enter Username"  value= "<?php if(isset($_SESSION['seller_user_name'])) echo $_SESSION['seller_user_name']; ?>" required="">
          </div>
          <div class="form-group">
            <label class="form-group-label"> Password:</label>
            <input type="password" class="form-control" name="seller_pass" placeholder="Enter Password" required="">
          </div>
          <input type="submit" name="login" class="btn btn-success btn-block" value="Login Now">
        </form>
        <?php if($enable_social_login == "yes"){ ?>
        <div class="clearfix"></div>
        <div class="text-center pt-4 pb-2"><?= $lang['modals']['login']['or']; ?></div>
        <hr class="">
        <div class="line mt-3"><span></span></div>
        <div class="text-center">
          <a href="#" onclick="window.location = '<?= $fLoginURL ?>';" class="btn btn-primary btn-fb-connect" >
          <i class="fa fa-facebook"></i> FACEBOOK
          </a>
          <a href="#" onclick="window.location = '<?= $gLoginURL ?>';" class="btn btn-danger btn-gplus-connect " >
          <i class="fa fa-google-plus"></i> GOOGLE
          </a>
        </div>
        <div class="clearfix"></div>
        <?php } ?>
        <div class="text-center mt-3">
          <a href="#" class="text-success" data-toggle="modal" data-target="#register-modal" data-dismiss="modal">
          <?= $lang['modals']['login']['not_registerd']; ?>
          </a>
          &nbsp; &nbsp; | &nbsp; &nbsp;
          <a href="#" class="text-success" data-toggle="modal" data-target="#forgot-modal" data-dismiss="modal">
          <?= $lang['modals']['login']['forgot_password']; ?>
          </a>
        </div>
      </div>
      <!-- Modal body ends -->
    </div>
  </div>
</div>
<!-- Login modal end -->

<?php //("register_login_forgot.php"); ?>


<!-- New Header Design -->

  <header>
    <div class="home-header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6 col-md-3 d-flex flex-row">
            <div class="logo">
              <?php if($site_logo_type == "image"){ ?>
              <!-- <a class="logo-1" href="<?= $site_url; ?>"><img src="<?= $site_url; ?>/assets/img/logo.svg" alt=""></a> -->
              <a class="logo-1" href="<?= $site_url; ?>"><img src="<?= $site_url; ?>/images/<?= $site_logo_image; ?>" width="150"></a>
              <a class="home-logo" href="<?= $site_url; ?>"><img src="<?= $site_url; ?>/images/<?= $site_sticky_logo; ?>" alt=""></a>
              <!-- <a class="home-logo" href="<?= $site_url; ?>"><img src="<?= $site_url; ?>/images/<?= $site_logo_image; ?>" width="150"></a> -->
              <?php }else{ ?>
              <?= $site_logo_text; ?>
              <?php } ?>
            </div>
          </div>
          <div class="col-6 col-md-9">
            <div class="header-right d-flex align-items-center justify-content-end">
              <div class="menu-inner">
                <ul>
                  <li><a href="<?= $site_url; ?>/requests/post-request.php"><?= $lang['post_request'];?></a></li>
                  <li><a href="<?= $site_url; ?>/how-it-works.php">How it Works</a></li>
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
                <select name="" id="curreny_convert" class="curreny_convert">
                  <option value="USD" <?php if($to == 'USD'){ echo "selected";} ?>>USD</option>
                  <option value="EGP" <?php if($to == 'EGP'){ echo "selected";} ?> >EGP</option>
                </select>
              </div>
              <div class="Login-button">
                <a href="<?= $site_url; ?>/login.php">Login</a>
                <a href="<?= $site_url; ?>/register.php">Join Now</a>
              </div>
              <div class="menubar">
                <div class="d-flex flex-row align-items-center">
                  <div class="image">
                    <img src="<?= $site_url ?>/assets/img/menu-left-logo-2.png" alt="">
                    <img src="<?= $site_url ?>/assets/img/menu-left-logo.png" alt="">
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
  <!-- End New Design -->
  <!-- Offcanvas-menu -->
  <div class="ofcanvas-menu pre-login">
    <div class="close-icon">
      <i class="fal fa-times"></i>
    </div>
    <div class="canvs-menu">
      <ul class="d-flex flex-column">
        <li>
          <a href="<?= $site_url; ?>/requests/post-request.php">Post A Request</a>
        </li>
        <li>
          <a href="<?= $site_url; ?>/how-it-works.php">How it Works</a>
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
            <select name="" id="curreny_convert" class="curreny_convert">
              <option value="USD" <?php if($to == 'USD' && $s_currency == '$'){ echo "selected";} ?>>USD</option>
              <option value="EGP" <?php if($to == 'EGP' && $s_currency == 'EGP'){ echo "selected";} ?> >EGP</option>
            </select>
          </div>
        </li>
        <li class="mb-20">
          <a class="button login-button" href="<?= $site_url; ?>/login.php">Login</a>
        </li>
        <li>
          <a class="button join-button" href="<?= $site_url; ?>/register.php">Join Now</a>
        </li>
      </ul>
    </div>
  </div>
  <!-- Close-overlay -->
  <div class="overlay-bg"></div>
  <!-- Offcanvas-menu END-->