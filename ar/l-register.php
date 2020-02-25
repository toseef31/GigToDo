<?php
session_start();
require_once("includes/db.php");
require_once("social-config.php");
require_once ('Linkedin/linkedinoauth.php');
if(isset($_SESSION['seller_user_name'])){
	echo "<script> window.open('index','_self'); </script>";
}
if(!isset($_SESSION['access_token'])) {
	echo "<script> window.open('index','_self'); </script>";
	exit();
}
function getRealUserIp(){
  //This is to check ip from shared internet network
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}
$ip = getRealUserIp();

$email = $_SESSION['email'];
$where = array("seller_email" => $email);
$get_seller_email = $db->select("sellers",$where);
$check_seller_email = $get_seller_email->rowCount();
if($check_seller_email > 0){
	$row_seller_email = $get_seller_email->fetch();
	$u_name = $row_seller_email->seller_user_name;
	$_SESSION['seller_user_name']=$u_name;
	unset($_SESSION['givenName']);
	unset($_SESSION['picture']);
	unset($_SESSION['email']);
	unset($_SESSION['access_token']);
	if($db->update("sellers",array("seller_status"=>'online',"seller_ip"=>$ip),$where)){
		echo "<script> window.open('index.php','_self'); </script>";
		exit();
	}
}
?>



<?php

/**
 * An example of how to handle the user authorization process for requesting accessing to a LinkedIn
 * account through oAuth. It displays a simple UI, storing the needed state in session variables. 
 * For a real app, you'll probably want to keep them in your database, but this arrangement makes the
 * example simpler.
 *
 * To install this example, just copy all the files in this folder onto your web server, edit config.php
 * to add the oAuth tokens you've obtained from LinkedIn and then load this index page in your browser.
 
 Licensed under the 2-clause (ie no advertising requirement) BSD license,
 making it easy to reuse for commercial or GPL projects:
 
 (c) Pete Warden <pete@petewarden.com> http://petewarden.typepad.com/ - Mar 21st 2010
 
 Redistribution and use in source and binary forms, with or without modification, are
 permitted provided that the following conditions are met:
   1. Redistributions of source code must retain the above copyright notice, this 
      list of conditions and the following disclaimer.
   2. Redistributions in binary form must reproduce the above copyright notice, this 
      list of conditions and the following disclaimer in the documentation and/or 
      other materials provided with the distribution.
   3. The name of the author may not be used to endorse or promote products derived 
      from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, 
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR 
PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY
OF SUCH DAMAGE.
 
 */




// Returns information about the oAuth state for the current user. This includes whether the process
// has been started, if we're waiting for the user to complete the authorization page on the remote
// server, or if the user has authorized us and if so the access keys we need for the API.
// If no oAuth process has been started yet, null is returned and it's up to the client to kick it off
// and set the new information.
// This is all currently stored in session variables, but for real applications you'll probably want
// to move it into your database instead.
//
// The oAuth state is made up of the following members:
//
// request_token: The public part of the token we generated for the authorization request.
// request_token_secret: The secret part of the authorization token we generated.
// access_token: The public part of the token granting us access. Initially ''. 
// access_token_secret: The secret part of the access token. Initially ''.
// state: Where we are in the authorization process. Initially 'start', 'done' once we have access.

function get_linkedin_oauth_state()
{
    if (empty($_SESSION['linkedinoauthstate']))
        return null;
        
    $result = $_SESSION['linkedinoauthstate'];

    error_log("Found state ".print_r($result, true));

    return $result;
}

// Updates the information about the user's progress through the oAuth process.
function set_linkedin_oauth_state($state)
{
    error_log("Setting OAuth state to - ".print_r($state, true));

    $_SESSION['linkedinoauthstate'] = $state;
}

// Returns an authenticated object you can use to access the LinkedIn API
function get_linkedin_oauth_accessor()
{
    $oauthstate = get_linkedin_oauth_state();
    if ($oauthstate===null)
        return null;
    
    $accesstoken = $oauthstate['access_token'];
    $accesstokensecret = $oauthstate['access_token_secret'];

    $to = new LinkedInOAuth(
        LINKEDIN_API_KEY_PUBLIC, 
        LINKEDIN_API_KEY_PRIVATE,
        $accesstoken,
        $accesstokensecret
    );

    return $to;
}

// Returns the current page's full URL. From http://blog.taragana.com/index.php/archive/how-to-find-the-full-url-of-the-page-in-php-in-a-platform-independent-and-configuration-independent-way/
function get_current_url()
{
	$result = 'http';
	$script_name = "";
	if(isset($_SERVER['REQUEST_URI'])) 
	{
		$script_name = $_SERVER['REQUEST_URI'];
	} 
	else 
	{
		$script_name = $_SERVER['PHP_SELF'];
		if($_SERVER['QUERY_STRING']>' ') 
		{
			$script_name .=  '?'.$_SERVER['QUERY_STRING'];
		}
	}
	
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') 
	{
		$result .=  's';
	}
	$result .=  '://';
	
	if($_SERVER['SERVER_PORT']!='80')  
	{
		$result .= $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'].$script_name;
	} 
	else 
	{
		$result .=  $_SERVER['HTTP_HOST'].$script_name;
	}

	return $result;
}

// Deals with the workflow of oAuth user authorization. At the start, there's no oAuth information and
// so it will display a link to the LinkedIn site. If the user visits that link they can authorize us,
// and then they should be redirected back to this page. There should be some access tokens passed back
// when they're redirected, we extract and store them, and then try to call the LinkedIn API using them.
function handle_linkedin_oauth()
{
	$oauthstate = get_linkedin_oauth_state();
    
    // If there's no oAuth state stored at all, then we need to initialize one with our request
    // information, ready to create a request URL.
	if (!isset($oauthstate))
	{
		error_log("No OAuth state found");

		$to = new LinkedInOAuth(LINKEDIN_API_KEY_PUBLIC, LINKEDIN_API_KEY_PRIVATE);
		
        // This call can be unreliable for some providers if their servers are under a heavy load, so
        // retry it with an increasing amount of back-off if there's a problem.
		$maxretrycount = 1;
		$retrycount = 0;
		while ($retrycount<$maxretrycount)
		{		
			$tok = $to->getRequestToken();
			if (isset($tok['oauth_token'])&&
				isset($tok['oauth_token_secret']))
				break;
			
			$retrycount += 1;
			sleep($retrycount*5);
		}
		
		$tokenpublic = $tok['oauth_token'];
		$tokenprivate = $tok['oauth_token_secret'];
		$state = 'start';
		
        // Create a new set of information, initially just containing the keys we need to make
        // the request.
		$oauthstate = array(
			'request_token' => $tokenpublic,
			'request_token_secret' => $tokenprivate,
			'access_token' => '',
			'access_token_secret' => '',
			'state' => $state,
		);

		set_linkedin_oauth_state($oauthstate);
	}

    // If there's an 'oauth_token' in the URL parameters passed into us, and we don't already
    // have access tokens stored, this is the user being returned from the authorization page.
    // Retrieve the access tokens and store them, and set the state to 'done'.
	if (isset($_REQUEST['oauth_token'])&&
		($oauthstate['access_token']==''))
	{
        error_log('$_REQUEST: '.print_r($_REQUEST, true));
    
		$urlaccesstoken = $_REQUEST['oauth_token'];
		$urlaccessverifier = $_REQUEST['oauth_verifier'];
		error_log("Found access tokens in the URL - $urlaccesstoken, $urlaccessverifier");

		$requesttoken = $oauthstate['request_token'];
		$requesttokensecret = $oauthstate['request_token_secret'];

		error_log("Creating API with $requesttoken, $requesttokensecret");			
	
		$to = new LinkedInOAuth(
			LINKEDIN_API_KEY_PUBLIC, 
			LINKEDIN_API_KEY_PRIVATE,
			$requesttoken,
			$requesttokensecret
		);
		
		$tok = $to->getAccessToken($urlaccessverifier);
		
		$accesstoken = $tok['oauth_token'];
		$accesstokensecret = $tok['oauth_token_secret'];

		error_log("Calculated access tokens $accesstoken, $accesstokensecret");			
		
		$oauthstate['access_token'] = $accesstoken;
		$oauthstate['access_token_secret'] = $accesstokensecret;
		$oauthstate['state'] = 'done';

		set_linkedin_oauth_state($oauthstate);		
	}

	$state = $oauthstate['state'];
	
	if ($state=='start')
	{
        // This is either the first time the user has seen this page, or they've refreshed it before
        // they've authorized us to access their information. Either way, display a link they can
        // click that will take them to the authorization page.
        // In a real application, you'd probably have the page automatically redirect, since the
        // user has already entered their email address once for us already
		$tokenpublic = $oauthstate['request_token'];
		$to = new LinkedInOAuth(LINKEDIN_API_KEY_PUBLIC, LINKEDIN_API_KEY_PRIVATE);
		$requestlink = $to->getAuthorizeURL($tokenpublic, get_current_url());
?>
        <center><h1>Click this link to authorize access to your LinkedIn profile</h1></center>
        <br><br>
        <center><a href="<?=$requestlink?>"><?=$requestlink?></a></center>
<?php
	}
	else
	{
        // We've been given some access tokens, so try and use them to make an API call, and
        // display the results.
        
        $accesstoken = $oauthstate['access_token'];
        $accesstokensecret = $oauthstate['access_token_secret'];

        $to = new LinkedInOAuth(
            LINKEDIN_API_KEY_PUBLIC,
            LINKEDIN_API_KEY_PRIVATE,
            $accesstoken,
            $accesstokensecret
        );
        
        $profile_result = $to->oAuthRequest('http://api.linkedin.com/v1/people/~');
        $profile_data = simplexml_load_string($profile_result);

        print '<h3>Your profile data</h3>';
        
        print htmlspecialchars(print_r($profile_data, true));
        
        print '<br>';
        print "\n";
	}
		
}

// This is important! The example code uses session variables to store the user and token information,
// so without this call nothing will work. In a real application you'll want to use a database
// instead, so that the information is stored more persistently.
session_start();

?>
<html>
<head>
<title>Example page showing how to authenticate the LinkedIn API through OAuth</title>
</head>
<body style="font-family:'lucida grande', arial;">
<div style="padding:20px;">
<?php

handle_linkedin_oauth();

?>
<br><br><br>
<center>
<i>An example demonstrating the LinkedIn API's oAuth workflow in PHP by <a href="http://petewarden.typepad.com">Pete Warden</a></i>
</center>
</div>
</body>
</html>


<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
<title> <?= $site_name; ?> - Google Registration </title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="GigToDoScript">
<link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet" >
<link href="styles/bootstrap.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
<link href="styles/categories_nav_styles.css" rel="stylesheet">
<link href="styles/sweat_alert.css" rel="stylesheet">
<!--- stylesheet width modifications --->
<link href="styles/custom.css" rel="stylesheet">
<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
<script type="text/javascript" src="js/ie.js"></script>
<script type="text/javascript" src="js/sweat_alert.js"></script>
<script src="js/jquery.min.js"></script>
</head>

<body class="is-responsive">
<?php require_once("includes/header.php"); ?>
<div class="container mt-5"><!--- container mt-5 Starts -->
<div class="row justify-content-center"><!--- row justify-content-center Starts -->
<div class="col-lg-5 col-md-7"><!--- col-lg-5 col-md-7 Starts -->
<h2 class="text-center"> Onboarding... </h2>
<div class="box-login mt-4"><!--- box-login mt-4 Starts -->
<img class="logo img-fluid" src="<?= $_SESSION['picture']; ?>">
<?php 
$form_errors = Flash::render("g_errors");
if(is_array($form_errors)){
?>
<div class="alert alert-danger mt-2"><!--- alert alert-danger Starts --->
<ul class="list-unstyled mb-0">
<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
<li class="list-unstyled-item"><?= $i ?>. <?= ucfirst($error); ?></li>
<?php } ?>
</ul>
</div><!--- alert alert-danger Ends --->
<?php } ?>
<form action="" method="post"><!-- form Starts -->
<div class="form-group"><!-- form-group Starts -->
<label class="form-control-label font-weight-bold"> Full Name </label>
<input type="text" class="form-control" name="name" value="<?= $_SESSION['givenName'] . "" . $_SESSION['familyName']; ?>" placeholder="Enter Your Full Name" required>
</div><!-- form-group Ends -->
<div class="form-group"><!-- form-group Starts -->
<label class="form-control-label font-weight-bold"> Username </label>
<input type="text" class="form-control" name="u_name" placeholder="Enter Your Username" required>
<small class="form-text text-muted">
<span class="danger">NB: Username can't be changed once created.</span>
</small>
</div><!-- form-group Ends -->
<div class="form-group"><!-- form-group Starts -->
<label class="form-control-label font-weight-bold"> Email </label>
<input type="email" class="form-control" disabled name="email" value="<?= $_SESSION['email'] ?>" placeholder="Enter Your Email" required>
</div><!-- form-group Ends -->
<input type="submit" name="continue" class="btn btn-success btn-block" value="Continue">
</form><!--- form Ends -->
</div><!-- text-center mt-3 Ends -->
</div><!--- box-login mt-4 Ends -->
</div><!--- col-lg-5 col-md-7 Ends -->
</div><!--- row justify-content-center Ends -->

</div><!--- container mt-5 Ends -->

<?php

if(isset($_POST['continue'])){


	$rules = array(
	"name" => "required",
	"u_name" => "required");

	$messages = array("name" => "Full Name Is Required.","u_name" => "User Name Is Required.");

	$val = new Validator($_POST,$rules,$messages);

	if($val->run() == false){

	Flash::add("g_errors",$val->get_all_errors());

	Flash::add("form_data",$_POST);

	echo "<script>window.open('g-register','_self')</script>";

	}else{


	$name = $input->post('name');
	$u_name = $input->post('u_name');
	
	$email = $_SESSION['email'];
	
	$regsiter_date = date("F d, Y");
	
	$date = date("F d, Y");
	
	
	$url_to_image = $_SESSION['picture'];

	$ch = curl_init($url_to_image);

	$my_save_dir = 'user_images/';
	$filename = basename($_SESSION['id'] . ".jpg");
	$complete_save_loc = $my_save_dir . $filename;

	$fp = fopen($complete_save_loc, 'wb');

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
	
	$check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
	
	$check_seller_email = $db->count("sellers",array("seller_email" => $email));
	
	if($check_seller_username > 0 ){
		
		echo "
		
	   <script>
      
           swal({
           
          type: 'warning',
          text: 'This username has already been used. Please try another one.',

          })

        </script>
		
		";
		
	}else{
		
		if($check_seller_email > 0){
			
		echo "
		<script>
      
           swal({
           
          type: 'warning',
          text: 'This email has already been used. Please try another one..',

          })

        </script>";	
			
		}else{
				
		$referral_code = mt_rand();
		
		$verification_code = "ok";

		$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_image" => $filename,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online'));

		$regsiter_seller_id = $db->lastInsertId();
		
		if($insert_seller){
		
	      $_SESSION['seller_user_name'] = $u_name;

			$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));
					
			if($insert_seller_account){
				
				unset($_SESSION['userData']);
				unset($_SESSION['access_token']);
				
				echo "
				
	            <script>
	      
	                  swal({
		                  type: 'success',
		                  text: 'Hey $u_name, welcome. ',
		                  timer: 2000,
		                  onOpen: function(){
		                  	swal.showLoading()
		                  }
	                  }).then(function(){
	                  
	                    // Read more about handling dismissals
	                    window.open('$site_url','_self')

	                  });

	            </script>";
				
			}
			
		}
				
						
		}
		
	}

	}
	
	}

?>

<?php require_once("includes/footer.php"); ?>

</body>

</html>