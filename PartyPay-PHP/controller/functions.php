<?php

/**
*
* Class of application functions
*
**/

require_once 'model/Evento.php';

// Function that receives the name of the event
function event_name($id) 
{
    $eventName = new Evento; // Variable to receive Events name data
    $eventName->eventoPorId($id);
    echo $eventName->getNome();
}

// Function that receives the thumbnail of the image event
function event_thumb($id) 
{
    $eventThumb = new Evento; // Variable to receive thumbnail event data
    $eventThumb->eventoPorId($id);
    echo $eventThumb->getMiniatura();
}

// Function that receives the description of the event
function event_description($id) 
{
    $eventDescription = new Evento; // Variable to receive description event data
    $eventDescription->eventoPorId($id);
    echo $eventDescription->getDescricao();
}

// Function that receives the image of the event
function the_image($id) 
{
    $eventImage = new Evento; // Variable to receive image event data
    $eventImage->eventoPorId($id);
    echo $eventImage->getImagem();
}

// Function that returns the last registered event
function lastEvent() 
{
    $mysqli = new mysqli("localhost", "root", "", "payparty");
    $result = $mysqli->query("SELECT MAX(id) FROM eventos");
    $row = $result->fetch_array(MYSQLI_NUM);
    return $row[0];
}

?>
