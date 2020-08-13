<?php
session_start();
require_once("../includes/db.php");
// if(!isset($_SESSION['email'])){
// echo "<script>window.open('../login','_self')</script>";
// }
$user_email = $_SESSION['email'];
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_level = $row_login_seller->seller_level;
$login_seller_language = $row_login_seller->seller_language;
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <!--====== Required meta tags ======-->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--====== Title ======-->
  <title><?php echo $site_name; ?> - Post a Gigs</title>
  <!--====== Favicon Icon ======-->
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <!-- ==============Google Fonts============= -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
  <!--====== Bootstrap css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
  <!-- <link href="../styles/styles.css" rel="stylesheet"> -->
  <!-- <link href="../styles/user_nav_styles.css" rel="stylesheet">
  <link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../styles/owl.carousel.css" rel="stylesheet">
  <link href="../styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="../styles/tagsinput.css" rel="stylesheet" >
  <link href="../styles/sweat_alert.css" rel="stylesheet">
  <link href="../styles/animate.css" rel="stylesheet">
  <link href="../styles/croppie.css" rel="stylesheet">
  <link href="../styles/create-proposal.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="../js/ie.js"></script>
  <script type="text/javascript" src="../js/sweat_alert.js"></script>
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/croppie.js"></script>
  <script src="https://checkout.stripe.com/checkout.js"></script>
  <style>
    .gig-category-item{
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-flex-basis: 100%;
      -ms-flex-preferred-size: 100%;
      flex-basis: 100%;
      -webkit-box-pack: justify;
      -webkit-justify-content: space-between;
      -moz-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      max-width: 100%;
      margin: 0;
      -webkit-flex-basis: -webkit-calc(100% - 10px) !important;
      -ms-flex-preferred-size: calc(100% - 10px) !important;
      flex-basis: -moz-calc(100% - 10px) !important;
      flex-basis: calc(100% - 10px) !important;
      max-width: -webkit-calc(100% - 10px) !important;
      max-width: -moz-calc(100% - 10px) !important;
      max-width: calc(100% - 10px) !important;
    }
    .gig-category-select{
      -webkit-flex-basis: -webkit-calc(100% - 10px);
      -ms-flex-preferred-size: calc(100% - 10px);
      flex-basis: -moz-calc(100% - 10px);
      flex-basis: calc1050% - 10px);
      max-width: -webkit-calc(100% - 10px);
      max-width: -moz-calc(100% - 10px);
      max-width: calc(100% - 10px);
    }
    .cat_item-content{
      -webkit-flex-basis: -webkit-calc(50% - 10px) !important;
      -ms-flex-preferred-size: calc(50% - 10px) !important;
      flex-basis: -moz-calc(50% - 10px) !important;
      flex-basis: calc(50% - 10px) !important;
      max-width: -webkit-calc(50% - 10px) !important;
      max-width: -moz-calc(50% - 10px) !important;
      max-width: calc(50% - 10px) !important;
    }
    .cat_item-content.item-active .gig-category-select {
      -webkit-flex-basis: -webkit-calc(50% - 10px);
      -ms-flex-preferred-size: calc(50% - 10px);
      flex-basis: -moz-calc(50% - 10px);
      flex-basis: calc(100% - 0px);
      max-width: -webkit-calc(50% - 10px);
      max-width: -moz-calc(50% - 10px);
      max-width: calc(100% - 0px);
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-active {
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-flex-basis: 100%;
      -ms-flex-preferred-size: 100%;
      flex-basis: 100%;
      -webkit-box-pack: justify;
      -webkit-justify-content: space-between;
      -moz-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
      max-width: 100%;
      margin: 0;
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-select {
        -webkit-flex-basis: -webkit-calc(100% - 10px);
        -ms-flex-preferred-size: calc(100% - 10px);
        flex-basis: -moz-calc(100% - 10px);
        flex-basis: calc(100% - 10px);
        max-width: -webkit-calc(100% - 10px);
        max-width: -moz-calc(100% - 10px);
        max-width: calc(100% - 10px);
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-tags {
        -webkit-flex-basis: -webkit-calc(50% - 10px);
        -ms-flex-preferred-size: calc(50% - 10px);
        flex-basis: -moz-calc(50% - 10px);
        flex-basis: calc(50% - 10px);
        margin-bottom: 20px;
        height: auto;
        max-width: -webkit-calc(50% - 10px);
        max-width: -moz-calc(50% - 10px);
        max-width: calc(50% - 10px);
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-removed {
        display: none;
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .backto-main {
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
    }
    .bootstrap-tagsinput{
      line-height: 40px;
    }
    #next{
      background-color: #ff0707;
      border: 2px solid #ff0707;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      line-height: 45px;
      height: 60px;
      text-transform: uppercase;
      -webkit-transition: all 0.3s ease-in-out 0s;
      -o-transition: all 0.3s ease-in-out 0s;
      -moz-transition: all 0.3s ease-in-out 0s;
      transition: all 0.3s ease-in-out 0s;
      width: 250px;
    }
    .header-top{
      background-color: #fff;
    }
    @media(max-width: 768px){
      .gig-category-item{
        -webkit-flex-basis: -webkit-calc(100% - 0px) !important;
        -ms-flex-preferred-size: calc(100% - 0px) !important;
        flex-basis: -moz-calc(100% - 0px) !important;
        flex-basis: calc(100% - 0px) !important;
        max-width: -webkit-calc(100% - 0px) !important;
        max-width: -moz-calc(100% - 0px) !important;
        max-width: calc(100% - 0px) !important;
      }
      .gig-category-select{
        -webkit-flex-basis: -webkit-calc(100% - 0px);
        -ms-flex-preferred-size: calc(100% - 0px);
        flex-basis: -moz-calc(100% - 0px);
        flex-basis: calc(100% - 0px);
        max-width: -webkit-calc(100% - 0px);
        max-width: -moz-calc(100% - 0px);
        max-width: calc(100% - 0px);
      }
      .cat_item-content{
        -webkit-flex-basis: -webkit-calc(100% - 0px) !important;
        -ms-flex-preferred-size: calc(100% - 0px) !important;
        flex-basis: -moz-calc(100% - 10px) !important;
        flex-basis: calc(100% - 0px) !important;
        max-width: -webkit-calc(100% - 0px) !important;
        max-width: -moz-calc(100% - 0px) !important;
        max-width: calc(100% - 0px) !important;
      }
      .cat_item-content.item-active .gig-category-select {
        -webkit-flex-basis: -webkit-calc(100% - 0px);
        -ms-flex-preferred-size: calc(100% - 0px);
        flex-basis: -moz-calc(100% - 0px);
        flex-basis: calc(100% - 0px);
        max-width: -webkit-calc(100% - 0px);
        max-width: -moz-calc(100% - 0px);
        max-width: calc(100% - 0px);
      }
      .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-select {
        -webkit-flex-basis: -webkit-calc(100% - 0px);
        -ms-flex-preferred-size: calc(100% - 0px);
        flex-basis: -moz-calc(100% - 0px);
        flex-basis: calc(100% - 0px);
        max-width: -webkit-calc(100% - 0px);
        max-width: -moz-calc(100% - 0px);
        max-width: calc(100% - 0px);
      }
      .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-tags {
        -webkit-flex-basis: -webkit-calc(100% - 0px);
        -ms-flex-preferred-size: calc(100% - 0px);
        flex-basis: -moz-calc(100% - 0px);
        flex-basis: calc(100% - 0px);
        max-width: -webkit-calc(100% - 0px);
        max-width: -moz-calc(100% - 0px);
        max-width: calc(100% - 0px);
      }
    }
  </style>
</head>

<body class="all-content">

  <!-- Preloader Start -->
  <div class="proloader">
        <div class="loader">
            <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
        </div>
    </div>
  <!-- Preloader End -->
  <!-- Header -->
  <header>
    <!-- Post a gig header -->
    <section class="container-fluid header-top post-gig">
      <div class="row">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-md-3 col-lg-2 d-flex flex-row justify-content-center">
              <div class="logo <?php if(isset($_SESSION["seller_user_name"])){echo"loggedInLogo";} ?>">
                <a href="javascript:void(0);">
                  <?php if($site_logo_type == "image"){ ?>
                  <img src="<?= $site_url; ?>/images/<?= $site_logo_image; ?>" alt="" width="150">
                  <?php }else{ ?>
                  <?php echo $site_logo_text; ?>
                  <?php } ?>
                </a>
              </div>
            </div>
            <div class="col-12 col-md-9 col-lg-10">
              <ul class="list-inline d-flex flex-row align-items-center justify-content-center justify-content-md-start post-gig-step">
                <li class="list-inline-item post-gig-step-item d-flex flex-row align-items-center active">
                  <span class="icon">1</span>
                  <span class="text">انضم</span>
                </li>
                <li class="list-inline-item post-gig-step-item d-flex flex-row align-items-center">
                  <i class="fal fa-angle-right"></i>
                </li>
                <li class="list-inline-item post-gig-step-item d-flex flex-row align-items-center active" id="post">
                  <span class="icon">2</span>
                  <span class="text">انشر</span>
                </li>
                <li class="list-inline-item post-gig-step-item d-flex flex-row align-items-center">
                  <i class="fal fa-angle-right"></i>
                </li>
                <li class="list-inline-item post-gig-step-item d-flex flex-row align-items-center" id="publish_tab">
                  <span class="icon">3</span>
                  <span class="text">تفعيل</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Post a gig header end -->
  </header>
  <!-- Header END-->
  <!-- Main content -->
  <main>
    <form action="" method="post">
      
    <div class="tab-content">
      <div class="tab-pane fade show active" id="post_gig">
        <section class="container-fluid postagig">
          <div class="row">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <h2>نشر الخدمة</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-lg-8">
                  <div class="row">
                    <div class="col-12 col-md-8">
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
                      <?php } ?>
                      <div class="create-gig proposal-form form-field">
                        <div class="form-group">
                          <label class="control-label d-flex flex-row align-items-center">
                            <span>
                              <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/create-gig-icon.png" />
                            </span>
                            <span>ما الذي يمكنك عمل ؟</span>
                          </label>
                          <input class="form-control" type="text" id="proposal_title" name="proposal_title" placeholder="I can..." required="" />
                          <span class="form-text text-danger" id="title_error">يجب أن تكتب عنوان أزعج</span>
                          <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_description']); ?></small>
                          <!-- <label class="bottom-label text-right"><span class="descCount">0</span>/2500 Chars Max</label> -->
                          <div class="popup">
                            <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
                            <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                            <p>عشان تجذب المشاهدين، لازم تحط عنوان جذاب. استخدامك شوية كلمات معروفة في العنوان بتاعك هيخلي خدماتك تبقا واضحة و بارزة في عيون المشترين. قبل ما تكتب العنوان، ابحث شوية عن أفضل الكلمات الرئيسية بالنسبة للأداء في مجالك و دة هيساعدك تكتب عنوان مميز و جذاب.</p>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label d-flex flex-row align-items-center">
                            <span>
                              <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/price-icon.png" />
                            </span>
                            <span>السعر ؟</span>&nbsp;<small>(الرجاء إدخال المبلغ EGP)</small>
                          </label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <select class="form-control">
                                <!-- <option value="1">USD</option> -->
                                <option value="2">EGP</option>
                              </select>
                            </div>
                            <input class="form-control" type="text" id="proposal_price" name="proposal_price" min="0" required="" />
                          </div>
                          <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_price']); ?></span>
                          <span class="form-text text-danger" id="price_error">يجب عليك كتابة السعر</span>
                          <div class="popup">
                            <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
                            <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                            <p>
                                حدد ميزانية مناسبة لجودة وكمية الشغل اللى بتنتجه.
                                وصل توقعات ميزانيتك لمشترينك بشكل واضح من الأول ولحد ما تخلص الأوردر بتاعك
                            </p>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label d-flex flex-row align-items-center">
                            <span>
                              <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/category-icon.png" />
                            </span>
                            <span>اختر الفئة</span>
                          </label>
                          <div class="gig-category d-flex flex-wrap align-items-start">
                            <?php 
                              $get_cats = $db->select("categories");
                              while($row_cats = $get_cats->fetch()){
                              
                              $cat_id = $row_cats->cat_id;
                              $cat_icon = $row_cats->cat_icon;
                              $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
                              $row_meta = $get_meta->fetch();
                              $cat_title = $row_meta->cat_title;
                              $arabic_title = $row_meta->arabic_title;
                            ?>

                            <div class="gig-category-item">
                              <?php
                                $get_cats = $db->select("categories");
                                while($row_cats = $get_cats->fetch()){
                                $cat_id = $row_cats->cat_id;
                                $cat_image = $row_cats->cat_image;
                                $cat_icon = $row_cats->cat_icon;

                                $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
                                $row_meta = $get_meta->fetch();
                                $cat_title = $row_meta->cat_title;
                                $arabic_title = $row_meta->arabic_title;
                                if($cat_id == 1){
                                $cat_class= "gd";
                                }elseif ($cat_id == 2) {
                                  $cat_class = "dm";
                                }elseif ($cat_id == 3) {
                                  $cat_class = "wt";
                                }elseif ($cat_id == 4) {
                                  $cat_class = "va";
                                }elseif ($cat_id == 7) {
                                  $cat_class = "ma";
                                }elseif ($cat_id == 6) {
                                  $cat_class = "pt";
                                }elseif($cat_id == 8){
                                  $cat_class= "va";
                                }else{
                                  $cat_class= "ma";
                                }
                                ?>
                                <div class="cat_item-content" data-id="<?= $cat_class; ?>">
                                  <div class="gig-category-select <?php echo $cat_class; ?> d-flex flex-column align-items-center justify-content-between" onclick="categoryItem(<?= $cat_id; ?>);">
                                    
                                    <label for="categoryItem-<?= $cat_id; ?>" class="d-flex flex-column align-items-center justify-content-between">
                                      <input id="categoryItem-<?= $cat_id; ?>" class="cat_value" value="<?= $cat_id; ?>" type="radio" name="proposal_cat_id" hidden required />
                                      <span class="icon">
                                          <img class="img-fluid white-icon" src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" width="75" height="75" />
                                          <img class="img-fluid color-icon" src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" width="75" height="75" />
                                      </span>
                                      <span class="text"><?= $arabic_title; ?></span>
                                    </label>
                                  </div>
                                </div>
                              <?php } ?>

                              <!-- <select class="form-control" name="child_id" required="" style="display: none;">
                                
                              </select> -->
                              <div class="gig-category-tags"  id="sub-category" style="display: none;">
                                
                              </div>
                              <div class="backto-main flex-row">
                                  <a href="javascript:void(0)" class="d-flex flex-row align-items-center">
                                      <span>
                                          <i class="fal fa-angle-left"></i>
                                      </span>
                                      <span>عد</span>
                                  </a>
                              </div>
                            </div>
                          <?php } ?>
                          <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_cat_id']); ?></span>
                          <span class="form-text text-danger" id="category_error">تحتاج إلى تحديد الفئة</span>
                            <!-- Each item -->
                          </div>
                          <div class="popup">
                            <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
                            <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                            <p>
                            لو اخترت الفئة و الفئة الفرعية ليهم صلة بالخدمات اللي بتقدمها، هيبقا عندك  أفضل فرصة ممكنة إنك تأمن المشترين. إذا قدمت خدمات توصل لفئات مختلفة هتقدر تنوع خدماتك و يبقا عندك مجموعات كتيرة
                            </p>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label d-flex flex-row align-items-center">
                            <span>
                              <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/document-icon.png" />
                            </span>
                            <span>ماذا تريد من المشتري للبدأ؟</span>
                          </label>
                          <textarea rows="6" id="proposal_desc" class="form-control text-count" name="buyer_instruction" placeholder="I need...." required=""></textarea>
                          <label class="bottom-label text-right"><span class="descCount">0</span>/2500 حرف بحد اقصى</label>
                          <span class="form-text text-danger" id="desc_error">تحتاج إلى كتابة وصف</span>
                          <div class="d-flex flex-column">
                            <label class="bottom-label">
                              نوع الإجابة :
                            </label>
                            <div class="d-flex flex-row mt-10 mb-10">
                              <select class="form-control wide" name="answer_type">
                                <option value="Free Text">كتابة حرة</option>
                                <option value="Attachment">نص مركب</option>
                              </select>
                            </div>
                            <div class="d-flex flex-row">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="answer_mandatory">
                                <label class="custom-control-label" for="customCheck1">
                                  إجابة أجبارية
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="popup">
                            <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
                            <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                            <p>
                                حط شوية طلبات خاصة بالخدمة للمشترين قبل ما يحصلوا عليها عشان تضمن إن معاك المعلومات الضرورية قبل ما تبدأ تشتغل على مشروعك. اختار من بين مجالات الكتابة الحرة و كمان مجالات الملفات المرفقة عشات تكمل الخدمة للمشترين.
                            </p>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label d-flex flex-row align-items-center">
                            <span>
                              <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/passage-of-time.png" />
                            </span>
                            <span>متي سيتم تسليم العمل ؟</span>
                          </label>
                          <div class="deliver-time d-flex flex-wrap">
                            <?php
                            $get_delivery_times = $db->select("delivery_times",array("type" => ''));
                            while($row_delivery_times = $get_delivery_times->fetch()){
                            $delivery_id = $row_delivery_times->delivery_id;
                            $delivery_proposal_title_arabic = $row_delivery_times->delivery_proposal_title_arabic;
                            ?>
                            <label class="deliver-time-item" for="hours<?php echo $delivery_id; ?>">
                              <input id="hours<?php echo $delivery_id; ?>" type="radio" name="delivery_id" value="<?php echo $delivery_id; ?>" hidden />
                              <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
                                <span class="color-icon">
                                  <span>-</span>
                                  <span>+</span>
                                </span>
                                <span class="d-flex flex-row align-items-end time">
                                  <span><?php echo $delivery_proposal_title_arabic; ?></span>
                                  <!-- <span>HRS</span> -->
                                </span>
                              </div>
                            </label>
                            <?php } ?>
                            <label class="deliver-time-item" for="days30">
                              <input id="days30" type="radio" name="custom_delivery" hidden  />
                              <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
                                <span class="color-icon">
                                  <span>-</span>
                                  <span>+</span>
                                </span>
                                <span class="d-flex flex-row align-items-end time">
                                  <span>مخصص</span>
                                  <input autofocus="autofocus" class="input-number" pattern="[0-9]{2}" maxlength="2" type="text" />
                                </span>
                              </div>
                            </label>
                          </div>
                          <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['delivery_id']); ?></small>
                          <span class="form-text text-danger" id="time_error">يرجى تحديد أو إدخال الوقت</span>
                          <div class="popup">
                            <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
                            <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                            <p>
                                حدد مواعيد نهائية واقعية للشغل اللى بتنتجه. ممكن دايما تعدل الميعاد النهائى لتسليم شغلك. يُرجى انك تخلى المشترى يعرف لو اخترت تعمل كدة
                            </p>
                          </div>
                        </div>
                        <!--- form-group row Ends --->
                        <?php if($enable_referrals == "yes"){ ?>
                        <div class="form-group d-none">
                          <div class="d-flex flex-column">
                            <!--- form-group row Starts --->
                            <label class="bottom-label">تمكين الإحالات: </label>
                            <div class="d-flex flex-row mt-10 mb-10">
                              <select name="proposal_enable_referrals" class="proposal_enable_referrals form-control wide">
                                <?php if(@$form_data['proposal_enable_referrals'] == "yes"){ ?>
                                <option value="yes"> Yes </option>
                                <option value="no"> No </option>
                                <?php }else{ ?>
                                <option value="no"> No </option>
                                <option value="yes"> Yes </option>
                                <?php } ?>
                              </select>
                            </div>
                              <small>في حالة التمكين ، يمكن للمستخدمين الآخرين الترويج لاقتراحك من خلال مشاركته على منصات مختلفة.</small>
                              <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_enable_referrals']); ?></small>
                          </div>
                        </div>
                        <!--- form-group row Ends --->
                        <div class="form-group proposal_referral_money d-none">
                          <div class="d-flex flex-column">
                            <!--- form-group row Starts --->
                            <label class="bottom-label">لجنة الترويج: </label>
                            <!-- <div class="d-flex flex-row mt-10 mb-10"> -->
                              <input type="number" name="proposal_referral_money" class="form-control" min="1" value="<?php echo @$form_data['proposal_referral_money']; ?>" placeholder="Figure should be in percentage e.g 20">
                              <small>يجب أن يكون الرقم بالنسبة المئوية. على سبيل المثال 20 هو نفس 20٪ من بيع هذا الاقتراح.</small>
                              <br>
                              <small> عندما يروج مستخدم آخر لاقتراحك ، كم تريد أن يحصل عليه هذا المستخدم من البيع؟ (بالنسبة المئوية) </small>
                            <!-- </div> -->
                          </div>
                        </div>
                        <!--- form-group row Ends --->
                        <?php } ?>
                        <!-- <div class="form-group d-none">
                          <div class="d-flex flex-column">
                            <label class="bottom-label">العلامات</label>
                            <div class="d-flex flex-row mt-10 mb-10">
                              <input type="text" name="proposal_tags" class="form-control" data-role="tagsinput">
                              <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_tags']); ?></small>
                            </div>
                          </div>
                        </div> -->
                        <!--- form-group row Ends --->
                        <div class="form-group mb-0">
                          <a class="button btn" id="next">التالي</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-4" id="popupWidth"></div>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="howitwork-card">
                    <div class="howitwork-card-title d-flex align-items-center">كيف يعمل</div>
                    <div class="howitwork-list d-flex flex-column">
                      <div class="howitwork-list-item d-flex flex-row align-items-start">
                        <div class="howitwork-list-icon">
                          <img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/postagig.png" />
                        </div>
                        <div class="howitwork-list-content">
                          <h3>
                              نشر خدمة
                          </h3>
                          <p>
                            ابدأ وخصص خدماتك بحيث الناس اللى هتشترى يقدروا يفهموا بشكل واضح الخدمات اللى بتوفرها علشان تقابل احتياجاتهم 
                             
                          </p>
                        </div>
                      </div>
                      <!-- How it work each item -->
                      <div class="howitwork-list-item d-flex flex-row align-items-start">
                        <div class="howitwork-list-icon">
                          <img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/gethired.png" />
                        </div>
                        <div class="howitwork-list-content">
                          <h3>2. التعاقد</h3>
                          <p>
                        اتواصل مع المشتري عشان تحددوا التفاصيل الخاصة بالمشروع. بمجرد ما تتفق انت و مقدم الخدمة على الطلبات، هتبدأ الشغل.
                          </p>
                        </div>
                      </div>
                      <!-- How it work each item -->
                      <div class="howitwork-list-item d-flex flex-row align-items-start">
                        <div class="howitwork-list-icon">
                          <img alt="Work" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/work.png" />
                        </div>
                        <div class="howitwork-list-content">
                          <h3>3. الشغل</h3>
                          <p>بمجردما تخلص شغلك،هتسلمال شغل الرائع على منصتنا عشان العميل يوافق عليه.</p>
                        </div>
                      </div>
                      <!-- How it work each item -->
                      <div class="howitwork-list-item d-flex flex-row align-items-start">
                        <div class="howitwork-list-icon">
                          <img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/getpaid.png" />
                        </div>
                        <div class="howitwork-list-content">
                          <h3>4. استلم فلوسك</h3>
                          <p>لما العميل يوافق على شغلك اللي اتسلم، فلوسك هتتحول لحسابك على موقع "منجز" و كمان ممكن تخلي فلوسك في حسابك على موقع "منجز" أو تحولهم لحسابك في البنك.</p>
                        </div>
                      </div>
                      <!-- How it work each item -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="tab-pane fade" id="publish_section">
        <section class="container-fluid publish-gig">
          <div class="row">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <div class="publish-gig-wrapper">
                    <div class="publish-gig-header text-center">انشر خدمة</div>
                    <div class="publish-gig-body">
                     
                      <div class="d-flex flex-column">
                        <input type="hidden" name="email" value="<?= $user_email; ?>">
                        <!-- <div class="form-group d-flex flex-column">
                          <label class="control-label" for="fname">الاسم الأول</label>
                          <input class="form-control" id="fname" name="name" type="text" />
                        </div> -->
                        <!-- Each item -->
                        <div class="form-group d-flex flex-column">
                          <label class="control-label" for="lname">اسم المستخدم</label>
                          <input class="form-control" id="lname" name="u_name" type="text" />
                          <?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
                          <?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
                          <?php if(in_array("Foreign characters are not allowed in username, Please try another one.", $error_array)) echo "<span style='color:red;'>Foreign characters are not allowed in username, Please try another one.</span> <br>"; ?>
                          <?php if(in_array("يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.", $error_array)) echo "<span style='color:red;'>يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.</span> <br>"; ?>
                        </div>
                        <!-- Each item -->
                        <div class="form-group d-flex flex-column">
                          <label class="control-label" for="password">الباسوورد</label>
                          <input class="form-control" id="password" name="pass" type="password" />
                        </div>
                        <!-- Each item -->
                        <div class="form-group d-flex flex-column">
                          <button class="publish-gig-button" name="publish" type="submit">انشر دلوقتي</button>
                        </div>
                        <!-- Each item -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </form>
  </main>
  <!-- Main content end -->
  
<?php 

function insertPackages($proposal_id, $price, $time){
  global $db;
  $insertPackage1 = $db->insert("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic',"price"=>$price,"delivery_time"=>$time,"revisions"=>1));
  $insertPackage2 = $db->insert("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard',"price"=>10,"delivery_time"=>1,"revisions"=>1));
  $insertPackage3 = $db->insert("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance',"price"=>15,"delivery_time"=>1,"revisions"=>1));
  if($insertPackage3){return true;}
}

if(isset($_POST['publish'])){

  $rules = array(
  "u_name" => "required",
  "pass" => "required");

  $messages = array("name" => "الإسم الكامل ضروري.","u_name" => "اسم المستخدم مطلوب.","pass" => "كلمة المرور مطلوبة.");
  $val = new Validator($_POST,$rules,$messages);

  if($val->run() == false){
    $_SESSION['error_array'] = array();
    Flash::add("register_errors",$val->get_all_errors());
    Flash::add("form_data",$_POST);
    echo "<script>window.open('post-gig#publish_section','_self')</script>";
  }else{
    $error_array = array();
    $name = strip_tags($input->post('name'));
    $name = strip_tags($name);
    $name = ucfirst(strtolower($name));
    $_SESSION['name']= $name;
    $u_name = strip_tags($input->post('u_name'));
    $u_name = strip_tags($u_name);
    $_SESSION['u_name']= $u_name;
    $email = strip_tags($input->post('email'));
    $email = strip_tags($email);
    $_SESSION['email']=$email;
    $pass = strip_tags($input->post('pass'));
    $accountType = 'seller';

    $country = '';
    $regsiter_date = date("F d, Y");
    $date = date("F d, Y");

    $check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
    $check_seller_email = $db->count("sellers",array("seller_email" => $email));
    // if(preg_match('/[اأإء-ي]/ui', $input->post('u_name'))){
    //   array_push($error_array, "الأحرف الأجنبية غير مسموح بها في اسم المستخدم ، يرجى تجربة حرف آخر.");
    // }
    if ( preg_match('/\s/',$input->post('u_name')) ){
      array_push($error_array, "يجب ألا يحتوي اسم المستخدم على مساحة ، يرجى تجربة اسم آخر.");
    }
    if($check_seller_username > 0 ){
      array_push($error_array, "عذراً! وقد تم بالفعل اتخاذ هذا المستخدم. يرجى تجربة واحدة أخرى");
    }
    if($check_seller_email > 0){
      array_push($error_array, "لقد اخذ الايميل من قبل. حاول تسجيل الدخول بدلاً من ذلك.");
    }
    if(empty($error_array)){
      $referral_code = mt_rand();

      if($signup_email == "yes"){
        $verification_code = mt_rand();
      }else{
        $verification_code = "ok";
      }
      $encrypted_password = password_hash($pass, PASSWORD_DEFAULT);
      $insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_pass" => $encrypted_password,"account_type" => $accountType,"seller_country"=>$country,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online','landing_email' => $email));

      $regsiter_seller_id = $db->lastInsertId();

        if($insert_seller){
          
          $_SESSION['seller_user_name'] = $u_name;
          $insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));

          if($insert_seller_account){

            if(!empty($referral)){
              $sel_seller = $db->select("sellers",array("seller_referral" => $referral));   
              $row_seller = $sel_seller->fetch();
              $seller_id = $row_seller->seller_id;  
              $seller_ip = $row_seller->seller_ip;
              if($seller_ip == $ip){
                echo "<script>alert('You Cannot Referral Yourself To Make Money.');</script>";
              }else{
                $count_referrals = $db->count("referrals",array("ip" => $ip));  
                if($count_referrals == 1){
                  echo "<script>alert('You are trying to referral yourself more then one time.');</script>";
                }else{
                  $insert_referral = $db->insert("referrals",array("seller_id" => $seller_id,"referred_id" => $regsiter_seller_id,"comission" => $referral_money,"date" => $date,"ip" => $ip,"status" => 'pending'));
                }
              } 
            }

            if($signup_email == "yes"){
              userSignupEmail($email);
            }

            $rules = array(
            "proposal_title" => "required",
            "proposal_cat_id" => "required",
            "proposal_child_id" => "required");

            $messages = array("proposal_cat_id" => "يجب عليك تحديد فئة","proposal_child_id" => "يجب عليك تحديد فئة فرعية","proposal_enable_referrals"=>"يجب عليك تمكين أو تعطيل إحالات الاقتراح.");
            $val = new Validator($_POST,$rules,$messages);

            if($val->run() == false){
              Flash::add("form_errors",$val->get_all_errors());
              Flash::add("form_data",$_POST);
              echo "<script> window.open('post-gig#post_gig','_self');</script>";
            }else{
              $proposal_title = $input->post('proposal_title');

              function proposalUrl($string, $space="-"){
                 
                if(preg_match('/[اأإء-ي]/ui', $string)){
                  return urlencode($string);
                }else{
                  $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
                  $turkceto = array("G","U","S","I","O","C","g","u","s","i","o","c");

                  $string = utf8_encode($string);
                  if(function_exists('iconv')) {
                    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
                  }

                  $string = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
                  $string = trim(preg_replace("/\\s+/", " ", $string));
                  $string = strtolower($string);
                  $string = str_replace(" ", $space, $string);

                  $string = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$string);
                  $string = preg_replace($turkcefrom,$turkceto,$string);
                  $string = preg_replace("/ +/"," ",$string);
                  $string = preg_replace("/ /","-",$string);
                  $string = preg_replace("/\s/","",$string);
                  $string = strtolower($string);
                  $string = preg_replace("/^-/","",$string);
                  $string = preg_replace("/-$/","",$string);
                  return $string;
               }

              }

              $sanitize_url = proposalUrl($proposal_title);
              $select_proposals = $db->select("proposals",array("proposal_seller_id" => $regsiter_seller_id,"proposal_url" => $sanitize_url));
              $count_proposals = $select_proposals->rowCount();
              if($count_proposals ==  1){
                echo "<script>
                swal({
                type: 'warning',
                text: 'عذراً! قدم بالفعل اقتراحًا بنفس العنوان جرب عنوانًا آخر.',
                })</script>";
              }else{
                $proposal_referral_code = mt_rand();
                $get_general_settings = $db->select("general_settings");   
                $row_general_settings = $get_general_settings->fetch();
                $proposal_email = $row_general_settings->proposal_email;
                $site_email_address = $row_general_settings->site_email_address;
                $site_logo = $row_general_settings->site_logo;
                // $data = $input->post();

                $data = array();



                // var_dump($data);die;
                // unset($data['submit']);
                $data['proposal_title'] = $input->post('proposal_title');
                $data['buyer_instruction'] = $input->post('buyer_instruction');
                $data['answer_type'] = $input->post('answer_type');
                $data['answer_mandatory'] = $input->post('answer_mandatory');
                $data['proposal_cat_id'] = $input->post('proposal_cat_id');
                $data['proposal_child_id'] = $input->post('proposal_child_id');
                // $data['proposal_tags'] = $input->post('proposal_tags');
                $data['proposal_price'] = $input->post('proposal_price');
                $custom_delivery = $input->post('custom_delivery');
                if($custom_delivery != ''){
                  $get_deliver_time = $db->select("delivery_times",array("delivery_title_arabic" => $custom_delivery));
                  $count_time = $get_deliver_time->rowCount();
                  $row_deliver_time = $get_deliver_time->fetch();
                  $delivery_id = $row_deliver_time->delivery_id;
                  
                  if($count_time > 0 ){
                    $data['delivery_id'] = $delivery_id;
                  }else{
                    $insert_time = $db->insert('delivery_times',array('delivery_proposal_title_arabic'=>$custom_delivery, 'delivery_title_arabic'=>$custom_delivery, 'type'=>'custom'));
                    if($insert_time){
                      $insert_delivery_id = $db->lastInsertId();
                      
                      $data['delivery_id'] = $insert_delivery_id;
                    }
                  }
                }else{
                $data['delivery_id'] = $input->post('delivery_id');
                }
                $data['proposal_url'] = $sanitize_url;
                $data['proposal_seller_id'] = $regsiter_seller_id;
                $data['proposal_featured'] = "no";
                if($enable_referrals == "no"){ 
                $data['proposal_enable_referrals'] = "no"; 
                }
                $graphic_img = array("Graphic.png", "Graphic-1.png", "Graphic-2.png", "Graphic-3.png", "Graphic-4.png", "Graphic-5.png");
                $random_graphic=array_rand($graphic_img);

                $digital_img = array("digital.png", "digital-1.png", "digital-2.png", "digital-3.png");
                $random_digital=array_rand($digital_img);

                $writing_img = array("writing.png", "writing-1.png", "writing-2.png", "writing-3.png");
                $writing_digital=array_rand($writing_img);

                $video_img = array("video.png", "video-1.png", "video-2.png", "video-3.png", "video-4.png");
                $video_digital=array_rand($video_img);

                $tech_img = array("programing.png", "programming-1.png", "programming-2.png", "programming-3.png", "programming-4.png");
                $tech_digital=array_rand($tech_img);

                $business_img = array("business.png", "business-1.png", "business-2.png", "business-3.png", "business-4.png");
                $business_digital=array_rand($business_img);

                if($data['proposal_cat_id'] == 1){
                  $data['proposal_img1'] = $graphic_img[$random_graphic];
                }else if($data['proposal_cat_id'] == 2){
                  $data['proposal_img1'] = $digital_img[$random_digital];
                }else if($data['proposal_cat_id'] == 3){
                  $data['proposal_img1'] = $writing_img[$writing_digital];
                }else if($data['proposal_cat_id'] == 4){
                  $data['proposal_img1'] = $video_img[$video_digital];
                }else if($data['proposal_cat_id'] == 6){
                  $data['proposal_img1'] = $tech_img[$tech_digital];
                }else if($data['proposal_cat_id'] == 7){
                  $data['proposal_img1'] = $business_img[$business_digital];
                }else{
                  $data['proposal_img1'] = 'becreative.jpg';
                }

                $data['level_id'] = '1';
                $data['language_id'] = '1';
                $data['proposal_status'] = "active";
                $data['proposal_date'] = date("F d, Y");
// var_dump($data);die;
                $insert_proposal = $db->insert("proposals",$data);

                if($insert_proposal){

                  $proposal_id = $db->lastInsertId();

                  if($videoPlugin == 1){
                    include("$dir/plugins/videoPlugin/proposals/checkVideo.php");
                  }else{
                    $redirect = "pricing";
                  }

                  $get_price = $db->select("proposals", array('proposal_id'=>$proposal_id));
                  $row_price = $get_price->fetch();
                  $proposal_price = $row_price->proposal_price; 
                  $delivery_id = $row_price->delivery_id;
                  $get_time = $db->select("delivery_times",array("delivery_id"=>$delivery_id));
                  $row_time = $get_time->fetch();
                  $delivery_proposal_title = $row_time->delivery_proposal_title;
                  insertPackages($proposal_id,$proposal_price,$delivery_proposal_title);

                  echo "<script>
                  swal({
                  type: 'success',
                  text: 'تم حفظ التفاصيل.',
                  timer: 2000,
                  onOpen: function(){
                  swal.showLoading()
                  }
                  }).then(function(){
                    window.open('$site_url/ar/dashboard','_self')
                  });
                  </script>";
                }
              }

            }
          }
        }
    }
    if(!empty($error_array)){
      $_SESSION['error_array'] = $error_array;
      echo "
      <script>
      swal({
      type: 'error',
      html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
      animation: false,
      customClass: 'animated tada'
      }).then(function(){
      window.open('post-gig#publish_section','_self')
      });
      </script>";
    }
  }

}

?>
  <script>
    $(document).ready(function(){
      $('.proposal_referral_money').hide();
      <?php if(@$form_data['proposal_enable_referrals'] == "yes"){ ?>
        $('.proposal_referral_money').show();
      <?php } ?>
      $(".proposal_enable_referrals").change(function(){
        var value = $(this).val();
        if(value == "yes"){
          $(".proposal_referral_money input").attr("required","");
          $('.proposal_referral_money').show();
        }else if(value == "no"){
          $(".proposal_referral_money input").removeAttr("required");
          $('.proposal_referral_money').hide();
        }
      });

      <?php if(@$form_data['proposal_child_id']){ ?>
      <?php }else{ ?>
      $("#sub-category").hide();
      <?php } ?>

      $('.input-number').keyup(function(){
        var custom_btn = $('.input-number').val();
        $('#days30').val(custom_btn);
      });
      $(".input-number").keypress(function (e) {
       //if the letter is not digit then display error and don't type anything
       if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          //display error message
          $("#errmsg").html("Digits Only").show().fadeOut("slow");
                 return false;
      }
     });
    });

      $(function(){
          $(window).on('load resize', function(){
              var popupWidth = $('#popupWidth').outerWidth();
              $('.popup').css({
                  'width': popupWidth + 30 + 'px'
              });
          });
          $('.gig-category-select').on('click', function(){
              $('.cat_item-content').addClass('item-removed');
              $('.gig-category-item').addClass('item-removed');
              $(this).parents('.cat_item-content').removeClass('item-removed');
              $(this).parents('.cat_item-content').addClass('item-active');
              $(this).parents('.gig-category-item').removeClass('item-removed');
              $(this).parents('.gig-category-item').addClass('item-active');
          });
          $('.gig-category-tag').on('click', function(){
              $(this).toggleClass('tag-selected');
          });
          $('.backto-main').on('click', function(){
              $('.gig-category-item').removeClass('item-active');
              $('.gig-category-item').removeClass('item-removed');
              $('.cat_item-content').removeClass('item-active');
              $('.cat_item-content').removeClass('item-removed');
              $('.gig-category-tag').removeClass('tag-selected');
              $('.gig-category-item').find('input[type="radio"]').prop('checked', false);
          });
          $('.deliver-time-item[for="days30"]').on('click', function(){
              $('.input-number').focus();
          });
          $(".gig-category-select").on('click', function(){
            var cat_class = $(this).parents('.cat_item-content').attr("data-id");
              $(".gig-category-tags").removeAttr('class').addClass('gig-category-tags '+cat_class);
              // $('.gig-category-tags').addClass(cat_class);
          });
      });

      $(".text-count").keydown(function(){
      var textarea = $(".text-count").val();
      $(".descCount").text(textarea.length);  
      }); 

      $(".gig-category-tags  .nice-select.form-control").remove();

      
      $("#sub-category").hide();

      function categoryItem(id){
        $("#sub-category").show();  
        var category_id =  id;
        $.ajax({
        url:"fetch_subcategory",
        method:"POST",
        data:{category_id:category_id},

        success:function(data){
          console.log(data);
        $("#sub-category").html(data);
        }
        });
      }
        $('#title_error').hide();
        $('#price_error').hide();
        $('#category_error').hide();
        $('#desc_error').hide();
        $('#time_error').hide();
        $('#next').click(function(){
          $('.form-field').each(function() {

            if ( $('#proposal_desc').val() === '' && $('#proposal_price').val() === '' && $('#proposal_title').val() === '' ){
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('post-gig#publish_section','_self')
              });
              $('#title_error').show();
              $('#price_error').show();
              $('#category_error').show();
              $('#desc_error').show();
              $('#time_error').show();
            }else if( $('#proposal_title').val() === ''){
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('post-gig#publish_section','_self')
              });
              $('#title_error').show();
            }else if( $('#proposal_price').val() === '' && $('#proposal_title').val() != ''){
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('post-gig#publish_section','_self')
              });
              $('#price_error').show();
              $('#title_error').hide();
            }else if( $('.cat_value').val() === '' && $('#proposal_desc').val() != '' && $('#proposal_price').val() != '' && $('#proposal_title').val() != ''){
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('post-gig#publish_section','_self')
              });
              $('#title_error').hide();
              $('#price_error').hide();
              $('#category_error').show();
              $('#desc_error').hide();
            }else if( $('.cat_value').val() === '' && $('#proposal_desc').val() != '' && $('#proposal_price').val() != '' && $('#proposal_title').val() != ''){
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('post-gig#publish_section','_self')
              });
              $('#title_error').hide();
              $('#price_error').hide();
              $('#category_error').show();
              $('#desc_error').hide();
            }else if( $('#proposal_desc').val() === '' && $('#proposal_price').val() != '' && $('#proposal_title').val() != '' && $('.cat_value').val() != ''){
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! هناك بعض الأخطاء في النموذج. حاول مرة اخرى.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('post-gig#publish_section','_self')
              });
              $('#desc_error').show();
              $('#title_error').hide();
              $('#price_error').hide();
              $('#category_error').hide();
            }else{
              $('#post_gig').removeClass('show active');
              $('#publish_section').addClass('show active');
              $('#publish_tab').addClass('active');
              document.documentElement.scrollTop = 0;

            }

                    //   if ( $(this).val() === '' ){
                    //        isValid = false;
                    //   }else{
                        
                    //   }
                    });
                
              });
        // function validateForm() {
        //   var isValid = true;
        //   $('.form-field').each(function() {
        //     if ( $(this).val() === '' ){
        //          isValid = false;
        //     }else{
              
        //     }
        //   });
        // }
    </script>
  <?php require_once("../includes/footer.php"); ?>
  <script src="../js/tagsinput.js"></script>
</body>
</html>