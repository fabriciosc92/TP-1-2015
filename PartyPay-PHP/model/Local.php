<?php

require_once 'DAC/LocalDAC.php';

/**
 * Class name: Local
 * Class responsible to define model elements in local.
 */
class Local 
{

    private $endereco;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $cep;
    private $pais;
    private $coordenadaGoogleMaps;
    private $fotos;
    private $id;
    private $nome;
    private $estado;
    private $miniatura;

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

    // Access variable estado
    public function getEstado() 
    {
        return $this->estado;
    }

    // Modify variable estado.
    public function setEstado($estado) 
    {
        $this->estado = $estado;
    }

    function __construct() 
    {
        
    }

    // Access variable numero.
    public function getNumero() 
    {
        return $this->numero;
    }

    // Modify variable numero.
    public function setNumero($numero) 
    {
        $this->numero = $numero;
    }

    // Access variable complemento.
    public function getComplemento() 
    {
        return $this->complemento;
    }

    // Modify variable complemento.
    public function setComplemento($complemento) 
    {
        $this->complemento = $complemento;
    }

    // Access variable bairro.
    public function getBairro() 
    {
        return $this->bairro;
    }

    // Modify variable bairro.
    public function setBairro($bairro) 
    {
        $this->bairro = $bairro;
    }

    // Access variable cidade.
    public function getCidade() 
    {
        return $this->cidade;
    }

    // Modify variable cidade.
    public function setCidade($cidade) 
    {
        $this->cidade = $cidade;
    }

    // Access variable cep.
    public function getCep() 
    {
        return $this->cep;
    }

    // Modify variable cep.
    public function setCep($cep) 
    {
        $this->cep = $cep;
    }

    // Access variable pais.
    public function getPais() 
    {
        return $this->pais;
    }

    // Modify variable pais.
    public function setPais($pais) 
    {
        $this->pais = $pais;
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

    // Access variable id.
    public function getId() 
    {
        return $this->id;
    }

    // Modify variable id.
    public function setId($id) 
    {
        $this->id = $id;
    }

    // Access variable endereco.
    public function getEndereco() 
    {
        return $this->endereço;
    }

    // Modify variable endereco.
    public function setEndereco($endereco) 
    {
        $this->endereço = $endereco;
    }

    // Access variable coordenadaGoogleMaps.
    public function getCoordenadaGoogleMaps() 
    {
        return $this->coordenadaGoogleMaps;
    }

    // Modify variable coordenadaGooleMaps.
    public function setCoordenadaGoogleMaps($coordenadaGoogleMaps) 
    {
        $this->coordenadaGoogleMaps = $coordenadaGoogleMaps;
    }

    // Access variable fotos.
    public function getFotos() 
    {
        return $this->fotos;
    }

    // Modify variable fotos.
    public function setFotos($fotos) 
    {
        $this->fotos = $fotos;
    }

    // Inserts a local in database.
    public function persist() 
    {
        return LocalDAC::persist($this);
    }

    // Update changes in local information.
    public function updateInfo($atributo, $novoValor) 
    {
        LocalDAC::updateInfo($this, $atributo, $novoValor);
    }

    // Delete a local in database.
    public function delete() 
    {
        LocalDAC::delete($this);
    }
    
}