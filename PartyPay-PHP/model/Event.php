<?php

require_once 'DAC/EventDAC.php';

/**
 * Class name: Event
 * Class responsible to define model elements in events.
 */
class Event
{

    private $eventName; // Store the name of the event.
    private $eventCriationDate; // Keeps date when the event was created.
    private $eventBeginDate; // Date when the event begun.
    private $eventEndDate; // Date when the event is over.
    private $eventImage; //input do tipo file name arquivo
    private $masculineEventPrice; // Price that a man has to pay for the event. In Real.
    private $femaleEventPrice; // Price that a woman has to pay for the event. In Real.
    private $eventPromoter; // Store the person that is organizing the event.
    private $eventLocal; // Local where the event is happening.
    private $facebookEventPage; // Keeps the linking to the facebook page of the event.
    private $eventDescription; // Description of the event.
    private $numberOfTickets; // Number of tickets avaible in the event.
    private $beginHour; // Begin time of the event.
    private $endHour; // Event end time.
    private $eventMiniature; // Miniature of the event.
    private $ageClassification; // Minimum age to enter in the event.
    private $id; // Database id of the event.

    // Access variable ageClassification.
    public function getAgeClassification() 
    {
        return $this->ageClassification;
    }

    // Modify variable ageClassification.
    public function setAgeClassification($ageClassification) 
    {
        $this->ageClassification = $ageClassification;
    }

    // Access variable id.
    public function getId() 
    {
        return $this->id;
    }

    // Modify variable id.
    public function setId($id) 
    {
        $this->id = $id;
    }

    // Access variable eventMiniature.
    public function getEventMiniature() 
    {
        return $this->eventMiniature;
    }

    // Modify variable eventMiniature.
    public function setEventMiniature($eventMiniature) 
    {
        $this->eventMiniature = $eventMiniature;
    }

    // Access variable beginHour.
    public function getBeginHour() 
    {
        return $this->beginHour;
    }

    // Modify variable beginHour.
    public function setBeginHour($beginHour) 
    {
        $this->beginHour = $beginHour;
    }

    // Access variable endHour.
    public function getEndHour() 
    {
        return $this->endHour;
    }

    // Modify variable endHour.
    public function setEndHour($endHour) 
    {
        $this->endHour = $endHour;
    }

    function __construct() 
    {
        
    }

    // Access variable numberOfTickets.
    public function getNumberOfTickets() 
    {
        return $this->numberOfTickets;
    }

    // Modify variable numberOfTickets.
    public function setNumberOfTickets($numberOfTickets) 
    {
        $this->numberOfTickets = $numberOfTickets;
    }

    // Access variable eventCriationDate.
    public function getEventCriationDate() 
    {
        return $this->eventCriationDate;
    }

    // Modify variable eventCriationDate.
    public function setEventCriationDate($eventCriationDate) 
    {
        $this->eventCriationDate = $eventCriationDate;
    }


    // Access variable eventImage.
    public function getEventImage() 
    {
        return $this->eventImage;
    }

    // Modify variable eventImage.
    public function setEventImage($eventImage) 
    {
        $this->eventImage = $eventImage;
    }

    // Access variable eventDescription.
    public function getEventDescription() 
    {
        return $this->eventDescription;
    }

    // Modify variable eventDescription.
    public function setEventDescription($eventDescription) 
    {
        $this->eventDescription = $eventDescription;
    }

    // Access variable facebookEventPage.
    public function getFacebookEventPage() 
    {
        return $this->facebookEventPage;
    }

    // Modify variable facebookEventPage.
    public function setFacebookEventPage($facebookEventPage) 
    {
        $this->facebookEventPage = $facebookEventPage;
    }

    // Access variable eventName.
    public function getEventName() 
    {
        return $this->eventName;
    }

    // Modify variable eventName.
    public function setEventName($eventName) 
    {
        $this->eventName = $eventName;
    }

    // Access variable eventBeginDate.
    public function getEventBeginDate() 
    {
        return $this->eventBeginDate;
    }

    // Modify variable eventBeginDate.
    public function setEventBeginDate($eventBeginDate) 
    {
        $this->eventBeginDate = $eventBeginDate;
    }

    // Access variable eventEndDate.
    public function getEventEndDate() 
    {
        return $this->eventEndDate;
    }

    // Modify variable eventEndDate.
    public function setEventEndDate($eventEndDate) 
    {
        $this->eventEndDate = $eventEndDate;
    }

    // Access variable masculineEventPrice.
    public function getMasculineEventPrice() 
    {
        return $this->masculineEventPrice;
    }

    // Modify variable masculineEventPrice.
    public function setMasculineEventPrice($masculineEventPrice) 
    {
        $this->masculineEventPrice = $masculineEventPrice;
    }

    // Access variable femaleEventPrice.
    public function getFemaleEventPrice() 
    {
        return $this->femaleEventPrice;
    }

    // Modify variable femaleEventPrice.
    public function setFemaleEventPrice($femaleEventPrice) 
    {
        $this->femaleEventPrice = $femaleEventPrice;
    }

    // Access variable eventPromoter.
    public function getEventOrganizer() 
    {
        return $this->eventPromoter;
    }

    // Modify variable eventPromoter.
    public function setEventPromoter($eventPromoter) 
    {
        $this->eventPomoter = $eventPromoter;
    }

    // Access variable eventLocal.
    public function getEventLocal() 
    {
        return $this->eventLocal;
    }

    // Modify variable eventLocal.
    public function setEventLocal($eventLocal) 
    {
        $this->eventLocal = $eventLocal;
    }

    // Inserts an event in database.
    public function insertEvent() 
    {
        return EventDAC::insertEvent($this);
    }

    // Update informations that are modify in database.
    public function updateInformationEvent($atributo, $novoValor) 
    {
        EventDAC::updateInformationEvent($this, $atributo, $novoValor);
    }

    // deleteEvents an event in database. 
    public function deleteEvent() 
    {
        EventDAC::deleteEvent($this);
    }

    // Recovery an event.
    public function eventByid($id)
    {
        EventDAC::recoveryEventDAC($this, $id);
    }

}