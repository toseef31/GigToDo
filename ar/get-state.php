<?php
require_once("includes/db.php");


if (! empty($_POST["country_name"])) {
    
    $country_name = $input->post("country_name");
    $get_country = $db->select("countries", array("name" => $country_name));
    $countryId = $get_country->fetch()->id;
    // print_r($countryId);

    
     $get_state = $db->select("states", array("country_id" => $countryId));
     
   
    ?>
<option value="">اختر ولايه </option>
<?php
   while($state_row = $get_state->fetch()){
        ?>
<option value="<?= $state_row->name ?>"><?= $state_row->name ?></option>
<?php
    }
}
?>