<?php

require_once '../../controller/gerarCodConfirmacao.php';

/**
 * Class name: GerarCodConfirmacaoTEST.
 * Tests class GerarCodConfirmacao.
**/

class GerarCodConfirmacaoTEST extends PHPUnit_Framework_TestCase 
{
    public $test;
    
	// Unit test the code generation.
    public function testaGeracaoDeCodigo() 
    {
        $codigo = gerarCodigoConfirmaçao();
        $this->assertTrue($codigo == !Null);
    }
}