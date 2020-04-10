<?php 

$form_errors = Flash::render("form_errors");
$form_data = Flash::render("form_data");
if (empty($form_data)) {
  $form_data = $input->post();
}

?>

<form action="#" class="create-gig proposal-form" method="post">
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/create-gig-icon.png" />
      </span>
      <span>
        عنوان الخدمة
      </span>
    </label>
    <input class="form-control" type="text" name="proposal_title" value="" placeholder="هصمم لوجو الشركة ..." />
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_title']); ?></span>
    <!-- <label class="bottom-label text-right">
      0 \2500 حرف بحد أقصى
    </label> -->
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>
        عشان تجذب المشاهدين، لازم تحط عنوان جذاب. استخدامك شوية كلمات معروفة في العنوان بتاعك هيخلي خدماتك تبقا واضحة و بارزة في عيون المشترين. قبل ما تكتب العنوان، ابحث شوية عن أفضل الكلمات الرئيسية بالنسبة للأداء في مجالك و دة هيساعدك تكتب عنوان مميز و جذاب.
      </p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/category-icon.png" />
      </span>
      <span>
        اختارالفئة
      </span>
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
        $arabic_title = $row_meta->arabic_title;
      ?>
      <!-- <label class="gig-category-item" for="categoryItem-<?= $cat_id; ?>"> -->
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
            $arabic_title = $row_meta->arabic_title;

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
                  <span class="text"><?= $arabic_title; ?></span>
                </label>
              </div>
            </div>
          <?php } ?>
          <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_cat_id']); ?></span>
          <!-- <select class="form-control" name="child_id" required="" style="display: none;">
            
          </select> -->
          <div class="gig-category-tags"  id="sub-category" style="display: none;">
            
          </div>
          <div class="backto-main flex-row">
              <a href="javascript:void(0)" class="d-flex flex-row align-items-center">
                  <span>
                      <i class="fal fa-angle-left"></i>
                  </span>
                  <span>عد</span>
              </a>
          </div>
        </div>
      <?php } ?>
      <!-- Each item -->
    </div>
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>
        لو اخترت الفئة و الفئة الفرعية ليهم صلة بالخدمات اللي بتقدمها، هيبقا عندك  أفضل فرصة ممكنة إنك تأمن المشترين. إذا قدمت خدمات توصل لفئات مختلفة هتقدر تنوع خدماتك و يبقا عندك مجموعات كتيرة.
      </p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/document-icon.png" />
      </span>
      <span>
        قول للمشتري كل حاجة محتاجها عشان تبدأ
      </span>
    </label>
    <div class="d-flex flex-column">
      <ul class="nav nav-tabs justify-content-end" id="langulageTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="false">
            الإنجليزية
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="true">
            العربية
          </a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="english" role="tabpanel" aria-labelledby="english-tab">
          <textarea rows="6" class="form-control" name="proposal_desc" placeholder="I need...."></textarea>
        </div>
        <div class="tab-pane fade show active" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
          <textarea dir="rtl" rows="6" class="form-control" name="proposal_desc" placeholder="أدخل متطلبات الخدمة"></textarea>
        </div>
      </div>
      <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_desc']); ?></span>
    </div>
    <label class="bottom-label text-right">
      <span class="descCount">0</span>-2500 حرف بحد أقصى
    </label>
    <div class="d-flex flex-column">
      <label class="bottom-label">
        نوع الإجابة :
      </label>
      <div class="d-flex flex-row mt-10 mb-10">
        <select class="form-control wide">
          <option value="1">كتابة حرة</option>
          <option value="2">نص مركب</option>
        </select>
      </div>
      <div class="d-flex flex-row">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="customCheck1">
          <label class="custom-control-label" for="customCheck1">
            إجابة أجبارية
          </label>
        </div>
      </div>
    </div>
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>
        حط شوية طلبات خاصة بالخدمة للمشترين قبل ما يحصلوا عليها عشان تضمن إن معاك المعلومات الضرورية قبل ما تبدأ تشتغل على مشروعك. اختار من بين مجالات الكتابة الحرة و كمان مجالات الملفات المرفقة عشات تكمل الخدمة للمشترين.
      </p>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label d-flex flex-row align-items-center">
      <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/passage-of-time.png" />
      </span>
      <span>متي سيتم تسليم العمل ؟</span>
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
            <!-- <span>HRS</span> -->
          </span>
        </div>
      </label>
      <?php } ?>
      <label class="deliver-time-item" for="days30">
        <input id="days30" type="radio" name="delivery_id" hidden  />
        <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
          <span class="color-icon">
            <span>-</span>
            <span>+</span>
          </span>
          <span class="d-flex flex-row align-items-end time">
            <span>مخصص</span>
            <input autofocus="autofocus" class="input-number" type="text" />
          </span>
        </div>
      </label>
    </div>
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['delivery_id']); ?></span>
    <div class="popup">
      <img alt="" class="lamp-icon" src="<?= $site_url; ?>/assets/img/post-a-gig/lamp-icon.png" />
      <img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
      <p>
          حدد مواعيد نهائية واقعية للشغل اللى بتنتجه. ممكن دايما تعدل الميعاد النهائى لتسليم شغلك. يُرجى انك تخلى المشترى يعرف لو اخترت تعمل كدة
      </p>
    </div>
  </div>
  <!--- form-group row Ends --->
  <?php if($enable_referrals == "yes"){ ?>
  <div class="form-group d-none">
    <div class="d-flex flex-column">
      <!--- form-group row Starts --->
      <label class="bottom-label">تمكين الإحالات: </label>
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
        <small>في حالة التمكين ، يمكن للمستخدمين الآخرين الترويج لاقتراحك من خلال مشاركته على منصات مختلفة.</small>
        <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_enable_referrals']); ?></small>
    </div>
  </div>
  <!--- form-group row Ends --->
  <div class="form-group proposal_referral_money d-none">
    <div class="d-flex flex-column">
      <!--- form-group row Starts --->
      <label class="bottom-label">لجنة الترويج: </label>
      <div class="d-flex flex-row mt-10 mb-10">
        <input type="number" name="proposal_referral_money" class="form-control" min="1" value="<?php echo @$form_data['proposal_referral_money']; ?>" placeholder="Figure should be in percentage e.g 20">
        <small>Fيجب أن يكون igure في النسبة المئوية. على سبيل المثال 20 هو نفس 20٪ من بيع هذا الاقتراح.</small>
        <br>
        <small> عندما يروج مستخدم آخر لاقتراحك ، كم تريد أن يحصل عليه هذا المستخدم من البيع؟ (بالنسبة المئوية) </small>
      </div>
    </div>
  </div>
  <!--- form-group row Ends --->
  <?php } ?>
  <div class="form-group d-none">
    <label class="control-label d-flex flex-row align-items-center">
      <!-- <span>
        <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/create-gig-icon.png" />
      </span> -->
      <span class="pl-0">العلامات</span>
    </label>
    <input type="text" name="proposal_tags" class="form-control" data-role="tagsinput">
    <span class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_tags']); ?></span>
    <!-- <div class="d-flex flex-column"> -->
      <!--- form-group row Starts --->
      <!-- <label class="bottom-label">العلامات</label>
      <div class="d-flex flex-row mt-10 mb-10">
        <input type="text" name="proposal_tags" class="form-control" data-role="tagsinput">
        <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_tags']); ?></small>
      </div>
    </div> -->
  </div>
  <!--- form-group row Ends --->
  <div class="form-group mb-0">
    <div class="d-flex flex-column">
      <!-- <div class="d-flex flex-row justify-content-end">
        <button class="button-add-more" type="button" role="button">
          <i class="fal fa-plus"></i>
        </button>
      </div> -->
      <div class="d-flex flex-row">
        <button class="button" name="submit" type="submit">حفظ و استمرار</button>
      </div>
    </div>
  </div>
</form>

<script>
  $('.input-number').keyup(function(){
    var custom_btn = $('.input-number').val();
    $('#days30').val(custom_btn);
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
  "proposal_child_id" => "required",
  "proposal_desc" => "required",
  "delivery_id" => "required");

  $messages = array("proposal_title" => "يرجى إدخال عنوان الخدمة","proposal_cat_id" => "يرجى تحديد الفئة والفئة الفرعية","proposal_desc" => "الرجاء إدخال متطلبات الخدمة","proposal_child_id" => "يرجى تحديد الفئة والفئة الفرعية","proposal_img1"=>"صورة الاقتراح 1 مطلوبة.", "delivery_id" => "الرجاء تحديد وقت التسليم");
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
      unset($data['submit']);

      $data['proposal_title'] = $input->post('proposal_title');
      $data['proposal_desc'] = $input->post('proposal_desc');
      $data['proposal_cat_id'] = $input->post('proposal_cat_id');
      $data['proposal_child_id'] = $input->post('proposal_child_id');
      // $data['proposal_tags'] = $input->post('proposal_tags');
      $data['proposal_price'] = $input->post('proposal_price');
      $data['delivery_id'] = $input->post('delivery_id');
      
      $data['proposal_url'] = $sanitize_url;
      $data['proposal_seller_id'] = $login_seller_id;
      $data['proposal_featured'] = "no";
      if($enable_referrals == "no"){ 
      $data['proposal_enable_referrals'] = "no"; 
      }

      $data['level_id'] = $login_seller_level;
      $data['language_id'] = $login_seller_language;
      $data['proposal_status'] = "draft";

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