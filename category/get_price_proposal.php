<?php

session_start();

require_once("../includes/db.php");

// if(!isset($_SESSION['seller_user_name'])){
	
// echo "<script>window.open('../login','_self')</script>";
	
// }


global $input;
global $siteLanguage;
global $dir;
global $db;
global $enable_referrals;
global $lang;
global $s_currency;
global $login_seller_id;
global $videoPlugin;
global $site_url;
global $dir;
$online_sellers = array();

$price = $input->post('price');
// echo $price;
print_r($price);
$s_value = $price;
$get_proposal_price = $db->select("proposals", array("proposal_status"=>'active'));
print_r($get_proposals);
// if(isset($_SESSION['cat_id'])){
// $session_cat_id = $_SESSION['cat_id'];

// $get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_cat_id=:cat_id AND proposal_price=:proposal_price AND proposal_status='active'",array("cat_id"=>$session_cat_id,"proposal_price"=>$price));
// }elseif(isset($_SESSION['cat_child_id'])){
// $session_cat_child_id = $_SESSION['cat_child_id'];
// $get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_child_id=:child_id AND proposal_price=:proposal_price AND proposal_status='active'",array("child_id"=>$session_cat_child_id,"proposal_price"=>$price));
// }
// $get_proposals = $db->select("proposals",array("proposal_title"=>$keyword,"proposal_status"=>'active'));;
// print_r($get_proposals);
while($row_proposal_price = $get_proposal_price->fetch()){
	print_r($row_proposal_price);
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
	$seller_status = $select_seller->fetch()->seller_status;
	if(check_status($proposal_seller_id) == "Online"){
	array_push($online_sellers,$proposal_seller_id);
	}
	print_r($seller_status);die();
}
	$where_online = array();
	$where_delivery_times = array();
	$where_level = array();
	$where_language = array();
	if(isset($_REQUEST['online_sellers'])){
		$i = 0;
		foreach($_REQUEST['online_sellers'] as $value){
			if($value != 0){
				foreach($online_sellers as $seller_id){
					$i++;
					$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";
					$values["proposal_seller_id_$i"] = $seller_id;
				}
			}
		}
	}
	if(isset($_REQUEST['delivery_time'])){
			$i = 0;
		foreach($_REQUEST['delivery_time'] as $value){
			$i++;
			if($value != 0){
				$where_delivery_times[] = "delivery_id=:delivery_id_$i";
				$values["delivery_id_$i"] = $value;
			}
		}
	}
	if(isset($_REQUEST['seller_level'])){
		$i = 0;
		foreach($_REQUEST['seller_level'] as $value){
			$i++;
			if($value != 0){
				$where_level[] = "level_id=:level_id_$i";
				$values["level_id_$i"] = $value;
			}
		}
	}
	if(isset($_REQUEST['seller_language'])){
		$i = 0;
		foreach($_REQUEST['seller_language'] as $value){
			$i++;
			if($value != 0){
				$where_language[] = "language_id=:language_id_$i";
				$values["language_id_$i"] = $value;
			}
		}
	}
	if(isset($_SESSION['cat_id'])){
	$query_where = "where proposal_cat_id=:cat_id AND proposal_status='active' ";
	}elseif(isset($_SESSION['cat_child_id'])){
	$query_where = "where proposal_child_id=:child_id AND proposal_status='active' ";
	}
	if(isset($_SESSION['cat_id'])){
	$values['cat_id'] = $session_cat_id;
	}elseif(isset($_SESSION['cat_child_id'])){
	$values['child_id'] = $session_cat_child_id;
	}
	if(count($where_online)>0){
		$query_where .= " and (" . implode(" or ",$where_online) . ")";
	}
	if(count($where_delivery_times)>0){
		$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	}
	if(count($where_level)>0){
		$query_where .= " and (" . implode(" or ",$where_level) . ")";
	}
	if(count($where_language)>0){
		$query_where .= " and (" . implode(" or ",$where_language) . ")";
	}
	$per_page = 16;
	if(isset($_GET['page'])){
		$page = $input->get('page');
	}else{
		$page = 1;
	}
	$start_from = ($page-1) * $per_page;
	$where_limit = " order by proposal_featured='yes' DESC LIMIT :limit OFFSET :offset";
	$get_proposals = $db->query("select * from proposals " . $query_where . $where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));
	$count_proposals = $get_proposals->rowCount();
	if($count_proposals == 0){
		
		echo "
		<div class='col-md-12'>
		<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> No proposals/services to Show in this Category Yet. </h1>
		</div>";
		
	}
	while($row_proposals = $get_proposals->fetch()){
		
	$proposal_id = $row_proposals->proposal_id;
	$proposal_title = $row_proposals->proposal_title;
	$proposal_price = $row_proposals->proposal_price;
	if($proposal_price == 0){
	$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic", "price"=>$price));
	$proposal_price = $get_p_1->fetch()->price;
	}
	$proposal_img1 = $row_proposals->proposal_img1;
	$proposal_video = $row_proposals->proposal_video;
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	$proposal_rating = $row_proposals->proposal_rating;
	$proposal_url = $row_proposals->proposal_url;
	$proposal_featured = $row_proposals->proposal_featured;
	$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;
	$proposal_referral_money = $row_proposals->proposal_referral_money;
	if(empty($proposal_video)){
		$video_class = "";
	}else{
		$video_class = "video-img";
	}
	$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
	$row_seller = $get_seller->fetch();
	$seller_user_name = $row_seller->seller_user_name;
	$seller_image = $row_seller->seller_image;
	$seller_level = $row_seller->seller_level;
	$seller_status = $row_seller->seller_status;
	if(empty($seller_image)){
	$seller_image = "empty-image.png";
	}
	// Select Proposal Seller Level
	@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
	$proposal_reviews = array();
	$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
	$count_reviews = $select_buyer_reviews->rowCount();
	while($row_buyer_reviews = $select_buyer_reviews->fetch()){
		$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
		array_push($proposal_reviews,$proposal_buyer_rating);
	}
	$total = array_sum($proposal_reviews);
	@$average_rating = $total/count($proposal_reviews);
	$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
	if($count_favorites == 0){
	$show_favorite_class = "proposal-favorite dil1";
	}else{
	$show_favorite_class = "proposal-unfavorite dil";
	}
	?>
	<div class="col-lg-4 col-sm-6">
	<?php require("../includes/proposals.php"); ?>
	</div>
	<?php	
	}
	


?>
