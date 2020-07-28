<?php
session_start();
require_once("includes/db.php");
require_once("functions/functions.php");
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
<head>
<title> <?= $site_name; ?> - Freelancers </title>
<meta name="description" content="">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="<?= $get_site_author; ?>">
  <!--====== Favicon Icon ======-->
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="<?= $site_url; ?>/images/<?= $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
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
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/tagsinput.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/ar/assets/css/style1.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
  <!-- <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="<?= $site_url; ?>/ar/styles/styles.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/ar/styles/user_nav_styles.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/ar/font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/ar/styles/owl.carousel.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/ar/styles/owl.theme.default.css" rel="stylesheet">
  <script type="text/javascript" src="<?= $site_url; ?>/js/jquery.min.js"></script>
  <style>
    .checkbox-success input[type="checkbox"]:checked + span::before {
        background-color: #ff0707;
        border-color: #ff0707;
    }
  </style>
</head>

<body class="all-content">
<?php require_once("includes/buyer-header.php"); ?>
<main class="emongez-content-main">
  <section class="container-fluid search-results">
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-4 col-lg-3">
            <?php require_once("includes/freelancer_sidebar.php"); ?>
          </div>
          <div class="col-12 col-md-8 col-lg-9">
            <div class="search-results-header">
              <!-- <h3>Result for <span>"maria"</span></h3> -->
              <!-- <div class="contains d-flex flex-row align-items-center">
                <div class="icon">
                  <img alt="" class="img-fluid d-block" src="assets/img/search/search-results-icon.png" />
                </div>
                <div class="text">Search gigs containing <span>"maria"</span></div>
              </div> -->
              <h4>صفحات مقدمي الخدمة</h4>
            </div>
            <div class="row" id="freelancers">
              <?php get_freelancers(); ?>
              
              <div id="wait"></div>
              <!-- Each item -->
            </div>
            <div class="row">
              <div class="col-12">
                <div class="search-results-pagination">
                  <ul class="pagination" id="freelancer_pagination">
                    <?php get_freelancer_pagination(); ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<!-- <div class="container-fluid mt-5">
  <div class="row">
    <div class="col-md-12">
      <center>
      <h1> Freelancers </h1>
      <p class="lead">Home / Search Freelancers</p>
      </center>
      <hr class="mt-5 pt-2">
    </div>
  </div>
  <div class="row mt-3 justify-content-center">
    
    <div class="col-xl-10 col-lg-12 col-md-12">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 <?=($lang_dir == "right" ? 'order-2 order-sm-1':'')?>">
          <?php //require_once("includes/freelancer_sidebar.php"); ?>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 <?=($lang_dir == "right" ? 'order-1 order-sm-2':'')?>">
          <div class="row flex-wrap" id="freelancers">
            
            <?php //get_freelancers(); ?>
          </div>
          <div id="wait"></div>
          <br>
          <div class="row justify-content-center mb-5 mt-0">
            <nav>
              <ul class="pagination" id="freelancer_pagination">
                
                <?php //get_freelancer_pagination(); ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- Container ends -->
<?php require_once("includes/footer.php"); ?>
<script>
  function get_freelancers(){
    var sPath = '';
    var aInputs = Array();
    
    var aInputs = $('li').find('.get_online_sellers');
    var aKeys   = Array();
    var aValues = Array();
    iKey = 0;
    $.each(aInputs,function(key,oInput){
      if(oInput.checked){
        aKeys[iKey] =  oInput.value
      };
      iKey++;
    });
    if(aKeys.length>0){
      var sPath = '';
      for(var i = 0; i < aKeys.length; i++){
        sPath = sPath + 'online_sellers[]=' + aKeys[i]+'&';
      }
    }

    var aInputs = $('li').find('.get_seller_country');
    var aKeys   = Array();
    var aValues = Array();
    iKey = 0;
    $.each(aInputs,function(key,oInput){
      if(oInput.checked){
      aKeys[iKey] = oInput.value
      };
      iKey++;
    });
    if(aKeys.length>0){
      for(var i = 0; i < aKeys.length; i++){
      sPath = sPath + 'seller_country[]=' + aKeys[i]+'&';
      }
    }

    var aInputs = Array();
    var aInputs = $('li').find('.get_seller_level');
    var aKeys   = Array();
    var aValues = Array();
    iKey = 0;
    $.each(aInputs,function(key,oInput){
      if(oInput.checked){
      aKeys[iKey] =  oInput.value
      };
      iKey++;
    });
    if(aKeys.length>0){
      for(var i = 0; i < aKeys.length; i++){
        sPath = sPath + 'seller_level[]=' + aKeys[i]+'&';
      }
    }

    var aInputs = Array();
    var aInputs = $('li').find('.get_seller_language');
    var aKeys   = Array();
    var aValues = Array();
    iKey = 0;
    $.each(aInputs,function(key,oInput){
      if(oInput.checked){
      aKeys[iKey] =  oInput.value
      };
      iKey++;
    });
    if(aKeys.length>0){
      for(var i = 0; i < aKeys.length; i++){
      sPath = sPath + 'seller_language[]=' + aKeys[i]+'&';
      }
    }

    $('#wait').addClass("loader");
    $.ajax({  
      url:"freelancer_load",  
      method:"POST",  
      data: sPath+'zAction=get_freelancers',  
      success:function(data){
      $('#freelancers').html('');  
      $('#freelancers').html(data); 
      $('#wait').removeClass("loader");
      }  
    });                           
    $.ajax({  
      url:"freelancer_load",  
      method:"POST",  
      data: sPath+'zAction=get_freelancer_pagination',  
      success:function(data){  
      $('#freelancer_pagination').html('');  
      $('#freelancer_pagination').html(data); 
      }  
    });
  }

  $('.get_online_sellers').click(function(){ 
   get_freelancers(); 
  });
  $('.get_seller_country').click(function(){ 
   get_freelancers(); 
  });
  $('.get_delivery_time').click(function(){ 
   get_freelancers(); 
  });
  $('.get_seller_level').click(function(){ 
    get_freelancers(); 
  }); 
  $('.get_seller_language').click(function(){ 
    get_freelancers(); 
  });

  $(document).ready(function(){
  $(".get_seller_country").click(function(){
    if($(".get_seller_country:checked").length > 0 ) {
      $(".clear_seller_country").show();
    }else{
      $(".clear_seller_country").hide();
    }
  });
  $(".get_delivery_time").click(function(){
    if($(".get_delivery_time:checked").length > 0 ) {
      $(".clear_delivery_time").show();
    }else{
      $(".clear_delivery_time").hide();
    }
  });
  $(".get_seller_level").click(function(){
    if($(".get_seller_level:checked").length > 0 ) {
      $(".clear_seller_level").show();
    }else{
      $(".clear_seller_level").hide();
    }
  });
  $(".get_seller_language").click(function(){
    if($(".get_seller_language:checked").length > 0 ) {
      $(".clear_seller_language").show();
    }else{
      $(".clear_seller_language").hide();
    }
  });
  $(".clear_seller_country").click(function(){
    $(".clear_seller_country").hide();
  });
  $(".clear_delivery_time").click(function(){
    $(".clear_delivery_time").hide();
  });
  $(".clear_seller_level").click(function(){
    $(".clear_seller_level").hide();
  });
  $(".clear_seller_language").click(function(){
    $(".clear_seller_language").hide();
  });
  });
  function clearCountry(){
  $('.get_seller_country').prop('checked',false);
  get_freelancers(); 
  }
  function clearDelivery(){
  $('.get_delivery_time').prop('checked',false);
  get_freelancers(); 
  }
  function clearLevel(){
  $('.get_seller_level').prop('checked',false);
  get_freelancers(); 
  }
  function clearLanguage(){
  $('.get_seller_language').prop('checked',false);
  get_freelancers(); 
  }
</script>
</body>
</html>