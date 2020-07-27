<?php
@session_start();
if(!isset($_SESSION['admin_email'])){
echo "<script>window.open('login','_self');</script>";
}else{
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">

<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script type="text/javascript" src="../js/summernote.js"></script>
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1><i class="menu-icon fa fa-book"></i> Testimonial</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li class="active">Insert Testimonial</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      
      <?php
      $form_errors = Flash::render("form_errors");
      $form_data = Flash::render("form_data");
      if(is_array($form_errors)){
      ?>
      <div class="alert alert-danger"><!--- alert alert-danger Starts --->
      
      <ul class="list-unstyled mb-0">
        <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
        <li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
        <?php } ?>
      </ul>
      </div><!--- alert alert-danger Ends --->
      <?php } ?>
      <div class="card">
        <div class="card-header">
          <h4 class="h4">
          Insert New Testimonial
          </h4>
        </div>
        <div class="card-body card-block">
          <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="row form-group">
              <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name</label></div>
              <div class="col-12 col-md-9"><input type="text" id="text-input" name="name" class="form-control" required=""><small class="form-text text-muted"></small></div>
            </div>
            <div class="row form-group">
              <div class="col col-md-3"><label for="text-designation" class=" form-control-label">Designation</label></div>
              <div class="col-12 col-md-9"><input type="text" id="text-designation" name="designation" class="form-control" required=""><small class="form-text text-muted"></small></div>
            </div>
            <!--- form-group row Ends --->
            <div class="row form-group">
              <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Description</label></div>
              
              <div class="col-12 col-md-9"><textarea name="description" id="textarea-input" rows="9" placeholder="Start Typing Here..." class="form-control"></textarea></div>
            </div>
            
            <div class="row form-group">
              <div class="col col-md-3"><label for="file-input" class=" form-control-label">Image</label></div>
              <div class="col-12 col-md-9"><input type="file" id="file-input" name="image" class="form-control-file"></div>
            </div>
            <div class="row form-group">
              <div class="col col-md-3"></div>
              <div class="col-12 col-md-9">
                <button type="submit" name="submit" class="btn btn-success">Insert Testimonial</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$('textarea').summernote({
placeholder: 'Start Typing Here...',
height: 150
});
</script>
<?php
if(isset($_POST['submit'])){
$rules = array(
"name" => "required",
"designation" => "required",
"description" => "required",
"image" => "required");

$messages = array("name" => "You must need to write name.", "description" => "You must need to add description", "designation" => "You must need to add designation", "image" => "please upload image");

$val = new Validator($_POST,$rules,$messages);
if($val->run() == false){
Flash::add("form_errors",$val->get_all_errors());
Flash::add("form_data",$_POST);
echo "<script> window.open('index?insert_testimonials','_self');</script>";
}else{

function removeJava($html){

$attrs = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
$dom = new DOMDocument;
@$dom->loadHTML($html);
$nodes = $dom->getElementsByTagName('*');//just get all nodes,
foreach($nodes as $node){
foreach ($attrs as $attr) {
if ($node->hasAttribute($attr)){ $node->removeAttribute($attr);  }
}
}
return strip_tags($dom->saveHTML(),"<div><iframe><br><a><b><i><u><span><img><h1><h2><h3><h4><h5><h6><p><ul><ol><li>");
  }
  $name = $input->post('name');
  $designation = $input->post('designation');
  $description = removeJava($_POST['description']);

  $image = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  $image_extension = pathinfo($image, PATHINFO_EXTENSION);
  $allowed = array('jpeg','jpg','gif','png','tif','ico','webp');

  if(!in_array($image_extension,$allowed)){
  echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
  }else{

  if(!empty($image)){
    $image = pathinfo($image, PATHINFO_FILENAME);
    $image = $image."".time().".$image_extension";
    move_uploaded_file($image_tmp, "../testimonial/testimonial_images/$image");
  }
  $posted_date = date("F d, Y");
  $insert_testimonial = $db->insert("testimonials",array("name"=>$name,"designation"=>$designation,"description"=>$description,"image"=>$image));
  if($insert_testimonial){

  $insert_id = $db->lastInsertId();

  $insert_log = $db->insert_log($admin_id,"Testimonial",$insert_id,"inserted");

  echo "<script>alert('Testimonial inserted successfully.');</script>";

  echo "<script>window.open('index?view_testimonials','_self');</script>";

  }
  }
  }
  }
  ?>
  <?php } ?>