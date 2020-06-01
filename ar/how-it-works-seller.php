<?php
  session_start();
  require_once("includes/db.php");
  require_once("social-config.php");

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
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title> <?php echo $site_name; ?> - <?php echo $lang['titles']['how_it_works']; ?> </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">
    <!-- ==============Google Fonts============= -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <!--====== Bootstrap css ======-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!--====== PreLoader css ======-->
    <link href="assets/css/preloader.css" rel="stylesheet">
    <!--====== Animate css ======-->
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <!--====== Fontawesome css ======-->
    <link href="assets/css/fontawesome.min.css" rel="stylesheet">
    <!--====== Owl carousel css ======-->
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet">
    <!--====== Nice select css ======-->
    <link href="assets/css/nice-select.css" rel="stylesheet">
    <!--====== Default css ======-->
    <link href="assets/css/default.css" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="assets/css/style.css" rel="stylesheet">
    <!--====== Responsive css ======-->
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link href="styles/animate.css" rel="stylesheet">
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>.swal2-popup .swal2-styled.swal2-confirm{background-color: #28a745;}.swal2-popup .swal2-select{display: none;}</style>
  </head>
  <body class="all-content" data-spy="scroll" data-target=".howitwork-cat-menu" data-offset="110">
    <!-- Preloader Start -->
      <div class="proloader">
        <div class="loader">
          <img src="assets/img/emongez_cube.png" />
        </div>
      </div>
      <!-- Preloader End -->
    <!-- Header -->
    <?php require('includes/user_header.php'); ?>
    
      <!-- How it work banner Start-->
      <div class="how-it-work-banner">
        <div class="container">
          <div class="how-it-work-banner-content d-flex flex-column justify-content-center align-items-center">
            <h3 class="how-title">
            ازاي بيشتغل
            </h3>
            <div class="d-flex flex-row justify-content-between">
              <a href="<?= $site_url; ?>/ar/proposals/create_proposal" class="how-btn">
                أنشر خدمة
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- How it work banner end -->
      <!-- how it work content Start-->
      <div class="how-it-work-area pt-80 pb-100">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="how-it-work-menu pb-20">
                <ul class="nav nav-tabs" id="how_it_work_menu" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#client" id="client-tab" data-toggle="tab" role="tab" aria-controls="client" aria-selected="true">
                      <span>
                        <img src="assets/img/how-it-work/client-white.png" alt="">
                        <img src="assets/img/how-it-work/client-red.png" alt="">
                      </span>
                      <span>
                        العميل
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#freelancer" id="freelancer-tab" data-toggle="tab" role="tab" aria-controls="freelancer" aria-selected="false">
                      <span>
                        <img src="assets/img/how-it-work/freelancer-white.png" alt="">
                        <img src="assets/img/how-it-work/freelancer-red.png" alt="">
                      </span>
                      <span>
                        الفريلانسر
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="tab-content" id="howitworkTabContent">
            <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="client-tab">
              <div class="row">
                <div class="col-lg-3">
                  <div class="how-it-work-category mt-50">
                    <ul class="nav howitwork-cat-menu d-flex flex-column" id="clientTab">
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link active" href="#client_find">
                          استكشف
                        </a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#client_hire">
                          التوظيف
                        </a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#client_work">
                          الشغل
                        </a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#client_pay">
                          الدفع
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="how-it-work-wrapper-content">
                    <div class="row align-items-center" id="client_find">
                      <div class="col-md-6">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          دور بسهولة على فريلانسرز بجودة عالية
                          </h3>
                          <ul>
                            <li>
                              eMongez فيه مجموعة مختلفة من الفريلانسرز الجاهزين انهم يشتغلوا ويمسكوا مشروعك. هتلاقى بسهولة كل الناس من المبرمجين، المصممين، الكُتاب وأكتر بكتير
                            </li>
                            <li>
                              مهما كان الخدمة الاحترافية اللى بتدور عليها، هتلاقيها على eMongez
                            </li>
                            <li>
                              فى عالم النهاردة، انك تلاقى مزودى خدمة خبراء ومؤهلين حاجة متعبة. eMongez بيسهل البحث والوصول للبايع المثالى لمشروعك. مش مضطر بعد دلوقتى تقبل بالوكالات اللى مش مؤهلة وبتوعد أكتر من اللازم وبتوصل أقل من اللازم
                            </li>
                            <li>
                              مع eMongez، ممكن توثق أوراق اعتمادك، أعمالك السابقة، وشهادات العملء لكل بايع بيستخدم منصة eMongez
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-1.png" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center" id="client_hire">
                      <div class="col-md-6 order-md-last">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          عين أحسن فريلانسر
                          </h3>
                          <ul>
                            <li>
                              مع eMongez، معاك الأدوات اللازمة علشان تراجع المرشحين المفضلين، تشوف مراجعاتهم اللى قبل كدة، بروتوفوليو الشغل، وأكتر بكتير.
                            </li>
                            <li>
                              اتفرج على العروض المتقدمة واختار أحسن فريلانسرز لمشروعك. التعيين على eMongez بيديك قوة الاستفادة من العرض اللى مبينتهيش من الفريلانسرز اللى بيتنافسوا على مشروعك
                            </li>
                            <li>
                              زى ما بيقولوا، المنافسة بتطلع الأحسن. خد وقتك علشان تتصفح بعناية بين البايعين المختلفين علشان تشوف الأحسن اللى مجتمع الأعمال الحرة قادر يعرضه
                            </li>
                            <li>
                              مع eMongez، صنع حلمك على بعد خطوة بس
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6 order-md-first">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-2.png" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center" id="client_work">
                      <div class="col-md-6">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          اشتغل بكفاءة وفاعلية
                          </h3>
                          <ul>
                            <li>
                              eMongez بيديك القوة انك تشغل تجارتك بكفاءة. استمتع بالمنصة سهلة الاستخدام اللى بتسمحلك انك تبعت وتستقبل ملفات، تشارك الفيدباك، تطلب مراجعات وتتواصل بسهولة
                            </li>
                            <li>
                              منصتنا الرائعة بتضمن ان البائعيين بيروجوا بس للخدمات اللى هما مختصين فيها
                            </li>
                            <li>
                              لو مش راضي عن جودة الشغل، ببساطة اطلب مراجعة. المشترين عندهم تحكم كامل وعليهم بس يقبلوا الشغل اللى بيمثل متطلباتهم بالظبط
                            </li>
                            <li>
                              eMongez فخور بنفسه لمحافظته على مستوى عالى من المعايير اللى بتضمن ان المشترين يلاقوا بس مستوى عالي من العمل الاحترافى
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-3.png" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center" id="client_pay">
                      <div class="col-md-6 order-md-last">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          دفع بسهولة، وريح بالك
                          </h3>
                          <ul>
                            <li>
                              استمتع براحة بالك ببوابة دفع آمنة 100% بتحمى معلوماتك الشخصية طول الوقت
                            </li>
                            <li>
                              استمتع بطرق دفع مرنة مع الفريلانسر اللى بيشتغل معاك. ادفع بالساعة أو سعر ثابت للمشروع كله. الاختيار ليك. واوعى تحس ان معلوماتك الشخصية مُخترقة فى أى وقت
                            </li>
                            <li>
                              تفاصيل دفعك عمر ما هيتم مشاركتها مع مع أى بايع، وبيوصلهم بس المبلغ المدفوع بمجرد مراجعتك وموافقتك على الأوردر (الطلب)
                            </li>
                            <li>
                              أحسن جزئية ان eMongez بيدير نقل الفلوس من المشترى للبايع. دة بيضمن ان الفريلانسرز عندهم حماس انهم يعملوا كل اللى يقدروا عليه للمشترى.
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6 order-md-first">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- How it work content -->
                </div>
              </div>
              <!-- Row -->
            </div>
            <div class="tab-pane fade" id="freelancer" role="tabpanel" aria-labelledby="freelancer-tab">
              <div class="row">
                <div class="col-lg-3">
                  <div class="how-it-work-category mt-50">
                    <ul class="nav howitwork-cat-menu d-flex flex-column" id="freelancerTab">
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link active" href="#freelancer_find">
                          استكشف
                        </a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#freelancer_hire">
                          التوظيف
                        </a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#freelancer_work">
                          الشغل
                        </a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#freelancer_pay">
                          الدفع
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="how-it-work-wrapper-content">
                    <div class="row align-items-center" id="freelancer_find">
                      <div class="col-md-6">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          هتلاقى الوظايف اللى متوجهة علشانك
                          </h3>
                          <ul>
                            <li>
                              اكتشف مشاريع ليها هدف تدخلك الفرح والفلوس فى نفس الوقت. منصتنا كلها مشترين بيدوروا على كل حاجة موجودة تحت الشمس
                            </li>
                            <li>
                              متفوتش فرصتك فى انك تكسب مشاريعك المثالية. احنا عارفين ان عندك مجموعة مهارات مطلوبة
                            </li>
                            <li>
                              انت مصمم جرافيك، كاتب، مبرمج، أو أى حاجة تانية؟ دور على الوظايف اللى متوجهة لمجموعة مهاراتك بالتحديد على eMongez
                            </li>
                            <li>
                              احنا عايزين نوفر مكان آمن يقدر يتجمع فيه المشترين والبائعين ويعملوا مشاريع تغير العالم
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-1.png" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center" id="freelancer_hire">
                      <div class="col-md-6 order-md-last">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          الحصول على التعاقد
                          </h3>
                          <ul>
                            <li>
                              eMongez بيخلى الموضوع بسيط جدًا انك تلاقى عملاء محتاجين خدمتك. منصتنا مخصصة انها تضمن ان أحسن البائعين يلاقوا المشترى المناسب
                            </li>
                            <li>
                              سلم لعملائك شغل بجودة عالية علشان تضمن ان نفس التجارة تجيلك تانى. كلما زادت سرعة تسليمك، كلما زادت الوظايف اللى بتجيلك
                            </li>
                            <li>
                              كل ما بتخلص مشاريع أكتر، بيقدر العملا يشوفوا التقييمات السابقة من أعمالك اللى قبل كدة. البائعين اللى عندهم أعلى عدد تقييمات إيجابى هما أكتر ناس بيتطلبوا
                            </li>
                            <li>
                              علشان كدة، وصل شغل بأحسن جودة علشان تضمن ان العملا يسيبولك فيدباك كويس
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6 order-md-first">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-2.png" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center" id="freelancer_work">
                      <div class="col-md-6">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          اشتغل بكفاءة وفعالية
                          </h3>
                          <ul>
                            <li>
                              جرد ما تبدأ شغل، هيساعدك انك تفضل فى تواصل دايم مع المشترى. خليك فى تواصل قريب على منصة eMongez واضمن ان عملائك يفضلوا راضيين بنسبة 100% طول الوقت
                            </li>
                            <li>
                              استغل منصتنا للموبايل بأحسن شكل علشان تفضل فى تواصل مع عملائك من أى مكان فى العالم. كل ما ميعاد تسليمك بيقرب، عملائك هيكونوا مستنيين بتوتر الشغل اللى هتسلمهلهم
                            </li>
                            <li>
                              ابعت رسالة سريعة تعرفهم فيها انك بتشتغل بجد علشان تقلل فترة انتظارهم. احنا عارفين انك شاطر فى اللى بتعمله
                            </li>
                            <li>
                              خلى عملائك يعرفوا دة عن طريق انك تدى اهتمام مميز لكل مشترى
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-3.png" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center" id="freelancer_pay">
                      <div class="col-md-6 order-md-last">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">
                          الحصول على أموال من العميل
                          </h3>
                          <ul>
                            <li>
                              كبايع، eMongez بيضمن ان عملائك هيدفعولك بطريقة آمنة وفى الوقت المظبوط. عمرك ما تقلق عن استلامك لفلوسك
                            </li>
                            <li>
                              حافظ على سجل كامل بالفواتير اللى جاية والفواتير القديمة من خلال التطبيق البديهى
                            </li>
                            <li>
                              eMongez  بيوفرلك دايما كل أدوات وبيانات التبليغ اللى محتاجها علشان تتابع مكاسبك، والمدفوعات المستقبلية. احنا عايزينك تاخد حياتك المهنية فى الفريلانسينج (الأعمال الحرة) للمستوى اللى جاى
                            </li>
                            <li>
                              مع eMongez، هتقدر تستفيد من مواهبكوتتفوق فعلا. اشترك النهاردة علشان تبدأ تكسب فلوس حقيقية بسرعة
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-md-6 order-md-first">
                        <div class="how-it-image mt-50">
                          <img src="assets/img/how-it-work/how-4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- How it work content -->
                </div>
              </div>
              <!-- Row -->
            </div>
          </div>
        </div>
      </div>
      <!-- how it work content end -->
    <?php require_once("includes/footer.php"); ?>
  </body>
</html>