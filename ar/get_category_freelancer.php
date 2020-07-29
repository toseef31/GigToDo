<?php
session_start();

require_once("includes/db.php");
require_once("functions/functions.php");
// if(!isset($_SESSION['seller_user_name'])){
	
// echo "<script>window.open('login','_self')</script>";
	
// }
$cat_id = $input->post('cat_id');
?>
	<?php 

		$get_proposal = $db->query("select DISTINCT proposal_seller_id from  proposals where proposal_cat_id=$cat_id and proposal_status='active'");
		while($row_proposal = $get_proposal->fetch()){
		$proposal_seller_id = $row_proposal->proposal_seller_id;
	
		// if(!empty($where_path)){
		
		$query = "select * from sellers where seller_id=$proposal_seller_id";
		$sellers = $db->query($query,$values);
	// }else{
	// 	$query = "select DISTINCT sellers.* from sellers JOIN proposals ON sellers.seller_id=proposals.proposal_seller_id and proposals.proposal_status='active' $where_limit";
	// 	$sellers = $db->query($query);
	// }
		
	$sellersCount = 0;
	$seller = $sellers->fetch();

		$sellersCount++;
		$seller_id = $seller->seller_id;
		$seller_user_name = $seller->seller_user_name;
		$seller_name = $seller->seller_name;
		$seller_headline = $seller->seller_headline;
		$seller_about = $seller->seller_about;
		$seller_image = $seller->seller_image;
		$seller_email = $seller->seller_email;
		$seller_level = $seller->seller_level;
		$seller_register_date = $seller->seller_register_date;
		$seller_recent_delivery = $seller->seller_recent_delivery;
		$seller_country = $seller->seller_country;
		$seller_status = $seller->seller_status;
		$occuption = $seller->occuption;
		$level_title = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;

		$select_buyer_reviews = $db->select("buyer_reviews",array("review_seller_id"=>$seller_id)); 
		$count_reviews = $select_buyer_reviews->rowCount();
		if(!$count_reviews == 0){
		  $rattings = array();
		  while($row_buyer_reviews = $select_buyer_reviews->fetch()){
		    $buyer_rating = $row_buyer_reviews->buyer_rating;
		    array_push($rattings,$buyer_rating);
		  }
		  $total = array_sum($rattings);
		  @$average = $total/count($rattings);
		  $average_rating = substr($average ,0,1);
		}else{
		 $average = "0";  
		 $average_rating = "0";
		}
		
	?>
	<div class="col-12 col-sm-6 col-md-4">
	  <div class="search-results-card d-flex flex-column align-items-center">
	    <div class="user-image">
	    	<?php if(!empty($seller_image)){ ?>
	    	<img src="<?= $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="100" class="rounded-circle img-fluid d-block">
	    	<?php }else{ ?>
	    	<img class="img-fluid d-block" src="<?= $site_url; ?>/user_images/empty-image.png" />
	    	<?php } ?>
	    </div>
	    
	    <div class="user-name d-flex flex-row align-items-center <?php if(check_status($seller_id) == 'Online'){ echo "online";} ?>"><?php echo $seller_user_name; ?></div>
	    <div class="locatons-categories d-flex flex-wrap align-items-center">
	      <div class="search-results-card-categories d-flex flex-row align-items-center">
	        <span>
	          <img alt="User Icon" class="img-fluid d-block" src="assets/img/search/user-icon.png" />
	        </span>
	        <span><?= $occuption ?></span>
	      </div>
	      <div class="search-results-card-locations d-flex flex-row align-items-center">
	        <span>
	          <img alt="Map Marker Icon" class="img-fluid d-block" src="assets/img/search/map-marker-icon.png" />
	        </span>
	        <span><?php echo $seller_country; ?></span>
	      </div>
	    </div>
	    <div class="search-results-profile-ratings d-flex flex-row align-items-center justify-content-center">
	    	<?php
	    	for($seller_i=0; $seller_i<$average_rating; $seller_i++){
	    	  echo " <span><i class='fa fa-star' style='color: #ffa320;'></i></span> ";
	    	}
	    	for($seller_i=$average_rating; $seller_i<5; $seller_i++){
	    	  echo " <span><i class='fa fa-star-o'></i></span> ";
	    	}
	    	?>
	    	<!-- <h4 class="mb-1"><?php printf("%.1f", $average); ?>/<small class="text-muted font-weight-normal">5</small></h4>
	    	<a>(<?php echo $count_reviews; ?> Reviews)</a> -->
	    </div>
	    <div class="search-results-card-action d-flex flex-row align-items-center justify-content-center">
	      <a class="d-flex flex-row align-items-center justify-content-center view-button" href="<?php echo $seller_user_name; ?>">اعرض الصفحة</a>
	    </div>
	  </div>
	</div>
	<!-- Each item -->
<?php  }?>