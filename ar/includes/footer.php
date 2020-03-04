<!-- start footer -->
<!-- <footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-12">
      <h3 data-toggle="collapse" data-target="#collapsecategories"><?= $lang['categories']; ?></h3>
      <ul class="collapse show list-unstyled" id="collapsecategories">
      <?php
      $get_footer_links = $db->query("select * from footer_links where link_section='categories' AND language_id='$siteLanguage'  LIMIT 0,4");
      while($row_footer_links = $get_footer_links->fetch()){
      $link_id = $row_footer_links->link_id;
      $link_title = $row_footer_links->link_title;
      $link_url = $row_footer_links->link_url;
      ?>
      <li class="list-unstyled-item"><a href="<?= $link_url; ?>"><?= $link_title; ?></a></li>
      <?php } ?>
      </ul>
      </div>
      <div class="col-md-2 col-12">
        <h3 class="h3Border" data-toggle="collapse" data-target="#collapseabout"><?= $lang['about']; ?></h3>
        <ul class="collapse show list-unstyled" id="collapseabout">
        <?php
        $get_footer_links = $db->select("footer_links",array("link_section" => "about","language_id" => $siteLanguage));
        while($row_footer_links = $get_footer_links->fetch()){
        $link_id = $row_footer_links->link_id;
        $icon_class = $row_footer_links->icon_class;
        $link_title = $row_footer_links->link_title;
        $link_url = $row_footer_links->link_url;
        ?>
        <li class="list-unstyled-item"><a href="<?= $link_url; ?>"><i class="fa <?= $icon_class; ?>"></i> <?= $link_title; ?></a></li>
        <?php } ?>
        </ul>
      </div>
      <div class="col-md-3 col-12">
        <h3 class="h3Border" data-toggle="collapse" data-target="#collapsecategories2"><?= $lang['categories']; ?></h3>
        <ul class="collapse show list-unstyled" id="collapsecategories2">
        <?php
        $get_footer_links = $db->query("select * from footer_links where link_section='categories' AND language_id='$siteLanguage' LIMIT 4,400");
        while($row_footer_links = $get_footer_links->fetch()){
        $link_id = $row_footer_links->link_id;
        $link_title = $row_footer_links->link_title;
        $link_url = $row_footer_links->link_url;
        ?>
          <li class="list-unstyled-item"><a href="<?= $link_url; ?>"><?= $link_title; ?></a></li>
        <?php } ?>
        </ul>
      </div>
      <div class="col-md-4 col-12">
        <h3 class="h3Border" data-toggle="collapse" data-target="#collapsefindusOn"><?= $lang['find_us_on']; ?></h3>
        <div class="collapse show" id="collapsefindusOn">
          <ul class="list-inline social_icon">
          <?php
          $get_footer_links = $db->select("footer_links",array("link_section" => "follow","language_id" => $siteLanguage));
          while($row_footer_links = $get_footer_links->fetch()){
          $link_id = $row_footer_links->link_id;
          $icon_class = $row_footer_links->icon_class;
          $link_url = $row_footer_links->link_url;
          ?>
          <li class="list-inline-item"><a href="<?= $link_url; ?>"><i class="fa <?= $icon_class; ?>"></i></a></li>
          <?php } ?>
          </ul>
          <?php if($language_switcher == 1){ ?>
          <div class="form-group mt-1">
          <select id="languageSelect" class="form-control">
          <?php 
          $get_languages = $db->select("languages");
          while($row_languages = $get_languages->fetch()){
          $id = $row_languages->id;
          $title = $row_languages->title;
          $image = $row_languages->image;
          ?>
          <option data-image="<?= $site_url; ?>/languages/images/<?= $image; ?>" data-url="<?= "$site_url/change_language?id=$id"; ?>" <?php if($id == $_SESSION["siteLanguage"]){ echo "selected"; } ?>>
          <?= $title; ?>
          </option>
          <?php } ?>
          </select>
          </div>
          <?php } ?>
          <h5><?= $lang['mobile_apps']; ?></h5>
          <img src="<?= $site_url; ?>/images/google.png" class="pic">
          <img src="<?= $site_url; ?>/images/app.png" class="pic1">
        </div>
      </div>
    </div>
  </div>
  <br>
</footer> -->
<!-- Footer-area -->
<div class="footer-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="widget-item">
          <h4>معلومات عن الشركة </h4>
          <?php
          $get_footer_links = $db->query("select * from footer_links where link_section='categories' AND language_id='2'  LIMIT 0,4");
          while($row_footer_links = $get_footer_links->fetch()){
          $link_id = $row_footer_links->link_id;
          $link_title = $row_footer_links->link_title;
          $link_url = $row_footer_links->link_url;
          ?>
          <a href="<?= $site_url?>/ar/<?= $link_url; ?>"><?= $link_title; ?></a>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-item">
          <h4>دعم</h4>
          <?php
          $get_footer_links = $db->select("footer_links",array("link_section" => "about","language_id" => '2'));
          while($row_footer_links = $get_footer_links->fetch()){
          $link_id = $row_footer_links->link_id;
          $icon_class = $row_footer_links->icon_class;
          $link_title = $row_footer_links->link_title;
          $link_url = $row_footer_links->link_url;
          ?>
          <a href="<?= $link_url; ?>"><?= $link_title; ?></a>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-item">
          <h4>اتواصل معانا</h4>
          <p>اتواصل معانا عن طريق الإيميل : <a href="javascript:void(0);">emongez@emongez.com</a></p>

          <div class="footer-social">
            <?php
            $get_footer_links = $db->select("footer_links",array("link_section" => "follow","language_id" => '2'));
            while($row_footer_links = $get_footer_links->fetch()){
            $link_id = $row_footer_links->link_id;
            $icon_class = $row_footer_links->icon_class;
            $link_url = $row_footer_links->link_url;
            ?>
            <a href="<?= $link_url; ?>"><i class="fab <?= $icon_class; ?>"></i></a>
            <?php } ?>
            <!-- <a href="javascript:void(0);"><i class="fab fa-twitter"></i></a>
            <a href="javascript:void(0);"><i class="fab fa-youtube"></i></a>
            <a href="javascript:void(0);"><i class="fab fa-linkedin-in"></i></a>
            <a href="javascript:void(0);"><i class="fab fa-instagram"></i></a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="copyright-area">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-4 col-md-4">
        <div class="copyright">
          <?php if($language_switcher == 1){ 
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                 $url = "https://";   
            else  
                 $url = "http://";   
            // Append the host(domain name, ip) to the URL.   
            $url.= $_SERVER['HTTP_HOST'];   
            
            // Append the requested resource location to the URL   
            $url.= $_SERVER['REQUEST_URI'];    
            $full_url = $_SERVER['REQUEST_URI'];
            
            $page_url = substr("$full_url", 12);
          ?>
          <div>
            <select name=""  id="languageSelect" onChange="window.location.href=this.value">
              <?php 
              $get_languages = $db->select("languages");
              while($row_languages = $get_languages->fetch()){
              $id = $row_languages->id;
              $title = $row_languages->title;
              $image = $row_languages->image;
              ?>
              <!-- <option data-image="<?= $site_url; ?>/languages/images/<?= $image; ?>" data-url="<?= "$site_url/change_language?id=$id"; ?>" <?php if($id == $_SESSION["siteLanguage"]){ echo "selected"; } ?>><?= $title; ?></option> -->
              <?php } ?>
              <option value="<?= $site_url?>/<?php echo $page_url; ?>">EN</option>
              <option value="<?= $site_url?>/ar/<?php echo $page_url; ?>" selected>AR</option>
            </select>
          </div>
          <?php } ?>
          <div>
            <select name="" id="">
              <option value="">USD</option>
              <option value="">EGP</option>
            </select>
          </div>
          <div>
            <p><?= $db->select("general_settings")->fetch()->site_copyright; ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-link">
          <ul>
            <li>
              <p>قريبا على:</p><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/play.png" alt=""></a>
            </li>
            <li><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/apple.png" alt=""></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="widget-link">
          <ul>
            <li>
              <p>المضمون مع</p><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/paypal.png" alt=""></a>
            </li>
            <li><a href="javascript:void(0);"><img src="<?= $site_url ?>/assets/img/noth.png" alt=""></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer-area END-->
<!-- end footer -->
<!-- <section class="post_footer">
<?= $db->select("general_settings")->fetch()->site_copyright; ?>
</section> -->

<?php if(!isset($_COOKIE['close_cookie'])){ ?>
<!-- <section class="clearfix cookies_footer row animated slideInLeft">
<div class="col-md-4">
<img src="<?= $site_url; ?>/images/cookie.png" class="img-fluid" alt="">
</div>
<div class="col-md-8">
<div class="float-right close btn btn-sm"><i class="fa fa-times"></i></div>
<h4 class="mt-0 mt-lg-2 <?=($lang_dir == "right" ? 'text-right':'')?>"><?= $lang["cookie_box"]['title']; ?></h4>
<p class="mb-1 "><?= str_replace('{link}',"$site_url/terms_and_conditions",$lang["cookie_box"]['desc']); ?></p>
<a href="#" class="btn btn-success btn-sm"><?= $lang["cookie_box"]['button']; ?></a>
</div>
</section> -->
<?php } ?>

<section class="messagePopup animated slideInRight"></section>
<link rel="stylesheet" href="<?= $site_url; ?>/styles/msdropdown.css"/>

<?php 
  
  if($videoPlugin == 1){
    require("$dir/plugins/videoPlugin/footer/videoCall.php"); 
  }

?>

<?php require("footerJs.php"); ?>