<?php
session_start([
    'cookie_lifetime' => 86400,
  ]);
require_once("../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}
$seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_name = $row_login_seller->seller_name;
$login_user_name = $row_login_seller->seller_user_name;
$login_seller_offers = $row_login_seller->seller_offers;
$relevant_requests = $row_general_settings->relevant_requests;

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar" class="ui-toolkit">
	<head>
		<title><?= $site_name; ?> - <?= $lang["titles"]["post_request"]; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?= $site_desc; ?>">
		<meta name="keywords" content="<?= $site_keywords; ?>">
		<meta name="author" content="<?= $site_author; ?>">
		<?php if(!empty($site_favicon)){ ?>
		<!--====== Favicon Icon ======-->
		<link rel="shortcut icon" href="../images/<?= $site_favicon; ?>" type="image/png">
		<?php } ?>
		<!-- ==============Google Fonts============= -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
		<!--====== Bootstrap css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/bootstrap.min.css" rel="stylesheet">
		<!--====== PreLoader css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/preloader.css" rel="stylesheet">
		<!--====== Animate css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/animate.min.css" rel="stylesheet">
		<!--====== Fontawesome css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/fontawesome.min.css" rel="stylesheet">
		<!--====== Owl carousel css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/owl.carousel.min.css" rel="stylesheet">
		<!--====== Nice select css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/nice-select.css" rel="stylesheet">
		<link href="<?= $site_url; ?>/ar/assets/css/tagsinput.css" rel="stylesheet">
		<!--====== Default css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
		<!--====== Style css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
		<!--====== Responsive css ======-->
		<link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
		<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
		<link href="../styles/bootstrap.css" rel="stylesheet">
		<link href="../styles/custom.css" rel="stylesheet"> --> 
		<!-- Custom css code from modified in admin panel --->
		<link href="../styles/styles.css" rel="stylesheet">
		<link href="../styles/user_nav_styles.css" rel="stylesheet">
		<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../styles/sweat_alert.css" rel="stylesheet">
		<link href="../styles/animate.css" rel="stylesheet">
		<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
		<script src="../js/ie.js"></script>
		<script type="text/javascript" src="../js/sweat_alert.js"></script>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<style>
			.gig-category .nice-select:nth-Child(2){
				display: none;
			}
			#category{
				display: block !important;
				width: 47%;
				margin-left: 8px;
			}
		</style>
	</head>
	<body class="is-responsive">
		<!-- Preloader Start -->
    <div class="proloader">
        <div class="loader">
            <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
        </div>
    </div>
    <!-- Preloader End -->
		<?php
		require_once("../includes/buyer-header.php");
		if($seller_verification != "ok"){
		echo "
		<div class='alert alert-danger rounded-0 mt-0 text-center'>
			Please confirm your email to use this feature.
		</div>
		";
		}else{
		?>
		<!-- Main content -->
		<main>
			<section class="container-fluid postarequest">
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<h2>انشر إعلان الوظيفة بتاعتك مجانًا</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-lg-8">
								<div class="row">
									<div class="col-12 col-md-8">
										<?php 
										$form_errors = Flash::render("form_errors");
										$form_data = Flash::render("form_data");
										if(is_array($form_errors)){
										?>
										<div class="alert alert-danger"><!--- alert alert-danger Starts --->
										<ul>
											<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
											<li><?= $i ?>. <?= ucfirst($error); ?></li>
											<?php } ?>
										</ul>
										</div><!--- alert alert-danger Ends --->
										<?php } ?>
										<form action="" class="create-request" method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/create-gig-icon.png" />
													</span>
													<span>عنوان طلبك</span>
												</label>
												<input type="text" name="request_title" placeholder="طلب عنوان...." class="form-control input-lg" required="" value="<?= $form_data['request_title']; ?>">
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/create-gig-icon.png" />
													</span>
													<span>اوصف الخدمة اللي عايز تشتريها</span>
												</label>

												<textarea class="form-control" name="request_description" id="textarea" placeholder="أنا بدور على...." rows="5"><?= $form_data['request_description']; ?></textarea>
												<div class="bottom-label d-flex flex-row align-items-center justify-content-between mt-15">
													<div class="attach-file d-flex flex-row align-items-center">
														<label for="file">
															<input type="file" id="file" name="request_file" hidden="">
															<span class="file d-flex flex-row align-items-center">
																<span><img src="<?= $site_url;?>/assets/img/post-request/attach.png" alt=""></span>
																<span>أرفق ملف</span>
															</span>
														</label>
														<span class="max-size">بحد اقصي 30 ميجا</span>
													</div>
													<span class="chars-max"><span class="descCount">0</span>\2500 حرف بحد أقصى</span>
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														خلي كل الناس في مجتمع موقع منجز يعرفوا عن مشروعك. اوصف كل حاجة محتاجها بالتفصيل عشان كل ما تكون دقيق كل ما تكون الوظيفة اللي عايز الفريلانسر يعملهالك دقيقة أكتر.
													</p>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/category-icon.png" />
													</span>
													<span>اختار فئة</span>
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
														if($cat_id == 1){
															$cat_class= "gd";
															$cat_img1 = "/assets/img/post-a-gig/graphic-design-white.png";
															$cat_img2 = "/assets/img/post-a-gig/graphic-design-color.png";
														}elseif ($cat_id == 2) {
															$cat_class = "dm";
															$cat_img1 = "/assets/img/post-a-gig/digital-marketing-white.png";
															$cat_img2 = "/assets/img/post-a-gig/digital-marketing-color.png";
														}elseif ($cat_id == 3) {
															$cat_class = "wt";
															$cat_img1 = "/assets/img/post-a-gig/writing-translation-white.png";
															$cat_img2 = "/assets/img/post-a-gig/writing-translation-color.png";
														}elseif ($cat_id == 4) {
															$cat_class = "va";
															$cat_img1 = "/assets/img/post-a-gig/video-animation-white.png";
															$cat_img2 = "/assets/img/post-a-gig/video-animation-color.png";
														}elseif ($cat_id == 7) {
															$cat_class = "ma";
															$cat_img1 = "/assets/img/post-a-gig/music-audio-white.png";
															$cat_img2 = "/assets/img/post-a-gig/music-audio-color.png";
														}elseif ($cat_id == 6) {
															$cat_class = "pt";
															$cat_img1 = "/assets/img/post-a-gig/programming-tech-white.png";
															$cat_img2 = "/assets/img/post-a-gig/programming-tech-color.png";
														}elseif($cat_id == 8){
															$cat_class= "va";
															$cat_img1 = '/cat_images/p7.png';
															$cat_img2 = '/cat_images/p7.png';
														}else{
															$cat_class= "ma";
															$cat_img1 = '/cat_images/p6.png';
															$cat_img2 = '/cat_images/p6.png';
														}
													?>
													<!-- <label class="gig-category-item" for="categoryItem-<?= $cat_id; ?>"> -->
														<select class="form-control" name="cat_id" id="category" required="" style="display: none;">
															<option value="" class="hidden">  الجرافيكس والتصميم </option>
															<?php
															$get_cats = $db->select("categories");
															while($row_cats = $get_cats->fetch()){
															$cat_id = $row_cats->cat_id;
															$get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
															$row_meta = $get_meta->fetch();
															$cat_title = $row_meta->cat_title;
															$arabic_title = $row_meta->arabic_title;
															?>
															<option value="<?= $cat_id; ?>">  <?= $arabic_title; ?> </option>
															<?php } ?>
														</select>
														<div class="">
															<!-- <label></label> -->
															<select class="form-control" name="child_id" id="sub-category" required="" style="display: none;">
																
															</select>
														</div>
														<!-- <div class="backto-main flex-row">
															<a href="javascript:void(0)" class="d-flex flex-row align-items-center">
																<span>
																	<i class="fal fa-angle-left"></i>
																</span>
																<span>Go Back</span>
															</a>
														</div> -->
													<!-- </label> -->
													<?php } ?>
													<!-- Each item -->
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														حسِّن طلبك و اختار الفئة الرئيسية و الفرعية المناسبة لمشروعك. اختيرارك للفئة المناسبة هيساعد الفريلانسرز يلاقوا مشروعك.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/passage-of-time.png" />
													</span>
													<span>عايز تستلم الخدمة امتى؟</span>
												</label>
												<div class="deliver-time d-flex flex-wrap">
													<?php
														$get_delivery_times = $db->select("delivery_times");
														while($row_delivery_times = $get_delivery_times->fetch()){
														$delivery_proposal_title = $row_delivery_times->delivery_proposal_title;
														$delivery_id = $row_delivery_times->delivery_id;
													?>
													<label class="deliver-time-item" for="hours<?= $delivery_id; ?>">
														<input id="hours<?= $delivery_id; ?>" type="radio" name="delivery_time" value="<?= $delivery_proposal_title; ?>" <?php if($form_data['delivery_time'] == $delivery_proposal_title){ echo "checked"; } ?> hidden />
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
													<?php } ?>
													<label class="deliver-time-item" for="days30">
														<input id="days30" type="radio" name="delivery_time" hidden />
														<div class="deliver-time-item-content d-flex flex-column justify-content-center align-items-center">
															<span class="color-icon">
																<span>-</span>
																<span>+</span>
															</span>
															<span class="d-flex flex-row align-items-end time">
																<span>مخصص</span>
																<input autofocus="autofocus" class="input-number" type="text" name="delivery_time" pattern="[0-9]" />
															</span>
														</div>
													</label>
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														ميعاد التسليم اللي انت محتاج مشروعك يخلص فيه. دة هيديك انت و الفريلانسر ميعاد تسليم دقيق تشتغلوا على أساسه. من الأمور المتاحة هو طلب التسليم السريع للمشاريع اللي بتحتاج تتسلم في وقت أسرع.
													</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-request/icon-4.png" />
													</span>
													<span>ايه هي المهارات المطلوبة ؟</span>
												</label>
												<div class="postarequest-tags">
													<input type="text" name="skills_required" data-role="tagsinput" value="HTML,PHP,Website Design,Graphic Design">
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>حط كل المهارات اللى ليها علاقة بشغلك علشان تخلص ، كل ما كنت دقيق ومحدد كل ما زادت فرصتك فى انك تجذب الموهبة المناسبة لشغلك</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-request/icon-5.png" />
													</span>
													<span>اللغات</span>
												</label>
												<div class="postarequest-tags">
													<input type="text" name="languages" data-role="tagsinput" value="English, German">
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="<?= $site_url;?>/assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>حط كل متطلبات اللغة المطلوبة علشان الشغل يخلص. لما تبقا شفاف بخصوص اللغة الاحترافية المطلوبة دة بيسمح لشغلك انه يخلص بنجاح</p>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label d-flex flex-row align-items-center">
													<span>
														<img alt="" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/price-icon.png" />
													</span>
													<span>ايه هي ميزانيتك ؟</span>
												</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<select class="form-control">
															<option value="1">USD</option>
															<option value="2">GBP</option>
														</select>
													</div>
													<input class="form-control" type="number" name="request_budget" value="<?= $form_data['request_budget']; ?>" />
												</div>
												<div class="popup">
													<img alt="" class="lamp-icon" src="assets/img/post-a-gig/lamp-icon.png" />
													<img alt="Ask our Community" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/ask-our-community.png" width="100%" />
													<p>
														تحديد ميزانية كويسة للمشروع بتاعك هيسمح للفريلانسرز يشوفوا انت ناوي تصرف قد ايه عالمشروع و دة بيدعم الخبرة سواء للمشتري أو مقدم الخدمة
													</p>
												</div>
											</div>
											<div class="form-group mb-0">
												<button class="button" role="button" type="submit" name="submit">انشر</button>
											</div>
										</form>
									</div>
									<div class="col-12 col-md-4" id="popupWidth"></div>
								</div>
							</div>
							<div class="col-12 col-lg-4">
								<div class="howitwork-card">
									<div class="howitwork-card-title d-flex align-items-center">ازاي بيشتغل</div>
									<div class="howitwork-list d-flex flex-column">
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Post a gig" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/find.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>1. استكشف</h3>
												<p> شارك مشروعك دلوقتي على منصتنا عشان تقدر تتواصل مع المحترفين من الموظفين المستقلين اللي مستعدين يقدموا حاجات رائعة ليك.</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Get Hired" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/gethired.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>2. التوظيف</h3>
												<p> راجع اعتمادات عشرات الفريلانسرز عشان تقدر تحدد الشخص المناسب اللي عنده المؤهلات المطلوبة لمشروعك</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Work" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/work.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>3. الشغل</h3>
												<p>اتواصل و حدد الأساس عشان تحقق التعاون الناجح، شارك أفكارك، طور الخطوط العريضة، ابعت ملفات، و كمان تقدر تدير المشروع بالكامل من خلال منصتنا سهلة الاستخدام</p>
											</div>
										</div>
										<!-- How it work each item -->
										<div class="howitwork-list-item d-flex flex-row align-items-start">
											<div class="howitwork-list-icon">
												<img alt="Get Paid" class="img-fluid d-block" src="<?= $site_url;?>/assets/img/post-a-gig/getpaid.png" />
											</div>
											<div class="howitwork-list-content">
												<h3>4. الدفع</h3>
												<p>بمجرد إنك تلاقي الموظف المثالي لمشروعك، عليك إنك تبعت المبلغ المطلوب من خلال بوابتنا الآمنة للدفع و تستمتع براحة البال لأن معاك ضمان باستعادة أموالك كاملة 100%</p>
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
		</main>
		<!-- Main content end -->
<?php } ?>
<script>
        $(function(){
            $(window).on('load resize', function(){
                var popupWidth = $('#popupWidth').outerWidth();
                $('.popup').css({
                    'width': popupWidth + 30 + 'px'
                });
            });
            $('.gig-category-select').on('click', function(){
                $('.gig-category-item').addClass('item-removed');
                $(this).parents('.gig-category-item').removeClass('item-removed');
                $(this).parents('.gig-category-item').addClass('item-active');
            });
            $('.gig-category-tag').on('click', function(){
                $(this).toggleClass('tag-selected');
            });
            $('.backto-main').on('click', function(){
                $('.gig-category-item').removeClass('item-active');
                $('.gig-category-item').removeClass('item-removed');
                $('.gig-category-tag').removeClass('tag-selected');
                $('.gig-category-item').find('input[type="radio"]').prop('checked', false);
            });
            $('.deliver-time-item[for="days30"]').on('click', function(){
                $('.input-number').focus();
            });
        });
    </script>
<script>
$(document).ready(function(){
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");

	$('.container-fluid').hover(function(){
	$('.h-1').css("visibility", "visible");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-1').mouseover(function(){
	$('.h-1').css("visibility", "visible");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-2').mouseover(function(){
	$('.h-1').css("visibility", "hidden");
	$('.h-2').css("visibility", "visible");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-3').mouseover(function(){
	$('.h-1').css("visibility", "hidden");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "visible");
	$('.h-4').css("visibility", "hidden");
	});

	$('.row-4').mouseover(function(){
	$('.h-1').css("visibility", "hidden");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "visible");
	});

	$('.row-2,.row-3,.row-4').mouseout(function(){
	$('.h-1').css("visibility", "visible");
	$('.h-2').css("visibility", "hidden");
	$('.h-3').css("visibility", "hidden");
	$('.h-4').css("visibility", "hidden");
	});

	$("#textarea").keydown(function(){
	var textarea = $("#textarea").val();
	$(".descCount").text(textarea.length);	
	});	

	// $("#sub-category").hide();
	$(".gig-category-tags  .nice-select.form-control").remove();

	
	$("#sub-category").hide();

	$("#category").change(function(){
		$("#sub-category").show();	
		var category_id = $(this).val();
		$.ajax({
		url:"fetch_subcategory",
		method:"POST",
		data:{category_id:category_id},
		success:function(data){
		$("#sub-category").html(data);
		}
		});
	});

});
// function categoryItem(id){
// 	$("#sub-category").show();	
// 	var category_id = id;
// 	$.ajax({
// 	url:"fetch_subcategory",
// 	method:"POST",
// 	data:{category_id:category_id},

// 	success:function(data){
// 		console.log(data);
// 	$("#sub-category").html(data);
// 	}
// 	});
// }

</script>
<?php
if(isset($_POST['submit'])){
	$rules = array(
	"request_title" => "required",
	"request_description" => "required",
	"cat_id" => "required",
	"request_budget" => "number|required");
	$messages = array("cat_id" => "you need to select a category","child_id" => "you need to select a child category");
	$val = new Validator($_POST,$rules,$messages);
	if($val->run() == false){
		Flash::add("form_errors",$val->get_all_errors());
		Flash::add("form_data",$_POST);
		echo "<script> window.open('post-request','_self');</script>";
	}else{
		$request_title = $input->post('request_title');
		$request_description = $input->post('request_description');
		$cat_id = $input->post('cat_id');
		$child_id = $input->post('child_id');
		$request_budget = $input->post('request_budget');
		$delivery_time = $input->post('delivery_time');

		echo "You have selected :" .$delivery_time;
		$skills_required = $input->post('skills_required');
		$languages = $input->post('languages');
		$request_file = $_FILES['request_file']['name'];
		$request_file_tmp = $_FILES['request_file']['tmp_name'];
		$request_date = date("F d, Y");
		$allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','pdf','docx','txt');
		$file_extension = pathinfo($request_file, PATHINFO_EXTENSION);
		if(!empty($request_file)){
			if(!in_array($file_extension,$allowed)){
				echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
				echo "<script>window.open('post-request','_self')</script>";
				exit();
			}
			$request_file = pathinfo($request_file, PATHINFO_FILENAME);
			$request_file = $request_file."_".time().".$file_extension";
			move_uploaded_file($request_file_tmp,"request_files/$request_file");
		}
		$insert_request = $db->insert("buyer_requests",array("seller_id"=>$login_seller_id,"cat_id"=>$cat_id,"child_id"=>$child_id,"request_title"=>$request_title,"request_description"=>$request_description,"request_file"=>$request_file,"delivery_time"=>$delivery_time,"skills_required"=>$skills_required,"languages"=>$languages,"request_budget"=>$request_budget,"request_date"=>$request_date,"request_status"=>'pending'));
		if($insert_request){
			echo "<script>
			    swal({
			      type: 'success',
			      text: 'Your request has been submitted successfully!',
			      timer: 3000,
			      onOpen: function(){
			      	swal.showLoading()
			      }
			    }).then(function(){
			      	window.open('manage_requests.php','_self');
			    });
			</script>";
		}
	}
}
?>
<?php require_once("../includes/footer.php"); ?>
<?php require_once("../includes/footerJs.php"); ?>

</body>
</html>