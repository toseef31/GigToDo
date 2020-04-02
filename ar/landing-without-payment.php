<?php
  session_start();
  require_once("includes/db.php");
  require_once("social-config.php");
  ?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title> <?php echo $site_name; ?> - Landing Page Without Payment </title>
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
              <img class="top-logo" src="assets/img/top-logo.png" alt="logo">
              <img class="En-top-logo" src="assets/img/ar-top-logo.png" alt="logo">
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
            <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
              <div class="work-item">
                <div class="work-thumb">
                  <img src="assets/img/work/find.png" alt="work">
                </div>
                <div class="work-content text-center">
                  <h5 class="title">استكشف</h5>
                  <p>ابدأ وخصص خدماتك بحيث الناس اللى هتشترى يقدروا يفهموا بشكل واضح الخدمات اللى بتوفرها علشان تقابل احتياجاتهم</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
              <div class="work-item">
                <div class="work-thumb">
                  <img src="assets/img/work/hire.png" alt="work">
                </div>
                <div class="work-content text-center">
                  <h5 class="title">التوظيف</h5>
                  <p>اتواصل مع المشتري عشان تعرف تفاصيل المشروع، و بمجرد ما يوافق البائع على الطلبات تقدر تبدأ شغل</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
              <div class="work-item">
                <div class="work-thumb">
                  <img src="assets/img/work/work.png" alt="work">
                </div>
                <div class="work-content text-center">
                  <h5 class="title">الشغل</h5>
                  <p>أول ما تنتهي من شغلك، قدم شغلك الرائع على منصتنا عشان عميلك يوافق عليه</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
              <div class="work-item">
                <div class="work-thumb">
                  <img src="assets/img/work/pay.png" alt="work">
                </div>
                <div class="work-content text-center">
                  <h5 class="title">الدفع</h5>
                  <p> لما العميل يوافق على شغلك اللي اتسلم، فلوسك هتتحول لحسابك على موقع "منجز" و كمان ممكن تخلي فلوسك في حسابك على موقع "منجز" أو تحولهم لحسابك في البنك</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Work Section Ends  -->
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
                  <div class="carousel-item active">
                    <div class="client-item">
                      <div class="client-thumb">
                        <img src="assets/img/client/01.png" alt="client">
                      </div>
                      <div class="client-content">
                        <h5 class="title">مصطفى عزيز</h5>
                        <span class="sub-title">– تاجر إلكتروني</span>
                        <p>
                        إني أكون قادر أدفع بالعملة المحلية وألاقي كاتب إعلاني عنده المهارات اللغوية المطلوبة كان كافي بالنسبالي. أنا سعيد جدا بالنسخة اللي استلمتها، والموضوع كان سهل جدا أنا دوست بس على زرار. موصى به بشدة!"</p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="client-item">
                      <div class="client-thumb">
                        <img src="assets/img/client/01.png" alt="client">
                      </div>
                      <div class="client-content">
                        <h5 class="title">لويس تايسون</h5>
                        <span class="sub-title">– صاحب بيزنس أونلاين</span>
                        <p>"كنت محتاج مساعدة إني أغير العلامة التجارية للبيزنس بتاعي من جديد بس مكنتش عارف أقدر أعمل لوجو جديد فين. بصة سريعة في منجز عرفتني على عشرات من مصممين الجرافيك الشاطرين. اخترت الشخص اللي فضلته، ولو قلت أني كنت في غاية السعادة بالنتائج هيكون قليل!"</p>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="client-item">
                      <div class="client-thumb">
                        <img src="assets/img/client/01.png" alt="client">
                      </div>
                      <div class="client-content">
                        <h5 class="title">هانا توماس
                        </h5>
                        <span class="sub-title">– رائدة أعمال تقنية</span>
                        <p>"أنا بكبر البيزنس بتاعي حاليا وكنت محتاجة أعين متخصص تقني أقدر أعتمد عليه. الفريلانسر اللي لقيته كان مفيد جدا ومكنتش هقدر أعمل اللي كنت عايزاه من غيره. شكرا، منجز، خليت الموضوع يتحقق!"</p>
                      </div>
                    </div>
                  </div>
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
            <input type="text" value="email" placeholder="دخلالإيميل الخاص بيك ">
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
              html: $('<div>').text('Opps! Email has already been taken. Try logging in instead..'),
              animation: false,
              customClass: 'animated tada'
              }).then(function(){
              window.open('landing-page','_self')
              });
              </script>";
              // array_push($error_array, "Email has already been taken. Try logging in instead.");
            }else{

              echo "<script>
              swal({
              type: 'success',
              text: 'Details Saved.',
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
        <?php require_once("includes/footer.php"); ?>
      </script>
  </body>
</html>