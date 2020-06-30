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
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title><?php echo $site_name; ?> - All Your Purchases.</title>
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
                Purchases
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="purchases-item-box">
                <div class="row">
                  <?php
                    $get_purchases = $db->select("purchases",array("seller_id" => $login_seller_id),"DESC");
                    $count_purchases = $get_purchases->rowCount();
                    $total_purchase = array();
                    $active_order_price = 0;
                    while($row_purchases = $get_purchases->fetch()){
                      $order_id = $row_purchases->order_id;
                      $amount = $row_purchases->amount;
                      array_push($total_purchase,$amount);

                      $get_order = $db->select("orders",array("order_id" => $order_id, "order_status" => "active"));
                      $order_amount_price = 0;
                      $order_fee_price = 0;
                      while($row_order = $get_order->fetch()){
                        $order_price = $row_order->order_price;
                        $order_fee = $row_order->order_fee;
                        $order_amount_price += $order_price;
                        $order_fee_price += $order_fee;
                        
                        $active_order_price += $order_amount_price + $order_fee_price;
                      }
                    }
                    $total_purchase_amount = array_sum($total_purchase);

                  ?>
                  <div class="col-lg-3 col-md-3 col-6">
                    <div class="purchases-blance-item">
                      <div class="purchases-blance-table">
                        <div class="purchases-icon">
                          <img src="assets/img/img/icon1.png" alt="">
                        </div>
                        <div class="purchases-text">
                          <h4>Total Purchases <span><?php if ($to == 'USD'){ echo $to.' '; echo $total_purchase_amount;}elseif($to == 'EGP'){  echo $to.' '; echo round($cur_amount * $total_purchase_amount);}else{  echo $s_currency.' '; echo $total_purchase_amount; } ?></span></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-6">
                    <div class="purchases-blance-item">
                      <div class="purchases-blance-table">
                        <div class="purchases-icon">
                          <img src="assets/img/img/icon2.png" alt="">
                        </div>
                        <div class="purchases-text">
                          <h4>active orders purchased <span><?php if ($to == 'USD'){ echo $to.' '; echo $active_order_price;}elseif($to == 'EGP'){  echo $to.' '; echo round($cur_amount * $active_order_price);}else{  echo $s_currency.' '; echo $active_order_price; } ?></span></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                    $get_purchases = $db->select("purchases",array("seller_id" => $login_seller_id),"DESC");
                    $count_purchases = $get_purchases->rowCount();
                    $total_purchase = array();
                    $completed_order_price = 0;
                    while($row_purchases = $get_purchases->fetch()){
                      $order_id = $row_purchases->order_id;
                      $amount = $row_purchases->amount;
                      array_push($total_purchase,$amount);

                      $get_order = $db->select("orders",array("order_id" => $order_id, "order_status" => "completed"));
                      $order_amount_price = 0;
                      $order_fee_price = 0;
                      while($row_order = $get_order->fetch()){
                        $order_price = $row_order->order_price;
                        $order_fee = $row_order->order_fee;
                        $order_amount_price += $order_price;
                        $order_fee_price += $order_fee;
                        
                        $completed_order_price += $order_amount_price + $order_fee_price;
                      }
                    }
                    $total_purchase_amount = array_sum($total_purchase);

                  ?>
                  <div class="col-lg-3 col-md-3 col-6">
                    <div class="purchases-blance-item">
                      <div class="purchases-blance-table">
                        <div class="purchases-icon">
                          <img src="assets/img/img/icon3.png" alt="">
                        </div>
                        <div class="purchases-text">
                          <h4>completed purchases <span><?php if ($to == 'USD'){ echo $to.' '; echo $completed_order_price;}elseif($to == 'EGP'){  echo $to.' '; echo round($cur_amount * $completed_order_price);}else{  echo $s_currency.' '; echo $completed_order_price; } ?></span></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-6">
                    <div class="purchases-blance-item">
                      <div class="purchases-blance-table">
                        <div class="purchases-icon">
                          <img src="assets/img/img/icon4.png" alt="">
                        </div>
                        <div class="purchases-text">
                          <h4>personal balance <span><?php if ($to == 'USD'){ echo $to.' '; echo "0";}elseif($to == 'EGP'){  echo $to.' '; echo round($cur_amount * "0");}else{  echo $s_currency.' '; echo "0"; } ?></span></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Purchases-area  END-->
      <div class="purchease-filer">
        <div class="container">
          <div class="row">
            <!-- <div class="col-12 col-md-6 d-flex flex-row justify-content-start align-items-start">
              <div class="show-text">
                Show
              </div>
              <div class="d-flex flex-wrap align-items-start">
                <div class="show-filer">
                  <select name="" id="">
                    <option value="">Everything</option>
                    <option value="">Everything</option>
                    <option value="">Everything</option>
                    <option value="">Everything</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="pagination-bar">
                <ul class="d-flex flex-row justify-content-center align-items-center justify-content-md-end">
                  <li><a href="javascript:void(0);"><i class="fas fa-caret-left"></i></a></li>
                  <li><a href="javascript:void(0);">1</a></li>
                  <li>Of <span>1</span></li>
                  <li><a href="javascript:void(0);"><i class="fas fa-caret-right"></i></a></li>
                </ul>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <!-- Purchase-table-area -->
      <div class="purchases-table-area">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <table class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Date</th>
                      <th scope="col">Title</th>
                      <th scope="col" style="text-align: right;">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $get_purchases = $db->select("purchases",array("seller_id" => $login_seller_id),"DESC");
                    $count_purchases = $get_purchases->rowCount();
                    while($row_purchases = $get_purchases->fetch()){
                    $order_id = $row_purchases->order_id;
                    $amount = $row_purchases->amount;
                    $date = $row_purchases->date;
                    $method = $row_purchases->method;
                    if($method=="featured_proposal_declined") {
                      $select_proposals = $db->select("proposals",array("proposal_id"=>$order_id));
                      $row_proposals = $select_proposals->fetch();
                      $proposal_title = $row_proposals->proposal_title;
                    }
                    ?>
                    <tr>
                      <th scope="row"><?php echo $date; ?></th>
                      <td>
                        <?php if($method == "shopping_balance"){ ?>
                        Proposal/Service purchased with Shopping Balance  
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;"> View Order </a>)
                        <?php }elseif($method == "paypal"){ ?>
                        Payment for purchase with paypal
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;">View Order</a>)
                        <?php }elseif($method == "stripe"){ ?>
                        Deposit from credit card / stripe
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;"> View Order </a>)
                        <?php }elseif($method == "2checkout"){ ?>
                        Payment for purchase with 2checkout
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;">View Order</a>)
                        <?php }elseif($method == "payza"){ ?>
                        Payment for purchase with payza
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;">View Order</a>)
                        <?php }elseif($method == "coinpayments"){ ?>
                        Payment for purchase with coinpayments
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;"> View Order </a>)
                        <?php }elseif($method == "mobile_money"){ ?>
                        Payment for purchase with mobile money
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;"> View Order </a>)
                        <?php }elseif($method == "paystack"){ ?>
                        Payment for purchase with paystack
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;"> View Order </a>)
                        <?php }elseif($method == "featured_proposal_declined"){ ?>
                        Your featured proposal is declined so it feature listing fee is refunded to your shopping balance.
                        (<a href="<?php echo $site_url; ?>/view_proposals.php" style=" color: #FF0000;"> View Proposals </a>)
                        <?php }elseif($method == "order_cancellation"){ ?>
                        Cancelled order payment refunded to your shopping  balance
                        (<a href="order_details?order_id=<?php echo $order_id; ?>" style=" color: #FF0000;"> View Order </a>)
                        <?php } ?>
                      </td>
                      <td style="text-align: right; color: #FF0000;">
                        <?php 
                          if($method == "order_cancellation" or $method == "featured_proposal_declined"){
                          echo "<span class='text-success'>+$s_currency$amount.00</span>";
                          }else{
                          echo "-$s_currency$amount.00";
                          }
                        ?>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </table>
              <?php
              if($count_purchases == 0){
                echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> You have no purchases to display.</h3></center>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Purchase-table-area END -->
    </div>

    <!-- <div class="container">
      <div class="row">
        <div class="col-md-12 mt-5">
          <h2 class="mb-5 <?=($lang_dir == "right" ? 'text-right':'')?>"> <?php echo $lang["titles"]["purchases"]; ?> </h2>
          <div class="table-responsive box-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>For</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $get_purchases = $db->select("purchases",array("seller_id" => $login_seller_id),"DESC");
                $count_purchases = $get_purchases->rowCount();
                while($row_purchases = $get_purchases->fetch()){
                $order_id = $row_purchases->order_id;
                $amount = $row_purchases->amount;
                $date = $row_purchases->date;
                $method = $row_purchases->method;
                if($method=="featured_proposal_declined") {
                $select_proposals = $db->select("proposals",array("proposal_id"=>$order_id));
                $row_proposals = $select_proposals->fetch();
                $proposal_title = $row_proposals->proposal_title;
                }
                ?>
                <tr>
                  <td> <?php echo $date; ?> </td>
                  <td>
                    <?php if($method == "shopping_balance"){ ?>
                    Proposal/Service purchased with Shopping Balance
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)
                    <?php }elseif($method == "paypal"){ ?>
                    Payment for purchase with paypal
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success">View Order</a>)
                    <?php }elseif($method == "stripe"){ ?>
                    Deposit from credit card / stripe
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)
                    <?php }elseif($method == "2checkout"){ ?>
                    Payment for purchase with 2checkout
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success">View Order</a>)
                    <?php }elseif($method == "payza"){ ?>
                    Payment for purchase with payza
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success">View Order</a>)
                    <?php }elseif($method == "coinpayments"){ ?>
                    Payment for purchase with coinpayments
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)
                    <?php }elseif($method == "mobile_money"){ ?>
                    Payment for purchase with mobile money
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)
                    <?php }elseif($method == "paystack"){ ?>
                    Payment for purchase with paystack
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)
                    <?php }elseif($method == "featured_proposal_declined"){ ?>
                    Your featured proposal is declined so it feature listing fee is refunded to your shopping balance.
                    (<a href="<?php echo $site_url; ?>/view_proposals.php" class="text-success"> View Proposals </a>)
                    <?php }elseif($method == "order_cancellation"){ ?>
                    Cancelled order payment refunded to your shopping  balance
                    (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)
                    <?php } ?>
                  </td>
                  <td class="text-danger">
                    <?php
                    if($method == "order_cancellation" or $method == "featured_proposal_declined"){
                    echo "<span class='text-success'>+$s_currency$amount.00</span>";
                    }else{
                    echo "-$s_currency$amount.00";
                    }
                    ?>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php
            if($count_purchases == 0){
            echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> You have no purchases to display.</h3></center>";
            }
            ?>
          </div>
        </div>
      </div>
    </div> -->
    <?php require_once("includes/footer.php"); ?>
  </body>
</html>