<?php 
require_once './secret/database.php';
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if(isset(($_GET["email"]))){
        $id = ($_GET["email"]);
    }else{
        $id ="";
    }
}

        if(!empty($_POST)){
            //user click/ submit the page
            //1.1 receive user input from for
            $pw = ($_POST["pass"]);
            $conpass = ($_POST["con-pass"]);
            
            //1.2 check/validate/ verify member detail
           $error["con-pass"] = checkSamePassword($conpass, $pw);
           
           
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           
           $hashed_password = password_hash($pw, PASSWORD_DEFAULT);
           if(empty($error)){
               //GOOD, sui no error
               //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "UPDATE user SET
                 password = ?
                 WHERE email = '$id'";
         
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql) 
         $stmt = $con->prepare($sql);
         
         //Step 3.1: prepare parameter for sql with "?"
         //NOTE: s - string, d - double, i - integer, b - blob
         $stmt->bind_param("s",$hashed_password);
         
         //Step 3.2: execute
         $stmt->execute();
         
         //NOTE:$stmt->affected_rows (this code will only apply to
         // CUD)
         //NOTE: $con->num_rows (how many row of records return) - R
         if($stmt->affected_rows > 0){
             //insert successfully
             printf("
                 <div class='info'>
                 Your <b>Password</b> has been successfully registered. <a href='login.php'>Login</a>
                 </div>");
            }else{
             //unable to insert
            echo "Database Error, Unable to insert. 
             Please try again!";
         }
         $con->close();
         $stmt->close();      
           }else{
               //WITH ERROR, display error msg
               echo "<ul class='error'>";
               foreach ($error as $value){
                   echo "<li>$value</li>";
               }
               echo "</ul>";
               
           }
        }
        ?>    

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Reset Password 2</title>
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
function checkSamePassword($conpass, $pw){
    if ($conpass == null){
        return "Please enter <b>confirm password</b>";
        
    }else if(strcmp($conpass, $pw) != 0){
        return "The confirm password didn't match the password";
        
    }
}

//create function to check user email
function checkPassword($pw){
    if($pw==null){
        return "Please enter your <b>Password</b>";
        
    }
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
                <form action="" method="POST">
                <div>
                    <div class="wrap-input100">
                    <input class="input100" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="Enter New Password"></span>
                    </div>
                    
                    <div class="wrap-input100">
                        <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
			</span>
			<input class="input100" type="password" name="con-pass">
                        <span class="focus-input100" data-placeholder="Confirm Password"></span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
			<div class="login100-form-bgbtn"></div>
                       	<button type="submit" class="login100-form-btn" value="submit">Submit</button>
                    </div>
                    </div>
                    
                </div>
                </form>
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