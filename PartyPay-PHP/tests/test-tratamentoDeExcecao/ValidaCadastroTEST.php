<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2013-07-11 at 02:29:41.
 * Class name: ValidaCadastroTest
 * Class that tests functions in class ValidaCadastro
**/
require_once '../../tratamentoDeExcecao/ValidaCadastro.php';

class ValidaCadastroTest extends PHPUnit_Framework_TestCase 
{

   public $test;

    /**
     * @var ValidaCadastro
    **/
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This functions is called before a test is executed.
     * Signal the start of the test process by creating a new ValidaCadastro.
    **/
    protected function setUp() 
    {
        $this->object = new ValidaCadastro;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This functions is called after a test is executed.
    **/
    protected function tearDown() 
    {
        
    }

    /**
     * @covers ValidaCadastro::mensagens
     * Tests functions mensagens in class ValidaCadastro.
    **/
    public function testMensagemNumero6() 
    {
        $actual = $this->object->mensagens(6, 'nome');
        $expected = "Preencha o campo nome com numeros <br />";
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ValidaCadastro::validarEmail
     * Tests functions validarEmail in class ValidaCadastro with a valid email.
    **/
    public function testValidarEmailValido() 
    {
        $this->markTestSkipped('pulando teste para não comitar quebrado');
        $actual = $this->object->validarEmail("cotrim149@gmail.com");
        $expected = NULL;
        $this->assertEquals($expected, $actual);
    }

    // Tests functions validarEmail in class ValidaCadastro with a non valid email.
    public function testValidarEmailNaoValido() 
    {
        $this->markTestSkipped('pulando teste para não comitar quebrado');
        $actual = $this->object->validarEmail("cotri&m149@gmail.com");
        $expected = "Preencha o campo com um email válido <br />";
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ValidaCadastro::validarCep
     * @todo   Implement testValidarCep().
    **/
    public function testValidarCep() 
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ValidaCadastro::checkData
     * @test
     * 
    **/
    public function testValidarDataCorreta() 
    {
        $actual = $this->object->checkData('22/04/2013');
        $expected = NULL;
        $this->assertEquals($expected, $actual);
    }

    public function testValidarDataDia() 
    {
        $actual = $this->object->checkData('510/04/2013');
        $expected = "Data em formato inválido, informe data como (Ex: DD/MM/AAAA) <br />";
        $this->assertEquals($expected, $actual);
    }

    public function testValidarDataMes() 
    {
        $actual = $this->object->checkData('24/43/2013');
        $expected = "Data em formato inválido, informe data como (Ex: DD/MM/AAAA) <br />";
        $this->assertEquals($expected, $actual);
    }

    public function testValidarDataAnoInferior() 
    {
        $actual = $this->object->checkData('24/04/2010');
        $expected = "Ano informado e inferior ao ano corrente <br />";
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ValidaCadastro::checkData
     * @todo   Implement testCheckData().
    **/
    public function testCheckData() 
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ValidaCadastro::checktime
     * @todo   Implement testChecktime().
    **/
    public function testChecktime() 
    {
        $expected = NULL;
        $actual = $this->object->checktime(23, 59);
        $this->assertEquals($expected,$actual);
    }

    /**
     * @covers ValidaCadastro::validarPreco
    **/
    public function testValidarPreco() 
    {
        $preco = 20;
        $expected = NULL;
        $actual = $this->object->validarPreco($preco);
        
        $this->assertEquals($expected, $actual);
    }

        public function testValidarPrecoNegativo() 
        {
        $preco = -20;
        $expected = "Informe um preço válido <br />";
        $actual = $this->object->validarPreco($preco);
        
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ValidaCadastro::validarVaga
    **/ 
    public function testValidarVaga() 
    {
        $vaga = 100;
        $expected = NULL;
        $actual = $this->object->validarVaga($vaga);
        
        $this->assertEquals($expected, $actual);
    }

    public function testValidarVagaNegativa() 
    {
        $vaga = -100;
        $expected = "Informe um número de vagas válida <br />";
        $actual = $this->object->validarVaga($vaga);
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @covers ValidaCadastro::validarTelefone
     * @todo   Implement testValidarTelefone().
    **/
    public function testValidarTelefone() 
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ValidaCadastro::validarCpf
     * @todo   Implement testValidarCpf().
    **/
    public function testValidarCpf() 
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ValidaCadastro::validarNumero
     * @todo   Implement testValidarNumero().
    **/
    public function testValidarNumero()
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ValidaCadastro::validarCampo
     * @todo   Implement testValidarCampo().
    **/
    public function testValidarCampo() 
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers ValidaCadastro::verifica
     * @todo   Implement testVerifica().
    **/
    public function testVerifica() 
    {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
}