<?php

include '../../model/Local.php';

/**
 * Class name: LocalTest
 * Tests the functions in class Local.
 */

class LocalTEST extends PHPUnit_Framework_TestCase 
{
    public $test;

    // Signal the start of the test process by creating a new local.
    public function setUp() 
    {
        $this->test = new Local();
    }

    // Tests the functions set and get InsercaoEndereco in class Local.
    public function testInsercaoEndereco() 
    {
        $endereco = $this->test->setEndereco("Quadra 2");
        $nomeTeste = $this->test->getEndereco();
        $this->assertEquals("Quadra 2", $nomeTeste);
    }

    // Tests the functions set and get InsercaoNumero in class Local.
    public function testInsercaoNumero() 
    {
        $numero = $this->test->setNumero("Casa 2");
        $nomeTeste = $this->test->getNumero();
        $this->assertEquals("Casa 2", $nomeTeste);
    }

    // Tests the functions set and get InsercaoComplemento in class Local.
    public function testInsercaoComplemento() 
    {
        $complemento = $this->test->setComplemento("complemento teste");
        $nomeTeste = $this->test->getComplemento();
        $this->assertEquals("complemento teste", $nomeTeste);
    }

    // Tests the functions set and get InsercaoBairro in class Local.
    public function testInsercaoBairro() 
    {
        $bairro = $this->test->setBairro("Setor Oeste");
        $nomeTeste = $this->test->getBairro();
        $this->assertEquals("Setor Oeste", $nomeTeste);
    }

    // Tests the functions set and get InsercaoCidade in class Local.
    public function testInsercaoCidade() 
    {
        $cidade = $this->test->setCidade("Gama");
        $nomeTeste = $this->test->getCidade();
        $this->assertEquals("Gama", $nomeTeste);
    }

    // Tests the functions set and get InsercaoCep in class Local.
    public function testInsercaoCep() 
    {
        $cep = $this->test->setCep("72.000-000");
        $nomeTeste = $this->test->getCep();
        $this->assertEquals("72.000-000", $nomeTeste);
    }

    // Tests the functions set and get InsercaoPais in class Local.
    public function testInsercaoPais() 
    {
        $pais = $this->test->setPais("Brasil");
        $nomeTeste = $this->test->getPais();
        $this->assertEquals("Brasil", $nomeTeste);
    }

    // Tests the functions set and get InsercaoCoordenadaGoogleMaps in class Local.
    public function testInsercaoCoordenadaGoogleMaps() 
    {
        $coordenadaGoogleMaps = $this->test->setCoordenadaGoogleMaps("-15, +12");
        $nomeTeste = $this->test->getCoordenadaGoogleMaps();
        $this->assertEquals("-15, +12", $nomeTeste);
    }

    // Tests the functions set and get InsercaoFotos in class Local.
    public function testInsercaoFotos() 
    {
        $fotos = $this->test->setFotos("Foto 0001");
        $nomeTeste = $this->test->getFotos();
        $this->assertEquals("Foto 0001", $nomeTeste);
    }

    // Tests the functions set and get InsercaoId in class Local.
    public function testInsercaoId() 
    {
        $id = $this->test->setId("150");
        $nomeTeste = $this->test->getId();
        $this->assertEquals("150", $nomeTeste);
    }

    // Tests the functions set and get InsercaoNome in class Local.
    public function testInsercaoNome() 
    {
        $nome = $this->test->setNome("Nome do evento TESTE");
        $nomeTeste = $this->test->getNome();
        $this->assertEquals("Nome do evento TESTE", $nomeTeste);
    }

    // Tests the functions set and get InsercaoEstado in class Local.
    public function testInsercaoEstado() 
    {
        $estado = $this->test->setEstado("Distrito Federal");
        $nomeTeste = $this->test->getEstado();
        $this->assertEquals("Distrito Federal", $nomeTeste);
    }

    // Tests the functions set and get InsercaoMiniatura in class Local.
    public function testInsercaoMiniatura() 
    {
        $miniatura = $this->test->setMiniatura("Miniatura 001");
        $nomeTeste = $this->test->getMiniatura();
        $this->assertEquals("Miniatura 001", $nomeTeste);
    }
}