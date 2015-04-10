<?php

include 'DAC/PessoaDAC.php';

/**
 * Class name: Pessoa
 * Class responsible to define model elements in users.
 */
class Pessoa 
{

    private $primeiroNome;
    private $sobreNome;
    private $email;
    private $id;
    private $password;
    private $sexo;
    private $codConfirmacao;
    private $cpf;
    private $compras;
    private $cartoesDeCredito;
    private $cnpj;
    private $eventos;
    private $informaçoesBancarias;
    private $telefoneContato;
    private $nomeFantasia;
    private $website;
    private $facebookFanPage;

    // Access variable cnpj.
    public function getCnpj() 
    {
        return $this->cnpj;
    }

    // Modify variable cnpj.
    public function setCnpj($cnpj) 
    {
        $this->cnpj = $cnpj;
    }

    // Access variable eventos.
    public function getEventos() 
    {
        return $this->eventos;
    }

    // Modify variable eventos.
    public function setEventos($eventos) 
    {
        $this->eventos = $eventos;
    }

    // Access variable informacoesBancarias.
    public function getInformaçoesBancarias() 
    {
        return $this->informaçoesBancarias;
    }

    // Modify variable informacoesBancarias.
    public function setInformaçoesBancarias($informaçoesBancarias) 
    {
        $this->informaçoesBancarias = $informaçoesBancarias;
    }

    // Access variable telefoneContato.
    public function getTelefoneContato() 
    {
        return $this->telefoneContato;
    }

    public function setTelefoneContato($telefoneContato) 
    {
        $this->telefoneContato = $telefoneContato;
    }

    // Access variable nomeFantasia.
    public function getNomeFantasia() 
    {
        return $this->nomeFantasia;
    }

    // Modify variable nomeFantasia.
    public function setNomeFantasia($nomeFantasia) 
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    // Access variable website.
    public function getWebsite() 
    {
        return $this->website;
    }

    // Modify variable website.
    public function setWebsite($website) 
    {
        $this->website = $website;
    }

    // Access variable facebookFanPage.
    public function getFacebookFanPage() 
    {
        return $this->facebookFanPage;
    }

    // Modify variable facebookFanPage.
    public function setFacebookFanPage($facebookFanPage) 
    {
        $this->facebookFanPage = $facebookFanPage;
    }

    // Access variable cpf.
    public function getCpf() 
    {
        return $this->cpf;
    }

    // Modify variable cpf.
    public function setCpf($cpf) 
    {
        $this->cpf = $cpf;
    }

    // Access variable compras.
    public function getCompras() 
    {
        return $this->compras;
    }

    // Modify variable compras.
    public function setCompras($compras) 
    {
        $this->compras = $compras;
    }

    // Access variable cartoesDeCredito.
    public function getCartoesDeCredito() 
    {
        return $this->cartoesDeCredito;
    }

    // Modify variable cartoesDeCredito.
    public function setCartoesDeCredito($cartoesDeCredito) 
    {
        $this->cartoesDeCredito = $cartoesDeCredito;
    }

    // Access variable codConfirmacao.
    public function getCodConfirmacao() 
    {
        return $this->codConfirmacao;
    }

    // Modify variable codConfirmacao.
    public function setCodConfirmacao($codConfirmacao) 
    {
        $this->codConfirmacao = $codConfirmacao;
    }

    function __construct() 
    {
        
    }

    public function construaPorId($id) 
    {
        PessoaDAC::recupere($this, $id);
    }

    // Access variable sexo.
    public function getSexo()
    {
        return $this->sexo;
    }

    // Modify variable sexo.
    public function setSexo($sexo) 
    {
        $this->sexo = $sexo;
    }

    // Access variable password.
    public function getPassword() 
    {
        return $this->password;
    }

    // Modify variable password.
    public function setPassword($password) 
    {
        $this->password = $password;
    }

    // Access variable email.
    public function getEmail() 
    {
        return $this->email;
    }

    // Modify variable email.
    public function setEmail($email) 
    {
        $this->email = $email;
    }

    // Access variable primeiroNome.
    public function getPrimeiroNome() 
    {
        return $this->primeiroNome;
    }

    // Modify variable primeiroNome.
    public function setPrimeiroNome($primeiroNome) 
    {
        $this->primeiroNome = $primeiroNome;
    }

    // Access variable sobrenome.
    public function getSobreNome() 
    {
        return $this->sobreNome;
    }

    // Modify variable sobrenome.
    public function setSobreNome($sobreNome) 
    {
        $this->sobreNome = $sobreNome;
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

    // Inserts a person in database.
    public function persist() 
    {
        return PessoaDAC::persist($this);
    }

    // Update changes tha person do as a user.
    public function updateInfo($atributo, $novoValor) 
    {
        PessoaDAC::updateInfo($this, $atributo, $novoValor);
    }

    // Deletes a person from database.
    public function delete() 
    {
        PessoaDAC::delete($this);
    }

    // Updates a person in database.
    public function atualizar() 
    {
        PessoaDAC::atualizar($this);
    }

}