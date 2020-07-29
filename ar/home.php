<?php
$get_section = $db->select("home_section",array("language_id" => $siteLanguage));
$row_section = $get_section->fetch();
$count_section = $get_section->rowCount();
@$section_heading = $row_section->section_heading;
@$section_short_heading = $row_section->section_short_heading;
$get_slides = $db->query("select * from home_section_slider LIMIT 0,1");
$row_slides = $get_slides->fetch();
$slide_id = $row_slides->slide_id; 
$slide_image = $row_slides->slide_image; 
?>
<link href="styles/styles.css" rel="stylesheet">
<style>
  .get-started .started-section-wrapper .started-item .started-inner .started-thumb img {
      width: 100%;
      height: 280px;
  }
  .trusted-by-section{
    position: relative;
  }
  .banner-section{
    z-index: 99;
    position: relative;
  }
  .home-header{
    z-index: 999;
  }
</style>
<div class="banner-section style-two" style="background-image: url(<?= $site_url; ?>/home_slider_images/<?= $slide_image; ?>);">
  <div class="container">
    <div class="section-wrapper">
      <h2 class="title">
          دور على أفضل خدمات الأعمال الحرة على منصة مصر 1#  الأمنة
      </h2>
      <p>عين فريلانسرز بجودة عالية و ادى دفعة البداية لمشروعك </p>
    </div>
    <form class="join-form" id="gnav-search" method="POST">
      <input type="search" id="search-query" name="search_query" value="<?php echo @$_SESSION["search_query"]; ?>" placeholder="ما نوع العمل هل تحتاج إلى القيام به؟">
      <input name="search" type="submit" value="البحث">
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
<!-- end main -->
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
            اختار الفئة، دور على الخبير
          </h2>
    </div>
    <div class="started-section-wrapper">
      <?php
        $get_categories = $db->query("select * from categories where cat_featured='yes' ".($lang_dir == "right" ? 'order by 1 DESC LIMIT 12,12':' LIMIT 0,12')."");
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
      <div class="started-item">
        <div class="started-inner">
          <?php if ($subcategories_switcher == 0) { ?>
          <a href="category/<?php echo $cat_url; ?>">
          <?php }else{ ?>
          <a href="categories/<?= $cat_url ?>">
          <?php } ?>  
            <div class="started-thumb">
              <img src="<?= $site_url; ?>/assets/img/category/<?= $cat_image; ?>" alt="category">
            </div>
            <div class="started-content d-flex align-items-center justify-content-center">
              <div class="content">
                <div class="thumb">
                  <img src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" alt="category">
                </div>
                <h6 class="sub-title">
                <?= $arabic_title; ?>
                </h6>
              </div>
            </div>
          </a>
          <?php if ($subcategories_switcher == 0) { ?>
          <a href="category/<?php echo $cat_url; ?>">
          <?php }else{ ?>
          <a href="categories/<?= $cat_url ?>">
          <?php } ?>
            <div class="started-hover-content d-flex flex-wrap justify-content-center align-items-center">
              <div class="content text-center">
                <h6 class="sub-title text-white"><?= $arabic_title; ?></h6>
                <p><?= $arabic_desc; ?> </p>
              </div>
            </div>
          </a>
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
            <h5 class="title"><?= $box_title; ?></h5>
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
      <h2 class="title">مدفوعات فورية، نتائج لا تقدر بثمن</h2>
      <p>لما تلاقي الفريلانسر الصح، هتبقى محتاج انك تكون قادر تعينه بدوسة زرار. عشان كدة منجز بيدعم أكثر من خيار للمدفوعات الآمنة</p>
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
              <<span>السيولة النقدية</span>
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
                $get_testimonials = $db->select("testimonials",array('testimonial_type' => 'buyer'));
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