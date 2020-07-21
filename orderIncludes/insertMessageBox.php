    <?php if($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested"){ ?>

      <?php

        if($seller_id == $login_seller_id){
          $select_buyer = $db->select("sellers",array("seller_id"=>$buyer_id));
          $row_buyer = $select_buyer->fetch();
          $buyer_user_name = $row_buyer->seller_user_name;
          $buyer_status = $row_buyer->seller_status;
        }elseif($buyer_id == $login_seller_id){
          $select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
          $row_seller = $select_seller->fetch();
          $seller_user_name = $row_seller->seller_user_name;
          $seller_status = $row_seller->seller_status;
        }
        
        ?>
      <div class="message-sender-area">
        <?php if($buyer_id == $login_seller_id AND $order_status == "pending" ){ ?>
        <div class="float-left pt-2">
          <!-- <span class="font-weight-bold text-danger"> RESPOND SO THAT SELLER CAN START YOUR ORDER. </span> -->
        </div>
        <?php } ?>
        <form id="insert-message-form">
          <textarea name="message" class="message-text" placeholder="Type your message here..." onkeyup="matchWords(this)"></textarea>
          <div class="float-left b-2">
            <p id="spamWords" class="mt-1 text-danger d-none"><i class="fa fa-warning"></i> You seem to have typed word(s) that are in violation of our policy. No direct payments or emails allowed.</p>
          </div>
          <?php 
          if($enableVideo == 1 or $count_schedule == 1){
             require_once("plugins/videoPlugin/videoCall/orderVideoCall.php"); 
          }
          ?>
          <div class="d-flex flex-column flex-sm-row justify-content-between">
            <div class="attachment d-flex flex-row align-items-center">
              <label for="attach-file">
                <input type="file" hidden name="file" id="attach-file" />
                <div class="d-flex flex-row align-items-center">
                  <i class="fal fa-paperclip"></i>
                  Attach File
                </div>
              </label>
              <div class="file-size">Max Size 30MB</div>
            </div>
            <button class="send-message" type="submit" role="button">SEND</button>
          </div>
        </form>
      </div>



    <!-- <div class="insert-message-box">
      <?php if($buyer_id == $login_seller_id AND $order_status == "pending" ){ ?>
      <div class="float-left pt-2">
        <span class="font-weight-bold text-danger"> RESPOND SO THAT SELLER CAN START YOUR ORDER. </span>
      </div>
      <?php } ?>
      <div class="float-right">
        <?php

        if($seller_id == $login_seller_id){
          $select_buyer = $db->select("sellers",array("seller_id"=>$buyer_id));
          $row_buyer = $select_buyer->fetch();
          $buyer_user_name = $row_buyer->seller_user_name;
          $buyer_status = $row_buyer->seller_status;
        }elseif($buyer_id == $login_seller_id){
          $select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
          $row_seller = $select_seller->fetch();
          $seller_user_name = $row_seller->seller_user_name;
          $seller_status = $row_seller->seller_status;
        }
        
        ?>
        <p class="text-muted mt-1">
          <?php if($seller_id == $login_seller_id){ ?>
          <?= ucfirst($buyer_user_name); ?>
          <span <?php if(check_status($buyer_id) == "Online"){ ?>
            class="text-success font-weight-bold"
            <?php }else{ ?>
            style="color:#868e96; font-weight:bold;"
            <?php } ?>>  
          is <?= check_status($buyer_id); ?> 
          </span> | Local Time
          <?php }elseif($buyer_id == $login_seller_id){ ?>
          <?= ucfirst($seller_user_name); ?>
          <span <?php if(check_status($seller_id) == "Online"){ ?>
            class="text-success font-weight-bold"
            <?php }else{ ?>
            style="color:#868e96; font-weight:bold;"
            <?php } ?>> 
          is <?= check_status($seller_id); ?> 
          </span> | Local Time
          <?php } ?>
          <i class="fa fa-sun-o"></i>
          <?= date("h:i A"); ?>
        </p>
      </div>
      <form id="insert-message-form" class="clearfix">
        <textarea name="message" rows="5" placeholder="Type Your Message Here..." class="form-control mb-2" onkeyup="matchWords(this)"></textarea>
        <div class="float-left b-2">
          <p id="spamWords" class="mt-1 text-danger d-none"><i class="fa fa-warning"></i> You seem to have typed word(s) that are in violation of our policy. No direct payments or emails allowed.</p>
        </div>
        <?php 
          if($enableVideo == 1 or $count_schedule == 1){
            // require_once("plugins/videoPlugin/videoCall/orderVideoCall.php"); 
          }
        ?>
        <button type="submit" class="btn btn-success float-right">Send</button>
        <div class="clearfix"></div>
        <p></p>
        <div class="form-row align-items-center message-attacment">
          
          <label class="h6 ml-2 mt-1"> Attach File (optional) </label>
          <input type="file" name="file" class="form-control-file p-1 mb-2 mb-sm-0">
        </div>
        
      </form>
    </div> -->
    <div id="upload_file_div"></div>
    <div id="message_data_div"></div>
    <?php } ?>