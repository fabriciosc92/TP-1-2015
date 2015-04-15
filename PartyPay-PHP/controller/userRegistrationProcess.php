<?php

include '../model/Pessoa.php';
include '../tratamentoDeExcecao/ValidaCadastro.php';
include 'generateConfirmationCode.php';

/**
*
* Class responsible for user's registration
*
**/

$firstName = addslashes($_POST['firstName']); // First name of the user
$lastName = addslashes($_POST['lastName']); // Last name of the user
$email = addslashes($_POST['email']); // User email
$password = addslashes($_POST['password']); // User password
$gender = addslashes($_POST['gender']); // User gender
$cpf = addslashes($_POST['cpf']); // User cpf
$telefoneContato = addslashes($_POST['phone']); // User phone

$strList = "\\\'\"&\n\r<>";
addcslashes($firstName, $strList);
addcslashes($lastName, $strList);
addcslashes($email, $strList);
addcslashes($password, $strList);
addcslashes($gender, $strList);
addcslashes($cpf, $strList);
addcslashes($phone, $strList);

//Validação comentada para rodar no localhost
$validator = new ValidaCadastro(); // Variable responsible to validate
$validator->validarEmail($email);
$validator->validarTelefone($phone);
$validator->validarCpf($cpf);

//inclua aqui o resto das chamadas dos metodos de validaçao;
//echo "<script>alert('$mensagem');</script>";


$codeConfirmation = generateCodConfirmation(); // Code confirmation
$user = new Pessoa(); // Responsible for creating instance of user


$user->setEmail($email);
$user->setFirstName($firstName);
$user->setLastName($lastName);
$user->setPassword(md5($password)); //criptografia md5 para o password
$user->setGender($gender);
$user->setCpf($cpf);
$user->setPhone($phone);


$user->setCodConfirmacao($codeConfirmation);
$user->persist();
echo "efetuado com sucesso";
// header("Location:../controller/SendEmailConfirmation.php?e=".$_POST['email']."&cod=".$codeConfirmation);
header("Location: ../login.php");

session_start();

$_SESSION['email'] = $email;
$_SESSION['password'] = $password;

header("location: processaLogin.php");
?>
