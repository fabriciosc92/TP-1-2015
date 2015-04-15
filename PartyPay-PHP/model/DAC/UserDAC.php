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

        include_once 'conexao.php';
        $sql = "INSERT INTO pessoas(`primeiroNome`, `sobreNome`, `email`, `senha`,`sexo`, 
            `emailConfirmado` , `codConfirmacao`, `cpf`, `telefoneContato`) VALUES 
            ('" . $pessoa->getPrimeiroNome() . "','" . $pessoa->getSobreNome() . "',
                '" . $pessoa->getEmail() . "','" . $pessoa->getPassword() . "',
                '" . $pessoa->getSexo() . "','0','" . $pessoa->getCodConfirmacao() . "',
                '" . $pessoa->getCpf() . "','" . $pessoa->getTelefoneContato() . "');";

        mysql_query($sql) or die(mysql_error() . "UserDAC - insertUserDAC");
        $RES = mysql_query("SELECT LAST_INSERT_ID()");
        $mat = mysql_fetch_array($RES);
        mysql_close($conexao);
        return $mat['0'];
    }

    // Update data from Pessoa in database.
    public static function updateInformationUserDAC(Pessoa $pessoa, $atributo, $atributoNovo) 
    {
        include_once 'conexao.php';
        $sql = "UPDATE `pessoas` SET `$atributo`=$atributoNovo WHERE id=". $pessoa->getId();
        mysql_query($sql) or die(mysql_error());

    }

    // Update changes in Pessoa data into database.
    public static function updateUserDAC($pessoa)
    {
        include_once 'conexao.php';
        $sql = "UPDATE pessoas SET
        primeiroNome='" . $pessoa->getPrimeiroNome() . "',
        sobreNome='" . $pessoa->getSobreNome() . "',
        sexo='" . $pessoa->getSexo() . "',
        cpf='" . $pessoa->getCpf() . "',
        telefoneContato='" . $pessoa->getTelefoneContato() . "'
        WHERE id='". $pessoa->getId() ."'";
        mysql_query($sql) or die(mysql_error());
    }

    // deleteUserDAC data from Pessoa in database.
    public static function deleteUserDAC($pessoa) 
    {
        include_once 'conexao.php';
        $sql = "deleteUserDAC FROM `pessoas` WHERE id=";
        mysql_query($sql) or die(mysql_error());
    }

    // Recover data from database to Pessoa.
    public static function recoverUserDAC($pessoa, $id) 
    {
        include_once 'conexao.php';
        $sql = "SELECT * FROM pessoas WHERE id=$id";
        $resultado = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($resultado);

        if (mysql_num_rows($resultado)==1){
           $pessoa->setPrimeiroNome($row['primeiroNome']);
           $pessoa->setSobreNome($row['sobreNome']);
           $pessoa->setEmail($row['email']);
           $pessoa->setTelefoneContato($row['telefoneContato']);
           $pessoa->setCpf($row['cpf']);
           $pessoa->setId($row['id']);
           //$pessoa->setDataNasc($row['dataNasc']);
           //$pessoa->setImage($row['image']);
           return 1;
        }else{
            return NULL;
        }
    }

    public static function verifyDisposition($email) 
    {
        include_once 'conexao.php';
        $sql = "SELECT email FROM pessoas WHERE email='$email'";
        $result = mysql_query($sql);
        if (mysql_num_rows($result) == 0) {
            return 1;
        } else {
            return 0;
        }
    }

}