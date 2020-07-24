<?php
session_start();
require_once("includes/db.php");
require_once("functions/functions.php");
require_once("social-config.php");

if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_user_type = $row_login_seller->account_type;
  $login_seller_name = $row_login_seller->seller_name;
  $login_user_name = $row_login_seller->seller_user_name;
  $login_seller_offers = $row_login_seller->seller_offers;
  $gmail_verification = $row_login_seller->gmail_verification;
  $fb_verification = $row_login_seller->fb_verification;
  $seller_verification = $row_login_seller->seller_verification;
  $login_seller_paypal_email = $row_login_seller->seller_paypal_email;

  $relevant_requests = $row_general_settings->relevant_requests;

  if(isset($_GET['delete_language'])){
    $delete_language_id = $input->get('delete_language');
    $delete_language = $db->delete("languages_relation",array("relation_id"=>$delete_language_id,"seller_id"=>$login_seller_id));
    if($delete_language->rowCount() == 1){
      echo "<script>alert('One Language has been deleted.')</script>";
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }else{
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }
  }
  if(isset($_GET['delete_skill'])){
    $delete_skill_id = $input->get('delete_skill');
    $delete_skill = $db->delete("skills_relation",array("relation_id"=>$delete_skill_id,"seller_id"=>$login_seller_id));
    if($delete_skill->rowCount() == 1){
      echo "<script>alert('One skill has been deleted.')</script>";
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }else{
      echo "<script> window.open('$login_seller_user_name','_self') </script>";
    }
  }
}

$get_seller_user_name = $input->get('user_name');
$select_seller = $db->query("select * from sellers where seller_user_name=:u_name AND NOT seller_status='deactivated' AND NOT seller_status='block-ban'",array("u_name"=>$get_seller_user_name));
$row_select_seller = $select_seller->fetch();
$select_seller_id = $row_select_seller->seller_id;
$gmail_verification = $row_select_seller->gmail_verification;
$fb_verification = $row_select_seller->fb_verification;
$seller_verification = $row_select_seller->seller_verification;
$seller_paypal_email = $row_select_seller->seller_paypal_email;


$count_seller = $select_seller->rowCount();
if($count_seller == 0){
  echo "<script>window.open('index?not_available','_self');</script>";
}

$get_requests = $db->select("buyer_requests",array("seller_id" => $seller_id,"request_status" => "active"),"DESC");                      
$count_requests = $get_requests->rowCount();

$select_seller_payments = $db->select("seller_payment_account", array("seller_id" => $login_seller_id));
$count_account = $select_seller_payments->rowCount();


$select_seller_payments = $db->select("seller_payment_account", array("seller_id" => $select_seller_id));
$count_account = $select_seller_payments->rowCount();

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - <?php echo ucfirst($get_seller_user_name) . "'s Profile"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  
  <!--====== Favicon Icon ======-->
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
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
  <!--====== Range Slider css ======-->
  <link href="assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
  <!-- <link href="styles/proposalStyles.css" rel="stylesheet">
  <link href="styles/categories_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="<?php echo $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
  <link href="<?php echo $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <style>
    .edit-profile-button {
      -webkit-box-align: center;
      -webkit-align-items: center;
      -moz-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      background-color: #ff0707;
      border: 2px solid #ff0707;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      color: white;
      -webkit-box-orient: horizontal;
      -webkit-box-direction: normal;
      -webkit-flex-direction: row;
      -moz-box-orient: horizontal;
      -moz-box-direction: normal;
      -ms-flex-direction: row;
      flex-direction: row;
      font-size: 13px;
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      height: 40px;
      line-height: 26px;
      -webkit-box-pack: center;
      -webkit-justify-content: center;
      -moz-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      margin-left: auto;
      text-transform: uppercase;
      -webkit-transition: all 0.3s ease-in-out 0s;
      -o-transition: all 0.3s ease-in-out 0s;
      -moz-transition: all 0.3s ease-in-out 0s;
      transition: all 0.3s ease-in-out 0s;
      width: 160px;
    }
    .edit-profile-button:hover{
      background-color: white;
      border: 2px solid #ff0707;
      color: #ff0707;
    }
    @media(max-width: 768px){
      .buyer-profile .managerequest .mangaerequest-body .managerequest-table tbody tr td .attachment {
        width: 255px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
      }
      .buyer-profile .buyer-profile-header{
        background-size: 100% 47%;
        background-position: center top;
      }
      .buyer-profile .buyer-profile-header .buyer-profile-image{
        padding: 2px;
      }
    }
  </style>
</head>
<body class="all-content">  
  <!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
      <img src="assets/img/emongez_cube.png" />
    </div>
  </div>
  <!-- Preloader End -->      
<?php //require_once("includes/header.php");
  if(isset($_SESSION['seller_user_name'])){  
    if($login_user_type == 'seller'){ 
      require_once('includes/user_header.php');
    }else{
      require_once("includes/buyer-header.php");
    }
  }else{
    require_once("includes/header_with_categories.php");
  }
?>

  <main>
      <section class="container-fluid buyer-profile">
        <div class="row">
          <div class="container">
            <?php require_once("includes/user_profile_header.php"); ?>
            <!-- Row -->
            <div class="row">
              <div class="col-12 col-md-4">
                <div class="buyer-sidebar-card">
                  <div class="buyer-sidebar-card-header d-flex flex-row align-items-center">
                    <span>
                      <img alt="" class="img-fluid d-block" src="assets/img/buyer/buyer-status.png" />
                    </span>
                    <span>Buyer Stats</span>
                  </div>
                  <div class="buyer-sidebar-card-body">
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/project-icon.png" /></span>
                      <span>Project Posted</span>
                      <span class="ml-auto"><?= $posted_projects; ?></span>
                    </div>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/purchased-icon.png" /></span>
                      <span>Services Purchased</span>
                      <span class="ml-auto"><?= $purchased_services; ?></span>
                    </div>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/sellers-icon.png" /></span>
                      <span>Sellers Worked with</span>
                      <span class="ml-auto"><?= $total_sellers; ?></span>
                    </div>
                  </div>
                </div>
                <!-- Each item -->
                <div class="buyer-sidebar-card">
                  <div class="buyer-sidebar-card-header d-flex flex-row align-items-center">
                    <span>
                      <img alt="" class="img-fluid d-block" src="assets/img/buyer/verification-icon.png" />
                    </span>
                    <span>Verifications</span>
                  </div>

                  <?php if(isset($_SESSION['seller_user_name'])){ ?>
                    <?php if($_SESSION['seller_user_name'] == $get_seller_user_name){ ?>
                  <div class="buyer-sidebar-card-body">
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-facebook-f"></i></span>
                      <span>Facebook</span>
                      <?php if($fb_verification == 0){ ?>
                      <span class="ml-auto d-flex flex-row align-items-center facebook" onclick="window.location='<?php echo $fLoginURL ?>';">
                        <span><i class="fab fa-facebook-f"></i></span>
                        <span>Connect</span>
                      </span>
                      <?php }else{ ?>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                      <?php } ?>
                    </div>
                    <!-- <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-linkedin-in"></i></span>
                      <span>LinkedIn</span>
                      <span class="ml-auto d-flex flex-row align-items-center linkedin">
                        <span><i class="fab fa-linkedin-in"></i></span>
                        <span>Connect</span>
                      </span>
                    </div> -->
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-google"></i></span>
                      <span>Google</span>
                      <?php if($gmail_verification == 0){ ?>
                      <span class="ml-auto d-flex flex-row align-items-center google" onclick="window.location = '<?php echo $gLoginURL ?>';">
                        <span><i class="fab fa-google"></i></span>
                        <span>Connect</span>
                      </span>
                      <?php }else{ ?>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                      <?php } ?>
                    </div>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fas fa-envelope"></i></span>
                      <span>Email</span>
                      <?php if($seller_verification != 'ok'){ ?>
                      <span class="ml-auto d-flex flex-row align-items-center email">
                        <span>Verify</span>
                      </span>
                      <?php }else{ ?>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                      <?php } ?>
                    </div>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
                      <span>Payment</span>
                      <?php if ($count_account > 0 or $login_seller_paypal_email != ''){ ?>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                      <?php }elseif($count_account == 0 and $login_seller_paypal_email == ''){ ?>
                      <span class="ml-auto d-flex flex-row align-items-center email" onclick="window.open('settings?account_settings')">
                        <span>Verify</span>
                      </span>
                      <?php } ?>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="buyer-sidebar-card-body">
                    <?php if($fb_verification != 0){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-facebook-f"></i></span>
                      <span>Facebook</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                    <!-- <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-linkedin-in"></i></span>
                      <span>LinkedIn</span>
                      <span class="ml-auto d-flex flex-row align-items-center linkedin">
                        <span><i class="fab fa-linkedin-in"></i></span>
                        <span>Connect</span>
                      </span>
                    </div> -->
                    <?php if($gmail_verification != 0){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-google"></i></span>
                      <span>Google</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                    <?php if($seller_verification == 'ok'){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fas fa-envelope"></i></span>
                      <span>Email</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                    <?php if ($count_account > 0 or $seller_paypal_email != ''){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
                      <span>Payment</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                  </div>
                <?php } } else{?>
                  <div class="buyer-sidebar-card-body">
                    <?php if($fb_verification != 0){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-facebook-f"></i></span>
                      <span>Facebook</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                    <!-- <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-linkedin-in"></i></span>
                      <span>LinkedIn</span>
                      <span class="ml-auto d-flex flex-row align-items-center linkedin">
                        <span><i class="fab fa-linkedin-in"></i></span>
                        <span>Connect</span>
                      </span>
                    </div> -->
                    <?php if($gmail_verification != 0){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fab fa-google"></i></span>
                      <span>Google</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                    <?php if($seller_verification == 'ok'){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><i class="fas fa-envelope"></i></span>
                      <span>Email</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                    <?php if ($count_account > 0 or $seller_paypal_email != ''){ ?>
                    <div class="buyer-sidebar-body-item d-flex flex-row">
                      <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
                      <span>Payment</span>
                      <span class="ml-auto d-flex flex-row align-items-center payment">
                        <span><i class="fal fa-check"></i></span>
                      </span>
                    </div>
                    <?php } ?>
                  </div>
                <?php } ?>
                </div>
                <!-- Each item -->
              </div>
              <div class="col-12 col-md-8">
                <div class="aboutme">
                  <div class="aboutme-header">About me</div>
                  <div class="aboutme-radmore">
                    <p><?= $seller_about; ?></p>
                  </div>
                </div>
                <?php if(isset($_SESSION['seller_user_name'])){ ?>
                <?php if($_SESSION['seller_user_name'] == $seller_user_name){ ?>
                <div class="managerequest">
                  <h3>Manage Jobs</h3>
                  <div class="managerequest-header d-flex flex-column flex-md-row justify-content-between">
                    <!-- <div class="managerequest-status d-flex flex-row align-items-center">
                      <span>Show</span>
                      <div>
                        <select class="wide">
                          <option>Select Request status</option>
                          <option>Select Request status</option>
                          <option>Select Request status</option>
                          <option>Select Request status</option>
                          <option>Select Request status</option>
                          <option>Select Request status</option>
                        </select>
                      </div>
                    </div> -->
                    <!-- <div class="managerequest-pagination">
                      <ul class="pagination">
                        <li class="pagination-item">
                          <a class="pagination-link" href="javascript:void(0);">
                            <i class="fal fa-angle-left"></i>
                          </a>
                        </li>
                        <li class="pagination-item">
                          <a class="pagination-link" href="javascript:void(0);">1</a>
                        </li>
                        <li class="pagination-item">
                          <div class="pagination-status d-flex flex-row align-items-center">
                            <span>Of</span>
                            <span>1</span>
                          </div>
                        </li>
                        <li class="pagination-item">
                          <a class="pagination-link" href="javascript:void(0);">
                            <i class="fal fa-angle-right"></i>
                          </a>
                        </li>
                      </ul>
                    </div> -->
                  </div>
                  <div class="mangaerequest-body">
                    <table class="table managerequest-table" cellpadding="0" cellspacing="0" border="0">
                      <thead>
                        <tr role="row">
                          <th role="column">Date</th>
                          <th role="column">Request</th>
                          <th role="column">Offers</th>
                          <th role="column">Delivery</th>
                          <th role="column">Budget</th>
                          <?php if(isset($_SESSION['seller_user_name'])){ ?>
                          <?php if($_SESSION['seller_user_name'] == $seller_user_name){ ?>
                          <th role="column">Actions</th>
                          <?php }} ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            $get_requests = $db->select("buyer_requests",array("seller_id" => $login_seller_id,"request_status" => "active"),"DESC");
                      
                            $count_requests = $get_requests->rowCount();
                            while($row_requests = $get_requests->fetch()){

                            $request_id = $row_requests->request_id;
                            $request_title = $row_requests->request_title;
                            $request_description = $row_requests->request_description;
                            $request_date = $row_requests->request_date;
                            $delivery_time = $row_requests->delivery_time;
                            $request_budget = $row_requests->request_budget;
                            $request_skills = explode(',',$row_requests->skills_required);
                            $count_offers = $db->count("send_offers",array("request_id" => $request_id, "status" => 'active'));
                          ?>
                        <tr role="row">
                          <td data-label="Date"><?php echo $request_date; ?></td>
                          <td data-label="Request">
                            <p><?= $request_description; ?></p>
                            <div class="tags">
                              <?php foreach ($request_skills as $key => $skills) { ?>
                                <a href="javascript:void(0);" class="taga-item"><?php echo $skills; ?></a>
                              <?php } ?>
                            </div>
                          </td>
                          <td data-label="Offers">
                            <div class="offers-button"><a href="requests/view_offers?request_id=<?php echo $request_id; ?>" class="offers-button"><?php echo $count_offers; ?> offers</a></div>
                          </td>
                          <td data-label="Delivery"><?= $delivery_time; ?> Days</td>
                          
                          <td data-label="Budget">
                            <div class="d-flex flex-column">
                              <?php if(!empty($request_budget)){ ?>
                              <span><?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget,2);}else{  echo $s_currency.' '; echo $request_budget; } ?></span>
                              <?php }else{ ?>
                              <span> ----- </span>
                              <?php } ?>
                              <?php if($_SESSION['seller_user_name'] != $seller_user_name){ ?>
                              <?php if($login_seller_offers == "0"){ ?>
                              <a class="send-offer send_button_<?= $request_id; ?>" data-toggle="modal" href="#quota-finish">Send offer</a>
                              <?php }else{ ?>
                              <button class="send-offer send_button_<?= $request_id; ?>">
                              Send Offer
                              </button>
                              <?php } ?>
                              <?php } ?>
                            </div>
                          </td>
                          <?php if($login_seller_offers == "0"){ ?>
                          <?php }else{ ?>
                          <script type="text/javascript">
                            $(".send_button_<?= $request_id; ?>").click(function(){
                             request_id = "<?= $request_id; ?>";
                              $.ajax({
                               method: "POST",
                                 url: "requests/send_offer_modal",
                                   data: {request_id: request_id }
                                })
                                   .done(function(data){
                                   $(".append-modal").html(data);
                                    });
                              });
                             <?php } ?>
                          </script>
                          <?php if(isset($_SESSION['seller_user_name'])){ ?>
                          <?php if($_SESSION['seller_user_name'] == $seller_user_name){ ?>
                          <td data-label="Actions">
                            <div class="dropdown">
                              <a class="action-link dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-cog"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="pause_request?request_id=<?php echo $request_id; ?>">Pause</a>
                                <a class="dropdown-item" href="delete_request?request_id=<?php echo $request_id; ?>">Delete</a>
                              </div>
                            </div>
                          </td>
                        <?php } } ?>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <?php
                      if($count_requests == 0){
                          echo "<center><h4 class='pb-2 pt-2'>you still dont have any job requests <a class='edit-profile-button btn' href='requests/post-request.php'>Post a request</a></h4></center>";
                      } else {
                    ?>
                    <!-- <center>
                      <a href="requests/buyer_requests.php" class="btn edit-profile-button mb-3">
                      <i class="fa fa-spinner"></i> Load More
                      </a>
                    </center> -->
                    <?php } ?>
                  </div>
                </div>
                <?php } } ?>
                <?php if(isset($_SESSION['seller_user_name'])) { ?>
                  <?php if($login_user_type == 'seller'){ ?>
                  <?php
                    $request_child_ids = array();
                    $select_proposals = $db->query("select DISTINCT proposal_child_id from proposals where proposal_seller_id='$login_seller_id' and proposal_status='active'");
                    while($row_proposals = $select_proposals->fetch()){
                    $proposal_child_id = $row_proposals->proposal_child_id;
                    array_push($request_child_ids, $proposal_child_id);
                    }
                    $where_child_id = array();
                    foreach($request_child_ids as $child_id){
                        $where_child_id[] = "child_id=" . $child_id;
                    }
                    if(count($where_child_id) > 0){
                        $query_where = " and (" . implode(" or ", $where_child_id) . ")";
                    }
                    
                    if($relevant_requests == "no"){ $query_where = ""; }

                    if(!empty($query_where) or $relevant_requests == "no"){
                    
                    $select_requests =  $db->query("select * from buyer_requests where request_status='active'". $query_where ." AND seller_id='$select_seller_id' order by request_id DESC LIMIT 0,5");
                    $requests_count = 0;
                    while($row_requests = $select_requests->fetch()){
                        $request_id = $row_requests->request_id;
                        $count_offers = $db->count("send_offers",array("request_id" => $request_id,"sender_id" => $login_seller_id));
                        if($count_offers == 0){
                            $requests_count++;
                        }
                    }
                    
                    $count_proposals = $db->count("proposals",array("proposal_seller_id"=>$login_seller_id,"proposal_status"=>'active'));
                    
                    if($requests_count !=0 and !empty($count_proposals)){

                    ?>
                    <div class="managerequest">
                      <h3>Manage Jobs</h3>
                      <div class="managerequest-header d-flex flex-column flex-md-row justify-content-between">
                        <!-- <div class="managerequest-status d-flex flex-row align-items-center">
                          <span>Category</span>
                          <span>
                            <select class="wide">
                              <option>Category</option>
                              <option>Category</option>
                              <option>Category</option>
                              <option>Category</option>
                              <option>Category</option>
                              <option>Category</option>
                            </select>
                          </span>
                        </div> -->
                        <!-- <div class="managerequest-pagination">
                          <ul class="pagination">
                            <li class="pagination-item">
                              <a class="pagination-link" href="javascript:void(0);">
                                <i class="fal fa-angle-left"></i>
                              </a>
                            </li>
                            <li class="pagination-item">
                              <a class="pagination-link" href="javascript:void(0);">1</a>
                            </li>
                            <li class="pagination-item">
                              <div class="pagination-status d-flex flex-row align-items-center">
                                <span>Of</span>
                                <span>1</span>
                              </div>
                            </li>
                            <li class="pagination-item">
                              <a class="pagination-link" href="javascript:void(0);">
                                <i class="fal fa-angle-right"></i>
                              </a>
                            </li>
                          </ul>
                        </div> -->
                      </div>
                      <div class="mangaerequest-body">
                        <table class="table managerequest-table" cellpadding="0" cellspacing="0" border="0">
                          <thead>
                            <tr role="row">
                              <th role="column">Buyer</th>
                              <th role="column">Request</th>
                              <th role="column">Offers</th>
                              <th role="column">Delivery</th>
                              <th role="column">Budget</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $select_requests =  $db->query("select * from buyer_requests where request_status='active'". $query_where ." AND seller_id='$select_seller_id' order by request_id DESC LIMIT 0,5");
                              while($row_requests = $select_requests->fetch()){
                              $request_id = $row_requests->request_id;
                              $seller_id = $row_requests->seller_id;
                              $request_title = $row_requests->request_title;
                              $request_description = $row_requests->request_description;
                              $request_date = $row_requests->request_date;
                              $delivery_time = $row_requests->delivery_time;
                              $request_budget = $row_requests->request_budget;
                              $request_file = $row_requests->request_file;
                              // $request_skills = $row_requests->skills_required;
                              $request_skills = explode(',',$row_requests->skills_required);
                              $select_request_seller = $db->select("sellers",array("seller_id"=>$seller_id));
                              $row_request_seller = $select_request_seller->fetch();
                              $request_seller_user_name = $row_request_seller->seller_user_name;
                              $request_seller_image = $row_request_seller->seller_image;
                              $count_send_offers = $db->count("send_offers",array("request_id" => $request_id));
                              $count_offers = $db->count("send_offers",array("request_id" => $request_id,"sender_id" => $login_seller_id));
                              if($count_offers == 0){
                              ?>
                            <tr role="row">
                              <td data-label="Buyer">
                                <div class="d-flex flex-column align-items-center">
                                  <div class="buyer-image">
                                    <?php if(!empty($request_seller_image)){ ?>
                                    <img alt class="img-fluid d-block rounded-circle" src="user_images/<?= $request_seller_image; ?>" />
                                    <?php } else { ?>
                                    <img alt class="img-fluid d-block" src="assets/img/emongez_cube.png" />
                                    <?php } ?>
                                  </div>
                                  <div class="buyer-id"><?= ucfirst($request_seller_user_name); ?></div>
                                  <span><?= $request_date; ?></span>
                                </div>
                              </td>
                              <td data-label="Request">
                                <p><?= $request_description; ?></p>
                                <div class="attachment d-flex flex-row align-items-center">
                                  <?php if(!empty($request_file)){ ?>
                                  <a href="requests/request_files/<?= $request_file; ?>" download><span><i class="fal fa-paperclip"></i></span>
                                  <span><?= $request_file; ?></span>
                                  <span></span></a>
                                  <?php } ?>
                                </div>
                                <div class="tags">
                                  <!-- <a href="javascript:void(0);" class="taga-item"><?= $request_skills; ?></a> -->
                                  <?php foreach ($request_skills as $key => $skills) { ?>
                                  <a href="javascript:void(0);" class="taga-item"><?php echo $skills; ?></a>
                                  <?php } ?>
                                </div>
                              </td>
                              <td data-label="Offers">
                                <div class="offers-button"><?= $count_send_offers; ?> offers</div>
                              </td>
                              <td data-label="Delivery"><?= $delivery_time; ?> Days</td>
                              <td data-label="Budget">
                                <div class="d-flex flex-column">
                                  <?php if(!empty($request_budget)){ ?>
                                  <span><?php if ($to == 'EGP'){ echo $to.' '; echo $request_budget;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $request_budget,2);}else{  echo $s_currency.' '; echo $request_budget; } ?></span>
                                  <?php }else{ ?><span> ----- </span><?php } ?>
                                  <?php if($login_seller_offers == "0"){ ?>
                                  <a class="send-offer send_button_<?= $request_id; ?>" data-toggle="modal" data-target="#quota-finish">Send offer</a>
                                <?php } else { ?>
                                  <a class="send-offer send_button_<?= $request_id; ?>">Send offer</a>
                                <?php } ?>
                                </div>
                              </td>
                              <?php if($login_seller_offers == "0"){ ?>
                              <?php }else{ ?>
                              <script type="text/javascript">
                                $(".send_button_<?= $request_id; ?>").click(function(){
                                 request_id = "<?= $request_id; ?>";
                                  $.ajax({
                                   method: "POST",
                                     url: "requests/send_offer_modal",
                                       data: {request_id: request_id }
                                    })
                                       .done(function(data){
                                       $(".append-modal").html(data);
                                        });
                                  });
                                 <?php } ?>
                              </script>
                            </tr>
                          <?php }} ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <?php }} ?>
                <?php } } ?>
                <?php if(isset($_SESSION['seller_user_name'])){ ?>
                <?php if($_SESSION['seller_user_name'] == $seller_user_name){ ?>
                <div class="all-gigs">
                  <div class="row">
                    <div class="col-12">
                      <h3>Favorites</h3>
                    </div>
                  </div>
                  <div class="all-gigs-small mt-30">
                    <div class="row">
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
                      <?php require("includes/proposals_mobile.php"); ?>
                      <?php } ?>
                      <!-- Each item -->
                    </div>
                  </div>
                  <!-- Small gigs item for mobile -->
                  <div class="row d-none d-lg-flex">
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
                    <div class="col-lg-4 col-sm-6">
                      <?php require("includes/proposals.php"); ?>
                    </div>
                    <?php } ?>
                    <!-- Each item -->
                  </div>
                </div>
                <?php }} ?>
              </div>
            </div>
          </div>
        </div>
      </section>
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
    </main>

<!-- <?php //require_once("includes/user_profile_header.php"); ?>
<div class="container">  -->
  <!-- Container starts -->
  <!-- <div class="row">
    <div class="col-md-4 mt-4">
      <?php //require_once("includes/user_sidebar.php"); ?>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card mt-4 mb-4 rounded-0">
            <div class="card-body">
              <h2><?php echo ucfirst($get_seller_user_name); ?>'s Proposals/Services</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <?php
        $get_proposals = $db->select("proposals",array("proposal_seller_id" => $seller_id,"proposal_status" => "active"));
        $count_proposals = $get_proposals->rowCount();
        if($count_proposals == 0){
        ?>  
        <div class="col-md-12">
        <?php if(isset($_SESSION['seller_user_name']) AND $seller_user_name == $_SESSION['seller_user_name']) { ?>
        <h3 class=" text-center mb-5 p-2">
        <i class="fa fa-smile-o"></i> Hey <?php echo ucfirst($get_seller_user_name); ?>! you have no proposals/services displayed here at the moment. Click <a href="<?php echo $site_url; ?>/proposals/create_proposal.php" class="text-success">here</a> to create a proposal/service.
        </h3>
        <?php }else{ ?>
        <h3 class="text-center mb-5 p-2">
        <i class="fa fa-smile-o"></i> <?php echo ucfirst($get_seller_user_name); ?> does not have any proposals/services to display at the moment.
        </h3>
        <?php } ?>
        </div>
        <?php   
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
        @$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
        if($count_favorites == 0){
        $show_favorite_class = "proposal-favorite dil1";
        }else{
        $show_favorite_class = "proposal-unfavorite dil";
        }
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
        <?php //require("includes/proposals.php"); ?>
        </div>
       <?php } ?>
       <?php if(isset($_SESSION['seller_user_name']) AND $_SESSION['seller_user_name'] == $get_seller_user_name AND $count_proposals > 0) { ?>
       <a href="proposals/create_proposal" class="col-lg-4 col-md-6 col-sm-6 mb-3">
        <div class="proposal-card-base mp-proposal-card add-new-proposal">
        Create A New Proposal
        </div>
       </a>
       <?php } ?>
      </div>
      <?php //include("includes/user_footer.php"); ?>
    </div>
  </div>
</div> --> <!-- Container ends -->
<?php require_once("includes/footer.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
$('#good').hide();
$('#bad').hide();
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
</script>
</body>
</html>