<?php 

$form_errors = Flash::render("form_errors");
$form_data = Flash::render("form_data");
if (empty($form_data)) {
  $form_data = $input->post();
}

?>


<form action="#" method="post" class="create-gig proposal-form mb-0 border-bottom-0" id="proposal-form">
  <!--- form Starts -->
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/create-gig-icon.png" />
      </span>
      <span>Gig Title</span>
    </label>
    <input class="form-control" type="text" name="proposal_title" value="" placeholder="I will create company logo and company..." />
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_title']); ?></span>
    <!-- <textarea name="proposal_title" rows="3" required="" placeholder="I Will" class="form-control"></textarea> -->
    <!-- <label class="bottom-label text-right">0/2500 Chars Max</label> -->
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>Create a catchy title that captivates viewers. Using well known keywords in your title will help your gig stand out in the eyes of buyers. Try to do some research beforehand on top performing keywords in your industry. This will help you come up with a catchy and relevant title.</p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/category-icon.png" />
      </span>
      <span>Choose a category</span>
    </label>
    <div class="gig-category d-flex flex-wrap align-items-start">
      <?php 
        $get_cats = $db->select("categories");
        while($row_cats = $get_cats->fetch()){
        
        $cat_id = $row_cats->cat_id;
        $cat_icon = $row_cats->cat_icon;
        $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
        $row_meta = $get_meta->fetch();
        $cat_title = $row_meta->cat_title;
        
      ?>

      <div class="gig-category-item">
        <?php
          $get_cats = $db->select("categories");
          while($row_cats = $get_cats->fetch()){
          $cat_id = $row_cats->cat_id;
          $cat_image = $row_cats->cat_image;
          $cat_icon = $row_cats->cat_icon;

          $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $cat_title = $row_meta->cat_title;

          if($cat_id == 1){
          $cat_class= "gd";
          }elseif ($cat_id == 2) {
            $cat_class = "dm";
          }elseif ($cat_id == 3) {
            $cat_class = "wt";
          }elseif ($cat_id == 4) {
            $cat_class = "va";
          }elseif ($cat_id == 7) {
            $cat_class = "ma";
          }elseif ($cat_id == 6) {
            $cat_class = "pt";
          }elseif($cat_id == 8){
            $cat_class= "va";
          }else{
            $cat_class= "ma";
          }
          ?>
          <div class="cat_item-content" data-id="<?= $cat_class; ?>">
            <div class="gig-category-select <?php echo $cat_class; ?> d-flex flex-column align-items-center justify-content-between" onclick="categoryItem(<?= $cat_id; ?>);">
              
              <label for="categoryItem-<?= $cat_id; ?>" class="d-flex flex-column align-items-center justify-content-between">
                <input id="categoryItem-<?= $cat_id; ?>" class="cat_value" value="<?= $cat_id; ?>" type="radio" name="proposal_cat_id" hidden />
                <span class="icon">
                    <img class="img-fluid white-icon" src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" width="75" height="75" />
                    <img class="img-fluid color-icon" src="<?= $site_url; ?>/assets/img/category/<?= $cat_icon; ?>" width="75" height="75" />
                </span>
                <span class="text"><?= $cat_title; ?></span>
              </label>
            </div>
          </div>
        <?php } ?>

        <!-- <select class="form-control" name="child_id" required="" style="display: none;">
          
        </select> -->
        <div class="gig-category-tags"  id="sub-category" style="display: none;">
          
        </div>
        <div class="backto-main flex-row">
            <a href="javascript:void(0)" class="d-flex flex-row align-items-center">
                <span>
                    <i class="fal fa-angle-left"></i>
                </span>
                <span>Go Back</span>
            </a>
        </div>
      </div>
    <?php } ?>
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_cat_id']); ?></span>

      <!-- <label class="gig-category-item item-active" for="categoryItem-1">
        <input checked id="categoryItem-1" type="radio" name="category" hidden />
        <div class="gig-category-select gd d-flex flex-column align-items-center justify-content-between">
          <span class="icon">
            <img class="img-fluid white-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/graphic-design-white.png" />
            <img class="img-fluid color-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/graphic-design-color.png" />
          </span>
          <span class="text">Graphics & Design</span>
        </div>
        <div class="gig-category-tags gd">
          <a class="gig-category-tag tag-selected" href="javascript:void(0);">Logos</a>
          <a class="gig-category-tag tag-selected" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag tag-selected" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag tag-selected" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
          <a class="gig-category-tag" href="javascript:void(0);">Tags Item</a>
        </div>
        <div class="backto-main flex-row">
          <a href="javascript:void(0)" class="d-flex flex-row align-items-center">
            <span>
              <i class="fal fa-angle-left"></i>
            </span>
            <span>Go Back</span>
          </a>
        </div>
      </label> -->
      <!-- Each item -->
    </div>
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>
        Choosing a relevant category and subcategory for your gig will give you the best possible chance of securing buyers. If you perform services that cut across multiple categories, you can break them up into multiple gigs.
      </p>
    </div>
  </div>
  <!--- form-group row Ends --->
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/document-icon.png" />
      </span>
      <span>tell your buyer what you need to get started</span>
    </label>
    <div class="d-flex flex-column">
      <ul class="nav nav-tabs justify-content-end" id="langulageTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">Arabic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">English</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
          <textarea dir="rtl" rows="6" class="form-control text-count" name="proposal_desc" placeholder="أدخل متطلبات الخدمة"></textarea>
        </div>
        <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
          <textarea rows="6" class="form-control text-count" name="proposal_desc" placeholder="I need...."></textarea>
        </div>
      </div>
      <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_desc']); ?></span>
    </div>
    <label class="bottom-label text-right"><span class="descCount">0</span>/2500 Chars Max</label>
    <div class="d-flex flex-column">
      <label class="bottom-label">Answer Type:</label>
      <div class="d-flex flex-row mt-10 mb-10">
        <select class="form-control wide">
          <option value="1">Free Text</option>
          <option value="2">Complex Text</option>
        </select>
      </div>
      <div class="d-flex flex-row">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="customCheck1">
          <label class="custom-control-label" for="customCheck1">Answer is Mandatory</label>
        </div>
      </div>
    </div>
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>
        Set a few gig requirements for your buyers to complete. This will ensure that you have all the necessary information before you begin working on a project.  Choose between free text fields, and file attachment fields for your buyers to complete.
      </p>
    </div>
  </div>

  <!-- <div class="form-group mb-0">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/passage-of-time.png" />
      </span>
      <span>when will you deliver the work?</span>
    </label>
    <div class="deliver-time d-flex flex-wrap">
      <?php
      $get_delivery_times = $db->select("delivery_times");
      while($row_delivery_times = $get_delivery_times->fetch()){
      $delivery_id = $row_delivery_times->delivery_id;
      $delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
      ?>
      <label class="deliver-time-item" for="hours<?php echo $delivery_id; ?>">
        <input id="hours<?php echo $delivery_id; ?>" type="radio" name="delivery_id" value="<?php echo $delivery_id; ?>" hidden />
        <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
          <span class="color-icon">
            <span>-</span>
            <span>+</span>
          </span>
          <span class="d-flex flex-row align-items-end time">
            <span><?php echo $delivery_proposal_title; ?></span>
            
          </span>
        </div>
      </label>
      <?php } ?>
      <label class="deliver-time-item" for="days30">
        <input id="days30" type="radio" name="delivery_id" class="time_select" hidden  />
        <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
          <span class="color-icon">
            <span>-</span>
            <span>+</span>
          </span>
          <span class="d-flex flex-row align-items-end time">
            <span>Custom</span>
            <input autofocus="autofocus" class="input-number" type="text" maxlength="2" pattern="[0-9]{2}" />
          </span>
        </div>
      </label>
    </div>
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['delivery_id']); ?></span>
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>Set realistic deadlines for the work you produce. You can always edit your delivery deadline. Please let your buyer know in advance if you chose to do so.</p>
    </div>
  </div> -->
  <!--- form-group row Ends --->
  <?php if($enable_referrals == "yes"){ ?>
  <div class="form-group d-none">
    <div class="d-flex flex-column">
      <!--- form-group row Starts --->
      <label class="bottom-label">Enable Referrals : </label>
      <div class="d-flex flex-row mt-10 mb-10">
        <select name="proposal_enable_referrals" class="proposal_enable_referrals form-control wide">
          <?php if(@$form_data['proposal_enable_referrals'] == "yes"){ ?>
          <option value="yes"> Yes </option>
          <option value="no"> No </option>
          <?php }else{ ?>
          <option value="no"> No </option>
          <option value="yes"> Yes </option>
          <?php } ?>
        </select>
      </div>
        <small>If enabled, other users can promote your proposal by sharing it on different platforms.</small>
        <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_enable_referrals']); ?></small>
    </div>
  </div>
  <!--- form-group row Ends --->
  <div class="form-group proposal_referral_money d-none">
    <div class="d-flex flex-column">
      <!--- form-group row Starts --->
      <label class="bottom-label">Promotion Commission: </label>
      <div class="d-flex flex-row mt-10 mb-10">
        <input type="number" name="proposal_referral_money" class="form-control" min="1" value="<?php echo @$form_data['proposal_referral_money']; ?>" placeholder="Figure should be in percentage e.g 20">
        <small>Figure should be in percentage. E.g 20 is the same as 20% from the sale of this proposal.</small>
        <br>
        <small> When another user promotes your proposal, how much would you like that user to get from the sale? (in percentage) </small>
      </div>
    </div>
  </div>
  <!--- form-group row Ends --->
  <?php } ?>
 <!--  <div class="form-group d-none">
    <label class="control-label d-flex flex-row align-items-center">
      
      <span class="pl-0">Tags</span>
    </label>
    <input type="text" name="proposal_tags" class="form-control" data-role="tagsinput">
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_tags']); ?></span> -->
    <!-- <div class="d-flex flex-column"> -->
      <!--- form-group row Starts --->
      <!-- <label class="bottom-label d-flex flex-row">Tags</label> -->
      <!-- <div class="d-flex flex-row mt-10 mb-10"> -->
        <!-- <input type="text" name="proposal_tags" class="form-control" data-role="tagsinput">
        <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_tags']); ?></small> -->
      <!-- </div> -->
    <!-- </div> -->
  <!-- </div> -->
  <!--- form-group row Ends --->
</form>
  <!-- <div class="postagig create-gigpostagig create-gig mb-0 border-bottom-0 pl-0 border-top-0 pt-0">
    <div class="form-group rounded-0">
      <div class="pt-3 pb-0">
       <div class="tabs accordion mt-2" id="allTabs">
          <?php //include("sections/edit/extras.php"); ?>
        </div>
      </div>
      <div class="d-flex flex-column align-items-end">
        <div class="d-flex flex-row justify-content-end">
          <a class="btn button-add-more mb-0" type="button" data-toggle="collapse" href="#insert-extra">
            <i class="fal fa-plus"></i>
          </a>
        </div>
      </div>
    </div>
  </div> -->
  <div class="create-gig proposal-form">
    <div class="form-group mb-0">
      <div class="d-flex flex-column">
        <!-- <div class="d-flex flex-row justify-content-end">
          <button class="button-add-more" type="button" role="button">
            <i class="fal fa-plus"></i>
          </button>
        </div> -->
        <div class="d-flex flex-row">
          <button class="button" name="submit" type="submit" form="proposal-form">Next</button>
        </div>
      </div>
    </div>
  </div>
  
<!-- </form> -->

<script>
  $('.input-number').keyup(function(){
    var custom_btn = $('.input-number').val();
    $('#days30').val(custom_btn);
  });
  $(".input-number").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      //display error message
      $("#errmsg").html("Digits Only").show().fadeOut("slow");
             return false;
    }
  });
</script>
<?php 

function insertPackages($proposal_id){
  global $db;
  $insertPackage1 = $db->insert("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic',"price"=>5));
  $insertPackage2 = $db->insert("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard',"price"=>10));
  $insertPackage3 = $db->insert("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance',"price"=>15));
  if($insertPackage3){return true;}
}

if(isset($_POST['submit'])){

  $rules = array(
  "proposal_title" => "required",
  "proposal_cat_id" => "required",
  "proposal_child_id" => "required");

  $messages = array("proposal_title" => "please enter gig title","proposal_cat_id" => "please select a category and subcategory","proposal_desc" => "please enter service requirements","proposal_child_id" => "please select a category and subcategory","proposal_img1"=>"Please add at least 1 image to continue.", "delivery_id" => "please select delivery time");
  $val = new Validator($_POST,$rules,$messages);

  if($val->run() == false){
    Flash::add("form_errors",$val->get_all_errors());
    Flash::add("form_data",$_POST);
    echo "<script> window.open('create_proposal','_self');</script>";
  }else{
    $proposal_title = $input->post('proposal_title');

    function proposalUrl($string, $space="-"){
       
      if(preg_match('/[اأإء-ي]/ui', $string)){
        return urlencode($string);
      }else{
        $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
        $turkceto = array("G","U","S","I","O","C","g","u","s","i","o","c");

        $string = utf8_encode($string);
        if(function_exists('iconv')) {
          $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        }

        $string = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
        $string = trim(preg_replace("/\\s+/", " ", $string));
        $string = strtolower($string);
        $string = str_replace(" ", $space, $string);

        $string = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$string);
        $string = preg_replace($turkcefrom,$turkceto,$string);
        $string = preg_replace("/ +/"," ",$string);
        $string = preg_replace("/ /","-",$string);
        $string = preg_replace("/\s/","",$string);
        $string = strtolower($string);
        $string = preg_replace("/^-/","",$string);
        $string = preg_replace("/-$/","",$string);
        return $string;
     }

    }

    $sanitize_url = proposalUrl($proposal_title);
    $select_proposals = $db->select("proposals",array("proposal_seller_id" => $login_seller_id,"proposal_url" => $sanitize_url));
    $count_proposals = $select_proposals->rowCount();
    if($count_proposals ==  1){
      echo "<script>
      swal({
      type: 'warning',
      text: 'Opps! Your Already Made A Proposal With Same Title Try Another.',
      })</script>";
    }else{
      $proposal_referral_code = mt_rand();
      $get_general_settings = $db->select("general_settings");   
      $row_general_settings = $get_general_settings->fetch();
      $proposal_email = $row_general_settings->proposal_email;
      $site_email_address = $row_general_settings->site_email_address;
      $site_logo = $row_general_settings->site_logo;

      // $data = $input->post();

      $data = array();
      unset($data['submit']);
      $data['proposal_title'] = $input->post('proposal_title');
      $data['proposal_desc'] = $input->post('proposal_desc');
      $data['proposal_cat_id'] = $input->post('proposal_cat_id');
      $data['proposal_child_id'] = $input->post('proposal_child_id');
      // $data['proposal_tags'] = $input->post('proposal_tags');
      $data['proposal_price'] = $input->post('proposal_price');
      // $data['delivery_id'] = $input->post('delivery_id');
      
      $data['proposal_url'] = $sanitize_url;
      $data['proposal_seller_id'] = $login_seller_id;
      $data['proposal_featured'] = "no";
      if($enable_referrals == "no"){ 
      $data['proposal_enable_referrals'] = "no"; 
      }

      $data['level_id'] = $login_seller_level;
      $data['language_id'] = $login_seller_language;
      $data['proposal_status'] = "draft";
      $data['proposal_date'] = date("F d, Y");
      $insert_proposal = $db->insert("proposals",$data);

      if($insert_proposal){

        $proposal_id = $db->lastInsertId();

        if($videoPlugin == 1){
          include("$dir/plugins/videoPlugin/proposals/checkVideo.php");
        }else{
          $redirect = "pricing";
        }

        insertPackages($proposal_id);

        echo "<script>
        swal({
        type: 'success',
        text: 'Details Saved.',
        timer: 2000,
        onOpen: function(){
        swal.showLoading()
        }
        }).then(function(){
          window.open('edit_proposal?proposal_id=$proposal_id&$redirect','_self')
        });
        </script>";
      }
    }

  }

}

?>