<?php

include '../model/User.php';
include '../tratamentoDeExcecao/ValidaCadastro.php';
include 'generateConfirmationCode.php';

/**
*
* Class responsible for user's registration
*
**/

$userFirstName = addslashes($_POST['userFirstName']); // First name of the user
$userLastName = addslashes($_POST['userLastName']); // Last name of the user
$userEmail = addslashes($_POST['userEmail']); // User userEmail
$userPassword = addslashes($_POST['userPassword']); // User userPassword
$userSex = addslashes($_POST['userSex']); // User userSex
$userCpf = addslashes($_POST['userCpf']); // User userCpf
$userPhone = addslashes($_POST['userPhone']); // User phone

$strList = "\\\'\"&\n\r<>";
addcslashes($userFirstName, $strList);
addcslashes($userLastName, $strList);
addcslashes($userEmail, $strList);
addcslashes($userPassword, $strList);
addcslashes($userSex, $strList);
addcslashes($userCpf, $strList);
addcslashes($userPhone, $strList);

//Validação comentada para rodar no localhost
$validator = new ValidaCadastro(); // Variable responsible to validate
$validator->validaruserEmail($userEmail);
$validator->validarTelefone($phone);
$validator->validaruserCpf($userCpf);

//inclua aqui o resto das chamadas dos metodos de validaçao;
//echo "<script>alert('$mensagem');</script>";


$codeConfirmation = generateConfirmationCode(); // Code confirmation
$user = new User(); // Responsible for creating instance of user


$user->setUserEmail($userEmail);
$user->setUserFirstName($userFirstName);
$user->setUserLastName($userLastName);
$user->setUserPassword(md5($userPassword)); //criptografia md5 para o userPassword
$user->setUserSex($userSex);
$user->setUserCpf($userCpf);
$user->setUserPhone($userPhone);


$user->setCodConfirmacao($codeConfirmation);
$user->insertUser();
echo "efetuado com sucesso";
// header("Location:../controller/SenduserEmailConfirmation.php?e=".$_POST['userEmail']."&cod=".$codeConfirmation);
header("Location: ../login.php");

session_start();

$_SESSION['userEmail'] = $userEmail;
$_SESSION['userPassword'] = $userPassword;

header("location: loginProcess.php");
?>
