<?php

@session_start();

if(isset($_POST['proposal_id'])){
	require_once("../../../includes/db.php");
	$proposal_id = $input->post('proposal_id');
}

$get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic'));
$row_1 = $get_p_1->fetch();
$get_p_2 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard'));
$row_2 = $get_p_2->fetch();
$get_p_3 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance'));
$row_3 = $get_p_3->fetch();

$prices = range(100,10000,50);

$revisions = array(1,2,3,4,5,6,7,8,9,10);

$times = range(1,30,1);

?>
<style>
	.package-item-single select{display: block !important;}
	.package-item-single .nice-select{display: none !important;}
</style>
<!-- New Design -->
<!-- Packages -->
<section class="container-fluid packages" style="display: block;">
	<div class="row">
		<div class="container">
			<div class="packages-container d-flex flex-column">
				<div class="package-header d-flex flex-row">
					<div class="package-header-item d-flex flex-column align-items-center">
						<span class="text">
							3 باقات
						</span>
						<div class="md_switch">
							<input class="switch" id="switch" type="checkbox">
							<label for="switch"></label>
						</div>
					</div>
					<!-- Each item -->
					<div class="package-header-item">
						<div class="package-icon">
							<img class="img-fluid d-block" src="<?= $site_url ?>/ar/assets/img/post-a-gig/basic-icon.png" />
						</div>
						<span class="text">
							أساسية
						</span>
					</div>
					<!-- Each item -->
					<div class="package-header-item">
						<div class="package-icon">
							<img class="img-fluid d-block" src="<?= $site_url ?>/ar/assets/img/post-a-gig/standard-icon.png" />
						</div>
						<span class="text">
							قياسية
						</span>
					</div>
					<!-- Each item -->
					<div class="package-header-item">
						<div class="package-icon">
							<img class="img-fluid d-block" src="<?= $site_url ?>/ar/assets/img/post-a-gig/premium-icon.png" />
						</div>
						<span class="text">
							بريميوم
						</span>
					</div>
					<!-- Each item -->
				</div>
				<!-- Packages header -->
				<div class="package-body d-flex flex-column">
					<form action="#" method="post" class="pricing-form" id="pricing-form">
						<input type="hidden" name="proposal_packages[1][package_id]" form="pricing-form" value="<?= $row_1->package_id; ?>">
						<input type="hidden" name="proposal_packages[2][package_id]" form="pricing-form" value="<?= $row_2->package_id; ?>">
						<input type="hidden" name="proposal_packages[3][package_id]" form="pricing-form" value="<?= $row_3->package_id; ?>">
						<div class="package-item d-flex flex-row">
							<div class="package-item-single">
								<span class="title">
									الوصف
								</span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<!-- <span class="package-title">
									الأساسية
								</span> -->
								<textarea name="proposal_packages[1][description]" class="form-control description1" rows="6" cols="5" placeholder="Description"><?= $row_1->description; ?></textarea>

								<span class="desc1">الوصف مطلوب</span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<!-- <span class="package-title">
									قياسية
								</span> -->
								<textarea name="proposal_packages[2][description]" class="form-control packg-desc" rows="6" cols="5" placeholder="Description"><?= $row_2->description; ?></textarea>
								<span class="desc2">الوصف مطلوب</span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<!-- <span class="package-title">
									بريميوم
								</span> -->
								<textarea name="proposal_packages[3][description]" class="form-control packg-desc" rows="6" cols="5" placeholder="Description"><?= $row_3->description; ?></textarea>
								<span class="desc3">الوصف مطلوب</span>
							</div>
							<!-- Each item -->
						</div>
						<!-- Package-item -->
						<div class="package-item d-flex flex-row">
							<div class="package-item-single">
								<span class="title">
									وقت التسليم
								</span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select name="proposal_packages[1][delivery_time]" class="form-control wide">
									<?php
									// $get_delivery_times = $db->select("delivery_times");
									// while($row_delivery_times = $get_delivery_times->fetch()){
									// $delivery_time = $row_delivery_times->delivery_proposal_title;
									// echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_1->delivery_time ? "selected" : "").">$delivery_time</option>";
									// }
									foreach ($times as $time) {
									
									echo "<option value='$time' ".(intval($time) == $row_1->delivery_time ? "selected" : "").">$time</option>";
									 } ?>
								</select>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select name="proposal_packages[2][delivery_time]" form="pricing-form" class="form-control wide">
								<?php
								// $get_delivery_times = $db->select("delivery_times");
								// while($row_delivery_times = $get_delivery_times->fetch()){
								// $delivery_time = $row_delivery_times->delivery_proposal_title;
								// echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_2->delivery_time ? "selected" : "").">$delivery_time</option>";
								// }

								foreach ($times as $time) {
								
								echo "<option value='$time' ".(intval($time) == $row_2->delivery_time ? "selected" : "").">$time</option>";
								 }
								?>
								</select>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select name="proposal_packages[3][delivery_time]" form="pricing-form" class="form-control wide">
								<?php
								// $get_delivery_times = $db->select("delivery_times");
								// while($row_delivery_times = $get_delivery_times->fetch()){
								// $delivery_time = $row_delivery_times->delivery_proposal_title;
								// echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_3->delivery_time ? "selected" : "").">$delivery_time</option>";
								// }
								foreach ($times as $time) {
								
								echo "<option value='$time' ".(intval($time) == $row_3->delivery_time ? "selected" : "").">$time</option>";
								 }
								?>
								</select>
							</div>
							<!-- Each item -->
						</div>
						<!-- Package-item -->
						<div class="package-item d-flex flex-row">
							<div class="package-item-single">
								<span class="title">
									المراجعات
								</span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select name="proposal_packages[1][revisions]" form="pricing-form" class="form-control wide">
									<?php 
									foreach ($revisions as $rev) {
										echo "<option value='$rev'".($rev == $row_1->revisions ? "selected" : "").">$rev</option>";
									}
									?>
									<option>غير محدود</option>
								</select>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select name="proposal_packages[2][revisions]" form="pricing-form" class="form-control wide">
								<?php 
								foreach ($revisions as $rev) {
									echo "<option value='$rev'".($rev == $row_2->revisions ? "selected" : "").">$rev</option>";
								}
								?>
								<option>غير محدود</option>
								</select>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select name="proposal_packages[3][revisions]" form="pricing-form" class="form-control wide">
								<?php 
								foreach ($revisions as $rev) {
									echo "<option value='$rev'".($rev == $row_3->revisions ? "selected" : "").">$rev</option>";
								}
								?>
								<option>غير محدود</option>
								</select>
							</div>
							<!-- Each item -->
						</div>
						<!-- Package-item -->
						<?php
						$i = 0;
						$get_a = $db->select("package_attributes",array("package_id"=>$row_1->package_id));
						while($row_a = $get_a->fetch()){
						$a_id = $row_a->attribute_id;
						$a_name = $row_a->attribute_name;
						$a_value = $row_a->attribute_value;
						$i++;
						?>
						<div class="package-item d-flex flex-row">
							<div class="package-item-single">
								<span class="title"><?php echo $a_name; ?></span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<div class="d-flex flex-row justify-content-center">
									<div class="custom-control custom-checkbox">
										<input type="hidden" name="package_attributes[<?= $i; ?>][attribute_id]" form="pricing-form" value="<?= $a_id; ?>">
										<input type="checkbox" name="package_attributes[<?= $i; ?>][attribute_value]" class="custom-control-input" id="customCheck<?= $a_id; ?>" value="<?= $a_id; ?>">
										<i class="fa fa-trash delete-attribute" data-attribute="<?php echo $a_name; ?>"></i>
										<label class="custom-control-label" for="customCheck<?= $a_id; ?>">&nbsp;</label>
									</div>
								</div>
							</div>
							<!-- Each item -->
							<?php
							$get_v = $db->query("select * from package_attributes where proposal_id='$proposal_id' and attribute_name='$a_name' and not attribute_id='$a_id'");
							while($row_v = $get_v->fetch()){
							$id = $row_v->attribute_id;
							$value = $row_v->attribute_value;
							$i++;
							?>
							<div class="package-item-single">
								<div class="d-flex flex-row justify-content-center">
									<div class="custom-control custom-checkbox">
										<input type="hidden" name="package_attributes[<?= $i; ?>][attribute_id]" form="pricing-form" value="<?= $id; ?>">
										<!-- <input type="checkbox"name="package_attributes[<?= $i; ?>][attribute_value]" form="pricing-form" class="form-control" value="<?= $value; ?>"> -->
										<input type="checkbox" name="package_attributes[<?= $i; ?>][attribute_value]" class="custom-control-input" id="customCheck<?= $id; ?>" value="<?= $value; ?>">
										<i class="fa fa-trash delete-attribute" data-attribute="<?php echo $a_name; ?>"></i>
										<label class="custom-control-label" for="customCheck<?= $id; ?>">&nbsp;</label>
									</div>
								</div>
							</div>
							<?php } ?>
							<!-- Each item -->
						</div>
						<?php } ?>
						<!-- Package-item -->
						<div class="package-item d-flex flex-row">
							<div class="package-item-single">
								<span class="title">السعر</span>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select class="form-control wide" name="proposal_packages[1][price]" form="pricing-form">
									<option value="<?= $row_1->price; ?>" selected><?php if ($to == 'EGP'){ echo $to.' '; echo $row_1->price;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $row_1->price);}else{  echo $s_currency; echo $row_1->price; } ?></option>
									<?php 
										foreach ($prices as $price) {
											if($to == 'USD'){
												$packg_price = round($cur_amount * $price);
											}else{
												$packg_price = $price;
											}
											if ($to == '') {
												$to = $s_currency;
											}
											$pkg_price = round($cur_amount * $row_1->price);
											echo "<option value='$price'>$to $packg_price</option>";
										}
									?>
								</select>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select class="form-control wide" name="proposal_packages[2][price]" form="pricing-form">
									<option value="<?= $row_2->price; ?>" selected><?php if ($to == 'EGP'){ echo $to.' '; echo $row_2->price;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $row_2->price);}else{  echo $s_currency; echo $row_2->price; } ?></option>
									<?php 
										foreach ($prices as $price) {
											if($to == 'USD'){
												$packg_price = round($cur_amount * $price);
											}else{
												$packg_price = $price;
											}
											if ($to == '') {
												$to = $s_currency;
											}
											$pkg_price = round($cur_amount * $row_2->price);
											echo "<option value='$price'>$to $packg_price</option>";
										}
									?>
								</select>
							</div>
							<!-- Each item -->
							<div class="package-item-single">
								<select class="form-control wide" name="proposal_packages[3][price]" form="pricing-form">
									<option value="<?= $row_3->price; ?>" selected><?php if ($to == 'EGP'){ echo $to.' '; echo $row_3->price;}elseif($to == 'USD'){  echo $to.' '; echo round($cur_amount * $row_3->price);}else{  echo $s_currency; echo $row_3->price; } ?></option>
									<?php 
										foreach ($prices as $price) {
											if($to == 'USD'){
												$packg_price = round($cur_amount * $price);
											}else{
												$packg_price = $price;
											}
											if ($to == '') {
												$to = $s_currency;
											}
											$pkg_price = round($cur_amount * $row_3->price);
											echo "<option value='$price'>$to $packg_price</option>";
										}
									?>
								</select>
							</div>
							<!-- Each item -->
						</div>
						<!-- Package-item -->
					</form>
				</div>
				<!-- Packages body -->
				<?php if($row_2->description != '' or $row_3->description != ''){ ?>
				<div class="tryit-overlay d-flex flex-column justify-content-center align-items-center packages-active" id="overly-check" style="background-image: url(../assets/img/post-a-gig/tryit-bg.png);">
					<p>
						زود العائد الخاص بيك لما تضيف باقتين زيادة
					</p>
					<div class="d-flex flex-row justify-content-center">
						<button class="tryit-overlay-button" type="button" role="button">جربه دلوقتي</button>
					</div>
				</div>
				<?php }else{?>
				<div class="tryit-overlay d-flex flex-column justify-content-center align-items-center" style="background-image: url(../assets/img/post-a-gig/tryit-bg.png);">
					<p>
						زود العائد الخاص بيك لما تضيف باقتين زيادة
					</p>
					<div class="d-flex flex-row justify-content-center">
						<button class="tryit-overlay-button" type="button" role="button">جربه دلوقتي</button>
					</div>
				</div>
				<?php } ?>
				<!-- Try it overlay -->
			</div>
			<div class="form-group row add-attribute justify-content-center d-none">
			  <div class="col-md-7">
			    <div class="input-group">
			      <input class="form-control form-control-sm attribute-name" placeholder="أضف سمة جديدة" name="">
			      <button class="btn btn btn-success input-group-addon insert-attribute" >
			        <i class="fa fa-cloud-upload"></i> &nbsp;إدراج 
			      </button>
			    </div>
			  </div>
			</div>
			<!-- Package contaner end -->
			<div class="package-footer d-flex flex-column align-items-center">
				<div class="d-flex flex-row">
					<button type="submit" class="package-save" form="pricing-form">
						حفظ و استمرار
					</button>
				</div>
				<div class="d-flex flex-row align-items-center justify-content-center backbuton  back-to-overview">
					<span><i class="fal fa-long-arrow-right"></i></span>
					<span>
						الرجوع
					</span>
				</div>
			</div>
			<!-- Package footer -->
		</div>
	</div>
</section>
<!-- Packages end -->
<!-- End New Design -->


<!-- <table class="table table-bordered packages">
<thead>
<tr>
  <th></th>
  <th>Basic</th>
  <th>Standard</th>
  <th>Advance</th>
</tr>
</thead>
<tbody>
	<form action="#" method="post" class="pricing-form" id="pricing-form">
		<input type="hidden" name="proposal_packages[1][package_id]" form="pricing-form" value="<?= $row_1->package_id; ?>">
		<input type="hidden" name="proposal_packages[2][package_id]" form="pricing-form" value="<?= $row_2->package_id; ?>">
		<input type="hidden" name="proposal_packages[3][package_id]" form="pricing-form" value="<?= $row_3->package_id; ?>">

		<tr>
			<td>Description</td>
			<td class="p-0"><textarea maxlength="35" name="proposal_packages[1][description]" class="form-control" placeholder="Description"><?= $row_1->description; ?></textarea></td>
			<td class="p-0"><textarea maxlength="35" name="proposal_packages[2][description]" class="form-control" placeholder="Description"><?= $row_2->description; ?></textarea></td>
			<td class="p-0"><textarea maxlength="35" name="proposal_packages[3][description]" class="form-control" placeholder="Description"><?= $row_3->description; ?></textarea></td>
		</tr>
		<?php
		$i = 0;
		$get_a = $db->select("package_attributes",array("package_id"=>$row_1->package_id));
		while($row_a = $get_a->fetch()){
		$a_id = $row_a->attribute_id;
		$a_name = $row_a->attribute_name;
		$a_value = $row_a->attribute_value;
		$i++;
		?>
		<tr>
			<td> <?php echo $a_name; ?> </td>
			<td class="p-0"> 
			<input type="hidden" name="package_attributes[<?= $i; ?>][attribute_id]" form="pricing-form" value="<?= $a_id; ?>">
			<input type="text"name="package_attributes[<?= $i; ?>][attribute_value]" form="pricing-form" class="form-control" value="<?= $a_value; ?>"> 
			<i class="fa fa-trash delete-attribute" data-attribute="<?php echo $a_name; ?>"></i>
			</td>
			<?php
			$get_v = $db->query("select * from package_attributes where proposal_id='$proposal_id' and attribute_name='$a_name' and not attribute_id='$a_id'");
			while($row_v = $get_v->fetch()){
			$id = $row_v->attribute_id;
			$value = $row_v->attribute_value;
			$i++;
			?>
			<td class="p-0"> 
			<input type="hidden" name="package_attributes[<?= $i; ?>][attribute_id]" form="pricing-form" value="<?= $id; ?>">
			<input type="text"name="package_attributes[<?= $i; ?>][attribute_value]" form="pricing-form" class="form-control" value="<?= $value; ?>">
			<i class="fa fa-trash delete-attribute" data-attribute="<?php echo $a_name; ?>"></i>
			</td>
			<?php } ?>
		</tr>
		<?php } ?>

		<tr class="delivery-time">
			<td>Delivery Time</td>
			<td class="p-0">
			<select name="proposal_packages[1][delivery_time]" class="form-control">
			<?php
			$get_delivery_times = $db->select("delivery_times");
			while($row_delivery_times = $get_delivery_times->fetch()){
			$delivery_time = $row_delivery_times->delivery_proposal_title;
			echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_1->delivery_time ? "selected" : "").">$delivery_time</option>";
			}
			?>
			</select>
			</td>
			<td class="p-0">
			<select name="proposal_packages[2][delivery_time]" form="pricing-form" class="form-control">
			<?php
			$get_delivery_times = $db->select("delivery_times");
			while($row_delivery_times = $get_delivery_times->fetch()){
			$delivery_time = $row_delivery_times->delivery_proposal_title;
			echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_2->delivery_time ? "selected" : "").">$delivery_time</option>";
			}
			?>
			</select></td>
			<td class="p-0">
			<select name="proposal_packages[3][delivery_time]" form="pricing-form" class="form-control">
			<?php
			$get_delivery_times = $db->select("delivery_times");
			while($row_delivery_times = $get_delivery_times->fetch()){
			$delivery_time = $row_delivery_times->delivery_proposal_title;
			echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_3->delivery_time ? "selected" : "").">$delivery_time</option>";
			}
			?>
			</select>
			</td>
		</tr>

		<tr>
			<td>Revisions</td>
			<td class="p-0">
			<select name="proposal_packages[1][revisions]" form="pricing-form" class="form-control">
			<?php 
			foreach ($revisions as $rev) {
				echo "<option value='$rev'".($rev == $row_1->revisions ? "selected" : "").">$rev</option>";
			}
			?>
			</select>
			</td>
			<td class="p-0">
			<select name="proposal_packages[2][revisions]" form="pricing-form" class="form-control">
			<?php 
			foreach ($revisions as $rev) {
				echo "<option value='$rev'".($rev == $row_2->revisions ? "selected" : "").">$rev</option>";
			}
			?>
			</select>
			</td>
			<td class="p-0">
			<select name="proposal_packages[3][revisions]" form="pricing-form" class="form-control">
			<?php 
			foreach ($revisions as $rev) {
				echo "<option value='$rev'".($rev == $row_3->revisions ? "selected" : "").">$rev</option>";
			}
			?>
			</select>
			</td>
		</tr>

		<tr>
			<td>Price</td>
			<td class="p-0"> -->
			<!-- <select name="" class="form-control">
			<?php 
			foreach ($prices as $price) {
				echo "<option value='$price'".($price == $row_1->price ? "selected" : "").">$s_currency$price</option>";
			}
			?>
			</select> -->
			<!-- <input type="number" min='5' required name="proposal_packages[1][price]" form="pricing-form" value="<?= $row_1->price; ?>" class="form-control">
			</td>
			<td class="p-0"> -->
			<!-- <select name="proposal_packages[2][price]" class="form-control">
				<?php 
				foreach ($prices as $price) {
					echo "<option value='$price'".($price == $row_2->price ? "selected" : "").">$s_currency$price</option>";
				}
				?>
			</select> -->
			<!-- <input type="number" min='5' required name="proposal_packages[2][price]" form="pricing-form" value="<?= $row_2->price; ?>" class="form-control">
			</td>
			<td class="p-0"> -->
			<!-- <select name="proposal_packages[3][price]" class="form-control">
			<?php 
			foreach ($prices as $price) {
				echo "<option value='$price'".($price == $row_3->price ? "selected" : "").">$s_currency$price</option>";
			}
			?>  
			</select> -->
			<!-- <input type="number" min='5' required name="proposal_packages[3][price]" form="pricing-form" value="<?= $row_3->price; ?>" class="form-control">
			</td>
		</tr>
	</form>
</tbody>
</table> -->