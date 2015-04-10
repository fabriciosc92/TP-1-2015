<?php

include '../../model/Local.php';

/**
 * Class name: ProcessaCadastroLocalTest.
 * Tests function in class ProcessaCadastroLocal.
 */

class ProcessaCadastroLocalTEST extends PHPUnit_Framework_TestCase 
{
    public $test;

    // Signal the start of the test process, creating a new local.
    public function setUp() 
    {
        $this->test = new Local();
    }

    // Unit test for the function Persist in the class Local. Registering a new local.
    public function testFuncaoPersist() 
    {
        $this->test->setBairro("Oeste");
        $this->test->setCep("724250000");
        $this->test->setCidade("Gama");
        $this->test->setComplemento("Apartamento 201");
        $this->test->setEndereco("Quadra A");
        $this->test->setNome("Fazenda");
        $this->test->setPais("Brasil");
		$this->test->setEstado("Distrito Federal");
        $resultadoTEST = $this->test->persist();
        $this->assertTrue($resultadoTEST == !Null);
    }
}