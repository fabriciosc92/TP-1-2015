<?php

include '../model/User.php';
include '../tratamentoDeExcecao/AuthenticateRegistration.php';
include 'generateConfirmationCode.php';

/**
*
* Class responsible for user's loggin
*
**/


session_start();

// Nesta parte do código pode ser utilzado o arquivo conexao.php
$host = "localhost"; // Host name 
$username = "root"; // Mysql username - MUDE AQUI O USERNAME DO SEU MYSQL
$password = ""; // Mysql password - MUDE AQUI A SENHA DO SEU MYSQL
$db_name = "payparty"; // Nome do Banco de Dados
$tbl_name = "pessoas"; // Nome da Tabela
// Conexão com o server e com o Banco de dados.
mysql_connect("$host", "$username", "$password") or die("cannot connect");
mysql_select_db("$db_name") or die("Banco não encontrado.");

if (isset($_SESSION['email'])) {
    $_POST['email'] = $_SESSION['email'];
    $_POST['password'] = $_SESSION['password'];
}

// email e password da FORM que vem do index.php
$email = addslashes($_POST['email']);
$mypassword = addslashes($_POST['password']);
$encrypted_mypassword = md5($mypassword);


$strList = "\\\'\"&\n\r<>";
addcslashes($email, $strList);
addcslashes($mypassword, $strList);

// Para proteger de MySQL injection
$email = stripslashes($email);
$mypassword = stripslashes($mypassword);
$email = mysql_real_escape_string($email);
$mypassword = mysql_real_escape_string($mypassword);
$sql = "SELECT * FROM $tbl_name WHERE email='$email' and senha='$encrypted_mypassword'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

// Mysql_num_row é para contar o número de linhas na tabela
$count = mysql_num_rows($result);

// Se o resuldado bater com o $email e o $mypassword, têm que haver uma linha no BD
if ($count == 1) {
// Registra $email, $mypassword e direciona para o arquivo "login_success.php"
// Porém este SESSION já faz a função que o arquivo login_sucess faz.
// TODO: PESQUISAR NECESSIDADE DE TAL ARQUIVO!
// Não há necessicidade!
    echo "Login Sucess!";
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $mypassword;
    $_SESSION['id'] = $row['id'];

    //Para testar se o id está sendo passado corretamente:
    //echo $_SESSION['id'];
    header("location: ../login.php");
} else {

    log_it("Attempt loggin failed, wrong username or password");
    
    echo "Wrong Username or Password";
}
ob_end_flush();
?>
