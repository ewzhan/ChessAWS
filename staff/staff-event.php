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
  <link href="../assets/css/event.css" rel="stylesheet" type="text/css"/>
  <style>
      .addEventBtn{
          height: 50px;
          width: 200px;
          border: none;
          border-radius: 50px;
          font-size: 20px;
          background-color: rgba(235,93,30,0.7);
          color: #212529;
      }
  </style>
</head>

<body>
  <?php
    require_once '../secret/database.php';
    include './../general/staff_header.php';
  ?>
 
  <main class="main">
    <section id="portfolio" class="portfolio section">
      <div class="container" data-aos="fade-right" style="display:flex;">
          <a href="add-event.php"><button class="addEventBtn">Add Event</button></a>
        <div class="container section-title" data-aos="fade-up">
            <h2>Event</h2>
        </div>
      </div>

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">


        <!------------------------------------------Filter Things-------------------------------------------------->
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-Tournament">Tournament</li>
            <li data-filter=".filter-Class">Class</li>
            <li data-filter=".filter-Camp">Camp</li>
          </ul><!-- End Portfolio Filters -->


        <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

        <?php
        $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        if($con -> connect_error){
            die("Connect Failed". $con -> connect_error);
        }
        
        $sql = "SELECT * FROM Events";
        
        $result = $con -> query($sql);
        
        if($result -> num_rows > 0){                    
            while($row = $result -> fetch_object()){
            printf("
                
                <div class='col-lg-4 col-md-6 portfolio-item isotope-item filter-%s'>
                <div class='portfolio-content h-100'>
                    <img src='../eventImage/%s' class='posterImg' alt=''/>

                    <div class='portfolio-info'>
                      <h4>%s</h4>
                      <a href='../eventImage/%s' title='Tournmant 1' data-gallery='portfolio-gallery-app' class='glightbox preview-link'><i class='bi bi-zoom-in'></i></a>
                      <a href='staff-event-details.php?image=%s' title='More Details' class='details-link'><i class='bi bi-link-45deg'></i></a>
                      <a href='event-edit.php?image=%s' title='Edit Details' class='edit-link'><i class='bi bi-pencil-square'></i></a>
                    </div>
                </div>
                </div>
                   ", $row -> EventType
                    , $row -> EventImage
                    , $row -> EventType
                    , $row -> EventImage
                    , $row -> EventImage
                    , $row -> EventImage
                    );
            }   
        } 
        $result -> free();
        $con -> close();
        ?>
            
        </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->

  
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

</body>

</html>