<?php

/**
 * Class name: EventLocaDAC
 * Class to connect EventLocaDAC to the database.
*/

class EventLocaDAC 
{

    //Insert data from EventLocaDAC into database.
    public static function insertEventLocalDAC($eventoId, $localId) 
    {
        require 'connection.php';
        $sql = "INSERT INTO `eventPlaces` (
            `id` ,
            `placeID` ,
            `eventID`
            )
            VALUES (
            NULL ,  '$localId',  '$eventoId'
            );";
        mysql_query($sql) or die(mysql_error() . "EventLocaDACDAC.php table data insertion");
        mysql_close($connection);
    }

}