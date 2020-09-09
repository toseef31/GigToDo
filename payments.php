<?php
session_start();
require_once("includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
  
echo "<script>window.open('login','_self')</script>";

}
    $login_seller_user_name = $_SESSION['seller_user_name'];
    $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
    $row_login_seller = $select_login_seller->fetch();
    $login_seller_id = $row_login_seller->seller_id;
    $select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
    $row_seller_accounts = $select_seller_accounts->fetch();
    $current_balance = $row_seller_accounts->current_balance;
    

    $payments = $db->query("SELECT * from weaccept_payments WHERE seller_id = {$login_seller_id} ORDER BY created_at DESC")->fetchAll();

   
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF82RTH');</script>
<!-- End Google Tag Manager -->
    <title><?php echo $site_name; ?> - All Your Payments.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <!--====== Favicon Icon ======-->
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="<?= $site_url; ?>/images/<?php echo $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
    <!--====== Bootstrap css ======-->
    <link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <!--====== PreLoader css ======-->
    <link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
    <!--====== Animate css ======-->
    <link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
    <!--====== Fontawesome css ======-->
    <link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
    <!--====== Owl carousel css ======-->
    <link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
    <!--====== Nice select css ======-->
    <link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
    <!--====== Range Slider css ======-->
    <link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
    <!--====== Default css ======-->
    <link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
    <!--====== Responsive css ======-->
    <link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
    <!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
    <!-- <link href="styles/custom.css" rel="stylesheet">  -->
    <!-- Custom css code from modified in admin panel --->
    <link href="styles/styles.css" rel="stylesheet">
    <link href="styles/user_nav_styles.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link href="styles/sweat_alert.css" rel="stylesheet">
  </head>
  <body class="all-content">
    <!-- Preloader Start -->
    <div class="proloader">
       <div class="loader">
           <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
       </div>
    </div>
    <!-- Preloader End -->
    <?php require_once("includes/buyer-header.php"); ?>

    <div class="purchases-box">
      <!-- Purchases-area -->
      <div class="purchases-area">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="purchases-title">
                Payments
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Purchases-area  END-->
      <div class="purchease-filer">
        <div class="container">
          <div class="row">
          </div>
        </div>
      </div>
      <!-- Purchase-table-area -->
      <div class="purchases-table-area payments-table">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <table class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Status</th>
                      <th scope="col">Type</th>
                      <th scope="col">Order Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($payments as $payment){ ?>
                    <tr>
                      <th scope="row"><?php echo date_format(date_create($payment->created_at),"M d, Y") ?></th>
                      <td class="payment-status">
                        <span class="font-weight-bold <?php echo $payment->status ?>">
                            <?php echo $payment->status ?>
                        </span>
                        <?php if($payment->status != "success"): ?>
                            <i title="Refresh payment status" class="fa fa-refresh ml-1 check-payment-status <?php echo $payment->status ?>" data-weaccept-transaction="<?php echo $payment->weaccept_transaction_id ?>"></i>
                        <?php else: ?> 
                            <i class="fal fa-check ml-1  font-weight-bold text-success"></i>
                        <?php endif ?>
                      </td>
                      <td class="payment-type">
                            <?php echo $payment->type ?>
                      </td>
                      <td class="order-status" data-payment-id="<?php echo $payment->id ?>">
                          <?php if($payment->order_id == null && !$payment->paid): ?>
                            Awaiting Payment
                          <?php elseif($payment->order_id == null && $payment->paid): ?>
                            <a href="/weaccept/create_order?payment_id=<?php echo $payment->id ?>" style=" color: #FF0000;">Create Order</a>
                          <?php else: ?>
                            <span class="text-success">Created</span>
                          <?php endif ?>
                      </td>
                    </tr>

                    <?php } ?>
                  </tbody>
                </table>
              </table>
              <?php
              if(count($payments) == 0){
                echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> You have no Payments to display.</h3></center>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Purchase-table-area END -->
    </div>
    <?php require_once("includes/footer.php"); ?>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script type="text/javascript" src="js/sweat_alert.js"></script>
    <script src="<?= $site_url; ?>/js/payments.js"></script>
  </body>
</html>