<?php

include 'DAC/UserDAC.php';

/**
 * Class name: User
 * Class responsible to define model elements in users.
*/
 
class User
{

    private $userFirstName; // Keeps user first name.
    private $userLastName; // Store the user last name.
    private $userEmail; // Keeps the user email.
    private $id; // User id in database.
    private $userPassword; // Password to access the site.
    private $userSex; // Gender of the user.
    private $confirmationCode; // Confirmation code when finishes the registering.
    private $userCpf; // Keeps the user cpf.
    private $userShopping; // Keeps what the user is buying.
    private $userCreditCard; // Credit cards that will be using to buy the tickets.
    private $userCnpj; // Keeps the user Cnpj.
    private $userEvents;  // Events that the user chose.
    private $bankInformation; // User bank information.
    private $userPhone; // Telefone to contact the user.
    private $userFantasyName; // Store the fantasy name.
    private $website; // Keeps the website
    private $facebookFanPage; // User facebook fan page.

    // Access variable userCnpj.
    public function getUserCnpj() 
    {
        return $this->userCnpj;
    }

    // Modify variable userCnpj.
    public function setUserCnpj($userCnpj) 
    {
        $this->userCnpj = $userCnpj;
    }

    // Access variable userEvents.
    public function getUserEvents() 
    {
        return $this->userEvents;
    }

    // Modify variable userEvents.
    public function setUserEvents($userEvents) 
    {
        $this->userEvents = $userEvents;
    }

    // Access variable informacoesBancarias.
    public function getBankInformation() 
    {
        return $this->bankInformation;
    }

    // Modify variable informacoesBancarias.
    public function setBankInformation($bankInformation) 
    {
        $this->bankInformation = $bankInformation;
    }

    // Access variable userPhone.
    public function getUserPhone() 
    {
        return $this->userPhone;
    }

    public function setUserPhone($userPhone) 
    {
        $this->userPhone = $userPhone;
    }

    // Access variable userFantasyName.
    public function getUserFantasyName() 
    {
        return $this->userFantasyName;
    }

    // Modify variable userFantasyName.
    public function setUserFantasyName($userFantasyName) 
    {
        $this->userFantasyName = $userFantasyName;
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

    // Access variable userCpf.
    public function getUserCpf() 
    {
        return $this->userCpf;
    }

    // Modify variable userCpf.
    public function setUserCpf($userCpf) 
    {
        $this->userCpf = $userCpf;
    }

    // Access variable userShopping.
    public function getUserShopping() 
    {
        return $this->userShopping;
    }

    // Modify variable userShopping.
    public function setUserShopping($userShopping) 
    {
        $this->userShopping = $userShopping;
    }

    // Access variable userCreditCard.
    public function getUserCreditCard() 
    {
        return $this->userCreditCard;
    }

    // Modify variable userCreditCard.
    public function setUserCreditCard($userCreditCard) 
    {
        $this->userCreditCard = $userCreditCard;
    }

    // Access variable confirmationCode.
    public function getConfirmationCode() 
    {
        return $this->confirmationCode;
    }

    // Modify variable confirmationCode.
    public function setConfirmationCode($confirmationCode) 
    {
        $this->confirmationCode = $confirmationCode;
    }

    function __construct() 
    {
        
    }

    public function builById($id) 
    {
        UserDAC::recoverUserDAC($this, $id);
    }

    // Access variable userSex.
    public function getUserSex()
    {
        return $this->userSex;
    }

    // Modify variable userSex.
    public function setUserSex($userSex) 
    {
        $this->userSex = $userSex;
    }

    // Access variable userPassword.
    public function getUserPassword() 
    {
        return $this->userPassword;
    }

    // Modify variable userPassword.
    public function setUserPassword($userPassword) 
    {
        $this->userPassword = $userPassword;
    }

    // Access variable userEmail.
    public function getUserEmail() 
    {
        return $this->userEmail;
    }

    // Modify variable userEmail.
    public function setUserEmail($userEmail) 
    {
        $this->userEmail = $userEmail;
    }

    // Access variable userFirstName.
    public function getUserFirstName() 
    {
        return $this->userFirstName;
    }

    // Modify variable userFirstName.
    public function setUserFirstName($userFirstName) 
    {
        $this->userFirstName = $userFirstName;
    }

    // Access variable userLastName.
    public function getUserLastName() 
    {
        return $this->userLastName;
    }

    // Modify variable userLastName.
    public function setUserLastName($userLastName) 
    {
        $this->userLastName = $userLastName;
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
    public function insertUser() 
    {
        return UserDAC::insertUser($this);
    }

    // Update changes tha person do as a user.
    public function updateInformationUserDAC($atributo, $novoValor) 
    {
        UserDAC::updateInformationUserDAC($this, $atributo, $novoValor);
    }

    // deleteUsers a person from database.
    public function deleteUser() 
    {
        UserDAC::deleteUser($this);
    }

    // Updates a person in database.
    public function updateUser() 
    {
        UserDAC::updateUser($this);
    }

}