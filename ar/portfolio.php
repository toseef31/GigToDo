<?php
session_start();
require_once("includes/db.php");
require_once("functions/functions.php");

if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;

  $login_user_type = $row_login_seller->account_type;
  $login_seller_name = $row_login_seller->seller_name;
  $login_user_name = $row_login_seller->seller_user_name;
  $login_seller_offers = $row_login_seller->seller_offers;
  $relevant_requests = $row_general_settings->relevant_requests;


}

?>
<?php
$get_seller_user_name = $input->get('seller_user_name');

$select_seller = $db->select("sellers",array("seller_user_name" => $get_seller_user_name)); 
$row_seller = $select_seller->fetch();
$get_seller_id = $row_seller->seller_id;

$get_seller_user_name = $row_seller->seller_user_name;
$get_seller_image = $row_seller->seller_image;
$get_seller_cover_image = $row_seller->seller_cover_image;
if(empty($seller_cover_image)){ 
$get_seller_cover_image = "images/user-background.jpg";
}else{
$get_seller_cover_image = "cover_images/".rawurlencode($seller_cover_image)."";
}
$get_seller_country = $row_seller->seller_country;
$get_seller_state = $row_seller->seller_state;
$get_seller_city = $row_seller->seller_city;
$get_seller_headline = $row_seller->seller_headline;
$get_seller_about = $row_seller->seller_about;
$get_seller_level = $row_seller->seller_level;
$get_seller_rating = $row_seller->seller_rating;
$get_seller_register_date = $row_seller->seller_register_date;
$get_seller_recent_delivery = $row_seller->seller_recent_delivery;

$get_seller_status = $row_seller->seller_status;


?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - <?php echo ucfirst($get_seller_user_name) . "'s Profile"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  
  <!--====== Favicon Icon ======-->
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <!--====== Bootstrap css ======-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!--====== PreLoader css ======-->
  <link href="assets/css/preloader.css" rel="stylesheet">
  <!--====== Animate css ======-->
  <link href="assets/css/animate.min.css" rel="stylesheet">
  <!--====== Fontawesome css ======-->
  <link href="assets/css/fontawesome.min.css" rel="stylesheet">
  <!--====== Owl carousel css ======-->
  <link href="assets/css/owl.carousel.min.css" rel="stylesheet">
  <!--====== Nice select css ======-->
  <link href="assets/css/nice-select.css" rel="stylesheet">
  <!--====== Range Slider css ======-->
  <link href="assets/css/ion.rangeSlider.min.css" rel="stylesheet">
  <!--====== Default css ======-->
  <link href="assets/css/default.css" rel="stylesheet">
  <!--====== Style css ======-->
  <link href="assets/css/style.css" rel="stylesheet">
  <!--====== Responsive css ======-->
  <link href="assets/css/responsive.css" rel="stylesheet">
  <!-- <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet">  -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <!-- <link href="styles/proposalStyles.css" rel="stylesheet">
  <link href="styles/categories_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
  <link href="<?php echo $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
  <link href="<?php echo $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <link href="styles/croppie.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/croppie.js"></script>
  <style>.sub_cat .nice-select{display: none;}
    #file_name span{
      width: 130px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      display: inline-block;
    }
    #category{
      display: block !important;
    }
    .crop_image{
        background-color: #ff0707;
        border-color: #ff0707;
        color: white;
    }
  </style>
</head>
<body class="all-content">  
  <!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
      <img src="assets/img/emongez_cube.png" />
    </div>
  </div>
  <!-- Preloader End -->      
<?php //require_once("includes/header.php");
  if(isset($_SESSION['seller_user_name'])){ 
    if($login_user_type == 'seller'){ 
      require_once('includes/user_header.php');
    }else{
      require_once("includes/buyer-header.php");
    }
  }else{
    require_once("includes/header_with_categories.php");
  }
?>

<!--  SELLER PROFILE area -->
  <main>
    <section class="container-fluid portfolio">
      <div class="row">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12 col-lg-6 portfolio-header">
              <h1 class="text-center">ابني ملف العرض بتاعك</h1>
              <!-- <p class="text-center">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humou.</p> -->
            </div>
          </div>
          <!-- Row -->
          <div class="row">
            <div class="col-12">
              <div class="portfolio-wrapper">
                <form method="POST" action="">
                  <label class="file-upload" for="uploadFile">
                    <input hidden type="file" id="uploadFile" name="portfolio_img">
                    <div class="upload-icon">
                      <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/portfolio/upload-icon.png" />
                    </div>
                    <h5 class="text-center">ارفع صورة</h5>
                    <div class="d-flex flex-row justify-content-center">
                      <div class="browse-button">ارفع</div>
                    </div>
                    <p class="text-center"><strong>لاحظ:</strong> اسم الصورة هيتعرض على انه عنوان عمل فني</p>
                  </label>
                </form>
                <div class="suggestion d-flex flex-row align-content-start">
                  <span>
                    <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/portfolio/warning-icon.png" />
                  </span>
                  <span>أقل أبعاد للصورة المفروض تكون: 500 عرض و 800 طول</span>
                </div>
                <div class="row gallery">
                  <?php 
                    $select_portfolio = $db->select("seller_portfolio",array("seller_id" => $login_seller_id)); 
                    while($row_portfolio = $select_portfolio->fetch()){
                      $portfolio_id = $row_portfolio->portfolio_id;
                      $portfolio_img = $row_portfolio->portfolio_img;
                      $img_name_tmp = explode('.',$portfolio_img );
                      $img_name = $img_name_tmp[0];
                  ?>
                  <div class="col-6 col-md-3">
                    <div class="portfolio-item">
                      <div class="close-icon">
                        <a href="portfolio?delete_portfolio=<?= $portfolio_id; ?>" style="color: #fff;">
                          <i class="fal fa-times"></i>
                        </a>
                      </div>
                      <a data-toggle="modal" href="#portfolioModal-<?= $portfolio_id; ?>">
                      <img class="img-fluid d-block" src="<?= $site_url; ?>/portfolio_images/<?= $portfolio_img ?>" />
                      <span><?= $img_name; ?></span>
                      </a>
                    </div>
                  </div>
                  <!-- Each item -->
                  <!-- Modal -->
                  <div class="modal fade portfolio-modal" id="portfolioModal-<?= $portfolio_id; ?>" tabindex="-1" role="dialog" aria-labelledby="portfolioModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                          </button>
                          <img class="img-fluid d-block" src="<?= $site_url; ?>/portfolio_images/<?= $portfolio_img ?>" width="100%" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Modal end -->
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <!-- Row -->
        </div>
      </div>
      <!-- Row -->
    </section>
  </main>
  <!-- Modal -->
  <div id="insertimageModal" class="modal" role="dialog">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
       قص وإدراج الصورة <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="image_demo" style="width:100% !important;"></div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="img_type" value="">
        <button class="btn btn-success crop_image">قص الصوره</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
      </div>
      </div>
    </div>
  </div>
  <div id="wait"></div>
<!--  SELLER PROFILE END -->
<?php 
  if(isset($_GET['delete_portfolio'])){
    $delete_portfolio_id = $input->get('delete_portfolio');
    $delete_portfolio = $db->delete("seller_portfolio",array("portfolio_id"=>$delete_portfolio_id));
    if($delete_portfolio->rowCount() == 1){
      echo "<script>alert('')</script>";
      echo "<script> window.open('portfolio','_self') </script>";
    }else{
      echo "<script> window.open('portfolio','_self') </script>";
    }
  }
?>
<script>
  $(document).ready(function(){
   
   $image_crop = $('#image_demo').croppie({
       enableExif: true,
       viewport: {
         width:270,
         height:270,
         type:'square' //circle
       },
       boundary:{
         width:100,
         height:270
       }    
       });
    function crop(data){
      var reader = new FileReader();
      reader.onload = function (event) {
        $image_crop.croppie('bind',{
        url: event.target.result
        }).then(function(){
        console.log('jQuery bind complete');
        });
      }
      reader.readAsDataURL(data.files[0]);
      $('#insertimageModal').modal('show');
      $('input[type=hidden][name=img_type]').val($(data).attr('name'));
    }
    $(document).on('change','input[type=file]:not(#cover)', function(){
    var size = $(this)[0].files[0].size; 
    var ext = $(this).val().split('.').pop().toLowerCase();
    if($.inArray(ext,['jpeg','jpg','gif','png']) == -1){
    alert('Your File Extension Is Not Allowed.');
    $(this).val('');
    }else{
    crop(this);
    }
    });
    $('.crop_image').click(function(event){
    $('#wait').addClass("loader");
    var name = $('input[type=hidden][name=img_type]').val();
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response){
        $.ajax({
          url:"portfolio_upload",
          type: "POST",
          data:{image: response, name: $('input[type=file][name='+ name +']').val().replace(/C:\\fakepath\\/i, '') },
          success:function(data){
            $('#wait').removeClass("loader");
            $('#insertimageModal').modal('hide');
            $('input[type=hidden][name='+ name +']').val(data);
            main = $('input[type=hidden][name='+ name +']').parent();
            swal({
            type: 'success',
            text: '',
            timer: 3000,
            onOpen: function(){
              swal.showLoading()
            }
            }).then(function(){
                // Read more about handling dismissals
                window.open('portfolio','_self');
            });
            // main.prepend("<img src='user_images/"+data+"' class='img-fluid'>");
            $('.img-circle').attr("src", "portolio_images/"+data+"");
            // $('.img-circle').hide();
          }
        });
      });
      });

    var gallery = $('.gallery');
    gallery.on('click', '.img', function () {
      $(this).children("img,span").remove();
      $(this).children("input[type=hidden]").val("");
      $(this).addClass("pic").removeClass("img");
      
      $(this).prepend("<div class='d-flex flex-column align-items-center img-btns'><div class='drag-drop-button'><div class='button button-red mr-1'>Browse</div><div class='button button-white'>Choose</div></div></div>");
      $(this).prepend("<i class='fa fa-picture-o fa-2x mb-2'></i><br> <span><?= $lang['proposals']['browse_image']; ?></span>");
    });

  });
</script>
<?php require_once("includes/footer.php"); ?>
</body>
</html>