<?php
function checkEventName($eventName){
    if($eventName == NULL){
        return "Please enter you <b>EVENT NAME</b>";
    }else if(strlen($eventName) > 40){
        return "Your <b>EVENT NAME</b> is too long!";
    }
}

function checkEventType($eventType){
    $type = array("Tournament" => 1, "Class" => 2,"Camp" => 3);
    if($eventType == NULL){
        return "Please select your <b>EVENT TYPE</b>";
    }else if(!array_key_exists($eventType, $type)){
        return "Invalid <b>EVENT TYPE</b> selected!";
    }
}

function checkEventVenue($eventVenue){
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $sql = "SELECT venueName FROM venue";
    $result = $con ->query($sql);
    if($result -> num_rows > 0){
        $count = 0;
        while($row = $result ->fetch_object()){
            $venueName = trim($row->venueName);
            $venue[$count] = $venueName;
            $count++;
        }
    }
  
    if($eventVenue == NULL){
        return "Please select the <b>VENUE</b>";
    }else if(!in_array($eventVenue, $venue)){
        return "Invalid <b>VENUE</b>";
    }
}

function checkEventDate($eventDate){
    if($eventDate == NULL){
        return "Please select the <b>EVENT DATE</b>";
    }
}

function checkEventTimeStart($timeStart){
    if($timeStart == NULL){
        return "Please select the <b>STARTED TIME</b>";
    }else{
       global $eventTimeStart;
       $eventTimeStart = $timeStart;
    }
}
function checkEventTimeEnd($timeEnd){
    if($timeEnd == NULL){
        return "Please select the <b>ENDED TIME</b>";
    }else if(isset($eventTimeStart)){
        if($timeEnd < $eventTimeStart){
            return "The <b>ENDED TIME</b> must late then started time";
        }
    }
}

function checkEventFee($fee){
    if($fee == NULL){
        return "Please enter the <b>FEE</b>";
    }else if($fee > 1000){
        return "The <b>FEE</b> is too high!";
    }else if($fee < -1){
        return "The mininum <b>FEE</b> is 0";
    }
}

function checkEventPrice($price){
    if($price == NULL){
        return "Please enter the <b>PRICE</b>";
    }else if($price < -1){
        return "The mininum <b>PRICE</b> is 0";
    }
}

function checkCardName($cardName){
    if($cardName == NULL){
        return "Please enter the <b>CARD HOLDER'S NAME</b>";
    }
}

function checkCardNum($cardNum){
    if($cardNum == NULL){
        return "Please enter the <b>CARD NUMBER</b>";
    }else if(!preg_match("/^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/", $cardNum)){
        return "Invalid <b>CARD NUMBER</b>";
    }
}

function checkCardExpiry($expiry){
    if($expiry == NULL){
        return "Please select the <b>CARD EXPIRY DATE</b>";
    }
}

function checkCardCvc($cvc){
    if($cvc == NULL){
        return "Please enter the <b>CARD CVC / CVV</b>";
    }else if(!preg_match("/^[0-9]{3}$/", $cvc)){
        return "Invalid <b>CARD CVC / CVV</b>";
    }
}

function checkaddress($venueAddress){
    if ($venueAddress == NULL) {
        return "Venue Address cannot be left empty";
    }
}

function checkname($venueName){
    if ($venueName == NULL) {
        return "Venue Name cannot be left empty";
    }
}


function checksameID($venueID){
    $found = false;
    
    //Step 1: create connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    //Step 1.1 clean $id, remove special character, prevent
    //sql error when exexuting sql code
    
    
    //Step 2: sql statement
     $sql ="SELECT * FROM venue WHERE venueID = '$venueID'";
     
     //Step 3.process sql
     $result = $con->query($sql);
     
     if($result->num_rows >0){
         //result found -> SAME STUDENT ID DETECTED
         $found = true;
     }else{
         //no result found -> NO PROBLEM
     }
     $result->free(); //release memory usage
     $con->close();
     
     return $found;
}

function checkID($venueID){
    if ($venueID == NULL) {
        return"Venue ID cannot be left empty";
    }else if (checksameID($venueID)) {
        return "Existed ID, Please pick a new one";
    }
}

function checkClosingDate($date){
    if($date == NULL){
        return "Please select the <b>CLOSING DATE</b>";
    }
}

function checkCategories($categories){
    if($categories == NULL){
        return "Please select the <b>AGE CATEGORIES</b>";
    }
}