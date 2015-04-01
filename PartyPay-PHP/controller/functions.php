<?php
// Class of functions

require_once 'model/Evento.php';

// Function that receives the name of the event
function the_nome($id) 
{
    $evento = new Evento;
    $evento->eventoPorId($id);
    echo $evento->getNome();
}

// Function that receives the thumbnail of the image event
function the_miniatura($id) 
{
    $eventod = new Evento;
    $eventod->eventoPorId($id);
    echo $eventod->getMiniatura();
}

// Function that receives the description of the event
function the_descricao($id) 
{
    $event = new Evento;
    $event->eventoPorId($id);
    echo $event->getDescricao();
}

// Function that receives the image of the event
function the_imagem($id) 
{
    $evento = new Evento;
    $evento->eventoPorId($id);
    echo $evento->getImagem();
}

// Function that returns the last registered event
function ultimoEvento() 
{
    $mysqli = new mysqli("localhost", "root", "", "payparty");
    $result = $mysqli->query("SELECT MAX(id) FROM eventos");
    $row = $result->fetch_array(MYSQLI_NUM);
    return $row[0];
}

?>
