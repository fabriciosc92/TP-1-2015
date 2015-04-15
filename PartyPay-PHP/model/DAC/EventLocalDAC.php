<?php

/**
 * Class name: EventLocaDAC
 * Class to connect EventLocaDAC to the database.
 */
class EventLocaDAC 
{

    // Insert data from EventLocaDAC
 into database.
    public static function insertEventLocaDAC($eventoId, $localId) 
    {
        require 'connection.php';
        $sql = "INSERT INTO `locaisdoseventos` (
            `id` ,
            `localID` ,
            `eventoID`
            )
            VALUES (
            NULL ,  '$localId',  '$eventoId'
            );";
        mysql_query($sql) or die(mysql_error() . "EventLocaDAC
DAC.php inserçao de dados na tabela");
        mysql_close($connection);
    }

}