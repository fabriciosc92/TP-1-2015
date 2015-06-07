<?php

require '../model/User.php';
require '../tratamentoDeExcecao/AuthenticateRegistration.php';
require 'generateConfirmationCode.php';

/**
* File name: userRegistrationProcess.
* Class responsible for user's registration.
**/

$userFirstName = addslashes($_POST['userFirstName']); // First name of the user
$userLastName = addslashes($_POST['userLastName']); // Last name of the user
$userEmail = addslashes($_POST['userEmail']); // User userEmail
$userPassword = addslashes($_POST['userPassword']); // User userPassword
$userGender = addslashes($_POST['userGender']); // User userGender
$userCpf = addslashes($_POST['userCpf']); // User userCpf
$userPhone = addslashes($_POST['userPhone']); // User phone

$strList = "\\\'\"&\n\r<>";
addcslashes($userFirstName, $strList);
addcslashes($userLastName, $strList);
addcslashes($userEmail, $strList);
addcslashes($userPassword, $strList);
addcslashes($userGender, $strList);
addcslashes($userCpf, $strList);
addcslashes($userPhone, $strList);

// Validation to run localhost
$validator = new ValidaCadastro(); // Variable responsible to validate
$validator->validaruserEmail($userEmail);
$validator->validarTelefone($phone);
$validator->validaruserCpf($userCpf);


$codeConfirmation = generateConfirmationCode(); // Code confirmation
$user = new User(); // Responsible for creating instance of user


$user->setUserEmail($userEmail);
$user->setUserFirstName($userFirstName);
$user->setUserLastName($userLastName);
$user->setUserPassword(md5($userPassword)); // md5 criptografy for userPassword
$user->setUserGender($userGender);
$user->setUserCpf($userCpf);
$user->setUserPhone($userPhone);


$user->setCodConfirmacao($codeConfirmation);
$user->insertUser();

echo("<script>console.log('PHP: ".$user."');</script>");
echo "sucess!";

header("Location: ../login.php");

session_start();

$_SESSION['userEmail'] = $userEmail;
$_SESSION['userPassword'] = $userPassword;

header("location: loginProcess.php");
?>
