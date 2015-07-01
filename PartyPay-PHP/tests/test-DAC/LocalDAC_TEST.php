<?php
require_once \dirname(__FILE__) . '\..\..\DAC\LocalDAC.php';
require_once \dirname(__FILE__) . '\..\..\DAC\connection.php';
require_once \dirname(__FILE__) . '\..\..\model\Local.php';

/**
 * Class name: localDAC_TEST.
 * Provide unit test to class localDAC.
 */
class localDAC_TEST extends PHPUnit_Framework_TestCase {
    
    protected $object;

    protected $local;

    private $connection;
     
    protected $id;
    
    protected $localDAC;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() 
    {
        $this->object = new localDAC;
        $this->localDAC = new localDAC;
         $this->connection = new connection;
         $this->local = new local;
        return $this->connection->conect();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() 
    {
        
    }
   
    public function testInsertLocal() {
       
        $this->local->set('localName', 'teste');
        $this->local->set('localBeginDate', '10/02/2015');
        $this->local->set('localEndDate', '10/02/2015');
        $this->local->set('masculinelocalPrice', '30');
        $this->local->set('femalelocalPrice', '20');
        $this->local->set('facebooklocalPage','localo');
        $this->local->set('localCriationDate','10/02/2015');
        $this->local->set('localDescription', 'localo comemorativo');
        $this->local->set('numberOfTickets', '10');
        $this->local->set('beginHour', '10h');
        $this->local->set('endHour', '11h');
        $this->local->set('localMiniature', 'teste.png');
        $this->local->set('ageClassification', '18');

        $this->localDAC = new LocalDAC();
        $this->id = null;
        $this->assertNull($this->id);
    }
    
}