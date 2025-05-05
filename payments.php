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
      .parInfo{
          display: grid;
          grid-template-columns: repeat(2, auto);
      }
      .parInfo table{
          margin: 0px 5px 10px 5px;
      }
  </style>
</head>
<body>
<?php
    require './secret/verifying.php';
    require_once './secret/database.php';
    include './general/header.php';
?>
<main class="main">
<section id="portfolio-details" class="portfolio-details section">
<div class="container" data-aos="fade-up" data-aos-delay="100">
<div class="row gy-4">
<div class="col-lg-12">
<div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
            <?php
            if($_SERVER["REQUEST_METHOD"] == "GET"){
                if(isset($_GET["ticket"])){
                $ticket = trim($_GET["ticket"]);
                }else{
                $ticket = 0;
                }
                
            if($ticket <= 0){
                    printf("<div>
                            <h4>No ticket selected<h4>
                            <a href='event.php'>Back</a>
                            </div>
                            ");
                }else{
                    printf("
                        <div>
                        <div id='paymentDetail'>
                        <h1>Participants Details</h1><hr/>
                        <form id='paymentForm' method='POST'>
                        <h5>Please enter the participants details for each ticket</h5>
                        <div class='parInfo'>
                        ");
                    for($i = 0 ; $i < $ticket ; $i++){
                    printf("
                    <table cellspacing='10' cellpadding='10' id='payment-Table' border='1px solid black'>
                    <tr>
                      <td>Fullname:</td>
                      <td>
                      <input type='text' name='firstName' value='' placeholder='First Name' required style='height: 40px;'>&nbsp;
                      <input type='text' name='lastName' required style='height: 40px;' placeholder='Last Name'>
                      </td>
                    </tr>
                    <tr>
                      <td>Gender:</td>
                      <td><input type='radio' name='%d' id='male' checked>M &nbsp;
                      <input type='radio' id='female' name='%d'>F</td>
                    </tr>
                    <tr>
                      <td>Date of Birth:</td>
                      <td><input type='date' name='birth' required ></td>
                    </tr>
                    <tr>
                      <td>Phone No:</td>
                      <td><input type='text' name='phoneNum' placeholder='011-23456789' required style='height: 40px;'></td>
                    </tr>
                    <tr>
                      <td>Email:</td>
                      <td><input type='text' name='email' placeholder='email@gmail.com' required style='width: 300px;height: 40px;'></td>
                    </tr>
                    </table>
                    ",$i, $i);
                    }
                    printf("</div>
                            <div id='buttonPay'>
                            <input type='submit' style='width: 150px;height: 40px;' value='Proceed payment' name='detailsBtn'>
                            <a href='event.php'><input type='button' value='Cancel Payment' style='height: 40px;cursor: pointer;'></a>
                            </div>
                            </form>
                            </div>
                            </div>
                            ");
                }
            }else{
                $true = 0;
                $image = trim($_GET["image"]);
                $ticket = trim($_GET["ticket"]);
                
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                $sql = "SELECT * FROM events WHERE EventImage = '$image'";
                $result = $con->query($sql);
                if($row = $result ->fetch_object()){
                    $eventFee = $row ->EventFee;
                $amount = $eventFee * $ticket;
                }else{
                    printf("<h2>Unable to process!</h2>");
                }
                
                if(isset($_POST["paymentBtn"])){
                    $cardName = trim($_POST["cardName"]);
                    $cardNumber = trim($_POST["cardNum"]);
                    if(isset($_POST["expiry"])){
                        $expiryDate = trim($_POST["expiry"]) . "-1";
                    }else{
                        $expiryDate = ""; 
                    }
                    $cardCvc = trim($_POST["cvc"]);
                    
                    $error["name"] = checkCardName($cardName);
                    $error["number"] = checkCardNum($cardNumber);
                    $error["expiry"] = checkCardExpiry($expiryDate);
                    $error["cvc"] = checkCardCvc($cardCvc);
                    $error = array_filter($error);
                    if(empty($error)){
                        $paymentId = "PAY" .uniqid();
                        $date = date("Y-m-d");
                        
                        $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                        $sql = "SELECT * FROM payment";
                        $result = $con ->query($sql);
                        $same = 0;
                        if($result->num_rows> 0){
                            while($row = $result->fetch_object()){
                                if($row->CardNumber == $cardNumber){
                                    $same = 1;
                                    break;
                                }
                            }
                        }
                        
                        if($same == 1){
                            $status = "default";
                        }else{
                            $status = "other";
                        }
                        if(isset($_GET["image"])){
                        $image = trim($_GET["image"]);
                        $sql = "INSERT INTO payment (PaymentID, PaymentDate,Amount,UserID,CardNumber,CardHolder,CardExpiry,CardCvc,status,EventImage,ticketNumber)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param("ssdsssssssi", $paymentId,$date,$amount,$userid,$cardNumber,$cardName,$expiryDate,$cardCvc,$status,$image,$ticket);
                        $stmt->execute();
                        if($stmt -> affected_rows > 0){
                                $image = trim($_GET["image"]);
                                $sql = "SELECT * FROM events WHERE EventImage = '$image'";
                                $result = $con->query($sql);
                                if($result -> num_rows > 0){
                                    while($row = $result->fetch_object()){
                                        $ticketID = "TK" . uniqid();
                                        $eventFee = $row->EventFee;
                                        $sql = "INSERT INTO ticket (ticketID, EventImage,UserID,ticketPrice) VALUES (?,?,?,?)";
                                        $stmt = $con ->prepare($sql);
                                        $stmt->bind_param("ssss", $ticketID,$image,$userid,$eventFee);
                                        $stmt->execute();
                                        printf("
                                            <div>
                                            <h5>Make Payment Successfull</h5>
                                            <a href='event.php'>[ Back to event page ]</a>
                                            </div>");
                                            $true = 1; 
                                    }
                                }
                        }else{
                            printf("Database error, unable be insert");
                        }
                        }else{
                            printf("Unable to Process");
                        }
                    }else{
                        echo "<ul>";
                        foreach($error as $value){
                            echo "<li>$value</li>";
                        }
                        echo "</ul>";
                    }
                }
                
                $sql = "SELECT * FROM payment Where status ='default' AND UserID ='$userid'";
                $result = $con ->query($sql);
                if($result -> num_rows > 0){
                    while($row = $result->fetch_object()){
                        $cardNumberDefault = $row->CardNumber;
                        $cardHolderDefault = $row->CardHolder;
                        $expiryDateDefault = $row->CardExpiry;
                    }
                }else{
                    $cardNumberDefault = "";
                    $cardHolderDefault = "";
                    $expiryDateDefault = "";
                }
                if($true == 0){
                  printf("
                    <h1>Payment Process</h1><hr/>
                    <form method='POST'>
                    <h5>Payment Fee : RM%.2f</h5>
                    <div>
                        <label for='cardName'>Card Holder's Name:</label><br>
                        <input type='text' name='cardName' style='height: 40px;width: 600px;' value='%s'>
                    </div >
                    
                    <div style='padding-top:30px;'>
                        <label for='cardNum'>Card Number:</label><br>
                        <input type='text' name='cardNum' value='%s' placeholder='0000 0000 0000 0000' style='height: 40px;width: 600px;'>   
                    </div>          
                    
                    <div style='padding-top:30px;'>
                        <label for='expiry'>Card Expiry Date</label><br/>
                        <input type='month' value='%s' id='expiry' name='expiry'>
                    </div>
                    
                    <div style='padding-top:30px;'>
                        <label for='cvc'>CVC / CVV</label><br>
                        <input type='text' name='cvc' style='height: 40px;width: 600px;'>
                    </div>
                    
                    <div id='backButton' style='float:right;'>
                        <a href='event.php' class='button kgink'>Cancel Buying</a
                        <input type='hidden' value='none' name='amount'>
                        <input type='submit' class='button kgink' value='Complete payment' name='paymentBtn'>
                    </div><br>
                    </form>
                         ",$amount
                          ,$cardHolderDefault
                          ,$cardNumberDefault
                          ,substr($expiryDateDefault,0,7)
                          ,$amount
                          );   
                }
                $con->close();
                $result->free();
            }
            ?>
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