<?php
	@session_start();
	require_once "includes/db.php";
	require_once "GoogleAPI/vendor/autoload.php";
	// $gClient = new Google_Client();
	// $gClient->setClientId($l_client_id);
	// $gClient->setClientSecret($l_client_secret);
	// $gClient->setApplicationName("");
	// $gClient->setRedirectUri("$site_url/l-callback");
	// $gClient->addScope("r_liteprofile r_emailaddress");


	
	define("CLIENT_ID", $l_client_id);
	define("CLIENT_SECRET", $l_client_secret);
	define("REDIRECT_URI", "$site_url/l-callback");
	define("SCOPE", 'r_basicprofile r_emailaddress' );
	
