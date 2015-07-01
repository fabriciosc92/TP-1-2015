<?php

include '../../model/Pessoa.php';

/**
 * Class name: ProcessaEditaPessoaTEST.
 * Tests function in class ProcessaEditaPessoa.
**/

class ProcessaEditaPessoaTEST extends PHPUnit_Framework_TestCase 
{
    public $test;

    // Signal the start of the test process, creating a new person.
    public function setUp() 
    {
        $this->test = new User();
    }

    // Unit test for the function Persist in the class User. Editing a person.
    public function testFunctionInsertUser() 
    {
        $this->test->setUserFirstName("Nometeste");
        $this->test->setUserLastName("Sobrenometeste");
        $this->test->setUserCpf("111.111.111-11");
        $this->test->setUserPhone("(22) 2222-2222");
        $resultTEST = $this->test->insertUser();
        $this->assertTrue($resultTEST == !Null);
    }
}