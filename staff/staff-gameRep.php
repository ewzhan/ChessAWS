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
  <link href="../assets/css/main.css" rel="stylesheet" type="text/css"/>
  <link href="../assets/css/gameRep.css" rel="stylesheet" type="text/css"/>

    <script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>

</head>
    <body>
        <?php
        require_once '../secret/database.php';
        include './../general/staff_header.php';
        ?>
        
        <div class="repository" style="border:0">
            
            <h1>Game Repository</h1>
            
            <p>Chess Society: All videos are free for everyone.</p>
            <?php 
            if(isset($_GET["video"])){
            $video = trim($_GET["video"]);
            if(!empty($video)){
                $id = trim($_GET["videoID"]);
                
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                            $sql = "SELECT videoDescription FROM repository WHERE videoID = '$id'";
                            $result = $con -> query($sql);
                            if($selected = $result -> fetch_object()){
                                $title = $selected -> videoDescription;
                            printf("<h1>%s</h1>",$title);    
                            }else{ 
                                $title = " ";
             
                            }
                            
                            $result -> free();
                            $con -> close();
            }
            }else{
               echo"No video selected [<a href='repository.php'>Back to Repository Menu</a>]";               
            }
            
            if(isset($_POST["subEditReview"])){
    $comId = trim($_POST['comID']);
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    $updateRating = isset($_POST['editRating']) && is_array($_POST['editRating']) ? $_POST['editRating'][0] : $rating;
    if(isset($_POST['editReview'])){
        $updateReview = trim($_POST['editReview']);
    }else{
        $updateReview =  $userComment;
    }
    
    $stmt = $con->prepare("UPDATE repcomment SET rating = ?,userComment = ? WHERE commentID = ?");
    $stmt->bind_param("iss",$updateRating, $updateReview, $comId);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "Review updated successfully.";
    } else {
        echo "Error updating review.";
    }
    
    $stmt->close();
    $con->close();
}
            
if(isset($_POST['dltComm'])){
    $comID = $_POST['comID'];
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "DELETE FROM repcomment WHERE commentID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $comID);
    if($stmt->execute()){
        echo "Comment deleted successfully.";
    } else {
        echo "Error deleting comment: " . $stmt->error;
    }
    $stmt->close();
    $con->close();
}



            ?>   
            
            <div class="box">
            <video controls
                   
              <source src="video/<?php $video = $_GET["video"]; echo"$video";?>" type="<?php $video = $_GET["video"]; echo "video/" . substr($video,-3);?>">
              Your browser does not support the video tag.
            </video>
                <form action="" method="POST">
                <div class="rating">
              <input type="radio" id="star5" name="rating[]" value="5">
              <label for="star5">&#9733;</label>
              <input type="radio" id="star4" name="rating[]" value="4">
              <label for="star4">&#9733;</label>
              <input type="radio" id="star3" name="rating[]" value="3">
              <label for="star3">&#9733;</label>
              <input type="radio" id="star2" name="rating[]" value="2">
              <label for="star2">&#9733;</label>
              <input type="radio" id="star1" name="rating[]" value="1">
              <label for="star1">&#9733;</label>
            </div>
                
            <div class="review">
              <textarea name="review" placeholder="Write your review here..."></textarea><br>
              <input type="submit" value="Submit Review" name="submitReview" />
            </div>
               <!--Add a php code to store the rating value and review content-->
                </form>
            
       
        
<?php
if (isset($_POST['submitReview'])) {
    if (!empty($_GET["video"])) {
        $video = $_GET["videoID"];
        if (isset($_COOKIE['user'])) {
            $user = $_COOKIE['user'];
            // Get the selected rating
            if (isset($_POST['rating']) && is_array($_POST['rating'])) {
                $rating = $_POST['rating'][0]; // Assuming only one rating can be selected
                $review = !empty($_POST['review']) ? $_POST['review'] : null;
                $id = "c" . uniqid(); // Generate a unique comment ID
                $currentTimestamp = time();
                // Get the current date and time in a specific format
                $time = date('Y-m-d H:i:s', $currentTimestamp);
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Using prepared statement to prevent SQL injection
                $stmt = $con->prepare("INSERT INTO repcomment (videoID, UserID, rating, userComment, commentID, comTime) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssisss", $video, $user, $rating, $review, $id, $time);
                if ($stmt->execute()) {
                    echo "Review submitted successfully.";
                } else {
                    echo "Error submitting review: " . $stmt->error;
                }

                $stmt->close();
                $con->close();
            } else {
                echo "Please select a rating.";
            }
        } else {
            echo "You need to login before submitting a review [<a href='login.php'>Login</a>]";
        }
    } else {
        echo "No video to review [<a href='repository.php'>Repository Menu</a>]";
    }
}

// Display existing comments
if (!empty($_GET["videoID"])) {
    $video = $_GET["videoID"];
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT UserName, rating, userComment, u.UserID as UserID, comTime, commentID FROM repository r JOIN repComment c ON r.videoID = c.videoID JOIN user u ON c.UserID = u.UserID WHERE r.videoID = ? ORDER BY comTime DESC";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $video);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $userComm = $row->commentID;
            $rating = $row->rating;
            $stars = str_repeat('<div>&#9733;</div>', 5 - $rating) . str_repeat('<div style="color:#ffcc00;">&#9733;</div>', $rating);
            $user = $_COOKIE['user'];
            $userComment = htmlspecialchars($row->userComment);
            
            if ($row->UserID == $user) {
                printf("
    <div class='box'>
        <div>%s</div>
        <div id='comtime'>%s</div>
        <div class='rating'>
            %s
        </div>
        <p>%s</p>  
        <form method='POST'>
            <button type='button' id='editBtn%d' onclick='displayEdit(%d)'>Edit</button>
            <input type='hidden' value='%s' name='comID' />
            <input type='submit' value='delete' name='dltComm' onclick=\"return confirm('Are you sure you want to delete?')\"/>
            <div id='editForm%d' style='display:none;'>
                <div class='rating'>
                    <input type='radio' id='editStar5%d' name='editRating[]' value='5'>
                    <label for='editStar5%d'>&#9733;</label>
                    <input type='radio' id='editStar4%d' name='editRating[]' value='4'>
                    <label for='editStar4%d'>&#9733;</label>
                    <input type='radio' id='editStar3%d' name='editRating[]' value='3'>
                    <label for='editStar3%d'>&#9733;</label>
                    <input type='radio' id='editStar2%d' name='editRating[]' value='2'>
                    <label for='editStar2%d'>&#9733;</label>
                    <input type='radio' id='editStar1%d' name='editRating[]' value='1'>
                    <label for='editStar1%d'>&#9733;</label>
                </div>
                <div class='review'>
                    <textarea name='editReview' placeholder='Write your review here...'>$userComment</textarea><br>
                    <input type='submit' value='Edit Review' name='subEditReview'/>
                </div>
            </div>
        </form>
    </div>", htmlspecialchars($row->UserName), htmlspecialchars($row->comTime), $stars, $userComment, $count, $count, $userComm, $count, $count, $count, $count, $count, $count, $count, $count, $count, $count, $count, $count);   $count += 1;
            } else {
                printf("
                    <div class='box'>
                      <div>%s</div>
                      <div id='comtime'>%s</div>
                      <div class='rating'>
                        %s
                      </div>
                      <p>%s</p>  
                    </div>
                ", htmlspecialchars($row->UserName), htmlspecialchars($row->comTime), $stars, $userComment);
            }
        }
    }
    $stmt->close();
    $con->close();
}
?>    
</div>

<script>
    document.getElementsByName("rating")[0].checked = true;     
</script>
<?php
    include './../general/footer.php';
?>

<script>
function displayEdit(num) {
      let btn = document.getElementById("editBtn"+ num);
      let form = document.getElementById("editForm"+num);
      
    if(form.style.display == "block"){
        form.style.display = "none";
    }else{
        form.style.display = "block";
    }
}
</script>
    </body>
</html>
