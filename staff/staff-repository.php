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
  <link href="../assets/css/main.css" rel="stylesheet">
  <link href="../assets/css/repository.css" rel="stylesheet" type="text/css"/>
  
</head>
    <body>
<?php
    include '../general/staff_header.php';
    require_once './../secret/database.php';
  ?>

        <div class="repository" style="border:0">
            
            <h1>Game Repository</h1>            
            <p>Chess Society: All videos are free for everyone.</p>
            <?php
        if(isset($_FILES['thumbnail']) && isset($_FILES['video'])){
            
            $file = $_FILES['thumbnail'];
            $videoFile = $_FILES['video'];
            if($file['error']>0){
                switch ($file['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $err = 'No thumbnail was selected.';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $err = 'File uploaded is too large.Maximum 1MB allowed.';
                        break;
                    default:
                        $err = 'There was an error while uploading the file.';
                        break;
                }
            }else if($file['size'] > 1048576){
                $err = 'File uploaded is too large.Maximum 1MB allowed.';
            }else if($videoFile['error']>0){
                switch ($videoFile['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $err = 'No video was selected.';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $err = 'File uploaded is too large.Maximum 1MB allowed.';
                        break;
                    default:
                        $err = 'There was an error while uploading the file.';
                        break;
                }
            }else if($videoFile['size'] > 1048576000){
                $err = 'File uploaded is too large.Maximum 100MB allowed.';
            }else if(empty($_POST["videoDescription"])){
                $err = 'Forgot to enter video description ';
                
                
            }else{
                $ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
                $videoExt = strtolower(pathinfo($videoFile['name'],PATHINFO_EXTENSION));
                
                if($videoExt != 'mp4' && $videoExt != 'avi' && $videoExt != 'mov'){
                    $err = 'Only MP4, AVI, MOV and WMV format are allowed.';
                }else if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'png'){
                    $err = 'Only JPG, GIF and PNG format are allowed.';
                }else{
                    //everything good
                    $save_as = uniqid().'.'.$ext;
                    $save_as_video = uniqid().'.'.$videoExt;
                    $video_description = trim($_POST["videoDescription"]);
                    move_uploaded_file($file['tmp_name'], 'video/'.$save_as);
                    move_uploaded_file($videoFile['tmp_name'], 'video/'.$save_as_video);
                    $videoID = 'v'. uniqid();
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                    
                    $sql = "Insert into repository(thumbnail,repositoryVideo,videoDescription,videoID)Values('$save_as','$save_as_video','$video_description','$videoID')";
                    
                    if($con->query($sql)){
                        printf('<div class="info">Video uploaded succesfuly.It is saved as [<a href="staff-gameRep.php?videoID=%s&video=%s">%s</a>]</div>',$videoID,$save_as_video,$video_description);                         
                    }
                    $con->close();
                    
                }
            }           
        }
            if(!empty($err)){
            printf("%s",$err);
            }
         
        ?>
           
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576000" />
            <table cellpadding="10">
               <tr>
                   <td>Video Thumbnail :</td>
                   <td><input type="file" name="thumbnail" /></td>  
            </tr>
            <tr>
                <td>Video :</td>
                <td><input type="file" name="video" /></td>           
            </tr>
            <tr>
                <td>Description :</td>
                <td><input type="text" name="videoDescription" value="" /></td>           
            </tr>
            </table>
            <br />
            
                <input type="submit" value="Add Video" name="btnAdd"/>
           
            
            <div class="videoBox">
            <?php
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $sql = "SELECT * FROM repository";
            $result = $con->query($sql);
            if($result -> num_rows > 0){
            while($row = $result -> fetch_object()){
                printf("<a href='staff-gameRep.php?videoID=%s&video=%s'>
                    <img class='imgGrid' src='video/%s' alt=''/>
                    <p style='float:left;'>%s</p>
                    <input style='margin-left:480px;margin-top:10px;width:20px;height:20px;' type='checkbox' name='checked[]' value='%s'/>
                </a>",$row -> videoID,$row -> repositoryVideo,$row -> thumbnail,$row -> videoDescription,$row -> videoID);
            }
            }
            ?>    
                
                
                
            </div>
            <div class="page"><span class="number">1&nbsp;&nbsp;&nbsp;</span> <span class="number">2&nbsp;&nbsp;&nbsp;</span> <span class="number">3&nbsp;&nbsp;&nbsp;</span> <span class="number">4&nbsp;&nbsp;&nbsp;</span> <a href="#">></a></span></div>
            <?php
if(isset($_POST["btnDelete"])){
    
            //retrive id
            if(isset($_POST["checked"])){
                $check = $_POST["checked"];
                
            }else{
                $check = null;
                echo"No video was selected";
            }
            
            if(!empty($check)){
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);               
                $escape = array();
                FOREACH($check as $value){
                    //clean id to remove special char
                    $escape[] = $con->real_escape_string($value);
                    
                }
                $sql = "DELETE FROM repository Where videoID IN('" .
                        implode("','",$escape) . "')";
                
                if($con->query($sql)){
                    
                    printf("<div class='info'>
                        <b>%d</b> record(s) has been deleted.
                            </div>",$con->affected_rows);
                }
                $con->close();
            }
        }
        ?>
                <input type="submit" value="Delete Video Selected" name="btnDelete" onclick="return confirm('This will delete all selected records.\n Are you sure?')"/> 
            </form>
        </div>
        
        
      <?php
    include './../general/footer.php';
  ?>
    </body>
</html>