<?php 
$get_delivery_time =  $db->select("delivery_times",array('delivery_id' => $d_delivery_id));
$row_delivery_time = $get_delivery_time->fetch();
$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;
$get_meta = $db->select("cats_meta",array("cat_id" => $d_proposal_cat_id,"language_id" => $siteLanguage));
$row_meta = $get_meta->fetch();
$cat_title = $row_meta->cat_title;
$arabic_title = $row_meta->arabic_title;
$get_meta = $db->select("child_cats_meta",array("child_id"=>$d_proposal_child_id,"language_id"=>$siteLanguage));
$row_meta = $get_meta->fetch();
$child_title = $row_meta->child_title;
$child_arabic_title = $row_meta->child_arabic_title;
?>
<style>
	.category_section .nice-select{
		display: none;
	}
  #sub-category, #category{
    display: block !important;
  }
	.insert_btn{
	  background-color: #ff0707;
	  border: 2px solid #ff0707;
	  -webkit-border-radius: 3px;
	  -moz-border-radius: 3px;
	  border-radius: 3px;
	  color: white;
	  font-size: 16px;
	  font-weight: 600;
	  text-transform: uppercase;
	}
	.delete-extra{
	  text-transform: uppercase;
	  font-size: 16px;
	}
</style>
<!-- New Design -->
<!-- Post a gig -->
<section class="container-fluid postagig pt-0 border-top-0">
	<div class="row">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="row">
						<div class="col-12 col-md-8">
							<form action="#" class="create-gig proposal-form mb-0 border-bottom-0" id="proposal-form" method="post">
								<div class="form-group">
									<label class="control-label d-flex flex-row align-items-center">
										<span>
											<img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/create-gig-icon.png" />
										</span>
										<span>
											عنوان الخدمة
										</span>
									</label>
									<input class="form-control" type="text" name="proposal_title" value="هصمم لوجو الشركة ..." placeholder="I can..." />
									<label class="bottom-label text-right">
										0 \2500 حرف بحد أقصى
									</label>
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
                  <div class="d-flex flex-column category_section">
                    <select name="proposal_cat_id" id="category" class="form-control mb-3" required>
                    <option value="<?= $d_proposal_cat_id; ?>" selected> <?= $arabic_title; ?> </option>
                    <?php 
                    $get_cats = $db->query("select * from categories where not cat_id='$d_proposal_cat_id'");
                    while($row_cats = $get_cats->fetch()){
                    $cat_id = $row_cats->cat_id;
                    $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
                    $row_meta = $get_meta->fetch();
                    $cat_title = $row_meta->cat_title;
                   	$arabic_title = $row_meta->arabic_title;
                    ?>
                    <option value="<?= $cat_id; ?>"> <?= $arabic_title; ?> </option>
                    <?php } ?>
                    </select>
                    <small class="form-text text-danger"><?= ucfirst(@$form_errors['proposal_cat_id']); ?></small>
                    <select name="proposal_child_id" class="form-control" id="sub-category" required>
                    <option value="<?= $d_proposal_child_id; ?>" selected> <?= $child_arabic_title; ?> </option>
                    <?php
                    $get_c_cats = $db->query("select * from categories_children where child_parent_id='$d_proposal_cat_id' and not child_id='$d_proposal_child_id'");
                    while($row_c_cats = $get_c_cats->fetch()){
                    $child_id = $row_c_cats->child_id;
                    $get_meta = $db->select("child_cats_meta",array("child_id" => $child_id, "language_id" => $siteLanguage));
                    $row_meta = $get_meta->fetch();
                    $child_title = $row_meta->child_title;
                    $child_arabic_title = $row_meta->child_arabic_title;
                    echo "<option value='$child_id'> $child_arabic_title </option>";
                    }
                    ?>
                    </select>
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
												<textarea rows="6" class="form-control" name="proposal_desc" placeholder="I need...."><?php echo $d_proposal_desc; ?></textarea>
											</div>
											<div class="tab-pane fade show active" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
												<textarea dir="rtl" rows="6" name="proposal_desc" class="form-control" placeholder="أدخل متطلبات الخدمة"><?php echo $d_proposal_desc; ?></textarea>
											</div>
										</div>
									</div>
									<label class="bottom-label text-right">
										0-2500 حرف بحد أقصى
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
								<div class="form-group mb-0">
                  <label class="control-label d-flex flex-row align-items-center">
                    <span>
                      <img alt="" class="img-fluid d-block" src="<?= $site_url; ?>/assets/img/post-a-gig/passage-of-time.png" />
                    </span>
                    <span>متي سيتم تسليم العمل ؟</span>
                  </label>
                  <div class="deliver-time d-flex flex-wrap">
                    <label class="deliver-time-item" for="hours<?= $d_delivery_id; ?>">
                      <?php 
                      	if($delivery_proposal_title == ''){
                      		$delivery_proposal_title = $d_delivery_id;
                      	}
                      ?>
                      <input id="hours<?= $d_delivery_id; ?>" type="radio" name="delivery_id" value="<?= $d_delivery_id; ?>" hidden checked/>
                      <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
                        <span class="color-icon">
                          <span>-</span>
                          <span>+</span>
                        </span>
                        <span class="d-flex flex-row align-items-end time">
                          <span><?= $delivery_proposal_title; ?></span>
                          <!-- <span>HRS</span> -->
                        </span>
                      </div>
                    </label>
                    <?php 
                    $get_delivery_times = $db->query("select * from delivery_times where not delivery_id='$d_delivery_id'");
                    while($row_delivery_times = $get_delivery_times->fetch()){
                    $delivery_id = $row_delivery_times->delivery_id;
                    $delivery_proposal_title_arabic = $row_delivery_times->delivery_proposal_title_arabic;
                   
                    ?>
                    <label class="deliver-time-item" for="hours<?php echo $delivery_id; ?>">
                      <input id="hours<?php echo $delivery_id; ?>" type="radio" name="delivery_id" value="<?php echo $delivery_id; ?>" hidden />
                      <div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
                        <span class="color-icon">
                          <span>-</span>
                          <span>+</span>
                        </span>
                        <span class="d-flex flex-row align-items-end time">
                          <span><?php echo $delivery_proposal_title_arabic; ?></span>
                          <!-- <span>HRS</span> -->
                        </span>
                      </div>
                    </label>
                    <?php } ?>
                  </div>
                  <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['delivery_id']); ?></small>
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
								      <small>يجب أن يكون الرقم بالنسبة المئوية. على سبيل المثال 20 هو نفس 20٪ من بيع هذا الاقتراح.</small>
								      <br>
								      <small> عندما يروج مستخدم آخر لاقتراحك ، كم تريد أن يحصل عليه هذا المستخدم من البيع؟ (بالنسبة المئوية) </small>
								    </div>
								  </div>
								</div>
								<!--- form-group row Ends --->
								<?php } ?>
								</form>
								<!-- <div class="postagig create-gigpostagig create-gig mb-0 border-bottom-0 pl-0 border-top-0 pt-0"">
								  <div class="form-group rounded-0">
								    <div class="pt-3 pb-0">
								     <div class="tabs accordion mt-2" id="allTabs">
								        <?php //include("extras.php"); ?>
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
								<!--- form-group row Ends --->
								<div class="postagig create-gig">
									<div class="form-group mb-0">
										<div class="d-flex flex-column">
											<!-- <div class="d-flex flex-row justify-content-end">
												<button class="button-add-more" type="button" role="button">
													<i class="fal fa-plus"></i>
												</button>
											</div> -->
											<div class="d-flex flex-row">
												<button class="button" type="submit" form="proposal-form">حفظ و استمرار</button>
											</div>
											<div class="d-flex flex-row align-items-center justify-content-center backbuton mt-4">
												<a href="view_proposals"><span><i class="fal fa-long-arrow-left"></i></span>
												<span>عد</span></a>
											</div>
										</div>
									</div>
								</div>
							<!-- </form> -->
						</div>
						<div class="col-12 col-md-4" id="popupWidth"></div>
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="howitwork-card">
						<div class="howitwork-card-title d-flex align-items-center">
							ازاي بيشتغل
						</div>
						<div class="howitwork-list d-flex flex-column">
							<div class="howitwork-list-item d-flex flex-row align-items-start">
								<div class="howitwork-list-icon">
									<img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/postagig.png" />
								</div>
								<div class="howitwork-list-content">
                  <h3>1. نشر خدمة</h3>
                  <p>
                      ابدأ وخصص خدماتك بحيث الناس اللى هتشترى يقدروا يفهموا بشكل واضح الخدمات اللى بتوفرها علشان تقابل احتياجاتهم
                      
                  </p>
								</div>
							</div>
							<!-- How it work each item -->
							<div class="howitwork-list-item d-flex flex-row align-items-start">
								<div class="howitwork-list-icon">
									<img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/gethired.png" />
								</div>
								<div class="howitwork-list-content">
									<h3>2. التعاقد</h3>
									<p>
										اتواصل مع المشتري عشان تحددوا التفاصيل الخاصة بالمشروع. بمجرد ما تتفق انت و مقدم الخدمة على الطلبات، هتبدأ الشغل.
									</p>
								</div>
							</div>
							<!-- How it work each item -->
							<div class="howitwork-list-item d-flex flex-row align-items-start">
								<div class="howitwork-list-icon">
									<img alt="Work" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/work.png" />
								</div>
								<div class="howitwork-list-content">
									<h3>3. الشغل</h3>
									<p>
										بمجردما تخلص شغلك،هتسلمال شغل الرائع على منصتنا عشان العميل يوافق عليه.
									</p>
								</div>
							</div>
							<!-- How it work each item -->
							<div class="howitwork-list-item d-flex flex-row align-items-start">
								<div class="howitwork-list-icon">
									<img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url; ?>/ar/assets/img/post-a-gig/getpaid.png" />
								</div>
								<div class="howitwork-list-content">
									<h3>4. استلم فلوسك</h3>
									<p>
										لما العميل يوافق على شغلك اللي اتسلم، فلوسك هتتحول لحسابك على موقع "منجز" و كمان ممكن تخلي فلوسك في حسابك على موقع "منجز" أو تحولهم لحسابك في البنك.
									</p>
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
<!-- Post a gig end -->
<!-- End New Design -->

<!-- <form action="#" method="post" class="proposal-form"> -->
	<!--- form Starts -->

	<!-- <div class="form-group row"> -->
		<!--- form-group row Starts --->
	<!-- <div class="col-md-3">Proposal Title</div>
	<div class="col-md-9"><textarea name="proposal_title" rows="2" placeholder="I Will" required="" class="form-control"><?= $d_proposal_title; ?></textarea></div>
	<small class="form-text text-danger"><?= ucfirst(@$form_errors['proposal_description']); ?></small>
	</div> -->
	<!--- form-group row Ends --->

	<!-- <div class="form-group row"> -->
		<!--- form-group row Starts --->
	<!-- <div class="col-md-3"> Category </div>
	<div class="col-md-9">
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
	<select name="proposal_child_id" id="sub-category" class="form-control" required>
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
	</div> -->
	<!--- form-group row Ends --->

	<!-- <div class="form-group row"> -->
		<!--- form-group row Starts --->
	<!-- <div class="col-md-3">Delivery Time</div>
	<div class="col-md-9">
	<select name="delivery_id" class="form-control" required="">
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
	<small class="form-text text-danger"><?= ucfirst(@$form_errors['delivery_id']); ?></small>
	</div> -->
	<!--- form-group row Ends --->

	<!-- <?php if($enable_referrals == "yes"){ ?>
	<div class="form-group row"> -->
		<!--- form-group row Starts --->
	<!-- <label class="col-md-3 control-label"> Enable Referrals : </label>
	<div class="col-md-9">
	<select name="proposal_enable_referrals" class="proposal_enable_referrals form-control" required="">
	<?php if($d_proposal_enable_referrals == "yes"){ ?>
	<option value="yes"> Yes </option>
	<option value="no"> No </option>
	<?php }elseif($d_proposal_enable_referrals == "no"){ ?>
	<option value="no"> No </option>
	<option value="yes"> Yes </option>
	<?php } ?>
	</select>
	<small>If enabled, other users can promote your proposal by sharing it on different platforms.</small>
	</div>
	</div> -->
	<!--- form-group row Ends --->

	<!-- <div class="form-group row proposal_referral_money"> -->
		<!--- form-group row Starts --->
	<!-- <label class="col-md-3 control-label"> Promotion Commission: </label>
	<div class="col-md-9">
	<input type="number" name="proposal_referral_money" class="form-control" min="1" max="100" value="<?= $d_proposal_referral_money; ?>">
	<small>Figure should be in percentage. E.g 20 is the same as 20% from the sale of this proposal.</small>
	<br>
	<small> 
	When another user promotes your proposal, how much would you like that user to get from the sale? (in dollars)
	</small>
	</div>
	</div> -->
	<!--- form-group row Ends --->
	<!-- <?php } ?>

	<div class="form-group row"> -->
		<!--- form-group row Starts --->
	<!-- <div class="col-md-3">Tags</div>
	<div class="col-md-9"><input type="text" name="proposal_tags" class="form-control" data-role="tagsinput" value="<?= $d_proposal_tags; ?>"></div>
	<small class="form-text text-danger"><?= ucfirst(@$form_errors['proposal_tags']); ?></small>
	</div> -->
	<!--- form-group row Ends --->

	<!-- <div class="form-group mb-0"> -->
		<!--- form-group Starts --->
	<!-- <a href="view_proposals" class="float-left btn btn-secondary">Cancel</a>
	<input class="btn btn-success float-right" type="submit" value="Save & Continue">
	</div> -->
	<!--- form-group Starts --->

<!-- </form> -->
<!--- form Ends -->