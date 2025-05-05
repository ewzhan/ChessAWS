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
     <h1>Delete Venue</h1>
       
     
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
                echo "Unable to process. 
                [ <a href='venue.php'>Try again.</a> ]";
            }
            $venueresult->free();
            $con->close();
            
            }else{
                //POST method below
                //delete
               if (isset($_GET['venueid'])) {
                    $venueID = $_GET['venueid'];
                }else{
                    $venueID = "";
                }
                
                //Step 1: create connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
            //Step 2: sql statement
            $sql = "DELETE FROM venue WHERE venueID = ?";
                
             //Step 3: process sql
            $stmt = $con->prepare($sql);
            
             //Step 3.1 pass in value into sql parameter 
            $stmt->bind_param("i", $venueID);
            
             //Step 3.2 execute process
            $stmt->execute();
            
            if($stmt->affected_rows >0){
                //delete succesful
               echo '<script>alert("Venue deleted successfully"); window.location.href ="venue.php";</script>'; 
                 
            }else{
                //unable to delete
               echo '<script>alert("Data error, cannot delete venue"); window.location.href ="venue.php";</script>'; 
             
            }
            
            $con->close();
            $stmt->close();
            
         }
     
     ?>
     
     
     
     
     
    <form method="POST" action="">
             <table>
                 <tr>
                     <td>Venue ID:</td>
                     <td><?php echo $venueID;?></td>
                 </tr>
                 <tr>
                     <td>Venue Name:</td>
                     <td><?php echo $venueName;?></td>
                 </tr>
                 <tr>
                     <td>Venue Address</td>
                     <td><?php echo $venueAddress; ?></td>
                 </tr>
             </table>
         <br/>
         <input type="submit" value="Delete" name="btnDelete"/>
         <input type="button" value="Cancel" name="btnCancel" onclick="location.href='venue.php'" />

     </form>
        
        <?php
    include './../general/footer.php';
  ?>
    </body>
</html>

