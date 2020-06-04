
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

<link rel="stylesheet" href="<?php echo $site_url; ?>/styles/msdropdown.css"/>

<?php //require("footerJs.php"); ?>
<!-- New Design -->
<!--====== jquery js ======-->
  <!-- <script src="<?= $site_url; ?>/assets/js/jquery.min.js"></script> -->

  <!--====== Popper js ======-->
  <script src="<?= $site_url; ?>/ar/assets/js/Popper.js"></script>

  <!--====== Bootstrap js ======-->
  <script src="<?= $site_url; ?>/ar/assets/js/bootstrap.min.js"></script>

  <!--====== Owl carousel js ======-->
  <script src="<?= $site_url; ?>/ar/assets/js/owl.carousel.min.js"></script>

  <!--====== Nicescroll js ======-->
  <script src="<?= $site_url; ?>/ar/assets/js/jquery.nicescroll.min.js"></script>
  <script>
    $(function() {
      $(".mesagee-item-box").niceScroll({
        cursorcolor: "#D72929",
      });
    });

  </script>

  <script src="<?= $site_url; ?>/ar/assets/js/jquery.nice-select.min.js"></script>
  <script src="<?= $site_url; ?>/ar/assets/js/tagsinput.js"></script>
  <script src="<?= $site_url; ?>/ar/assets/js/ion.rangeSlider.min.js"></script>
  <!--====== Main js ======-->
  <script src="<?= $site_url; ?>/ar/assets/js/main.js"></script>
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