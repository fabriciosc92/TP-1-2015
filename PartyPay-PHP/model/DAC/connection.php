<?php

/**
 * File name: connection
 * Connection  with database.
**/

$server = 'localhost';
$db = 'partypay';
//CHANGE HERE THE USER.NAME AND YOUR MYSQL PASSWORD
$user = 'root';
$password = '';

$conexao = mysql_connect($server, $user, $password);
@mysql_select_db($db) OR DIE("DataBase not found!");

?>