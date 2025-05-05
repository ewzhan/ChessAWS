<?php 

//4 IMPORTANT INFORMATION NEEDED BY DB
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "chess");

        if(isset($_POST["login"])){
            //user click/ submit the page
            //1.1 receive user input from form
            $id = trim($_POST["email"]);
            $pw = ($_POST["pass"]);
            $gCaptcha = ($_POST["gCaptcha"]);
            $captcha = ($_POST["captcha"]);
    
           
           if(strcmp($id, 'admin')==0){
               //admin login
               //GOOD, sui no error
               //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "SELECT password, UserID FROM user
             WHERE email = '$id'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql) 
         $stmt = $con->query($sql);
         
         if($row = $stmt->fetch_object()){
                //record found
                $apw = $row->password;
                $uid = $row->UserID;
            }else{
                //record is not found
                echo "Unable to process.
                [ <a href='login.php'>Try again.</a> ]";
            }
            
         if(strcmp($pw, $apw)==0){
             //pw correct
              
              $cookie_name = "admin";
              $cookie_value = "$uid";
              setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
              echo "<script>window.location.href='staff/staff-index.php?user=$cookie_name'</script>";
         }else{
             //wrong password
             echo "Wrong Password, Unable to Login. 
             Please try again!";
         }
         $con->close();
         $stmt->close();
         
            
           }else{
               //user login
               //1.2 check/validate/ verify member detail
           $error["id"] = checkUserID($id);
           $error["captcha"] = checkCaptcha($captcha, $gCaptcha);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
               //GOOD, sui no error
               //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "SELECT password, UserID, attempts, time, loginCount FROM user
             WHERE email = '$id'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->query($sql);
         
         if($row = $stmt->fetch_object()){
                //record found
                $hashed_password = $row->password;
                $uid = $row->UserID;
                $attempts = $row->attempts;
                $t = $row->time;
                $loginCount = $row->loginCount;
            }else{
                //record is not found
                echo "Unable to process.
                [ <a href='login.php'>Try again.</a> ]";
            }
        if($attempts<5){
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
         if(password_verify($pw, $hashed_password)){
             //pw correct
             $sql = "UPDATE user SET 
                 attempts = ?,
                 loginCount = ?
                 WHERE email = '$id'";
             $loginCount++;
         $attempts = 0;
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("ii", $attempts, $loginCount);
         $stmt->execute();
         
         
              $cookie_name = "user";
              $cookie_value = "$uid";
              setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
              echo "<script>window.location.href='index.php?user=$cookie_name'</script>";
              
         }else{
             //wrong password
             echo "Wrong Password, Unable to Login. 
             Please try again!";
             $attempts++;

         $sql = "UPDATE user SET
                 attempts = ? 
                 WHERE email = '$id'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql) 
        $stmt = $con->prepare($sql);
        $stmt -> bind_param("i", $attempts);
         $stmt->execute();
         }
          if($attempts == 4){
     $t = time();
     $sql = "UPDATE user SET
            time = $t 
            WHERE email = '$id'";
     $stmt = $con->query($sql);
  }
         
 }else{
    echo "sorry you have to wait 5 min to log in again";
    //Check elapsed time
    //5 minute timeout
    if ($t + 5 * 60 < time()) {
       $attempts = 0;
       $t = 0;
       //code to write $attempts to table attempts
       $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "UPDATE user SET
                 attempts = ?, time = ?
                 WHERE email = '$id'";
        $stmt = $con->prepare($sql);
         $stmt -> bind_param("ii", $attempts, $t);
         $stmt->execute();
    }
}
        $stmt->close();
         $con->close();
         
           }else{
               //WITH ERROR, display error msg
               echo "<ul class='error'>";
               foreach ($error as $value){
                   echo "<li>$value</li>";
               }
               echo "</ul>";
               
           }
           
        }
        }
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
    
            $number = uniqid();
            $varray = str_split($number);
            $len = sizeof($varray);
            $gCaptcha = array_slice($varray, $len-6, $len);
            $gCaptcha = implode(",", $gCaptcha);
            $gCaptcha = str_replace(',', '', $gCaptcha);
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
function checkCaptcha($captcha, $gCaptcha){
        // CAPTCHA validation successful
    if($captcha==null){
        return "Please enter your <b>Captcha</b>";
        
    } else if( $captcha != $gCaptcha){
        // CAPTCHA validation failed
        return "CAPTCHA validation failed. Please try again.";
    }
}
  ?>
    
    

<main class="main">
<div class="limiter">
    <div class="container-login100">
	<div class="wrap-login100">
            <form class="login100-form" method="POST">
                <span class="login100-form-title">Welcome</span>
                <div id="loginLogo">
                    <img src="assets/img/chess_logo.png" >
                </div>
               

		<div class="wrap-input100">
                    <input class="input100" type="text" name="email" value="<?php echo isset($id)? $id : ""; ?>">
                    <span class="focus-input100" data-placeholder="Email"></span>
		</div>

		<div class="wrap-input100">
                    <!--<span class="btn-show-pass"><i class="zmdi zmdi-eye"></i></span>-->
                    <input class="input100" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="Password"></span>
		</div>
                <p class="txt1">CAPTCHA: <?php echo $gCaptcha ?></p>
                <input type="hidden" name="gCaptcha" value="<?php echo $gCaptcha ?>">
                <input type="text" name="captcha" placeholder="Enter CAPTCHA"><br><br>
		<div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
			<div class="login100-form-bgbtn"></div>
                       	<button type="submit" name="login" class="login100-form-btn">Login</button>
                    </div>
                </div>
                
                <div class="loginTxt">
                
                <div class="text-center ">
                    <span class="txt1">Forgot your password?</span>
                    <a class="txt2" href="resetpw.php">Find</a>
		</div>

		<div style="text-align: center; margin-top: 10px;">
                        <span class="txt1">Don’t have an account?</span>
                    <a class="txt2" href="register.php">Sign Up</a>
        	</div>

                </div>
            </form>
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