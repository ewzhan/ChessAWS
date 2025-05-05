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
  <style>
.paymentBox{
    border: 1px solid black;
    margin: 10px 10px;
    padding: 10px;
}
.payment-method{
    display: grid;
    grid-template-columns: repeat(2,auto);
}
.paymentMethodBox{
    width: 500px;
    border: 1px solid black;
    padding: 10px;
}
.trashIcon{
    float: right;
    border: none;
    background-color: white;
}
  </style>
</head>
<body>
<?php
    require_once './secret/database.php';
    require './secret/verifying.php';
    include './general/header.php';
?>
<main class="main">
<section id="portfolio-details" class="portfolio-details section">
<div class="container" data-aos="fade-up" data-aos-delay="100">
<div class="row gy-4">
<div class="col-lg-12">
<?php
$con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(isset($_POST["removeDefault"])){
    $sql = "UPDATE payment SET status = 'other' WHERE status = 'default'";
    $result = $con->query($sql);
}else if(isset($_POST["changeDefault"])){
    $paymentId = trim($_POST["paymentID"]);
    $sql = "SELECT * FROM payment WHERE PaymentID = '$paymentId'";
    $result = $con->query($sql);
    if($result -> num_rows > 0){
        while($row = $result->fetch_object()){
            $cdNum = $row->CardNumber;
        }
    }else{
        prinft("Unable to process!");
    }
    $sql = "UPDATE payment SET status = 'other' WHERE status = 'default'";
    $result = $con->query($sql);
    $query = "UPDATE payment SET status = 'default' WHERE CardNumber = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $cdNum);
    $stmt->execute();
}else if(isset($_POST["deleteCard"])){
    $paymentId = trim($_POST["paymentID"]);
    $sql = "SELECT * FROM payment WHERE PaymentID = '$paymentId'";
    $result = $con->query($sql);
    if($result -> num_rows > 0){
        while($row = $result->fetch_object()){
            $cdNum = $row->CardNumber;
        }
    }else{
        prinft("Unable to process!");
    }
    $query = "UPDATE payment SET status = 'none' WHERE CardNumber = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $cdNum);
    $stmt->execute();
}

    $sql = "SELECT * FROM payment WHERE UserID = '$userid' AND status ='default'";
    $result = $con -> query($sql);
    echo "<div class='portfolio-info' data-aos='fade-up' data-aos-delay='200'><h3>Payment Method</h3>";
    if($result -> num_rows > 0){
        echo "<div><h6>Default Card</h6>";
        $card = "";
        while($row = $result ->fetch_object()){
                printf("
                    <form method='POST'>
                    <div class='paymentMethodBox'>
                    <p>Card Number - **** **** **** %s</p>
                    <p>Card Holder Name - %s</p>
                    <p>Card Expiry Date - %s</p>
                    <div display:flex;>
                        <input type='submit' name='removeDefault' value='Remove it from default card'>
                        <input type='hidden' name='paymentID' value='%s'>
                        <button type='submit' name='deleteCard' class='trashIcon'><i class='bi bi-trash3-fill'></i></button>
                    </div>
                    </div>
                    </form>
                   ",substr($row->CardNumber,15)
                    ,$row->CardHolder
                    ,substr($row->CardExpiry,0,7)
                    ,$row->PaymentID
                );
                break;
        }
        echo "</div>";
    }
    
    $sql = "SELECT * FROM payment WHERE UserID = '$userid' AND status ='other' Order by CardNumber";
    $result = $con -> query($sql);
    if($result -> num_rows > 0){
        echo "<br><div><h6>Other Card</h6><div class='payment-method'>";
        $card = "";
        while($row = $result ->fetch_object()){
            if($row->CardNumber != $card){
                 printf("
                    <form method='POST'>
                    <div class='paymentMethodBox'>
                    <p>Card Number - **** **** **** %s</p>
                    <p>Card Holder Name - %s</p>
                    <p>Card Expiry Date - %s</p>
                    <div display:flex;>
                        <input type='submit' name='changeDefault' value='Set it as default card'>
                        <input type='hidden' name='paymentID' value='%s'>
                        <button type='submit' name='deleteCard' class='trashIcon'><i class='bi bi-trash3-fill'></i></button>
                    </div>
                    </div>
                    </form>
                   ",substr($row->CardNumber,15)
                    ,$row->CardHolder
                    ,substr($row->CardExpiry,0,7)
                    ,$row->PaymentID
                );
                $card = $row->CardNumber;
            }
        }
        echo "</div></div><br>";
    }
    echo "</div><br>";
    
    
    $sql = "SELECT * FROM payment WHERE UserID = '$userid'";
    $result = $con -> query($sql);
    if($result -> num_rows > 0){
        echo "<div class='portfolio-info' data-aos='fade-up' data-aos-delay='200'>
                <h3>Payment History</h3>";
        while($row = $result ->fetch_object()){
            printf("<div class='paymentBox'>
                    <p>Payment Date - %s<p>
                    <p>Amount - RM%.2f<p>
                    <p>Payment Card Number - **** **** **** %s<p>
                    </div>
                   ", $row->PaymentDate
                    ,$row->Amount
                    ,substr($row->CardNumber,15)
                    );
        }
        echo"</div>";
    }else{
        printf("<h4>No record found</h4>");
    }
?>    

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