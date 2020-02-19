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

<div class="banner-section style-two">
  <div class="container">
    <div class="section-wrapper">
      <h2 class="title">
          دور على أفضل خدمات الأعمال الحرة على منصة مصر 1#  الأمنة
      </h2>
      <p>عين فريلانسرز بجودة عالية و ادى دفعة البداية لمشروعك </p>
    </div>
    <form class="join-form">
      <input type="search" placeholder="ما نوع العمل هل تحتاج إلى القيام به؟">
      <input type="submit" value="البحث">
    </form>
  </div>
</div>
<!-- end main -->
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
            اختار الفئة، دور على الخبير
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
        $cat_desc = $row_meta->cat_desc;
        $arabic_title = $row_meta->arabic_title;
        $arabic_desc = $row_meta->arabic_desc;
      ?>
      <div class="started-item">
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
          <div class="started-hover-content d-flex flex-wrap justify-content-center align-items-center">
            <div class="content text-center">
              <h6 class="sub-title"><a href="<?= $card_link ?>"><?= $arabic_title; ?></a></h6>
              <p><?= $arabic_desc; ?> </p>
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
            <p>شارك مشروعك دلوقتي على منصتنا عشان تقدر تتواصل مع المحترفين من الموظفين المستقلين اللي مستعدين يقدموا حاجات رائعة ليك</p>
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
            <p>راجع اعتمادات عشرات الفريلانسرز عشان تقدر تحدد الشخص المناسب اللي عنده المؤهلات المطلوبة لمشروعك</p>
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
            <p>اتواصل و حدد الأساس عشان تحقق التعاون الناجح، شارك أفكارك، طور الخطوط العريضة، ابعت ملفات، و كمان تقدر تدير المشروع بالكامل من خلال منصتنا سهلة الاستخدام</p>
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
            <p>بمجرد إنك تلاقي الموظف المثالي لمشروعك، عليك إنك تبعت المبلغ المطلوب من خلال بوابتنا الآمنة للدفع و تستمتع براحة البال لأن معاك ضمان باستعادة أموالك كاملة</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Work Section Ends  -->
<!-- Payment getway -->
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