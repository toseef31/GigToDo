<?php
require_once("includes/db.php");


if (! empty($_POST["state_name"])) {
    
    $state_name = $input->post("state_name");
    $get_state = $db->select("states", array("name" => $state_name));
    $stateId = $get_state->fetch()->id;
    // print_r($stateId);die();

    
    $get_city = $db->select("cities", array("state_id" => $stateId));
   	
    ?>
<option value="">اختر مدينة </option>
<?php
   while($city_row = $get_city->fetch()){
        ?>
<option value="<?= $city_row->name ?>"><?= $city_row->name ?></option>
<?php
    }
}
?>