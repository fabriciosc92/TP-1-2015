<?php
// Class responsible for checking register

$validatorCode = $_GET['op'];
$user_email = $_GET['email'];

require_once '../model/DAC/conexao.php';

$sql_update_email = "UPDATE `pessoas` SET `emailConfirmado`=true WHERE `email`= '$user_email' AND `codConfirmacao`= '$validatorCode'";

$return = mysql_query($sql_update_email) or die(mysql_error());

if (!$return)
    echo "Cadastro confirmado!";

mysql_close($conexao);
?>
