<?php

/**
 * Class name: UserDAC
 * Class to connect user to the database.
*/

class UserDAC 
{

    // Insert data from user into database.
    public static function insertUserDAC($user) 
    {

        include_once 'connection.php';
        $sql = "INSERT INTO users(`userFirstName`, `userLastName`, `userEmail`, `password`,`userSex`, 
            `userEmailConfirmado` , `confirmationCode`, `userCpf`, `userPhone`) VALUES 
            ('" . $user->getuserFirstName() . "','" . $user->getUserLastName() . "',
                '" . $user->getUserEmail() . "','" . $user->getUserPassword() . "',
                '" . $user->getUserSex() . "','0','" . $user->getConfirmationCode() . "',
                '" . $user->getUserCpf() . "','" . $user->getUserPhone() . "');";

        mysql_query($sql) or die(mysql_error() . "UserDAC - insertUserDAC");
        $RES = mysql_query("SELECT LAST_INSERT_ID()");
        $mat = mysql_fetch_array($RES);
        mysql_close($connection);
        return $mat['0'];
    }

    // Update data from user in database.
    public static function updateInformationUserDAC(user $user, $atributo, $atributoNovo) 
    {
        include_once 'connection.php';
        $sql = "UPDATE `users` SET `$atributo`=$atributoNovo WHERE id=". $user->getId();
        mysql_query($sql) or die(mysql_error());

    }

    // Update changes in user data into database.
    public static function updateUserDAC($user)
    {
        include_once 'connection.php';
        $sql = "UPDATE users SET
        userFirstName='" . $user->getUserFirstName() . "',
        UserLastName='" . $user->getUserLastName() . "',
        UserSex='" . $user->getUserSex() . "',
        UserCpf='" . $user->getUserCpf() . "',
        UserPhone='" . $user->getUserPhone() . "'
        WHERE id='". $user->getId() ."'";
        mysql_query($sql) or die(mysql_error());
    }

    // deleteUserDAC data from user in database.
    public static function deleteUserDAC($user) 
    {
        include_once 'connection.php';
        $sql = "deleteUserDAC FROM `users` WHERE id=";
        mysql_query($sql) or die(mysql_error());
    }

    // Recover data from database to user.
    public static function recoverUserDAC($user, $id) 
    {
        include_once 'connection.php';
        $sql = "SELECT * FROM users WHERE id=$id";
        $resultado = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($resultado);

        if (mysql_num_rows($resultado)==1){
           $user->setUserFirstName($row['userFirstName']);
           $user->setUserLastName($row['userLastName']);
           $user->setUserEmail($row['userEmail']);
           $user->setUserPhone($row['userPhone']);
           $user->setUserCpf($row['userCpf']);
           $user->setId($row['id']);
           //$user->setDataNasc($row['dataNasc']);
           //$user->setImage($row['image']);
           return 1;
        }else{
            return NULL;
        }
    }

    public static function verifyDisposition($UserEmail) 
    {
        include_once 'connection.php';
        $sql = "SELECT userEmail FROM users WHERE userEmail='$userEmail'";
        $result = mysql_query($sql);
        if (mysql_num_rows($result) == 0) {
            return 1;
        } else {
            return 0;
        }
    }

}