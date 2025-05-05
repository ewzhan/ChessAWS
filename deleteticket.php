<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
define("DB_HOST", "php-db.cgghs0khunws.us-east-1.rds.amazonaws.com");
define("DB_USER", "admin");
define("DB_PASS", "asspassword");
define("DB_NAME", "chess");
if (isset($_GET['ticketID'])) {
    
    $ticketID = $_GET['ticketID'];
                //Step 1: create connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
            //Step 2: sql statement
            $sql = "DELETE FROM ticket WHERE ticketID = ?";
                
             //Step 3: process sql
            $stmt = $con->prepare($sql);
            
             //Step 3.1 pass in value into sql parameter 
            $stmt->bind_param("s", $ticketID);
            
             //Step 3.2 execute process
            $stmt->execute();
            
            
            $con->close();
            $stmt->close();
      echo'<script>window.location.href = "ticket.php";</script>';
}
?>
    </body>
</html>
