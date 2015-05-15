<?php

include '../model/User.php';
include '../tratamentoDeExcecao/ValidaCadastro.php';
include 'generateConfimationCode.php';

/**
*
* Class responsible for edits of user's data
*
**/

session_start();

$userFirstName = addslashes($_POST['userFirstName']);
$userLastName = addslashes($_POST['lastName']);
$userSex = addslashes($_POST['userSex']);
$userCpf = addslashes($_POST['userCpf']);
$userPhone = addslashes($_POST['userPhone']);
$id = $_SESSION['id'];

$strList = "\\\'\"&\n\r<>";
addcslashes($userFirstName, $strList);
addcslashes($lastName, $strList);
addcslashes($userSex, $strList);
addcslashes($userCpf, $strList);
addcslashes($userPhone, $strList);

//Validação comentada para rodar no localhost
//$validator= new ValidaCadastro();
//$validator->validarEmail($email);
//inclua aqui o resto das chamadas dos metodos de validaçao;
//$mensagem=$validator->msg;
//echo "<script>alert('$mensagem');</script>";

$confirmationCode = generateConfirmationCode();
$user = new User();

$user->setUserFirstName($userFirstName);
$user->setUserLastName($lastName);
$user->setUserSex($userSex);
$user->setUserCpf($userCpf);
$user->setUserPhone($userPhone);
$user->setId($id);

$user->setConfirmationCode($confirmationCode);
//$user->updateInfo("lastName", "lastName");

$user->atualizar();

unset($_SESSION['userFirstName']);
unset($_SESSION['userLastName']);
unset($_SESSION['userSex']);
unset($_SESSION['userCpf']);
unset($_SESSION['userPhone']);

$_SESSION['userFirstName'] = $userFirstName;
$_SESSION['userLastName'] = $lastName;
$_SESSION['userSex'] = $userSex;
$_SESSION['userCpf'] = $userCpf;
$_SESSION['userPhone'] = $userPhone;

echo "efetuado com sucesso " . $id;
// header("Location:../controller/sendEmailConfirmation.php?e=".$_POST['email']."&cod=".$confirmationCode);
header("Location: ../editPerson.php");
?>