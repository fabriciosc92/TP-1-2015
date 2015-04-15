<?php

/**
 * Class name: EventDac
 * Class to connect Evento to the database.
 */
class EventDac 
{

    // Inserts data from Evento into database.
    public static function insertEventDAC(Evento $evento) 
    {
        include_once 'connection.php';
        $sql = "INSERT INTO `eventos`(`eventName`, 
            `eventBeginDate`, `eventEndDate`, `eventImage`,
            `masculineEventPrice`, `femaleEventPrice`, `eventOrganizerID`,
            `facebookEventPage`, `id`,
            `eventCriationDate`, `eventDescription`, `numberOfTickets`,
            `beginHour`, `endHour`, `eventMiniature`,`ageClassification`) VALUES ('";
        $sql.=$evento->getEventName() . "','";
        $sql.=$evento->getEventBeginDate() . "','";
        $sql.=$evento->getEventEndDate() . "','";
        $sql.=$evento->getEventImage() . "','";
        $sql.=$evento->getMasculineEventPrice() . "','";
        $sql.=$evento->getFemaleEventPrice() . "','";
        $sql.=$evento->getEventOrganizer() . "','";
        $sql.=$evento->getFacebookEventPage() . "', NULL,'";
        $sql.=$evento->getEventCriationDate() . "','";
        $sql.=$evento->getEventDescription() . "','";
        $sql.=$evento->getNumberOfTickets() . "','";
        $sql.=$evento->getBeginHour() . "','";
        $sql.=$evento->getEndHour() . "','";
        $sql.=$evento->getEventMiniature() . "','";
        $sql.=$evento->getAgeClassification() . "');";

        mysql_query($sql) or die(mysql_error());


        $RES = mysql_query("SELECT LAST_INSERT_ID()");
        $mat = mysql_fetch_array($RES);
        mysql_close($connection);

        return $mat['0'];
    }

    // Update data in database from  Evento.
    public static function updateInformationEventDAC($evento, $atributo, $atributoNovo) 
    {
        include_once 'connection.php';
        $sql = "UPDATE `eventos` SET `$atributo`=$atributoNovo WHERE id=" . $evento->getId();
        mysql_query($sql) or die(mysql_error());
        mysql_close($connection);
    }

    // deleteEventDAC data from database.
    public static function deleteEventDAC($evento) 
    {
        include_once 'connection.php';
        $sql = "deleteEventDAC FROM `eventos` WHERE id=" . $evento->getId();
        mysql_query($sql) or die(mysql_error());
        mysql_close($connection);
    }

    // Recover data from database to Evento.
    public static function recoveryEventDAC($evento, $id) 
    {
        include_once 'connection.php';
        $sql = "SELECT * FROM eventos WHERE id=$id";
        $resultado = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($resultado);

        if (mysql_num_rows($resultado) == 1) {
            $evento->setEventName($row['eventName']);
            $evento->setEventBeginDate($row['eventBeginDate']);
            $evento->setEventEndDate($row['eventEndDate']);
            $evento->setEventImage($row['eventImage']);
            $evento->setMasculineEventPrice($row['masculineEventPrice']);
            $evento->setFemaleEventPrice($row['femaleEventPrice']);
            $evento->setEventOrganizer($row['eventOrganizerID']);
            $evento->setFacebookEventPage($row['facebookEventPage']);
            $evento->setEventCriationDate($row['eventCriationDate']);
            $evento->setEventDescription($row['eventDescription']);
            $evento->setNumberOfTickets($row['numberOfTickets']);
            $evento->setBeginHour($row['beginHour']);
            $evento->setEndHour($row['endHour']);
            $evento->setEventMiniature($row['eventMiniature']);
            $evento->setAgeClassification($row['ageClassification']);

            return 1;
        } else {
            return NULL;
        }
        mysql_close($connection);
    }

}