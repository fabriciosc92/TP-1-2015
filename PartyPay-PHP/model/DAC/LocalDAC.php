<?php

/**
 * Class name: LocalDac
 * Class to connect Local to the database
*/

class LocalDAC 
{

    // Insert data from Local into database.
    public static function insertLocalDAC(Local $local) 
    {
        include_once 'connection.php';
        $sql = "INSERT INTO `places`(`id`, `eventAddress`, `coordenadasGoogleMaps`, 
            `eventLocalName`, `addressNumber`, `addressComplement`, `eventNeighborhood`, `eventCity`, `localCep`, `eventCountry`, 
            `eventLocalPictures`, `eventState`,`localMiniature`) 
            VALUES (NULL,'" . $local->getEventAddress() . "','"
                . $local->getGoogleMapsCoordanate() . "','"
                . $local->getEventLocalName() . "','"
                . $local->getAddressNumber() . "','"
                . $local->getAddressComplement() . "','"
                . $local->getEventNeighborhood() . "','"
                . $local->getEventCity() . "','"
                . $local->getLocalCep() . "','"
                . $local->getEventCountry() . "','"
                . $local->getEventLocalPictures() . "','"
                . $local->getEventState() . "','"
                . $local->getLocalMiniature() . "')";
        mysql_query($sql) or die(mysql_error());
        $RES = mysql_query("SELECT LAST_INSERT_ID()");
        $mat = mysql_fetch_array($RES);
        mysql_close($connection);

        return $mat['0'];
    }

    // Update data from Local in database.
    public static function updateInformationDAC(Local $local, $atributo, $atributoNovo) 

        include_once 'connection.php';
        $sql = "UPDATE `places` SET `$atributo`=$atributoNovo WHERE id=" . $local->getId();
        mysql_query($sql) or die(mysql_error());
        mysql_close($connection);
    }

    // deleteLocalDAC data from Local in database.
    public static function deleteLocalDAC(Local $local) 
    {
        include_once 'connection.php';
        $sql = "deleteLocalDAC FROM `places` WHERE id=" . $local->getId();
        mysql_query($sql) or die(mysql_error());
        mysql_close($connection);
    }

}