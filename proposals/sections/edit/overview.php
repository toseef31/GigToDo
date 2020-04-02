<?php 
$get_delivery_time =  $db->select("delivery_times",array('delivery_id' => $d_delivery_id));
$row_delivery_time = $get_delivery_time->fetch();
$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;
$get_meta = $db->select("cats_meta",array("cat_id" => $d_proposal_cat_id,"language_id" => $siteLanguage));
$row_meta = $get_meta->fetch();
$cat_title = $row_meta->cat_title;
$get_meta = $db->select("child_cats_meta",array("child_id"=>$d_proposal_child_id,"language_id"=>$siteLanguage));
$row_meta = $get_meta->fetch();
$child_title = $row_meta->child_title;
?>
<style>
	#sub-category{
		display: none;
	}
</style>
<!-- New Design -->
<section class="container-fluid postagig pt-0 border-top-0">
	<input type="hidden" name="section" value="overview">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="row">
            <div class="col-12 col-md-8">
              <!-- <div class="tab-content"> -->
              	<!--- tab-content Starts --->
                <!-- <div class="tab-pane fade show active"> -->
                  <form action="#" method="post" class="create-gig proposal-form">
                    <!--- form Starts -->
                    <div class="form-group">
                      <label class="control-label d-flex flex-row align-items-center">
                        <span>
                          <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/create-gig-icon.png" />
                        </span>
                        <span>Gig Title</span>
                      </label>
                      <input class="form-control" type="text" name="proposal_title" value="<?= $d_proposal_title; ?>" placeholder="I can..." />
                      <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_description']); ?></small>
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
                      <div class="d-flex flex-column">
	                      <select name="proposal_cat_id" id="category" class="form-control mb-3" required>
	                      <option value="<?= $d_proposal_cat_id; ?>" selected> <?= $cat_title; ?> </option>
	                      <?php 
	                      $get_cats = $db->query("select * from categories where not cat_id='$d_proposal_cat_id'");
	                      while($row_cats = $get_cats->fetch()){
	                      $cat_id = $row_cats->cat_id;
	                      $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
	                      $row_meta = $get_meta->fetch();
	                      $cat_title = $row_meta->cat_title;
	                      ?>
	                      <option value="<?= $cat_id; ?>"> <?= $cat_title; ?> </option>
	                      <?php } ?>
	                      </select>
	                      <small class="form-text text-danger"><?= ucfirst(@$form_errors['proposal_cat_id']); ?></small>
	                      <select name="proposal_child_id" class="form-control" required>
	                      <option value="<?= $d_proposal_child_id; ?>" selected> <?= $child_title; ?> </option>
	                      <?php
	                      $get_c_cats = $db->query("select * from categories_children where child_parent_id='$d_proposal_cat_id' and not child_id='$d_proposal_child_id'");
	                      while($row_c_cats = $get_c_cats->fetch()){
	                      $child_id = $row_c_cats->child_id;
	                      $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
	                      $row_meta = $get_meta->fetch();
	                      $child_title = $row_meta->child_title;
	                      echo "<option value='$child_id'> $child_title </option>";
	                      }
	                      ?>
	                      </select>
	                    </div>

                      <!-- <div class="gig-category d-flex flex-wrap align-items-start">
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
                      <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_cat_id']); ?></small>

                      </div> -->
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
                            <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">English</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">Arabic</a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                            <textarea rows="6" class="form-control text-count" name="proposal_desc" placeholder="I need...."><?php echo $d_proposal_desc; ?></textarea>
                          </div>
                          <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                            <textarea dir="rtl" rows="6" class="form-control text-count" name="proposal_desc" placeholder="أدخل متطلبات الخدمة"><?php echo $d_proposal_desc; ?></textarea>
                          </div>
                        </div>
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

                    <div class="form-group">
                      <div class="d-flex flex-column">
                        <!--- form-group row Starts --->
                        <label class="bottom-label">Delivery Time</label>
                        <div class="d-flex flex-row mt-10 mb-10">
                        	<select name="delivery_id" class="form-control wide" required="">
                        	<option value="<?= $d_delivery_id; ?>">  <?= $delivery_proposal_title; ?> </option>
                        	<?php 
                        	$get_delivery_times = $db->query("select * from delivery_times where not delivery_id='$d_delivery_id'");
                        	while($row_delivery_times = $get_delivery_times->fetch()){
                        	$delivery_id = $row_delivery_times->delivery_id;
                        	$delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
                        	echo "<option value='$delivery_id'>$delivery_proposal_title</option>";
                        	}
                        	?>
                        	</select>
                        </div>
                        <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['delivery_id']); ?></small>
                      </div>
                    </div>
                    <!--- form-group row Ends --->
                    <?php if($enable_referrals == "yes"){ ?>
                    <div class="form-group">
                      <div class="d-flex flex-column">
                        <!--- form-group row Starts --->
                        <label class="bottom-label">Enable Referrals : </label>
                        <div class="d-flex flex-row mt-10 mb-10">
                          <select name="proposal_enable_referrals" class="proposal_enable_referrals form-control wide" required="">
                          <?php if($d_proposal_enable_referrals == "yes"){ ?>
                          <option value="yes"> Yes </option>
                          <option value="no"> No </option>
                          <?php }elseif($d_proposal_enable_referrals == "no"){ ?>
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
                    <div class="form-group proposal_referral_money">
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
                    <div class="form-group">
                      <div class="d-flex flex-column">
                        <!--- form-group row Starts --->
                        <label class="bottom-label">Tags</label>
                        <div class="d-flex flex-row mt-10 mb-10">
                          <input type="text" name="proposal_tags" class="form-control" data-role="tagsinput" value="<?= $d_proposal_tags; ?>">
                          <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_tags']); ?></small>
                        </div>
                      </div>
                    </div>
                    <!--- form-group row Ends --->
                    <div class="form-group mb-0">
                      <div class="d-flex flex-column align-items-center">
                        <!-- <div class="d-flex flex-row justify-content-end">
                          <button class="button-add-more" type="button" role="button">
                            <i class="fal fa-plus"></i>
                          </button>
                        </div> -->

                        <div class="d-flex flex-row">
                          <button class="button" type="submit">Next</button>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-center backbuton mt-4">
                        	<a href="view_proposals"><span><i class="fal fa-long-arrow-left"></i></span>
                        	<span>go back</span></a>
                        </div>
                      </div>
                    </div>
                    
                  </form>
                <!-- </div> -->
              <!-- </div> -->
            </div>
            <div class="col-12 col-md-4" id="popupWidth"></div>
          </div>
        </div>
        <div class="col-12 col-lg-4">
          <div class="howitwork-card">
            <div class="howitwork-card-title d-flex align-items-center">How it Works</div>
            <div class="howitwork-list d-flex flex-column">
              <div class="howitwork-list-item d-flex flex-row align-items-start">
                <div class="howitwork-list-icon">
                  <img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/postagig.png" />
                </div>
                <div class="howitwork-list-content">
                  <h3>1. Post A Gig</h3>
                  <p>Create and customise services so that buyers can understand clearly the services you provide in order to meet their requirements.</p>
                </div>
              </div>
              <!-- How it work each item -->
              <div class="howitwork-list-item d-flex flex-row align-items-start">
                <div class="howitwork-list-icon">
                  <img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/gethired.png" />
                </div>
                <div class="howitwork-list-content">
                  <h3>2. Get Hired</h3>
                  <p>Communicate with the buyer to work out the specific details of the project. Once you and the seller agree on the requirements, you can begin working.</p>
                </div>
              </div>
              <!-- How it work each item -->
              <div class="howitwork-list-item d-flex flex-row align-items-start">
                <div class="howitwork-list-icon">
                  <img alt="Work" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/work.png" />
                </div>
                <div class="howitwork-list-content">
                  <h3>3. Work</h3>
                  <p>Once you finish your gig, deliver your awesome work on our platform for your client to approve.</p>
                </div>
              </div>
              <!-- How it work each item -->
              <div class="howitwork-list-item d-flex flex-row align-items-start">
                <div class="howitwork-list-icon">
                  <img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/getpaid.png" />
                </div>
                <div class="howitwork-list-content">
                  <h3>4. Get Paid</h3>
                  <p>When the client approves your professional delivery, your funds will be released into your eMongez account. Keep your funds in your eMongez account or transfer them to your bank account</p>
                </div>
              </div>
              <!-- How it work each item -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End New Design -->



