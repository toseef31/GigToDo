<?php
	if (empty($_GET["action"])) {
	    require_once 'l-config.php';
	    require ('Linkedin/http.php');
	    require ('Linkedin/oauth_client.php');
	    
	    if ($_GET["oauth_problem"] != "") {
	        $error1 = $_GET["oauth_problem"];
	    }
	    
	    $client = new oauth_client_class();
	    
	    $client->debug = false;
	    $client->debug_http = true;
	    $client->redirect_uri = REDIRECT_URI;
	    $client->server = "LinkedIn";
	    $client->client_id = CLIENT_ID;
	    $client->client_secret = CLIENT_SECRET;
	    $client->scope = SCOPE;
	    
	    if (($success = $client->Initialize())) {
	        if (($success = $client->Process())) {
	            if (strlen($client->authorization_error)) {
	                $client->error = $client->authorization_error;
	                $success = false;
	            } elseif (strlen($client->access_token)) {
	                $success = $client->CallAPI('http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,picture-url,public-profile-url,formatted-name)', 'GET', array(
	                    'format' => 'json'
	                ), array(
	                    'FailOnAccessError' => true
	                ), $user);
	            }
	        }
	        $success = $client->Finalize($success);
	        $_SESSION["member_id"] = $user->id;
	    }
	    if ($client->exit) {
	        exit();
	    }
	    if ($success) {
	        // Do your code with the Linkedin Data
	    } else {
	        $error = $client->error;
	    }
	} else {
	    $_SESSION = array();
	    unset($_SESSION);
	    session_destroy();
	}
?>