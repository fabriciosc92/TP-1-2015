<?php

/**
 * Class name: UserDAC
 * Class to connect Pessoa to the database.
 */
class UserDAC 
{

    // Insert data from Pessoa into database.
    public static function insertUserDAC($pessoa) 
    {

        include_once 'connection.php';
        $sql = "INSERT INTO pessoas(`firstName`, `userLastName`, `userEmail`, `senha`,`userSex`, 
            `userEmailConfirmado` , `confirmationCode`, `userCpf`, `userPhone`) VALUES 
            ('" . $pessoa->getFirstName() . "','" . $pessoa->getUserLastName() . "',
                '" . $pessoa->getUserEmail() . "','" . $pessoa->getUserPassword() . "',
                '" . $pessoa->getUserSex() . "','0','" . $pessoa->getConfirmationCode() . "',
                '" . $pessoa->getUserCpf() . "','" . $pessoa->getUserPhone() . "');";

        mysql_query($sql) or die(mysql_error() . "UserDAC - insertUserDAC");
        $RES = mysql_query("SELECT LAST_INSERT_ID()");
        $mat = mysql_fetch_array($RES);
        mysql_close($connection);
        return $mat['0'];
    }

    // Update data from Pessoa in database.
    public static function updateInformationUserDAC(Pessoa $pessoa, $atributo, $atributoNovo) 
    {
        include_once 'connection.php';
        $sql = "UPDATE `pessoas` SET `$atributo`=$atributoNovo WHERE id=". $pessoa->getId();
        mysql_query($sql) or die(mysql_error());

    }

    // Update changes in Pessoa data into database.
    public static function updateUserDAC($pessoa)
    {
        include_once 'connection.php';
        $sql = "UPDATE pessoas SET
        FirstName='" . $pessoa->getFirstName() . "',
        UserLastName='" . $pessoa->getUserLastName() . "',
        UserSex='" . $pessoa->getUserSex() . "',
        UserCpf='" . $pessoa->getUserCpf() . "',
        UserPhone='" . $pessoa->getUserPhone() . "'
        WHERE id='". $pessoa->getId() ."'";
        mysql_query($sql) or die(mysql_error());
    }

    // deleteUserDAC data from Pessoa in database.
    public static function deleteUserDAC($pessoa) 
    {
        include_once 'connection.php';
        $sql = "deleteUserDAC FROM `pessoas` WHERE id=";
        mysql_query($sql) or die(mysql_error());
    }

    // Recover data from database to Pessoa.
    public static function recoverUserDAC($pessoa, $id) 
    {
        include_once 'connection.php';
        $sql = "SELECT * FROM pessoas WHERE id=$id";
        $resultado = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($resultado);

        if (mysql_num_rows($resultado)==1){
           $pessoa->setFirstName($row['firstName']);
           $pessoa->setUserLastName($row['userLastName']);
           $pessoa->setUserEmail($row['userEmail']);
           $pessoa->setUserPhone($row['userPhone']);
           $pessoa->setUserCpf($row['userCpf']);
           $pessoa->setId($row['id']);
           //$pessoa->setDataNasc($row['dataNasc']);
           //$pessoa->setImage($row['image']);
           return 1;
        }else{
            return NULL;
        }
    }

    public static function verifyDisposition($UserEmail) 
    {
        include_once 'connection.php';
        $sql = "SELECT userEmail FROM pessoas WHERE userEmail='$userEmail'";
        $result = mysql_query($sql);
        if (mysql_num_rows($result) == 0) {
            return 1;
        } else {
            return 0;
        }
    }

}