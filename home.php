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
      <h2 class="title"><?= $section_heading; ?>
      
      </h2>
      <p><?= $section_short_heading; ?></p>
    </div>
    <form class="join-form" id="gnav-search" method="post">
      <input type="text" placeholder="<?= $lang['search']['placeholder']; ?>" id="search-query" name="search_query" value="<?= @$_SESSION["search_query"]; ?>"  autocomplete="off">
      <input type="submit" value="<?= $lang['search']['button']; ?>">
    </form>
  </div>
</div>
<!-- end main -->
<!-- Truster by section starts-->
<div class="trusted-by-section padding-top padding-bottom bg-gray">
  <div class="container">
    <div class="section-header">
      <h2 class="title">
      trusted by great companies
      </h2>
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
      Browse a Category, Find an Expert
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
              <?= $cat_title; ?>
              </h6>
            </div>
          </div>
          <div class="started-hover-content d-flex flex-wrap justify-content-center align-items-center">
            <div class="content text-center">
              <h6 class="sub-title"><a href="categories/<?= $cat_url ?>"><?= $cat_title; ?></a></h6>
              <p><?= $cat_desc; ?> </p>
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
      <h2 class="title">how it works</h2>
      <p>Getting started couldn’t be easier</p>
    </div>
    <div class="row justify-content-center mb-30-none">
      <?php
        $get_boxes = $db->query("select * from section_boxes where language_id='$siteLanguage' LIMIT 0,4");
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
      <!-- <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
        <div class="work-item">
          <div class="work-thumb">
            <img src="assets/img/work/hire.png" alt="work">
          </div>
          <div class="work-content text-center">
            <h5 class="title">hire</h5>
            <p>Review expert credentials from dozens of freelancers. Have the power to select the most qualified seller that matches the requirements of your project. </p>
          </div>
        </div>
      </div> -->
      <!-- <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
        <div class="work-item">
          <div class="work-thumb">
            <img src="assets/img/work/work.png" alt="work">
          </div>
          <div class="work-content text-center">
            <h5 class="title">work</h5>
            <p>Communicate and lay the foundation for a successful collaboration. Share ideas, approve outlines, send files, and manage the entire project from our easy-to-use platform. </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 d-flex flex-row">
        <div class="work-item">
          <div class="work-thumb">
            <img src="assets/img/work/pay.png" alt="work">
          </div>
          <div class="work-content text-center">
            <h5 class="title">pay</h5>
            <p>Once you have found the perfect freelancer for your project, send the payment through our safe and secure payment portal. Enjoy peace of mind with a 100% money back guarantee.</p>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>
<!-- Work Section Ends  -->
<!-- Payment getway -->
<div class="payment-system padding-bottom padding-top bg-white">
  <div class="container">
    <div class="section-header">
      <h2 class="title">
      Instant Payment, Priceless Results
      </h2>
      <p>When you find the right freelancer, you need to be able to hire them with the click of a button. <br> That’s why eMongez supports a whole host of secure payment options</p>
    </div>
    <div class="payment-wrapper">
      <div class="payment-item">
        <div class="payment-flip-container">
          <div class="payment-flip">
            <div class="payment-thumb">
              <img src="assets/img/payment/online.png" alt="payment">
            </div>
            <div class="payment-content">
              <span>online</span>
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
        <div class="payment-label">Online</div>
      </div>
      <div class="payment-item">
        <div class="payment-flip-container">
          <div class="payment-flip">
            <div class="payment-thumb">
              <img src="assets/img/payment/mobile.png" alt="payment">
            </div>
            <div class="payment-content">
              <span>mobile wallet</span>
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
        <div class="payment-label">Mobile Wallet</div>
      </div>
      <div class="payment-item">
        <div class="payment-flip-container">
          <div class="payment-flip">
            <div class="payment-thumb">
              <img src="assets/img/payment/cash.png" alt="payment">
            </div>
            <div class="payment-content">
              <span>cash</span>
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
        <div class="payment-label">Cash</div>
      </div>
      <div class="payment-item">
        <div class="payment-flip-container">
          <div class="payment-flip">
            <div class="payment-thumb">
              <img src="assets/img/payment/local.png" alt="payment">
            </div>
            <div class="payment-content">
              <span>local</span>
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
        <div class="payment-label">Local</div>
      </div>
    </div>
    <!-- Payment wrapper -->
  </div>
</div>
<!-- Payment getway -->
<!-- Client Section -->
<section class="client-section" style="background:url(assets/img/client/01.jpg);">
  <div class="section-header style-two m-0 px-3">
    <h2 class="title">What Our Customers Say</h2>
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
                  <h5 class="title">Mustafa Aziz</h5>
                  <span class="sub-title">— eCommerce Seller </span>
                  <p>
                  “Being able to pay in my local currency and find a copywriter with the language skills I needed was a real deal breaker for me. I’m so happy with the copy that I received, and it was as easy as clicking a button. Highly recommended!” </p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="client-item">
                <div class="client-thumb">
                  <img src="assets/img/client/01.png" alt="client">
                </div>
                <div class="client-content">
                  <h5 class="title">Lewis Tyson</h5>
                  <span class="sub-title">— Online Business Owner </span>
                  <p>“I needed help rebranding my business but didn’t know where to turn for a new logo. One quick look at eMongez introduced me to dozens of skilled graphic designers. I chose my favorite, and to say I’m delighted with the result would be an understatement!” </p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="client-item">
                <div class="client-thumb">
                  <img src="assets/img/client/01.png" alt="client">
                </div>
                <div class="client-content">
                  <h5 class="title">Hannah Thomas
                  </h5>
                  <span class="sub-title">— Tech Entrepreneur </span>
                  <p>“I’m expanding my business right now, and I needed to employ a tech specialist I could rely on. The seller I found has been really helpful and I wouldn’t have been able to do it without them. Thanks, eMongez for making it happen!” </p>
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