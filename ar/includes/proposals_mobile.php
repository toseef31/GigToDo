<?php
	
	if($videoPlugin == 1){
		$proposal_videosettings =  $db->select("proposal_videosettings",array('proposal_id'=>$proposal_id))->fetch();
		$enableVideo = $proposal_videosettings->enable;
	}else{
		$enableVideo = 0;
	}

?>

<div class="col-12">
  <div class="small-gigs-item d-flex flex-column">
    <div class="small-gigs-item-header d-flex justify-content-between">
      <div class="small-gigs-image">
      	<a href="<?= $site_url; ?>/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>">
        	<img class="img-fluid d-block" src="<?= $site_url; ?>/proposals/proposal_files/<?= $proposal_img1; ?>" width="100" height="109"/>
        </a>
      </div>
      <div class="small-gigs-content d-flex justify-content-between">
        <div class="content d-flex flex-column justify-content-between">
          <h3 class="title">

            <?php 
              $string = strip_tags($proposal_title);
              if (strlen($string) > 35) {

                  // truncate string
                  $stringCut = substr($string, 0, 34);
                  $endPoint = strrpos($stringCut, ' ');

                  //if the string doesn't contain any space then it will cut without word basis.
                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                  $string .= '....';
              }
              // echo $string;

            ?>
            <a href="<?= $site_url; ?>/ar/proposals/<?= $seller_user_name; ?>/<?= $proposal_url; ?>"><?= $string; ?></a>
          </h3>
          <div class="rating d-flex flex-row align-items-center">
          		<svg class="fit-svg-icon full_star" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"></path></svg>
          		<span><strong><?php if($proposal_rating == "0"){ echo "0.0"; }else{ printf("%.1f", $average_rating); } ?></strong>
          	(<?= $count_reviews; ?>)</span>
            <!-- <span><i class="fas fa-star"></i></span>
            <span>4.8</span>
            <span>(1k+)</span> -->
          </div>
        </div>
        <div class="icon d-flex flex-column align-items-end justify-content-between">
          <?php if(isset($_SESSION['seller_user_name'])){ ?>
          <?php if($proposal_seller_id != $login_seller_id){ ?>
          <a href="javascript:void(0);"><i data-id="<?= $proposal_id; ?>" href="#" class="fas fa-heart <?= $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorite"></i></a>
          <?php }else{ ?>
          <a href="javascript:void(0);"><i class="fa fa-heart"></i></a>
          <?php }}else{ ?>
          	<a href="<?= $site_url; ?>/ar/login.php"><i class="fas fa-heart"></i></a>
          <?php } ?>
          <div class="verified-tag">Verified</div>
        </div>
      </div>
    </div>
    <div class="small-gigs-item-footer d-flex flex-row justify-content-between align-items-center">
      <div class="small-gigs-seller d-flex flex-row align-items-center">
        <div class="user-image">
          <img class="img-fluid d-block" src="<?= $site_url; ?>/user_images/<?= $seller_image; ?>" />
        </div>
        <div class="user-name"><a href="<?= $site_url; ?>/ar/<?= $seller_user_name; ?>" style="color: #353535;"><?= $seller_user_name; ?></a></div>
      </div>
      <div class="small-gigs-pricing d-flex flex-row">
        <a href="javascript:void(0);"><?= $s_currency; ?><?= $proposal_price; ?></a>
      </div>
    </div>
  </div>
</div>
