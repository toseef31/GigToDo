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
$proposal_id = $input->get('proposal_id');
$edit_proposal = $db->select("proposals",array("proposal_id"=>$proposal_id,"proposal_seller_id"=>$login_seller_id));
if($edit_proposal->rowCount() == 0){
echo "<script>window.open('view_proposals','_self');</script>";
}
$row_proposal = $edit_proposal->fetch();
$d_proposal_title = $row_proposal->proposal_title;
$d_proposal_url = $row_proposal->proposal_url;
$d_proposal_cat_id = $row_proposal->proposal_cat_id;
$d_proposal_child_id = $row_proposal->proposal_child_id;
$d_proposal_price = $row_proposal->proposal_price;
$d_proposal_desc = $row_proposal->proposal_desc;
$d_buyer_instruction = $row_proposal->buyer_instruction;
$d_answer_type = $row_proposal->answer_type;
$d_proposal_tags = $row_proposal->proposal_tags;
$d_proposal_video = htmlspecialchars($row_proposal->proposal_video);
$d_proposal_img1 = $row_proposal->proposal_img1;
$d_proposal_img2 = $row_proposal->proposal_img2;
$d_proposal_img3 = $row_proposal->proposal_img3;
$d_proposal_img4 = $row_proposal->proposal_img4;
$d_delivery_id = $row_proposal->delivery_id;
$d_proposal_enable_referrals = $row_proposal->proposal_enable_referrals;
$d_proposal_referral_money = $row_proposal->proposal_referral_money;
$d_proposal_status = $row_proposal->proposal_status;
if($d_proposal_price == 0){
$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
$package_price = $get_p_1->fetch()->price;
}
if(isset($_GET['remove_video'])){
$update_proposal = $db->update("proposals",array("proposal_video" => ''),array("proposal_id"=>$proposal_id));
if($update_proposal){
echo "<script>window.open('edit_proposal?proposal_id=$proposal_id','_self');</script>";
}
}
if(isset($_GET['remove_image'])){
if($_GET['remove_image'] == 2){
$remove_image = "proposal_img2";
}else if($_GET['remove_image'] == 3){
$remove_image = "proposal_img3";
}else if($_GET['remove_image'] == 4){
$remove_image = "proposal_img4";
}
$update_proposal = $db->update("proposals",array($remove_image => ''),array("proposal_id"=>$proposal_id));
if($update_proposal){
echo "<script>window.open('edit_proposal?proposal_id=$proposal_id','_self');</script>";
}
}
if($videoPlugin == 1){
$proposal_videosettings = $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id));
$count_videosettings = $proposal_videosettings->rowCount();
if($count_videosettings == 0){
$db->insert("proposal_videosettings",array("proposal_id"=>$proposal_id,"enable"=>0));
}
require_once("$dir/plugins/videoPlugin/proposals/checkVideo2.php");
$checkVideo = checkVideo($d_proposal_cat_id,$d_proposal_child_id);
}else{
$checkVideo = false;
}
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title><?= $site_name; ?> - Edit Proposal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site_desc; ?>">
    <meta name="keywords" content="<?= $site_keywords; ?>">
    <meta name="author" content="<?= $site_author; ?>">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <link href="../styles/styles.css" rel="stylesheet">
    <?php if($paymentGateway == 1){ ?>
    <link href="../plugins/paymentGateway/proposals/styles/styles.css" rel="stylesheet">
    <?php } ?>
    <link href="../styles/user_nav_styles.css" rel="stylesheet">
    <link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../styles/owl.carousel.css" rel="stylesheet">
    <link href="../styles/owl.theme.default.css" rel="stylesheet">
    <link href="../styles/tagsinput.css" rel="stylesheet" >
    <link href="../styles/sweat_alert.css" rel="stylesheet">
    <link href="../styles/animate.css" rel="stylesheet">
    <link href="../styles/croppie.css" rel="stylesheet">
    <link href="../styles/create-proposal.css" rel="stylesheet">
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="../js/ie.js"></script>
    <script type="text/javascript" src="../js/sweat_alert.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= $site_url; ?>/js/croppie.js"></script>
    <script type="text/javascript" src="<?= $site_url; ?>/js/exif.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <?php if($paymentGateway == 1){ ?>
    <script src="../plugins/paymentGateway/proposals/javascript/javascript.js"></script>
    <?php } ?>
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="../images/<?= $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
    <script>var videoOrNotVideo;</script>
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
        .proposal-form.create-gig .row{
          margin-left: 0;
          margin-right: 0;
        }
        .proposal-form.create-gig .row .col-md-3{
          padding-left: 0;
        }
        .gallery .pic{
          border: 2px dashed #3b3b3b;
          -webkit-border-radius: 10px;
          -moz-border-radius: 10px;
          border-radius: 10px;
          cursor: pointer;
          margin-bottom: 20px;
          padding: 30px 20px;
          width: 100%;
        }
        .insert-attribute, .btn.crop_image{
          background-color: #ff0707;
          border-color: #ff0707;
        }
        .header-top{
          background-color: white;
        }
        .desc1, .desc2, .desc3{
          color: red;
          /*display: none;*/
        }
        .border-red{
          border-color: #ff0707;
        }
        /*.desc1 , .desc2 , .desc3{
          display: none;
        } */
        .drag-drop-button{
          display: -webkit-box;
          display: -webkit-flex;
          display: -moz-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: normal;
          -webkit-flex-direction: row;
          -moz-box-orient: horizontal;
          -moz-box-direction: normal;
          -ms-flex-direction: row;
          flex-direction: row;
          -webkit-box-pack: center;
          -webkit-justify-content: center;
          -moz-box-pack: center;
          -ms-flex-pack: center;
          justify-content: center;
          margin-top: 10px;
        }
        .drag-drop-button .button{
          -webkit-box-align: center;
          -webkit-align-items: center;
          -moz-box-align: center;
          -ms-flex-align: center;
          align-items: center;
          color: white;
          display: -webkit-box;
          display: -webkit-flex;
          display: -moz-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: horizontal;
          -webkit-box-direction: normal;
          -webkit-flex-direction: row;
          -moz-box-orient: horizontal;
          -moz-box-direction: normal;
          -ms-flex-direction: row;
          flex-direction: row;
          font-size: 14px !important;
          font-family: 'Poppins', sans-serif;
          font-weight: 400 !important;
          height: 38px !important;
          -webkit-box-pack: center;
          -webkit-justify-content: center;
          -moz-box-pack: center;
          -ms-flex-pack: center;
          justify-content: center;
          max-width: 100px;
          text-transform: uppercase;
          width: 80px !important;
        }
        .drag-drop-button .button-white{
          background-color: white !important;
          border-color: #afafaf !important;
          color: #202020 !important;
        }
    </style>
  </head>
  <body class="all-content">
    <?php require_once("../includes/user_header.php"); ?>
    <main>
      <?php
      if($d_proposal_status == "draft"){
      require_once("sections/createProposalNav.php");
      }else{
      require_once("sections/editProposalNav.php");
      }
      ?>
      <div class="container-fluid mt-5 mb-5"><!--- container mt-5 Starts --->
        <div class="row"><!--- row Starts --->
          <div class="container">
            <div class="packages-container d-flex flex-column"><!--- col-md-8 Starts --->
              <div class="tab-content"><!--- tab-content Starts --->
                <div class="tab-pane fade <?php if(!isset($_GET['video']) AND !isset($_GET['pricing']) and !isset($_GET['publish'])){ echo " show active"; } ?>" id="overview">
                  <?php include("sections/edit/overview.php"); ?>
                </div>
                <?php if($videoPlugin == 1){ ?>
                  <div class="tab-pane fade <?php if(isset($_GET['video'])){ echo "show active"; } ?>" id="video">
                    <?php include("../plugins/videoPlugin/proposals/sections/edit/video.php"); ?>
                  </div>
                <?php } ?>
                <div class="tab-pane fade <?php if(isset($_GET['pricing'])){ echo "show active"; } ?>" id="pricing">
                  <?php include("sections/edit/pricing.php"); ?>
                </div>
                <div class="tab-pane fade" id="gallery">
                  <?php include("sections/edit/gallery.php"); ?>
                </div>
                <div class="tab-pane fade" id="description">
                  <?php include("sections/edit/description.php"); ?>
                </div>
                <div class="tab-pane fade" id="requirements">
                  <?php include("sections/edit/requirements.php"); ?>
                </div>
                
                <?php if($d_proposal_status == "draft"){ ?>
                  <div class="tab-pane fade <?php if(isset($_GET['publish'])){ echo "show active"; } ?>" id="publish">
                    <?php include("sections/edit/publish.php"); ?>
                  </div>
                <?php } ?>
                <input type="hidden" name="section" value="<?= (isset($_GET['pricing']) ? "pricing" : "overview"); ?>">
              </div><!--- tab-content Ends --->
            </div><!--- col-md-8 Ends --->
          </div>
        </div><!--- row Ends --->
      </div><!--- container mt-5 Ends --->
      <?php require_once("sections/insertimageModal.php"); ?>
      <div id="featured-proposal-modal"></div>
      <?php
      if($paymentGateway == 1){
      include("../plugins/paymentGateway/proposals/addVideoModal.php");
      }
      ?>
    </main>
    <script>
    $(document).ready(function(){
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var e = ""+e.target+"";
    var e = e.replace('<?= $site_url; ?>/proposals/edit_proposal?proposal_id=<?= $proposal_id; ?>#', '');
    var e = e.replace('<?= $site_url; ?>/proposals/edit_proposal?proposal_id=<?= $proposal_id; ?>&pricing#', '');
    $("input[type='hidden'][name='section']").val(e);
    });
    $(".proposal-form").on('submit', function(event){
    event.preventDefault();
    var form_data = new FormData(this);
    form_data.append('proposal_id',<?= $proposal_id; ?>);
    $('#wait').addClass("loader");
    $.ajax({
    method: "POST",
    url: "ajax/save_proposal",
    data: form_data,
    async: false,cache: false,contentType: false,processData: false
    }).done(function(data){
    console.log(data);
    videoOrNotVideo = data;
    $('#wait').removeClass("loader");
    if(data == "error"){
    swal({type: 'warning',text: 'Please fill in the missing Details.'});
    }else if(data == "error_img"){
    swal({type: 'warning',text: 'Please add at least 1 image to continue.'});
    }else if(data != "error" || data != "error_img"){
    swal({
    type: 'success',
    text: 'Details Saved.',
    timer: 1000,
    onOpen: function(){
    swal.showLoading();
    }
    }).then(function(){
    var section = $("input[type='hidden'][name='section']");
          var current_section = $("input[type='hidden'][name='section']").val();
          // alert(current_section);
          if(data == "video"){
            $('#package_tab"]').addClass('d-none');
            $('#tabs a[href="#video"]').removeClass('d-none');
          }else if(data == "not-video"){
            $('#package_tab"]').removeClass('d-none');
            $('#tabs a[href="#video"]').addClass('d-none');
          }

          if(current_section == "overview"){
            $('#overview').removeClass('show active');
            section.val("pricing");

            <?php if($d_proposal_status == "draft"){ ?>
            $('#pricing').addClass('show active');
            $('#package_tab').addClass('active');
            <?php }else{ ?> 
            $('#pricing').addClass('show active');
            $('#package_tab').addClass('active'); 
            <?php } ?>
            if(data == "video"){
              section.val("video");
              <?php if($d_proposal_status == "draft"){ ?>
              $('#video').addClass('show active');
              $('#tabs a[href="#video"]').addClass('active');
              <?php }else{ ?> 
              $('.nav a[href="#video"]').tab('show'); 
              <?php } ?>
            }else{
              section.val("pricing");
              <?php if($d_proposal_status == "draft"){ ?>
              $('#pricing').addClass('show active');
              $('#package_tab').addClass('active');
              <?php }else{ ?> 
              $('#pricing').addClass('show active');
              $('#package_tab').addClass('active'); 
              <?php } ?>
            }
          }else if(current_section == "description"){
            section.val("requirements");
            <?php if($d_proposal_status == "draft"){ ?>
              $('#description').removeClass('show active');
              $('#requirements').addClass('show active');
              $('#tabs a[href="#requirements"]').addClass('active');
            <?php }else{ ?> 
              $('.nav a[href="#requirements"]').tab('show');
            <?php } ?>
          }else if(current_section == "requirements"){
            section.val("gallery");
            <?php if($d_proposal_status == "draft"){ ?>
              $('#requirements').removeClass('show active');
              $('#gallery').addClass('show active');
              $('#tabs a[href="#gallery"]').addClass('active');
            <?php }else{ ?> $('.nav a[href="#gallery"]').tab('show'); <?php } ?>
          }else if(current_section == "gallery"){
            <?php if($d_proposal_status == "draft"){ ?>
              $('#gallery').removeClass('show active');
              $('#publish').addClass('show active');
              $('#tabs a[href="#publish"]').addClass('active');
            <?php } ?>
          }
    
    });
    }
    });
    });
    <?php if($d_proposal_enable_referrals == "no"){ ?>
    $(".proposal_referral_money input").attr("min","0");
    $('.proposal_referral_money').hide();
    <?php } ?>
    $(".proposal_enable_referrals").change(function(){
    var value = $(this).val();
    if(value == "yes"){
    $(".proposal_referral_money input").attr("min","1");
    $('.proposal_referral_money').show();
    }else if(value == "no"){
    $('.proposal_referral_money').hide();
    $(".proposal_referral_money input").attr("min","0");
    }
    });
    $(document).on("click",".pricing", function(event){
    var value = $(this).val();
    if(this.checked){
    $('.packages').hide();
    $('.add-attribute').hide();
    $('.proposal-price').show();
    }else{
    $('.packages').show();
    $('.add-attribute').show();
    $('.proposal-price').hide();
    }
    });
    $("#category").change(function(){
    $("#sub-category").show();
    var category_id = $(this).val();
    $.ajax({
    url:"fetch_subcategory_edit",
    method:"POST",
    data:{category_id:category_id},
    success:function(data){
    $("#sub-category").html(data);
    }
    });
    });
    // $('textarea[name="proposal_desc"]').summernote({
    // placeholder: 'Write Your Description Here.',
    // height: 200,
    // });
    });
    </script>
    <script>
        $(function(){
          $('#switch').on('change', function(){
            if ($(this).is(':checked')) {
              $(this).prop('checked', true);
              $('.tryit-overlay').addClass('packages-active');
            } else {
              $(this).prop('checked', false);
              $('.tryit-overlay').removeClass('packages-active');
            }
          });
          $('.tryit-overlay-button').on('click', function(){
            $(this).parents('.tryit-overlay').addClass('packages-active');
            $('#switch').prop('checked', false);
          });
        });
      </script>
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