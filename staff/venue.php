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
        
        <div class="box">
        <h1>Venue Maintenance</h1>

        <!-- Button group for Add, Edit, Delete -->
        <div class="button-group">
          <button class="button" onclick="location.href='addVenue.php'">Add Venue</button>
          <button class="button" onclick="editVenue()">Edit Venue</button>
          <button class="button delete" onclick="deleteVenue()">Delete Venue</button>
        </div>

        <!-- Venue List -->
        <table id="venueTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Map</th>
            </tr>
          </thead>
          <tbody>
              <?php
              //connection to database
              $con = new mysqli(DB_HOST,
                        DB_USER, DB_PASS, DB_NAME);
              
              //check
               if($con->connect_error){
                    die("Connection failed: ". $con->connect_error);
                }
                
                //sql
                 $sql = "SELECT * 
                        FROM venue;" ;
                 
                 //pass sql into connection to execute
                $venueresult = $con->query($sql);    
               //check contains record
                if($venueresult->num_rows >0){
                    //record returned
                    
                    while ($row = $venueresult->fetch_object()) {
                        printf("<tr>
                                <td>%d</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>
                                <div style='width: 100%%'><iframe width='100%%' height='100%%' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?width=100%%25&amp;height=600&amp;hl=en&amp;q=%s+(My%%20Business%%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed'></iframe></div>

                                </td>
                              </tr>",$row->venueID,$row->venueName,$row->venueAddress,$row->venueAddress);
                    }
                    
                }
                
                 $venueresult->free();
                 $con ->close();
                
              ?>

          </tbody>
        </table>

        <!-- delete/Edit Form (hidden by default) -->
        <div id="venueForm" style="display: none;" >
          <h2 id="formTitle">Add Venue</h2>
          <form id="venueFormFields" method="GET" action="">
            <label for="venueid">Venue ID:</label><br>
            <input type="text" id="venueid" name="venueid" required><br>
            
            <input type="submit" value="Submit" name="btnEdit"/>
            
           
          </form>
        </div>
      </div>

      <script>
        // Function to show the Add Venue form
        function addVenue() {
          document.getElementById('formTitle').innerText = 'Add Venue';
          document.getElementById('venueForm').style.display = 'block';
         
        }

        // Function to show the Edit Venue form
        function editVenue() {
          document.getElementById('formTitle').innerText = 'Edit Venue';
          document.getElementById('venueForm').style.display = 'block';
          document.getElementById('venueFormFields').setAttribute("action","editVenue.php");
        }

        // Function to delete a venue (just an example, not functional)
        function deleteVenue() {
           document.getElementById('formTitle').innerText = 'Delete Venue';
          document.getElementById('venueForm').style.display = 'block';
           document.getElementById('venueFormFields').setAttribute("action","deleteVenue.php");
        }
      </script>
        
        
        <?php
    include './../general/footer.php';
  ?>
    </body>
</html>
