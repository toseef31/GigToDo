<?php
	@session_start();
	require_once "includes/db.php";
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId($l_client_id);
	$gClient->setClientSecret($l_client_secret);
	$gClient->setApplicationName("");
	$gClient->setRedirectUri("$site_url/l-callback");
	$gClient->addScope("r_basicprofile r_emailaddress");


	
	define("LINKEDIN_API_KEY_PUBLIC", "81bs1pptuhmwx3");
	define("LINKEDIN_API_KEY_PRIVATE", "ckrk9NKdttlVayRS");
	define("REDIRECT_URI", "$site_url/l-callback");
	define("SCOPE", 'r_basicprofile r_emailaddress' );
	
