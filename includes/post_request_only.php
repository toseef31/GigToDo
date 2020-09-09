<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
$allowedMethods = array(
    'POST'
);


$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);


if(!in_array($requestMethod, $allowedMethods)){
  
    // header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
    http_response_code(405);

    exit;
}
?>