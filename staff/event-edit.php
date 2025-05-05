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
      
.right .rightImg img{
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
    require './../secret/verifying.php';
    require_once '../secret/database.php';
    include './../general/staff_header.php';
  ?>

<main class="main">
<section id="portfolio-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
    <div class="col-lg-12">
    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
        
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
                $eventVenue = $row -> EventVenue;
                $eventCategories = $row -> EventCategories;
                $eventFee = $row -> EventFee;
                $eventPrize = $row -> EventPrize;
                $eventImage = $row -> EventImage;
                $closingDate = $row -> ClosingDate;
                
                $checkType1 = "";
                $checkType2 = "";
                $checkType3 = "";
                if($eventType == "Tournament"){
                    $checkType1 = "checked";
                }else if($eventType == "Class"){
                    $checkType2 = "checked";
                }else if($eventType == "Camp"){
                    $checkType3 = "checked";
                }else{
                    echo "Undefine Event Type";
                }
                
                $checkCat1 = "";
                $checkCat2 = "";
                $checkCat3 = "";
                $checkCat4 = "";
                $checkCat5 = "";
                $checkCat6 = "";
                if($eventCategories == "U12"){
                    $checkCat1 = "selected";
                }else if($eventCategories == "U15"){
                    $checkCat2 = "selected";
                }else if($eventCategories == "U18"){
                    $checkCat3 = "selected";
                }else if($eventCategories == "A18"){
                    $checkCat4 = "selected";
                }else if($eventCategories == "A50"){
                    $checkCat5 = "selected";
                }else if($eventCategories == "Open"){
                    $checkCat6 = "selected";
                }
                
                printf("
                <form action='' method='POST'>
                <h3>Edit Event information</h3>
                <div class='all'>
                    <div class='left'>
                    <ul>
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Event Name</strong></div>
                        <div class='setWidth2'><input type='text' value='%s' name='eventName' class='inputWitdh'></div>
                    </li>
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Type</strong></div>
                        <div class='setWidth2'>
                            <div class='inputWitdh'>
                            <input type='radio' id='tournament' value='Tournament'  name='eventType' %s>
                            <label for='tournament'>Tournament</label>
                            </div>
                            
                            <div class='inputWitdh'>
                            <input type='radio' id='class' value='Class' name='eventType' %s>
                            <label for='class'>Class</label>
                            </div>
                            
                            <div class='inputWitdh'>
                            <input type='radio' id='camp' value='Camp' name='eventType' %s>
                            <label for='camp'>Camp</label>
                            </div>
                        </div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Start At </strong></div>
                        <div class='setWidth3'>
                            <input type='date' value='%s' name='eventDateStart' class='inputWitdh'>
                            <input type='time' value='%s' name='eventTimeStart' class='inputWitdh'>
                        </div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>End At</strong></div>
                        <div class='setWidth3'>
                            <input type='date' value='%s' name='eventDateEnd' class='inputWitdh'>
                            <input type='time' value='%s' name='eventTimeEnd' class='inputWitdh'>
                        </div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Age Categories</strong></div>
                        <div class='setWidth2'>
                            <select name='categories'>
                                <option %s>U12</option>
                                <option %s>U15</option>
                                <option %s>U18</option>
                                <option %s>A18</option>
                                <option %s>A50</option>
                                <option %s>Open</option>
                            </select>
                        </div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Venue</strong></div>
                        <div class='setWidth2'>
                        <select name='venue'>
                       ", $eventName
                        , $checkType1
                        , $checkType2
                        , $checkType3
                        , $eventDateStart
                        , substr($eventTimeStart,11)
                        , $eventDateEnd
                        , substr($eventTimeEnd, 11)
                        , $checkCat1
                        , $checkCat2
                        , $checkCat3
                        , $checkCat4
                        , $checkCat5
                        , $checkCat6
                        );
                
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                    $sql = "SELECT * FROM venue";
                    $result = $con->query($sql);
                    if($result -> num_rows > 0){
                        while($row = $result->fetch_object()){
                            if($row->venueName == $eventVenue){
                                printf("<option selected>%s</option>", $row->venueName);
                            }else{
                                printf("<option>%s</option>", $row->venueName);   
                            }
                        }
                    }

                printf(" 
                        </select>
                        </div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Fee (RM)</strong></div>
                        <div class='setWidth2'><input type='text' value='%.2f' name='eventFee' class='inputWitdh'></div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Closing Date</strong></div>
                        <div class='setWidth3'><input type='date' value='%s' name='closingDate' class='inputWitdh'></div>
                    </li>
                    
                    <li class='editEventTable' style='display: flex;'>
                        <div class='setWidth'><strong>Prize (RM)</strong></div>
                        <div class='setWidth2'><input type='text' value='%.2f' name='eventPrize' class='inputWitdh'></div>
                    </li>
                    </ul>
                    </div>
              
                    <div class='right'>
                        <div class='rightImg'><img src='../eventImage/%s'></div>
                        <div><strong>Change Poster</strong></div>
                        <div><input type='file'></div>
                    </div>
                </div>
                
                <a href='staff-event.php'><button type='button'>Cancel Changes</button></a>
                <a><button type='submit' name='saveBtn'>Save Changes</button></a>
                <a><button type='button' onclick='deleteDiv()'>Delete Event</button></a>
                
                <div id='confirm' style='display:none;'>           
                    <h5 style='margin-top: 20px;'>Are you sure to delete this event?</h5>
                    <button type='submit' name='deleteBtn'>Yes</button>
                    <a href='event-edit.php?image=%s'><button type='button'>No</button></a>
                </div>
                </form>
                       "
                        , $eventFee
                        , $closingDate
                        , $eventPrize
                        , $eventImage
                        , $eventImage
                        , $eventImage
                        );
            }else{
                echo "<a>Unable to Process!</a><br><a href='staff-event.php'>[ Back to event page ]</a>";
            }
            $result -> free();
            $con -> close();
        }else{
            if(isset($_POST["saveBtn"])){
            $imagePost = trim($_GET["image"]);
            $eventNamePost = trim($_POST["eventName"]);
            $eventTypePost = trim($_POST["eventType"]);
            $eventDateStartPost = trim($_POST["eventDateStart"]);
            $eventDateEndPost = trim($_POST["eventDateEnd"]);
            $eventTimeStartPost = trim($_POST["eventTimeStart"]);
            $eventTimeEndPost = trim($_POST["eventTimeEnd"]);
            $eventVenuePost = trim($_POST["venue"]);
            $eventFeePost = trim($_POST["eventFee"]);
            $eventPrizePost = trim($_POST["eventPrize"]);
            $eventClosingDatePost = trim($_POST["closingDate"]);
            $eventCategoriesPost = trim($_POST["categories"]);
            
            $error["name"] = checkEventName($eventNamePost);
            $error["type"] = checkEventType($eventTypePost);
            $error["dateStart"] = checkEventDate($eventDateStartPost);
            $error["dateEnd"] = checkEventDate($eventDateEndPost);
            $error["timeStart"] = checkEventTimeStart($eventTimeStartPost);
            $error["timeEnd"] = checkEventTimeEnd($eventTimeEndPost);
            $error["venue"] = checkEventVenue($eventVenuePost);
            $error["fee"] = checkEventFee($eventFeePost);
            $error["prize"] = checkEventPrice($eventPrizePost);
            $error["closing"] = checkClosingDate($eventClosingDatePost);
            $error["categories"] = checkCategories($eventCategoriesPost);
            $error = array_filter($error);
            
            if(empty($error)){
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
                $sql = "UPDATE Events SET EventName = ? , EventType = ?, EventDateStart = ?, EventDateEnd = ?, EventTimeStart = ?,
                        EventTimeEnd = ?, EventCategories = ? , EventVenue = ?, EventFee = ?, ClosingDate = ? , EventPrize = ?, EventImage = ? WHERE EventImage = ?";
                
                $statement = $con ->prepare($sql);
                
                $statement ->bind_param("sssssssssssss", 
                $eventNamePost,$eventTypePost,$eventDateStartPost,$eventDateEndPost,$eventTimeStartPost,$eventTimeEndPost,$eventCategoriesPost,$eventVenuePost,$eventFeePost,$eventClosingDatePost,$eventPrizePost,$imagePost,$imagePost);
                
                $statement ->execute();
                
                if($statement -> affected_rows > 0){
                    printf("
                    <div style='display: block;'>
                        <div>Changes Successfully</div>
                        <div><a href='staff-event-details.php?image=". $imagePost . "'>[ See Update Details ]</a></div>
                        <div><a href='staff-event.php'>[ Back to event page ]</a></div>
                    </div>
                     ");
                }else{
                    printf("Database Upload Failed!");
                }
            }else{
                echo "<ul>";
                foreach($error as $value){
                    echo "<li>$value</li>";
                }
                echo "</ul>";
                echo "<a href=''>Try Again</a>";
            }   
            }else if(isset($_POST["deleteBtn"])){
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
        }
        ?> 
            
              
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
  <script>
  function deleteDiv(){
      document.getElementById('confirm').style.display='block';
  }
  </script>
</body>

</html>
