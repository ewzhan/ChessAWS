<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Chess Society</title>
  <meta content="Chess Society" name="description">
  <meta content="Chess, Chess Society" name="keywords">

  <link href="../assets/img/chess_logo.png" rel="icon">
  <link href="../assets/img/chess_logo.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">
  <link href="../assets/css/venue.css" rel="stylesheet" type="text/css"/>
</head>
 <body>
         <?php
    include './../general/staff_header.php';
    require_once './../secret/database.php';
    require './../secret/verifying.php';
  ?>
     <h1>Edit Venue</h1>
     
     <?php
            if ($_SERVER["REQUEST_METHOD"]=="GET") {
                //get 
                //display
                if (isset($_GET['venueid'])) {
                    $venueID = $_GET['venueid'];
                }else{
                    $venueID = "";
                }
                
                 //connect
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            //sql
            $sql = "SELECT * FROM venue WHERE venueID = '$venueID'";
            
            //insert
            $venueresult = $con->query($sql);
            
             if($row = $venueresult->fetch_object()){
                //record found
                $venueID = $row->venueID;
                $venueName = $row->venueName;
                 $venueAddress = $row->venueAddress;
            }else{
                //record is not found
                echo "Record did not exist
                [ <a href='venue.php'>Return.</a> ]";
            }
            $venueresult->free();
            $con->close();
            
            }else{
                //POST method from form below
                //edit and update
                 //available data
      $venueID = $_POST["venueidhidden"];
      $venueName = trim($_POST["venuename"]);
      $venueAddress = trim($_POST["address"]);
      
      //check for error
   
            $error["venueName"]= checkname($venueName);
      $error["venueAddress"]= checkaddress($venueAddress);
      
                 $error = array_filter($error);

                 
                 
                 
                 if (empty($error)) {
                     //nothing in error array
                     $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                     
                     $sql = "UPDATE venue 
                 SET venueName = ?, venueAddress = ?
                 WHERE venueID = ?";
                     
                     $insertvenue = $con -> prepare($sql);
                     $insertvenue-> bind_param("ssi",$venueName,$venueAddress,$venueID);
                     $insertvenue -> execute();
                     
                       if($insertvenue->affected_rows > 0){
                         //insert successfully
                          echo '<script>alert("Venue updated successfully")</script>'; 
                         
                         
                     
                            }else{
                                   echo '<script>alert("Data error, cannot update venue")</script>'; 
                                    
                                 
                            }
                            $con->close();
                            $insertvenue->close();
                 
                        } else {
                            
                            echo '<script>';
                            echo 'alert("';
                            
                            foreach ($error as $value) {
                                echo "$value\\n";
                                
                            }
                            
                            echo '")';
                            echo '</script>';

                                     
                            
                            
                            echo "<ul class='error'>";
                                     foreach ($error as $value){
                                         echo "<li>$value</li>";
                                     }
                                     echo "</ul>";
                                }
                
                
            }
            
           
            
            
     ?>
     
     
       
     <form method="POST" action="">
             <table>
                 <tr>
                     <td>Venue ID:</td>
                     <td><?php echo $venueID;?><input type="hidden" name="venueidhidden" value="<?php echo $venueID;?>" /></td>
                 </tr>
                 <tr>
                     <td>Venue Name:</td>
                     <td><input type="text" name="venuename" value="<?php 
                               echo isset($venueName)? $venueName : "";
    
                               ?>" /></td>
                 </tr>
                 <tr>
                     <td>Venue Address</td>
                     <td><input type="text" name="address" value="<?php 
                               echo isset($venueAddress)? $venueAddress : "";
    
                               ?>" /></td>
                 </tr>
             </table>
         <br/>
         <input type="submit" value="Edit" name="btnEdit"/>
         <input type="button" value="Cancel" name="btnCancel" onclick="location.href='venue.php'" />

     </form>
        
        <?php
    include './../general/footer.php';
  ?>
    </body>
</html>
