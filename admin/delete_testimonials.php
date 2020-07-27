<?php

@session_start();

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self');</script>";

}else{


?>

<?php

if(isset($_GET['delete_testimonial'])){

$testimonial_id = $input->get('delete_testimonial');


$delete_testimonial = $db->delete("testimonials",array('testimonial_id' => $testimonial_id));	

if($delete_testimonial){

$insert_log = $db->insert_log($admin_id,"testimonial",$testimonial_id,"deleted");


echo "<script>alert('One testimonial has been deleted successfully.');</script>";

echo "<script>window.open('index?view_testimonials','_self');</script>";

}


}

?>

<?php } ?>
