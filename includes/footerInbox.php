<div class="footer-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="widget-item">
          <h4 class="text-uppercase">company info</h4>
          <?php
          $get_footer_links = $db->query("select * from footer_links where link_section='categories' AND language_id='$siteLanguage'  LIMIT 0,4");
          while($row_footer_links = $get_footer_links->fetch()){
          $link_id = $row_footer_links->link_id;
          $link_title = $row_footer_links->link_title;
          $link_url = $row_footer_links->link_url;
          ?>
          <a href="<?= $site_url?><?= $link_url; ?>"><?= $link_title; ?></a>
          <?php } ?>
          <!-- <a href="javascript:void(0);">Mission and Vision</a>
          <a href="javascript:void(0);">Blog</a> -->
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-item">
          <h4 class="text-uppercase">support </h4>
          <?php
          $get_footer_links = $db->select("footer_links",array("link_section" => "about","language_id" => $siteLanguage));
          while($row_footer_links = $get_footer_links->fetch()){
          $link_id = $row_footer_links->link_id;
          $icon_class = $row_footer_links->icon_class;
          $link_title = $row_footer_links->link_title;
          $link_url = $row_footer_links->link_url;
          ?>
          <a href="<?= $site_url?><?= $link_url; ?>"><?= $link_title; ?></a>
          <?php } ?>
          <!-- <a href="javascript:void(0);">Privacy Policy</a>
          <a href="javascript:void(0);">Contact Us</a> -->
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-item">
          <h4 class="text-uppercase">contact us</h4>
          <p>Email: <a href="javascript:void(0);">emongez@emongez.com</a></p>

          <div class="footer-social">
            <?php
            $get_footer_links = $db->select("footer_links",array("link_section" => "follow","language_id" => $siteLanguage));
            while($row_footer_links = $get_footer_links->fetch()){
            $link_id = $row_footer_links->link_id;
            $icon_class = $row_footer_links->icon_class;
            $link_url = $row_footer_links->link_url;
            ?>
            <a href="<?= $link_url; ?>"><i class="fab <?= $icon_class; ?>"></i></a>
            <?php } ?>
            <!-- <a href="javascript:void(0);"><i class="fab fa-twitter"></i></a>
            <a href="javascript:void(0);"><i class="fab fa-youtube"></i></a>
            <a href="javascript:void(0);"><i class="fab fa-linkedin-in"></i></a>
            <a href="javascript:void(0);"><i class="fab fa-instagram"></i></a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="copyright-area">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-4 col-md-4">
        <div class="copyright">
          <?php if($language_switcher == 1){ 
              if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                   $url = "https://";   
              else  
                   $url = "http://";   
              // Append the host(domain name, ip) to the URL.   
              $url.= $_SERVER['HTTP_HOST'];   
              
              // Append the requested resource location to the URL   
              $url.= $_SERVER['REQUEST_URI'];    
              $full_url = $_SERVER['REQUEST_URI'];
              
              $page_url = substr("$full_url", 1);
            ?>
          <div>

            <select name=""  id="" onChange="window.location.href=this.value">
              
              <option value="" selected="">EN</option>
              <option value="<?= $site_url?>/ar/<?php echo $page_url; ?>">AR</option>
              <!-- <option value="">AR</option> -->
            </select>
          </div>
          <?php } ?>
          <div>
            <select name="" id="">
              <option value="">USD</option>
              <option value="">EGP</option>
            </select>
          </div>
          <div>
            <p><?= $db->select("general_settings")->fetch()->site_copyright; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-link">
          <ul>
            <li>
              <p>Soon On:</p><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/play.png" alt=""></a>
            </li>
            <li><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/apple.png" alt=""></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-link">
          <ul>
            <li>
              <p>Secured With</p><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/paypal.png" alt=""></a>
            </li>
            <li><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/noth.png" alt=""></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer-area END-->
<!-- end footer -->
<!-- <section class="post_footer">
<?= $db->select("general_settings")->fetch()->site_copyright; ?>
</section> -->

<?php if(!isset($_COOKIE['close_cookie'])){ ?>
<!-- <section class="clearfix cookies_footer row animated slideInLeft">
<div class="col-md-4">
<img src="<?= $site_url; ?>/images/cookie.png" class="img-fluid" alt="">
</div>
<div class="col-md-8">
<div class="float-right close btn btn-sm"><i class="fa fa-times"></i></div>
<h4 class="mt-0 mt-lg-2 <?=($lang_dir == "right" ? 'text-right':'')?>"><?= $lang["cookie_box"]['title']; ?></h4>
<p class="mb-1 "><?= str_replace('{link}',"$site_url/terms_and_conditions",$lang["cookie_box"]['desc']); ?></p>
<a href="#" class="btn btn-success btn-sm"><?= $lang["cookie_box"]['button']; ?></a>
</div>
</section> -->
<?php } ?>

<section class="messagePopup animated slideInRight"></section>
<link rel="stylesheet" href="<?= $site_url; ?>/styles/msdropdown.css"/>

<?php 
  
  if($videoPlugin == 1){
    require("$dir/plugins/videoPlugin/footer/videoCall.php"); 
  }

?>

<?php if(!isset($_COOKIE['close_cookie'])){ ?>

<section class="clearfix cookies_footer row animated slideInLeft">

<div class="col-md-4">

<img src="<?php echo $site_url; ?>/images/cookie.png" class="img-fluid" alt="">

</div>

<div class="col-md-8">

<div class="float-right close btn btn-sm"><i class="fa fa-times"></i></div>

<h4 class="mt-0 mt-lg-2">Our site uses cookies</h4>

<p class="mb-1">We use cookies to ensure you get the best experience. By using our website you agree <br>to our <a href='<?php echo $site_url; ?>/terms_and_conditions'>Privacy Policy</a>.</p>

<a href="#" class="btn btn-success btn-sm">Got It.</a>

</div>

</section>

<?php } ?>

<!-- <section class="messagePopup animated slideInRight">
</section> -->

<!-- <link rel="stylesheet" href="<?php echo $site_url; ?>/styles/msdropdown.css"/> -->

 <?php //require("footerJs.php"); ?>
<!-- New Design -->
<!--====== jquery js ======-->
  <!-- <script src="<?= $site_url; ?>/assets/js/jquery.min.js"></script> -->

  <!--====== Popper js ======-->
  <script src="<?= $site_url; ?>/assets/js/Popper.js"></script>

  <!--====== Bootstrap js ======-->
  <script src="<?= $site_url; ?>/assets/js/bootstrap.min.js"></script>

  <!--====== Owl carousel js ======-->
  <script src="<?= $site_url; ?>/assets/js/owl.carousel.min.js"></script>

  <!--====== Nicescroll js ======-->
  <script src="<?= $site_url; ?>/assets/js/jquery.nicescroll.min.js"></script>
  <script>
    $(function() {
      $(".mesagee-item-box").niceScroll({
        cursorcolor: "#D72929",
      });
    });

  </script>

  <script src="<?= $site_url; ?>/assets/js/jquery.nice-select.min.js"></script>
  <script src="<?= $site_url; ?>/assets/js/tagsinput.js"></script>
  <script src="<?= $site_url; ?>/assets/js/ion.rangeSlider.min.js"></script>
  <!--====== Main js ======-->
  <script src="<?= $site_url; ?>/assets/js/main.js"></script>
<!-- End New Design -->
<!-- End New Design -->
<script src="<?= $site_url; ?>/js/msdropdown.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/js/jquery.sticky.js"></script>
<script type="text/javascript" id="custom-js" src="<?= $site_url; ?>/js/customjs.js" data-logged-id="<?php if(isset($_SESSION['seller_user_name'])){ echo $login_seller_id; }?>" data-base-url="<?= $site_url; ?>" data-enable-sound="<?php if(isset($_SESSION['seller_user_name'])){ echo $login_seller_enable_sound; }?>"></script>
<script type="text/javascript" src="<?= $site_url; ?>/js/categoriesProposal.js"></script>
<!-- <script type="text/javascript" src="<?= $site_url; ?>/js/popper.min.js"></script> -->
<script type="text/javascript" src="<?= $site_url; ?>/js/owl.carousel.min.js"></script>
<!-- <script type="text/javascript" src="<?= $site_url; ?>/js/bootstrap.js"></script> -->
<script type="text/javascript" src="<?= $site_url; ?>/js/summernote.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/js/croppie.js"></script>
<script src="<?= $site_url; ?>/assets/js/select2.min.js"></script>
<script>
  $(function(){
    $("#price").ionRangeSlider({
      min: 0,
      max: 50,
      from: 25,
      prefix: "$",
      hide_min_max:true,
    });
    $('.filter-results').on('click', function(){
      $('.gigs-sidebar').addClass('open-mobile');
    });
    $('.backtomain').on('click', function(){
      $(this).parents('.gigs-sidebar').removeClass('open-mobile');
    });
  });
</script>
<script>
$(document).ready(function(){
  $("#languageSelect").change(function(){
    var url = $("#languageSelect option:selected").data("url");
    window.location.href = url;
  });

  $("#languageSelect").msDropdown({visibleRows:4});
  <?php if(isset($_SESSION['seller_user_name'])){ ?>
  var seller_id = "<?= $login_seller_id; ?>";
  var base_url = "<?= $site_url; ?>";
  <?php } ?>

  $(".cookies_footer .btn").click(function(){
    $.ajax({
    method: "POST",
    url: "<?= $site_url; ?>/includes/close_cookies_footer",
    data: {close : 'close'}
    }).done(function(data){
      $(".cookies_footer").fadeOut();
    });
  });

  $('.curreny_convert').change(function(){
    var value = $(this).children("option:selected").val();
    
    $.ajax({                   
        type: 'POST',          
        url: "<?php echo $site_url; ?>/includes/change_currency",
        data: {toCurrency: value}, 
        success: function (response) { 
          console.log(response);
          location.reload();
          
        }
    });

  });
  
});
<?php if(!isset($proposals_stylesheet)){ ?>
$(window).scroll(function(){
  var scrollTop = $(window).scrollTop();
  if(scrollTop > 0){
    $('.home-header').addClass('affix')
  }else{
    $('.home-header').removeClass('affix')
  }
});
<?php } ?>
</script>