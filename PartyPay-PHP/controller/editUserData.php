<?php

include '../model/Pessoa.php';
include '../tratamentoDeExcecao/ValidaCadastro.php';
include 'gerarCodConfirmacao.php';

/**
*
* Class responsible for edits of user's data
*
**/

session_start();

$firstName = addslashes($_POST['firstName']);
$sobreNome = addslashes($_POST['lastName']);
$sexo = addslashes($_POST['gender']);
$cpf = addslashes($_POST['cpf']);
$telefoneContato = addslashes($_POST['phone']);
$id = $_SESSION['id'];

$strList = "\\\'\"&\n\r<>";
addcslashes($firstName, $strList);
addcslashes($lastName, $strList);
addcslashes($gender, $strList);
addcslashes($cpf, $strList);
addcslashes($phone, $strList);

//Validação comentada para rodar no localhost
//$validator= new ValidaCadastro();
//$validator->validarEmail($email);
//inclua aqui o resto das chamadas dos metodos de validaçao;
//$mensagem=$validator->msg;
//echo "<script>alert('$mensagem');</script>";

$codeConfirmation = generateCodConfimation();
$user = new Pessoa();

$user->setFirstName($firstName);
$user->setLastName($lastName);
$user->setGender($gender);
$user->setCpf($cpf);
$user->setPhone($phone);
$user->setId($id);

$user->setCodConfirmacao($codeConfirmation);
//$user->updateInfo("lastName", "lastName");

$user->atualizar();

unset($_SESSION['firstName']);
unset($_SESSION['lastName']);
unset($_SESSION['gender']);
unset($_SESSION['cpf']);
unset($_SESSION['phone']);

$_SESSION['firstName'] = $firstName;
$_SESSION['lastName'] = $lastName;
$_SESSION['gender'] = $gender;
$_SESSION['cpf'] = $cpf;
$_SESSION['phone'] = $phone;

echo "efetuado com sucesso " . $id;
// header("Location:../controller/sendEmailConfirmation.php?e=".$_POST['email']."&cod=".$codeConfirmation);
header("Location: ../editarPerson.php");
?>