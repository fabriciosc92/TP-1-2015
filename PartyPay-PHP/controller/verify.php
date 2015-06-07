<?php

// File responsible for checking register

$validatorCode = $_GET['op'];
$userEmail = $_GET['email'];

require_once '../model/DAC/connection.php'
    or log_it("Could not include connection.php file");

$sql_update_email = "UPDATE `pessoas` SET `emailConfirmado`=true 
	WHERE `email`= '$user_email' AND `codConfirmacao`= '$validatorCode'";

$return = mysql_query($sql_update_email) or die(mysql_error());

if (!$return) {

    log_it("Registration failed"); 
    echo "Cadastro confirmado!";
}

mysql_close($connection);
?>
