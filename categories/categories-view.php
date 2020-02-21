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
  
  if(isset($_GET['cat_url'])){
    unset($_SESSION['cat_child_id']);
    $get_cat = $db->select("categories",array('cat_url' => $input->get('cat_url')));
    $cat_id = $get_cat->fetch()->cat_id;
    $cat_url = $input->get('cat_url');

    $_SESSION['cat_id']=$cat_id;
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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="<?php echo $site_author; ?>">
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">
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
  <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.swal2-popup .swal2-select{display: none;}.cat-nav .top-nav-item{margin-top: 0;}.header-menu .mainmenu ul li a{font-size: 15px;}.cat-nav .top-nav-item.active {border-bottom: 3px solid #ff0000;}.ui-toolkit h1, .ui-toolkit .h1, .ui-toolkit h2, .ui-toolkit .h2, .ui-toolkit h3, .ui-toolkit .h3 {font-weight: 600 !important;}</style>
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
  require_once("../includes/header-top.php");
 }
?>

<!-- Sub Categories view -->
<div class="subcategories-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-6 text-center">
        <div class="subcategories-title">
          <?php
            if(isset($_SESSION['cat_id'])){
            $cat_id = $_SESSION['cat_id'];
            $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
            $row_meta = $get_meta->fetch();
            $cat_title = $row_meta->cat_title;
            $cat_desc = $row_meta->cat_desc;
            ?>
          <h2><?php echo $cat_title; ?></h2>
          <p><?php echo $cat_desc; ?></p>
          <?php } ?>
          <?php
            if(isset($_SESSION['cat_child_id'])){
            $cat_child_id = $_SESSION['cat_child_id'];
            $get_meta = $db->select("child_cats_meta",array("child_id" => $cat_child_id,"language_id" => $siteLanguage));
            $row_meta = $get_meta->fetch();
            $child_title = $row_meta->child_title;
            $child_desc = $row_meta->child_desc;
            ?>
          <h2> <?php echo $child_title; ?> </h2>
          <p><?php echo $child_desc; ?></p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-4">
        <div class="graphic-design-text">
          <h3><?php echo $cat_title; ?></h3>
          <?php
            $get_child_cat = $db->select("categories_children",array("child_parent_id" => $cat_id));
            while($row_child_cat = $get_child_cat->fetch()){
              $cat_url = $input->get('cat_url');
              $child_id = $row_child_cat->child_id;
              $child_url = $row_child_cat->child_url;
              $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
              $row_meta = $get_meta->fetch();
              $child_title = $row_meta->child_title;
              if(!empty($child_title)){
          ?>
          <a href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>"><?php echo $child_title; ?></a>
          <?php }} ?>
          
        </div>
      </div>
      <div class="col-lg-9 col-md-8">
        <div class="row">
          <?php
            $get_child_cat = $db->select("categories_children",array("child_parent_id" => $cat_id));
            while($row_child_cat = $get_child_cat->fetch()){
              
              $child_id = $row_child_cat->child_id;
              $child_url = $row_child_cat->child_url;
              $child_image = $row_child_cat->child_image;
              $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
              $row_meta = $get_meta->fetch();
              $child_title = $row_meta->child_title;
              if(!empty($child_title)){
          ?>
          <div class="col-lg-3 col-md-6 ">
            <div class="subcategories-item">
              <a href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>">
                <img src="<?= $site_url; ?>/assets/img/subcategories/<?php echo $child_image; ?>" alt="">
                <p><?php echo $child_title; ?></p>
              </a>
            </div>
          </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Sub Categories view -->
<!-- Container ends -->
<div class="append-modal"></div>
<?php require_once("../includes/footer.php"); ?>
<?php require_once("../includes/footerJs.php"); ?>
<script>
  function get_category_proposals(){
  
  var sPath = ''; 
  
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
</script>
</body>
</html>