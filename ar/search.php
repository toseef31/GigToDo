<?php
session_start();
require_once("includes/db.php");
require_once("functions/functions.php");

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - Search Results For <?php echo @$_SESSION["search_query"]; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
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
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <link href="styles/categories_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
</head>
<body class="all-content">

<?php
    if(isset($_SESSION['seller_user_name'])){
    require_once("includes/buyer-header.php");
   }else{
    require_once("includes/header_with_categories.php");
   }
  ?>

<div class="all-gigs-area pb-60">
<div class="container"> <!-- Container start -->
  <div class="row mt-3">
    <div class="col-md-12">
      <center>
        <h1>Search Results</h1>
        <p class="lead pb-5"> "<?php echo @$_SESSION["search_query"]; ?>" </p>
      </center>
      <hr>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-3 col-md-4 col-sm-12 <?=($lang_dir == "right" ? 'order-2 order-sm-1':'')?>">
      <?php require_once("includes/search_sidebar.php");?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 <?=($lang_dir == "right" ? 'order-1 order-sm-2':'')?>">
      <div class="all-gigs">
        <div class="row flex-wrap" id="search_proposals">
          <?php get_search_proposals(); ?>
        </div>
      </div>

      <div class="all-gigs-small">
        <div class="row" id="search_proposals_mobile">
          <?php get_search_proposals_mobile(); ?>
          <!-- Each item -->
        </div>
      </div>

      <div id="wait"></div>
      <br>
      <div class="row justify-content-center mb-5 mt-0">
        <nav>
          <ul class="pagination" id="search_pagination">
            <?php get_search_pagination(); ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
</div><!-- Container ends -->

<div class="append-modal"></div>
<?php require_once("includes/footer.php"); ?>
  
<script>
function get_search_proposals(){
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

  var aInputs = $('li').find('.get_cat_id');
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
  sPath = sPath + 'cat_id[]=' + aKeys[i]+'&';
  }
  }

  var aInputs = $('li').find('.get_delivery_time');
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
  sPath = sPath + 'delivery_time[]=' + aKeys[i]+'&';
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
  url:"search_load",  
  method:"POST",  
  data: sPath+'zAction=get_search_proposals',  
  success:function(data){
  $('#search_proposals').html('');  
  $('#search_proposals').html(data); 
  $('#wait').removeClass("loader");
  }  
  });  

  $.ajax({  
  url:"search_load",  
  method:"POST",  
  data: sPath+'zAction=get_search_pagination',  
  success:function(data){  
  $('#search_pagination').html('');  
  $('#search_pagination').html(data); 
  }  
  });
}

$('.get_online_sellers').click(function(){ 
get_search_proposals(); 
});
$('.get_cat_id').click(function(){ 
get_search_proposals(); 
});
$('.get_delivery_time').click(function(){ 
get_search_proposals(); 
});
$('.get_seller_level').click(function(){ 
get_search_proposals(); 
}); 
$('.get_seller_language').click(function(){ 
get_search_proposals(); 
});


function get_search_proposals_mobile(){
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

  var aInputs = $('li').find('.get_cat_id');
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
  sPath = sPath + 'cat_id[]=' + aKeys[i]+'&';
  }
  }

  var aInputs = $('li').find('.get_delivery_time');
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
  sPath = sPath + 'delivery_time[]=' + aKeys[i]+'&';
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
  url:"search_load",  
  method:"POST",  
  data: sPath+'zAction=get_search_proposals_mobile',  
  success:function(data){
  $('#search_proposals_mobile').html('');  
  $('#search_proposals_mobile').html(data); 
  $('#wait').removeClass("loader");
  }  
  });  

  $.ajax({  
  url:"search_load",  
  method:"POST",  
  data: sPath+'zAction=get_search_pagination',  
  success:function(data){  
  $('#search_pagination').html('');  
  $('#search_pagination').html(data); 
  }  
  });
}

$('.get_online_sellers').click(function(){ 
get_search_proposals_mobile(); 
});
$('.get_cat_id').click(function(){ 
get_search_proposals_mobile(); 
});
$('.get_delivery_time').click(function(){ 
get_search_proposals_mobile(); 
});
$('.get_seller_level').click(function(){ 
get_search_proposals_mobile(); 
}); 
$('.get_seller_language').click(function(){ 
get_search_proposals_mobile(); 
});

</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".get_cat_id").click(function(){
    if($(".get_cat_id:checked").length > 0 ) {
      $(".clear_cat_id").show();
    }
    else{
      $(".clear_cat_id").hide();
    }
  });
  $(".get_delivery_time").click(function(){
    if($(".get_delivery_time:checked").length > 0 ) {
      $(".clear_delivery_time").show();
    }
    else{
      $(".clear_delivery_time").hide();
    }
  });
  $(".get_seller_level").click(function(){
    if($(".get_seller_level:checked").length > 0 ) {
      $(".clear_seller_level").show();
    }
    else{
      $(".clear_seller_level").hide();
    }
  });
  $(".get_seller_language").click(function(){
    if($(".get_seller_language:checked").length > 0 ) {
      $(".clear_seller_language").show();
    }
    else{
      $(".clear_seller_language").hide();
    }
  });
  $(".clear_cat_id").click(function(){
    $(".clear_cat_id").hide();
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

function clearCat(){
$('.get_cat_id').prop('checked',false);
  get_search_proposals(); 
}
function clearDelivery(){
$('.get_delivery_time').prop('checked',false);
  get_search_proposals(); 
}
function clearLevel(){
  $('.get_seller_level').prop('checked',false);
  get_search_proposals(); 
}
function clearLanguage(){
  $('.get_seller_language').prop('checked',false); 
  get_search_proposals(); 
}
</script>
</body>
</html>