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
    .box {
      max-width: 800px;
      margin: 30px auto;
      background-color: #fff;
      border-radius: 5px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    .ticket {
      background-color: #f9f9f9;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .ticket:hover {
      background-color: #e9e9e9;
    }

    .ticket-details {
      display: none;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-top: 10px;
    }

    .cancel-button {
      background-color: #dc3545;
      color: #fff;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 3px;
    }
    
    .ticketDetails{
        display: flex;
    }
    
    #ticketDetails{
        width:30%;
    }
    
    img.ticket-image{
        height: 100px;
        margin-left: 350px;
        margin-top: 10px;
    }
    
    .qrCode{
        height: 150px;
        margin-left: 350px;
    }
    #ticketCol{
        margin-bottom: 10px
    }
  </style>
  
</head>
<body>
<?php
    require_once './secret/database.php';
    include './general/header.php';
    include 'phpqrcode/qrlib.php';  
?>

<div class="box">
<h2>My Tickets</h2>
<div id="ticketsContainer">
    <?php
    
     //connection to database
              $con = new mysqli(DB_HOST,
                        DB_USER, DB_PASS, DB_NAME);
              
              //check
               if($con->connect_error){
                    die("Connection failed: ". $con->connect_error);
                }
                
                //sql
                 $sql = "SELECT *
FROM ticket t
JOIN events e ON t.EventImage = e.EventImage
JOIN user u ON t.UserID = u.UserID
JOIN payment p on p.EventImage = t.EventImage where t.UserID ='$userid';" ;
                 
                 //pass sql into connection to execute
                $ticketresult = $con->query($sql);    
               //check contains record
                if($ticketresult->num_rows >0){
                    //record returned
                    $i=0;
                    while ($row = $ticketresult->fetch_object()) {
                        $item = ["ticket ID: ".$row->ticketID,"Event Name: ".$row->EventName, "Ticket Price: RM".$row->ticketPrice, "Event Date: ".$row->EventDateStart, "Event Venue: ".$row->EventVenue, "PAX: ".$row->ticketNumber];   
                        $item = implode(" | ", $item);
                                $file = "qrImage/qr".$row->ticketID.".png";            
                                  $ecc = 'H';
                                $pixel_size = 20;
                                $frame_size = 5;

                                // Generates QR Code and Save as PNG
                                QRcode::png($item, $file, $ecc, $pixel_size, $frame_size);  
                        
                                            printf("
                           <div onclick='displayTickets(%d)' id='ticketCol'>
                           <div class='ticket' id='ticket%d'>
                             <div class='ticketDetails'>
                               <div id='ticketDetails'>
                               <p>%s - %s</p>
                               <p>Venue: %s</p>
                               <p>Total Price: RM%d</p>
                               </div>
                               <div><img src='eventImage/%s' class='ticket-image'></div>
                             </div>   
                           </div>  

                           <div class='ticket-details' id='ticket-details%d'>
                           <div class='ticketDetails'>
                           <div id='ticketDetails'>
                             <p>ID: %s</p>
                             <p>Event: %s</p>
                             <p>Date: %s</p>
                             <p>Venue: %s</p>
                             <p>Unit Price: RM%d</p>
                           </div>
                           <div><img src='%s' class='qrCode'></div>
                           </div>
                           <button class='cancel-button' onclick='cancelBooking(\"%s\")'>Cancel Booking</button>
                           </div> 
                       </div>
                               ",$i,$i,$row->EventType,$row->EventDateStart,$row->EventVenue,($row->ticketPrice * $row->ticketNumber),$row->EventImage,$i,$row->ticketID,$row->EventType,$row->EventDateStart,$row->EventVenue,$row->ticketPrice,$file, $row->ticketID);
                                   
                     $i++;
                 }
                    
                }else{
                    echo 'You Have No Ticket';
                }
                $ticketresult->free();
                 $con ->close();
    ?>
    </div>
 </div>      
    <?php
        include './general/footer.php';
    ?>    
    <script>
function displayTickets(num) {
      let ticketElement = document.getElementById("ticket"+ num);
      let ticketDetails = document.getElementById("ticket-details"+num);
      
    if(ticketDetails.style.display == "block"){
        ticketDetails.style.display = "none";
    }else{
        ticketDetails.style.display = "block";
    }
}

function cancelBooking(ticketId) {
    const confirmed = confirm("Are you sure you want to cancel this booking?");
    if (confirmed) {
        const ticketID = ticketId;
        window.location.href = "deleteticket.php?ticketID=" + encodeURIComponent(ticketID);
      alert(`Booking for ticket with ID `+ticketId+` cancelled.`);
    }
}
</script>
</body>
</html>
