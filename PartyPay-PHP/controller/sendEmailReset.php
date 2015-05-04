<?php

/**
*
* This class is responsible for sending a message of password reset
*
**/

$user_email = $_POST['userEmail']; // Receive input user e-mail

$AcceptedChars = 'ghijklmABCEF0123456789'; // Test acceptable characteres
$maxChars = strlen($AcceptedChars) - 1; // Test max acceptable characteres in user e-mail
$newPassword = ''; //Store the new password entered
$password = ''; // Compare the new password entered again

for ($i = 0; $i < 8; $i++) {
    $password .= $AcceptedChars{mt_rand(0, $maxChars)};
    $newPassword = md5($password);
}

$Message = "Oi!\n\nEsta é a sua nova senha: $password\n"; // Message to the user new password confirmation

require_once("phpmailer/class.phpmailer.php");

// Function to control sending emails
function smtpmailer($para, $de, $de_nome, $assunto, $corpo) 
{

    global $error;

    $mail = new PHPMailer(); // Receive e-mail configuration parameters

    $mail->IsSMTP();  // Ativar SMTP
    $mail->SMTPDebug = 0;  // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
    $mail->SMTPAuth = true;  // Autenticação ativada
    $mail->SMTPSecure = 'ssl'; // SSL REQUERIDO pelo GMail
    $mail->Host = 'smtp.gmail.com'; // SMTP utilizado
    $mail->Port = 465;    // A porta 465 deverá estar aberta em seu servidor
    $mail->Username = 'partypay.eventos@gmail.com';
    $mail->Password = 'senhapartypay';
    $mail->SetFrom($de, $de_nome);
    $mail->Subject = $assunto;
    $mail->Body = $corpo;
    $mail->AddAddress($para);

    if (!$mail->Send()) 
    {
        $error = 'Mail error: ' . $mail->ErrorInfo;
        return false;
    } 
    else 
    {
        $error = 'Uma nova senha foi enviada para seu email!';
        return true;
    }
}

require_once '../model/DAC/conexao.php';

$sql = "SELECT * FROM `pessoas` WHERE email= '$user_email' ";
$retorno = mysql_query($sql) or die(mysql_error());

if (mysql_num_rows($retorno) === 1) 
{

    $sql_update = "UPDATE `pessoas` SET `senha` = '$newPassword' 
                    WHERE `pessoas`.`email` ='$user_email';";

    mysql_query($sql_update) or die(mysql_error());

    smtpmailer($user_email, 'partypay.eventos@gmail.com', "PartyPay", 
                                "Nova senha - PartyPay!", $Message);

    if (!empty($error))
    {
        echo $error;
    }
    else
    {
        
    }

 }   
else 
{
    echo "Desculpe! Email n&atilde;o cadastrado!";
}

mysql_close($conexao);
?>
