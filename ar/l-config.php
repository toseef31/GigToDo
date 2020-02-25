<?php
	@session_start();
	require_once "includes/db.php";
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId($g_client_id);
	$gClient->setClientSecret($g_client_secret);
	$gClient->setApplicationName("");
	$gClient->setRedirectUri("$site_url/l-callback");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");


	
	define("LINKEDIN_API_KEY_PUBLIC", "81bs1pptuhmwx3");
	define("LINKEDIN_API_KEY_PRIVATE", "ckrk9NKdttlVayRS");
	define("REDIRECT_URI", "$site_url/l-callback");
	define("SCOPE", 'r_basicprofile r_emailaddress' );
	
