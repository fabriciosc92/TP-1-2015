<?php

/**
 * Class name: LocalEventDAC
 * Class to connect LocalEventDAC to the database.
 */
class LocalEventDAC
 
{

    // Insert data from LocalEventDAC
 into database.
    public static function insertLocalEventDac($eventoId, $localId) 
    {
        require 'conexao.php';
        $sql = "INSERT INTO `locaisdoseventos` (
            `id` ,
            `localID` ,
            `eventoID`
            )
            VALUES (
            NULL ,  '$localId',  '$eventoId'
            );";
        mysql_query($sql) or die(mysql_error() . "LocalEventDAC
DAC.php inserçao de dados na tabela");
        mysql_close($conexao);
    }

}