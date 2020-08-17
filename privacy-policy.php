<?php

session_start();
require_once("includes/db.php");

// if(!isset($_SESSION['seller_user_name'])){
	
// 	echo "<script>window.open('login','_self')</script>";
	
// }

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_type = $row_login_seller->account_type;
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TF82RTH');</script>
<!-- End Google Tag Manager -->
	<title><?= $site_name; ?> - About</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="<?= $site_keywords; ?>">
	<meta name="author" content="<?= $site_author; ?>">
	<!--====== Favicon Icon ======-->
	<?php if(!empty($site_favicon)){ ?>
		<link rel="shortcut icon" href="<?= $site_url; ?>/images/<?= $site_favicon; ?>" type="image/x-icon">
	<?php } ?>
	<!--====== Bootstrap css ======-->
	<link href="<?= $site_url; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<!--====== PreLoader css ======-->
	<link href="<?= $site_url; ?>/assets/css/preloader.css" rel="stylesheet">
	<!--====== Animate css ======-->
	<link href="<?= $site_url; ?>/assets/css/animate.min.css" rel="stylesheet">
	<!--====== Fontawesome css ======-->
	<link href="<?= $site_url; ?>/assets/css/fontawesome.min.css" rel="stylesheet">
	<!--====== Owl carousel css ======-->
	<link href="<?= $site_url; ?>/assets/css/owl.carousel.min.css" rel="stylesheet">
	<!--====== Nice select css ======-->
	<link href="<?= $site_url; ?>/assets/css/nice-select.css" rel="stylesheet">
	<!--====== Nice select css ======-->
		<link href="<?= $site_url; ?>/assets/css/tagsinput.css" rel="stylesheet">
	<!--====== Range Slider css ======-->
	<link href="<?= $site_url; ?>/assets/css/ion.rangeSlider.min.css" rel="stylesheet">
	<!--====== Default css ======-->
	<link href="<?= $site_url; ?>/assets/css/default.css" rel="stylesheet">
	<!--====== Style css ======-->
	<link href="<?= $site_url; ?>/assets/css/style.css" rel="stylesheet">
	<link href="<?= $site_url; ?>/assets/css/style1.css" rel="stylesheet">
	<!--====== Responsive css ======-->
	<link href="<?= $site_url; ?>/assets/css/responsive.css" rel="stylesheet">
	<!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
	<!-- <link href="styles/custom.css" rel="stylesheet">  -->
	<!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">
	<link href="styles/user_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body class="all-content">
	<?php
    if(!isset($_SESSION['seller_user_name'])){
      require_once("includes/header_with_categories.php");
    }else{
    	if($login_seller_type == 'buyer'){
      	require_once("includes/buyer-header.php");
    	}else{
    		require_once("includes/user_header.php");
    	}
    } 
  ?>

	<!-- Preloader Start -->
	<div class="proloader">
		<div class="loader">
			<img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
		</div>
	</div>
	<!-- Preloader End -->
	<main class="emongez-content-main">
				<section class="container-fluid legal-page">
					<div class="row">
						<div class="container">
							<h3>Privacy Policy</h3>
							<p>
								<span>We take your data privacy seriously. This policy explains what information we collect, why we collect it and how we use that information. We store user or your information securely and will never share it with anyone. You can change your preferences at any time.</span>
								<span><a href="/">eMongez</a> or “we” are the administrator of our websites and mobile applications, which collect information in order to provide better services to all of our users and/or you. This may include some information that can identify you, but this is not sensitive. This policy aims to help you understand the terms and conditions that govern the collection and use of such information.</span>
								<span>This policy applies to: <a href="http://www.emongez.com/">eMongez</a> hereinafter referred to as “Website”.</span>
								<span>“Website” or “Platform” shall mean and include <a href="http://www.emongez.com/">eMongez</a>, permitted mobile application, any successor website/applications, any website of the emongez’s affiliates or any other channel facilitated and permitted by emongez;</span>
							</p>
							<h3>1. Who we are</h3>
							<p>
								<span><a href="http://www.emongez.com/">www.eMongez.com</a> is an online platform for users to buy and Sell the skills in the manner of Services. Under this, the Seller shall sell Services and the Buyer shall buy Services through the Website. The Services are offered to the Users through various modes which may include issue of coupons and vouchers that can be redeemed for various Services.</span>
								<span><a href="http://www.emongez.com/">www.emongez.com</a> is an online platform for users to buy and sell the skills in the manner of Services. Under this, the Seller shall sell Services and Buyer buy Services through the Website.</span>
								<span>The Services are offered to the Users through various modes, which may include issue of coupons and vouchers that can be redeemed for various Services.</span>
								<span>What information we may collect</span>
								<span>Personal identifiable information</span>
								<span>When you subscribe to receive our news updates, event invitations, and other emails, you will be asked for basic personal information that helps to identify you such as your name, email address, organizational affiliation and country of residence. If you apply for a job at emongez, you will be asked to provide information typically found in a curriculum vitae.</span>
								<span>We collect only the personal data from you in order to provide you with the service you requested. Your personal data will be kept with us until you unsubscribe from our mailing list.</span>
								<span>At any time, you can opt out of receiving emails from us clicking the ‘Unsubscribe’ link at the bottom of all of our emails, or by contacting us at <a href="mailto:info@emongez.com">info@emongez.com</a>. You can also request to have your personal data modified or deleted.</span>
							</p>
							<h3>Non-personal identifiable information</h3>
							<p>
								<span>When you access the Website for general browsing, we do not collect any personal information from you. The only information we collect is Internet Protocol (IP) address, browser type, operating system, the files you download, the pages you visit, and the dates/times of those visits. These do not specifically identify you. The information is used only for website traffic analysis in order to improve our website, and we treat it confidentially.</span>
							</p>
							<h3>Cookies</h3>
							<p>
								<span>A cookie is a small text file that a website saves on your computer or mobile device when you visit the site. In general, cookies have two main purposes: to improve your browsing experience by remembering your actions and preferences, and to help us analyze our website traffic.</span>
								<span>We use cookies to help us analyze traffic to the Website, to help us improve website performance and usability, and to make the Website more secure. Third-party cookies help us use Google Analytics to count, track and analyze visits to the Website. This helps us understand how people are using our website and where we need to make improvements. These third-party cookies do not specifically identify you.</span>
							</p>
							<h3>Control cookies</h3>
							<p>
								<span>You are always free to delete cookies that are already on your computer through your browser settings, and you can set most browsers to prevent them from being added to your computer. However, this may prevent you from using certain features on the Website.</span>
							</p>
							<h3>IP Addresses</h3>
							<p>
								<span>In addition, we also record your IP address, which is the Internet address of your computer, and information such as your browser type and operating system. This information helps us learn about the geographical distribution of our website visitors and the technology they use to access the Website.</span>
								<span>For example, our photo and video competitions allow a specific IP address to vote only once. This helps us ensure that our competitions are fair and that every competitor gets an equal chance. Another example is the publication download Paywall, which uses your IP address to track our publication dissemination.</span>
							</p>
							<h3>Social Media</h3>
							<p>
								<span>If you share our content on Facebook, Twitter or other social media accounts, we may track what content you share. This helps us improve our social media outreach.</span>
							</p>
							<h3>2. How we will use your information</h3>
							<p>
								<span>We do not use your personal data with any third party that intends to use it for direct marketing purposes, unless you have provided specific consent in relation to this.</span>
								<span>The Website may share your personal data with third parties for other purposes, but only in the following circumstances:</span>
							</p>
							<h4>I. With your consent</h4>
							<p>
								<span>We will share personal data with third parties outside of the Website when we have your consent to do so. We require explicit opt-in consent for the sharing of any sensitive personal information.</span>
							</p>
							<h4>II. For legitimate interests</h4>
							<p>
								<span>We will share personal data based on legitimate interests. For example, when you register for one of our events, except where such interests are overridden by your interests or fundamental rights, in which case we will request your explicit consent.</span>
							</p>
							<h4>III. For processing of the Website’s offices in other regions</h4>
							<p>
								<span>We provide your personal data to the Website’s offices in other regions for legitimate business purposes, on a “need-to-know” basis only, based on our instructions and in compliance with our Privacy Policy and any other appropriate confidentiality and security measures.</span>
							</p>
							<h4>IV. For external processing (service providers)</h4>
							<p>
								<span>We may engage service providers, agents or contractors to provide services on our behalf, including to administer the Website and services available to you. These third parties may come to access or otherwise process your personal data during providing these services.</span>
								<span>The Website requires such third parties, who may be based outside the country from which you have accessed the Website or service, to comply with all relevant data protection laws and security requirements in relation to your personal data, usually by way of a written agreement.</span>
							</p>
							<h4>V. Compliance with laws</h4>
							<p>We will share personal data with third parties outside of the Website if we have a good reason to believe that access, use, preservation or disclosure of the personal data is reasonably necessary to:</p>
							<ul>
								<li>Meet any applicable law, regulation, legal process or enforceable governmental request</li>
								<li>Enforce applicable Terms of Use, including investigation of potential violations</li>
								<li>Detect, prevent or otherwise address fraudulent activities, security or technical issues</li>
								<li>Protect against harm to the rights, property or safety of the Website, our users or the public as required or permitted by law</li>
							</ul>
							<h3>3. How we will protect your personal information</h3>
							<p>
								<span>We do not store your personal data on your mobile device or computer. We store all your personal information - including your primary information and other personal information- on secure servers.</span>
								<span>Where you have chosen a password that enables you to access certain parts of our App, you are responsible for keeping this password confidential. We ask you not to share the password with anyone.</span>
								<span>We encrypt data transmitted to and from the App. Once we have received your information, we will use strict procedures and security features to prevent any possible unauthorized access. We will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this privacy policy.</span>
								<span>Your data may be processed or stored outside the country, but always in accordance with data protection laws, including operations to lawfully transfer data across borders, and subject to strict safety measures.</span>
							</p>
							<h3>4. How can you access your data or contact us?</h3>
							<p>
								<span>As indicated above, whenever we rely on your consent to process your personal information, you have the right to withdraw your consent at any time by accessing the privacy settings in the Website or mobile application.</span>
								<span>You also have specific rights to:</span>
							</p>
							<ul>
								<li>Whenever we process data based on your consent, withdraw that consent at any time. You can do this via the privacy section of our App or Website;</li>
								<li>Understand and request a copy of the information we hold about you. Information with us and other notes can be accessed via the Website. For other information, you can make a request by email;</li>
								<li>Ask us to rectify or erase information we hold about you, subject to limitations relating to our obligation to store records for prescribed periods of time;</li>
								<li>Ask us to restrict our processing of your personal data or object to our processing; and </li>
								<li>Ask for your data to be provided on a portable basis</li>
							</ul>
							<p>Should you have any questions, concerns and/or complaints about this Privacy Policy, or if you would like to make any recommendations or comments to improve the quality of our Privacy Policy, please email us at <a href="mailto:info@emongez.com">info@emongez.com</a>.</p>
						</div>
					</div>
				</section>
			</main>	
		<?php require_once("includes/footer.php"); ?>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	</body>
</html>