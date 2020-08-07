<?php
  session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  // Load Composer's autoloader
  require "vendor/autoload.php";

  require_once("includes/db.php");
  require_once("social-config.php");
  if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_email = $row_login_seller->seller_email;
  $login_seller_user_name = $row_login_seller->seller_user_name;
  }
  $recaptcha_site_key = $row_general_settings->recaptcha_site_key;
  $recaptcha_secret_key = $row_general_settings->recaptcha_secret_key;

  if ($lang_dir == "right") {
    $floatRight = "float-right";
  } else {
    $floatRight = "float-left";
  }

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - Customer Support</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/png">

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
  <!-- <link href="styles/custom.css" rel="stylesheet"> -->
  <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <!-- <link href="styles/categories_nav_styles.css" rel="stylesheet"> -->
  <!-- <link href="font_awesome/css/font-awesome.css" rel="stylesheet"> -->
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <!-- <script type="text/javascript" src="js/ie.js"></script> -->
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
  <style>
    .select-error .nice-select.form-control{display: none !important;}
    #relevantSubject{display: block !important;}
    .user_role .nice-select{display: none;}
    .user_role select{display: block !important;}
  </style>
</head>
<body class="all-content">
  <!-- Preloader Start -->
  <div class="proloader">
    <div class="loader">
      <img src="<?= $site_url; ?>/assets/img/emongez_cube.png" />
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
    <section class="container-fluid contactus">
      <div class="row">
        <?php
          $get_contact_support = $db->select("contact_support");
          $row_contact_support = $get_contact_support->fetch();
          $contact_email = $row_contact_support->contact_email;
          $get_meta = $db->select("contact_support_meta",array('language_id' => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $contact_heading = $row_meta->contact_heading;
          $contact_desc = $row_meta->contact_desc;
        ?>
        <!-- <div class="col-md-12 mt-4">
          <?php if(!isset($_SESSION['seller_user_name'])){ ?>
          <div class="alert alert-warning rounded-0">
            <p class="lead mt-1 mb-1 text-center">
              <strong>Sorry!</strong> You can't submit a support request without logging in first. If you have a general question, please email us at <?php echo $contact_email; ?>.
            </p>
          </div>
          <?php } ?>
        </div> -->
      </div>
      <div class="row">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-12 col-md-7">
              <div class="contactus-form">
                <h1><?php echo $contact_heading; ?></h1>
                <p class="text-muted pt-1"><?php echo $contact_desc; ?></p>
                <form class="d-flex flex-column" method="POST" enctype="multipart/form-data">
                  <?php if(isset($_SESSION['seller_user_name'])){ ?>
                  <div class="form-group select-error">
                    <label class="control-label" for="relevantSubject">select relevant inquiry subject</label>
                    <select class="form-control select_tag" name="enquiry_type" id="relevantSubject">
                      <option value="" url="customer_support">Select Inquiry Subject</option>
                      <?php
                        $get_enquiry_types = $db->select("enquiry_types");
                        while($row_enquiry_types = $get_enquiry_types->fetch()){
                          $enquiry_id = $row_enquiry_types->enquiry_id;
                          $enquiry_title = $row_enquiry_types->enquiry_title;
                          echo "<option value='$enquiry_id' ".(@$_GET['enquiry_id'] == $enquiry_id ? "selected " : "") ."url='customer_support?enquiry_id=$enquiry_id'>
                          $enquiry_title
                          </option>";
                        }
                      ?>
                    </select>
                  </div>
                  <?php }else{ ?>
                  <div class="form-group select-error">
                    <label class="control-label" for="relevantSubject">select relevant inquiry subject</label>
                    <select class="form-control" name="enquiry_type" id="relevantSubject">
                      <option value="">Select Inquiry Subject</option>
                      <option value="4">Report A Bug</option>
                      <option value="5">General Enquiry</option>
                        
                    </select>
                  </div>
                  <?php } ?>
                  <?php if(!isset($_SESSION['seller_user_name'])){ ?>
                  <div class="form-group">
                    <label class="control-label" for="email">Email</label>
                    <input type="text" name="email" required="" id="email" class="form-control" />
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <label class="control-label" for="subject">Subject</label>
                    <input type="text" name="subject" required="" id="subject" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" required rows="7"></textarea>
                  </div>
                  <?php if($_GET['enquiry_id'] == 1 or $_GET['enquiry_id'] == 2){ ?>
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">Order Number *</label>
                    <input type="text" class="form-control" name="order_number" required="">
                  </div>
                  <div class="form-group user_role">
                    <label class="<?= $floatRight ?>">User Role *</label>
                    <select name="user_role" class="form-control" required>
                      <option value="" class="hidden">Select user role</option>
                      <option>Buyer</option>
                      <option>Seller</option>
                    </select>
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <label class="control-label" for="attachment">Attatchment</label>
                    <input type="file" name="file" id="attachment" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label>Please verify that you're part of humanity.</label>
                    <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
                  </div>
                  <div class="form-group">
                    <button class="contactus-form-button" type="submit" name="submit">Submit request</button>
                  </div>
                  
                </form>
              </div>
            </div>
            <div class="col-12 col-md-7 col-lg-4">
              <div class="contact-location">
                <h2>We Are Always here to help you!</h2>
                <div class="address-item d-flex flex-row">
                  <div class="icon">
                    <img alt="Address" class="img-fluid d-block" src="assets/img/contact/map-marker.png" />
                  </div>
                  <div class="text">
                    <h4>Address</h4>
                    <h5>Egypt</h5>
                    <address>
                      4 Johayna St Ad Doqi a Dokki Giza<br />
                      Governorate 12311 Egypt
                    </address>
                    <h5>Australia</h5>
                    <address>
                      1409/200 Spencer St Neo200,<br />
                      Melbourne VIC 3000
                    </address>
                  </div>
                </div>
                <!-- Each item -->
                <div class="address-item d-flex flex-row">
                  <div class="icon">
                    <img alt="Email" class="img-fluid d-block" src="assets/img/contact/mail-icon.png" />
                  </div>
                  <div class="text">
                    <h4>Email</h4>
                    <p><a href="mailto:emongez@emongez.com">emongez@emongez.com</a></p>
                  </div>
                </div>
                <!-- Each item -->
              </div>
            </div>
          </div>
          <!-- Row -->
          <div class="row">
            <div class="col-12">
              <div class="contactus-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.970234789631!2d31.21043481569234!3d30.037711781884774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145846d4ecbeb8f5%3A0xd00525dc3aa4c477!2s4%20Johayna%20St%2C%20Ad%20Doqi%20A%2C%20Dokki%2C%20Giza%20Governorate%2012311%2C%20Egypt!5e0!3m2!1sen!2sbd!4v1592425184858!5m2!1sen!2sbd" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
              </div>
            </div>
          </div>
          <!-- Row -->
        </div>
      </div>
    </section>
  </main>




  <!-- <div class="container pb-4">
    <div class="row">
      <?php
        $get_contact_support = $db->select("contact_support");
        $row_contact_support = $get_contact_support->fetch();
        $contact_email = $row_contact_support->contact_email;
        $get_meta = $db->select("contact_support_meta",array('language_id' => $siteLanguage));
        $row_meta = $get_meta->fetch();
        $contact_heading = $row_meta->contact_heading;
        $contact_desc = $row_meta->contact_desc;
      ?>
      <div class="col-md-12 mt-4">
        <?php if(!isset($_SESSION['seller_user_name'])){ ?>
        <div class="alert alert-warning rounded-0">
          <p class="lead mt-1 mb-1 text-center">
            <strong>Sorry!</strong> You can't submit a support request without logging in first. If you have a general question, please email us at <?php echo $contact_email; ?>.
          </p>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="row customer-support" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header text-center make-white">
            <h2><?php echo $contact_heading; ?></h2>
            <p class="text-muted pt-1"><?php echo $contact_desc; ?></p>
          </div>
          <div class="card-body">
            <center>
              <form class="col-md-8 contact-form" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="<?= $floatRight ?>">Select Relevant Inquiry Subject</label>
                  <select name="enquiry_type" class="form-control select_tag" required>
                    <option value="" url="customer_support">Select Inquiry Subject</option>
                    <?php
                      $get_enquiry_types = $db->select("enquiry_types");
                      while($row_enquiry_types = $get_enquiry_types->fetch()){
                        $enquiry_id = $row_enquiry_types->enquiry_id;
                        $enquiry_title = $row_enquiry_types->enquiry_title;
                        echo "<option value='$enquiry_id' ".(@$_GET['enquiry_id'] == $enquiry_id ? "selected " : "") ."url='customer_support?enquiry_id=$enquiry_id'>
                        $enquiry_title
                        </option>";
                      }
                    ?>
                  </select>
                </div>
                <?php if(isset($_GET['enquiry_id'])){ ?>
                <div class="form-group">
                  <label class="<?= $floatRight ?>">Subject *</label>
                  <input type="text" class="form-control" name="subject" required="">
                </div>
                <div class="form-group">
                  <label class="<?= $floatRight ?>">Message</label>
                  <textarea class="form-control" rows="6" name="message" required></textarea>
                </div>
                <?php if($_GET['enquiry_id'] == 1 or $_GET['enquiry_id'] == 2){ ?>
                <div class="form-group">
                  <label class="<?= $floatRight ?>">Order Number *</label>
                  <input type="text" class="form-control" name="order_number" required="">
                </div>
                <div class="form-group">
                  <label class="<?= $floatRight ?>">User Role *</label>
                  <select name="user_role" class="form-control" required>
                    <option value="" class="hidden">Select user role</option>
                    <option>Buyer</option>
                    <option>Seller</option>
                  </select>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label class="<?= $floatRight ?>">Attachment</label>
                  <input type="file" class="form-control" name="file">
                </div>
                <div class="form-group">
                  <label>Please verify that you're part of humanity.</label>
                  <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
                </div>
                <div class="text-center">
                  <button class="btn btn-success btn-lg" name="submit" type="submit">
                  <i class="fa fa-paper-plane"> Submit Request</i>
                  </button>
                </div>
                <?php } ?>
              </form>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!-- Container ends -->
  <?php
    if(isset($_POST['submit'])){
    if(!isset($_SESSION['seller_user_name'])){
      $secret_key = "$recaptcha_secret_key";
      $response = $input->post('g-recaptcha-response');
      $remote_ip = $_SERVER['REMOTE_ADDR'];
      $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$remote_ip");
      $result = json_decode($url, TRUE);
      if($result["success"] == 1 ){
      $enquiry_type = $input->post('enquiry_type');
      $subject = $input->post('subject');
      $email = $input->post('email');
      $message = $input->post('message');
      if($enquiry_type == 1 or $enquiry_type == 2){
        $order_number = $input->post('order_number');
        $order_rule = $input->post('user_role');
      }else{
        $order_number = "";
       $order_rule = "";
      }
      $file = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','txt');
      $file_extension = pathinfo($file, PATHINFO_EXTENSION);
      if(!in_array($file_extension,$allowed) & !empty($file)){
      echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
      }else{
      $file = pathinfo($file, PATHINFO_FILENAME);
      $file = $file."_".time().".$file_extension";
      move_uploaded_file($file_tmp , "ticket_files/$file");
      $date = date("h:i M d, Y");
      $insert_support_ticket = $db->insert("support_tickets",array("enquiry_id" => $enquiry_type,"sender_id" => $login_seller_id,"subject" => $subject,"message" => $message,"order_number" => $order_number,"order_rule" => $order_rule,"attachment" => $file,"date" => $date,"status" => 'open', "email" => $email));
      if($insert_support_ticket){
        $get_enquiry_types = $db->select("enquiry_types",array("enquiry_id" => $enquiry_id));
        $row_enquiry_types = $get_enquiry_types->fetch();
        $enquiry_title = $row_enquiry_types->enquiry_title;

        $ticket_id = $db->lastInsertId();

        $get_support_ticket = $db->select("enquiry_types", array("enquiry_id" => $ticket_id));
        $row_support_ticket = $get_support_ticket->fetch();
        $email = $row_support_ticket->email;
        // Send Email To Admin Code Starts

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {

        if($enable_smtp == "yes"){
        $mail->isSMTP();
        $mail->Host = $s_host;
        $mail->Port = $s_port;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $s_secure;
        $mail->Username = $s_username;
        $mail->Password = $s_password;
        }
        
        $mail->setFrom($contact_email,$site_name);
        $mail->addAddress($contact_email);
        $mail->addReplyTo($login_seller_email);
        $mail->isHTML(true);

        $mail->Subject = $subject;

        if(!empty($file)){
        $mail->Body = "
        <html>
        <head>
        <style>
        .container {
          background: rgb(238, 238, 238);
          padding: 80px;
        }
        @media only screen and (max-device-width: 690px) {
        .container {
        background: rgb(238, 238, 238);
        width:100%;
        padding:1px;
        }
        }
        .box {
          background: #fff;
          margin: 0px 0px 30px;
          padding: 8px 20px 20px 20px;
          border:1px solid #e6e6e6;
          box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
        }
        hr{
          margin-top:20px;
          margin-bottom:20px;
          border:1px solid #eee;
        }
        .table {
          max-width:100%;
          background-color:#fff;
          margin-bottom:20px;
        }
        .table thead tr th {
          border:1px solid #ddd;
          font-weight:bolder;
          padding:10px;
        }
        .table tbody tr td {
          border:1px solid #ddd;
          padding:10px;
        }
        </style>
        </head>
        <body class='is-responsive'>
        <div class='container'>
        <div class='box'>
        <center>
        <img class='logo' src='$site_url/images/logo.png' width='100' >
        <h2> Hello  Admin!</h2>
        <h2> This message has been sent from the customer support form. </h2>
        </center>
        <hr>
        <table class='table'>
        <thead>
        <tr>
        <th> Enquiry Type </th>
        <th> Email Address </th>
        <th> Subject </th>
        <th> Message </th>
        <th> Attachment </th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td> $enquiry_title </td>
        <td> $$email </td>
        <td> $subject </td>
        <td> $message </td>
        <td> '$file' </td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
        </body>
        </html>
        ";
        }else{
        $mail->Body = "
        <html>
        <head>
        <style>
        .container {
          background: rgb(238, 238, 238);
          padding: 80px;
        }
        @media only screen and (max-device-width: 690px) {
        .container {
          background: rgb(238, 238, 238);
        width:100%;
        padding:1px;
        }
        }
        .box {
          background: #fff;
          margin: 0px 0px 30px;
          padding: 8px 20px 20px 20px;
          border:1px solid #e6e6e6;
          box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
        }
        hr{
          margin-top:20px;
          margin-bottom:20px;
          border:1px solid #eee;
        }
        .table {
        max-width:100%; 
        background-color:#fff;
        margin-bottom:20px;
        }
        .table thead tr th {
          border:1px solid #ddd;
          font-weight:bolder;
          padding:10px;
        }
        .table tbody tr td {
          border:1px solid #ddd;
          padding:10px;
        }
        </style>
        </head>
        <body class='is-responsive'>
        <div class='container'>
        <div class='box'>
        <center>
        <img class='logo' src='$site_url/images/logo.png' width='100' >
        <h2> Hello Admin! </h2>
        <h2> This message has been sent from the customer support form. </h2>
        </center>
        <hr>
        <table class='table'>
        <thead>
        <tr>
        <th> Enquiry Type </th>
        <th> Email Address </th>
        <th> Subject </th>
        <th> Message </th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td> $enquiry_title </td>
        <td> $$email </td>
        <td> $subject </td>
        <td> $message </td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
        </body>
        </html>
        ";
        }

        $mail->send();

        }catch(Exception $e){
            
        }
        // Send Email To Admin Code Ends

        /// Send Email To Sender Code Starts 

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
         
            if($enable_smtp == "yes"){
            $mail->isSMTP();
            $mail->Host = $s_host;
            $mail->Port = $s_port;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = $s_secure;
            $mail->Username = $s_username;
            $mail->Password = $s_password;
            }
            
            $mail->setFrom($contact_email,$site_name);
            $mail->addAddress($login_seller_email);
            $mail->addReplyTo($contact_email,$site_name);
            $mail->isHTML(true);

            $mail->Subject = "Message has been received.";
            $mail->Body = "
            <html>
            <head>
            <style>
            .container {
              background: rgb(238, 238, 238);
              padding: 80px;
            }
            @media only screen and (max-device-width: 690px) {
            .container {
              background: rgb(238, 238, 238);
            width:100%;
            padding:1px;
            }
            }
            .box {
              background: #fff;
              margin: 0px 0px 30px;
              padding: 8px 20px 20px 20px;
              border:1px solid #e6e6e6;
              box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
            }
            hr{
              margin-top:20px;
              margin-bottom:20px;
              border:1px solid #eee;
            }
            .lead {
              font-size:16px;
            }
            </style>
            </head>
            <body class='is-responsive'>
            <div class='container'>
            <div class='box'>
            <center>
            <img src='$site_url/images/logo.png' width='100'>
            <h3> Hello $login_seller_user_name, </h3>
            <p class='lead'> Thank you for contacting us. </p>
            <hr>
            <p class='lead'>
            A customer repressentative will be in touch with you shortly.
            </p>
            </center>
            </div>
            </div>
            </body>
            </html>";

            $mail->send();

        }catch(Exception $e){
        
        }

        /// Send Email To Sender Code Ends  
        echo "
        <script>
        swal({
          type: 'success',
          text: 'Message submitted successfully!',
          timer: 6000,
        })
        </script>
        ";
      }
    }
  }
    }else{
    $secret_key = "$recaptcha_secret_key";
    $response = $input->post('g-recaptcha-response');
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$remote_ip");
    $result = json_decode($url, TRUE);
    if($result["success"] == 1 ){
    $enquiry_type = $input->post('enquiry_type');
    $subject = $input->post('subject');
    $message = $input->post('message');
    if($enquiry_type == 1 or $enquiry_type == 2){
      $order_number = $input->post('order_number');
      $order_rule = $input->post('user_role');
    }else{
      $order_number = "";
     $order_rule = "";
    }
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav','txt');
    $file_extension = pathinfo($file, PATHINFO_EXTENSION);
    if(!in_array($file_extension,$allowed) & !empty($file)){
    echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
    }else{
    $file = pathinfo($file, PATHINFO_FILENAME);
    $file = $file."_".time().".$file_extension";
    move_uploaded_file($file_tmp , "ticket_files/$file");
    $date = date("h:i M d, Y");
    $insert_support_ticket = $db->insert("support_tickets",array("enquiry_id" => $enquiry_type,"sender_id" => $login_seller_id,"subject" => $subject,"message" => $message,"order_number" => $order_number,"order_rule" => $order_rule,"attachment" => $file,"date" => $date,"status" => 'open'));
    if($insert_support_ticket){
    $get_enquiry_types = $db->select("enquiry_types",array("enquiry_id" => $enquiry_id));
    $row_enquiry_types = $get_enquiry_types->fetch();
    $enquiry_title = $row_enquiry_types->enquiry_title;
    // Send Email To Admin Code Starts

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {

    if($enable_smtp == "yes"){
    $mail->isSMTP();
    $mail->Host = $s_host;
    $mail->Port = $s_port;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = $s_secure;
    $mail->Username = $s_username;
    $mail->Password = $s_password;
    }
    
    $mail->setFrom($contact_email,$site_name);
    $mail->addAddress($contact_email);
    $mail->addReplyTo($login_seller_email);
    $mail->isHTML(true);

    $mail->Subject = $subject;

    if(!empty($file)){
    $mail->Body = "
    <html>
    <head>
    <style>
    .container {
      background: rgb(238, 238, 238);
      padding: 80px;
    }
    @media only screen and (max-device-width: 690px) {
    .container {
    background: rgb(238, 238, 238);
    width:100%;
    padding:1px;
    }
    }
    .box {
      background: #fff;
      margin: 0px 0px 30px;
      padding: 8px 20px 20px 20px;
      border:1px solid #e6e6e6;
      box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
    }
    hr{
      margin-top:20px;
      margin-bottom:20px;
      border:1px solid #eee;
    }
    .table {
      max-width:100%;
      background-color:#fff;
      margin-bottom:20px;
    }
    .table thead tr th {
      border:1px solid #ddd;
      font-weight:bolder;
      padding:10px;
    }
    .table tbody tr td {
      border:1px solid #ddd;
      padding:10px;
    }
    </style>
    </head>
    <body class='is-responsive'>
    <div class='container'>
    <div class='box'>
    <center>
    <img class='logo' src='$site_url/images/logo.png' width='100' >
    <h2> Hello  Admin!</h2>
    <h2> This message has been sent from the customer support form. </h2>
    </center>
    <hr>
    <table class='table'>
    <thead>
    <tr>
    <th> Enquiry Type </th>
    <th> Email Address </th>
    <th> Subject </th>
    <th> Message </th>
    <th> Attachment </th>
    <th> Sender Username </th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td> $enquiry_title </td>
    <td> $login_seller_email </td>
    <td> $subject </td>
    <td> $message </td>
    <td> '$file' </td>
    <td> $login_seller_user_name </td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>
    </body>
    </html>
    ";
    }else{
    $mail->Body = "
    <html>
    <head>
    <style>
    .container {
      background: rgb(238, 238, 238);
      padding: 80px;
    }
    @media only screen and (max-device-width: 690px) {
    .container {
      background: rgb(238, 238, 238);
    width:100%;
    padding:1px;
    }
    }
    .box {
      background: #fff;
      margin: 0px 0px 30px;
      padding: 8px 20px 20px 20px;
      border:1px solid #e6e6e6;
      box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
    }
    hr{
      margin-top:20px;
      margin-bottom:20px;
      border:1px solid #eee;
    }
    .table {
    max-width:100%; 
    background-color:#fff;
    margin-bottom:20px;
    }
    .table thead tr th {
      border:1px solid #ddd;
      font-weight:bolder;
      padding:10px;
    }
    .table tbody tr td {
      border:1px solid #ddd;
      padding:10px;
    }
    </style>
    </head>
    <body class='is-responsive'>
    <div class='container'>
    <div class='box'>
    <center>
    <img class='logo' src='$site_url/images/logo.png' width='100' >
    <h2> Hello Admin! </h2>
    <h2> This message has been sent from the customer support form. </h2>
    </center>
    <hr>
    <table class='table'>
    <thead>
    <tr>
    <th> Enquiry Type </th>
    <th> Email Address </th>
    <th> Subject </th>
    <th> Message </th>
    <th> Sender Username </th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td> $enquiry_title </td>
    <td> $login_seller_email </td>
    <td> $subject </td>
    <td> $message </td>
    <td> $login_seller_user_name </td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>
    </body>
    </html>
    ";
    }

    $mail->send();

    }catch(Exception $e){
        
    }

    // Send Email To Admin Code Ends

    /// Send Email To Sender Code Starts 

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
     
        if($enable_smtp == "yes"){
        $mail->isSMTP();
        $mail->Host = $s_host;
        $mail->Port = $s_port;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $s_secure;
        $mail->Username = $s_username;
        $mail->Password = $s_password;
        }
        
        $mail->setFrom($contact_email,$site_name);
        $mail->addAddress($login_seller_email);
        $mail->addReplyTo($contact_email,$site_name);
        $mail->isHTML(true);

        $mail->Subject = "Message has been received.";
        $mail->Body = "
        <html>
        <head>
        <style>
        .container {
          background: rgb(238, 238, 238);
          padding: 80px;
        }
        @media only screen and (max-device-width: 690px) {
        .container {
          background: rgb(238, 238, 238);
        width:100%;
        padding:1px;
        }
        }
        .box {
          background: #fff;
          margin: 0px 0px 30px;
          padding: 8px 20px 20px 20px;
          border:1px solid #e6e6e6;
          box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);      
        }
        hr{
          margin-top:20px;
          margin-bottom:20px;
          border:1px solid #eee;
        }
        .lead {
          font-size:16px;
        }
        </style>
        </head>
        <body class='is-responsive'>
        <div class='container'>
        <div class='box'>
        <center>
        <img src='$site_url/images/logo.png' width='100'>
        <h3> Hello $login_seller_user_name, </h3>
        <p class='lead'> Thank you for contacting us. </p>
        <hr>
        <p class='lead'>
        A customer repressentative will be in touch with you shortly.
        </p>
        </center>
        </div>
        </div>
        </body>
        </html>";

        $mail->send();

    }catch(Exception $e){
  
    }

    /// Send Email To Sender Code Ends  
    echo "
    <script>
    swal({
      type: 'success',
      text: 'Message submitted successfully!',
      timer: 6000,
    })
    </script>
    ";
    }
    }
    }else{
    echo "
    <script>
    swal({
      type: 'warning',
      text: 'Please select captcha and try again!',
      timer: 6000,
    })
    </script>"; 
    }
    }
    }
  ?>
  <?php require_once("includes/footer.php"); ?>
  <script>
  $(document).ready(function(){
    $(".select_tag").change(function(){
      url = $(".select_tag option:selected").attr('url');
      window.location.href = url;
    });
  });
  </script>
</body>
</html>