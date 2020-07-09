<?php
if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_enable_sound = $row_login_seller->enable_sound;
}
?>

<!-- New Design -->
<!--====== jquery js ======-->
  <script src="<?= $site_url; ?>/ar/assets/js/jquery.min.js"></script>

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
<script src="<?= $site_url; ?>/ar/js/msdropdown.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/jquery.sticky.js"></script>
<script type="text/javascript" id="custom-js" src="<?= $site_url; ?>/ar/js/customjs.js" data-logged-id="<?php if(isset($_SESSION['seller_user_name'])){ echo $login_seller_id; }?>" data-base-url="<?= $site_url; ?>" data-enable-sound="<?php if(isset($_SESSION['seller_user_name'])){ echo $login_seller_enable_sound; }?>"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/categoriesProposal.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/popper.min.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/bootstrap.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/summernote.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/croppie.js"></script>
<script type="text/javascript" src="<?= $site_url; ?>/ar/js/exif.js"></script>
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
        url: "<?php echo $site_url; ?>/ar/includes/change_currency",
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