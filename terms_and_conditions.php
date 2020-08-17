<?php
  session_start();
  require_once("includes/db.php");
  require_once("social-config.php");
  // if(!isset($_SESSION['seller_user_name'])){
    
  //  echo "<script>window.open('login','_self')</script>";
    
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
    <title><?= $site_name; ?> - Terms and Conditions.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site_desc; ?>">
    <meta name="keywords" content="<?= $site_keywords; ?>">
    <meta name="author" content="<?= $site_author; ?>">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">

    <!-- ==============Google Fonts============= -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!--====== Bootstrap css ======-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!--====== PreLoader css ======-->
    <link href="assets/css/preloader.css" rel="stylesheet">

    <!--====== Animate css ======-->
    <link href="assets/css/animate.min.css" rel="stylesheet">

    <!--====== Fontawesome css ======-->
    <link href="assets/css/fontawesome.min.css" rel="stylesheet">

    <!--====== Owl carousel css ======-->
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet">

    <!--====== Nice select css ======-->
    <link href="assets/css/nice-select.css" rel="stylesheet">

    <!--====== Default css ======-->
    <link href="assets/css/default.css" rel="stylesheet">

    <!--====== Style css ======-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style1.css" rel="stylesheet">

    <!--====== Responsive css ======-->
    <link href="assets/css/responsive.css" rel="stylesheet">
    <!-- <link href="styles/bootstrap.css" rel="stylesheet"> -->
    <link href="styles/styles.css" rel="stylesheet">
    <!-- <link href="styles/categories_nav_styles.css" rel="stylesheet"> -->
    <!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet"> -->
    <!-- <link href="styles/owl.carousel.css" rel="stylesheet"> -->
    <!-- <link href="styles/owl.theme.default.css" rel="stylesheet"> -->
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="images/<?= $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <!-- <script src="js/ie.js"></script> -->
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>.legal-page p span {display: inline;}</style>
  </head>
  <body class="all-content">
    <!-- Preloader Start -->
    <div class="proloader">
      <div class="loader">
        <img src="assets/img/emongez_cube.png" />
      </div>
    </div>
    <!-- Preloader End -->
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
    <main class="emongez-content-main">
      <section class="container-fluid legal-page">
        <div class="row">
          <div class="container">
            <!-- <h3>Terms & Conditions</h3>
            <p>
              <span>This Agreement was last revised on June 17, 2019.</span>
              <span>eMongez Welcomes you.</span>
              <span>We provide you access to our services through our “Website” (defined below) subject to the following Terms of Service, which may be updated by us from time to time without notice to you.</span>
              <span>By browsing the public areas or by accessing and using the Website, you acknowledge that you have read, understood, and agree to be legally bound by the terms and conditions of these Terms of Service and the terms and conditions of our Privacy Policy, which are hereby incorporated by reference (collectively, this “Agreement”).  If you do not agree to any of these terms, then please do not use the Website.</span>
            </p> -->
            <?php
              $get_terms = $db->query("select * from terms where language_id=1");
              while($row_terms = $get_terms->fetch()){
                  $term_title = $row_terms->term_title;
                  $term_link = $row_terms->term_link;
                  $term_description = $row_terms->term_description;
              ?>
            <h3><?= $term_title; ?></h3>
            <?= $term_description; ?>
            <?php } ?>
            <!-- <h3>How can we serve you?</h3>
            <p>
              <span><a href="http://www.emongez.com/">www.eMongez.com</a> is an online platform for users to buy and Sell the skills in the manner of Services. Under this, the Seller shall sell Services and the Buyer shall buy Services through the Website. The Services are offered to the Users through various modes which may include issue of coupons and vouchers that can be redeemed for various Services.</span>
            </p>
            <h3>How can you buy any service from our website?</h3>
            <p>
              <span>So, you are here as a Buyer, thank you for using our website, and you are looking for some skillful freelancer or professional to support your business and brand.</span>
              <span>You can surf the website and choose the appropriate Seller, for placing any order to buy any service from this Website is between you and eMongez. At the time of ordering, while providing your details it is your duty to be careful and warrant that the information provided are true and accurate.</span>
            </p>
            <p>
              <span>Online: Pay on eMongez using a credit card, debit card or PayPal account.</span>
              <span>eMongez accepts any local or international Debit or Credit cards using Master Card and Visa.</span>
              <span>Please ensure that online transactions have been approved by your bank.</span>
            </p>
            <p>
              <span>Mobile Wallet: Pay on eMongez using your Mobile wallet.</span>
              <span>eMongez accepts all of Egypt’s leading mobile wallet Providers.</span>
              <span>Make sure that your wallet has the needed funds for the purchase.</span>
              <span>If you would like to top up your wallet, please contact your Mobile wallet provider.</span>
            </p>
            <p>
              <span>Cash: Select Cash Collection from eMongez</span>
              <span>Our Partner R2S Egypt’s leading courier will contact you to arrange Cash Collection.</span>
              <span>Please ensure that your address is entered correctly to ensure next day Cash Collection.</span>
            </p>
            <p>
              <span>Local: Pay on eMongez through the largest network of cash points.</span>
              <span>Enjoy the convenience of paying at your preferred time and location across Egypt.</span>
              <span>You can check your nearest cash point by visiting the providers website.</span>
            </p>
            <p>
              <span>Once you selected a Service gig you wish to buy from the Sellers available on the Website, click on “Order” button for the completion of buying process.</span>
              <span>Services purchased from this Website are intended for your use only and you warrant that any Service purchased by you are not for resale and that you shall act as a principal and not as an agent of other party for taking the Services.</span>
            </p>
            <p>
              <span>When buying from this Website you may be required to open a Buyers Account and provide a username and password. You must take care of your details and not disclose these details to any other party.</span>
              <span>We make every possible care to secure your order details and payment details however we are not responsible if any third party access the data and you may suffer any losses for the same.</span>
            </p>
            <p>
              <span>You can place an Order subject to service availability and acceptance by us. After placing an order online, you will receive a confirmation email for the same. This is an automatic email confirmation ensuring you that your order is confirmed. If you receive an automatic confirmation email, it does not mean that we will meet your order.</span>
            </p>
            <p>
              <span>Once we have sent the confirmation email we will then check availability and obtain an authorization from your Credit card Company for the amount detailed on the order summary page and contact you with a further email. If the Services are available and the details of the order are correct, this email will be deemed an acceptance and will specify delivery details and confirm the price of the Services purchased.</span>
            </p>
            <p>
              <span><strong>We may refuse to process your order if:</strong></span>
            </p>
            <ul>
              <li>The Service you ordered is unavailable or discontinued;</li>
              <li>You credit card or PayPal account does not give authorization for the payment of purchase price</li>
              <li>You do not meet the eligibility to order criteria set out above.</li>
            </ul>
            <p>
              <span>The Orders can be cancelled by either Party as per website policy. If any Buyer regularly canceled orders or raise Disputes will be closely monitored and can be removed from the website.</span>
              <span>All prices listed on the Website are correct however we reserve the right to alter these in the future. We also reserve the right to alter the services available for sale on the Website and to discontinue any service.</span>
              <span>Through the controlled system of the Website can you chat with the Sellers for a better buying experience.</span>
            </p>
            <p>
              <span>Buyers have the option to not include a comment, but still rate your service. They also have the right to not leave a review or rating at all. This is their choice. A friendly one-time message, politely asking for a review and or/comment is cool, feedback is important after all! Do not hassle your buyers for reviews. Spamming the community customer base is against the Terms, but also reflects badly on your own business profile</span>
            </p>
            <p>
              <span>We are happy to support you if there is any issue you can contact our back-office team for any inquiry or problem.</span>
            </p>
            <h3>How you can offer your services and earn!</h3>
            <p>
              <span>As a Seller to make any offer to sell service from this Website is between you (Seller) and eMongez while providing your details it is your duty to be careful and warrant that the information provided are true and accurate.</span>
              <span>Once you selected a Service you wish to offer through the Website, you are bound to build a successful online business, portfolio and reputation as a global digital citizen of the world.</span>
              <span>Services offered from this Website are offered by you only and you warrant that for offering any Service you should act as principal only and not as agent for another party when offering the Services.</span>
              <span>When buying from this Website you may be required to open a Sellers Account and provide a username and password. You must keep your details and other information secure and not disclose it to any other party.</span>
              <span>We make every possible care to secure you order details and payment details however we are not responsible if any third party access the data and you may suffer any losses for the same.</span>
              <span>You can offer Service by creating a Gig subject to service requirement, description and acceptance by us. When you create a Gig to offer services online we will send you an email to confirm that we have accepted your gig for offering Services.</span>
            </p>
            <p>
              <span><strong>We may refuse to process you order if:</strong></span>
            </p>
            <ul>
              <li>The Gig you created to provide Service is not appropriate with the rules and regulation of the Website;</li>
              <li>You do not meet the eligibility to order criteria set out above.</li>
            </ul>
            <p>
              <span>To withdraw your Revenue, you must have an account with at least one of Website’s withdrawal methods. Currently, you can add PayPal or Bank Transfer details into your profile.</span>
              <span>The minimal withdrawal balance is EGP 100. We have set this to limit to avoid eating into your Revenue with conversion rates, cross-border fees, and all the other financial fees currently charged by 3rd party providers. We are constantly working on ways to pay you faster, with as little fees as possible. Fees will vary depending on your nominated payout provider.</span>
            </p>
            <p>
              <span>The total Revenue in your Virtual Wallet (minus 3rd party fees) will be transferred to your nominated payout Account. Withdrawals are final and cannot be undone. No refund will be granted or change in the process once it has begun. The time taken to receipt Revenues into your nominated Account will be dependent on 3rd party payout partners.</span>
            </p>
            <p>
              <span>We are human. If your situation requires a little bit of extra attention, please contact website support via the messaging center and we will genuinely do anything in our power to assist in accessing your Revenue. As we grow as a business our negotiation will also grow with our payout providers.</span>
            </p>
            <h3>What We Charge?</h3>
            <p>
              <span>We currently don’t charge anything. That’s right you get to keep 100% of what you have earned.</span>
              <span>eMongez will deposit 100% of your earnings to your virtual wallet.</span>
            </p>
            <h3>How you get refund?</h3>
            <p>
              <span>We can refund your balance for cancelled orders and can send back the refund to your payment provider. Firstly, the fund from cancelled order shall be refunded to the Buyer’s Virtual Wallet as a credit for future purchases from the website. The funds refunded to your Virtual Wallet shall not include processing fee paid.</span>
            </p>
            <h3>Our Rights</h3>
            <p>
              <span>We reserve the right, but not the obligation, to limit the usage or supply of any service to any person, geographic region or jurisdiction.  We may use this right in accordance with the case. We reserve the right to stop or remove any service any time.</span>
              <span>We do not warrant about the quality of services, or information provided to you shall fulfill your expectation or have any issue/defect that can be corrected.</span>
            </p>
            <p>
              <span><strong>Some General Conditions…. please follow</strong></span>
            </p>
            <ul>
              <li>You shall use website for lawful purpose and comply all the applicable laws while using the website;</li>
              <li>You shall not upload, any content that:</li>
              <li>Defamatory, infringes any trademark, copyright or any proprietary rights of any person or effect any one’s privacy, contain violence or hate speech, include any sensitive information about any person.</li>
              <li>You shall not trail, bully or harass another person;</li>
              <li>You may not buy or sell any Users accounts</li>
              <li>Always respect other Users’ opinions, aspirations and goals;</li>
              <li>You shall not use or access the website for collecting any market research for some competing business;</li>
              <li>Treat other Users with kindness and humility;</li>
              <li>Do not judge other Users;</li>
              <li>You shall not trail, bully or harass another person;</li>
              <li>Be active and supportive, and contribute;</li>
              <li>You shall not misrepresent or personate any person or entity for any false or illegal purpose;</li>
              <li>You shall not use or access the website for collecting any market research for some competing business;</li>
              <li>Be open-minded and listen to each other</li>
              <li>You shall not use any virus, hacking tool for interfering in the operation of the website or data and files of the website;</li>
              <li>You will not any device, scraper or any automated thing to access the website for any mean without taking permission.</li>
              <li>You will inform us about any inappropriate content or you can inform us if you find something illegal;</li>
            </ul>
            <p>
              <span>We reserve the sole right at our absolute discretion, to block any user to access the website or any part of the Website, with or without notice.</span>
            </p>
            <h3>Still an issue?</h3>
            <p>
              <span>Please contact our support to resolve your issue in the best possible way. If there any dispute or issue regarding payment or order, contact us at <a href="mailto:support@eMongez.com">support@eMongez.com</a></span>
              <span>You can raise dispute for anything goes wrong with the order like buyer/seller not responding, or for any other dispute or issue.</span>
              <span>Buyer can communicate with the Seller for resolving the disputes through the resolution center and can also communicate with us for unresolved matters.</span>
            </p>
            <h3>Definitions</h3>
            <ul>
              <li>“Agreement” is a reference to these Terms and Conditions, the Privacy Policy, any order form and payment instructions provided to you;</li>
              <li>“Privacy Policy” means "<a href="http://www.emongez.com/">https://eMongez.com/</a> privacy policy the policy displayed on our Website which details how we collect and store your personal data;</li>
              <li>“Goods”, “Products” is a reference to any product or goods which we may offer for sale from our Website from time to time;</li>
              <li>“Service” or “Services” is a reference to any service defined below, which we may supply and which you may request via our Website;</li>
              <li>“User”, “You” and “your” are refers to the person who is accessing for taking or offering any service through us as a Buyer or Seller. User shall also refer to the company, partnership, sole trader, person, body corporate or association taking services of this website;</li>
              <li>“Buyer” is referring to the user/person who register as Buyer on the Website to buy services through the Website and signed the Buyers Agreement with the Website;</li>
              <li>Buyers Agreement” refers to the Agreement signed between Buyer and <a href="http://www.emongez.com/">eMongez</a>;</li>
              <li>“Seller” is refers to the user/person who register as Seller on the Website in order to sell services through the Website and signed the Sellers Agreement.</li>
              <li>“Buyer” is referring to the user/person who register as Buyer on the Website to buy services through the Website and signed the Buyers Agreement with the Website;</li>
              <li>“Sellers Agreement” refers to the Agreement signed between Seller and <a href="http://www.emongez.com/">www.eMongez.com</a>;</li>
              <li>“We”, “us”, “our” and “Company” are references to COMPANY NAME AND ADDRESS</li>
              <li>“Website” shall mean and include "<a href="http://www.emongez.com/">https://eMongez.com</a>, mobile application of the Company, any successor website/applications, any website of the Company’s affiliates or any other channel facilitated and permitted by the Company;</li>
              <li>"Applicable Law" means in respect of a person, any statute, law, regulation, ordinance, rule, judgment, decree, by-law, approval from the concerned authority, government resolution, order, directive, guideline, policy, requirement, or other governmental restriction or any similar form of decision, or determination, or any interpretation or adjudication having the force of law of any of the foregoing, by any concerned authority or other requirements of any governmental or regulatory authority, to which such person is subject;</li>
              <li>“Gig” refers to the medium by which Seller can offer its Services through the Website;</li>
              <li>“Transaction” means when Buyer buy the Gig of the Seller available on the Website;</li>
              <li>"Seller Account” shall mean an electronic account opened by the User with the Website to offered services through the Website;</li>
              <li>“Buyer Account” shall mean an electronic account opened by the User with the Website to buy Services offered by various Sellers through the Website;</li>
              <li>“Virtual Wallet” refers to the wallet in which the website credits all the earning of the Seller.</li>
            </ul>
            <h3>Exclusion Of Liability</h3>
            <p>
              <span>In no event shall <a href="http://www.emongez.com/">eMongez</a>, nor its directors, employees, partners, agents, suppliers, or affiliates, be responsible for any indirect, incidental, special, eventful or exemplary damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from (i) your access to or use of or inability to access or use the Service; (ii) any conduct or content of any third party on the Service; (iii) any content obtained from the Service; and (iv) unauthorized access, use or alteration of your transmissions or content, whether or not based on warranty, contract, civil wrong (including negligence) or any other legal theory, whether or not we've been aware of the likelihood of such harm, and even if a remedy set forth herein is found to have failed of its essential purpose.</span>
            </p>
            <h3>Use Restriction</h3>
            <p>
              <span>This is an Agreement for Services, and you are not granted a license to any software by this Agreement. You will not, directly or indirectly: reverse engineer, decompile, disassemble, or otherwise attempt to discover the source code, object code, or underlying structure, ideas, or algorithms of or included in the Services or any software, documentation or data related to the Services (“Software”); modify, translate or create derivative works based on the Services or any Software; or copy (except for archival purposes), distribute, pledge, assign or otherwise transfer or encumber rights to the Services or any Software; use the Services or any Software for timesharing or service bureau purposes or otherwise for the benefit of a third party; or remove any proprietary notices or labels.</span>
            </p>
            <h3>Modifications to the Service and Prices</h3>
            <p>
              <span>We reserve the right, in its discretion, to change, modify, add to, or remove portions of the Terms (collectively, “Changes”), at any time. We may notify you of Changes by sending an email to the address identified in your Account or by posting a revised version of the Terms incorporating the Changes to its Website. Your continued use of the Website or Services following notice of the Changes (or posting of the Terms incorporating the Changes in the event your email address is no longer valid, is blocked, or is otherwise not able to receive the notice) will mean that you accept and agree to the Changes. Such Changes will apply prospectively beginning on the date the Changes are posted to the Website.</span>
            </p>
            <h3>Third Party Links</h3>
            <p>
              <span>The Website may contain links to third-party websites (“External Sites”).  These links are provided solely as a convenience to you and not as an endorsement by us of the content on such External Sites.  The content of such External Sites is developed and provided by others.  You should contact the site administrator or webmaster for those External Sites if you have any concerns regarding such links or any content located on such External Sites.  We are not responsible for the content of any linked External Sites and do not make any representations regarding the content or accuracy of materials on such External Sites.  You should take precautions when downloading files from all websites to protect your computer from viruses and other destructive programs.  If you decide to access linked External Sites, you do so at your own risk.</span>
            </p>
            <h3>Personal Information and Privacy Policy</h3>
            <p>
              <span>By using this Website, you authorize us to use, store or otherwise process your personal information to provide the website Services to you and for marketing and credit control purposes (the “Purpose”). More information can be found in our Privacy Policy.</span>
            </p>
            <h3>Errors, Inaccuracies and Omissions</h3>
            <p>
              <span>Great care has been taken to ensure that the information available on this Website is correct and error free. We apologies for any errors or omissions that may have occurred. We cannot warrant that use of the Website will be error free or fit for purpose, timely, that defects will be corrected, or that the site or the server that makes it available are free of viruses or bugs or represents the full functionality, accuracy, reliability of the Website and we do not make any warranty whatsoever, whether express or implied, relating to fitness for purpose, or accuracy.</span>
            </p>
            <h3>DISCLAIMER OF WARRANTIES; LIMITATION OF LIABILITY</h3>
            <p>
              <span>THE WEBSITE AND THE CONTENT ARE PROVIDED ON AN “AS IS” AND “AS AVAILABLE” BASIS WITHOUT ANY WARRANTIES OF ANY KIND, INCLUDING THAT THE WEBSITE WILL OPERATE ERROR-FREE OR THAT THE WEBSITE, ITS SERVERS, OR THE CONTENT ARE FREE OF COMPUTER VIRUSES OR SIMILAR CONTAMINATION OR DESTRUCTIVE FEATURES.</span>
            </p>
            <p>
              <span>WE DISCLAIM ALL WARRANTIES, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF TITLE, MERCHANTABILITY, NON-INFRINGEMENT OF THIRD PARTIES’ RIGHTS, AND FITNESS FOR PARTICULAR PURPOSE AND ANY WARRANTIES ARISING FROM A COURSE OF DEALING, COURSE OF PERFORMANCE, OR USAGE OF TRADE. IN CONNECTION WITH ANY WARRANTY, CONTRACT, OR COMMON LAW TORT CLAIMS: (I) WE SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, OR CONSEQUENTIAL DAMAGES, LOST PROFITS, OR DAMAGES RESULTING FROM LOST DATA OR BUSINESS INTERRUPTION  RESULTING FROM THE USE OR INABILITY TO ACCESS AND USE THE WEBSITE OR THE CONTENT, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES; AND (II) ANY DIRECT DAMAGES THAT YOU MAY SUFFER AS A RESULT OF YOUR USE OF THE WEBSITE OR THE CONTENT SHALL BE LIMITED TO THE MONIES YOU HAVE PAID US IN  CONNECTION WITH YOUR USE OF THE WEBSITE DURING THE THREE (3) MONTHS IMMEDIATELY PRECEDING THE EVENTS GIVING RISE TO THE CLAIM.</span>
            </p>
            <p>
              <span>THE WEBSITE MAY CONTAIN TECHNICAL INACCURACIES OR TYPOGRAPHICAL ERRORS OR OMISSIONS. UNLESS REQUIRED BY APPLICABLE LAWS, WE ARE NOT RESPONSIBLE FOR ANY SUCH TYPOGRAPHICAL, TECHNICAL, OR PRICING ERRORS LISTED ON THE WEBSITE.  THE WEBSITE MAY CONTAIN INFORMATION ON CERTAIN SERVICES, NOT ALL OF WHICH ARE AVAILABLE IN EVERY LOCATION.  A REFERENCE TO A SERVICE ON THE WEBSITES DOES NOT IMPLY THAT SUCH SERVICE IS OR WILL BE AVAILABLE IN YOUR LOCATION.  WE RESERVE THE RIGHT TO MAKE CHANGES, CORRECTIONS, AND/OR IMPROVEMENTS TO THE WEBSITE AT ANY TIME WITHOUT NOTICE.</span>
            </p>
            <h3>Copyright and Trademark</h3>
            <p>
              <span>The Website contains material, such as software, text, graphics, images, designs, sound recordings, audiovisual works, and other material provided by or on behalf of us (collectively referred to as the “Content”).  The Content may be owned by us or third parties.   Unauthorized use of the Content may violate copyright, trademark, and other laws.  You have no rights in or to the Content, and you will not use the Content except as permitted under this Agreement.  No other use is permitted without prior written consent from us.  You must retain all copyright and other proprietary notices contained in the original Content on any copy you make of the Content.  You may not sell, transfer, assign, license, sublicense, or modify the Content or reproduce, display, publicly perform, make a derivative version of, distribute, or otherwise use the Content in any way for any public or commercial purpose.  The use or posting of the Content on any other website or in a networked computer environment for any purpose is expressly prohibited.</span>
              <span>If you violate any part of this Agreement, your permission to access and/or use the Content and the Website automatically terminates and you must immediately destroy any copies you have made of the Content.</span>
              <span>Our trademarks, service marks, and logos used and displayed on the Website are registered and unregistered trademarks or service marks of us.  Other company, product, and service names located on the Website may be trademarks or service marks owned by others (the “Third-Party Trademarks,” and, collectively with us, the “Trademarks”). Nothing on the Website should be construed as granting, by implication, estoppel, or otherwise, any license or right to use the Trademarks, without our prior written permission specific for each such use. None of the Content may be retransmitted without our express, written consent for each and every instance.</span>
            </p>
            <h3>Indemnification</h3>
            <p>
              <span>You agree to defend, indemnify, and hold us and our officers, directors, employees, successors, licensees, and assigns harmless from and against any claims, actions, or demands, including, without limitation, reasonable legal and accounting fees, arising or resulting from your breach of this Agreement or your misuse of the Content or the Website.  We shall provide notice to you of any such claim, suit, or proceeding and shall assist you, at your expense, in defending any such claim, suit, or proceeding.  We reserve the right, at your expense, to assume the exclusive defense and control of any matter that is subject to indemnification under this section.  In such case, you agree to cooperate with any reasonable requests assisting our defense of such matter.</span>
            </p>
            <h3>Termination</h3>
            <p>
              <span>Term. The Services will be provided to you can be cancelled or terminated by us. We may terminate these Services at any time, with or without cause, upon written notice. We will have no liability to you or any third party because of such termination. Termination of these Terms will terminate all of your Services subscriptions.</span>
              <span>Effect of Termination. Upon termination of these Terms for any reason, or cancellation or expiration of your Services: (a) We will cease providing the Services; (b) you will not be entitled to any refunds or usage fees, or any other fees, pro rata or otherwise; (c) any fees you owe to us will immediately become due and payable in full; and (d) we may delete your archived data within 30 days. All sections of the Terms that expressly provide for survival, or by their nature should survive, will survive termination of the Terms, including, without limitation, indemnification, warranty disclaimers, and limitations of liability.</span>
            </p>
            <h3>Entire Agreement</h3>
            <p>
              <span>These Terms are the complete and exclusive statement of the mutual understanding of the parties and supersedes and cancels all previous written and oral agreements, communications, and other understandings relating to the subject matter of these Terms, and any modifications must be in a writing signed by both parties, except as otherwise provided herein.</span>
            </p>
            <h3>Governing Law and Judicial Recourse</h3>
            <p>
              <span>The terms herein will be governed by and construed in accordance with the laws of Arab Republic of Egypt without giving effect to any principles or conflicts of law. The competent Egyptian courts shall have exclusive jurisdiction over any dispute arising from use of the Website.</span>
            </p>
            <h3>Force Majeure</h3>
            <p>
              <span>We will have no liability to you, your users, or any third party for any failure us to perform its obligations under these Terms in the event that such non-performance arises as a result of the occurrence of an event beyond the reasonable control of us, including, without limitation, an act of war or terrorism, natural disaster, failure of electricity supply, riot, civil disorder, or civil commotion or other force majeure event.</span>
            </p>
            <h3>Interpretation</h3>
            <ul>
              <li>All references to singular include plural and vice versa and the word "includes" should be construed as "without limitation".</li>
              <li>Words importing any gender shall include all the other genders.</li>
              <li>Reference to any statute, ordinance or other law includes all regulations and other instruments and all consolidations, amendments, re-enactments or replacements for the time being in force.</li>
              <li>All headings, bold typing and italics (if any) have been inserted for convenience of reference only and do not define limit or affect the meaning or interpretation of the terms of this Agreement.</li>
            </ul>
            <h3>Hosting Services</h3>
            <p>
              <span>We have entered into arrangements with one or more third parties for hosting services that are essential to the Services, incorporated within the Services and without which the Services could not be provided to you.</span>
            </p>
            <h3>Assignment</h3>
            <p>
              <span>The Company shall have the right to assign/transfer these presents to any third party including its holding company, subsidiaries, affiliates, associates and group companies, without any consent of the User.</span>
            </p> -->
            <h3>Contact Information</h3>
            <p>
              <span>If you have any questions about these Terms, please contact us at <a href="mailto:support@eMongez.com">Support@eMongez.com</a>.</span>
            </p>
          </div>
        </div>
      </section>
    </main>

    <!-- <div class="container-fluid mt-5 mb-5">
      <div class="row mb-4">
        <div class="col-md-12 text-center">
          <h1>Our Policies</h1>
          <p class="lead pb-4"> Terms & Conditions, Refund Policy, Pricing & Promotion Policy. </p>
        </div>
      </div>
      <div class="row terms-page" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
        <div class="col-md-3 mb-3">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-pills flex-column mt-2">
                <?php
                  $get_terms = $db->query("select * from terms where language_id='$siteLanguage' LIMIT 0,1");
                  while($row_terms = $get_terms->fetch()){
                      $term_title = $row_terms->term_title;
                      $term_link = $row_terms->term_link;
                  ?>
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="pill" href="#<?= $term_link; ?>">
                  <?= $term_title; ?>
                  </a>
                </li>
                <?php } ?>
                <?php
                  $count_terms = $db->count("terms",array("language_id" => $siteLanguage));
                  $get_terms = $db->query("select * from terms where language_id='$siteLanguage' LIMIT 1,$count_terms");
                  while($row_terms = $get_terms->fetch()){
                      $term_title = $row_terms->term_title;
                      $term_link = $row_terms->term_link;
                  ?>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#<?= $term_link; ?>">
                  <?= $term_title; ?>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-body">
              <div class="tab-content">
                <?php
                  $get_terms = $db->query("select * from terms where language_id='$siteLanguage' LIMIT 0,1");
                  while($row_terms = $get_terms->fetch()){
                      $term_title = $row_terms->term_title;
                      $term_link = $row_terms->term_link;
                      $term_description = $row_terms->term_description;
                  ?>
                <div id="<?= $term_link; ?>" class="tab-pane fade show active">
                  <h2 class="mb-4"><?= $term_title; ?></h2>
                  <p class="text-justify">
                    <?= $term_description; ?>
                  </p>
                </div>
                <?php } ?>
                <?php
                  $get_terms = $db->query("select * from terms where language_id='$siteLanguage'");
                  while($row_terms = $get_terms->fetch()){
                      $term_title = $row_terms->term_title;
                      $term_link = $row_terms->term_link;
                      $term_description = $row_terms->term_description;
                  ?>
                <div id="<?= $term_link; ?>" class="tab-pane fade ">
                  <h1 class="mb-4"><?= $term_title; ?></h1>
                  <p class="text-justify">
                    <?= $term_description; ?>
                  </p>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <?php require_once("includes/footer.php"); ?>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TF82RTH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  </body>
</html>