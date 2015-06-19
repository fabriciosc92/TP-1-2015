<?php

/**
 * File name: logout
 * Logout user destroying all data registered to a session
**/

session_start();
session_destroy(); //destroys session data
session_unset(); //free all session variables

header("location: index.php");

?>