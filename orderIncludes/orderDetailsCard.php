<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-2">
        <img src="proposals/proposal_files/<?= $proposal_img1; ?>" class="img-fluid d-lg-block d-md-block d-none">
      </div>
      <div class="col-md-10">
        <?php if($seller_id == $login_seller_id){ ?>
        <h1 class="text-success float-right d-lg-block d-md-block d-none"><?= $s_currency.$order_price; ?>.00</h1>
        <h4>
          Order #<?= $order_number; ?>
          <small>
          <a href="proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>" target="_blank" class="text-success">
            View Proposal/Service
          </a>
          </small>
        </h4>
        <p class="text-muted">
          <span class="font-weight-bold">Buyer: </span>
          <a href="<?= $buyer_user_name; ?>" target="_blank" class="seller-buyer-name mr-1 text-success">
          <?= ucfirst($buyer_user_name); ?>
          </a>
          | <span class="font-weight-bold ml-1"> Status: </span>
          <?= $order_status; ?>
          | <span class="font-weight-bold ml-1"> Date: </span>
          <?= $order_date; ?>
          <?php if($videoPlugin == 1 AND !empty($order_minutes)){ ?>
          | <span class="font-weight-bold ml-1"> Video Call Minutes: </span>
          <?= $order_minutes; ?> Minutes
          <?php } ?>
        </p>
        <?php }elseif($buyer_id == $login_seller_id){ ?>
        <h1 class="text-success float-right d-lg-block d-md-block d-none"><?= $s_currency.$total; ?>.00</h1>
        <h4><?= $proposal_title; ?>   </h4>
        <p class="text-muted">
          <span class="font-weight-bold">Seller: </span>
          <a href="<?= $seller_user_name; ?>" target="_blank" class="seller-buyer-name mr-1 text-success">
          <?= ucfirst($seller_user_name); ?>
          </a>
          | <span class="font-weight-bold ml-1"> Order: </span> #<?= $order_number; ?>
          | <span class="font-weight-bold ml-1"> Date: </span>
          <?= $order_date; ?>
          <?php if($videoPlugin == 1 AND !empty($order_minutes)){ ?>
            | <span class="font-weight-bold ml-1"> Video Call Minutes: </span>
            <?= $order_minutes; ?> Minutes
          <?php } ?>
        </p>
        <?php } ?>
      </div>
    </div>
    <?php require_once("orderItems.php"); ?>
  </div>
</div>