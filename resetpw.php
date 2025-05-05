<?php 
require_once './secret/database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

$usernameErr = $passwordErr = $confirmPasswordErr = $emailErr = "";
$username = $password = $confirmPassword = $email = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Chess Society</title>
  <meta content="Chess Society" name="description">
  <meta content="Chess, Chess Society" name="keywords">

  <link href="assets/img/chess_logo.png" rel="icon">
  <link href="assets/img/chess_logo.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/iconic/css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css"/>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" type="text/css"/>
  <link href="assets/css/login.css" rel="stylesheet" type="text/css"/>
  
</head>
<body>
  <?php
    //create function to check duplicated(SAME) email
function checkSameUserID($id){
    $found = true;
    
    //Step 1: create connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    //Step 1.1 clean $id, remove special character, prevent
    //sql error when exexuting sql code
    $id = $con->real_escape_string($id);
    
    //Step 2: sql statement
     $sql ="SELECT * FROM user WHERE email = '$id'";
     
     //Step 3.process sql
     $result = $con->query($sql);
     
     if($result->num_rows >0){
         //result found -> SAME STUDENT ID DETECTED
         $found = false;
     }else{
         //no result found -> NO PROBLEM
     }
     $result->free(); //release memory usage
     $con->close();
     
     return $found; 
}

//create function to check user email
function checkUserID($id){
    if($id==null){
        return "Please enter your <b>Email</b>";
        
    }else if(!preg_match("/^[0-9A-Za-z]+@gmail.com$/",
                            $id)){
        return "Invalid <b>Email</b>";
        
    }else if(checkSameUserID($id)){
        return "<b>Email</b> didn't exist. 
        Please try another Email or make new <a href='register.php'>register.</a>";
        
    }
}

if(isset($_GET['email'])){
            $id = trim($_GET['email']);
            }else{
                $id="";
            }

  ?>
<main class="main">
<div class="limiter">
    <div class="container-login100">
	<div class="wrap-login100">
            
                <span class="login100-form-title">Welcome</span>
                <div id="loginLogo">
                    <img src="assets/img/chess_logo.png" >
                </div>
                <div id="resetPage">
                    
                    <form action="" method="GET">
		<div class="resetPw">
                    <input class="input100 <?php echo isset($id)? "has-val" : ""; ?>" type="text" name="email" value="<?php echo isset($id)? $id : ""; ?>">
                    <span class="focus-input100" data-placeholder="Email"></span>
		</div>
                
                    <div class="wrap-login100-form-btn resetPsBtn">
			<div class="login100-form-bgbtn"></div>
                       	<input type="submit" class="resetSendBtn" value="Send OTP" >
                    </div>
                       </form>
        
                <?php if($_SERVER["REQUEST_METHOD"]=="GET"){
            //GET METHOD
                    
            //validate user's email
            $error["id"] = checkUserID($id);
           
            //NOTE: when the $error array contains null value
            //array_filter() will remove it
            $error = array_filter($error);
            if(empty($error)){
               //GOOD, sui no error
               $number = uniqid();
               $varray = str_split($number);
               $len = sizeof($varray);
               $otp = array_slice($varray, $len-5, $len);
               $otp = implode(",", $otp);
               $otp = str_replace(',', '', $otp);
               
            date_default_timezone_set('Asia/Kuala_Lumpur');

            require_once 'includes/class.phpmailer.php';

            // Instantiate the PHPMailer object.
            // With exception handling turned on (i.e. the "true").
            $mail = new PHPMailer(true);

            // Indicate it is an SMTP mail.
             // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'wenzhaneu@gmail.com'; // Replace with your SMTP username
        $mail->Password = 'hfyexhizubwjqsmu'; // Replace with your SMTP password
        $mail->Port = 587; // Replace with your SMTP port
        $mail->SMTPSecure = 'tls'; // Replace with 'tls' or 'ssl' based on your SMTP settings

            try
            {
                // Mail details.
                $mail->SetFrom('wenzhaneu@gmail.com', 'PHP Admin'); // Your Gmail address.
                $mail->AddAddress($id, 'User');
                $mail->Subject  = 'PHP Mailer';
                $mail->Body     = 'Here is your OTP --> ' . $otp . "\n" .
                                  'Mail sent at ' . date('d-F-Y h:i:s A');
            
                $mail->Send();
                echo '<p class="ok">Message successfully sent!</p>';
            }
            catch (Exception $e)
            {
                //echo '<p class="error">' . $e->getMessage() . '</p>';
            }
            //1.3 create token based on email and store token in database 
            //1.4 send email to user, in the email, include clickable link
            printf('
                <form action="" method="POST">
                <div> 
		<div class="resetPw">
                    <input class="input100" type="text" name="otp">
                    <span class="focus-input100" data-placeholder="OTP"></span>
		</div>

		<div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
			<div class="login100-form-bgbtn"></div>
                       	<input type="submit" class="resetSendBtn" value="submit">
                    </div>
                </div>
                </div>
                </form>
                               ');
            }else{
               //WITH ERROR, display error msg
               echo "<ul class='error'>";
               foreach ($error as $value){
                   echo "<li>$value</li>";
               }
               echo "</ul>";    
            }
        }else{
            
            //POST METHOD
             $uotp = ($_POST["submit"]);
             $id = trim($_GET['email']);
            if(strcmp($uotp, $otp)==0){
                echo "<script>window.location.href='resetpw2.php?id=$id'</script>";
                
            }
        }
        ?>
                </div>     
                <div class="loginTxt">
                    <div style="text-align: center; margin-top: 10px;">   
                        <a class="txt2" href="login.php">Back</a>
                    </div>
                </div>
	</div>
    </div>
</div>
</main>

<script src="assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script>  
(function ($) {
    "use strict";

    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        });
    });
  
})(jQuery);
</script>
</body>
</html>