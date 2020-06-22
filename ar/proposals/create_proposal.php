<?php
session_start();
require_once("../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_level = $row_login_seller->seller_level;
$login_seller_language = $row_login_seller->seller_language;
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
<head>
<title><?php echo $site_name; ?> - Create A New Proposal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="<?php echo $site_desc; ?>">
<meta name="keywords" content="<?php echo $site_keywords; ?>">
<meta name="author" content="<?php echo $site_author; ?>">

<!--====== Favicon Icon ======-->
<?php if(!empty($site_favicon)){ ?>
<link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
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
<!--====== Default css ======-->
<link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
<!--====== Style css ======-->
<link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
<!--====== Responsive css ======-->
<link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
<!-- <link href="../styles/bootstrap.css" rel="stylesheet"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
<link href="../styles/styles.css" rel="stylesheet">
<!-- <link href="../styles/user_nav_styles.css" rel="stylesheet">
<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
<link href="../styles/owl.carousel.css" rel="stylesheet">
<link href="../styles/owl.theme.default.css" rel="stylesheet"> -->
<link href="../styles/tagsinput.css" rel="stylesheet" >
<link href="../styles/sweat_alert.css" rel="stylesheet">
<link href="../styles/animate.css" rel="stylesheet">
<link href="../styles/croppie.css" rel="stylesheet">
<!-- <link href="../styles/create-proposal.css" rel="stylesheet"> -->
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
<script src="../js/ie.js"></script>
<script type="text/javascript" src="../js/sweat_alert.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/croppie.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<style>
  .gig-category-item{
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-flex-basis: 100%;
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -moz-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    max-width: 100%;
    margin: 0;
    -webkit-flex-basis: -webkit-calc(100% - 10px) !important;
    -ms-flex-preferred-size: calc(100% - 10px) !important;
    flex-basis: -moz-calc(100% - 10px) !important;
    flex-basis: calc(100% - 10px) !important;
    max-width: -webkit-calc(100% - 10px) !important;
    max-width: -moz-calc(100% - 10px) !important;
    max-width: calc(100% - 10px) !important;
  }
  .gig-category-select{
    -webkit-flex-basis: -webkit-calc(100% - 10px);
    -ms-flex-preferred-size: calc(100% - 10px);
    flex-basis: -moz-calc(100% - 10px);
    flex-basis: calc1050% - 10px);
    max-width: -webkit-calc(100% - 10px);
    max-width: -moz-calc(100% - 10px);
    max-width: calc(100% - 10px);
  }
  .cat_item-content{
    -webkit-flex-basis: -webkit-calc(50% - 10px) !important;
    -ms-flex-preferred-size: calc(50% - 10px) !important;
    flex-basis: -moz-calc(50% - 10px) !important;
    flex-basis: calc(50% - 10px) !important;
    max-width: -webkit-calc(50% - 10px) !important;
    max-width: -moz-calc(50% - 10px) !important;
    max-width: calc(50% - 10px) !important;
  }
  .cat_item-content.item-active .gig-category-select {
    -webkit-flex-basis: -webkit-calc(50% - 10px);
    -ms-flex-preferred-size: calc(50% - 10px);
    flex-basis: -moz-calc(50% - 10px);
    flex-basis: calc(100% - 0px);
    max-width: -webkit-calc(50% - 10px);
    max-width: -moz-calc(50% - 10px);
    max-width: calc(100% - 0px);
  }
  .postagig .create-gig .form-group .gig-category .cat_item-content.item-active {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-flex-basis: 100%;
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -moz-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    max-width: 100%;
    margin: 0;
  }
  .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-select {
    -webkit-flex-basis: -webkit-calc(100% - 10px);
    -ms-flex-preferred-size: calc(100% - 10px);
    flex-basis: -moz-calc(100% - 10px);
    flex-basis: calc(100% - 10px);
    max-width: -webkit-calc(100% - 10px);
    max-width: -moz-calc(100% - 10px);
    max-width: calc(100% - 10px);
  }
  .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-tags {
    -webkit-flex-basis: -webkit-calc(50% - 10px);
    -ms-flex-preferred-size: calc(50% - 10px);
    flex-basis: -moz-calc(50% - 10px);
    flex-basis: calc(50% - 10px);
    margin-bottom: 20px;
    height: auto;
    max-width: -webkit-calc(50% - 10px);
    max-width: -moz-calc(50% - 10px);
    max-width: calc(50% - 10px);
  }
  .postagig .create-gig .form-group .gig-category .cat_item-content.item-removed {
    display: none;
  }
  .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .backto-main {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
  }
  .bootstrap-tagsinput{
    line-height: 40px;
  }
  .header-top{
    background-color: white;
  }
  .insert_btn{
    background-color: #ff0707;
    border: 2px solid #ff0707;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
  }
  .delete-extra{
    text-transform: uppercase;
    font-size: 16px;
  }
  @media(max-width: 768px){
    .gig-category-item{
      -webkit-flex-basis: -webkit-calc(100% - 0px) !important;
      -ms-flex-preferred-size: calc(100% - 0px) !important;
      flex-basis: -moz-calc(100% - 0px) !important;
      flex-basis: calc(100% - 0px) !important;
      max-width: -webkit-calc(100% - 0px) !important;
      max-width: -moz-calc(100% - 0px) !important;
      max-width: calc(100% - 0px) !important;
    }
    .gig-category-select{
      -webkit-flex-basis: -webkit-calc(100% - 0px);
      -ms-flex-preferred-size: calc(100% - 0px);
      flex-basis: -moz-calc(100% - 0px);
      flex-basis: calc(100% - 0px);
      max-width: -webkit-calc(100% - 0px);
      max-width: -moz-calc(100% - 0px);
      max-width: calc(100% - 0px);
    }
    .cat_item-content{
      -webkit-flex-basis: -webkit-calc(100% - 0px) !important;
      -ms-flex-preferred-size: calc(100% - 0px) !important;
      flex-basis: -moz-calc(100% - 0px) !important;
      flex-basis: calc(100% - 0px) !important;
      max-width: -webkit-calc(100% - 0px) !important;
      max-width: -moz-calc(100% - 0px) !important;
      max-width: calc(100% - 0px) !important;
    }
    .cat_item-content.item-active .gig-category-select {
      -webkit-flex-basis: -webkit-calc(100% - 0px);
      -ms-flex-preferred-size: calc(100% - 0px);
      flex-basis: -moz-calc(100% - 0px);
      flex-basis: calc(100% - 0px);
      max-width: -webkit-calc(100% - 0px);
      max-width: -moz-calc(100% - 0px);
      max-width: calc(100% - 0px);
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-select {
        -webkit-flex-basis: -webkit-calc(100% - 0px);
        -ms-flex-preferred-size: calc(100% - 0px);
        flex-basis: -moz-calc(100% - 0px);
        flex-basis: calc(100% - 0px);
        max-width: -webkit-calc(100% - 0px);
        max-width: -moz-calc(100% - 0px);
        max-width: calc(100% - 0px);
    }
    .postagig .create-gig .form-group .gig-category .cat_item-content.item-active .gig-category-tags {
        -webkit-flex-basis: -webkit-calc(100% - 0px);
        -ms-flex-preferred-size: calc(100% - 0px);
        flex-basis: -moz-calc(100% - 0px);
        flex-basis: calc(100% - 0px);
        max-width: -webkit-calc(100% - 0px);
        max-width: -moz-calc(100% - 0px);
        max-width: calc(100% - 0px);
    }
  }
</style>
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
require_once("../includes/user_header.php"); 

if($seller_verification != "ok"){
  echo "<main style='min-height:80%'>
  <div class='alert alert-danger rounded-0 mt-0 text-center'>
  يرجى تأكيد بريدك الإلكتروني لاستخدام هذه الميزة.
  </div></main>";
}else{

?>
<main>
    <!-- Post a gig overview step -->
    <?php require_once("sections/createProposalNav.php"); ?>
    <!-- Post a gig overview step end -->
    <!-- Post a gig -->
    <section class="container-fluid postagig pt-0 border-top-0">
      <div class="row">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8">
              <div class="row">
                <div class="col-12 col-md-8">
                  <div class="tab-content"><!--- tab-content Starts --->
                    <div class="tab-pane fade show active" id="overview">
                      <?php include("sections/create/overview.php"); ?>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4" id="popupWidth"></div>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="howitwork-card">
                <div class="howitwork-card-title d-flex align-items-center">
                  ازاي بيشتغل
                </div>
                <div class="howitwork-list d-flex flex-column">
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/postagig.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>1. نشر خدمة</h3>
                      <p>
                          ابدأ وخصص خدماتك بحيث الناس اللى هتشترى يقدروا يفهموا بشكل واضح الخدمات اللى بتوفرها علشان تقابل احتياجاتهم
                          
                      </p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/gethired.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>2. التعاقد</h3>
                      <p>
                        اتواصل مع المشتري عشان تحددوا التفاصيل الخاصة بالمشروع. بمجرد ما تتفق انت و مقدم الخدمة على الطلبات، هتبدأ الشغل.
                      </p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Work" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/work.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>3. الشغل</h3>
                      <p>
                        بمجردما تخلص شغلك،هتسلمال شغل الرائع على منصتنا عشان العميل يوافق عليه.
                      </p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                  <div class="howitwork-list-item d-flex flex-row align-items-start">
                    <div class="howitwork-list-icon">
                      <img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/getpaid.png" />
                    </div>
                    <div class="howitwork-list-content">
                      <h3>4. استلم فلوسك</h3>
                      <p>
                        لما العميل يوافق على شغلك اللي اتسلم، فلوسك هتتحول لحسابك على موقع "منجز" و كمان ممكن تخلي فلوسك في حسابك على موقع "منجز" أو تحولهم لحسابك في البنك.
                      </p>
                    </div>
                  </div>
                  <!-- How it work each item -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Post a gig end -->
  </main>


<!-- <div class="container mt-5 mb-5"> -->
  <!--- container Starts --->
<!-- <div class="row"> -->
  <!--- row Starts --->
<!-- <div class="col-md-8">
<div class="tab-content card card-body"> -->
  <!--- tab-content Starts --->
<!-- <div class="tab-pane fade show active" id="overview">
<?php //include("sections/create/overview.php"); ?>
</div>
</div> -->
<!--- tab-content Ends --->
<!-- </div>
</div> -->
<!--- row Ends --->
<!-- </div> -->
<!--- container Ends --->

<script>
$(document).ready(function(){
  $('.proposal_referral_money').hide();
  <?php if(@$form_data['proposal_enable_referrals'] == "yes"){ ?>
  $('.proposal_referral_money').show();
  <?php } ?>

  $(".proposal_enable_referrals").change(function(){
    var value = $(this).val();
    if(value == "yes"){
    $(".proposal_referral_money input").attr("required","");
    $('.proposal_referral_money').show();
    }else if(value == "no"){
    $(".proposal_referral_money input").removeAttr("required");
    $('.proposal_referral_money').hide();
    }
  });

  <?php if(@$form_data['proposal_child_id']){ ?>

  <?php }else{ ?>

  $("#sub-category").hide();	

  <?php } ?>

  // $("#category").change(function(){
  //   $("#sub-category").show();
  //   var category_id = $(this).val();
  //   $.ajax({
  //   url:"fetch_subcategory",
  //   method:"POST",
  //   data:{category_id:category_id},
  //   success:function(data){
  //   $("#sub-category").html(data);
  //   }
  //   });
  // });

 	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:540,
      height:300,
      type:'square' //circle
    },
    boundary:{
      width:100,
      height:400
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

	$(document).on('change','input[type=file]:not(#v_file)', function(){
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
        url:"crop_upload",
        type: "POST",
        data:{image: response, name: $('input[type=file][name='+ name +']').val().replace(/C:\\fakepath\\/i, '') },
        success:function(data){
          $('#wait').removeClass("loader");
          $('#insertimageModal').modal('hide');
          $('input[type=hidden][name='+ name +']').val(data);
        }
      });
    });
  });

  // $('textarea[name="proposal_desc"]').summernote({
  //   placeholder: 'Write Your Description Here.',
  //   height: 150,
  //   toolbar: [
  //   ['style', ['style']],
  //   ['font', ['bold', 'italic', 'underline', 'clear']],
  //   ['fontname', ['fontname']],
  //   ['fontsize', ['fontsize']],
  //   ['height', ['height']],
  //   ['color', ['color']],
  //   ['para', ['ul', 'ol', 'paragraph']],
  //   ['table', ['table']],
  //   ['insert', ['link', 'picture']],
  // ],
  // });

});
</script>

<?php } ?>
<script>
    $(function(){
        $(window).on('load resize', function(){
            var popupWidth = $('#popupWidth').outerWidth();
            $('.popup').css({
                'width': popupWidth + 30 + 'px'
            });
        });
        $('.gig-category-select').on('click', function(){
            $('.cat_item-content').addClass('item-removed');
            $('.gig-category-item').addClass('item-removed');
            $(this).parents('.cat_item-content').removeClass('item-removed');
            $(this).parents('.cat_item-content').addClass('item-active');
            $(this).parents('.gig-category-item').removeClass('item-removed');
            $(this).parents('.gig-category-item').addClass('item-active');
        });
        $('.gig-category-tag').on('click', function(){
            $(this).toggleClass('tag-selected');
        });
        $('.backto-main').on('click', function(){
            $('.gig-category-item').removeClass('item-active');
            $('.gig-category-item').removeClass('item-removed');
            $('.cat_item-content').removeClass('item-active');
            $('.cat_item-content').removeClass('item-removed');
            $('.gig-category-tag').removeClass('tag-selected');
            $('.gig-category-item').find('input[type="radio"]').prop('checked', false);
        });
        $('.deliver-time-item[for="days30"]').on('click', function(){
            $('.input-number').focus();
        });
        $(".gig-category-select").on('click', function(){
          var cat_class = $(this).parents('.cat_item-content').attr("data-id");
            $(".gig-category-tags").removeAttr('class').addClass('gig-category-tags '+cat_class);
            // $('.gig-category-tags').addClass(cat_class);
        });
    });

    $(".text-count").keydown(function(){
    var textarea = $(".text-count").val();
    $(".descCount").text(textarea.length);  
    }); 

    $(".gig-category-tags  .nice-select.form-control").remove();

    
    $("#sub-category").hide();

    function categoryItem(id){
      $("#sub-category").show();  
      var category_id =  id;
      $.ajax({
      url:"fetch_subcategory",
      method:"POST",
      data:{category_id:category_id},

      success:function(data){
        console.log(data);
      $("#sub-category").html(data);
      }
      });
    }

  </script>
<?php require_once("../includes/footer.php"); ?>
<script src="../js/tagsinput.js"></script>
</body>
</html>