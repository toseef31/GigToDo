<?php

require_once("includes/db.php");

if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;

}
if(isset($_POST["image"])){
	
	$data = $input->post("image");
	$name = $input->post("name");

	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);

	$data = base64_decode($image_array_2[1]);

	$imageName = pathinfo($name, PATHINFO_FILENAME). '.png';
	$allowed = array('jpeg','jpg','gif','tiff','png','webp');
	$file_extension = pathinfo($name, PATHINFO_EXTENSION);

	if(!in_array($file_extension,$allowed)){
		echo "";
	}else{
		 file_put_contents("portfolio_images/" . $imageName, $data);
	    echo $imageName;
	}
	$db->insert('seller_portfolio',array("seller_id"=>$login_seller_id,"portfolio_img"=>$imageName));
}

	// if(isset($_POST["image"]))
	// {
	// 	$data = $input->post("image");
	// 	$name = $input->post("name");

	//  $test = explode('.', $name);
	//  $ext = end($test);
	//  $name = rand(100, 999) . '.' . $ext;
	//  $location = 'portfolio_images/' . $name;  
	//  move_uploaded_file($_FILES["file"]["tmp_name"], $location);
	//  $insert_portfolio = $db->insert('seller_portfolio',array("seller_id"=>$login_seller_id,"portfolio_img"=>$name));
	// }

?>