<?php

require_once 'DAC/LocalDAC.php';

/**
 * Class name: Local
 * Class responsible to define model elements in local.
*/
 
class Local 
{

    private $eventAddress; // Keeps the address of the event.
    private $addressNumber; // Store the address number
    private $addressComplement; // Address complement
    private $eventNeighborhood; // Store the neighborhood.
    private $eventCity; // Event city.
    private $localCep; // localCep of the local of the event.
    private $eventCountry; // Countrt where the event is happening.
    private $googleMapsCoordanate; // Coordanate of the event in the google maps.
    private $eventLocalPictures; // Pictures of the local of the event.
    private $id; // Local id in database.
    private $eventLocalName; // Name of the place of the event.
    private $eventState; // Estate of the place of the event.
    private $localMiniature; // Local Miniature

    // Access variable localMiniature.
    public function getLocalMiniature() 
    {
        return $this->localMiniature;
    }

    // Modify variable localMiniature.
    public function setLocalMiniature($localMiniature) 
    {
        $this->localMiniature = $localMiniature;
    }

    // Access variable eventState
    public function getEventState() 
    {
        return $this->eventState;
    }

    // Modify variable eventState.
    public function setEventState($eventState) 
    {
        $this->eventState = $eventState;
    }

    function __construct() 
    {
        
    }

    // Access variable addressNumber.
    public function getAddressNumber() 
    {
        return $this->addressNumber;
    }

    // Modify variable addressNumber.
    public function setAddressNumber($addressNumber) 
    {
        $this->addressNumber = $addressNumber;
    }

    // Access variable addressComplement.
    public function getAddressComplement() 
    {
        return $this->addressComplement;
    }

    // Modify variable addressComplement.
    public function setAddressComplement($addressComplement) 
    {
        $this->addressComplement = $addressComplement;
    }

    // Access variable eventNeighborhood.
    public function getEventNeighborhood() 
    {
        return $this->eventNeighborhood;
    }

    // Modify variable eventNeighborhood.
    public function setEventNeighborhood($eventNeighborhood) 
    {
        $this->eventNeighborhood = $eventNeighborhood;
    }

    // Access variable eventCity.
    public function getEventCity() 
    {
        return $this->eventCity;
    }

    // Modify variable eventCity.
    public function setEventCity($eventCity) 
    {
        $this->eventCity = $eventCity;
    }

    // Access variable localCep.
    public function getLocalCep() 
    {
        return $this->localCep;
    }

    // Modify variable localCep.
    public function setLocalCep($localCep) 
    {
        $this->localCep = $localCep;
    }

    // Access variable eventCountry.
    public function getEventCountry() 
    {
        return $this->eventCountry;
    }

    // Modify variable eventCountry.
    public function setEventCountry($eventCountry) 
    {
        $this->eventCountry = $eventCountry;
    }

    // Access variable eventLocalName.
    public function getEventLocalName() 
    {
        return $this->eventLocalName;
    }

    // Modify variable eventLocalName.
    public function setEventLocalName($eventLocalName) 
    {
        $this->eventLocalName = $eventLocalName;
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

    // Access variable eventAddress.
    public function getEventAddress() 
    {
        return $this->endereço;
    }

    // Modify variable eventAddress.
    public function setEventAddress($eventAddress) 
    {
        $this->endereço = $eventAddress;
    }

    // Access variable googleMapsCoordanate.
    public function getGoogleMapsCoordanate() 
    {
        return $this->googleMapsCoordanate;
    }

    // Modify variable coordenadaGooleMaps.
    public function setGoogleMapsCoordanate($googleMapsCoordanate) 
    {
        $this->googleMapsCoordanate = $googleMapsCoordanate;
    }
    

    // Access variable eventLocalPictures.
    public function getEventLocalPictures() 
    {
        return $this->eventLocalPictures;
    }

    // Modify variable eventLocalPictures.
    public function setEventLocalPictures($eventLocalPictures) 
    {
        $this->eventLocalPictures = $eventLocalPictures;
    }

    // Inserts a local in database.
    public function insertLocal() 
    {
        return LocalDAC::insertLocal($this);
    }

    // Update changes in local information.
    public function updateLocalInformation($atributo, $novoValor) 
    {
        LocalDAC::updateLocalInformation($this, $atributo, $novoValor);
    }

    // deleteLocal a local in database.
    public function deleteLocal() 
    {
        LocalDAC::deleteLocal($this);
    }
    
}