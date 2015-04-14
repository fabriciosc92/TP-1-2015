<?php

/**
 * File name: login
 * Login the user creating a new session
 */

include 'model/Person.php';

session_start();

$soAndSo = new Person;
$soAndSo->constructById($_SESSION['id']);

$firstName = $soAndSo->getFirstName();
$surName = $soAndSo->getSurName();
$email = $soAndSo->getEmail();
$gender = $soAndSo->getGender();
$idNumber = $soAndSo->getIdNumber();
$phoneNumber = $soAndSo->getContactNumber();

$_SESSION['firstName'] = $firstName;
$_SESSION['surName'] = $surName;
$_SESSION['email'] = $email;
$_SESSION['gender'] = $gender;
$_SESSION['idNumber'] = $idNumber;
$_SESSION['phoneNumber'] = $phoneNumber;

header("location: index.php");

?>