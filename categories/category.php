<?php
  session_start();
  require_once("../includes/db.php");
  require_once("../functions/functions.php");

  $seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_name = $row_login_seller->seller_name;
  $login_user_name = $row_login_seller->seller_user_name;

  $cat_page_url = $input->get('cat_url');
  
  if(isset($_GET['cat_url'])){
    unset($_SESSION['cat_child_id']);
    $get_cat = $db->select("categories",array('cat_url' => $input->get('cat_url')));
    $cat_id = $get_cat->fetch()->cat_id;
    $_SESSION['cat_id']=$cat_id;
    $page_cat_id = $cat_id;
    
  }
  if(isset($_GET['cat_child_url'])){
    unset($_SESSION['cat_id']);
    $get_cat = $db->select("categories",array('cat_url' => $input->get('cat_url')));
    $cat_id = $get_cat->fetch()->cat_id;
    $get_child = $db->select("categories_children",array('child_parent_id'=>$cat_id,'child_url'=>$input->get('cat_child_url')));
    $_SESSION['cat_child_id']= $get_child->fetch()->child_id;
  }
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <?php
    if(isset($_SESSION['cat_id'])){
    $cat_id = $_SESSION['cat_id'];
    $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
    $row_meta = $get_meta->fetch();
    $cat_title = $row_meta->cat_title;
    $cat_desc = $row_meta->cat_desc;
    ?>
  <title><?php echo $site_name; ?> - <?php echo $cat_title; ?>  </title>
  <meta name="description" content="<?php echo $cat_desc; ?>" >
  <?php } ?>
  <?php
    if(isset($_SESSION['cat_child_id'])){
    $cat_child_id = $_SESSION['cat_child_id'];
    $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
    $row_meta = $get_meta->fetch();
    $child_title = $row_meta->child_title;
    $child_desc = $row_meta->child_desc;
    ?>
  <title><?php echo $site_name; ?> - <?php echo $child_title; ?></title>
  <meta name="description" content="<?php echo $child_desc; ?>" >
  <?php } ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="<?php echo $site_author; ?>">
  
  <!-- ==============Google Fonts============= -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
  <!--====== Bootstrap css ======-->
  <link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="<?= $site_url; ?>/ar/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="<?= $site_url; ?>/styles/bootstrap.css" rel="stylesheet"> -->
  <!-- <link href="<?= $site_url; ?>/styles/custom.css" rel="stylesheet"> -->
  <!-- Custom css code from modified in admin panel --->
  <link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/styles/categories_nav_styles.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= $site_url; ?>/styles/sweat_alert.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="<?= $site_url; ?>/js/ie.js"></script>
  <script type="text/javascript" src="<?= $site_url; ?>/js/sweat_alert.js"></script>
  <script type="text/javascript" src="<?= $site_url; ?>/js/jquery.min.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="<?= $site_url; ?>/images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.swal2-popup .swal2-select{display: none;}.cat-nav .top-nav-item{margin-top: 0;}.header-menu .mainmenu ul li a{font-size: 15px;}.cat-nav .top-nav-item.active {border-bottom: 3px solid #ff0000;}.ui-toolkit h1, .ui-toolkit .h1, .ui-toolkit h2, .ui-toolkit .h2, .ui-toolkit h3, .ui-toolkit .h3 {font-weight: 600 !important;}#sub-cat .nice-select{display: none;}#sub-cat #sub-category{height: 45px;}</style>
</head>
<body class="all-content">
  <!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
      <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
    </div>
  </div>
  <!-- Preloader End -->
  <?php
    if(isset($_SESSION['seller_user_name'])){
    require_once("../includes/buyer-header.php");
   }else{
    require_once("../includes/header_with_categories.php");
   }
  ?>

<!-- all-gigs-area Start-->

  <div class="all-gigs-banner pt-30 pb-20">
    <div class="container">
      <div class="gigs-banner align-items-center d-sm-flex justify-content-between">
        <?php
          if(isset($_SESSION['cat_id'])){
          $cat_id = $_SESSION['cat_id'];
          $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $cat_title = $row_meta->cat_title;
          $cat_desc = $row_meta->cat_desc;
          ?>
          <div class="banner-title mt-20">
            <h3 class="title"><?php echo $cat_title; ?></h3>
          </div>
          <div class="banner-breadcrumb mt-20">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="javascript:void(0);">eMongez</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);"><?= $cat_title; ?></a></li>
            </ol>
          </div>
        <?php } ?>
        <?php
          if(isset($_SESSION['cat_child_id'])){
          $cat_child_id = $_SESSION['cat_child_id'];
          $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $child_title = $row_meta->child_title;
          $child_desc = $row_meta->child_desc;
        ?>
        <div class="banner-title mt-20">
          <h3 class="title"><?php echo $child_title; ?></h3>
        </div>
        <div class="banner-breadcrumb mt-20">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">eMongez</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);"><?= $child_title; ?></a></li>
          </ol>
        </div>
        <?php } ?>
        
        
      </div>
    </div>
  </div>

  <!-- all-gigs-area end -->
<!-- all-gigs-area Start-->

  <div class="all-gigs-area pb-60">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-3">
          <?php require_once("../includes/category_sidebar.php"); ?>
        </div>
        <div class="col-12 col-lg-9">
          <div class="all-gigs">
            <div class="row" id="category_proposals">
              <?php get_category_proposals(); ?>
            </div>
          </div>
          <div class="all-gigs-small hide">
            <div class="row">
              <?php get_category_proposals_mobile(); ?>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-12">
              <div class="gigs-more text-center mt-50">
                <!-- <a href="javascript:void(0);">Load more gigs</a> -->
              </div>
              <nav>
                <!-- nav Starts -->
                <ul class="pagination" id="category_pagination">
                  <?php get_category_pagination(); ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- all-gigs-area end -->
<div class="container-fluid mt-5" style="display: none;">
  <!-- Container start -->
  <div class="row">
    <div class="col-md-12">
      <center>
        <?php
          if(isset($_SESSION['cat_id'])){
          $cat_id = $_SESSION['cat_id'];
          $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $cat_title = $row_meta->cat_title;
          $cat_desc = $row_meta->cat_desc;
          ?>
        <h1> <?php echo $cat_title; ?> </h1>
        <p class="lead"><?php echo $cat_desc; ?></p>
        <?php } ?>
        <?php
          if(isset($_SESSION['cat_child_id'])){
          $cat_child_id = $_SESSION['cat_child_id'];
          $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $child_title = $row_meta->child_title;
          $child_desc = $row_meta->child_desc;
          ?>
        <h1> <?php echo $child_title; ?> </h1>
        <p class="lead"><?php echo $child_desc; ?></p>
        <?php } ?>
      </center>
      <hr class="mt-5 pt-2">
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-3 col-md-4 col-sm-12 <?=($lang_dir == "right" ? 'order-2 order-sm-1':'')?>">
      <?php require_once("../includes/category_sidebar.php"); ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-12 <?=($lang_dir == "right" ? 'order-1 order-sm-2':'')?>">
      <div class="row flex-wrap <?=($lang_dir == "right" ? 'justify-content':'')?>" id="category_proposals">
        <?php get_category_proposals(); ?>
      </div>
      <div id="wait"></div>
      <br>
      <div class="row justify-content-center mb-5 mt-0">
        <!-- row justify-content-center Starts -->
        <nav>
          <!-- nav Starts -->
          <ul class="pagination" id="category_pagination">
            <?php get_category_pagination(); ?>
          </ul>
        </nav>
        <!-- nav Ends -->
      </div>
    </div>
  </div>
</div>
<!-- Container ends -->
<div class="append-modal"></div>
<?php require_once("../includes/footer.php"); ?>
<script>
  // var switchStatus = false;
// $("#switch").on('change', function() {
//     if ($(this).is(':checked')) {
//         switchStatus = $(this).is(':checked');
//         alert(switchStatus);
//     }
//     else {
//        switchStatus = $(this).is(':checked');
//        alert(switchStatus);
//     }
// });
  function get_category_proposals(){
  
  var sPath = ''; 
  
  // var aInputs = $('li').find('.get_online_sellers');
  var aInputs = $('.get_online_sellers');

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
  
  
  var cat_url = "<?php echo $input->get('cat_url'); ?>";
  
  sPath = sPath + 'cat_url=' + cat_url +'&';
  
  <?php if(isset($_REQUEST['cat_child_url'])){ ?>
  
  var cat_child_url = "<?php echo $input->get('cat_child_url'); ?>";
  
  sPath = sPath+ 'cat_child_url='+ cat_child_url +'&';
  
  var url_plus = "../";
  
  <?php }else{ ?>
  
  var url_plus = "";
  
  <?php } ?>
  
  
  var aInputs = Array();
  
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
  
  url: url_plus + "../category_load",  
  method:"POST",  
  data: sPath+'zAction=get_category_proposals',  
  success:function(data){
  
  $('#category_proposals').html('');  
  
  $('#category_proposals').html(data);
  
  $('#wait').removeClass("loader");
  
  }  
  
  });							  
  
  $.ajax({  
  
  url: url_plus + "../category_load",  
  method:"POST",  
  data: sPath+'zAction=get_category_pagination',  
  success:function(data){  
  
  $('#category_pagination').html('');  
  
  $('#category_pagination').html(data); 
  
  }  
  
  });
  
  }

  function get_search_category_proposals(){
  
  var sPath = ''; 
  
  // var aInputs = $('li').find('.get_online_sellers');
  var aInputs = $('.get_online_sellers');

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
  
  
  var cat_url = "<?php echo $input->get('cat_url'); ?>";
  
  sPath = sPath + 'cat_url=' + cat_url +'&';
  
  <?php if(isset($_REQUEST['cat_child_url'])){ ?>
  
  var cat_child_url = "<?php echo $input->get('cat_child_url'); ?>";
  
  sPath = sPath+ 'cat_child_url='+ cat_child_url +'&';
  
  var url_plus = "../";
  
  <?php }else{ ?>
  
  var url_plus = "";
  
  <?php } ?>
  
  
  var aInputs = Array();
  
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
  
  url: url_plus + "../category_load",  
  method:"POST",  
  data: sPath+'zAction=get_search_category_proposals',  
  success:function(data){
  
  $('#category_proposals').html('');  
  
  $('#category_proposals').html(data);
  
  $('#wait').removeClass("loader");
  
  }  
  
  });               
  
  $.ajax({  
  
  url: url_plus + "../category_load",  
  method:"POST",  
  data: sPath+'zAction=get_category_pagination',  
  success:function(data){  
  
  $('#category_pagination').html('');  
  
  $('#category_pagination').html(data); 
  
  }  
  
  });
  
  }

  
  $('.get_online_sellers').click(function(){ 
  
  get_category_proposals(); 
  
  });
  
  $('.get_delivery_time').click(function(){ 
  
  get_category_proposals(); 
  
  }); 
  
  $('.get_seller_level').click(function(){ 
  
  get_category_proposals(); 
  
  }); 
  
  $('.get_seller_language').click(function(){ 
  
  get_category_proposals(); 
  
  });


  function getgig(){

    var getUrl = '<?php echo $site_url; ?>';
    var keyword = $('#keyword').val();
    
    var sPath = ''; 
    
    // var aInputs = $('li').find('.get_online_sellers');
    var aInputs = $('.get_online_sellers');

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
    
    
    var cat_url = "<?php echo $input->get('cat_url'); ?>";
    
    sPath = sPath + 'cat_url=' + cat_url +'&';
    
    <?php if(isset($_REQUEST['cat_child_url'])){ ?>
    
    var cat_child_url = "<?php echo $input->get('cat_child_url'); ?>";
    
    sPath = sPath+ 'cat_child_url='+ cat_child_url +'&';
    
    var url_plus = "../";
    
    <?php }else{ ?>
    
    var url_plus = "";
    
    <?php } ?>
    
    
    var aInputs = Array();
    
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
    if (keyword == '') {
      $.ajax({  
      
      url: url_plus + "../category_load",  
      method:"POST",  
      data: sPath+'zAction=get_category_proposals',  
      success:function(data){
      
      $('#category_proposals').html('');  
      
      $('#category_proposals').html(data);
      
      $('#wait').removeClass("loader");
      
      }  
      
      });
    }else {
      // alert(keyword);

      $.ajax({
       method:"post",  
       data: {keyword:keyword},  
       url: url_plus + "../category_load?zAction=get_search_proposals",  
       success:function(data){
       // console.log(data);  
       
       $('#category_proposals').html('');  
       
       $('#category_proposals').html(data); 
       
       }
     });
    }

  }
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
    get_category_proposals();
  }
  function clearDelivery(){
    $('.get_delivery_time').prop('checked',false);
    get_category_proposals();
  }
  function clearLevel(){
    $('.get_seller_level').prop('checked',false);
    get_category_proposals();
  }
  function clearLanguage(){
    $('.get_seller_language').prop('checked',false);
    get_category_proposals();
  }

  $("#sub-category").hide();

  $("#category").change(function(){
    var base_url = '<?php echo $site_url;  ?>';
    
   $("#sub-category").show();  
   var category_id = $(this).val();
   
   $('.cat_hide').addClass('d-none');
   $('#sub-cat').addClass('d-block');
   $.ajax({
   url:base_url+"/categories/fetch_subcategory",
   method:"POST",
   data:{category_id:category_id},
   success:function(data){
    console.log(data);
   $('#sub-category').html(data);
   }
   });

  });

 


</script>
</body>
</html>