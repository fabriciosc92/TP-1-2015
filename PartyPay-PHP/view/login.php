<?php

/**
 * File name: login
 * Login the user creating a new session
**/

include 'model/User.php';

session_start();

$soAndSo = new User;
$soAndSo->constructById($_SESSION['id']);

$userFirstName = $soAndSo->getuserFirstName();
$userLastName = $soAndSo->getuserLastName();
$userEmail = $soAndSo->getuserEmail();
$userSex = $soAndSo->getuserSex();
$id = $soAndSo->getid();
$userPhone = $soAndSo->getContactNumber();

$_SESSION['userFirstName'] = $userFirstName;
$_SESSION['userLastName'] = $userLastName;
$_SESSION['userEmail'] = $userEmail;
$_SESSION['userSex'] = $userSex;
$_SESSION['id'] = $id;
$_SESSION['userPhone'] = $userPhone;

header("location: index.php");

?>