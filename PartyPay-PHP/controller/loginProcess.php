<?php

include '../model/User.php';
include '../tratamentoDeExcecao/AuthenticateRegistration.php';
include 'generateConfirmationCode.php';

/*
 * File name: loginProcess.
 * File responsible for user's loggin.
 */


session_start();

// In this part can use the file connection.php.
$host = "localhost"; // Host name. 
$username = "root"; // Mysql username - Change here the MYSQL username.
$password = ""; // Mysql password - Change here the MYSQL password.
$db_name = "payparty"; // DB name.
$tbl_name = "pessoas"; // Table name.

// Connection with server and Data Base.
mysql_connect("$host", "$username", "$password") or die("cannot connect");
mysql_select_db("$db_name") or die("DB not found.");

if (isset($_SESSION['email'])) 
{
    $_POST['email'] = $_SESSION['email'];
    $_POST['password'] = $_SESSION['password'];
}

// FORM email e password  that comes from index.php.
$email = addslashes($_POST['email']);
$mypassword = addslashes($_POST['password']);
$encrypted_mypassword = md5($mypassword);


$strList = "\\\'\"&\n\r<>";
addcslashes($email, $strList);
addcslashes($mypassword, $strList);

// To protect from MySQL injection.
$email = stripslashes($email);
$mypassword = stripslashes($mypassword);
$email = mysql_real_escape_string($email);
$mypassword = mysql_real_escape_string($mypassword);
$sql = "SELECT * FROM $tbl_name WHERE email='$email' and senha='$encrypted_mypassword'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

// Mysql_num_row counts the number of lines in the table.
$count = mysql_num_rows($result);

// If the result matches $email and $mypassword, it must have a line in the BD.
if ($count == 1) 
{

    // Register $email, $mypassword and direct to "login_success.php"
    log_it("Login with success");
    echo "Login Sucess!";

    $_SESSION['email'] = $email;
    $_SESSION['password'] = $mypassword;
    $_SESSION['id'] = $row['id'];

    // Test if the id is passing right:
    // echo $_SESSION['id'];
    header("location: ../login.php");
} 
else 
{

    log_it("Attempt loggin failed, wrong username or password");
    echo "Wrong Username or Password";
}

ob_end_flush();
?>
