<?php

require_once '../model/Event.php';
include '../tratamentoDeExcecao/ValidaCadastro.php';

/**
*
* Class responsible for event registration
*
**/

session_start();


$eventName = $_POST['eventName']; // Receives the event eventName to be created
$eventBeginDate = $_POST['eventBeginDate']; // Receives the starting date of the event
$eventEndDate= $_POST['endDate']; // Receives the end date of the event
$masculineEventPrice = $_POST['masculineEventPrice']; // Male price
$femaleEventPrice= $_POST['emaleEventPrice']; // Women price
$facebookEventPage = $_POST['facebookEventPage']; // Receives the link facebook page of the event
$eventDescription = $_POST['eventDescription']; // Receives eventDescription of the event
$numberOfTickets = $_POST['numberOfTickets']; // Amount of avaible tickets
$beginHour = $_POST['beginHour']; // Receives the start hour of the event
$startMinute = $_POST['startMinute']; // Receives the start minute of the event
$endMinute = $_POST['endMinute']; // Receives the end hour of the event
$endHour = $_POST['endHour']; // Receives the end minute of the event
$idOrganizer = $_SESSION['idOrganizer']; // Organizer registration code
$ageClassification = $_POST['ageClassification']; // Age rating of the event
$event = new Event(); // Varible that receives event's data

require_once 'eventUploadImage.php';

$event->setEventName($eventName);
$event->setEventBeginDate($eventBeginDate);
$event->setEndDate($endDate);
$event->setBeginHour($beginHour . ":" . $startMinute);
$event->setEndHour($endHour . ":" . $endMinute);
$event->setNumberOfTickets($numberOfTickets);
$event->setEventOrganizer("1");
$event->setFemaleEventPrice($emaleEventPrice);
$event->setMasculineEventPrice($masculineEventPrice);
$event->setFacebookEventPage($facebookEventPage);
$event->setEventDescription($eventDescription);
$event->setIdOrganizer($idOrganizer);
$event->setAgeClassification($ageClassification);

$validator = new ValidaCadastro(); // Variable responsible to validate
$validator->validarCampo("eventName", $eventName);
$validator->checkData($eventBeginDate);
$validator->checkData($endDate);
$validator->checktime($beginHour, $startMinute);
$validator->checktime($endHour, $endMinute);
$validator->validarPreco($masculineEventPrice);
$validator->validarPreco($femaleEventPrice);
$validator->validarVaga($numberOfTickets);

$_SESSION['id'] = $event->insertEvent();
header("Location:../localRegistrationProcess.php");
?>
