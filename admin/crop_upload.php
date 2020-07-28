<?php

// require_once("includes/db.php");

if(isset($_POST["image"])){
	
	$image = $_FILES['image']['name'];
	$image_tmp = $_FILES['image']['tmp_name'];
	$image_extension = pathinfo($image, PATHINFO_EXTENSION);
	$allowed = array('jpeg','jpg','gif','png','tif','ico','webp');

	if(!in_array($image_extension,$allowed)){
	echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
	}else{

	if(!empty($image)){
	  $image = pathinfo($image, PATHINFO_FILENAME);
	  $image = $image."".time().".$image_extension";
	  move_uploaded_file($image_tmp, "../testimonial/testimonial_images/$image");
	}
	}

}

?>