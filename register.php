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
    function checkUserName($name){
    if($name == null){
        return "Please enter your <b>name</b>.";
        
    }else if(strlen($name) >30){
        return "Your <b>name</b> is too long.";
        
    }else if(!preg_match("/^[A-Za-z \.]+$/", $name)){
        return 'Invalid <b>name</b>.';
    }
    
}



//create function to check duplicated(SAME) Student ID
function checkSameUserID($id){
    $found = false;
    
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
         $found = true;
     }else{
         //no result found -> NO PROBLEM
     }
     $result->free(); //release memory usage
     $con->close();
     
     return $found; 
}


//create function to check student ID
function checkUserID($id){
    if($id==null){
        return "Please enter your <b>Email</b>";
        
    }else if(!preg_match("/^[0-9A-Za-z]+@gmail.com$/",
                            $id)){
        return "Invalid <b>Email</b>";
        
    }else if(checkSameUserID($id)){
        return "Same <b>Email</b> detected. 
        Please try a new Email.";
        
    }
}

//create function to check student ID
function checkConPass($conpass, $pw){
    if($conpass==null){
        return "Please enter your <b>Confirm Password</b>";
        
    }else if(strcmp($conpass, $pw)!= 0){
        return "Your password didnt <b>SAME</b>. 
        Please enter the same confirm password.";
        
    }
}

//4 IMPORTANT INFORMATION NEEDED BY DB
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "chess");


  ?>
    
<?php 
        if(!empty($_POST)){
            //user click/ submit the page
            //1.1 receive user input from form
            $id = trim($_POST["email"]);
            $pw = ($_POST["pass"]);
            $name = trim($_POST["txtName"]);
            $conpass = ($_POST["con-pass"]);
            $contact = ($_POST["contact"]);
            $profilePic = 'profile.webp';
            //1.2 check/validate/ verify member detail
           $error["id"] = checkUserID($id);
           $error["name"] =checkUserName($name);
           $error["con-pass"] = checkConPass($conpass, $pw);
           
           
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           
           $hashed_password = password_hash($pw, PASSWORD_DEFAULT);
           if(empty($error)){
               //GOOD, sui no error
               //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //make a unique id for userID
         $save_id = 'UID'.uniqid();
         //Step 2: sql statement
         $sql = "INSERT INTO user
                 (email, UserName, password, contact, UserID, profilePicture, attempts, time, loginCount) 
                 VALUES(?,?,?,?,?,?,0,0,0)";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql) 
         $stmt = $con->prepare($sql);
         
         //Step 3.1: prepare parameter for sql with "?"
         //NOTE: s - string, d - double, i - integer, b - blob
         $stmt->bind_param("ssssss",
                 $id, $name, $hashed_password, $contact, $save_id, $profilePic);
         
         //Step 3.2: execute
         $stmt->execute();
         
         //NOTE:$stmt->affected_rows (this code will only apply to
         // CUD)
         //NOTE: $con->num_rows (how many row of records return) - R
         if($stmt->affected_rows > 0){
             //insert successfully
             printf("
                 <div class='info'>
                 Your <b>%s</b> has been successfully registered. <a href='login.php'>Login</a>
                 </div>", $id);
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
    
<main class="main">
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                            <form class="login100-form validate-form" action="" method="POST">
					<span class="login100-form-title">
                                            Welcome
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="email" value="<?php echo isset($id)? $id : ""; ?>">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						
						<input class="input100" type="password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

                                        <div class="wrap-input100 validate-input" data-validate="con-pass">
                                                
						<input class="input100" type="password" name="con-pass">
						<span class="focus-input100" data-placeholder="Confirm Password"></span>
					</div>

          <div class="wrap-input100 validate-input" data-validate="Valid Name">
						<input class="input100" type="text" name="txtName" value="<?php echo isset($name)? $name : ""; ?>">
						<span class="focus-input100" data-placeholder="Enter Your Name"></span>
					</div>

          <div class="wrap-input100 validate-input" data-validate="Valid Contact Number" >
						<input class="input100" type="text" name="contact" value="<?php echo isset($contact)? $contact : ""; ?>">
						<span class="focus-input100" data-placeholder="Contact Number"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" value="Insert" name="btnInsert">
								Register
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Already have an account?
						</span>

						<a class="txt2" href="login.php">
							Sign In
						</a>
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