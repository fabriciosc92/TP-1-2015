<?php

/**
 * File name: conexao
 * Connection  with database.
 */

$server = 'localhost';
$db = 'partypay';
//MODIFIQUE AQUI O USER.NAME E A SENHA DO SEU MYSQL
$user = 'root';
$password = '';

$connection = mysql_connect($server, $user, $password);
@mysql_select_db($db) OR DIE("Banco não encontrado.");

?>