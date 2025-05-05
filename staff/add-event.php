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
    <style>
.posterImg{
    width: 435px;
    height: 650px;
}

.setWidth{
    width: 20%;
}

.setWidth2, .setWidth3{
    width: 75%;
    display: flex;
}
.setWidth3 input{
    width: 30%;
    margin-right: auto;
}
.inputWitdh{
    width: 100%;      
}
      
.all{
    display: flex;
    width: 115%;    
} 
.left{
    width: 60%; /*360*/    
}
     
.right .rightImg img, .rightImg{
    width: 400px;
    height: 500px;
    margin-bottom: 15px;
    border: 1px solid black;
}
.addEventBtn{
    height: 50px;
    width: 200px;
    border: none;
    border-radius: 50px;
    font-size: 20px;
    background-color: rgba(235,93,30,0.7);
    color: #212529;
}
.portfolio-info form{
    display: block;
}
</style>
</head>

<body>
  <?php
    require_once '../secret/database.php';
    require './../secret/verifying.php';
    include './../general/staff_header.php';
  ?>

<main class="main">
<section id="portfolio-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
    <div class="col-lg-12">
    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
    <form action='' method='POST' enctype="multipart/form-data">  

    <h3>Add Event</h3>
    <?php   
    if(isset($_POST["uploadBtn"])){
        if(isset($_FILES['eventImage'])){
            $file = $_FILES['eventImage'];
            
            if($file['error']>0){
                switch ($file['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $err = 'No file was selected.';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $err = 'Image uploaded is too large.Maximum 1MB allowed.';
                        break;
                    default:
                        $err = 'There was an error while uploading the Image.';
                        break;
                }
            }else if($file['size'] > 1048576){
                $err = 'File uploaded is too large.Maximum 1MB allowed.';
            }else{
                $ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
                
                if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'png'){
                    $err = 'Only JPG, GIF and PNG format are allowed.';
                }else{
                    $uploadImage = uniqid().'.'.$ext;
                    move_uploaded_file($file['tmp_name'], '../eventImage/'.$uploadImage);
                }
            }
            
            if(isset($err)){
                echo "$err";
            }
        }
    }else if(isset($_POST["addBtn"])){
        $eventName = trim($_POST["eventName"]);
        
        if(isset($_POST["eventType"])){
            $eventType = trim($_POST["eventType"]);
        }else{
            $eventType = "";
        }
        
        if(isset($_POST["eventDateStart"])){
            $eventDateStart = trim($_POST["eventDateStart"]);
        }else{
            $eventDateStart = "";
        }

        if(isset($_POST["eventTimeStart"])){
            $eventTimeStart = trim($_POST["eventTimeStart"]);
        }else{
            $eventTimeStart = "";
        }
        
        if(isset($_POST["eventDateEnd"])){
            $eventDateEnd = trim($_POST["eventDateEnd"]);
        }else{
            $eventDateEnd = "";
        }
        
        if(isset($_POST["eventTimeEnd"])){
            $eventTimeEnd = trim($_POST["eventTimeEnd"]);
        }else{
            $eventTimeEnd = "";
        }
        
        if(isset($_POST["categories"])){
            $categories = trim($_POST["categories"]);
        }else{
            $categories = "";
        }
        
        if(isset($_POST["venue"])){
            $eventVenue = trim($_POST["venue"]);
        }else{
            $eventVenue = "";
        }
        
        if(isset($_POST["closingDate"])){
            $closingDate = trim($_POST["closingDate"]);
        }else{
            $closingDate = "";
        } 
        
        if(isset($_POST["image"])){
            $image = trim($_POST["image"]);
            if($image == NULL){
                $error["image"] = "Please upload the <b>IMAGE</b>";
            }
        }
        
        $eventFee = trim($_POST["eventFee"]);
        $eventPrize = trim($_POST["eventPrice"]);
        
        $error["name"] = checkEventName($eventName);
        $error["type"] = checkEventType($eventType);
        $error["dateStart"] = checkEventDate($eventDateStart);
        $error["dateEnd"] = checkEventDate($eventDateEnd);
        $error["timeStart"] = checkEventTimeStart($eventTimeStart);
        $error["timeEnd"] = checkEventTimeEnd($eventTimeEnd);
        $error["venue"] = checkEventVenue($eventVenue);
        $error["fee"] = checkEventFee($eventFee);
        $error["prize"] = checkEventPrice($eventPrize);
        $error["closing"] = checkClosingDate($closingDate);
        $error["categories"] = checkCategories($categories);
        
        $error = array_filter($error);
        
        if(empty($error)){
            
            $eventTimeStart = $eventDateStart . " " . $eventTimeStart;
            $eventTimeEnd = $eventDateEnd . " " . $eventTimeEnd;
            
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $sql = "INSERT INTO events (EventName,EventType,EventDateStart,EventDateEnd,EventTimeStart,EventTimeEnd,EventCategories,EventVenue,EventFee,ClosingDate,EventPrize,EventImage) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            
            $stmt = $con ->prepare($sql);
            $stmt->bind_param("ssssssssssss", $eventName,$eventType,$eventDateStart,$eventDateEnd,$eventTimeStart,$eventTimeEnd,$categories,$eventVenue, $eventFee,$closingDate,$eventPrize,$image);
            $stmt->execute();
            
            if($stmt -> affected_rows > 0){
                echo "<script>alert('Insert Successfull');window.location.href='staff-event.php'</script>";
            }else{
                printf("Database Error! Unable to Insert the data");
            }
            $stmt -> close();
            $con -> close();
        }else{
            echo "<ul>";
            foreach($error as $value){
                echo "<li>$value</li>";
            }
            echo "</ul>";
        }
    }
    ?>

    <div class='all'>
        <div class='left'>
        <ul>
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Event Name</strong></div>
            <div class='setWidth2'><input type='text' name='eventName' class='inputWitdh'></div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Type</strong></div>
            <div class='setWidth2'>
                <div class='inputWitdh'>
                <input type='radio' id='tournament' value='Tournament' name='eventType'>
                <label for='tournament'>Tournament</label>
                </div>
                            
                <div class='inputWitdh'>
                <input type='radio' id='class' value='Class' name='eventType'>
                <label for='class'>Class</label>
                </div>
                            
                <div class='inputWitdh'>
                <input type='radio' id='camp' value='Camp' name='eventType'>
                <label for='camp'>Camp</label>
                </div>
            </div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Start At</strong></div>
            <div class='setWidth3'>
                <input type='date' name='eventDateStart' class='inputWitdh'>
                <input type='time' name='eventTimeStart' class='inputWitdh'>
            </div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>End At</strong></div>
            <div class='setWidth3'>
                <input type='date' name='eventDateEnd' class='inputWitdh'>
                <input type='time' name='eventTimeEnd' class='inputWitdh'>
            </div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Age Categories</strong></div>
            <div class='setWidth2'>
                <select name='categories'>
                    <option>U12</option>
                    <option>U15</option>
                    <option>U18</option>
                    <option>A18</option>
                    <option>A50</option>
                    <option>Open</option>
                </select>
            </div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Venue</strong></div>
            <div class='setWidth2'>
                <select name="venue">
                    <?php
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                    $sql = "SELECT * FROM venue";
                    $result = $con->query($sql);
                    if($result -> num_rows > 0){
                        while($row = $result->fetch_object()){
                            printf("<option>%s</option>", $row->venueName);
                        }
                    }
                    ?>
                </select>
            </div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Fee (RM)</strong></div>
            <div class='setWidth2'><input type='text' name='eventFee' class='inputWitdh'></div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Closing Date</strong></div>
            <div class='setWidth3'><input type='date' name='closingDate' class='inputWitdh'></div>
        </li>
        
        <li class='editEventTable' style='display: flex;'>
            <div class='setWidth'><strong>Price (RM)</strong></div>
            <div class='setWidth2'><input type='text' name='eventPrice' class='inputWitdh'></div>
        </li>
        </ul>
        </div>
        
        
        <div class='right'>
            <div class="rightImg"><?php if(isset($uploadImage)){echo "<img src= '../eventImage/$uploadImage'>";}?></div>
            <div><strong>Upload Poster</strong></div>
            <div><input type='file' name="eventImage"><input type="submit" value="Upload" name="uploadBtn"></div>
            <input type="hidden" name="image" value="<?php if(isset($uploadImage)){echo "$uploadImage";}?>">
        </div>
    </div>   
    <a href='staff-event.php'><button type='button'>Cancel Add</button></a>
    <a href=''><button type='submit' name="addBtn">Add Event</button></a>
  </form>
    
    </div>  
    </div>
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

</body>

</html>
