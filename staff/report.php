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
  <link href="../assets/css/report.css" rel="stylesheet" type="text/css"/>
</head>
 <body>
<?php
    include './../general/staff_header.php';
    require_once '../secret/database.php';
?>
<main class="main">
<section id="portfolio-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
    <div class="col-lg-12">
    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
    <h3>Monthly Sales Report</h3>
    <form method='POST'>
        <label for='month'>Please select the month that you want to generate the sales report</label><br>
        <input type='month' name='month'>
        <input type='submit' name='monthlyBtn' value='Confirm'>
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </form>
    </div>
    <br>    
    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
        <h3>Most Video Reviews and Comments</h3>
        <div id="piechart2" style="width: 900px; height: 500px;"></div>
    </div>
    </div>
    </div>
    </div>
</section>   
    
</main>        
<?php
include './../general/footer.php';
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Type', 'Number of participations'],
  
  <?php
  if(isset($_POST["monthlyBtn"])){
    $date =  trim($_POST["month"]);  
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $sql = "SELECT * FROM payment p JOIN events e on p.EventImage = e.EventImage";
    $result = $con ->query($sql);
    $count = 0;
    $totalTou = 0; $totalClass = 0; $totalCamp = 0;
    if($result -> num_rows > 0){
        while($row = $result ->fetch_object()){
            $getDate = trim(substr($row->PaymentDate,0,7));
            if($getDate == $date){
                if($row->EventType == "Tournament"){
                    $totalTou += $row->Amount;
                }else if($row->EventType == "Class"){
                    $totalClass += $row->Amount;
                }else if($row->EventType == "Camp"){
                    $totalCamp += $row->Amount;
                }
                $count++;
            }
        }
        printf("
            ['Tournament', %.2f],
            ['Camp', %.2f],
            ['Class', %.2f]
                 ",$totalTou,$totalCamp,$totalClass);
    }else{
        printf("<h5>No record found</h5>");
    }
    if($count == 0){
        printf("Record No found");
    }
}
?>  
]);

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data);
}

google.charts.setOnLoadCallback(drawChart2);

        function drawChart2() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Video Description');
            data.addColumn('number', 'Number of Review and Comment');
            
            <?php
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            $sql = "SELECT videoDescription, COUNT(rating) as rating FROM repcomment c JOIN repository r ON c.videoID=r.videoID GROUP BY videoDescription";  
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    $video = $row->videoDescription;
                    $numRate = $row->rating;
                    echo "data.addRow(['$video', $numRate]);";
                }
            } else {
                echo "console.log('No data available');";
            }

            $con->close();
            ?>
            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart.draw(data);
        }

</script>
</body>
</html>
