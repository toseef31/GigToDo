<?php
	
	if($videoPlugin == 1){
		$proposal_videosettings =  $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
		$enableVideo = $proposal_videosettings->enable;
	}else{
		$enableVideo = 0;
	}

?>

<div class="product-single-item">
  <div class="product-img">
    <div class="verified">
      <img src="assets/img/verifired.png" alt="">
    </div>
    <a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>">
    	<img src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" alt="">
    </a>
  </div>
  <div class="product-text">
    <div class="product-author">
      <img src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" alt="">
      <span><a href="<?= $site_url; ?>/ar/<?= $seller_user_name; ?>" style="color: #434343;"><?= $seller_user_name; ?></a></span>
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
    <h5><a href="<?= $site_url; ?>/ar/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>" style="color: #383838;"><?= $string; ?></a></h5>
    <div class="rating">
      <svg class="fit-svg-icon full_star" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"></path></svg>
			<span class="star-count"><strong><?php if($proposal_rating == "0"){ echo "0.0"; }else{ printf("%.1f", $average_rating); } ?></strong>
      		(<?= $count_reviews; ?>)</span>
      <!-- <span class="star-count">(25)</span> -->
    </div>
    <div class="product-price">
      <?php if(isset($_SESSION['seller_user_name'])){ ?>
			<?php if($proposal_seller_id != $login_seller_id){ ?>
			<a href="javascript:void(0);"><i data-id="<?= $proposal_id; ?>" href="#" class="fas fa-heart <?= $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorite"></i></a>
			<?php }else{ ?>
			<a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
			<?php }}else{ ?>
				<a href="<?= $site_url; ?>/login.php"><i class="fa fa-heart"></i></a>
			<?php } ?>
      <span><?= $s_currency; ?><?= $proposal_price; ?></span>
    </div>
  </div>
</div>