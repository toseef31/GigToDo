<?php
	
	if($videoPlugin == 1){
		$proposal_videosettings =  $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
		$enableVideo = $proposal_videosettings->enable;
	}else{
		$enableVideo = 0;
	}
	if(isset($_SESSION['currency'])){
		$to = $_SESSION['currency'];
	}
	$cur_amount = currencyConverter($to,1);
// print_r($cur_amount.'opyyyyy aa na zraa');
?>


<div class="single-gigs mt-30 all-gigs">
	<div class="gigs-image verified-rebon">
		<a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>">
			<img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" class="img-fluid" alt="Gigs Image" height="200px" width="286px">
		</a>
	</div>
	<div class="gigs-content">
		<div class="gigs-author d-flex align-items-center">
			<div class="author-image">
				<img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" alt="" height="50px" width="50px">
				<?php if(check_status($proposal_seller_id) == "Online"){ ?>
					<span class="active"></span>
				<?php } ?>
			</div>
			<div class="author-name media-body">
				<a href="<?= $site_url; ?>/<?= $seller_user_name; ?>" style="color: #353535;"><?= $seller_user_name; ?></a>
			</div>
		</div>

		<?php 
		  $string = strip_tags($proposal_title);
		  if (strlen($string) > 50) {

		      // truncate string
		      $stringCut = substr($string, 0, 48);
		      $endPoint = strrpos($stringCut, ' ');

		      //if the string doesn't contain any space then it will cut without word basis.
		      $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
		      $string .= '....';
		  }
		  // echo $string;

		?>
		<h4 class="gigs-title"><a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>"><?= $string; ?></a></h4>
		<ul class="gigs-rating d-flex">
			<svg class="fit-svg-icon full_star" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"></path></svg>
			<span><strong><?php if($proposal_rating == "0"){ echo "0.0"; }else{ printf("%.1f", $average_rating); } ?></strong>
		(<?= $count_reviews; ?>)</span>
		</ul>
	</div>
	<div class="gigs-meta d-flex justify-content-between align-items-center">
		<div class="meta-left">
			<?php if(isset($_SESSION['seller_user_name'])){ ?>
			<?php if($proposal_seller_id != $login_seller_id){ ?>
			<a href="javascript:void(0);"><i data-id="<?= $proposal_id; ?>" href="#" class="fa fa-heart <?= $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorite"></i></a>
			<?php } ?>
			<?php }else{ ?>
				<a href="<?= $site_url; ?>/ar/login.php"><i class="fa fa-heart"></i></a>
			<?php } ?>
		</div>
		<div class="meta-right">
			<?php if($to == 'EGP'){ ?>
        <span>
          <?= $to; ?> <?= $proposal_price; ?>
        </span>
      <?php } elseif($to == 'USD'){ ?>
        <span><?= $to; ?> <?= round($cur_amount * $proposal_price,2) ?></span>
      <?php
        }else{?>
        	<span><?= $s_currency; ?> <?= $proposal_price; ?></span>
        <?php }
      ?>
		</div>
	</div>
</div>
<!-- <div class="proposal-card-base mp-proposal-card"> -->
	<!--- proposal-card-base mp-proposal-card Starts --->
	<!-- <a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>">
		<img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" class="img-fluid">
	</a>
	<div class="proposal-card-caption"> -->
		<!--- proposal-card-caption Starts --->
		<!-- <div class="proposal-seller-info"> -->
			<!--- gig-seller-info Starts --->
		<!-- <span class="fit-avatar s24">
			<img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" class="rounded-circle" width="32" height="32">
		</span>
		<div class="seller-info-wrapper">
	    <a href="<?= $site_url; ?>/<?= $seller_user_name; ?>" class="seller-name"><?= $seller_user_name; ?></a>
	    <div class="gig-seller-tooltip">
	    	<?= $seller_level; ?>
	    </div>
		</div>
		</div> -->
		<!--- gig-seller-info Ends --->
		<!-- <a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>" class="proposal-link-main js-proposal-card-imp-data">
		<h3><?= $proposal_title; ?></h3>
		</a>
		<div class="rating-badges-container">
		<span class="proposal-rating">
		<svg class="fit-svg-icon full_star" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"></path></svg>
		<span>
		<strong><?php if($proposal_rating == "0"){ echo "0.0"; }else{ printf("%.1f", $average_rating); } ?></strong>
		(<?= $count_reviews; ?>)
		</span>
		</span>
		</div>
		<?php if(check_status($proposal_seller_id) == "Online"){ ?>
		<div class="is-online float-right">
		<i class="fa fa-circle"></i> <?= $lang['proposals']['online']; ?>
		</div>
		<?php } ?>
	</div> -->
	<!--- proposal-card-caption Ends --->
	<!-- <footer class="proposal-card-footer"> -->
		<!--- proposal-card-footer Starts --->
		<!-- <div class="proposal-fav">
			<?php if($proposal_enable_referrals == "yes" & $enable_referrals == "yes"){ ?>
			<?php if(isset($_SESSION['seller_user_name'])){ ?>
			<?php if($proposal_seller_id != $login_seller_id){ ?>
			<a class="icn-list proposal-offer" data-id="<?= $proposal_id; ?>">
			<?php require("$dir/images/affiliate.svg"); ?>
			</a>
			<?php } ?>
			<?php }else{ ?>
			<a class="icn-list" data-toggle="modal" data-target="#login-modal">
			<?php require("$dir/images/affiliate.svg"); ?>
			</a>
			<?php } ?>
			<?php } ?>
			
			<?php if($enableVideo == 1){ ?>
				<a class="icn-list" data-toggle="tooltip" data-placement="top" title="This proposal allows video sessions">
				<?php require("$dir/images/camera.svg"); ?>
				</a>
			<?php } ?>

			<?php if(isset($_SESSION['seller_user_name'])){ ?>
			<?php if($proposal_seller_id != $login_seller_id){ ?>
			<i data-id="<?= $proposal_id; ?>" href="#" class="fa fa-heart <?= $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorite"></i>
			<?php } ?>
			<?php }else{ ?>
			<a href="#" data-toggle="modal" data-target="#login-modal">
				<i class="fa fa-heart dil1" data-toggle="tooltip" data-placement="top" title="Favorite"></i>
			</a>
			<?php } ?>
		</div>
		<div class="proposal-price">
			<a><small><?= $lang['proposals']['starting_at']; ?></small><?= $s_currency; ?><?= $proposal_price; ?></a>
		</div>
	</footer> -->
	<!--- proposal-card-footer Ends --->
<!-- </div> -->
<!--- proposal-card-base mp-proposal-card Ends --->