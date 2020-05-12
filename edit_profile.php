<?php
session_start();
require_once("includes/db.php");
require_once("functions/email.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";
}
require 'admin/timezones.php';

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_username = $row_login_seller->seller_user_name;
$login_seller_name = $row_login_seller->seller_name;
$login_seller_email = $row_login_seller->seller_email;
$login_seller_paypal_email = $row_login_seller->seller_paypal_email;
$login_seller_payoneer_email = $row_login_seller->seller_payoneer_email;
$login_seller_image = $row_login_seller->seller_image;
$login_seller_cover_image = $row_login_seller->seller_cover_image;
$login_seller_headline = $row_login_seller->seller_headline;
$login_seller_country = $row_login_seller->seller_country;
$login_seller_state = $row_login_seller->seller_state;
$login_seller_city = $row_login_seller->seller_city;
$login_seller_timzeone = $row_login_seller->seller_timezone;
$login_seller_language = $row_login_seller->seller_language;
$login_seller_about = $row_login_seller->seller_about;
$login_seller_account_number = $row_login_seller->seller_m_account_number;
$login_seller_account_name = $row_login_seller->seller_m_account_name;
$login_seller_wallet = $row_login_seller->seller_wallet;
$login_seller_enable_sound = $row_login_seller->enable_sound;
$login_seller_verification = $row_login_seller->seller_verification;

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

if($lang_dir == "right"){
  $floatRight = "";
}else{
  $floatRight = "float-right";
}

$years = range(1910,date("Y"));

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - <?php echo $lang["settings"]; ?> </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  
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
  <!--====== Nice select css ======-->
  <link href="assets/css/tagsinput.css" rel="stylesheet">
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
  <!-- <link href="styles/user_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/animate.css" rel="stylesheet">
  <link href="styles/croppie.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/croppie.js"></script>
  <?php if($paymentGateway == 1){ ?>
  <script src="plugins/paymentGateway/javascript/script.js"></script>
  <?php } ?>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <script src="<?php echo $site_url; ?>/js/jquery.easy-autocomplete.min.js"></script>
  <link href="<?php echo $site_url; ?>/styles/easy-autocomplete.min.css" rel="stylesheet">
  <style>
    .profile-edit-step-item{
      cursor: pointer;
    }
    .icontext{
      left: -webkit-calc(50% - (33px / 2));
      left: -moz-calc(50% - (33px / 2));
      left: calc(50% - (33px / 2));
      position: absolute;
      top: -webkit-calc(50% - (33px / 2));
      top: -moz-calc(50% - (33px / 2));
      top: calc(50% - (33px / 2));
    }
    .remove{
      position: absolute;
      top: 10px;
      right: 30px;
    }
    .edit-profile .profile-edit-card .edit-profile-image .cover-image-label{
      padding: 20px 0;
    }
    .edit-profile .profile-edit-card  .custom_nice .nice-select .list {
      width: 100%;
      height: 300px;
      overflow: auto;
    }
    .crop_image , .crop_image_cover{
      background-color: #ff0707;
      border-color: #ff0707;
      color: white; 
    }
    #insertimageModal .modal-header .close {
      padding: 1rem;
      margin: -1rem -1rem auto;
    }
    #state-list , #city-list, #country{
      height: 54px;
      display: block !important;
    }
    .state_box .nice-select{
      display: none;
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
  <?php require_once("includes/user_header.php"); ?>
  <main>
    <section class="container-fluid edit-profile">
      <div class="row">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="heading-title">Edit Profile</h1>
            </div>
          </div>
          <!-- Row -->
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="profile-edit-card">
                <div class="row">
                  <div class="col-12">
                    <div class="profile-edit-steps wide d-flex flex-row justify-content-between">
                      <div class="profile-edit-step-item active" id="profile_tab">
                        <span class="step">1</span>
                        <span class="text">Basic Information</span>
                      </div>
                      <div class="profile-edit-step-item" id="professional_tab">
                        <span class="step">2</span>
                        <span class="text">Professional Information</span>
                      </div>
                      <div class="profile-edit-step-item" id="verification_tab">
                        <span class="step">2</span>
                        <span class="text">Trust & Verification</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-content">
                  <div id="profile_settings" class="tab-pane fade <?php if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){ echo "show active"; } if(isset($_GET['profile_settings'])){ echo "show active"; } ?>">
                    <!-- Row -->
                    <div class="row">
                      <div class="col-12">
                        <?php 
                          $form_errors = Flash::render("form_errors");
                          $form_data = Flash::render("form_data");
                          if(is_array($form_errors)){
                        ?>
                        <div class="alert alert-danger">
                          <!--- alert alert-danger Starts --->
                          <ul class="list-unstyled mb-0">
                            <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
                            <li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
                            <?php } ?>
                          </ul>
                        </div>
                        <!--- alert alert-danger Ends --->
                        <?php } ?>
                        <form method="post" enctype="multipart/form-data" runat="server" autocomplete="off">

                          <div class="seller-profile-image d-flex flex-row align-items-center">
                            <!-- <label class="cover-image-label" for="cover">
                              <input type="file" id="cover" name="cover_photo" hidden />
                              <input type="hidden" name="cover_photo">
                              <div class="icontext d-flex flex-row align-items-center justify-content-center">
                                <span>
                                  <img class="img-fluid d-block" src="assets/img/edit-profile/pen-icon.png" />
                                </span>
                                <span>Edit Cover Image</span>
                                
                              </div>
                              <?php if(!empty($login_seller_cover_image)){ ?>
                              <img src="cover_images/<?php echo $login_seller_cover_image; ?>" width="795" height="280" class="img-thumbnail img-circle cover_pic">
                              <span class="remove text-danger"><i class="fa fa-trash"></i></span>
                              <?php }else{ ?>
                              <?php } ?>
                            </label> -->
                            <label class="profile-image" for="profile-image">
                              <input type="file" id="profile-image" name="profile_photo" class="form-control" hidden />
                              <input type="hidden" name="profile_photo">
                              <?php if(!empty($login_seller_image)){ ?>
                              <img src="user_images/<?php echo $login_seller_image; ?>" width="80" class="img-thumbnail img-circle" >
                              <?php }else{ ?>
                              <img class="img-fluid img-circle" src="assets/img/emongez_cube.png" />
                              <?php } ?>

                              <!-- <input type="file" id="profile-image" name="profile-image" hidden /> -->
                              <!-- <img class="img-fluid d-block" src="assets/img/emongez_cube.png" /> -->
                              <img class="img-fluid d-block pen-icon" src="assets/img/edit-profile/pen-icon.png" />
                            </label>
                            <span>Edit Profile Picture</span>
                          </div>
                          <div class="row">
                            <div class="col-12 col-md-6">
                              <div class="form-group d-flex flex-column">
                                <label class="control-label">Full Name</label>
                                <input class="form-control" type="text" name="seller_name" value="<?php echo $login_seller_name; ?>" />
                              </div>
                            </div>
                            <div class="col-12 col-md-6">
                              <div class="form-group d-flex flex-column">
                                <label class="control-label">Email</label>
                                <input class="form-control" type="email" name="seller_email" value="<?php echo $login_seller_email; ?>" readonly/>
                              </div>
                            </div>
                            <div class="col-12 col-md-6">
                              <div class="form-group d-flex flex-column custom_nice state_box">
                                <label class="control-label">Country</label>
                                <select class="form-control wide" name="seller_country" required="" onChange="getState(this.value);" id="country">
                                  <option>Select Country</option>
                                  <?php
                                    $get_countries = $db->select("countries");
                                    while($row_countries = $get_countries->fetch()){
                                      $id = $row_countries->id;
                                      $name = $row_countries->name;
                                      echo "<option value='$name'".($name == $login_seller_country ? "selected" : "").">$name</option>";
                                    }
                                    ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-12 col-md-6">
                              <div class="form-group d-flex flex-column custom_nice state_box">
                                <label class="control-label">State</label>
                                <select class="form-control wide" name="seller_state" required="" onChange="getCity(this.value);" id="state-list">
                                  <?php if (!empty($login_seller_state)){ ?>
                                    <option selected><?= $login_seller_state; ?></option>
                                  <?php } ?>
                                  
                                </select>
                              </div>
                            </div>
                            <div class="col-12 col-md-6">
                              <div class="form-group d-flex flex-column custom_nice state_box">
                                <label class="control-label">City</label>
                                <select class="form-control wide" name="seller_city" required="" id="city-list">
                                  <?php if (!empty($login_seller_city)){ ?>
                                    <option selected><?= $login_seller_city; ?></option>
                                  <?php } ?>
                                  
                                </select>
                              </div>
                            </div>
                            <div class="col-12 col-md-6">
                              <div class="form-group d-flex flex-column custom_nice">
                                <label class="control-label">Timezone</label>
                                <select class="form-control wide site_logo_type" name="seller_timezone" required="">
                                  <option>Select timezone</option>
                                  <?php foreach ($timezones as $key => $zone) { ?>
                                    <option <?=($login_seller_timzeone == $zone)?"selected=''":""; ?> value="<?= $zone; ?>"><?= $zone; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group d-flex flex-column">
                                <label class="control-label">Languages</label>
                                <!-- <input type="text" data-role="tagsinput" value="English,German"> -->
                                <select name="seller_language" class="form-control wide" multiple>
                                  <?php if($login_seller_language == 0){ ?>
                                  <option class="hidden"> Select Language </option>
                                  <?php 
                                    $get_languages = $db->select("seller_languages");
                                    while($row_languages = $get_languages->fetch()){
                                    $language_id = $row_languages->language_id;
                                    $language_title = $row_languages->language_title;
                                    ?>
                                  <option value="<?php echo $language_id; ?>"> <?php echo $language_title; ?> </option>
                                  <?php } ?>
                                  <?php }else{ ?>
                                  <?php 
                                    $get_languages = $db->select("seller_languages");
                                    while($row_languages = $get_languages->fetch()){
                                    $language_id = $row_languages->language_id;
                                    $language_title = $row_languages->language_title;
                                    ?>
                                  <option value="<?php echo $language_id; ?>" <?php if($language_id == $login_seller_language){ echo "selected"; } ?>> <?php echo $language_title; ?> </option>
                                  <?php } ?>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group d-flex flex-column">
                                <label class="control-label">tell us a bit about yourself</label>
                                <textarea rows="5" class="form-control" name="seller_about" id="textarea-about" maxlength="300"><?php echo $login_seller_about; ?></textarea>
                                <span class="float-left mt-1">
                                  <span class="count-about"> 0 </span> / 300 MAX
                                </span>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group d-flex flex-row justify-content-end">
                                <button class="button button-white" type="button" role="button">Cancel</button>
                                <button class="button button-red" type="submit" name="submit">Save</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <!-- Row -->
                  </div>
                  <div id="professional_info" class="tab-pane fade ">
                    <!-- Row -->
                    <div class="row">
                      <div class="col-12">
                        <!-- <form method="post" enctype="multipart/form-data" runat="server" autocomplete="off"> -->
                          <div class="row">
                            <div class="col-12">
                              <div class="form-group d-flex flex-column">
                                <label class="control-label">Your Occupation</label>
                                <select class="wide form-control">
                                  <option>Select Your Occupation</option>
                                  <option value="1">Your Occupation 1</option>
                                  <option value="2">Your Occupation 2</option>
                                  <option value="3">Your Occupation 3</option>
                                  <option value="3">Your Occupation 4</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group d-flex flex-row justify-content-end">
                                <button class="add-new" type="button" role="button">
                                  <span><i class="fas fa-plus-circle"></i></span>
                                  <span>Add New</span>
                                </button>
                              </div>
                            </div>
                          </div>
                          <!-- Row -->
                          <div class="row">
                            <div class="col-12">
                              <label class="control-label">Skills</label>
                            </div>
                            <div class="col-12">
                              <ul class="list-unstyled mt-3"><!-- list-unstyled mt-3 Starts -->

                              <?php

                              $select_skills_relation = $db->select("skills_relation",array("seller_id" => $seller_id));

                              while($row_skills_relation = $select_skills_relation->fetch()){
                                
                                $relation_id = $row_skills_relation->relation_id;
                                
                                $skill_id = $row_skills_relation->skill_id;
                                
                                $skill_level = $row_skills_relation->skill_level;
                                
                                
                                $get_skill = $db->select("seller_skills",array("skill_id" => $skill_id));
                                  
                                $row_skill = $get_skill->fetch();
                                
                                $skill_title = $row_skill->skill_title;

                              ?>

                              <li class="card-li mb-1"><!--- card-li mb-1 Starts -->

                              <?php echo $skill_title; ?> - <span class="text-muted"> <?php echo $skill_level; ?> </span>

                              <?php if(isset($_SESSION['seller_user_name'])){ ?>

                              <?php if($login_seller_user_name == $login_username){ ?>

                              <a href="user.php?delete_skill=<?php echo $relation_id; ?>" class="text-danger">
                               <i class="fas fa-trash-alt"></i>
                              </a>

                              <?php } ?>

                              <?php } ?>

                              </li><!--- card-li mb-1 Ends -->

                              <?php } ?>

                              </ul><!-- list-unstyled mt-3 Ends -->
                            </div>
                            <div id="add_skill" class="col-12 collapse">
                              <form method="post">
                                <div class="row">
                                  <div class="col-12 col-md-6">
                                    <div class="form-group d-flex flex-column">
                                      <select class="wide form-control" name="skill_id" required="">
                                        <option value=""> Select Skill </option>
                                        <?php 
                                          $s_skills = array();
                                          $get = $db->select("skills_relation",array("seller_id"=>$login_seller_id));
                                          while($row = $get->fetch()){
                                          array_push($s_skills,$row->skill_id);
                                          }
                                          $s_skills = implode(",", $s_skills);
                                          if(!empty($s_skills)){ $query_where  = "where not skill_id IN ($s_skills)"; }else{ $query_where = ""; }
                                          $get_seller_skills = $db->query("select * from seller_skills $query_where");
                                          while($row_seller_skills = $get_seller_skills->fetch()){
                                          $skill_id = $row_seller_skills->skill_id;
                                          $skill_title = $row_seller_skills->skill_title;
                                        ?>
                                        <option value="<?php echo $skill_id; ?>"> <?php echo $skill_title; ?> </option>
                                      <?php } ?>
                                      </select>
                                      <!-- <input class="form-control" type="text" name="" placeholder="Skills" /> -->
                                    </div>
                                  </div>
                                  <div class="col-12 col-md-6">
                                    <div class="form-group d-flex flex-column">
                                      <select class="wide form-control" name="skill_level">
                                        <option>Experience Level</option>
                                        <option>Beginner</option>
                                        <option>Intermediate</option>
                                        <option>Expert</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group d-flex flex-row justify-content-end">
                                      <button class="button button-white" type="button" data-toggle="collapse" data-target="#add_skill">Cancel</button>
                                      <button class="button button-red" type="submit" name="insert_skill">Save</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                              <?php

                              if(isset($_POST['insert_skill'])){
                                
                              $skill_id = $input->post('skill_id');

                              $skill_level = $input->post('skill_level');
                                
                              $insert_skill = $db->insert("skills_relation",array("seller_id" => $seller_id,"skill_id" => $skill_id,"skill_level" => $skill_level));
                                
                              echo "<script>window.open('edit_profile','_self');</script>";
                                
                              }

                              ?>
                            </div>
                            <div class="col-12">
                              <div class="form-group d-flex flex-row justify-content-end">
                                <button class="add-new" type="button" data-toggle="collapse" data-target="#add_skill">
                                  <span><i class="fas fa-plus-circle"></i></span>
                                  <span>Add New</span>
                                </button>
                              </div>
                            </div>
                          </div>
                          <!-- Row -->
                          <div class="row">
                            <div class="col-12">
                              <label class="control-label">Education</label>
                            </div>
                            <div class="col-12">
                              <ul class="list-unstyled mt-3">
                                <?php 
                                  $get_seller_education = $db->select("seller_education",array("seller_id" => $login_seller_id));
                                  while($row_seller_education = $get_seller_education->fetch()){
                                    $education_id = $row_seller_education->education_id;
                                  $education = @json_decode($row_seller_education->education_data);
                                ?>
                                <li class="card-li mb-1">
                                  <!-- <a class="float-right" onclick="getEducation(<?= $education_id ?>)">
                                   <i class="fas fa-edit"></i>
                                  </a> -->
                                  <a href="edit_profile.php?delete_education=<?php echo $education_id; ?>" class="float-right mr-3 text-danger">
                                   <i class="fas fa-trash-alt"></i>
                                  </a>
                                  Country: <span class="text-muted"><?= $education->country ?></span><br>
                                  Major: <span class="text-muted"><?= $education->major ?></span><br>
                                  Institute: <span class="text-muted"><?= $education->institute ?></span><br>
                                  Year: <span class="text-muted"><?= $education->degree_year ?></span>
                                  </li> <br>
                                <?php }?>
                                </ul>
                              </div>
                            </div>
                            <div id="add_education" class="col-12 collapse">
                              <form method="post">
                                <div class="row">
                                  <div class="col-12 col-md-6">
                                    <div class="form-group d-flex flex-column custom_nice">
                                      <select class="wide form-control" name="country">
                                        <option>Select Country</option>
                                        <?php
                                          $get_countries = $db->select("countries");
                                          while($row_countries = $get_countries->fetch()){
                                            $id = $row_countries->id;
                                            $name = $row_countries->name;
                                            echo "<option value='$name'".($login_seller_country == $name ? "selected" : "").">$name</option>";
                                          }
                                          ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-12 col-md-6">
                                    <div class="form-group d-flex flex-column">
                                      <input class="form-control" type="text" name="institute" placeholder="Institute Name" required="" />
                                    </div>
                                  </div>
                                  <div class="col-12 col-md-6">
                                    <div class="form-group d-flex flex-column">
                                      <input class="form-control" type="text" name="major" placeholder="Major" required="" />
                                      <!-- <select class="wide form-control" name="major">
                                        <option>Major</option>
                                        <option value="1">Major</option>
                                        <option value="2">Major</option>
                                        <option value="3">Major</option>
                                        <option value="3">Major</option>
                                      </select> -->
                                    </div>
                                  </div>
                                  <div class="col-12 col-md-6">
                                    <div class="form-group d-flex flex-column custom_nice">
                                      <select class="wide form-control" name="degree_year"required>
                                        <option value="">Year</option>
                                        <?php 
                                          foreach ($years as $year) {
                                        ?>
                                        <option value="<?= $year ?>"><?= $year?></option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group d-flex flex-row justify-content-end">
                                      <button class="button button-white" type="button"data-toggle="collapse" data-target="#add_education">Cancel</button>
                                      <button class="button button-red" type="submit" name="insert_education">Save</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                              <?php

                              if(isset($_POST['insert_education'])){
                                
                              $country = $input->post('country');
                              $major = $input->post('major');
                              $institute = $input->post('institute');
                              $degree_year = $input->post('degree_year');

                              $educationQry = array('country' => $country, 'major' => $major, 'institute' => $institute, 'degree_year' => $degree_year);
                                
                              
                              $insert_skill = $db->insert("seller_education",array("seller_id" => $seller_id,"education_data" => @json_encode($educationQry)));
                                
                              echo "<script>window.open('edit_profile','_self');</script>";
                                
                              }

                              ?>
                            </div>
                          </div>
                          <!-- Row -->
                            <div class="col-12">
                              <div class="form-group d-flex flex-row justify-content-end">
                                <button class="add-new" type="button"  data-toggle="collapse" data-target="#add_education">
                                  <span><i class="fas fa-plus-circle"></i></span>
                                  <span>Add New</span>
                                </button>
                              </div>
                            </div>
                      </div>
                    </div>
                    <!-- Row -->
                  <!-- </div> -->
                  <div id="account_verification" class="tab-pane fade ">
                    <!-- Row -->
                    <div class="row">
                      <div class="col-12">
                        <div class="profile-verifications">
                          <div class="profile-verification-item d-flex flex-row">
                            <span><i class="fab fa-facebook-f"></i></span>
                            <span>Facebook</span>
                            <span class="ml-auto d-flex flex-row align-items-center facebook">
                              <span><i class="fab fa-facebook-f"></i></span>
                              <span>Connect</span>
                            </span>
                          </div>
                          <div class="profile-verification-item d-flex flex-row">
                            <span><i class="fab fa-linkedin-in"></i></span>
                            <span>LinkedIn</span>
                            <span class="ml-auto d-flex flex-row align-items-center linkedin">
                              <span><i class="fab fa-linkedin-in"></i></span>
                              <span>Connect</span>
                            </span>
                          </div>
                          <div class="profile-verification-item d-flex flex-row">
                            <span><i class="fab fa-google"></i></span>
                            <span>Google</span>
                            <span class="ml-auto d-flex flex-row align-items-center google">
                              <span><i class="fab fa-google"></i></span>
                              <span>Connect</span>
                            </span>
                          </div>
                          <div class="profile-verification-item d-flex flex-row">
                            <span><i class="fas fa-envelope"></i></span>
                            <span>Email</span>
                            <span class="ml-auto d-flex flex-row align-items-center email">
                              <span>Verify</span>
                            </span>
                          </div>
                          <div class="profile-verification-item d-flex flex-row">
                            <span><img alt="" class="img-fluid d-block" src="assets/img/buyer/payment-verified-icon.png" /></span>
                            <span>Payment</span>
                            <span class="ml-auto d-flex flex-row align-items-center payment">
                              <span><i class="fal fa-check"></i></span>
                              <span>Verified</span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Row -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="howitwork-card">
                <div class="howitwork-card-title d-flex align-items-center">Improve Your Profile</div>
                <div class="howitwork-list d-flex flex-column">
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Post a gig" class="img-fluid d-block" src="assets/img/edit-profile/basic-info-icon.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>1. Basic Information</h3>
                      <p>As a seller, you want to complete your profile as detailed as possible. Enter in some basic information to get started on your freelancing career. Endless possibilities await you as a freelancer with eMongez. It all starts with putting in your basic details</p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Get Hired" class="img-fluid d-block" src="assets/img/edit-profile/text-edit-icon.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>2. Professional information</h3>
                      <p>Here is where you want to share your credentials. Let us know how long you have been involved in your industry? Who have you worked for in the past? What special skills do you have? Most importantly, tell us why you are passionate about what you do?</p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Work" class="img-fluid d-block" src="assets/img/edit-profile/verifiy-icon.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>3. Trust and Verification</h3>
                      <p>Develop a strong and credible presence on eMongez through verifying your seller profile. Simply connect it to your other social media profiles to enjoy more offers and the best engagements eMongez has to offer.</p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                </div>
              </div>
              <!-- How it work -->
            </div>
          </div>
        </div>
      </div>
      <!-- Row -->
    </section>
  </main>

<!-- <div class="container-fluid mt-5 mb-5">
  <div class="row terms-page" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
    <div class="col-md-3 mb-3">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-pills flex-column mt-2">
            <li class="nav-item">
            <a data-toggle="pill" href="#profile_settings" class="nav-link
            <?php
            if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){
            echo "active";
            }
            if(isset($_GET['profile_settings'])){ echo "active"; }
            ?>">
            <?php echo $lang["titles"]["settings"]["profile_settings"]; ?>
            </a>
            </li>
            <li class="nav-item">
              <a data-toggle="pill" href="#account_settings" class="nav-link
              <?php
                if(isset($_GET['account_settings'])){
                  echo "active";
                }
              ?>
              ">
               <?php echo $lang["titles"]["settings"]["account_settings"]; ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <div class="tab-content">
          <div id="profile_settings" class="tab-pane fade <?php if(!isset($_GET['profile_settings']) and !isset($_GET['account_settings'])){ echo "show active"; } if(isset($_GET['profile_settings'])){ echo "show active"; } ?>">
            <h2 class="mb-4"><?php echo $lang["titles"]["settings"]["profile_settings"]; ?></h2>
            <?php //require_once("profile_settings.php") ?>
          </div>
          <div id="account_settings" class="tab-pane fade <?php if(isset($_GET['account_settings'])){ echo "show active"; } ?>">
            <h2 class="mb-4"><?php echo $lang["titles"]["settings"]["account_settings"]; ?></h2>
            <?php //require_once("account_settings.php") ?>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<div id="insertimageModal" class="modal" role="dialog">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Image <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="image_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type" value="">
      <button class="btn crop_image">Crop Image</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div id="insertCoverModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Cover <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="cover_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type_cover" value="">
      <button class="btn crop_image_cover">Crop Image</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div id="wait"></div>
<script>
  $('#verification_tab').click(function(){
    $('#account_verification').addClass('show active');
    $('#profile_settings').removeClass('show active');
    $('#professional_info').removeClass('show active');
    $('#verification_tab').addClass('active');
  });
  $('#profile_tab').click(function(){
    $('#account_verification').removeClass('show active');
    $('#professional_info').removeClass('show active');
    $('#profile_settings').addClass('show active');
    $('#verification_tab').removeClass('active');
    $('#professional_tab').removeClass('active');
  });
  $('#professional_tab').click(function(){
    $('#account_verification').removeClass('show active');
    $('#profile_settings').removeClass('show active');
    $('#professional_info').addClass('show active');
    $('#professional_tab').addClass('active');
    $('#verification_tab').removeClass('active');
  });
  function getState(val) {
    $.ajax({
      type: "POST",
      url: "get-state",
      data:'country_name='+val,
      beforeSend: function() {
        $("#state-list").addClass("loader");
      },
      success: function(data){
        // console.log(data);
        $("#state-list").html(data);
        $('#city-list').find('option[value]').remove();
        $("#state-list").removeClass("loader");
      }
    });
  }
  function getCity(val) {
    // alert(val);
    $.ajax({
      type: "POST",
      url: "get-city",
      data:'state_name='+val,
      beforeSend: function() {
        $("#city-list").addClass("loader");
      },
      success: function(data){
        $("#city-list").html(data);
        $("#city-list").removeClass("loader");
      }
    });
  }
</script>
<script>
  $(document).ready(function(){
  $image_crop = $('#image_demo').croppie({
      enableExif: true,
      viewport: {
        width:200,
        height:200,
        type:'square' //circle
      },
      boundary:{
        width:100,
        height:250
      }    
      });
    function crop(data){
      var reader = new FileReader();
      reader.onload = function (event) {
        $image_crop.croppie('bind',{
        url: event.target.result
        }).then(function(){
        console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(data.files[0]);
      $('#insertimageModal').modal('show');
      $('input[type=hidden][name=img_type]').val($(data).attr('name'));
    }
    $(document).on('change','input[type=file]:not(#cover)', function(){
    var size = $(this)[0].files[0].size; 
    var ext = $(this).val().split('.').pop().toLowerCase();
    if($.inArray(ext,['jpeg','jpg','gif','png']) == -1){
    alert('Your File Extension Is Not Allowed.');
    $(this).val('');
    }else{
    crop(this);
    }
    });
    $('.crop_image').click(function(event){
      var getUrl = '<?php echo $site_url; ?>';
    $('#wait').addClass("loader");
    var name = $('input[type=hidden][name=img_type]').val();
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response){
        $.ajax({
          url:"crop_upload",
          type: "POST",
          data:{image: response, name: $('input[type=file][name='+ name +']').val().replace(/C:\\fakepath\\/i, '') },
          success:function(data){
            $('#wait').removeClass("loader");
            $('#insertimageModal').modal('hide');
            $('input[type=hidden][name='+ name +']').val(data);
            main = $('input[type=hidden][name='+ name +']').parent();
            main.prepend("<img src='user_images/"+data+"' class='img-fluid'>");
            $('.img-circle').hide();
          }
        });
      });
      });

    // Cover Image Crop
    $image_crop_cover = $('#cover_demo').croppie({
        enableExif: true,
        viewport: {
          width:796,
          height:280,
          type:'square' //circle
        },
        boundary:{
          width:100,
          height:250
        }    
        });
      function crop_cover(data){
        var reader = new FileReader();
        reader.onload = function (event) {
          $image_crop_cover.croppie('bind',{
          url: event.target.result
          }).then(function(){
          console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(data.files[0]);
        $('#insertCoverModal').modal('show');
        $('input[type=hidden][name=img_type_cover]').val($(data).attr('name'));
      }
      $(document).on('change','input[type=file]:not(#profile-image)', function(){
        
      var size = $(this)[0].files[0].size; 
      var ext = $(this).val().split('.').pop().toLowerCase();
      if($.inArray(ext,['jpeg','jpg','gif','png']) == -1){
      alert('Your File Extension Is Not Allowed.');
      $(this).val('');
      }else{
      crop_cover(this);
      }
      });
      $('.crop_image_cover').click(function(event){
        var getUrl = '<?php echo $site_url; ?>';
      $('#wait').addClass("loader");
      var name = $('input[type=hidden][name=img_type_cover]').val();
        $image_crop_cover.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){
          $.ajax({
            url:"crop_upload_cover",
            type: "POST",
            data:{image: response, name: $('input[type=file][name='+ name +']').val().replace(/C:\\fakepath\\/i, '') },
            success:function(data){
              $('#wait').removeClass("loader");
              $('#insertCoverModal').modal('hide');
              $('input[type=hidden][name='+ name +']').val(data);
              main = $('input[type=hidden][name='+ name +']').parent();
              main.prepend("<img src='cover_images/"+data+"' class='img-fluid'>");
            }
          });
        });
        });
        $('.remove').click(function(){
          $('.cover_pic').remove();
          $('.remove').hide();
        });
    $("#textarea-headline").keydown(function(){
      var textarea_headline = $("#textarea-headline").val();
      $(".count-headline").text(textarea_headline.length);  
    });
    $("#textarea-about").keydown(function(){
      var textarea_about = $("#textarea-about").val();
      $(".count-about").text(textarea_about.length);
    });

    

  });

function getEducation(educationId){
      alert(educationId);
        $.ajax({
            url: "edit_education?edit_edu="+educationId,
            success: function(response){
              console.log(response);
                var obj = $.parseJSON(response);
                $('.form-academic input[name="resumeId"]').val(resumeId);
                $('.form-academic select[name="degreeLevel"]').val(obj.degreeLevel).trigger('change');
                $('.form-academic input[name="degree"]').val(obj.degree);
                $('.form-academic input[name="completionDate"]').val(obj.completionDate);
                $('.form-academic input[name="grade"]').val(obj.grade);
                $('.form-academic input[name="institution"]').val(obj.institution);
                $('.form-academic select[name="country"]').val(obj.country).trigger('change');
                $('.form-academic textarea[name="details"]').val(obj.details);
                $('#academic-edit h4 c').text('Edit Academics');
                $('#academic').hide();
                $('#academic-edit').fadeIn();
            }
        })
    }
</script>
<?php
  if(isset($_POST['submit'])){
    $rules = array(
    "seller_name" => "required",
    "seller_email" => "required",
    "seller_country" => "required",
    "seller_language" => "required");

    $messages = array("seller_name" => "Full Name Is required.","seller_email" => "Email Is Required.","seller_country"=>"Country Is Required.","seller_language"=>"Main Conversational Language Is Required.");
    $val = new Validator($_POST,$rules,$messages);
    if($val->run() == false){
      Flash::add("form_errors",$val->get_all_errors());
      Flash::add("form_data",$_POST);
      echo "<script> window.open('settings?profile_settings','_self');</script>";
    }else{
      $seller_name = strip_tags($input->post('seller_name'));
      $seller_email = strip_tags($input->post('seller_email'));
      $seller_country = strip_tags($input->post('seller_country'));
      $seller_state = strip_tags($input->post('seller_state'));
      $seller_city = strip_tags($input->post('seller_city'));
      $seller_timezone = strip_tags($input->post('seller_timezone'));
      $seller_language = strip_tags($input->post('seller_language'));
      $seller_headline = strip_tags($input->post('seller_headline'));
      $seller_about = strip_tags($input->post('seller_about'));
      $profile_photo = strip_tags($input->post('profile_photo'));
      $cover_photo = strip_tags($input->post('cover_photo'));
      // $cover_photo = $_FILES['cover_photo']['name'];
      // $cover_photo_tmp = $_FILES['cover_photo']['tmp_name'];
      // $allowed = array('jpeg','jpg','gif','png','tif');
      // $cover_file_extension = pathinfo($cover_photo, PATHINFO_EXTENSION);
      // if(!in_array($cover_file_extension,$allowed) & !empty($cover_photo)){
      //   echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
      // }else{
        if(empty($profile_photo)){
          $profile_photo = $login_seller_image;
        }
        if(empty($cover_photo)){
          $cover_photo = $login_seller_cover_image;
        }else{
          // $cover_photo = pathinfo($cover_photo, PATHINFO_FILENAME);
          // $cover_photo = $cover_photo."_".time().".$cover_file_extension";
        }
        // move_uploaded_file($cover_photo_tmp,"cover_images/$cover_photo");
        
        $update_proposals = $db->update("proposals",array("language_id" => $seller_language),array("proposal_seller_id" => $login_seller_id));

        $sel_languages_relation = $db->query("select * from languages_relation where seller_id='$login_seller_id' and language_id='$seller_language'");
        $count_languages_relation = $sel_languages_relation->rowCount();

        if($count_languages_relation == 0){
          $insert_language = $db->insert("languages_relation",array("seller_id"=>$login_seller_id,"language_id"=>$seller_language,"language_level"=>'conversational'));
        }

        // if email changed
        if($seller_email != $login_seller_email){
          $verification_code = mt_rand();
        }elseif($seller_email == $login_seller_email){
          $verification_code = $login_seller_verification;
        }

        $update_seller = $db->update("sellers",array("seller_name"=>$seller_name,"seller_email"=>$seller_email,"seller_image"=>$profile_photo,"seller_cover_image"=>$cover_photo,"seller_country"=>$seller_country,"seller_state"=>$seller_state,"seller_city"=>$seller_city,"seller_timezone"=>$seller_timezone,"seller_headline"=>$seller_headline,"seller_about"=>$seller_about,"seller_language"=>$seller_language,"seller_verification"=>$verification_code),array("seller_id"=>$login_seller_id));
        
        if($update_seller){
          if (($seller_email == $login_seller_email) or ($seller_email != $login_seller_email and userConfirmEmail($seller_email))){
            echo "<script>
            swal({
            type: 'success',
            text: 'Profile settings updated successfully!',
            timer: 3000,
            onOpen: function(){
              swal.showLoading()
            }
            }).then(function(){
                // Read more about handling dismissals
                // window.open('edit_profile','_self');
                $('#account_verification').removeClass('show active');
                $('#profile_settings').removeClass('show active');
                $('#professional_info').addClass('show active');
                $('#professional_tab').addClass('active');
                $('#verification_tab').removeClass('active');
            });
            
            </script>";
          }
        }
      // }
    }
  }

  if(isset($_POST['submit_info'])){
    $rules = array(
    "seller_name" => "required",
    "seller_email" => "required",
    "seller_country" => "required",
    "seller_language" => "required");

    $messages = array("seller_name" => "Full Name Is required.","seller_email" => "Email Is Required.","seller_country"=>"Country Is Required.","seller_language"=>"Main Conversational Language Is Required.");
    $val = new Validator($_POST,$rules,$messages);
    if($val->run() == false){
      Flash::add("form_errors",$val->get_all_errors());
      Flash::add("form_data",$_POST);
      echo "<script> window.open('settings?profile_settings','_self');</script>";
    }else{
      $seller_name = strip_tags($input->post('seller_name'));
      $seller_email = strip_tags($input->post('seller_email'));
      $seller_country = strip_tags($input->post('seller_country'));
      $seller_state = strip_tags($input->post('seller_state'));
      $seller_city = strip_tags($input->post('seller_city'));
      $seller_timezone = strip_tags($input->post('seller_timezone'));
      $seller_language = strip_tags($input->post('seller_language'));
      $seller_headline = strip_tags($input->post('seller_headline'));
      $seller_about = strip_tags($input->post('seller_about'));
      $profile_photo = strip_tags($input->post('profile_photo'));
      $cover_photo = strip_tags($input->post('cover_photo'));
      // $cover_photo = $_FILES['cover_photo']['name'];
      // $cover_photo_tmp = $_FILES['cover_photo']['tmp_name'];
      // $allowed = array('jpeg','jpg','gif','png','tif');
      // $cover_file_extension = pathinfo($cover_photo, PATHINFO_EXTENSION);
      // if(!in_array($cover_file_extension,$allowed) & !empty($cover_photo)){
      //   echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
      // }else{
        if(empty($profile_photo)){
          $profile_photo = $login_seller_image;
        }
        if(empty($cover_photo)){
          $cover_photo = $login_seller_cover_image;
        }else{
          // $cover_photo = pathinfo($cover_photo, PATHINFO_FILENAME);
          // $cover_photo = $cover_photo."_".time().".$cover_file_extension";
        }
        // move_uploaded_file($cover_photo_tmp,"cover_images/$cover_photo");
        
        $update_proposals = $db->update("proposals",array("language_id" => $seller_language),array("proposal_seller_id" => $login_seller_id));

        $sel_languages_relation = $db->query("select * from languages_relation where seller_id='$login_seller_id' and language_id='$seller_language'");
        $count_languages_relation = $sel_languages_relation->rowCount();

        if($count_languages_relation == 0){
          $insert_language = $db->insert("languages_relation",array("seller_id"=>$login_seller_id,"language_id"=>$seller_language,"language_level"=>'conversational'));
        }

        // if email changed
        if($seller_email != $login_seller_email){
          $verification_code = mt_rand();
        }elseif($seller_email == $login_seller_email){
          $verification_code = $login_seller_verification;
        }

        $update_seller = $db->update("sellers",array("seller_name"=>$seller_name,"seller_email"=>$seller_email,"seller_image"=>$profile_photo,"seller_cover_image"=>$cover_photo,"seller_country"=>$seller_country,"seller_state"=>$seller_state,"seller_city"=>$seller_city,"seller_timezone"=>$seller_timezone,"seller_headline"=>$seller_headline,"seller_about"=>$seller_about,"seller_language"=>$seller_language,"seller_verification"=>$verification_code),array("seller_id"=>$login_seller_id));
        
        if($update_seller){
          if (($seller_email == $login_seller_email) or ($seller_email != $login_seller_email and userConfirmEmail($seller_email))){
            echo "<script>
            swal({
            type: 'success',
            text: 'Profile settings updated successfully!',
            timer: 3000,
            onOpen: function(){
              swal.showLoading()
            }
            }).then(function(){
                // Read more about handling dismissals
                // window.open('edit_profile','_self');
                $('#account_verification').removeClass('show active');
                $('#profile_settings').removeClass('show active');
                $('#professional_info').addClass('show active');
                $('#professional_tab').addClass('active');
                $('#verification_tab').removeClass('active');
            });
            
            </script>";
          }
        }
      // }
    }
  }
  if(isset($_GET['delete_education'])){
    $delete_education_id = $input->get('delete_education');
    $delete_education = $db->delete("seller_education",array("education_id"=>$delete_education_id,"seller_id"=>$login_seller_id));
    if($delete_education->rowCount() == 1){
      echo "<script>alert('One Education has been deleted.')</script>";
      echo "<script> window.open('edit_profile','_self') </script>";
    }else{
      echo "<script> window.open('edit_profile','_self') </script>";
    }
  }
?>
<?php require_once("includes/footer.php"); ?>
</body>
</html>