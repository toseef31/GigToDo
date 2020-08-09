<?php
  session_start();
  require_once("includes/db.php");
  require_once("social-config.php");
  ?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title> <?php echo $site_name; ?> - Landing Page </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <?php if(!empty($site_favicon)){ ?>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">
    <?php } ?>
    <!-- ==============Google Fonts============= -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
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
    <!--====== Default css ======-->
    <link href="assets/css/default.css" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="assets/css/style.css" rel="stylesheet">
    <!--====== Responsive css ======-->
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link href="styles/animate.css" rel="stylesheet">
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #ff0707;}.swal2-popup .swal2-select{display: none !important;}.footer-area, .copyright-area{display: none;}</style>
  </head>
  <body class="all-content">
    <!-- Preloader Start -->
      <div class="proloader">
        <div class="loader">
          <img src="assets/img/emongez_cube.png" />
        </div>
      </div>
      <!-- Preloader End -->
   
    <!-- Banner Section  Starts-->
    <div class="banner-section landing-page">
      <div class="container">
        <div class="section-wrapper">
          <div class="logo">

            <a href="javascript:void(0);">
              <!-- <img class="top-logo" src="assets/img/top-logo.png" alt="logo"> -->
              <img class="En-top-logo" src="<?= $site_url; ?>/images/ar/<?= $arabic_sticky_logo; ?>" alt="logo">
            </a>
          </div>
          <h2 class="title">
            بتدور إزاي تكسب فلوس من <br>العمل الحر؟
          </h2>
          <p>هتلاقي عملاء جدد بدوسة زرار</p>
        </div>
        <form class="join-form" method="post">
          <input type="text" name="email" placeholder="دخلالإيميل الخاص بيك ">
          <input type="submit" name="join_now" value="انضم دلوقتي">
        </form>
      </div>
    </div>
    <!-- Banner Section  Ends-->
    <!-- Truster by section starts-->
    <?php if($trusted_companies == 1){ ?>
    <div class="trusted-by-section padding-top padding-bottom bg-gray">
      <div class="container">
        <div class="section-header">
          <h2 class="title">مضمونين حول العالم</h2>
        </div>
        <ul class="trusted-wrapper">
          <li>
            <a href="javascript:void(0);"><img src="assets/img/trusted/01.png" alt="trusted"></a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="assets/img/trusted/02.png" alt="trusted"></a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="assets/img/trusted/03.png" alt="trusted"></a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="assets/img/trusted/04.png" alt="trusted"></a>
          </li>
          <li>
            <a href="javascript:void(0);"><img src="assets/img/trusted/05.png" alt="trusted"></a>
          </li>
        </ul>
      </div>
    </div>
    <?php } ?>
    <!-- Truster by section ends-->
    <!-- Get Started Section Starts -->
      <div class="get-started padding-bottom padding-top">
        <div class="container">
          <div class="section-header">
            <h2 class="title">
              اختار فئة، اعرض خبراتك 
            </h2>
          </div>
          <div class="started-section-wrapper">
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
              $arabic_title = $row_meta->arabic_title;
              $cat_desc = $row_meta->cat_desc;
            ?>
            <div class="started-item landingpage">
              <div class="started-inner">
                <div class="started-thumb">
                  <img src="assets/img/category/<?= $cat_image; ?>" alt="category">
                </div>
                <div class="started-content d-flex align-items-center justify-content-center">
                  <div class="content">
                    <div class="thumb">
                      <img src="assets/img/category/<?= $cat_icon; ?>" alt="category">
                    </div>
                    <h6 class="sub-title">
                      <?= $arabic_title; ?>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- Get Started Section Ends -->

      <!-- Work Section Starts  -->
      <div class="work-section padding-top padding-bottom">
        <div class="container">
          <div class="section-header">
            <h2 class="title">إزاي بتشتغل</h2>
            <p>مفيش أسهل من كدة عشان تبدأ</p>
          </div>
          <div class="row justify-content-center mb-30-none">
            <?php
              $get_boxes = $db->query("select * from section_boxes where language_id='2' LIMIT 0,4");
              while($row_boxes = $get_boxes->fetch()){
              $box_id = $row_boxes->box_id;
              $box_title = $row_boxes->box_title;
              $box_desc = $row_boxes->box_desc;
              $box_image = $row_boxes->box_image; 
            ?>
            <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
              <div class="work-item">
                <div class="work-thumb">
                  <img src="assets/img/work/<?= $box_image; ?>" alt="work">
                </div>
                <div class="work-content text-center">
                  <h5 class="title"><?= $box_title; ?><h5>
                  <p><?= $box_desc; ?></p>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <!-- Work Section Ends  -->
      <!-- Payment getway -->
      <?php if($payment_option == 1){ ?>
      <div class="payment-system padding-bottom padding-top bg-white">
        <div class="container">
          <div class="section-header">
            <h2 class="title">دفع امن</h2>
            <p>تم تصميم خيارات الدفع الآمنة لدينا لتوفر لك الأمان ،<br />حتى تتمكن من التركيز على ما تفعله بشكل أفضل</p>
          </div>
          <div class="payment-wrapper">
            <div class="payment-item">
              <div class="payment-flip-container">
                <div class="payment-flip">
                  <div class="payment-thumb">
                    <img src="assets/img/payment/online.png" alt="payment">
                  </div>
                  <div class="payment-content">
                    <span>عبر الانترنت</span>
                  </div>
                  <div class="payment-getway">
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/01.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/02.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/03.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/04.png" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="payment-label">عبر الانترنت</div>
            </div>
            <div class="payment-item">
              <div class="payment-flip-container">
                <div class="payment-flip">
                  <div class="payment-thumb">
                    <img src="assets/img/payment/mobile.png" alt="payment">
                  </div>
                  <div class="payment-content">
                    <span>محفظة المحمول</span>
                  </div>
                  <div class="payment-getway mobile-getway">
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/05.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/06.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/07.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/08.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/09.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/10.png" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="payment-label">محفظة المحمول</div>
            </div>
            <div class="payment-item">
              <div class="payment-flip-container">
                <div class="payment-flip">
                  <div class="payment-thumb">
                    <img src="assets/img/payment/cash.png" alt="payment">
                  </div>
                  <div class="payment-content">
                    <span>السيولة النقدية</span>
                  </div>
                  <div class="payment-getway">
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/11.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/12.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/13.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/14.png" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="payment-label">السيولة النقدية</div>
            </div>
            <div class="payment-item">
              <div class="payment-flip-container">
                <div class="payment-flip">
                  <div class="payment-thumb">
                    <img src="assets/img/payment/local.png" alt="payment">
                  </div>
                  <div class="payment-content">
                    <span>محلي</span>
                  </div>
                  <div class="payment-getway">
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/15.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/16.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/17.png" />
                    </div>
                    <div class="payment-getway-item">
                      <img alt="Payment Getway" src="assets/img/payment/18.png" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="payment-label">محلي</div>
            </div>
          </div>
          <!-- Payment wrapper -->
        </div>
      </div>
      <?php } ?>
      <!-- Payment getway -->
      <!-- Client Section -->
      <section class="client-section" style="background:url(assets/img/client/01.jpg);">
        <div class="section-header style-two m-0 px-3">
          <h2 class="title">الناس بيحبوا خدماتنا</h2>
        </div>
        <div class="client-wrapper bg_img" data-background="./assets/img/client/01.jpg">
          <div class="container">
            <div class="client-slider-wrapper">
              <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <?php
                  $get_testimonials = $db->select("testimonials",array('testimonial_type' => 'seller'));
                  $i = 0;
                  while($row_testimonials = $get_testimonials->fetch()){
                  $testimonial_id = $row_testimonials->testimonial_id;
                  
                  $name = $row_testimonials->name;
                  $arabic_name = $row_testimonials->arabic_name;
                  $designation = $row_testimonials->designation;
                  $arabic_designation = $row_testimonials->arabic_designation;
                  $description = $row_testimonials->description;
                  $arabic_description = $row_testimonials->arabic_description;
                  $image = $row_testimonials->image;
                  ?>
                  <div class="carousel-item <?php if($i == 0){echo "active";} ?>">
                    <div class="client-item">
                      <div class="client-thumb">
                        <?php if(!empty($image)){?>
                        <img src="<?= $site_url; ?>/testimonial/testimonial_images/<?= $image; ?>" style="min-height: 100%" alt="client">
                        <?php }else{ ?>
                        <img src="assets/img/client/01.png" alt="client">
                        <?php } ?>
                      </div>
                      <div class="client-content">
                        <h5 class="title"><?= $arabic_name ?></h5>
                        <span class="sub-title">– <strong><?= $arabic_designation; ?></strong></span>
                        <?php 
                          $string = $arabic_description;
                          if (strlen($string) > 520) {
                              // truncate string
                              $stringCut = substr($string, 0, 520);
                              $endPoint = strrpos($stringCut, ' ');
                              //if the string doesn't contain any space then it will cut without word basis.
                              $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                              $string .= '....';
                          }
                          // echo $string;
                        ?>
                        <p><?= $string; ?></p>
                      </div>
                    </div>
                  </div>
                  <?php $i++; } ?>

                </div>
                <a class="nav-button carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <i class="fa fa-angle-left" aria-hidden="true"></i>
                </a>
                <a class="nav-button carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Client Section -->
      <!-- Stay Connected Starts -->
      <div class="stay-connected">
        <div class="container">
          <div class="section-header style-three">
                      <h2 class="title">
                          انضم و اكسب
                      </h2>
                      <p>اعمل بروفايلك وابدأ شغل!</p>
          </div>
          <form class="join-form" method="post">
            <input type="text" name="email" placeholder="دخلالإيميل الخاص بيك ">
            <input type="submit" name="join_now" value="انضم دلوقتي">
          </form>
          <div class="d-flex flex-row align-items-center justify-content-center copy-right">
            <span><?= $db->select("general_settings")->fetch()->site_copyright; ?></span>
          </div>
        </div>
      </div>
      <!-- Stay Connected Ends -->
      <?php
        if(isset($_POST['join_now'])){
          $rules = array(
          "email" => "email|required");
          $messages = array("email" => "Email Is Required.");
          $val = new Validator($_POST,$rules,$messages);
          if($val->run() == false){
            $_SESSION['error_array'] = array();
            Flash::add("register_errors",$val->get_all_errors());
            Flash::add("form_data",$_POST);
            echo "<script>window.open('index','_self')</script>";
          }else{
            $email = strip_tags($input->post('email'));
            $email = strip_tags($email);
            $_SESSION['email']=$email;

            $check_seller_email = $db->count("sellers",array("seller_email" => $email));
            if($check_seller_email > 0){
              echo "
              <script>
              swal({
              type: 'error',
              html: $('<div>').text('عذراً! لقد اخذ الايميل من قبل. حاول تسجيل الدخول بدلاً من ذلك.'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('landing-page','_self')
              });
              </script>";
              // array_push($error_array, "Email has already been taken. Try logging in instead.");
            }else{
              $insert_email = $db->insert("landing_email", array("email" => $email));
              echo "<script>
              swal({
              type: 'success',
              text: 'تم حفظ التفاصيل.',
              timer: 2000,
              onOpen: function(){
              swal.showLoading()
              }
              }).then(function(){
                window.open('proposals/post-gig','_self')
              });
              </script>";
            }
          }
        }
      ?>
      <script>
          $(function() {
            $(".mesagee-item-box").niceScroll({
              cursorcolor: "#D72929",
            });
          });

        </script>
    <?php require_once("includes/footer.php"); ?>
  </body>
</html>