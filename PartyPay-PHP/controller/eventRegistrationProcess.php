<?php

require_once '../model/Evento.php';
include '../tratamentoDeExcecao/ValidaCadastro.php';

/**
*
* Class responsible for event registration
*
**/

session_start();


$name = $_POST['name']; // Receives the event name to be created
$startDate = $_POST['startDate']; // Receives the starting date of the event
$endDate = $_POST['endDate']; // Receives the end date of the event
$malePrice = $_POST['malePrice']; // Male price
$womenPrice = $_POST['womenPrice']; // Women price
$facebookEventPage = $_POST['facebookEventPage']; // Receives the link facebook page of the event
$description = $_POST['description']; // Receives description of the event
$numberTickets = $_POST['numberTickets']; // Amount of avaible tickets
$startHour = $_POST['startHour']; // Receives the start hour of the event
$startMinute = $_POST['startMinute']; // Receives the start minute of the event
$endMinute = $_POST['endMinute']; // Receives the end hour of the event
$endHour = $_POST['endHour']; // Receives the end minute of the event
$organizerId = $_SESSION['id']; // Organizer registration code
$ageRating = $_POST['ageRating']; // Age rating of the event
$event = new Evento(); // Varible that receives event's data

require_once 'recebe_upload_evento.php';

$event->setName($name);
$event->setStartDate($startDate);
$event->setEndDate($endDate);
$event->setStartHour($startHour . ":" . $startMinute);
$event->setEndHour($endHour . ":" . $endMinute);
$event->setNumberTickets($numberTickets);
$event->setOrganizador("1");
$event->setWomenPrice($womenPrice);
$event->setMalePrice($malePrice);
$event->setFacebookEventPage($facebookEventPage);
$event->setDescription($description);
$event->setOrganizador($organizerId);
$event->setAgeRating($ageRating);

$validator = new ValidaCadastro(); // Variable responsible to validate
$validator->validarCampo("Name", $name);
$validator->checkData($startDate);
$validator->checkData($endDate);
$validator->checktime($startHour, $startMinute);
$validator->checktime($endHour, $endMinute);
$validator->validarPreco($malePrice);
$validator->validarPreco($womenPrice);
$validator->validarVaga($numberTickets);

$_SESSION['eventid'] = $event->persist();
header("Location:../cadastrar-evento-local.php");
?>
