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
  <link href="assets/css/repository.css" rel="stylesheet" type="text/css"/>
</head>
    <body>
        <?php
            include './general/header.php';
            require_once './secret/database.php';
        ?>
   
        
        <div class="repository" style="border:0">
        
            
            <h1>Game Repository</h1>
            
            <p>Chess Society: All videos are free for everyone.</p>
            <div class="videoBox">
               <?php
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $sql = "SELECT * FROM repository";
            $result = $con->query($sql);
            if($result -> num_rows > 0){
            while($row = $result -> fetch_object()){
                printf("<a href='gameRep.php?videoID=%s&video=%s'>
                    <img class='imgGrid' src='staff/video/%s' alt=''/>
                    <p>%s</p>
                    
                </a>",$row -> videoID,$row -> repositoryVideo,$row -> thumbnail,$row -> videoDescription);
            }
            }
            ?>    
               
                
            </div>
            <div class="page"><span class="number">1&nbsp;&nbsp;&nbsp;</span> <span class="number">2&nbsp;&nbsp;&nbsp;</span> <span class="number">3&nbsp;&nbsp;&nbsp;</span> <span class="number">4&nbsp;&nbsp;&nbsp;</span> <a href="#">></a></span></div>
        </div>
        
        
        <?php
            include './general/footer.php';
        ?>
    </body>
</html>