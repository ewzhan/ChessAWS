<?php

//retreive sort and order paramater from URL
if(empty($_GET)){
    //nothing inside in the URL 
    //default
    $sort = "UserName";
    $order = "ASC";
    $allGender = "%";  //show all record
}else{
    //something inside the URL
    $sort  = $_GET["sort"];
    $order =$_GET["order"];
    $allGender = $_GET["gender"];
}

?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Management</title>
        <link rel="stylesheet" href="../assets/css/user-list.css"/>
    </head>
    <body>
        <?php
        include '../general/staff_header.php';
        
        //4 IMPORTANT INFORMATION NEEDED BY DB
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "chess");
    if(isset($_COOKIE[$cookie_name])){
        $userid = $_COOKIE[$cookie_name];
        
    }
        
        ?>        
<main class="main">
<section id="portfolio-details" class="portfolio-details section">
<div class="container" data-aos="fade-up" data-aos-delay="100">
<div class="row gy-4">
<div class="col-lg-12">
<div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
            <div class="list" style="margin: auto;">
                <h2>Users List</h2>
                <button onclick="location='userReport.php'">Generate User Performance Report</button>
        <h6 class="mb-0">Filter with Gender: 
        <?php 
        //function to return all types of gender
        function getGender(){
            return array(
                'M' => '👦 Male',
                'F' => '👧 Female'
            );
        }

        printf("<a href='?sort=%s&order=%s&gender=%s'>All</a>",$sort, $order, '%');
        foreach (getGender() as $key => $value){
            //$key - programme shortform
            //$value - programme full name
        printf(" | <a href='?sort=%s&order=%s&gender=%s'>%s</a>"
                , $sort,$order, $key, $key);
        }
        ?>
        </h6>
        
        <?php 
        //check if the user click the delete button?
        if(isset($_POST["delete"])){
            
            $delete = $_POST["delete"];
            
            if(!empty($delete)){
                //something inside
                //step 1: create connection
                $con = new mysqli(DB_HOST, DB_USER,
                        DB_PASS, DB_NAME);
                
                
                //Step 2: sql statement
                //DELETE FROM Student 
                //WHERE StudentID IN ('23PMD12345', '23PMD12346');
                //NOTE: Array -> string - implode()
                //NOTE: string -> array - explode()
                $sql = "DELETE FROM user WHERE UserID = '$delete'";
                
                if($con->query($sql)){
                    //deleted succesfully
                    printf("<div class='info'>
                        %s has been deleted.
                           </div>", $delete);
                }
                $con->close();
                echo "<script>window.location.href='staff-users.php'</script>";
            }else{
                echo "<script>alert('No user founded.');</script>";
            }
        }
                
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
                        WHERE gender LIKE '$allGender' && UserName != 'admin'
                        ORDER BY $sort $order";
               
                
                //pass sql into connection to execute
                $result = $con->query($sql);
                if($result->num_rows >0){
                    //record returned
                    
                    while($row = $result->fetch_object()){
                        printf('
                    
                <form action="" method="POST">
                <div class="line" style="background-color:rgba(0,0,0,0.05);">
                    <div class="user">
                        <div class="profile">
                            <img src="../profileImage/%s" alt="ProfilePic"/>                         
                        </div>
                        <div class="details">
                            <h4>%s</h4>
                            <h6 class="mb-0">%s</h6>
                        </div>
                    </div>
                    <div class="status">
                        <p class="text-muted font-size-sm dateText">%s</p>
                    </div>
                    <div class="location">
                        <p class="text-muted font-size-sm dateText">%s</p>
                    </div>
                    <div class="phone">
                        <p class="text-muted font-size-sm dateText">%s</p>
                    </div>
                    <div class="contact">
                        <a class="text-muted font-size-sm dateText" href="#">%s</a>
                    </div>
                    
                    <div>
                        <button type="submit" name="delete" value="%s" 
                                style="margin: auto;" 
                                onclick="return confirm(\'This will delete the user. \n Are you sure?\')">Delete</button>
                    </div>
                    
                </div>
                </form>', $row->profilePicture,$row->UserName,$row->UserID,$row->gender,$row->address,$row->contact,$row->email,$row->UserID);
                    }
                }
                $result->free();
                $con->close();
                    ?>
                
            </div>    
            
</div>
</div></div></div>
</section>
        </main>
        
        <?php
        include '../general/footer.php';
        ?>
        
        
        <script>
        function myFuntion(){
            
        }
        </script>
    </body>
</html>
