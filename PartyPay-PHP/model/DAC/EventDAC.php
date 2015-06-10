<?php

/**
 * Class name: EventDac
 * Class to connect event to the database.
 */
class EventDac 
{

    // Inserts data from event into database.
    public static function insertEventDAC(event $event) 
    {
        include_once 'connection.php';
        $sql = "INSERT INTO `events`(`eventName`, 
            `eventBeginDate`, `eventEndDate`, `eventImage`,
            `masculineEventPrice`, `femaleEventPrice`, `eventrganizerID`,
            `facebookEventPage`, `id`,
            `eventCriationDate`, `eventDescription`, `numberOfTickets`,
            `beginHour`, `endHour`, `eventMiniature`,`ageClassification`) VALUES ('";
        $sql.=$event->getEventName() . "','";
        $sql.=$event->getEventBeginDate() . "','";
        $sql.=$event->getEventEndDate() . "','";
        $sql.=$event->getEventImage() . "','";
        $sql.=$event->getMasculineEventPrice() . "','";
        $sql.=$event->getFemaleEventPrice() . "','";
        $sql.=$event->getEventOrganizer() . "','";
        $sql.=$event->getFacebookEventPage() . "', NULL,'";
        $sql.=$event->getEventCriationDate() . "','";
        $sql.=$event->getEventDescription() . "','";
        $sql.=$event->getNumberOfTickets() . "','";
        $sql.=$event->getBeginHour() . "','";
        $sql.=$event->getEndHour() . "','";
        $sql.=$event->getEventMiniature() . "','";
        $sql.=$event->getAgeClassification() . "');";

        mysql_query($sql) or die(mysql_error());


        $RES = mysql_query("SELECT LAST_INSERT_ID()");
        $mat = mysql_fetch_array($RES);
        mysql_close($connection);

        return $mat['0'];
    }

    // Update data in database from  event.
    public static function updateInformationEventDAC($event, $atributo, $atributoNovo) 
    {
        include_once 'connection.php';
        $sql = "UPDATE `events` SET `$atributo`=$atributoNovo WHERE id=" . $event->getId();
        mysql_query($sql) or die(mysql_error());
        mysql_close($connection);
    }

    // deleteEventDAC data from database.
    public static function deleteEventDAC($event) 
    {
        include_once 'connection.php';
        $sql = "deleteEventDAC FROM `events` WHERE id=" . $event->getId();
        mysql_query($sql) or die(mysql_error());
        mysql_close($connection);
    }

    // Recover data from database to event.
    public static function recoveryEventDAC($event, $id) 
    {
        include_once 'connection.php';
        $sql = "SELECT * FROM events WHERE id=$id";
        $resultado = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($resultado);

        if (mysql_num_rows($resultado) == 1) {
            $event->setEventName($row['eventName']);
            $event->setEventBeginDate($row['eventBeginDate']);
            $event->setEventEndDate($row['eventEndDate']);
            $event->setEventImage($row['eventImage']);
            $event->setMasculineEventPrice($row['masculineEventPrice']);
            $event->setFemaleEventPrice($row['femaleEventPrice']);
            $event->seteventpromoter($row['eventpromoterID']);
            $event->setFacebookEventPage($row['facebookEventPage']);
            $event->setEventCriationDate($row['eventCriationDate']);
            $event->setEventDescription($row['eventDescription']);
            $event->setNumberOfTickets($row['numberOfTickets']);
            $event->setBeginHour($row['beginHour']);
            $event->setEndHour($row['endHour']);
            $event->setEventMiniature($row['eventMiniature']);
            $event->setAgeClassification($row['ageClassification']);

            return 1;
        } else {
            return NULL;
        }
        mysql_close($connection);
    }

}