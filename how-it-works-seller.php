<?php
  session_start();
  require_once("includes/db.php");
  require_once("social-config.php");
  if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";
  }
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
    <!-- <link href="<?= $site_url; ?>/styles/styles.css" rel="stylesheet"> -->
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
        <div class="row">
          <div class="col-lg-12">
            <div class="how-it-work-banner-content d-flex flex-column justify-content-center align-items-center">
              <h3 class="how-title">How It Works</h3>
              <div class="d-flex flex-row justify-content-between">
                <a href="<?= $site_url; ?>/proposals/create_proposal" class="how-btn">Post a Gig</a>
              </div>
            </div>
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
                  <a class="nav-link" href="#client" id="client-tab" data-toggle="tab" role="tab" aria-controls="client" aria-selected="true">
                    <span>
                      <img src="assets/img/how-it-work/client-white.png" alt="">
                      <img src="assets/img/how-it-work/client-red.png" alt="">
                    </span>
                    <span>Client</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="#freelancer" id="freelancer-tab" data-toggle="tab" role="tab" aria-controls="freelancer" aria-selected="false">
                    <span>
                      <img src="assets/img/how-it-work/freelancer-white.png" alt="">
                      <img src="assets/img/how-it-work/freelancer-red.png" alt="">
                    </span>
                    <span>Freelancer</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="tab-content" id="howitworkTabContent">
          <div class="tab-pane fade" id="client" role="tabpanel" aria-labelledby="client-tab">
            <div class="row">
              <div class="col-lg-3">
                <div class="how-it-work-category mt-50">
                  <ul class="nav howitwork-cat-menu d-flex flex-column" id="clientTab">
                    <li class="nav-item howitwork-cat-item">
                      <a class="nav-link howitwork-cat-link active" href="#client_find">Find</a>
                    </li>
                    <li class="nav-item howitwork-cat-item">
                      <a class="nav-link howitwork-cat-link" href="#client_hire">Hire</a>
                    </li>
                    <li class="nav-item howitwork-cat-item">
                      <a class="nav-link howitwork-cat-link" href="#client_work">Work</a>
                    </li>
                    <li class="nav-item howitwork-cat-item">
                      <a class="nav-link howitwork-cat-link" href="#client_pay">Pay</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-9">
                <div class="how-it-work-wrapper-content">
                  <div class="row align-items-center" id="client_find">
                    <div class="col-md-6">
                      <div class="how-it-content mt-50">
                        <h3 class="how-it-title">Easily find quality freelancers</h3>
                        <ul>
                          <li>eMongez has a diversified range of expert freelancers ready to take on your project. Find everyone from programmers, designers, writers, to customer support reps, and much more.</li>
                          <li>Whichever professional freelance services you are looking for, it can be found on eMongez.</li>
                          <li>In today’s world, finding qualified, expert service providers can be a hassle. eMongez makes it easy to find and reach out to the perfect seller for your project. No longer will you have to settle for inadequate agencies that over promise and under deliver.</li>
                          <li>With eMongez, you can verify the credentials, previous work, and client testimonies of each seller using the eMongez platform.</li>
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
                        <h3 class="how-it-title">Hire the best freelancer</h3>
                        <ul>
                          <li>With eMongez, you have the tools necessary to review your favorite candidates, see their previous reviews, work portfolios, and much more.</li>
                          <li>Search through proposals and select the best freelancers for your project. Hiring on eMongez gives you the power to leverage an endless supply of freelancers competing for your project.</li>
                          <li>As they say, competition brings out the best. Taking the time to carefully browse through our variety of sellers will allow you to see the very best that the freelancing community has to offer.</li>
                          <li>With eMongez, your dream creation is only a click away.</li>
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
                        <h3 class="how-it-title">Work efficiently, effectively</h3>
                        <ul>
                          <li>eMongez gives you the power to run your business efficiently. Enjoy an easy to use platform that allows you to send and receive files, share feedback, request revisions, and communicate with ease.</li>
                          <li>Our incredible platform guarantees that sellers only promote the services that they are competent in.</li>
                          <li>If you are not satisfied with the quality of your work, simply request a revision. Buyers are in complete control and only have to accept work that represents their requirements exactly.</li>
                          <li>eMongez prides itself on maintaining a high level of standards that ensure buyers only receive a high level of professional-grade work.</li>
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
                        <h3 class="how-it-title">Pay easily, with peace of mind</h3>
                        <p class="text">
                          <ul>
                            <li>Enjoy peace of mind with a 100% secure payment portal that protects your personal information at all times.</li>
                            <li>Enjoy flexible payment options with your freelancer. Pay by the hour or at a fixed price for the entire project. The choice is yours. Never feel as if your private information is compromised at any moment.</li>
                            <li>Your payment details will never be shared with any seller, and they only receive the payment once you have reviewed and approved your order.</li>
                            <li>The best part is that eMongez manages the transfer of funds from buyer to seller. This ensures that freelancers are motivated to go above and beyond for buyers.</li>
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
            <div class="tab-pane fade show active" id="freelancer" role="tabpanel" aria-labelledby="freelancer-tab">
              <div class="row">
                <div class="col-lg-3">
                  <div class="how-it-work-category mt-50">
                    <ul class="nav howitwork-cat-menu d-flex flex-column" id="freelancerTab">
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link active" href="#freelancer_find">Find</a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#freelancer_hire">Get Hired</a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#freelancer_work">Work</a>
                      </li>
                      <li class="nav-item howitwork-cat-item">
                        <a class="nav-link howitwork-cat-link" href="#freelancer_pay">Get Paid</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="how-it-work-wrapper-content">
                    <div class="row align-items-center" id="freelancer_find">
                      <div class="col-md-6">
                        <div class="how-it-content mt-50">
                          <h3 class="how-it-title">Find jobs that are geared towards you</h3>
                          <ul>
                            <li>Discover meaningful projects that bring you joy and income at the same time. Our platform is full of buyers searching for everything under the sun.</li>
                            <li>Don’t miss out on your opportunity to win your ideal projects. We know that you have a set of skills that are in demand.</li>
                            <li>Are you a graphic designer, writer, programmer, or something more? Find jobs that are geared towards your exact set of skills on eMongez.</li>
                            <li>We want to provide a safe place where buyers and sellers can come together and create projects that change the world.</li>
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
                          <h3 class="how-it-title">Get Hired</h3>
                          <ul>
                            <li>eMongez makes it incredibly simple to find quality clients that need your services. Our platform is dedicated to making sure that the best sellers are matched with the appropriate buyer.</li>
                            <li>Deliver quality work for your clients to guarantee that you receive repeat business coming back again and again. The faster you deliver, the more jobs you will receive.</li>
                            <li>As you complete more projects, clients will be able to see the previous ratings from your past jobs. Sellers with the highest number of positive reviews are in the highest demand.</li>
                            <li>So, deliver your best quality work to ensure your clients leave you great feedback.</li>
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
                          <h3 class="how-it-title">Work efficiently, effectively</h3>
                          <ul>
                            <li>Once you start working, it helps to stay in constant communication with your buyer. Stay in close contact on the eMongez platform and guarantee your clients stay 100% satisfied at all times.</li>
                            <li>Utilize our mobile platform to remain connected to your clients from anywhere in the world. As your delivery deadline gets closer, your clients will be getting anxious to receive their delivery.</li>
                            <li>Send a quick message letting them know you are working diligently to ease their waiting period. We know you are good at what you do.</li>
                            <li>Let your clients see that by always giving quality attention to each buyer.</li>
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
                          <h3 class="how-it-title">Get paid from client</h3>
                          <ul>
                            <li>As the seller, eMongez guarantees that your clients will pay you in a secure and timely manner. Never feel worried about receiving your payment.</li>
                            <li>Maintain complete track of your upcoming and past invoices all through the intuitive application.</li>
                            <li>eMongez will always provide you with all the reporting tools and data you need to keep track of your earnings, and future payouts. We want you to take your freelancing career to the next level.</li>
                            <li>With eMongez, you will be able to hone in on your talents and truly excel. Sign up today to get started earning real cash fast.</li>
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