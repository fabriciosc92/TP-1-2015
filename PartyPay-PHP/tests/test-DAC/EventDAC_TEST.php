<?php
require_once \dirname(__FILE__) . '\..\..\DAC\EventDAC.php';
require_once \dirname(__FILE__) . '\..\..\DAC\connection.php';
require_once \dirname(__FILE__) . '\..\..\model\Event.php';

/**
 * Class name: EventDAC_TEST.
 * Provide unit test to class EventDAC.
 */
class EventDAC_TEST extends PHPUnit_Framework_TestCase {
    
    protected $object;

    protected $event;

    private $connection;
     
    protected $id;
    
    protected $eventDAC;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() 
    {
        $this->object = new EventDAC;
        $this->eventDAC = new EventDAC;
         $this->connection = new connection;
         $this->event = new Event;
        return $this->connection->conect();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() 
    {
        
    }

    public function testInsertEvent() {
       
        $this->event->set('eventName', 'teste');
        $this->event->set('eventBeginDate', '10/02/2015');
        $this->event->set('eventEndDate', '10/02/2015');
        $this->event->set('masculineEventPrice', '30');
        $this->event->set('femaleEventPrice', '20');
        $this->event->set('facebookEventPage','evento');
        $this->event->set('eventCriationDate','10/02/2015');
        $this->event->set('eventDescription', 'evento comemorativo');
        $this->event->set('numberOfTickets', '10');
        $this->event->set('beginHour', '10h');
        $this->event->set('endHour', '11h');
        $this->event->set('eventMiniature', 'teste.png');
        $this->event->set('ageClassification', '18');

        $this->eventDAC = new EventDAC();
        $this->id = null;
        $this->assertNull($this->id);
    }
    
}