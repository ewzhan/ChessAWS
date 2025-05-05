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

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
div#changeInfo2,div#changeInfo3,div#changeInfo4,div#changeInfo5,div#changeInfo6,div#changeInfo7,div#changeInfo8{
  position: fixed;
  width: 1320px;
  z-index: 999;
  display: none;
}
  </style>
</head>

<body>
<?php
    include './general/header.php';
    
    //4 IMPORTANT INFORMATION NEEDED BY DB
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "chess");
    if(isset($_COOKIE[$cookie_name])){
        $userid = $_COOKIE[$cookie_name];
        
        
        //Step 1:establish (create) connection to DB
                //NOTE: new keyword - instantiate object
                //NOTE: parameter inside mysqli() SEQUENCE VERY
                //IMPORTANT
                $con = new mysqli(DB_HOST,
                        DB_USER, DB_PASS, DB_NAME);
                
                //checking database connection
                //are there errors?
                //NOTE: => associative array
                //NOTE: ->only for DB
                if($con->connect_error){
                    die("Connection failed: ". $con->connect_error);
                }
                
                //sql statement
                //SELECT *
                //FROM Student
                //WHERE Program LIKE FT
                //ORDER BY StudentName ASC
                $sql = "SELECT * 
                        FROM user 
                        WHERE UserID = '$userid'";
               
                
                //pass sql into connection to execute
                $result = $con->query($sql);
                
                //check if $result contains record??
                if($result->num_rows >0){
                    //record returned
                    
                    while($row = $result->fetch_object()){
                        $uid = $row->UserID;
                        $username = $row->UserName;
                        $contact = $row->contact;
                        $address = $row->address;
                        $gender = $row->gender;
                        $age = $row->age;
                        $email = $row->email;
                        $password = $row->password;
                        $profilePic = $row->profilePicture;
                    }
                }
                
                $result->free();
                $con->close();
        
        

         if(isset($_POST["updateName"])){
             //get user input
             $fname = $_POST["FirstName"];
             $lname = $_POST["LastName"];
             //check user input
             //create function to check student name 
            function checkUserFName($fname){
                if($fname == null){
                    return "Please enter your first name.";

                }else if(strlen($fname) >30){
                    return "Your first name is too long.";

                }else if(!preg_match("/^[A-Za-z \.]+$/", $fname)){
                    return 'Invalid first name.';
                }
            }
            function checkUserLName($lname){
                if($lname == null){
                    return "Please enter your last name.";

                }else if(strlen($lname) >30){
                    return "Your last name is too long.";

                }else if(!preg_match("/^[A-Za-z \.]+$/", $lname)){
                    return 'Invalid last name.';
                }
            }
           $error["FirstName"] = checkUserFName($fname);
           $error["LastName"] = checkUserLName($lname);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
             $name = $fname.' '.$lname;
         //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "UPDATE user SET 
             UserName = ?
             WHERE UserID = '$userid'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("s", $name);
         $stmt->execute();
         
         $con->close();
         $stmt->close();
         echo "<script>window.location.href='profile.php'</script>";
         }else{
               //WITH ERROR, display error msg
             foreach ($error as $value){
                   echo "<script>alert('$value');</script>"; 
               }
             
           }

        }elseif(isset($_POST["updateAge"])){
            //get user input
             $uAge = $_POST["uAge"];
             //check user input
             //create function to check student name 
            function checkUserAge($uAge){
                if($uAge == null){
                    return "Please enter your age.";
                }else if(!preg_match("/^[0-9]{2}$/", $uAge)){
                    return 'Invalid Age.';
                }

            }
           $error["uAge"] = checkUserAge($uAge);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
         //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "UPDATE user SET 
             age = ?
             WHERE UserID = '$userid'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("i", $uAge);
         $stmt->execute();
         
         $con->close();
         $stmt->close();
         echo "<script>window.location.href='profile.php'</script>";
         }else{
               //WITH ERROR, display error msg
               foreach ($error as $value){
                   echo "<script>alert('$value');</script>"; 
               }
           }
        }elseif(isset($_POST["updateGender"])){
            //get user input
             $uGender = $_POST["uGender"];
             //check user input
             //create function to check student name 
            //function check gender
            function checkGender($gender){
                if($gender == null){
                    return "Please select your Gender.";

                }else if(!array_key_exists($gender, getGender())){
                    //whatever user select is NOT in our list
                    return "Hello, wrong gender!";
                }
            }
            
            //function to return all types of gender
            function getGender(){
                return array(
                    'M' => '👦 Male',
                    'F' => '👧 Female'
                );
            }
            
            
           $error["uGender"] = checkGender($uGender);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
         //Step 1: create connection 
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "UPDATE user SET 
             gender = ?
             WHERE UserID = '$userid'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("s", $uGender);
         $stmt->execute();
         
         $con->close();
         $stmt->close();
         echo "<script>window.location.href='profile.php'</script>";
         }else{
               //WITH ERROR, display error msg
               foreach ($error as $value){
                   echo "<script>alert('$value');</script>"; 
               }
           }
        }elseif(isset($_POST["updateContact"])){
            //get user input
             $uContact = $_POST["uContact"];
             //check user input
             //create function to check student name 
            function checkContact($uContact){
                if($uContact == null){
                    return "Please enter your contact.";
                }else if(!preg_match("/^[0-9]{10}$/", $uContact)){
                    return 'Invalid Contact.';
                }

            }
           $error["uContact"] = checkContact($uContact);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
         //Step 1: create connection
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "UPDATE user SET 
             contact = ?
             WHERE UserID = '$userid'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("i", $uContact);
         $stmt->execute();
         
         $con->close();
         $stmt->close();
         echo "<script>window.location.href='profile.php'</script>";
         }else{
               //WITH ERROR, display error msg
               foreach ($error as $value){
                   echo "<script>alert('$value');</script>"; 
               }
           }
        }elseif(isset($_POST["updateAddress"])){
            //get user input
             $uAddress = $_POST["uAddress"];
             //check user input
             //create function to check student name 
            function checkAddress($uAddress){
                if($uAddress == null){
                    return "Please enter your Address.";
                }
            }
           $error["uAddress"] = checkAddress($uAddress);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
         //Step 1: create connection
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
         //Step 2: sql statement
         $sql = "UPDATE user SET 
             address = ?
             WHERE UserID = '$userid'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("s", $uAddress);
         $stmt->execute();
         
         $con->close();
         $stmt->close();
         echo "<script>window.location.href='profile.php'</script>";
         }else{
               //WITH ERROR, display error msg
             foreach ($error as $value){
                   echo "<script>alert('$value');</script>"; 
               }
           }
        }elseif(isset($_POST["updatePassword"])){
            //get user input
             $oldPassword = $_POST["oldPassword"];
             $conPassword = $_POST["conPassword"];
             $uPassword = $_POST["uPassword"];
             //check user input
             //create function to check student name 
            function checkOldPassword($oldPassword, $password){
                if($oldPassword == null){
                    return "Please enter your Old Password.";
                }elseif(!password_verify($oldPassword, $password)){
                    return "The Old Password didn't match!";
                }
            }
            function checkConPassword($conPassword, $uPassword){
                if($conPassword == null){
                    return "Please enter your Confirm Password.";
                }elseif(strcmp($conPassword, $uPassword)!=0){
                    return "The Confirm Password didn't match New Password!";
                }
            }
            
           $error["oldPassword"] = checkOldPassword($oldPassword, $password);
           $error["conPassword"] = checkConPassword($conPassword, $uPassword);
           //NOTE: when the $error array contains null value
           //array_filter() will remove it
           $error = array_filter($error);
           if(empty($error)){
         //Step 1: create connection
         $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         $hashed_password = password_hash($uPassword, PASSWORD_DEFAULT);
         //Step 2: sql statement
         $sql = "UPDATE user SET 
             password = ?
             WHERE UserID = '$userid'";
               
         //step 3:process sql
         //NOTE: $con->query($sql) <<<<<< when there is NO "?" in sql
         //NOTE: $con->prepare($sql)
         $stmt = $con->prepare($sql);
         $stmt -> bind_param("s", $hashed_password);
         $stmt->execute();
         
         $con->close();
         $stmt->close();
         echo '<script>alert("Password Successfully Changed.")</script>';
         echo "<script>window.location.href='profile.php'</script>";
         }else{
               //WITH ERROR, display error msg
               foreach ($error as $value){
                   echo "<script>alert('$value');</script>"; 
               }
           }
        }elseif(isset($_POST["updateProfile"])){
              if(isset($_FILES['proPicture'])){
            $file = $_FILES['proPicture'];
            
            if($file['error']>0){
                switch ($file['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $err = 'No file was selected.';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $err = 'File uploaded is too large.Maximum 1MB allowed.';
                        break;
                    default:
                        $err = 'There was an error while uploading the file.';
                        break;
                }
            }else if($file['size'] > 1048576){
                $err = 'File uploaded is too large.Maximum 1MB allowed.';
            }else{
                $ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
                
                if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'png'){
                    $err = 'Only JPG, GIF and PNG format are allowed.';
                }else{
                    //everything good
                    $save_as = uniqid().'.'.$ext;
                    move_uploaded_file($file['tmp_name'], 'profileImage/'.$save_as);
                    
                }
            }
            
        }
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "UPDATE user SET profilePicture = '$save_as' WHERE UserID = '$userid'";
        if($result = $con -> query($sql)){
            echo "Succesful to update profile";
        }
           $con->close(); 
        }
      
                
    }
?>
    
  <main class="main">
    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
          <div class="main-body">
            <div class="row">
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-body">

                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="./profileImage/<?php echo $profilePic?>" alt="Default" class="rounded-circle bg-primary " width="150" height="154">
                      <div class="mt-2">
                          <h4><?php echo isset($cookie_name)?$cookie_name:""?></h4>
                        <p class="text-secondary mb-1"><b>Profile</b></p>
                        <button class="infoRow resetPass text-secondary mb-1"onclick="document.getElementById('changeInfo8').style.display='block';
                            document.body.style.overflow = 'hidden';">Upload Profile Picture</button>
                        <p class="text-secondary mb-1"><b>User ID</b></p>
                        <p class="text-muted font-size-sm dateText"><?php echo $uid?></p>
                      </div>
                    </div>
                    <!--
                    <h5 class="d-flex align-items-center mb-3">Ticket Purchase Summary</h5>
                    <div id="piechart"></div>
                      -->
                      <div class="infoRow resetPass"onclick="document.getElementById('changeInfo2').style.display='block';
                         document.body.style.overflow = 'hidden';">
                        <div class="info" id="info" >
                          <div class="col-sm-2" style="width: 94.7%;">
                            <h6 class="mb-0">Password Reset</h6>
                          </div>                      
                          <i class="bi bi-chevron-right"></i>
                        </div>  
                      </div>
                  </div>
                </div>
              </div>

              <!-- User Change Information-->
              <div class="col-lg-8" id="changeInfo">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">First Name</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="text" class="form-control" name="FirstName">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Last Name</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" name="LastName">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateName" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              
              <!-- User Change Information reset pw-->
              <div class="col-lg-8" id="changeInfo2">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Old Password</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="text" class="form-control" name="oldPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">New Password</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" name="uPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Confirm Password</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" name="conPassword">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo2').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updatePassword" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              <!-- User Change Information reset age-->
              <div class="col-lg-8" id="changeInfo3">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Age (two digit)</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="text" class="form-control" name="uAge">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo3').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateAge" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              <!-- User Change Information reset gender-->
              <div class="col-lg-8" id="changeInfo4">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Gender</h6>
                      </div>
                          <select class="col-sm-9" name="uGender">
                              <option>M</option>
                              <option>F</option>
                              </select>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo4').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateGender" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              <!-- User Change Information reset email-->
              <div class="col-lg-8" id="changeInfo5">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="text" class="form-control" name="uEmail">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo5').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateEmail" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              <!-- User Change Information reset phone-->
              <div class="col-lg-8" id="changeInfo6">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Contact</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="text" class="form-control" name="uContact">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo6').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateContact" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              <!-- User Change Information reset address-->
              <div class="col-lg-8" id="changeInfo7">
                  <form action="" method="POST">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Address</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="text" class="form-control" name="uAddress">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo7').style.display='none'">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateAddress" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>
              <!-- User Change Information reset address-->
              <div class="col-lg-8" id="changeInfo8">
                  <form action="" method="POST" enctype="multipart/form-data">
                <div class="card">
                  <div class="card-body changeRow">

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Profile Picture</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
                          <input type="hidden" name="userProfile" value="<?php $save_as?>">
                          <input type="file" class="form-control" name="proPicture">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <h6 class="mb-0"></h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      </div>
                    </div>

                    <div class="row buttonRow">

                      <div>
                        <input type="button" class="btn px-4 cancelBtn" value="Cancel"
                        onclick="document.getElementById('changeInfo8').style.display='none';">
                      </div>

                      <div>
                        <input type="submit" class="btn px-4 saveBtn" name="updateProfile" value="Save">
                      </div>
                    </div>
                  </div>
                </div>
                      </form>
              </div>

              <!--User Information-->
              <div class="col-lg-8">
                <div class="card">
                  <div class="card-body">

                    <div class="infoRow" onclick="document.getElementById('changeInfo').style.display='block';
                         document.body.style.overflow = 'hidden';">
                      <div class="info" id="info">
                        <div class="col-sm-2">
                          <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          <?php echo $username ?>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                      </div>  
                    </div>

                    <div class="infoRow" onclick="document.getElementById('changeInfo3').style.display='block';
                         document.body.style.overflow = 'hidden';">
                      <div class="info">
                        <div class="col-sm-2">
                          <h6 class="mb-0">Age</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          <?php echo $age ?>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                      </div>  
                    </div>

                    <div class="infoRow" onclick="document.getElementById('changeInfo4').style.display='block';
                         document.body.style.overflow = 'hidden';">
                      <div class="info">
                        <div class="col-sm-2">
                          <h6 class="mb-0">Gender</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          <?php echo $gender ?>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                      </div>  
                    </div>

                    <div class="infoRow" onclick="myFunction()">
                      <div class="info">
                        <div class="col-sm-2">
                          <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          <?php echo isset($email)?$email:"" ?>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                      </div>  
                    </div>

                    <div class="infoRow" onclick="document.getElementById('changeInfo6').style.display='block';
                         document.body.style.overflow = 'hidden';">
                      <div class="info">
                        <div class="col-sm-2">
                          <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          <?php echo $contact ?>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                      </div>  
                    </div>

                    <div class="infoRow" onclick="document.getElementById('changeInfo7').style.display='block';
                         document.body.style.overflow = 'hidden';">
                      <div class="info">
                        <div class="col-sm-2">
                          <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          <?php echo $address ?>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        
      </div>

    </section><!-- /Starter Section Section -->

  </main>

  <?php
    include './general/footer.php';
  ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Pie Chart JS-->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
function myFunction() {
  alert("Email cannot be changed.");
}
</script>
</body>

</html>