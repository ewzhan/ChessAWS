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
        define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "chess");
    ?>
    <main>
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </main>
            
    <?php
        include './../general/footer.php';
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'User Name');
            data.addColumn('number', 'Number of User Join Every Year');
            
            <?php
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            $sql = "SELECT UserName, sum(loginCount) as Visit FROM user GROUP BY UserName";  
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    $username = $row->UserName;
                    $loginCount = $row->Visit;
                    echo "data.addRow(['$username', $loginCount]);";
                }
            } else {
                echo "console.log('No data available');";
            }

            $con->close();
            ?>
            
            var options = {
                title: 'Total User Join in each Year',
                is3D: true
            };
            
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
</body>
</html>