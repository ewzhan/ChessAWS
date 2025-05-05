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
  <link href="assets/css/payment.css" rel="stylesheet" type="text/css"/>
  <style>
      #confirm{
          margin-top: 25px;
          display: none;
      }
  </style>
</head>

<body>
  <?php
    require_once './secret/database.php';
    include './general/header.php';
  ?>
<main class="main">

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <form method="POST">
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
            <div class='portfolio-details-slider swiper' id='swiper'>
               <div class='swiper-slide' id='swiper-slide'>
                    <img src='eventImage/%s'/>
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
                  <button type='button' onclick='selectNum()'>Buy Ticket</button>
                  
                  <div id='confirm'>
                    <label for='num'>Please select the number of ticket that you want to purchase.</label>
                    <input id='num' type='number' name='selectedNum' value='1'>
                    <input type='submit' value='Confirm' name='submitBtn'>
                  </div>
                </div>
            
                <div class='portfolio-description' data-aos='fade-up' data-aos-delay='300'>
                  <h2>Any Question / Problem</h2>
                  <p>
                    Contact Us<br>
                    Email : abc@gmail.com<br>
                    Phone : +6012-3456-789
                  </p>
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
                );
                
            }else{
                echo "<a>Unable to Process!</a><a href='event.php'>[ Back to event page ]</a>";
            }
            $result -> free();
            $con -> close();
        }else{
            $image = trim($_GET["image"]);
            $selectedNum = trim($_POST["selectedNum"]);
            echo "<script>window.location.href='payments.php?image=$image&ticket=$selectedNum'</script>";
        }
        ?>
        </div>
        </form>
      </div>
    </section><!-- /Portfolio Details Section -->

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
  <script>
  function selectNum(){
      document.getElementById('confirm').style.display='block';
  }
  </script>
</body>

</html>
