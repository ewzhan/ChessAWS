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
</head>

<body>
  <?php
    require_once '../secret/database.php';
    include './../general/staff_header.php';
  ?>

  <main class="main">
    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            
        <?php
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if(isset($_GET["image"])){
                $image = trim($_GET["image"]);
            }else{
                $image = "";
            }
            
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql = "SELECT * FROM Events WHERE EventImage = '$image'";
            
            $result = $con -> query($sql);
            if($row = $result -> fetch_object()){
                $eventName = $row -> EventName;
                $eventType = $row -> EventType;
                $eventDateStart = $row -> EventDateStart;
                $eventDateEnd = $row -> EventDateEnd;
                $eventTimeStart = $row -> EventTimeStart;
                $eventTimeEnd = $row -> EventTimeEnd;
                $eventCategories = $row -> EventCategories;
                $eventVenue = $row -> EventVenue;
                $eventFee = $row -> EventFee;
                $closingDate = $row -> ClosingDate;
                $eventPrize = $row -> EventPrize;
                $eventImage = $row -> EventImage;
        
        printf("
            <div class='col-lg-8'>
            <div class='portfolio-details-slider swiper'>
                <div class='swiper-slide'>
                  <img src='../eventImage/%s'>
                </div>
            </div>
            </div>

            <div class='col-lg-4'>
            <div class='portfolio-info' data-aos='fade-up' data-aos-delay='200'>
              <h3>Event information</h3>
              <ul>
                <li><strong>Event Name</strong>: %s</li>
                <li><strong>Start At</strong>: %s - %s</li>
                <li><strong>End At</strong>: %s - %s</li>
                <li><strong>Venue</strong>: %s </li>
                <li><strong>Categories</strong>: %s</li>
                <li><strong>Fee</strong>: RM%.2f </li>
                <li><strong>Register Closing Date</strong>: %s</li>
                <li><strong>Prize</strong>: RM%.2f </li>
              </ul>
              <div>
                <a href='event-edit.php?image=%s'><button>Edit Details</button></a>
                <a><button onclick='displayDiv()'>Delete Event</button></a>
              </div>
              <div id='confirm' style='display:none;'>
              <form action='' method='POST'>
              <h5 style='margin-top: 20px;'>Are you sure to delete this event?</h5>
                <button type='submit'>Yes</button>
                <a href='staff-event-details.php?image=%s'><button type='button'>No</button></a>
              </form>
              </div>
            </div>
            </div>
               ", $eventImage
                , $eventName
                , $eventDateStart
                , substr($eventTimeStart, 11)
                , $eventDateStart
                , substr($eventTimeEnd, 11)
                , $eventVenue
                , $eventCategories
                , $eventFee
                , $closingDate
                , $eventPrize
                , $eventImage
                , $eventImage
                );
        
            }else{
                echo "<a>Unable to Process!</a><a href='staff-event.php'>[ Back to event page ]</a>";
            }
            $result -> free();
            $con -> close();
        }else{
            $image = trim($_GET["image"]);
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $sql = "DELETE FROM events WHERE EventImage = ?";
            $stmt = $con->prepare($sql);
            $stmt ->bind_param("s", $image);
            $stmt->execute();
            
           if($stmt -> affected_rows > 0){
            printf("
            <div class='col-lg-8'>
            <div class='portfolio-details-slider swiper'>
              <h4>Delete Successfull<h4>
              <a href='staff-event.php'>[ Back to event page ]</a>
            </div>
            </div>  
            ");
           }else{
               printf("Unable to delete the record");
           }
        }
        ?>
            
        </div>
        </div>
    </section><!-- /Portfolio Details Section -->
  </main>

  <?php
    include './../general/footer.php';
  ?>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script>
      function displayDiv(){
        document.getElementById('confirm').style.display='block';
      }
  </script>
</body>

</html>
