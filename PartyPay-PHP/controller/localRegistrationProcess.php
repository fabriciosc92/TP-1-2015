<?php

require_once '../model/Local.php';
require_once '../model/DAC/EventoLocalDAC.php' 
	or log.it("Could not include EventoLocalDAC file");

/**
*
* Class responsible for local registration
*
**/

session_start();
$address = $_POST['address']; // Receives the address of the event
//$coordenadaGoogleMaps = $_POST['coordenadas'];
//$foto=
$name = $_POST['name']; // Receives the name of the event address
$number = $_POST['number']; // Receives the number of the event address
$complement = $_POST['complement']; // Receives the complement of the event address
$district = $_POST['district']; // Receives the district of the event address
$city = $_POST['city']; // Receives the city of the event address
$zipCode = $_POST["zipCode"]; // Receives the zip code of the event address
$country = $_POST['country']; // Receives the country of the event address
$state = $_POST['state']; // Receives the state of the event address
$idEvento = $_SESSION['eventoid']; // Event identifier

$strList = "\\\'\"&\n\r<>\b";
addcslashes($address, $strList);
addcslashes($name, $strList);
addcslashes($number, $strList);
addcslashes($complement, $strList);
addcslashes($district, $strList);
addcslashes($city, $strList);
addcslashes($city, $strList);
addcslashes($country, $strList);
addcslashes($state, $strList);

$local = new Local(); // Variable that receives local data

require_once "localUploadImage.php";

$local->setDistrict($district);
$local->setZipCode($zipCode);
$local->setCity($city);
$local->setComplement($complement);
$local->setAddress($address);
$local->setName($name);
$local->setNumber($number);
$local->setCountry($country);
$local->setState($state);

$idLocal = $local->persist(); // Local identifier

// Responsible for linking the event to the local
EventoLocal::persist($idEvento, $idLocal);

log_it('PHP: Registration not completed');
echo "cadastro efetuado";

header("Location: ../Event.php?id=$idEvento");
?>
