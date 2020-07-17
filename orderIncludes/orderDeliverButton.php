<?php if($seller_id == $login_seller_id){ ?>
  <?php if($order_status == "progress" or $order_status == "revision requested"){ ?>
    <div class="message-content-card-item d-flex flex-column">
      <div class="d-flex flex-wrap justify-content-center">
        <a class="d-flex flex-row align-items-center justify-content-center button button-red" data-toggle="modal" data-target="#deliver-order-modal">Deliver Now</a>
      </div>
    </div>
    <!-- <center>
      <button class="btn btn-success btn-lg mt-5 mb-3" data-toggle="modal" data-target="#deliver-order-modal">
        <i class="fa fa-upload"></i> Deliver Order
      </button>
    </center> -->
  <?php } ?>
  <?php if($order_status == "delivered"){ ?>
    <div class="message-content-card-item d-flex flex-column">
      <div class="d-flex flex-wrap justify-content-center">
        <a class="d-flex flex-row align-items-center justify-content-center button button-red" data-toggle="modal" data-target="#deliver-order-modal">Deliver Order Again</a>
      </div>
    </div>
    <!-- <center>
      <button class="btn btn-success btn-lg mt-4 mb-2" data-toggle="modal" data-target="#deliver-order-modal">
        <i class="fa fa-upload"></i> Deliver Order Again
      </button>
    </center> -->
  <?php } ?>
  <?php } ?>