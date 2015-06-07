<?php

/**
* Class for application functions.
**/

require_once 'model/Event.php';

// Function that receives the name of the event
function event_name($id) 
{
    $eventName = new Event; // Variable to receive Events name data
    $eventName->eventByid($id);
    echo $eventName->getEventName();
}

// Function that receives the thumbnail of the image event
function event_thumb($id) 
{
    $eventThumb = new Event; // Variable to receive thumbnail event data
    $eventThumb->eventByid($id);
    echo $eventThumb->getEventMiniature();
}

// Function that receives the description of the event
function event_description($id) 
{
    $eventDescription = new Event; // Variable to receive description event data
    $eventDescription->eventByid($id);
    echo $eventDescription->getEventDescription();
}

// Function that receives the image of the event
function event_image($id) 
{
    $eventImage = new Event; // Variable to receive image event data
    $eventImage->eventByid($id);
    echo $eventImage->getEventImage();
}

// Function that returns the last registered event
function lastEvent() 
{
    $mysqli = new mysqli("localhost", "root", "", "payparty");
    $result = $mysqli->query("SELECT MAX(id) FROM eventos");
    $row = $result->fetch_array(MYSQLI_NUM);
    return $row[0];
}

function log_it($error_message)
{
    error_log($error_message, 3, "\\PartyPay-PHP\php_error.log");
}

?>
