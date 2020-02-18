<h5 class="font-weight-normal"><?= $lang['proposals']['gallery_title']; ?></h5>
<h6 class="font-weight-normal"><?= $lang['proposals']['gallery_descrption']; ?></h6>

<hr>

<p class="text-right mb-0">
<span class="float-left"><?= $lang['proposals']['proposals_photos']; ?></span>
<small class="text-muted" style="font-size: 78%;"><?= $lang['proposals']['proposals_photos_description']; ?></small>
</p>

<form action="" class="proposal-form" id="gallery_form"><!--- form Starts --->
  <div class="row gallery"><!--- row gallery Starts --->
    <div class="col-md-3"><!--- col-md-3 Starts --->
    <?php if(empty($d_proposal_img1)){ ?>
    <div class="pic add-pic">
    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span><?= $lang['proposals']['browse_image']; ?></span>
    <input type="hidden" name="proposal_img1" value="<?= $d_proposal_img1; ?>">
    </div>
    <?php }else{ ?>
    <div class="img">
    <img src="proposal_files/<?= $d_proposal_img1; ?>" class='img-fluid' alt="">
    <span><?= $lang['proposals']['remove']; ?></span>
    <input type="hidden" name="proposal_img1" value="<?= $d_proposal_img1; ?>">
    </div>
    <?php } ?>
    </div><!--- col-md-3 Ends --->
    <div class="col-md-3"><!--- col-md-3 Starts --->
    <?php if(empty($d_proposal_img2)){ ?>
    <div class="pic">
    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span><?= $lang['proposals']['browse_image']; ?></span>
    <input type="hidden" name="proposal_img2" value="<?= $d_proposal_img2; ?>">
    </div>
    <?php }else{ ?>
    <div class="img">
    <img src="proposal_files/<?= $d_proposal_img2; ?>" class='img-fluid' alt="">
    <span><?= $lang['proposals']['remove']; ?></span>
    <input type="hidden" name="proposal_img2" value="<?= $d_proposal_img2; ?>">
    </div>
    <?php } ?>
    </div><!--- col-md-3 Ends --->
    <div class="col-md-3"><!--- col-md-3 Starts --->
    <?php if(empty($d_proposal_img3)){ ?>
    <div class="pic">
    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span><?= $lang['proposals']['browse_image']; ?></span>
    <input type="hidden" name="proposal_img3" value="<?= $d_proposal_img3; ?>">
    </div>
    <?php }else{ ?>
    <div class="img">
    <img src="proposal_files/<?= $d_proposal_img3; ?>" class='img-fluid' alt="">
    <span><?= $lang['proposals']['remove']; ?></span>
    <input type="hidden" name="proposal_img3" value="<?= $d_proposal_img3; ?>">
    </div>
    <?php } ?>
    </div><!--- col-md-3 Ends --->
    <div class="col-md-3"><!--- col-md-3 Starts --->
    <?php if(empty($d_proposal_img4)){ ?>
    <div class="pic">
    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span><?= $lang['proposals']['browse_image']; ?></span>
    <input type="hidden" name="proposal_img4" value="">
    </div>
    <?php }else{ ?>
    <div class="img">
    <img src="proposal_files/<?= $d_proposal_img4; ?>" class='img-fluid' alt="">
    <span><?= $lang['proposals']['remove']; ?></span>
    <input type="hidden" name="proposal_img4" value="<?= $d_proposal_img4; ?>">
    </div>
    <?php } ?>
    </div><!--- col-md-3 Ends --->
  </div><!--- row gallery Ends --->
  <hr>
  <p class="text-right mb-0">
    <span class="float-left"><?= $lang['proposals']['add_video']; ?>add_proposal_video</span>
    <small class="text-muted" style="font-size: 78%;"><?= $lang['proposals']['add_video_description']; ?></small>
  </p>
  <div class="row gallery"><!--- row gallery Starts --->
    <div class="col-md-12"><!--- col-md-3 Starts --->
      <div class="pic <?php if(empty($d_proposal_video)){echo"add-video";}else{echo"video-added";} ?>">
        <?php if(empty($d_proposal_video)){ ?>
        <span class="chose"><i class="fa fa-video-camera fa-2x mb-2"></i><br><?= $lang['proposals']['add_video']; ?></span>
        <?php }else{ ?>
        <span>
          <i class="fa fa-video-camera fa-2x mb-2"></i> <br> <span class="text-success font-weight-bold">Video Added</span>
          <br>
          <span class="delete-video text-danger text-underline"><?= $lang['proposals']['remove_video']; ?></span>
          <i class="fa fa-trash fa-2x delete-video" title="<?= $lang['proposals']['remove_video']; ?>"></i>
        </span>
        <?php } ?>
        <input type='hidden' name='proposal_video' value='<?= $d_proposal_video; ?>' id='v_file'> 
      </div>
    </div><!--- col-md-3 Ends --->
  </div><!--- row gallery Ends --->
</form><!--- form Ends --->

<div class="mb-5"></div>

<div class="form-group mb-0"><!--- form-group Starts --->

<a href="#" class="btn btn-secondary float-left back-to-req">Back</a>

<input class="btn btn-success float-right" type="submit" form="gallery_form" value="Save & Continue">
<a href="<?php echo $_SESSION["seller_user_name"]; ?>/<?php echo $d_proposal_url; ?>" id="previewProposal" class="btn btn-success float-right mr-3 d-none">Preview Proposal</a>

</div><!--- form-group Starts --->

<script>
$(document).ready(function(){
  var browsers = ["Opera", "Edge", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
  var userbrowser, useragent = navigator.userAgent;
  for(var i = 0; i < browsers.length; i++) {
    if( useragent.indexOf(browsers[i]) > -1 ) {
      userbrowser = browsers[i];
      break;
    }
  };

  <?php if($d_proposal_status != "draft"){ ?>
  $("#gallery_form").on('submit', function(event){
    $('#previewProposal').removeClass("d-none");
  });
  <?php } ?>

  $('.back-to-req').click(function(){
    <?php if($d_proposal_status == "draft"){ ?>
    $("input[type='hidden'][name='section']").val("requirements");
    $('#gallery').removeClass('show active');
    $('#requirements').addClass('show active');
    $('#tabs a[href="#gallery"]').removeClass('active');
    <?php }else{ ?>
    $('.nav a[href="#requirements"]').tab('show');
    <?php } ?>
  });

  $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:700,
      height:390,
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
    $('input[type=hidden][name=img_name]').val(data.files[0].name);
  }

  $('.crop_image').click(function(event){
    $('#wait').addClass("loader");
    var name = $('input[type=hidden][name=img_type]').val();
    $image_crop.croppie('result', {
      type: 'canvas', size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"crop_upload", type: "POST",
        data:{image: response, name: $('input[type=hidden][name=img_name]').val() },
        success:function(data){
          $('#wait').removeClass("loader");
          $('#insertimageModal').modal('hide');
          $('input[type=hidden][name='+ name +']').val(data);
          main = $('input[type=hidden][name='+ name +']').parent();
          main.children("i,br,span").remove();
          main.addClass("img").removeClass("pic");
          main.prepend("<img src='proposal_files/"+data+"' class='img-fluid'> <span><?= $lang['proposals']['remove']; ?></span>");
        }
      });
    });
  });

  var gallery = $('.gallery');
  gallery.on('click', '.img', function () {
    $(this).children("img,span").remove();
    $(this).children("input[type=hidden]").val("");
    $(this).addClass("pic").removeClass("img");
    $(this).prepend("<i class='fa fa-picture-o fa-2x mb-2'></i><br> <span><?= $lang['proposals']['browse_image']; ?></span>");
  });


  gallery.on('click', '.pic:not(.add-video,.video-added,.disable)',function(){
    var name = $(this).children("input[type=hidden]").attr("name");
    if(userbrowser == "Edge" || userbrowser == "Safari"){
      $("input[type=file]").click();
      $("input[type=file]").attr('name',name); 
      $("input[type=file]").attr('accept','image/*');
      $("input[type=file]").removeAttr('multiple');
      $("input[type=file]").on('change',function(){ crop(this); });
    }else{
      var uploader = $('<input type="file" name="'+name+'" accept="image/*" />');
      uploader.click();
      uploader.on('input', function(){ crop(this); });
    }
  });

  $(document).on('click','.add-video',function(){
    <?php if($paymentGateway == 1){ ?>
      $("#video-modal").modal("show");
    <?php }else{ ?>
      var uploader = $('<input class="d-none" type="file" name="proposal_video" accept="video/mp4,video/x-m4v,video/*"/>');
      span = $(this);
      uploader.click();
      uploader.on('change', function(){ 
        var form_data = new FormData();
        form_data.append("file", this.files[0]);
        $.ajax({
          url:"ajax/upload_file",
          method:"POST",
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
        }).done(function(data){
          $("#v_file").val(data);
          span.removeClass('chose').html("<i class='fa fa-video-camera fa-2x mb-2'></i><br>"+data+"<i class='fa fa-trash fa-2x delete-video'></i>");
        });
      });
    <?php } ?>
  });

  gallery.on('click', '.delete-video', function () {
    $("#v_file").val("");
    $(this).parent().parent().prepend("<span class='chose'><i class='fa fa-video-camera fa-2x mb-2'></i><br> <?= $lang['proposals']['add_video']; ?></span>");
    $(this).parent().remove();
    $(".video-added").addClass("add-video").removeClass("video-added");
  });

});
</script>