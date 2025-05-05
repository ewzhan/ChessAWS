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
  <link href="../assets/css/forum.css" rel="stylesheet" type="text/css"/>
    <style>
    div.rate input[type="radio"] {
    display: none;
}

div.rate label {
    font-size: 15px;
    border: none;
    cursor: pointer; /* Add cursor pointer to indicate clickable */
}

div.rate input[type="radio"]:checked + label {
    border: 1px solid blue;
}
    </style>
</head>

<body>
  <?php
    include './../general/staff_header.php';
    require_once './../secret/database.php';
  ?>
   <div id="backFlap">
        <div  id="threadModal" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-header d-flex align-items-center bg-primary text-white chatBox">
                            <h6 class="modal-title mb-10" id="threadModalLabel">New Discussion</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="xStyle" onclick="location.reload()">
                                <span aria-hidden="true">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="threadTitle">Title</label>
                                <input type="text" class="form-control" id="threadTitle" name="forumTitle" placeholder="Enter title" autofocus="" />
                            </div>
                            <textarea class="form-control summernote" style="display: none;"></textarea>
    
                            <div class="custom-file form-control-sm mt-3" style="max-width: 300px;">
                                <input type="file" class="custom-file-input" id="customFile" name="forumImg" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="1048576000" />
                                <label class="custom-file-label" for="customFile">Attachment</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal" onclick="location.reload()">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="postForum">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php 
    if(isset($_POST['postForum'])){
    if (isset($_COOKIE['user'])) {
        $user = $_COOKIE['user'];
        if(isset($_POST['forumTitle']) && !empty($_POST['forumTitle'])){ 
            $content = $_POST['forumTitle'];
            $save_as = "NULL";

            if(isset($_FILES['forumImg'])){
                $file = $_FILES['forumImg'];

                if($file['size'] > 1048576000){
                    $err = 'File uploaded is too large. Maximum 1MB allowed.';
                }else{
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                    if(!in_array($ext, ['jpg', 'jpeg', 'gif', 'png'])){
                        $err = 'Only JPG, GIF, and PNG formats are allowed.';
                    }else{
                        $save_as = uniqid().'.'.$ext;
                        move_uploaded_file($file['tmp_name'], '../forumImgVideo/'.$save_as);
                    }
                }
            }else{
                $save_as = " ";
            }

            $forumId = "f". uniqid();
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentTimestamp = time();
            $time = date('Y-m-d H:i:s', $currentTimestamp);
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "INSERT INTO forum (forumID, UserID, titleOrCom, imgForum, upForumTime, forumLike, forumDislike, reportForum) VALUES (?, ?, ?, ?, ?, 0, 0, 0)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssss", $forumId, $user, $content, $save_as, $time);

            if ($stmt->execute()) {
                echo "<div class='info'>Discussion posted successfully.</div>";
            } else {
                echo "Failed to post discussion: " . $stmt->error;
            }

            $stmt->close();
            $con->close();
        }else{
            echo "Please enter a Title or Content";
        }
    } else {
        echo "You need to login before posting a discussion.";
    }
    }
if (isset($_POST['submitLikeBtn'])) {
    if (isset($_POST['likeForum'])) {
        $check = $_POST['likeForum'];
        $id = $_POST['forumID'];
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Prepare the update query
        $sql = "UPDATE forum SET ";
        if ($check == "L") {
            $sql .= "forumLike = forumLike + 1";
        } else if ($check == "N") {
            $sql .= "forumDislike = forumDislike + 1";
        } else if ($check == "R") {
            $sql .= "reportForum = reportForum + 1";
        }
        $sql .= " WHERE forumID = ?";
        
        // Prepare and execute the query
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            echo "Updated successfully.";
        } else {
            echo "Error updating likes, dislikes, and reports.";
        }

        $stmt->close();
        $con->close();
    }
}

if (isset($_POST['dltComm'])) {
    $forID = $_POST['forumID'];
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "DELETE FROM forum WHERE forumID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $forID);
    if ($stmt->execute()) {
        echo "Comment deleted successfully.";
    } else {
        echo "Error deleting comment: " . $stmt->error;
    }
    $stmt->close();
    $con->close();
}
    ?>
    <main>
    
    <div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper" id="pos">
            <!-- Inner sidebar -->
            <div class="inner-sidebar" id="pos1">
                <!-- Inner sidebar header -->
                <div class="inner-sidebar-header justify-content-center" id="pos2">
                    <button class="btn btn-primary has-icon btn-block" type="button" data-toggle="modal" data-target="#threadModal" onclick="postForum()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        NEW DISCUSSION
                    </button>
                </div>
                <!-- /Inner sidebar header -->
    
                <!-- Inner sidebar body -->
                <div class="inner-sidebar-body p-0" id="pos3">
                    <div class="p-3 h-100" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: -16px;">
                            <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
                                        <div class="simplebar-content" style="padding: 16px;">
                                            <nav class="nav nav-pills nav-gap-y-1 flex-column">
                                                <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon active">All Threads</a>
                                                <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon">Popular this week</a>
                                                <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon">Popular all time</a>
                                                <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon">No replies yet</a>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div>
                    </div>
                </div>
                <!-- /Inner sidebar body -->
            </div>
            <!-- /Inner sidebar -->
    
            <!-- Inner main -->
            <div class="inner-main" id="pos4">
                <!-- Inner main header -->
                <div class="inner-main-header">
                    <a class="nav-link nav-icon rounded-circle nav-link-faded mr-3 d-md-none" href="#" data-toggle="inner-sidebar"><i class="material-icons">arrow_forward_ios</i></a>
                    <select class="custom-select custom-select-sm w-auto mr-1">
                        <option selected="">Latest</option>
                        <option value="1">Popular</option>
                        <option value="3">No Replies Yet</option>
                    </select>
                    <span class="input-icon input-icon-sm ml-auto w-auto" style="margin-left: 10px;">
                        <input type="text" class="form-control form-control-sm bg-gray-200 border-gray-200 shadow-none mb-4 mt-4" placeholder="Search forum" />
                    </span>
                </div>
                <!-- /Inner main header -->
    
                <!-- Inner main body -->
    
                <!-- Forum List -->
                <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
                    <?php
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT * FROM forum f JOIN user u ON f.UserID=u.UserID Order BY upForumTime";
$result = $con->query($sql);
$count = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        $forum = $row->forumID;
        $user = $row->UserID;
        $name = $row->UserName;
        $title = $row->titleOrCom;
        $img = $row->imgForum;
        $pro = $row->profilePicture;
        $time = $row->upForumTime;
        $like = $row->forumLike;
        $dislike = $row -> forumDislike;
        $report = $row-> reportForum;
        if ($img == NULL) {
            $img = " ";
        }
printf('
                <div class="card mb-2">
                    <div class="card-body p-2 p-sm-3">
                        <div class="media forum-item">
                            <a href="#" data-toggle="collapse" data-target=".forum-content"><img src="../profileImage/%s" class="mr-3 rounded-circle" width="50" alt="User" /></a>
                            <div class="media-body">
                                <h6><a href="#" data-toggle="collapse" data-target=".forum-content" class="text-body">%s</a></h6>
                                <p style="font-size:10px;">%s</p>
                                <p class="text-secondary">%s</p>
                                <img src="../forumImgVideo/%s" alt="" style="height:150px;width:200px;"/>
                            </div>
                            <div class="rate text-muted small text-center align-self-center">
                                <form method="POST">
                                    <input type="radio" id="likeF%d" name="likeForum" value="L" />
                                    <label for="likeF%d">&#x1F44D;</label><span id="likeCount%d">%d</span>                            
                                    <input type="radio" id="dislikeF%d" name="likeForum" value="N" />
                                    <label for="dislikeF%d">&#x1F44E;</label><span id="dislikeCount%d">%d</span>
                                    <input type="radio" id="reportF%d" name="likeForum" value="R" />
                                    <label for="reportF%d">&#9888;</label><span id="reportCount%d">%d</span>
                                    <input type="hidden" value="%s" name="forumID" />
                                    <input type="hidden" value="%d" name="forumLike" />
                                    <input type="hidden" value="%d" name="forumDislike" />
                                    <input type="hidden" value="%d" name="forumReport" />
                                    <input type="submit" value="Submit" name="submitLikeBtn" />
                                    <input type="submit" value="delete" name="dltComm" onclick=\'return confirm("Are you sure you want to delete?")\'/>
                                    </form>
                                <!--Like and Dislike-->
                            </div>
                        </div>
                    </div>
                </div>',
                $pro,$name, $time,$title, $img, $count, $count, $count,$like, $count, $count, $count, $dislike,$count, $count, $count,$report, $forum,$like,$dislike,$report
            );
            $count++;
        }
    }
                
     ?>
           </div>
                <!-- /Forum Detail -->
    
                <!-- /Inner main body -->
            </div>
            <!-- /Inner main -->
        </div>
        </div></div>    
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
function postForum(){
    
    var pls5 = document.getElementById("backFlap");

  
    document.body.style.overflow = "hidden";

    pls5.style.display="block";

}
</script>

</body>

</html>
