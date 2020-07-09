<?php
session_start();
require_once("../includes/db.php");
require_once("../functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_email = $row_login_seller->seller_email;
$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$enable_paypal = $row_payment_settings->enable_paypal;
$paypal_email = $row_payment_settings->paypal_email;
$paypal_currency_code = $row_payment_settings->paypal_currency_code;
$paypal_sandbox = $row_payment_settings->paypal_sandbox;
if($paypal_sandbox == "on"){
$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}elseif($paypal_sandbox == "off"){
$paypal_url = "https://www.paypal.com/cgi-bin/webscr";	
}
$enable_stripe = $row_payment_settings->enable_stripe;
$enable_dusupay = $row_payment_settings->enable_dusupay;
$enable_payza = $row_payment_settings->enable_payza;
$payza_test = $row_payment_settings->payza_test;
$payza_currency_code = $row_payment_settings->payza_currency_code;
$payza_email = $row_payment_settings->payza_email;
$enable_coinpayments = $row_payment_settings->enable_coinpayments;
$coinpayments_merchant_id = $row_payment_settings->coinpayments_merchant_id;
$coinpayments_currency_code = $row_payment_settings->coinpayments_currency_code;
$enable_paystack = $row_payment_settings->enable_paystack;
if($paymentGateway == 1){
	$enable_2checkout = $row_payment_settings->enable_2checkout;
}else{
	$enable_2checkout = "no"; 
}
$enable_weaccept = $row_payment_settings->enable_weaccept;

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;
$_SESSION['c_message_offer_id'] = $input->post('offer_id');
$_SESSION['c_single_message_id'] = $input->post('single_message_id');
$offer_id = $input->post('offer_id');
$single_message_id = $input->post('single_message_id');
$select_offers = $db->select("messages_offers",array("offer_id" => $offer_id));
$row_offers = $select_offers->fetch();
$proposal_id = $row_offers->proposal_id;
$description = $row_offers->description;
$delivery_time = $row_offers->delivery_time;
$amount = $row_offers->amount;
$processing_fee = processing_fee($amount);
$total = $amount+$processing_fee;
$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
$row_proposals = $select_proposals->fetch();
$proposal_title = $row_proposals->proposal_title;
$site_logo_image = $row_general_settings->site_logo;
?>
<style>
	.accept-offer-modal .modal-footer form{
		margin-top: 12px;
		margin-bottom: 0;
	}
</style>
<div id="accept-offer-modal" class="modal">
	<div class="modal-dialog  modal-dialog-centered customer-order" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> Select A Payment Method To Order </h5>
				<a href="javascript:void(0);" class="closed" data-dismiss="modal" aria-label="Close">
					<img src="<?= $site_url; ?>/assets/img/seller-profile/popup-close-icon.png" />
				</a>
			</div>
			<div class="modal-body p-0">
				<div class="order-details">
					<div class="request-div">
						<h4 class="mb-3">
						يتعلق هذا الأمر بالعرض التالي:
						<span class="total-price d-sm-block d-none float-left"> <?= $s_currency; ?><?= $amount; ?> </span>
						</h4>
						<p> "<?= $description; ?>" </p>
						<p> <b> اقتراح: </b> <?= $proposal_title; ?> </p>
						<p> <b> السعر: </b> <?= $s_currency; ?><?= $amount; ?> </p>
						<p class="processing-fee"> <b> كلفة المعالجة: </b> <?= $s_currency; ?><?= $processing_fee; ?> </p>
						<p> <b> موعد التسليم: </b> <?= $delivery_time; ?> </p>
					</div>
				</div>
				<div class="payment-options-list">
					
					<?php if($current_balance >= $amount){ ?>
					<div class="payment-options mb-2">
						<input type="radio" name="payment_option" id="shopping-balance" class="radio-custom" checked>
						<label for="shopping-balance" class="radio-custom-label" ></label>
						<span class="lead font-weight-bold"> Shopping Balance </span>
						<p class="lead ml-5">
							Personal Balance - <?= $login_seller_user_name; ?> <span class="text-success font-weight-bold"> <?= $s_currency; ?><?= $current_balance; ?> </span>
						</p>
					</div>
					<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_payza == "yes" or $enable_coinpayments == "yes" or $enable_dusupay == "yes" or $enable_weaccept == "yes"){ ?>
					<hr>
					<?php } ?>
					<?php } ?>
					<?php if($enable_paypal == "yes"){ ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="paypal" class="radio-custom"
						<?php
						if($current_balance < $amount){
							echo "checked";
						}
						?>>
						<label for="paypal" class="radio-custom-label"></label>
						<img src="../images/paypal.png" class="img-fluid">
					</div>
					<?php } ?>
					<?php if($enable_stripe == "yes"){ ?>
					<?php if($enable_paypal == "yes"){ ?>
					<hr>
					<?php } ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="credit-card" class="radio-custom"
						<?php
						if($current_balance < $amount){
							if($enable_paypal == "no"){
							echo "checked";
							}
						}
						?>>
						<label for="credit-card" class="radio-custom-label"></label>
						<img src="../images/credit_cards.jpg" class="img-fluid">
					</div>
					<?php } ?>
					<?php if($enable_weaccept == "yes"){ ?>
					<?php if($enable_paypal == "yes"){ ?>
					<hr>
					<?php } ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="weacceptWallet" class="radio-custom"
						<?php
						if($current_balance < $amount){
							if($enable_paypal == "no"){
							echo "checked";
							}
						}
						?>>
						<label for="weacceptWallet" class="radio-custom-label"></label>
						We Accept Wallet
					</div>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="weacceptCash" class="radio-custom"
						<?php
						if($current_balance < $amount){
							if($enable_paypal == "no"){
							echo "checked";
							}
						}
						?>>
						<label for="weacceptCash" class="radio-custom-label"></label>
						We Accept Cash
					</div>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="weacceptKiosk" class="radio-custom"
						<?php
						if($current_balance < $amount){
							if($enable_paypal == "no"){
							echo "checked";
							}
						}
						?>>
						<label for="weacceptKiosk" class="radio-custom-label"></label>
						We Accept Kiosk
					</div>
					<?php } ?>
					<!-- End We Accept -->
					<?php
					if($enable_2checkout == "yes"){
						include("../plugins/paymentGateway/paymentMethod2.php");
					}
					?>
					<?php if($enable_payza == "yes"){ ?>
					<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes"){ ?>
					<hr>
					<?php } ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="payza" class="radio-custom"
						<?php
						if($current_balance < $amount){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "yes"){
							echo "checked";
							}
						}
						?>>
						<label for="payza" class="radio-custom-label"></label>
						<img src="../images/payza.jpg" class="img-fluid">
					</div>
					<?php } ?>
					<?php if($enable_coinpayments == "yes"){ ?>
					<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_payza == "yes"){ ?>
					<hr>
					<?php } ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="coinpayments" class="radio-custom"
						<?php
						if($current_balance < $amount){
						if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no"){
						echo "checked";
						}
						}
						?>>
						<label for="coinpayments" class="radio-custom-label"></label>
						<img src="../images/coinpayments.png" class="img-fluid">
					</div>
					<?php } ?>
					<?php if($enable_paystack == "yes"){ ?>
					<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_payza == "yes" or $enable_coinpayments == "yes"){ ?>
					<hr>
					<?php } ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="paystack" class="radio-custom"
						<?php
						if($current_balance < $amount){
						if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "no"){
						echo "checked";
						}
						}
						?>>
						<label for="paystack" class="radio-custom-label"></label>
						<img src="../images/paystack.png" class="img-fluid">
					</div>
					<?php } ?>
					<?php if($enable_dusupay == "yes"){ ?>
					<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_2checkout == "yes" or $enable_payza == "yes" or $enable_coinpayments =="yes" or $enable_paystack == "yes"){ ?>
					<hr>
					<?php } ?>
					<div class="payment-option">
						<input type="radio" name="payment_option" id="mobile-money" class="radio-custom"
						<?php
						if($current_balance < $amount){
						if($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "no"){
							echo "checked";
						}
						}
						?>>
						<label for="mobile-money" class="radio-custom-label"></label>
						<img src="../images/mobile-money.png" class="img-fluid">
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="form-group d-flex flex-row align-items-center justify-content-between border-top pt-30">
				<button class="button-close" data-dismiss="modal"> Close </button>
				<?php if($current_balance >= $amount){ ?>
				<form action="../shopping_balance" method="post" id="shopping-balance-form">
					<button class="button" type="submit" name="message_offer_submit_order" onclick="return confirm('Are you sure you want to pay the featured listing fee with your shopping balance ?')">
					Pay With Shopping Balance
					</button>
				</form>
				<br>
				<?php } ?>
				<?php if($enable_paypal == "yes"){ ?>
				<form action="paypal_charge" method="post" id="paypal-form"><!--- paypal-form Starts --->
				<button type="submit" name="paypal" class="button">Pay With Paypal</button>
				</form><!--- paypal-form Ends --->
				<?php } ?>
				<?php if($enable_stripe == "yes"){ ?>
				<?php
				require_once("../stripe_config.php");
				$stripe_total_amount = $total * 100;
				?>
				<form action="stripe_charge" method="post" id="credit-card-form"><!--- credit-card-form Starts --->
				<input
				type="submit"
				class="button stripe-submit"
				value="Pay With Credit Card"
				data-dismiss="modal"
				data-key="<?= $stripe['publishable_key']; ?>"
				data-amount="<?= $stripe_total_amount; ?>"
				data-currency="<?= $stripe['currency_code']; ?>"
				data-email="<?= $login_seller_email; ?>"
				data-name="<?= $site_name; ?>"
				data-image="<?= $site_url; ?>/images/<?= $site_logo_image; ?>"
				data-description="<?= $proposal_title; ?>"
				data-allow-remember-me="false">
				<script>
				$(document).ready(function() {
				$('.stripe-submit').on('click', function(event) {
				event.preventDefault();
				var $button = $(this),
				$form = $button.parents('form');
				var opts = $.extend({}, $button.data(), {
				token: function(result) {
				$form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
				}
				});
				StripeCheckout.open(opts);
				});
				});
				</script>
				</form><!--- credit-card-form Ends --->
				<?php } ?>
				<?php if($enable_2checkout == "yes"){ ?>
				<form action="../plugins/paymentGateway/conversations/2checkout_charge" method="post" id="2checkout-form">
					<button type="submit" name="2Checkout" class="button">Pay With 2Checkout</button>
				</form>
				<?php } ?>
				<?php if($enable_payza == "yes"){ ?>
				<form action="https://secure.payza.eu/checkout" method="post" id="payza-form">
					<input type="hidden" name="ap_merchant" value="<?= $payza_email; ?>"/>
					<input type="hidden" name="ap_purchasetype" value="item"/>
					<input type="hidden" name="ap_itemname" value="<?= $proposal_title; ?>"/>
					<input type="hidden" name="ap_amount" value="<?= $amount; ?>"/>
					<input type="hidden" name="ap_currency" value="<?= $payza_currency_code; ?>"/>
					<input type="hidden" name="ap_description" value="Proposal Payment"/>
					<input type="hidden" name="ap_taxamount" value="<?= $processing_fee; ?>"/>
					<input type="hidden" name="ap_ipnversion" value="2"/>
					<?php if($payza_test == "on"){ ?>
					<input type="hidden" name="ap_testmode" value="1"/>
					<?php }else{ ?>
					<input type="hidden" name="ap_testmode" value="0"/>
					<?php } ?>
					<input type="hidden" name="ap_returnurl" value="<?= $site_url; ?>/payza_order?message_offer_id=<?= $offer_id; ?>"/>
					<input type="hidden" name="ap_cancelurl" value="<?= $site_url; ?>/conversations/insert_message.php?single_message_id=<?= $single_message_id; ?>"/>
					<input type="submit" class="button" value="Pay With Payza">
				</form>
				<?php } ?>
				<?php if($enable_coinpayments == "yes"){ ?>
				<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments-form">
					<input type="hidden" name="cmd" value="_pay_simple">
					<input type="hidden" name="reset" value="1">
					<input type="hidden" name="merchant" value="<?= $coinpayments_merchant_id; ?>">
					<input type="hidden" name="item_name" value="<?= $proposal_title; ?>">
					<input type="hidden" name="item_desc" value="Proposal Payment">
					<input type="hidden" name="item_number" value="1">
					<input type="hidden" name="currency" value="<?= $coinpayments_currency_code; ?>">
					<input type="hidden" name="amountf" value="<?= $amount; ?>">
					<input type="hidden" name="want_shipping" value="0">
					<input type="hidden" name="taxf" value="<?= $processing_fee; ?>">
					<input type="hidden" name="success_url" value="<?= $site_url; ?>/crypto_order?message_offer_id=<?= $offer_id; ?>">
					<input type="hidden" name="cancel_url" value="<?= $site_url; ?>/conversations/insert_message.php?single_message_id=<?= $single_message_id; ?>">
					<input type="submit" class="button" value="Pay With Coinpayments">
				</form>
				<?php } ?>
				<?php if($enable_paystack == "yes"){ ?>
				<form action="paystack_charge" method="post" id="paystack-form"><!--- paystack-form Starts --->
				<button type="submit" name="paystack" class="button btn-block">Pay With Paystack</button>
				</form><!--- paystack-form Ends --->
				<?php } ?>
				<?php if($enable_dusupay == "yes"){ ?>
				<form method="post" action="dusupay_charge" id="mobile-money-form">
					<input type="submit" name="dusupay" value="Pay With Mobile Money" class="button">
				</form>
				<?php } ?>
				</div><!-- modal-footer Ends -->
				</div><!-- modal-content Ends -->
				</div><!-- modal-dialog Ends -->
				</div><!-- accpet-offer-modal Ends -->
<script>
$(document).ready(function(){
$("#accept-offer-modal").modal('show');
<?php if($current_balance >= $amount){ ?>
$('#paypal-form').hide();
$('#credit-card-form').hide();
$('#2checkout-form').hide();
$('#coinpayments-form').hide();
$('#paystack-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#weaccept-form').hide();
$('#weaccept-cash').hide();
$('#weaccept-valu').hide();
$('#weaccept-kiosk').hide();
<?php }else{ ?>
$('#shopping-balance-form').hide();
<?php } ?>
<?php if($current_balance >= $amount){ ?>	
$('.total-price').html('<?= $s_currency; ?><?= $amount; ?>');
$('.processing-fee').hide();
<?php }else{ ?>
$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
$('.processing-fee').show();
<?php } ?>

<?php if($current_balance < $amount){ ?>
<?php if($enable_paypal == "yes"){ ?>
$('#credit-card-form').hide();
$('#2checkout-form').hide();
$('#mobile-money-form').hide();
$('#payza-form').hide();
$('#coinpayments-form').hide();
$('#paystack-form').hide();
$('#weaccept-form').hide();
$('#weaccept-cash').hide();
$('#weaccept-valu').hide();
$('#weaccept-kiosk').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "yes"){ ?>
$('#2checkout-form').hide();
$('#coinpayments-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "yes") { ?>
$('#coinpayments-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "yes") { ?>
$('#coinpayments-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "yes") { ?>
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_2checkout == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "yes") { ?>
$('#mobile-money-form').hide();
<?php } ?>
<?php } ?>

$('#shopping-balance').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $amount; ?>');
	$('.processing-fee').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').show();
	$('#coinpayments-form').hide();
	$('#payza-form').hide();
	$('#paystack-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#paypal').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').show();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#payza-form').hide();
	$('#paystack-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#credit-card').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#payza-form').hide();
	$('#paystack-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#2checkout').click(function(){
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#payza').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#paypal-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').show();
	$('#shopping-balance-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#coinpayments').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
  $('#coinpayments-form').show();
  $('#paystack-form').hide();
	$('#payza-form').hide();
	$('#shopping-balance-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#paystack').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#mobile-money').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').show();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#weacceptWallet').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').show();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#weacceptCash').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').show();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').hide();
});
$('#weacceptValU').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').show();
	$('#weaccept-kiosk').hide();
});
$('#weacceptKiosk').click(function(){
	$('.total-price').html('<?= $s_currency; ?><?= $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#2checkout-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#weaccept-form').hide();
	$('#weaccept-cash').hide();
	$('#weaccept-valu').hide();
	$('#weaccept-kiosk').show();
});
});
</script>