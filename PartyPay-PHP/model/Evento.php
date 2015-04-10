<?php

require_once 'DAC/EventoDAC.php';

/**
 * Class name: Evento
 * Class responsible to define model elements in events.
 */
class Evento 
{

    private $nome; //nome do evento
    private $dataCriacao;
    private $dataInicio;
    private $dataTermino;
    private $imagem; //input do tipo file name arquivo
    private $precoMasc;
    private $precoFem;
    private $organizador; //nao precisa
    private $local; //nao precisa
    private $facebookEventPage;
    private $descricao;
    private $numeroIngressos;
    private $horaInicio;
    private $horaTermino;
    private $miniatura; //nao precisa
    private $classificacao;
    private $Id;

    // Access variable classificacao.
    public function getClassificacao() 
    {
        return $this->classificacao;
    }

    // Modify variable classificacao.
    public function setClassificacao($classificacao) 
    {
        $this->classificacao = $classificacao;
    }

    // Access variable id.
    public function getId() 
    {
        return $this->Id;
    }

    // Modify variable id.
    public function setId($Id) 
    {
        $this->Id = $Id;
    }

    // Access variable miniatura.
    public function getMiniatura() 
    {
        return $this->miniatura;
    }

    // Modify variable miniatura.
    public function setMiniatura($miniatura) 
    {
        $this->miniatura = $miniatura;
    }

    // Access variable horaInicio.
    public function getHoraInicio() 
    {
        return $this->horaInicio;
    }

    // Modify variable horaInicio.
    public function setHoraInicio($horaInicio) 
    {
        $this->horaInicio = $horaInicio;
    }

    // Access variable horaTermino.
    public function getHoraTermino() 
    {
        return $this->horaTermino;
    }

    // Modify variable horaTermino.
    public function setHoraTermino($horaTermino) 
    {
        $this->horaTermino = $horaTermino;
    }

    function __construct() 
    {
        
    }

    // Access variable numeroIngressos.
    public function getNumeroIngressos() 
    {
        return $this->numeroIngressos;
    }

    // Modify variable numeroIngressos.
    public function setNumeroIngressos($numeroIngressos) 
    {
        $this->numeroIngressos = $numeroIngressos;
    }

    // Access variable dataCriacao.
    public function getDataCriacao() 
    {
        return $this->dataCriacao;
    }

    // Modify variable dataCriacao.
    public function setDataCriacao($dataCriacao) 
    {
        $this->dataCriacao = $dataCriacao;
    }


    // Access variable imagem.
    public function getImagem() 
    {
        return $this->imagem;
    }

    // Modify variable imagem.
    public function setImagem($imagem) 
    {
        $this->imagem = $imagem;
    }

    // Access variable descricao.
    public function getDescricao() 
    {
        return $this->descricao;
    }

    // Modify variable descricao.
    public function setDescricao($descricao) 
    {
        $this->descricao = $descricao;
    }

    // Access variable facebookEventPage.
    public function getFacebookEventPage() 
    {
        return $this->facebookEventPage;
    }

    // Modify variable facebookEventPage.
    public function setFacebookEventPage($facebookEventPage) 
    {
        $this->facebookEventPage = $facebookEventPage;
    }

    // Access variable nome.
    public function getNome() 
    {
        return $this->nome;
    }

    // Modify variable nome.
    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    // Access variable dataInicio.
    public function getDataInicio() 
    {
        return $this->dataInicio;
    }

    // Modify variable dataInicio.
    public function setDataInicio($dataInicio) 
    {
        $this->dataInicio = $dataInicio;
    }

    // Access variable dataTermino.
    public function getDataTermino() 
    {
        return $this->dataTermino;
    }

    // Modify variable dataTermino.
    public function setDataTermino($dataTermino) 
    {
        $this->dataTermino = $dataTermino;
    }

    // Access variable precoMasc.
    public function getPrecoMasc() 
    {
        return $this->precoMasc;
    }

    // Modify variable precoMasc.
    public function setPrecoMasc($precoMasc) 
    {
        $this->precoMasc = $precoMasc;
    }

    // Access variable precoFem.
    public function getPrecoFem() 
    {
        return $this->precoFem;
    }

    // Modify variable precoFem.
    public function setPrecoFem($precoFem) 
    {
        $this->precoFem = $precoFem;
    }

    // Access variable organizador.
    public function getOrganizador() 
    {
        return $this->organizador;
    }

    // Modify variable organizador.
    public function setOrganizador($organizador) 
    {
        $this->organizador = $organizador;
    }

    // Access variable local.
    public function getLocal() 
    {
        return $this->local;
    }

    // Modify variable local.
    public function setLocal($local) 
    {
        $this->local = $local;
    }

    // Inserts an event in database.
    public function persist() 
    {
        return EventoDAC::persist($this);
    }

    // Update informations that are modify in database.
    public function updateInfo($atributo, $novoValor) 
    {
        EventoDAC::updateInfo($this, $atributo, $novoValor);
    }

    // Deletes an event in database. 
    public function delete() 
    {
        EventoDAC::delete($this);
    }

    // Recovery an event.
    public function eventoPorId($Id)
    {
        EventoDAC::recupere($this, $Id);
    }

}