<?php

session_start();

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}

$education_id = $input->post('edit_edu');
// print_r($education_id);die();

$get_seller_education = $db->select("seller_education",array("education_id" => $education_id));
while($row_seller_education = $get_seller_education->fetch()){
  $education_id = $row_seller_education->education_id;
$education = @json_decode($row_seller_education->education_data);
	
}

?>