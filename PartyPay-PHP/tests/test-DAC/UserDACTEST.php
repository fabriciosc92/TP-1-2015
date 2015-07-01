<?php

require_once \dirname(__FILE__) . '\..\..\DAC\UserDAC.php';
require_once \dirname(__FILE__) .'\..\..\DAC\connection.php';
require_once \dirname(__FILE__) . '\..\..\model\User.php';

/**
 * Class name: UserDACTEST.
 * Unit test class UserDAC.
 */
class UserDACTEST extends PHPUnit_Framework_TestCase 
{
	protected $user;
    
    private $connection;
     
    protected $id;
    
    protected $UserDAC;

    protected function setUp() 
    {
       
        $this->user = new User();
        $this->userDAC = new UserDAC;
        
        $this->getConnection();     
    }

     protected function tearDown() 
     {
       
     $this->id = mysql_insert_id();
    
    }

     public function getConnection()
     {
       
        $this->connection = new Connection;
        
        return $this->connction->conect();
    }

    public function testInsertUserDAC() 
    {

        $userDAC = new UserDAC();
        
        $this->id = $userDAC->insertUser($this->user);
        $this->assertNull($this->id);
      
    }

}
