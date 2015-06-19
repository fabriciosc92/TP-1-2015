<?php

/**
 * File name: event
 * Page responsible to show the event information
**/

require_once ('header.php');

if (isset($event)) {
	
    unset($event);
	
}

$event = new Event();

$eventId = $_GET['id'];
$event->eventById($eventId);

$eventName = $event->getEventName();
$eventBeginDate = $event->getEventBeginDate();
$eventEndDate = $event->getEventEndDate();
$eventImage = $event->getEventImage();
$masculineEventPrice = $event->getMasculineEventPrice();
$femaleEventPrice = $event->getFemaleEventPrice();
$eventPromoter = $event->getEventPromoter();
$facebookEventPage = $event->getFacebookEventPage();
$eventCreationDate = $event->getEventCriationDate();
$eventDescription = $event->getEventDescription();
$numberOfTickets = $event->getNumberOfTickets();
$beginHour = $event->getBeginHour();
$endHour = $event->getEndHour();
$eventMiniature = $event->getEventMiniature();
$ageClassification = $event->getAgeClassification();

?>

<div class="container">
    <h1><?php echo $eventName; ?></h1>
    <div class="row">
        <div class="span8 conteudo">
            <img src="<?php echo $image; ?>" alt="">
            <p><?php echo $description; ?></p>

        </div>
        <div class="span4">
            <div class="data well">
                <h4>Data</h4>
                <span class="horario">
					<?php
						echo ("De " . $startingDate . " at&eacute; " . $endingDate); 
					?>
				</span>
            </div>
            <div class="Local well">
                <h4>Local</h4>
                <p><span>Hub Sao Paulo(Bela Cintra)</span>
                    <br>Rua Bela Cintra, 409 - Consolação, Sao Paulo - São Paulo, 01415-000, Brazil<br>
                    <a class="btn btn-mini" href="http://maps.google.com/maps?q=Rua Bela Cintra, 409 - Consolação, Sao Paulo - São Paulo, 01415-000, Brazil" target="_blank" style="font-size: 11px;"><i class="icon-map-marker"></i>Ver no mapa</a>
                </p>
            </div>
            <div class="comprar well">
                <a href="" class="btn btn-large btn-success">Comprar ingresso</a>
            </div>
        </div>
    </div>
</div>

<?php

require_once ('footer.php');

?>