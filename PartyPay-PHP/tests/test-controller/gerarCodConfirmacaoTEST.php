<?php

require_once '../../controller/generateConfirmationCode.php';

/**
 * Class name: GerarCodConfirmacaoTEST.
 * Tests class GerarCodConfirmacao.
**/

class GenerateConfirmationCodeTEST extends PHPUnit_Framework_TestCase 
{
    public $test;
    
    public function setUp()
    {
    	$this->test = new generateConfirmationCode();
    }
    
	// Unit test the code generation.
    public function testGenerateCodConfirmation() 
    {
        $code = generateCodConfirmation();
        $this->assertTrue($code == !Null);
    }
}