<?php

include '../../model/Pessoa.php';

/**
 * Class name: ProcessaEditaPessoaTEST.
 * Tests function in class ProcessaEditaPessoa.
 */

class ProcessaEditaPessoaTEST extends PHPUnit_Framework_TestCase 
{
    public $test;

    // Signal the start of the test process, creating a new person.
    public function setUp() 
    {
        $this->test = new Pessoa();
    }

    // Unit test for the function Persist in the class Pessoa. Editing a person.
    public function testFuncaoPersist() 
    {
        $this->test->setPrimeiroNome("Nometeste");
        $this->test->setSobreNome("Sobrenometeste");
        $this->test->setCpf("111.111.111-11");
        $this->test->setTelefoneContato("(22) 2222-2222");
        $resultadoTEST = $this->test->persist();
        $this->assertTrue($resultadoTEST == !Null);
    }
}