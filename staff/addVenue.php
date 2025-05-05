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
     <h1>Add Venue</h1>
     <?php
     
  if (!empty($_POST)) {
      //available data
      $venueID = $_POST["venueid"];
      $venueName = trim($_POST["venuename"]);
      $venueAddress = trim($_POST["address"]);
      
      //check for error
      $error["venueID"]= checkID($venueID);
            $error["venueName"]= checkname($venueName);
      $error["venueAddress"]= checkaddress($venueAddress);
      
                 $error = array_filter($error);

                 
                 
                 
                 if (empty($error)) {
                     //nothing in error array
                     $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                     
                     $sql = "INSERT INTO venue(venueID,venueName,venueAddress)VALUES(?,?,?); ";
                     
                     $insertvenue = $con -> prepare($sql);
                     $insertvenue-> bind_param("iss",$venueID,$venueName,$venueAddress);
                     $insertvenue -> execute();
                     
                       if($insertvenue->affected_rows > 0){
                         //insert successfully
                          echo '<script>alert("Venue added successfully")</script>'; 
                                   

                     
                            }else{
                                   echo '<script>alert("Data error, cannot add venue")</script>'; 
                                    
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
                     <td><input type="number" name="venueid" value="" /></td>
                 </tr>
                 <tr>
                     <td>Venue Name:</td>
                     <td><input type="text" name="venuename" value="" /></td>
                 </tr>
                 <tr>
                     <td>Venue Address</td>
                     <td><input type="text" name="address" value="" /></td>
                 </tr>
             </table>
         <br/>
         <input type="submit" value="Add" name="btnAdd"/>
         <input type="button" value="Cancel" name="btnCancel" onclick="location.href='venue.php'" />

     </form>
        
        <?php
    include './../general/footer.php';
  ?>
    </body>
</html>
