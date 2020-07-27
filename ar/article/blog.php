<?php
  
  session_start();
  require_once("../includes/db.php");
  
  $article_url = $input->get('article_url');
  
  // print($article_url);
  // print_r($id);
  $get_articles = $db->select("knowledge_bank",array("article_url"=>$article_url));
  $row_articles = $get_articles->fetch();
  $article_id = $row_articles->article_id;
  $article_heading = $row_articles->article_heading;
  $article_body = $row_articles->article_body;
  $right_image = $row_articles->right_image;
  $top_image = $row_articles->top_image;
  $bottom_image = $row_articles->bottom_image;
  if($lang_dir == "right"){
    $floatRight = "float-right";
  }else{
    $floatRight = "float-left";
  }

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
  <head>
    <title> <?php echo $site_name; ?> - <?php echo $article_heading; ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <!-- <link href="../styles/bootstrap.css" rel="stylesheet"> -->
    <!-- <link href="../styles/custom.css" rel="stylesheet"> -->
    <!-- Custom css code from modified in admin panel --->
    <!--====== Favicon Icon ======-->
    <?php if(!empty($site_favicon)){ ?>
      <link rel="shortcut icon" href="<?= $site_url; ?>/images/<?= $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
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
    <!--====== Nice select css ======-->
    <link href="<?= $site_url; ?>/ar/assets/css/tagsinput.css" rel="stylesheet">
    <!--====== Range Slider css ======-->
    <link href="<?= $site_url; ?>/ar/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
    <!--====== Default css ======-->
    <link href="<?= $site_url; ?>/ar/assets/css/default.css" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="<?= $site_url; ?>/ar/assets/css/style.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/ar/assets/css/style1.css" rel="stylesheet">
    <!--====== Responsive css ======-->
    <link href="<?= $site_url; ?>/ar/assets/css/responsive.css" rel="stylesheet">
    <!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
    <!-- <link href="styles/custom.css" rel="stylesheet">  -->
    <!-- Custom css code from modified in admin panel --->
    <link href="<?= $site_url; ?>/ar/styles/styles.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/ar/styles/user_nav_styles.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/ar/font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/ar/styles/owl.carousel.css" rel="stylesheet">
    <link href="<?= $site_url; ?>/ar/styles/owl.theme.default.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $site_url; ?>/js/jquery.min.js"></script>
    <style>
      .form-control{
      width: 200px;
      }
      .blog-feature-image{height: 420px;overflow: hidden;}
      .blog-recent-posts-item .image{height: 80px; overflow: hidden;}
      @media(max-width: 768px){.blog-feature-image{height: 187px;overflow: hidden;}}
      <?php if ($lang_dir == "right") { ?>
    /*  .rtlClass{
        float: right;
      }
      .rtlClass p,span{
        float: right;
      }*/
      <?php } ?>
    </style>
  </head>
  <body class="all-content">
    <?php
      if(!isset($_SESSION['seller_user_name'])){
        require_once("../includes/header_with_categories.php");
      }else{
        if($login_seller_type == 'buyer'){
          require_once("../includes/buyer-header.php");
        }else{
          require_once("../includes/user_header.php");
        }
      } 
    ?>

    <!-- Preloader Start -->
    <div class="proloader">
      <div class="loader">
        <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
      </div>
    </div>
    <!-- Preloader End -->
    <!-- <div class="header" 
      style="<?php if(!empty($top_image)){ ?>background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(article_images/<?php echo $top_image; ?>);<?php } ?>"
      >
      <div class="container">
        <a class="navbar-brand logo text-success " href="<?php echo $site_url; ?>/index">
        <?php if($site_logo_type == "image"){ ?>
        <img src="<?php echo $site_url; ?>/images/<?php echo $site_logo_image; ?>" width="150" style="margin-top:8%;">
        <?php }else{ ?>
        <?php echo $site_logo_text; ?>
        <?php } ?>
        </a>
        <div class="text-center">
          <h2 class="text-white mt-5">KNOWLEDGE BANK FOR <?php echo strtoupper($site_name);?></h2>
          <h4 class="text-white">Everything you need to know</h4>
        </div>
        <div class="text-center reduceForm">
          <form action="" method="post">
            <div class="input-group space50">
              <input type="text" name="search_query" class="form-control" value=""  placeholder="Search Questions">
              <div class="input-group-append move-icon-up" style="cursor:pointer;">
                <button name="search_article" type="submit" class="search_button">
                <img src="../images/srch2.png" class="srch2">
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div> -->
    <?php
      if(isset($_POST['search_article'])){
      $search_query = $input->post('search_query');
      echo "<script>window.open('$site_url/search_articles?search=$search_query','_self')</script>";
      }
      ?>

    <main class="emongez-content-main">     
      <section class="container-fluid blog-single">
        <div class="row">
          <div class="container">
            <div class="row">
              <div class="col-12 col-md-8">
                <div class="blog-feature-image">
                  <img alt="Create a compelling graphic design portfolio that lands work" class="img-fluid d-block" src="<?= $site_url ?>/article/article_images/<?= $top_image ?>" />
                </div>
                <!-- Feature image -->
                <div class="blog-single-author-social d-flex flex-wrap align-items-center justify-content-between">
                  <div class="blog-signle-author d-flex flex-wrap align-items-center">
                    <div class="blog-signle-author-item d-flex flex-row">
                      <span><i class="fal fa-user"></i></span>
                      <span>بقلم   Admin</span>
                    </div>
                    <!-- Each item -->
                    <div class="blog-signle-author-item d-flex flex-row">
                      <span><i class="fal fa-folder"></i></span>
                      <span><?= $cat_title; ?></span>
                    </div>
                    <!-- Each item -->
                    <div class="blog-signle-author-item d-flex flex-row">
                      <span><i class="fal fa-clock"></i></span>
                      <span><?= $posted_date; ?></span>
                    </div>
                    <!-- Each item -->
                  </div>
                  <div class="blog-signle-social d-none flex-wrap align-items-center" style="display: none;">
                    <a class="blog-signle-social-item facebook" href="javascript:void(0);">
                      <i class="fab fa-facebook-f"></i>
                      <span class="counter">02</span>
                    </a>
                    <!-- Each item -->
                    <a class="blog-signle-social-item twitter" href="javascript:void(0);">
                      <i class="fab fa-twitter"></i>
                      <span class="counter">53</span>
                    </a>
                    <!-- Each item -->
                    <a class="blog-signle-social-item youtube" href="javascript:void(0);">
                      <i class="fab fa-youtube"></i>
                      <span class="counter">75</span>
                    </a>
                    <!-- Each item -->
                    <a class="blog-signle-social-item instagram" href="javascript:void(0);">
                      <i class="fab fa-instagram"></i>
                      <span class="counter">25</span>
                    </a>
                    <!-- Each item -->
                    <a class="blog-signle-social-item email" href="javascript:void(0);">
                      <i class="fal fa-envelope"></i>
                      <span class="counter">16</span>
                    </a>
                    <!-- Each item -->
                  </div>
                </div>
                <!-- Blog author social -->
                <div class="blog-single-description">
                  <h1><?= $article_heading ?></h1>
                  <p><?= $article_body ?></p>
                  <?php if(!empty($right_image)){  ?>
                  <img alt="" class="img-fluid d-block" src="<?= $site_url ?>/article/article_images/<?= $right_image ?>" style="height: 368px;width: 420px" />
                  <?php } ?>
                  <?php if(!empty($bottom_image)){ ?>
                  <img alt="" class="img-fluid d-block" src="<?= $site_url ?>/article/article_images/<?= $bottom_image ?>" style="height: 368px;width: 420px" />
                  <?php } ?>
                </div>
                <!-- Blog description -->
                <!-- <div class="blog-signle-comments">
                  <h2>Blog comments plugin will apply here</h2>
                </div> -->
                <!-- Blog comments -->
              </div>
              <!-- Column 1 -->
              <div class="col-12 col-md-4">
                <div class="blog-categories d-flex flex-column">
                  <div class="blog-categories-header">التصنيفات</div>
                  <div class="blog-categories-lists d-flex flex-column">
                    <?php
                      $get_cats = $db->select("article_cat",array("language_id" => 2));
                      while($row_cats = $get_cats->fetch()){
                      $article_cat_id = $row_cats->article_cat_id;
                      $article_cat_title = $row_cats->article_cat_title;

                       $count_categories = $db->select("knowledge_bank", array("cat_id" => $article_cat_id));
                       $count_article = $count_categories->rowCount();
                    ?>
                    <a class="blog-categories-item" href="article/blogs?cat_id=<?= $article_cat_id; ?>"><?php echo $article_cat_title; ?> (<?= $count_article ?>)</a>
                    <?php } ?>
                  </div>
                </div>
                <div class="blog-recent-posts d-flex flex-column">
                  <div class="blog-recent-posts-header">المنشور الاخير</div>
                  <div class="blog-recent-posts-body d-flex flex-column">
                    <?php 
                      $get_articles = $db->query("select * from knowledge_bank where language_id=2 order by 1 DESC LIMIT 0,3");
                      // $get_articles = $db->select("knowledge_bank", array("language_id" => 1));
                      while($row_articles = $get_articles->fetch()){
                      $article_id = $row_articles->article_id;
                      $article_url = $row_articles->article_url;
                      $article_heading = $row_articles->article_heading;
                      $article_body = $row_articles->article_body;
                      $right_image = $row_articles->right_image;
                      $top_image = $row_articles->top_image;
                      $bottom_image = $row_articles->bottom_image;
                      if($lang_dir == "right"){
                        $floatRight = "float-right";
                      }else{
                        $floatRight = "float-left";
                      }
                    ?>
                    <a class="blog-recent-posts-item d-flex flex-row" href="article/<?php echo $article_id; ?>">
                      <div class="image">
                        <img alt="7 tips ensure a remarkable job application in social media" class="img-fluid d-block" src="<?= $site_url; ?>/article/article_images/<?= $top_image; ?>" style="height: 100%" />
                      </div>
                      <div class="text"><?= $article_heading ?></div>
                    </a>
                    <?php } ?>
                    <!-- Each item -->
                  </div>
                </div>
              </div>
              <!-- Column 2 -->
            </div>
          </div>
        </div>
      </section>

    </main>


    <!-- <div class="container mt-5">
      <div class="row">
        <div <?php if(!empty($right_image)){ ?>class="col-md-9"<?php }else{ ?>class="col-md-12"<?php } ?>>
          <h3 class="make-black pb-1 <?= $floatRight ?>"><i class="text-success fa fa-book"></i> <?php echo $article_heading; ?> </h3>
          <hr style="clear: both;">
          <p><?php echo $article_body; ?></p>
          <br><br>
        </div>
        <?php if(!empty($right_image)){ ?>
        <div class="col-md-3">
          <img src="article_images/<?php echo $right_image; ?>" class="img-fluid mt-5"> 
        </div>
        <?php } ?>
      </div>
    </div>
    <section class="text-center p-5" 
      <?php if(!empty($bottom_image)){ ?>
      style="background-image:url(article_images/<?php echo $bottom_image; ?>); color:white;"
      <?php }else{ ?>
      style="background-color:#F7F7F7; "
      <?php } ?>
      >
      <h1 style=" font-family: 'Montserrat-Regular';" >Do you still have questions ?</h1>
      <h6 style="    font-family:'Montserrat-Light';" class=" mt-2">Our support agents are ready with the answers.</h6>
      <?php if(!empty($bottom_image)){ ?>
      <a href="../customer_support" class="mt-2 btn btn-lg btn-outline-secondary">Contact Us</a>
      <?php }else{ ?>
      <a href="../customer_support" class="mt-2 btn btn-lg btn-outline-success">Contact Us</a>
      <?php } ?>
    </section> -->
    <?php include "../includes/footer.php"; ?>
  </body>
</html>