<?php

require_once '../../controller/gerarCodConfirmacao.php';

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