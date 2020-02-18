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
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
<link href="../styles/bootstrap.css" rel="stylesheet">
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
<script type="text/javascript" src="../js/croppie.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php if($paymentGateway == 1){ ?>
<script src="../plugins/paymentGateway/proposals/javascript/javascript.js"></script>
<?php } ?>
<?php if(!empty($site_favicon)){ ?>
<link rel="shortcut icon" href="../images/<?= $site_favicon; ?>" type="image/x-icon">
<?php } ?>
<script>var videoOrNotVideo;</script>
</head>
<body class="is-responsive">
<?php require_once("../includes/user_header.php"); ?>
<?php
if($d_proposal_status == "draft"){
require_once("sections/createProposalNav.php"); 
}else{
require_once("sections/editProposalNav.php"); 
}
?>
<div class="container mt-5 mb-5"><!--- container mt-5 Starts --->
  <div class="row"><!--- row Starts --->
    <div class="col-md-8"><!--- col-md-8 Starts --->
      <div class="tab-content card card-body"><!--- tab-content Starts --->
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
        <div class="tab-pane fade" id="description">
          <?php include("sections/edit/description.php"); ?>
        </div>
        <div class="tab-pane fade" id="requirements">
          <?php include("sections/edit/requirements.php"); ?>
        </div>
        <div class="tab-pane fade" id="gallery">
          <?php include("sections/edit/gallery.php"); ?>
        </div>
        <?php if($d_proposal_status == "draft"){ ?>
        <div class="tab-pane fade <?php if(isset($_GET['publish'])){ echo "show active"; } ?>" id="publish">
          <?php include("sections/edit/publish.php"); ?>
        </div>
        <?php } ?>
        <input type="hidden" name="section" value="<?= (isset($_GET['pricing']) ? "pricing" : "overview"); ?>">
      </div><!--- tab-content Ends --->
    </div><!--- col-md-8 Ends --->
  </div><!--- row Ends --->
</div><!--- container mt-5 Ends --->

<?php require_once("sections/insertimageModal.php"); ?>
<div id="featured-proposal-modal"></div>

<?php 
if($paymentGateway == 1){
  include("../plugins/paymentGateway/proposals/addVideoModal.php");
}
?>

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
        swal({type: 'warning',text: 'You Must Need To Fill Out All Fields Before Updating The Details.'});
      }else if(data == "error_img"){
        swal({type: 'warning',text: 'You Must Need To Add At Least 1 Image In Proposal To Continue.'});
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

          if(data == "video"){
            $('#tabs a[href="#pricing"]').addClass('d-none');
            $('#tabs a[href="#video"]').removeClass('d-none');
          }else if(data == "not-video"){
            $('#tabs a[href="#pricing"]').removeClass('d-none');
            $('#tabs a[href="#video"]').addClass('d-none');
          }

          if(current_section == "overview"){
            $('#overview').removeClass('show active');
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
              $('#tabs a[href="#pricing"]').addClass('active');
              <?php }else{ ?> 
              $('.nav a[href="#pricing"]').tab('show'); 
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
  url:"fetch_subcategory",
    method:"POST",
    data:{category_id:category_id},
    success:function(data){
      $("#sub-category").html(data);
    }
  });
});

$('textarea[name="proposal_desc"]').summernote({
    placeholder: 'Write Your Description Here.',
    height: 200,
 });

});
</script>
<?php require_once("../includes/footer.php"); ?>
<script src="../js/tagsinput.js"></script>
</body>
</html>