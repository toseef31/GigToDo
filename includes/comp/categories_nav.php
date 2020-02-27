<link href="<?= $site_url; ?>/styles/scoped_responsive_and_nav.css" rel="stylesheet">
<link href="<?= $site_url; ?>/styles/vesta_homepage.css" rel="stylesheet">


<div class="container">
  <div class="row align-items-center">
    <div class="col-xs-12">
      <div data-ui="cat-nav" id="desktop-category-nav" class="ui-toolkit cat-nav">
        <div class="bg-white bg-transparent-homepage-experiment hide-xs hide-sm hide-md">
          <div class="body-max-width mainmenu">
            <ul class="body-max-width display-flex-xs justify-content-space-between" role="menubar" data-ui="top-nav-category-list" aria-activedescendant="catnav-primary-link-10855">
              <?php
              $get_categories = $db->query("select * from categories where cat_featured='yes'".($lang_dir=="right"?'order by 1 DESC':'')." LIMIT 0,7");
              while($row_categories = $get_categories->fetch()){
              $cat_id = $row_categories->cat_id;
              $cat_url = $row_categories->cat_url;
              $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
              $row_meta = $get_meta->fetch();
              @$cat_title = $row_meta->cat_title;
              ?>
              <li class="top-nav-item align-items-center text-center" 
                data-linkable="true" data-ui="top-nav-category-link" data-node-id="c-<?php echo $cat_id; ?>">
                <a href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>">
                <?php echo @$cat_title; ?>
                </a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="position-absolute col-xs-12 col-centered z-index-4">
          <div>
            <?php
            $get_categories = $db->query("select * from categories where cat_featured='yes'".($lang_dir=="right"?'order by 1 DESC':'')." LIMIT 0,10");
            while($row_categories = $get_categories->fetch()){
            $cat_id = $row_categories->cat_id;
            $cat_url = $row_categories->cat_url;
            $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
            $row_meta = $get_meta->fetch();
            @$cat_title = $row_meta->cat_title;
            $count = $db->count("categories_children",array("child_parent_id" => $cat_id));
            if($count > 0){
            ?>
            <div class="body-sub-width vertical-align-top sub-nav-container bg-white overflow-hidden bl-xs-1 bb-xs-1 br-xs-1 bt-xs-1 catnav-mott-control display-none" data-ui="sub-nav" aria-hidden="true" data-node-id="c-<?php echo $cat_id; ?>">
              <div class="width-full display-flex-xs">
                <ul class="list-unstyled display-inline-block col-xs-3 p-xs-3 pl-xs-5" role="presentation">
                  <?php
                    $get_child_cat = $db->query("select * from categories_children where child_parent_id='$cat_id' LIMIT 0,7");
                    while($row_child_cat = $get_child_cat->fetch()){
                    $child_id = $row_child_cat->child_id;
                    $child_url = $row_child_cat->child_url;
                    $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                    $row_meta = $get_meta->fetch();
                    $child_title = $row_meta->child_title;
                    ?>
                  <li>
                    <a class="display-block text-gray text-body-larger pt-xs-1" href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>">
                    <?php echo $child_title; ?>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
                <ul class="list-unstyled display-inline-block col-xs-3 p-xs-3 pl-xs-5" role="presentation">
                  <?php
                  $get_child_cat = $db->query("select * from categories_children where child_parent_id='$cat_id' LIMIT 7,7");
                  while($row_child_cat = $get_child_cat->fetch()){
                  $child_id = $row_child_cat->child_id;
                  $child_url = $row_child_cat->child_url;
                  $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                  $row_meta = $get_meta->fetch();
                  $child_title = $row_meta->child_title;
                  ?>
                  <li>
                    <a class="display-block text-gray text-body-larger pt-xs-1" href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>">
                      <?php echo $child_title; ?>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
                <ul class="list-unstyled display-inline-block col-xs-3 p-xs-3 pl-xs-5" role="presentation">
                  <?php
                  $get_child_cat = $db->query("select * from categories_children where child_parent_id='$cat_id' LIMIT 14,7");
                  while($row_child_cat = $get_child_cat->fetch()){
                  $child_id = $row_child_cat->child_id;
                  $child_url = $row_child_cat->child_url;
                  $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                  $row_meta = $get_meta->fetch();
                  $child_title = $row_meta->child_title;

                  ?>
                  <li>
                    <a class="display-block text-gray text-body-larger pt-xs-1" href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>">
                      <?php echo $child_title; ?>
                    </a>
                  </li>
                  <?php }?>
                </ul>
                <ul class="list-unstyled display-inline-block col-xs-3 p-xs-3 pl-xs-5" role="presentation">
                  <?php
                  $get_child_cat = $db->query("select * from categories_children where child_parent_id='$cat_id' LIMIT 21,7");
                  while($row_child_cat = $get_child_cat->fetch()){
                  $child_id = $row_child_cat->child_id;
                  $child_url = $row_child_cat->child_url;
                  $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                  $row_meta = $get_meta->fetch();
                  $child_title = $row_meta->child_title;
                  ?>
                  <li>
                    <a class="display-block text-gray text-body-larger pt-xs-1" href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>/<?php echo $child_url; ?>">
                      <?php echo $child_title; ?>
                    </a>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("comp/mobile_menu.php"); ?>