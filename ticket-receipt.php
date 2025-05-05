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

  <!-- =======================================================
  * Template Name: Ninestars
  * Template URL: https://bootstrapmade.com/ninestars-free-bootstrap-3-theme-for-creative/
  * Updated: Mar 23 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<?php
    include './general/header.php';
?>
    

  <main>
    <div id="cont">
    <div id="contain-ticket">
        <div id="ticketReceipt">
            <h1>Chess Competition Participant</h1>
            <hr>
            <table id="receiptDate">
            <tr>
                <td>Date: 01 March, 2020</td>
            </tr>
            <tr>
                <td>Time: 8.00 a.m. - 8.00 p.m.</td>
            </tr>
            </table>
            <div id="receiptDetail">
                <div style="display: grid; grid-template-columns: repeat(3,auto);">
                    <div class="ticketDetails"><b>Ticket #ID</b></div>
                    <div class="ticketDetails"><b>Ticket Type</b></div>
                    <div class="ticketDetails"><b>Security Code</b></div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3,auto);margin-top: 10px;">
                    <div class="ticketDetails">TRE1001</div>
                    <div class="ticketDetails">Tournament</div>
                    <div class="ticketDetails">DSRFV515</div>
                </div>
            </div>
        <div id="receiptInfo">
            <div style="float: left;margin-left: 100px;display: block;">
                <div><b>Venue</b></div>
                <div >ASU Company</div>
                
            </div>
            <div style="margin-left: 340px;">
                <div><b>Ticket Holder's Information</b></div>
                <div>Eu Wen Zhan</div>
                <div>euwenzhan@gmail.com</div>
                <div>6011-23456789</div>
            </div>
            <div style="margin: 20px;">
                <div style="float: left; "><b>Organizer Name:</b></div>
                <div>Chess Society</div>
            </div>
        </div>

        </div>
        <div id="qrCheck-in">
            <div style="margin: 20px 240px;"><img src="assets/img/QR-code.jpg"  ></div>
            <div style="text-align: center;"><h2>Check In For This Event</h2></div>
            <div style="text-align: center;margin-bottom: 20px;">Scan this QR code at Event to Check In</div>
        </div>
    </div>
        <div>
            <button onclick="window.location.href='index.php'" id="button" class="button" style="margin-left: 10px;">Back To Home</button>
            <button onclick="printDiv()" id="button" class="button">Print Receipt</button>
        </div>
    </div>
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
    function printDiv() {
    var printContents = document.getElementById("contain-ticket").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();

    document.body.innerHTML = originalContents;
}
 </script>

</body>

</html>