<?php

session_start();

require_once("../includes/db.php");

// if(!isset($_SESSION['seller_user_name'])){
	
// echo "<script>window.open('../login','_self')</script>";
	
// }




$keyword = $input->post('keyword');
// print_r($keyword);

$s_value = $keyword;
$get_proposals = $db->query("select from proposals where proposal_title like :proposal_title AND proposal_status='active'",array(":proposal_title"=>$s_value));
	 print_r($get_proposals);
	
}

?>
