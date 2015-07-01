<?php

require_once '../../DAC/connection.php';

class ConnectionTEST extends PHPUnit_Framework_TestCase
{
	public  $object;
	public $connection;
	
	public function setUp() {
		$this->object = new Connection;
		$this->object->set('server', 'localhost');
		$this->object->set('user', 'root');
		$this->object->set('password', '');
		$this->object->set('db', 'payparty');
		$this->connection = mysql_connect('localhost', 'root', '', 'payparty');
		$this->object->connection();
	}
	
	public function tearDown() {
	
	}
	
	public function testConnection() {
		
		$this->assertNotEquals(0, $this->object->connection());
	}
	
	public function testSet() {
		
		$this->object->set('password', '');
	}
}