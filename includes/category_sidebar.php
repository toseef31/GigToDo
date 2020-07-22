<?php
  if(isset($_SESSION['cat_id'])){
  $session_cat_id = $_SESSION['cat_id'];  
  
  }
  if(isset($_SESSION['cat_child_id'])){
    $session_cat_child_id = $_SESSION['cat_child_id'];  
    $get_child_cats = $db->select("categories_children",array("child_id" => $session_cat_child_id));
    $child_parent_id = $get_child_cats->fetch()->child_parent_id;
  }
  $online_sellers = array();
  $delivery_time = array();
  $seller_level = array();
  $seller_language = array();
  if(isset($_GET['online_sellers'])){
    foreach($_GET['online_sellers'] as $value){
      $online_sellers[$value] = $value;
    }
  }
  if(isset($_GET['delivery_time'])){
    foreach($_GET['delivery_time'] as $value){
      $delivery_time[$value] = $value;
    }
  }
  if(isset($_GET['seller_level'])){
    foreach($_GET['seller_level'] as $value){
      $seller_level[$value] = $value;
    }
  }
  if(isset($_GET['seller_language'])){
    foreach($_GET['seller_language'] as $value){
      $seller_language[$value] = $value;
    }
  }
  ?>


  <button class="filter-results" type="button" role="button">
    <img src="<?= $site_url; ?>/assets/img/gigs/filter.png" alt="" />Filter by
  </button>
  <div class="gigs-sidebar">
    <h2 class="results-title">
      <a class="backtomain" href="javascript:void(0);">
        <i class="fal fa-angle-left"></i>
      </a>
      <span>Refine Results</span>
      <a class="clearfilter" href="javascript:void(0);">Clear All</a>
    </h2>
    <div class="gigs-sidebar-filter">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url; ?>/assets/img/gigs/filter.png" alt="">Filter by</h4>
      </div>
      <div class="gigs-filter-content ">
        <div class="single-filter clearfix">
          <select id="category" name="cat_value">
            <?php
              $get_cats = $db->select("categories");
              while($row_cats = $get_cats->fetch()){
              $cat_id = $row_cats->cat_id;
              $cat_featured = $row_cats->cat_featured;
              $cat_url = $row_cats->cat_url;
              $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
              $row_meta = $get_meta->fetch();
              $cat_title = $row_meta->cat_title;
              $cat_desc = $row_meta->cat_desc;
              $arabic_title = $row_meta->arabic_title;
              $arabic_desc = $row_meta->arabic_desc;
            ?>
            
            <option value="<?php echo $cat_id; ?>" <?php
            if($cat_id == @$_SESSION['cat_id']){ echo "selected"; }
            if($cat_id == @$child_parent_id){ echo "selected"; }
            ?> ><?= $cat_title; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="single-filter clearfix cat_hide">
          <select id="cat_<?php echo $page_cat_id; ?>" onChange="window.location.href=this.value">
            <?php
              $get_child_cat = $db->select("categories_children",array("child_parent_id" => $child_parent_id));
              while($row_child_cat = $get_child_cat->fetch()){
                $child_id = $row_child_cat->child_id;
                $child_url = $row_child_cat->child_url;
                $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                $row_meta = $get_meta->fetch();
                $child_title = $row_meta->child_title;
                if(!empty($child_title)){
            ?>
            <option <?php if($child_id == @$_SESSION['cat_child_id']){ echo "selected"; } ?> value="<?php echo $site_url; ?>/categories/<?php echo $cat_page_url; ?>/<?php echo $child_url; ?>"><?php echo $child_title; ?></option>
            <?php } } ?>
          </select>
          
        </div>
        <div class="single-filter clearfix d-none" id="sub-cat">
          <select id="sub-category" class="form-control" onChange="window.location.href=this.value">
            
          </select>
          
        </div>
      </div>
    </div>
    
    <div class="gigs-sidebar-price">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/price.png" alt="">Price</h4>
      </div>
      <div class="gigs-price-content ">
        <input id="price" type="text" name="price_slider" value="" class="irs-hidden-input" tabindex="-1" readonly="">
        <input type="hidden" id="price_range" name="">
      </div>
    </div>
    
    <div class="gigs-sidebar-status">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/status.png" alt="">Status</h4>
      </div>
      <div class="gigs-status-content d-flex justify-content-between align-items-center">
        <div class="status-text pt-20">
          <p class="text">Online</p>
        </div>
        <div class="status-switch pt-20">
          <div class="md_switch">
            <input class="switch get_online_sellers" id="switch" value="1" type="checkbox" <?php if(isset($online_sellers["1"])){ echo "checked"; } ?> >
            <label for="switch"></label>
          </div>
        </div>
      </div>
    </div>
    
    <div class="gigs-sidebar-titme">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/time.png" alt="">Delivery Time</h4>
      </div>
      <div class="gigs-titme-content pt-20">
        <ul class="radio_titme radio_style2">
          <?php
            if(isset($_SESSION['cat_id'])){
              $get_proposals = $db->query("select DISTINCT delivery_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
            }elseif(isset($_SESSION['cat_child_id'])){
              $get_proposals = $db->query("select DISTINCT delivery_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
            }
            while($row_proposals = $get_proposals->fetch()){
            $delivery_id = $row_proposals->delivery_id;
            $select_delivery_time = $db->select("delivery_times",array('delivery_id' => $delivery_id));
            $delivery_title = @$select_delivery_time->fetch()->delivery_title;
            if(!empty($delivery_title)){
          ?>
          <li>
            <input type="radio" name="radio_titme" checked="" id="time<?php echo $delivery_id; ?>" class="get_delivery_time" value="<?php echo $delivery_id; ?>" <?php if(isset($delivery_time[$delivery_id])){ echo "checked"; } ?> >
            <label for="time<?php echo $delivery_id; ?>"><span></span><?php echo $delivery_title; ?></label>
          </li>
          <?php }} ?>
        </ul>
      </div>
    </div>

    <!-- <div class="gigs-sidebar-titme">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/time.png" alt="">Seller Level</h4>
      </div>
      <div class="gigs-titme-content pt-20">
        <ul class="radio_titme radio_style2">
          <?php
            if(isset($_SESSION['cat_id'])){
              $get_proposals = $db->query("select DISTINCT level_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
            }elseif(isset($_SESSION['cat_child_id'])){
              $get_proposals = $db->query("select DISTINCT level_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
            }
            while($row_proposals = $get_proposals->fetch()){
              $level_id = $row_proposals->level_id;
              $select_seller_levels = $db->select("seller_levels",array('level_id' => $level_id));
              $level_title = @$db->select("seller_levels_meta",array("level_id"=>$level_id,"language_id"=>$siteLanguage))->fetch()->title;
              if(!empty($level_title)){
          ?>
          <li>
            <input type="radio" id="level<?php echo $level_id; ?>" value="<?php echo $level_id; ?>" class="get_seller_level"
              <?php if(isset($seller_level[$level_id])){ echo "checked"; } ?> >
            
            <label for="level<?php echo $level_id; ?>"><span></span><?php echo $level_title; ?></label>
          </li>
          <?php }} ?>
        </ul>
      </div>
    </div> -->

    <!-- <div class="gigs-sidebar-titme">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/time.png" alt="">Seller Lang
        </h4>
      </div>
      <div class="gigs-titme-content pt-20">
        <ul class="radio_titme radio_style2">
          <?php
            if(isset($_SESSION['cat_id'])){
              $get_proposals = $db->query("select DISTINCT language_id from proposals where not language_id='0' and proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
            }elseif(isset($_SESSION['cat_child_id'])){
              $get_proposals = $db->query("select DISTINCT language_id from proposals where not language_id='0' and proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
            }
            while($row_proposals = $get_proposals->fetch()){
              $language_id = $row_proposals->language_id;
              $select_seller_languges = $db->select("seller_languages",array('language_id' => $language_id));
              $language_title = @$select_seller_languges->fetch()->language_title;
              if(!empty($language_title)){
          ?>
          <li>
            
            <input type="radio" id="lang<?php echo $language_id; ?>"> value="<?php echo $language_id; ?>" class="get_seller_language"
              <?php if(isset($seller_language[$language_id])){ echo "checked"; } ?> >
            <span> <?php echo $language_title; ?> </span>
            <label for="lang<?php echo $language_id; ?>"></label>
          </li>
          <?php }} ?>
        </ul>
      </div>
    </div> -->
    
    <!-- <div class="gigs-sidebar-rating">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/star.png" alt="">Rating</h4>
      </div>
      <div class="gigs-rating-content">
        <div class="single-rating clearfix">
          <select>
            <option value="0">Logo Design</option>
            <option value="1">Logo Design 01</option>
            <option value="2">Logo Design 02</option>
            <option value="3">Logo Design 03</option>
            <option value="4">Logo Design 04</option>
          </select>
        </div>
      </div>
    </div> -->
    
    <div class="gigs-sidebar-search">
      <div class="gigs-sidebar-title">
        <h4 class="title"><img src="<?= $site_url;?>/assets/img/gigs/keyword.png" alt="">Keywords</h4>
      </div>
      <div class="gigs-search-content mt-20">
        <input type="search" id="keyword" onkeyup="getgig()" placeholder="Search by Keywords">
      </div>
    </div>
    
    <div class="gigs-sidebar-button">
      <div class="gigs-button-content">
        <button>Update Search</button>
      </div>
    </div>
  </div>

<!-- <div class="card border-success mb-3">
  <div class="card-header bg-success">
    <h3 class="<?=($lang_dir == "right" ? 'float-right':'float-left')?> h5 text-white"><?php echo $lang['sidebar']['categories']; ?></h3>
  </div>
  <div class="card-body">
    <ul class="nav flex-column" id="proposal_category">
      <?php
        $get_cats = $db->select("categories");
        while($row_cats = $get_cats->fetch()){
        $cat_id = $row_cats->cat_id;
        $cat_featured = $row_cats->cat_featured;
        $cat_url = $row_cats->cat_url;
        $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
        $row_meta = $get_meta->fetch();
        $cat_title = $row_meta->cat_title;
        $cat_desc = $row_meta->cat_desc;
      ?>
      <li class="nav-item">
        <span class="nav-link 
          <?php
            if($cat_id == @$_SESSION['cat_id']){ echo "active"; }
            if($cat_id == @$child_parent_id){ echo "active"; }
            ?>">     
        <a href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>" class="text-success"> <?php echo $cat_title; ?></a> 
        <a class="h5 text-success float-right" data-toggle="collapse" data-target="#cat_<?php echo $cat_id; ?>">
        <i class="fa fa-arrow-circle-down"></i>
        </a>
        </span>
        <ul id="cat_<?php echo $cat_id; ?>" class="collapse">
          <?php
            $get_child_cat = $db->select("categories_children",array("child_parent_id" => $child_parent_id));
            while($row_child_cat = $get_child_cat->fetch()){
              $child_id = $row_child_cat->child_id;
              $child_url = $row_child_cat->child_url;
              $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
              $row_meta = $get_meta->fetch();
              $child_title = $row_meta->child_title;
              if(!empty($child_title)){
          ?>
          <li>
            <a class="nav-link text-success <?php if($child_id == @$_SESSION['cat_child_id']){ echo "active"; } ?>" href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>">
            <?php echo $child_title; ?>
            </a>
          </li>
          <?php }} ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </div>
</div>
<div class="card border-success mb-3">
  <div class="card-body pb-2 pt-2">
    <ul class="nav flex-column">
      <li class="nav-item checkbox checkbox-success">
        <label class="pt-2">
        <input type="checkbox" value="1" class="get_online_sellers"
          <?php if(isset($online_sellers["1"])){ echo "checked"; } ?> >
        <span><?php echo $lang['sidebar']['online_sellers']; ?></span>
        </label>
      </li>
    </ul>
  </div>
</div>
<div class="card border-success mb-3">
  <div class="card-header bg-success">
    <h3 class="<?=($lang_dir == "right" ? 'float-right':'float-left')?> text-white h5"><?php echo $lang['sidebar']['delivery_time']; ?></h3>
    <button class="btn btn-secondary btn-sm <?=($lang_dir == "right" ? 'float-left':'float-right')?> clear_delivery_time clearlink" onclick="clearDelivery()">
    <i class="fa fa-times-circle"></i> Clear Filter
    </button>
  </div>
  <div class="card-body">
    <ul class="nav flex-column">
      <?php
        if(isset($_SESSION['cat_id'])){
          $get_proposals = $db->query("select DISTINCT delivery_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
        }elseif(isset($_SESSION['cat_child_id'])){
          $get_proposals = $db->query("select DISTINCT delivery_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
        }
        while($row_proposals = $get_proposals->fetch()){
        $delivery_id = $row_proposals->delivery_id;
        $select_delivery_time = $db->select("delivery_times",array('delivery_id' => $delivery_id));
        $delivery_title = @$select_delivery_time->fetch()->delivery_title;
        if(!empty($delivery_title)){
      ?>
      <li class="nav-item checkbox checkbox-success">
        <label>
        <input type="checkbox" value="<?php echo $delivery_id; ?>" class="get_delivery_time"
          <?php if(isset($delivery_time[$delivery_id])){ echo "checked"; } ?> >
        <span> <?php echo $delivery_title; ?> </span>
        </label>
      </li>
      <?php }} ?>
    </ul>
  </div>
</div>
<div class="card border-success mb-3">
  <div class="card-header bg-success">
    <h3 class="<?=($lang_dir == "right" ? 'float-right':'float-left')?> text-white h5"><?php echo $lang['sidebar']['seller_level']; ?></h3>
    <button class="btn btn-secondary btn-sm <?=($lang_dir == "right" ? 'float-left':'float-right')?> clear_seller_level clearlink" onclick="clearLevel()">
    <i class="fa fa-times-circle"></i> Clear Filter
    </button>
  </div>
  <div class="card-body">
    <ul class="nav flex-column">
      <?php
        if(isset($_SESSION['cat_id'])){
          $get_proposals = $db->query("select DISTINCT level_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
        }elseif(isset($_SESSION['cat_child_id'])){
          $get_proposals = $db->query("select DISTINCT level_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
        }
        while($row_proposals = $get_proposals->fetch()){
          $level_id = $row_proposals->level_id;
          $select_seller_levels = $db->select("seller_levels",array('level_id' => $level_id));
          $level_title = @$db->select("seller_levels_meta",array("level_id"=>$level_id,"language_id"=>$siteLanguage))->fetch()->title;
          if(!empty($level_title)){
      ?>
      <li class="nav-item checkbox checkbox-primary">
        <label>
        <input type="checkbox" value="<?php echo $level_id; ?>" class="get_seller_level"
          <?php if(isset($seller_level[$level_id])){ echo "checked"; } ?> >
        <span> <?php echo $level_title; ?> </span>
        </label>
      </li>
      <?php }} ?>
    </ul>
  </div>
</div>
<div class="card border-success mb-3">
  <div class="card-header bg-success">
    <h2 class="float-left text-white h5"><?php echo $lang['sidebar']['seller_lang']; ?></h2>
    <button class="btn btn-secondary btn-sm <?=($lang_dir == "right" ? 'float-left':'float-right')?> clear_seller_language clearlink" onclick="clearLanguage()">
    <i class="fa fa-times-circle"></i> Clear Filter
    </button>
  </div>
  <div class="card-body">
    <ul class="nav flex-column">
      <?php
        if(isset($_SESSION['cat_id'])){
          $get_proposals = $db->query("select DISTINCT language_id from proposals where not language_id='0' and proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));
        }elseif(isset($_SESSION['cat_child_id'])){
          $get_proposals = $db->query("select DISTINCT language_id from proposals where not language_id='0' and proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
        }
        while($row_proposals = $get_proposals->fetch()){
          $language_id = $row_proposals->language_id;
          $select_seller_languges = $db->select("seller_languages",array('language_id' => $language_id));
          $language_title = @$select_seller_languges->fetch()->language_title;
          if(!empty($language_title)){
      ?>
      <li class="nav-item checkbox checkbox-primary">
        <label>
        <input type="checkbox" value="<?php echo $language_id; ?>" class="get_seller_language"
          <?php if(isset($seller_language[$language_id])){ echo "checked"; } ?> >
        <span> <?php echo $language_title; ?> </span>
        </label>
      </li>
      <?php }} ?>
    </ul>
  </div>
</div> -->
