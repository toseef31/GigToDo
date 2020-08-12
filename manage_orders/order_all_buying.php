<table class="table orders-table" border="0" cellpadding="0" cellspacing="0">
	<thead>
		<tr role="row">
			<th role="column">Orders Description</th>
			<th role="column">Order Date</th>
			<th role="column">Due On</th>
			<th role="column">Total</th>
			<th role="column">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sel_orders = $db->select("orders",array("buyer_id" => $login_seller_id),"DESC");
		
		$count_orders = $sel_orders->rowCount();
		while($row_orders = $sel_orders->fetch()){
		$order_id = $row_orders->order_id;
		$proposal_id = $row_orders->proposal_id;
		$order_price = $row_orders->order_price;
		$order_fee = $row_orders->order_fee;
		$total_amount = $order_price + $order_fee;
		$order_status = $row_orders->order_status;
		$order_number = $row_orders->order_number;
		$order_duration = intval($row_orders->order_duration);
		$order_date = $row_orders->order_date;
		$order_due = date("F d, Y", strtotime($order_date . " + $order_duration days"));
		$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
		$row_proposals = $select_proposals->fetch();
		$proposal_title = $row_proposals->proposal_title;
		$proposal_img1 = $row_proposals->proposal_img1;
		$today_date = date("F d, Y");
		// if($order_due < $today_date){
		// 	$update_order = $db->update("orders",array("order_status"=>'overdue'),array("buyer_id"=>$login_seller_id));
		// }

  $new_date_today = strtotime($today_date);
   
  $date1 = date('Y-m-d',$new_date_today);

  $new_date_order = strtotime($order_due);
   
  $date2 = date('Y-m-d',$new_date_order);
 
		?>
		<tr role="row">
			<td data-label="Description" role="column">
				<div class="order-desc d-flex flex-wrap">
					<div class="order-image">
						<?php if (!empty($proposal_img1)){ ?>
						<img src="<?= $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid d-block" width="100%" style="height: 85px;" />
						<?php }else{ ?>
						<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" class="img-fluid d-block" width="100%" />
						<?php } ?>
					</div>
					<div class="order-desc-text">
						<p><?php echo $proposal_title;?></p>
					</div>
				</div>
			</td>
			<td data-label="Order Date" role="column">
				<div class="date"><?php echo $order_date; ?></div>
			</td>
			<td data-label="Due On" role="column">
				<div class="date"><?php echo $order_due; ?></div>
			</td>
			<td data-label="Total" role="column">
				<div class="amount"><?php if ($to == 'EGP'){ echo $to.' '; echo $total_amount;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $total_amount,2);}else{  echo $s_currency.' '; echo $total_amount; } ?></div>
			</td>
			<td data-label="Status" role="column">
				<?php if ($order_status == "delivered"){ ?>
				<a class="button button-red" href="order_details?order_id=<?php echo $order_id; ?>"><?php echo ucwords($order_status); ?></a>
				<?php }elseif($order_status == "progress" && $date1 <= $date2){ ?>
					<a class="button button-limerick" href="order_details?order_id=<?php echo $order_id; ?>">In Progress</a>
				<?php }elseif($order_status == "completed"){ ?>
					<a class="button button-yellow" href="order_details?order_id=<?php echo $order_id; ?>"><?php echo ucwords($order_status); ?></a>
				<?php }elseif($order_status == "cancelled"){ ?>
					<a class="button button-white" href="order_details?order_id=<?php echo $order_id; ?>"><?php echo ucwords($order_status); ?></a>
				<?php }elseif($order_status == "pending" && $date1 < $date2){ ?>

					<a class="button button-darkgray" href="order_details?order_id=<?php echo $order_id; ?>"><?php echo ucwords($order_status); ?></a>

				<?php }elseif($order_status == "cancellation requested"){ ?>
					<a class="button button-red" href="order_details?order_id=<?php echo $order_id; ?>">Cancel Request</a>

				<?php }elseif($date1 > $date2 && $order_status == 'progress' or $order_status == 'pending'){ ?>
					<a class="button button-lochmara" href="order_details?order_id=<?php echo $order_id; ?>">overdue</a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php
	if( $count_orders == 0){
	echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> No proposals/services purchases at the momment.</h3></center>";
	}
	?>
<!-- <div class="table-responsive box-table mt-3">
	<table class="table table-bordered">
		<thead>
			
			<tr>
				<th>ORDER SUMMARY</th>
				<th>ORDER DATE</th>
				<th>DUE ON</th>
				<th>TOTAL</th>
				<th>STATUS</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				
				<?php
				$sel_orders = $db->select("orders",array("buyer_id" => $login_seller_id),"DESC");
				
				$count_orders = $sel_orders->rowCount();
				while($row_orders = $sel_orders->fetch()){
				$order_id = $row_orders->order_id;
				$proposal_id = $row_orders->proposal_id;
				$order_price = $row_orders->order_price;
				$order_status = $row_orders->order_status;
				$order_number = $row_orders->order_number;
				$order_duration = intval($row_orders->order_duration);
				$order_date = $row_orders->order_date;
				$order_due = date("F d, Y", strtotime($order_date . " + $order_duration days"));
								$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
								$row_proposals = $select_proposals->fetch();
								$proposal_title = $row_proposals->proposal_title;
				$proposal_img1 = $row_proposals->proposal_img1;
				?>
				<td>
					<a href="order_details?order_id=<?php echo $order_id; ?>" class="make-black">
						<img class="order-proposal-image " src="proposals/proposal_files/<?php echo $proposal_img1; ?>">
						<p class="order-proposal-title"><?php echo $proposal_title; ?></p>
						
					</a>
					
				</td>
				<td><?php echo $order_date; ?></td>
				<td><?php echo $order_due; ?></td>
				<td><?php echo $s_currency; ?><?php echo $order_price; ?></td>
				<td><button class="btn btn-success"><?php echo ucwords($order_status); ?></button></td>
				
			</tr>
			
			<?php } ?>
			
		</tbody>
		
	</table>
	
	<?php
	
	if( $count_orders == 0){
	
	echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> No proposals/services purchases at the momment.</h3></center>";
	}
	
	
	
	?>
</div> -->