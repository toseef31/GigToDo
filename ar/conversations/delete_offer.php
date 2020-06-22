<?php

session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}

if(isset($_GET['offer_id'])){
	

$offer_id = $input->get('offer_id');

$select_offer = $db->select("inbox_messages",array("message_offer_id" => $offer_id));	
$row_offer = $select_offer->fetch();

$get_message_id = $row_offer->message_group_id;

$get_message = $row_offer->message_id;

$last_message = ($get_message - 1);


$delete_offer = $db->delete("messages_offers",array("offer_id"=>$offer_id)); 
	
if($delete_offer->rowCount() == 1){

$delete_offers_msg = $db->delete("inbox_messages",array('message_offer_id' => $offer_id)); 
	
echo "<script>alert('Your offer has been Withdrawn successfully.');</script>";
	
	$insert_id = $db->update("inbox_sellers",array("message_id" => $last_message),array("message_group_id" => $get_message_id));
echo "<script>window.open('inbox?single_message_id=$get_message_id','_self')</script>";
	
}else{ echo "<script>window.open('inbox?single_message_id=$get_message_id','_self');</script>"; }


}

?>