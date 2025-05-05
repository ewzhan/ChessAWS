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
  <link href="https://developers.google.com/calendar/api/v3/reference/calendars/insert#http-request" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/calender.css" rel="stylesheet" type="text/css"/>
</head>

<body>
  <?php
    include './general/header.php';
  ?>
  
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="section hero">

       <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 class="">Chess Society</h1>
            <p>Welcome to the Chess Society!</p>
            <p>The Chess Society at TARUMT is a vibrant and engaging club. Whether you’re a seasoned player or just starting out, there’s a place for you to learn about chess and discover the intricacies of the game as a fascinating hobby.</p>    
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img">
              <img src="assets/img/chess_logo.png" class="img-fluid animated">
          </div>
        </div>
      </div>
    </section>
    
    <section id="portfolio-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
    <div class="col-lg-12">
    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
    <iframe src="https://calendar.google.com/calendar/embed?src=790d0e775a040bd7d12a07f2d512d1cad405235cb22d6fe9d46d9e4b5f018e17%40group.calendar.google.com&ctz=Asia%2FKuala_Lumpur" style="border: 0; margin-left:240px;" width="800" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
    </div>
    </div>
    </div>
    </section>
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
  
  

</body>

</html>