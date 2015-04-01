<?php

include '../../model/Evento.php';

class EventoTEST extends PHPUnit_Framework_TestCase 
{
    public $test;

    // Signal the start of the test process by creating a new event.
    public function setUp() 
    {
        $this->test = new Evento();
    }   
    
	// Tests the methods set and get InsercaoNome in class Evento.
    public function testInsercaoNome() 
    {
        $nome = $this->test->setNome("nome");
        $nomeTeste = $this->test->getNome();
        $this->assertEquals("nome", $nomeTeste);
    }
	
    // Tests the methods set and get InsercaoDataCriacao in class Evento.
    public function testInsercaoDataCriacao() 
    {
        $dataCriacao = $this->test->setDataCriacao("25/12/1999");
        $nomeTeste = $this->test->getDataCriacao();
        $this->assertEquals("25/12/1999", $nomeTeste);
    }

    // Tests the methods set and get InsercaoDataInicio in class Evento.
    public function testInsercaoDataInicio() 
    {
        $dataInicio = $this->test->setDataInicio("26/12/2001");
        $nomeTeste = $this->test->getDataInicio();
        $this->assertEquals("26/12/2001", $nomeTeste);
    }

    // Tests the methods set and get InsercaoDataTermino in class Evento.
    public function testInsercaoDataTermino() 
    {
        $dataTermino = $this->test->setDataTermino("28/12/2001");
        $nomeTeste = $this->test->getDataTermino();
        $this->assertEquals("28/12/2001", $nomeTeste);
    }

    // Tests the methods set and get InsercaoImagem in class Evento.
    public function testInsercaoImagem() 
    {
        $imagem = $this->test->setImagem("imagem001");
        $nomeTeste = $this->test->getImagem();
        $this->assertEquals("imagem001", $nomeTeste);
    }

    // Tests the methods set and get InsercaoPrecoMasc in class Evento.
    public function testInsercaoPrecoMasc() 
    {
        $precoMasc = $this->test->setPrecoMasc(50.00);
        $nomeTeste = $this->test->getPrecoMasc();
        $this->assertEquals(50.00, $nomeTeste);
    }

    // Tests the methods set and get InsercaoPrecoFem in class Evento.
    public function testInsercaoPrecoFem() 
    {
        $precoFem = $this->test->setPrecoFem(25.00);
        $nomeTeste = $this->test->getPrecoFem();
        $this->assertEquals(25.00, $nomeTeste);
    }

    // Tests the methods set and get InsercaoOrganizador in class Evento.
    public function testInsercaoOrganizador() 
    {
        $organizador = $this->test->setOrganizador("Promotor Fulano");
        $nomeTeste = $this->test->getOrganizador();
        $this->assertEquals("Promotor Fulano", $nomeTeste);
    }

    // Tests the methods set and get InsercaoLocal in class Evento.
    public function testInsercaoLocal() 
    {
        $local = $this->test->setLocal("Gama - DF");
        $nomeTeste = $this->test->getLocal();
        $this->assertEquals("Gama - DF", $nomeTeste);
    }

    // Tests the methods set and get InsercaoFacebookEventPage in class Evento.
    public function testInsercaoFacebookEventPage() 
    {
        $facebookEventPage = $this->test->setFacebookEventPage("www.facebook.com/dreamtheaterofficial");
        $nomeTeste = $this->test->getFacebookEventPage();
        $this->assertEquals("www.facebook.com/dreamtheaterofficial", $nomeTeste);
    }

    // Tests the methods set and get InsercaoDescricao in class Evento.
    public function testInsercaoDescricao()
    {
        $descricao = $this->test->setDescricao("Descrição sagaz");
        $nomeTeste = $this->test->getDescricao();
        $this->assertEquals("Descrição sagaz", $nomeTeste);
    }
    
    // Tests the methods set and get InsercaoNumeroIngressos in class Evento.
    public function testInsercaoNumeroIngressos() 
    {
        $numeroIngressos = $this->test->setNumeroIngressos(500);
        $nomeTeste = $this->test->getNumeroIngressos();
        $this->assertEquals(500, $nomeTeste);
    }

    // Tests the methods set and get InsercaoHoraInicio in class Evento.
    public function testInsercaoHoraInicio() 
    {
        $horaInicio = $this->test->setHoraInicio("22:00");
        $nomeTeste = $this->test->getHoraInicio();
        $this->assertEquals("22:00", $nomeTeste);
    }

    // Tests the methods set and get InsercaoHoraTermino in class Evento.
    public function testInsercaoHoraTermino() 
    {
        $horaTermino = $this->test->setHoraTermino("08:00");
        $nomeTeste = $this->test->getHoraTermino();
        $this->assertEquals("08:00", $nomeTeste);
    }

    // Tests the methods set and get InsercaoMiniatura in class Evento.
    public function testInsercaoMiniatura() 
    {
        $miniatura = $this->test->setMiniatura("miniaturaImagem001");
        $nomeTeste = $this->test->getMiniatura();
        $this->assertEquals("miniaturaImagem001", $nomeTeste);
    }

    // Tests the methods set and get InsercaoClassificacao in class Evento.
    public function testInsercaoClassificacao() 
    {
        $classificacao = $this->test->setClassificacao("Livre");
        $nomeTeste = $this->test->getClassificacao();
        $this->assertEquals("Livre", $nomeTeste);
    }
}