<!-- New Design -->
<!-- Post a gig -->
  <section class="container-fluid postagig pt-0 border-top-0">
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-md-9">
                <form action="" class="proposal-form create-gig" id="gallery_form" method="post">
                  <div class="row gallery form-group"><!--- row gallery Starts --->
                    <label class="custom-label d-flex flex-row align-items-center">
                      <span>
                        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/photo-icon.png" />
                      </span>
                      <span>
                        الصور
                      </span>
                      <!-- <span class="ml-auto item-count">(0/3)</span> -->
                    </label>
                    <div class="col-md-3 file-input-label"><!--- col-md-3 Starts --->
                    <?php if(empty($d_proposal_img1)){ ?>
                    <div class="pic add-pic">
                    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span>                               ارفع صورة</span>
                    <div class="d-flex flex-column align-items-center img-btns">
                      <!-- <div class="icon">
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/drag-photo-icon.png" />
                      </div> -->
                      <!-- <div class="text">drag a photo or</div> -->
                      <div class="drag-drop-button">
                        <div class="button button-red ml-1">
                           ارفع
                        </div>
                        <div class="button button-white">
                           اختار
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="proposal_img1" value="<?= $d_proposal_img1; ?>">
                    </div>
                    <?php }else{ ?>
                    <div class="img">
                    <img src="../../proposals/proposal_files/<?= $d_proposal_img1; ?>" class='img-fluid' alt="">
                    <span><?= $lang['proposals']['remove']; ?></span>
                    <input type="hidden" name="proposal_img1" value="<?= $d_proposal_img1; ?>">
                    </div>
                    <?php } ?>
                    </div><!--- col-md-3 Ends --->
                    <div class="col-md-3"><!--- col-md-3 Starts --->
                    <?php if(empty($d_proposal_img2)){ ?>
                    <div class="pic">
                    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span>                              ارفع صورة </span>
                    <div class="d-flex flex-column align-items-center img-btns">
                      <!-- <div class="icon">
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/drag-photo-icon.png" />
                      </div> -->
                      <!-- <div class="text">drag a photo or</div> -->
                      <div class="drag-drop-button">
                        <div class="button button-red ml-1">
                           ارفع
                        </div>
                        <div class="button button-white">
                           اختار
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="proposal_img2" value="<?= $d_proposal_img2; ?>">
                    </div>
                    <?php }else{ ?>
                    <div class="img">
                    <img src="../../proposals/proposal_files/<?= $d_proposal_img2; ?>" class='img-fluid' alt="">
                    <span><?= $lang['proposals']['remove']; ?></span>
                    <input type="hidden" name="proposal_img2" value="<?= $d_proposal_img2; ?>">
                    </div>
                    <?php } ?>
                    </div><!--- col-md-3 Ends --->
                    <div class="col-md-3"><!--- col-md-3 Starts --->
                    <?php if(empty($d_proposal_img3)){ ?>
                    <div class="pic">
                    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span>                              ارفع صورة</span>
                    <div class="d-flex flex-column align-items-center img-btns">
                      <!-- <div class="icon">
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/drag-photo-icon.png" />
                      </div> -->
                      <!-- <div class="text">drag a photo or</div> -->
                      <div class="drag-drop-button">
                        <div class="button button-red ml-1">
                           ارفع
                        </div>
                        <div class="button button-white">
                           اختار
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="proposal_img3" value="<?= $d_proposal_img3; ?>">
                    </div>
                    <?php }else{ ?>
                    <div class="img">
                    <img src="../../proposals/proposal_files/<?= $d_proposal_img3; ?>" class='img-fluid' alt="">
                    <span><?= $lang['proposals']['remove']; ?></span>
                    <input type="hidden" name="proposal_img3" value="<?= $d_proposal_img3; ?>">
                    </div>
                    <?php } ?>
                    </div><!--- col-md-3 Ends --->
                    <div class="col-md-3"><!--- col-md-3 Starts --->
                    <?php if(empty($d_proposal_img4)){ ?>
                    <div class="pic">
                    <i class="fa fa-picture-o fa-2x mb-2"></i><br> <span>                              ارفع صورة</span>
                    <div class="d-flex flex-column align-items-center img-btns">
                      <!-- <div class="icon">
                        <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/drag-photo-icon.png" />
                      </div> -->
                      <!-- <div class="text">drag a photo or</div> -->
                      <div class="drag-drop-button">
                        <div class="button button-red ml-1">
                          ارفع
                        </div>
                        <div class="button button-white">
                          اختار
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="proposal_img4" value="">
                    </div>
                    <?php }else{ ?>
                    <div class="img">
                    <img src="../../proposals/proposal_files/<?= $d_proposal_img4; ?>" class='img-fluid' alt="">
                    <span><?= $lang['proposals']['remove']; ?></span>
                    <input type="hidden" name="proposal_img4" value="<?= $d_proposal_img4; ?>">
                    </div>
                    <?php } ?>
                    </div><!--- col-md-3 Ends --->
                    <!-- <div class="popup">
                      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/lamp-icon.png" />
                      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                      <p>
                        إستخدام صور إعلامية عالية الجودة سيساعد المشترين على تصور الخدمات التي تقدمها. الحد الأدنى لأبعاد الصورة هو 800 بكسل للعرض × 450 بكسل للطول
                      </p>
                    </div> -->
                  </div><!--- row gallery Ends --->
                  <div class="row gallery form-group">
                    <label class="custom-label d-flex flex-row align-items-center">
                      <span>
                        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/video-icon.png" />
                      </span>
                      <span>فيديو </span>
                      <span class="ml-auto item-count"><small class="text-muted" style="font-size: 78%;"><?= $lang['proposals']['add_video_description']; ?></small></span>
                      
                    </label>
                    <div class="col-md-12"><!--- col-md-3 Starts --->
                      <div class="pic <?php if(empty($d_proposal_video)){echo"add-video";}else{echo"video-added";} ?>">
                        <?php if(empty($d_proposal_video)){ ?>
                        <span class="chose"><i class="fa fa-video-camera fa-2x mb-2"></i><br><?= $lang['proposals']['add_video']; ?></span>
                        <!-- <div class="d-flex flex-column align-items-center img-btns"> -->
                          <!-- <div class="icon">
                            <img class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/drag-photo-icon.png" />
                          </div> -->
                          <!-- <div class="text">drag a photo or</div> -->
                          <!-- <div class="drag-drop-button">
                            <div class="button button-red ml-1">
                               ارفع
                            </div>
                            <div class="button button-white">
                               اختار
                            </div>
                          </div>
                        </div> -->
                        <?php }else{ ?>
                        <span>
                          <i class="fa fa-video-camera fa-2x mb-2"></i> <br> <span class="text-success font-weight-bold">Video Added</span>
                          <br>
                          <span class="delete-video text-danger text-underline"><?= $lang['proposals']['remove_video']; ?></span>
                          <i class="fa fa-trash fa-2x delete-video" title="<?= $lang['proposals']['remove_video']; ?>"></i>
                        </span>
                        <?php } ?>
                      </div>
                      <input type="hidden" name="proposal_video" value="<?= $d_proposal_video; ?>" id="v_file">  
                    </div><!--- col-md-3 Ends --->
                    <!-- <div class="popup">
                      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/lamp-icon.png" />
                      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/ask-our-community.png" width="100%" />
                      <p>
                        تساعد مقاطع الفيديو الخاصة بالخدمة المشتري على رؤية وسماع ما ستفعله بالضبط. يستغرق بعض الوقت لإنشاء فيديو متميز. لكنها سوف تزيد بشكل كبير من فرصك للحصول على المشتري<br />
                        <strong>
                          الإمتدادات الصالحة هي mp4 و avi و m4v
                        </strong><br />
                        <strong>
                          الحد الأقصى لحجم الملف هو 25 ميغابايت
                        </strong>
                      </p>
                    </div> -->
                  </div>
                  <!-- <div class="form-group">
                    <label class="custom-label d-flex flex-row align-items-center">
                      <span>
                        <img alt="" class="img-fluid d-block" src="assets/img/post-a-gig/photo-icon.png" />
                      </span>
                      <span>
                        الصور
                      </span>
                      <span class="mr-auto item-count">(0/3)</span>
                    </label>
                    <div class="drag-drop d-flex flex-wrap">
                      <div class="drag-drop-fileinput">
                        <label class="file-input-label" for="image-file">
                          <input type="file" hidden name="image-file" id="image-file" />
                          <div class="d-flex flex-column align-items-center">
                            <div class="icon">
                              <img class="img-fluid d-block" src="assets/img/post-a-gig/drag-photo-icon.png" />
                            </div>
                            <div class="text">
                              ارفع صورة
                            </div>
                            <div class="drag-drop-button">
                              <div class="button button-red">
                                ارفع
                              </div>
                              <div class="button button-white">
                                اختار
                              </div>
                            </div>
                          </div>
                        </label>
                      </div>
                      <div class="drag-drop-file d-flex flex-row">
                        <div class="drag-drop-file-item"></div>
                        <div class="drag-drop-file-item"></div>
                        <div class="drag-drop-file-item"></div>
                      </div>
                    </div>
                    <div class="popup">
                      <img alt="" class="lamp-icon" src="assets/img/post-a-gig/lamp-icon.png" />
                      <img alt="Ask our Community" class="img-fluid d-block" src="assets/img/post-a-gig/ask-our-community.png" width="100%" />
                      <p>
                        إستخدام صور إعلامية عالية الجودة سيساعد المشترين على تصور الخدمات التي تقدمها. الحد الأدنى لأبعاد الصورة هو 800 بكسل للعرض × 450 بكسل للطول
                      </p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="custom-label d-flex flex-row align-items-center">
                      <span>
                        <img alt="" class="img-fluid d-block" src="assets/img/post-a-gig/video-icon.png" />
                      </span>
                      <span>
                        الفيديو 
                      </span>
                      <span class="mr-auto item-count">(0/3)</span>
                    </label>
                    <div class="drag-drop d-flex flex-wrap">
                      <div class="drag-drop-fileinput">
                        <label class="file-input-label" for="video-file">
                          <input type="file" hidden name="video-file" id="video-file" />
                          <div class="d-flex flex-column align-items-center">
                            <div class="icon">
                              <img class="img-fluid d-block" src="assets/img/post-a-gig/drag-video-icon.png" />
                            </div>
                            <div class="text">
                              ارفع فيديو 
                            </div>
                            <div class="drag-drop-button">
                              <div class="button button-red">
                                ارفع
                              </div>
                              <div class="button button-white">
                                اختار
                              </div>
                            </div>
                          </div>
                        </label>
                      </div>
                      <div class="drag-drop-file d-flex flex-row">
                        <div class="drag-drop-file-item"></div>
                        <div class="drag-drop-file-item"></div>
                        <div class="drag-drop-file-item"></div>
                      </div>
                    </div>
                    <div class="popup">
                      <img alt="" class="lamp-icon" src="assets/img/post-a-gig/lamp-icon.png" />
                      <img alt="Ask our Community" class="img-fluid d-block" src="assets/img/post-a-gig/ask-our-community.png" width="100%" />
                      <p>
                        تساعد مقاطع الفيديو الخاصة بالخدمة المشتري على رؤية وسماع ما ستفعله بالضبط. يستغرق بعض الوقت لإنشاء فيديو متميز. لكنها سوف تزيد بشكل كبير من فرصك للحصول على المشتري<br />
                        <strong>
			الإمتدادات الصالحة هي mp4 و avi و m4v
                        </strong><br />
                        <strong>
                          الحد الأقصى لحجم الملف هو 25 ميغابايت
                        </strong>
                      </p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="custom-label d-flex flex-row align-items-center">
                      <span>
                        <img alt="" class="img-fluid d-block" src="assets/img/post-a-gig/pdf-icon.png" />
                      </span>
                      <span>
                        بي دي اف ( تقدر تضيف لحد  3 ملفات بي دي اف)
                      </span>
                      <span class="mr-auto item-count">(0/3)</span>
                    </label>
                    <div class="drag-drop d-flex flex-wrap">
                      <div class="drag-drop-fileinput">
                        <label class="file-input-label" for="pdf-file">
                          <input type="file" hidden name="pdf-file" id="pdf-file" />
                          <div class="d-flex flex-column align-items-center">
                            <div class="icon">
                              <img class="img-fluid d-block" src="assets/img/post-a-gig/drag-pdf-icon.png" />
                            </div>
                            <div class="text">
                              اسحب قوات الدفاع الشعبي أو
                            </div>
                            <div class="drag-drop-button">
                              <div class="button button-red">
                                تصفح
                              </div>
                              <div class="button button-white">
                                اختار
                              </div>
                            </div>
                          </div>
                        </label>
                      </div>
                      <div class="drag-drop-file d-flex flex-row">
                        <div class="drag-drop-file-item"></div>
                        <div class="drag-drop-file-item"></div>
                        <div class="drag-drop-file-item"></div>
                      </div>
                    </div>
                    <div class="popup">
                      <img alt="" class="lamp-icon" src="assets/img/post-a-gig/lamp-icon.png" />
                      <img alt="Ask our Community" class="img-fluid d-block" src="assets/img/post-a-gig/ask-our-community.png" width="100%" />
                      <p>
                        إن تحميل أي ملفات من نوع بى دى إف تشرح الخدمة التى تقدمها سيؤدي إلى مساعدة المشتري على الشعور بالراحة. عليك إستخدام إصدارات بى دى إف لنماذج العمل والرسومات المعلوماتية والرسوم البيانية وأي شيء آخر يساعد في شرح خدمتك
                      </p>
                    </div>
                  </div> -->
                  <div class="form-group mb-0">
                    <div class="d-flex flex-row justify-content-center">
                      <input class="package-save" type="submit" form="gallery_form" value="حفظ واستمرار">
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                      <a href="<?php echo $_SESSION["seller_user_name"]; ?>/<?php echo $d_proposal_url; ?>" id="previewProposal" class="package-save  d-none">اقتراح المعاينة</a>
                      <!-- <input class="package-save" type="submit" form="gallery_form" value="Save & Continue"> -->
                    </div>
                    <div class="d-flex flex-row align-items-center justify-content-center backbuton backButton">
                      <span><i class="fal fa-long-arrow-left"></i></span>
                      <span>
                        الرجوع
                      </span>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-12 col-md-3" id="popupWidth"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Post a gig end -->
<!-- End New Design -->

<!-- <h5 class="font-weight-normal"><?= $lang['proposals']['gallery_title']; ?></h5>
<h6 class="font-weight-normal"><?= $lang['proposals']['gallery_descrption']; ?></h6>

<hr>

<p class="text-right mb-0">
<span class="float-left"><?= $lang['proposals']['proposals_photos']; ?></span>
<small class="text-muted" style="font-size: 78%;"><?= $lang['proposals']['proposals_photos_description']; ?></small>
</p>

<form action="" class="proposal-form" id="gallery_form"> -->
  <!--- form Starts --->
  <!-- <div class="row gallery"> -->
    <!--- row gallery Starts --->
    <!-- <div class="col-md-3"> -->
      <!--- col-md-3 Starts --->
    <!-- <?php if(empty($d_proposal_img1)){ ?>
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
    </div> -->
    <!--- col-md-3 Ends --->
    <!-- <div class="col-md-3"> -->
      <!--- col-md-3 Starts --->
    <!-- <?php if(empty($d_proposal_img2)){ ?>
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
    </div> -->
    <!--- col-md-3 Ends --->
    <!-- <div class="col-md-3"> -->
      <!--- col-md-3 Starts --->
    <!-- <?php if(empty($d_proposal_img3)){ ?>
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
    </div> -->
    <!--- col-md-3 Ends --->
    <!-- <div class="col-md-3"> -->
      <!--- col-md-3 Starts --->
    <!-- <?php if(empty($d_proposal_img4)){ ?>
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
    </div> -->
    <!--- col-md-3 Ends --->
  <!-- </div> -->
  <!--- row gallery Ends --->
  <!-- <hr>
  <p class="text-right mb-0">
    <span class="float-left"><?= $lang['proposals']['add_video']; ?>add_proposal_video</span>
    <small class="text-muted" style="font-size: 78%;"><?= $lang['proposals']['add_video_description']; ?></small>
  </p>
  <div class="row gallery"> -->
    <!--- row gallery Starts --->
    <!-- <div class="col-md-12"> -->
      <!--- col-md-3 Starts --->
      <!-- <div class="pic <?php if(empty($d_proposal_video)){echo"add-video";}else{echo"video-added";} ?>">
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
    </div> -->
    <!--- col-md-3 Ends --->
  <!-- </div> -->
  <!--- row gallery Ends --->
<!-- </form> -->
<!--- form Ends --->
<!-- 
<div class="mb-5"></div>

<div class="form-group mb-0"> -->
  <!--- form-group Starts --->

<!-- <a href="#" class="btn btn-secondary float-left back-to-req">Back</a>

<input class="btn btn-success float-right" type="submit" form="gallery_form" value="Save & Continue">
<a href="<?php echo $_SESSION["seller_user_name"]; ?>/<?php echo $d_proposal_url; ?>" id="previewProposal" class="btn btn-success float-right mr-3 d-none">Preview Proposal</a>

</div> -->
<!--- form-group Starts --->

<script>
  $('.backButton').click(function(){
    <?php if($d_proposal_status == "draft"){ ?>
    $("input[type='hidden'][name='section']").val("pricing");
    $('#gallery').removeClass('show active');
    $('#pricing').addClass('show active');
    $('#gallery_tab').removeClass('active');
    <?php }else{ ?>
    $('#gallery').removeClass('show active');
    $('#pricing').addClass('show active');
    $('#gallery_tab').removeClass('active');
    <?php } ?>
  });
$(document).ready(function(){
  var browsers = ["Opera", "Edge", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
  var userbrowser, useragent = navigator.userAgent;
  for(var i = 0; i < browsers.length; i++) {
    if( useragent.indexOf(browsers[i]) > -1 ) {
      userbrowser = browsers[i];
      break;
    }
  };
  var url = '<?php echo $site_url ?>';
  function pageRedirect() {
    window.location.replace(url+"/ar/proposals/view_proposals");
  } 
  <?php if($d_proposal_status != "draft"){ ?>
  $("#gallery_form").on('submit', function(event){
    $('#previewProposal').removeClass("d-none");
    setTimeout(pageRedirect(), 15000);
  });
  <?php } ?>

  // $('.back-to-req').click(function(){
  //   <?php if($d_proposal_status == "draft"){ ?>
  //   $("input[type='hidden'][name='section']").val("requirements");
  //   $('#gallery').removeClass('show active');
  //   $('#requirements').addClass('show active');
  //   $('#tabs a[href="#gallery"]').removeClass('active');
  //   <?php }else{ ?>
  //   $('.nav a[href="#requirements"]').tab('show');
  //   <?php } ?>
  // });

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
           main.children('.img-btns').remove();
          main.addClass("img").removeClass("pic");
          main.prepend("<img src='../../proposals/proposal_files/"+data+"' class='img-fluid'> <span><?= $lang['proposals']['remove']; ?></span>");
        }
      });
    });
  });

  var gallery = $('.gallery');
  gallery.on('click', '.img', function () {
    $(this).children("img,span").remove();
    $(this).children("input[type=hidden]").val("");
    $(this).addClass("pic").removeClass("img");
    $(this).prepend("<div class='d-flex flex-column align-items-center img-btns'><div class='drag-drop-button'><div class='button button-red ml-1'>تصفح</div><div class='button button-white'>اختار</div></div></div>");
    $(this).prepend("<i class='fa fa-picture-o fa-2x mb-2'></i><br> دراج صورة او </span>");
  });


  gallery.on('click', '.pic:not(.add-video,.video-added,.disable)',function(){
    var name = $(this).children("input[type=hidden]").attr("name");
    // if(userbrowser == "Edge" || userbrowser == "Safari"){
    //   $("input[type=file]").click();
    //   $("input[type=file]").attr('name',name); 
    //   $("input[type=file]").attr('accept','image/*');
    //   $("input[type=file]").removeAttr('multiple');
    //   $("input[type=file]").on('change',function(){ crop(this); });
    // }else{
      var uploader = $('<input type="file" name="'+name+'" accept="image/*" />');
      uploader.click();
      uploader.on('input', function(){ crop(this); });
    // }
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