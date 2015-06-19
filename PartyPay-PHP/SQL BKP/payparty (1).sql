-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Server: 127.0.0.1
-- Generation Time: 
-- Server Version: 5.5.27
-- PHP version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT**/;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS**/;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION**/;
/*!40101 SET NAMES utf8**/;

--
-- Database: `partypay`
--

-- --------------------------------------------------------

--
-- Table Structure `credicCards`
--

CREATE TABLE IF NOT EXISTS `creditCards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `securityCode` varchar(50) NOT NULL,
  `validity` varchar(50) NOT NULL,
  `holdersName` varchar(50) NOT NULL,
  `holdersAddress` varchar(50) NOT NULL,
  `holdersPhone` varchar(50) NOT NULL,
  `personID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table Structure `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `name` varchar(50) NOT NULL,
  `startingDate` date NOT NULL,
  `endingDate` date NOT NULL,
  `image` varchar(50) NOT NULL,
  `menPrice` float NOT NULL,
  `womenPrice` float NOT NULL,
  `promoterID` int(11) NOT NULL,
  `placeID` int(11) DEFAULT NULL,
  `facebookEventPage` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `numberOfTickets` int(11) NOT NULL,
  `startingTime` time NOT NULL,
  `endingTime` time NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `classification` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Extracting data form table `events`
--

INSERT INTO `events` (`name`, `startingDate`, `endingDate`, `image`, `menPrice`, `womenPrice`, `promoterID`, `placeID`, `facebookEventPage`, `id`, `creationDate`, `description`, `numberOfTickets`, `startingTime`, `endingTime`, `thumbnail`) VALUES
('as', '2013-06-06', '2013-06-15', '../view/images/1370319982.jpg', 12, 12, 3, 0, 'as', 18, '0000-00-00 00:00:00', 'as', 25, '00:00:16', '00:00:16', '../view/images/thumb1370319982.jpg'),
('as', '2013-06-06', '2013-06-15', '../view/images/1370322873.jpg', 12, 12, 3, 0, 'as', 19, '0000-00-00 00:00:00', 'as', 25, '00:00:16', '00:00:16', '../view/images/thumb1370322873.jpg');

-- --------------------------------------------------------

--
-- Table Structure `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL,
  `personID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `qr` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `validity` varchar(50) NOT NULL,
  `instructions` text NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'Inteira'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table Structure `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `GoogleMapsCordenates` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(5) NOT NULL,
  `complement` varchar(50) NOT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `photos` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Extracting data form table `places`
--

INSERT INTO `places` (`id`, `address`, `GoogleMapsCordenates`, `name`, `number`, `complement`, `neighborhood`, `city`, `country`, `zip`, `state`, `thumbnail`, `photos`) VALUES
(16, 'peknf', '', 'sapkljsdpa', '3413', 'açldknf', 'çadknf', 'açldkn', '~çknsd', '12333-333', '~pkenf', '../view/images/thumb1370320010.jpg', '../view/images/1370320010.jpg');

-- --------------------------------------------------------

--
-- Table Structure `eventsPlaces`
--

CREATE TABLE IF NOT EXISTS `eventsPlaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placeID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extracting data form table `eventsPlaces`
--

INSERT INTO `eventsPlaces` (`id`, `placeID`, `eventID`) VALUES
(9, 16, 18);

-- --------------------------------------------------------

--
-- Table Structure `promoters`
--

CREATE TABLE IF NOT EXISTS `promoters` (
  `cnpj` varchar(50) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `bankingInformation` varchar(50) NOT NULL,
  `contactPhone` varchar(50) NOT NULL,
  `tradingName` varchar(50) NOT NULL,
  `website` varchar(50) NOT NULL,
  `facebookFanPage` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table Structure `promotersMakeEvents`
--

CREATE TABLE IF NOT EXISTS `promotersMakeEvents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promoterID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table Structure `participants`
--

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(11) NOT NULL,
  `personID` int(11) NOT NULL,
  `cpf` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table Structure `todaysEventsParticipants`
--

CREATE TABLE IF NOT EXISTS `todaysEventsParticipants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `participantsID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table Structure `participantsHaveTickets`
--

CREATE TABLE IF NOT EXISTS `participantsHaveTickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticketID` int(11) NOT NULL,
  `participantID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table Structure `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `firstName` varchar(50) NOT NULL,
  `SurName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `confirmedEmail` tinyint(1) NOT NULL,
  `confirmationCode` varchar(50) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `contactPhone` varchar(50) NOT NULL,   
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extracting data form table `people`
--

INSERT INTO `people` (`firstName`, `surName`, `email`, `id`, `password`, `gender`, `confirmedEmail`, `confirmationCode`, `cpf`, `contactPhone`) VALUES
('Andre', 'Ferraz', '234', 3, '202cb962ac59075b964b07152d234b70', 'Masculino', 0, '', '111.111.111-11', '(11) 1111-1111');

-- --------------------------------------------------------

--
-- Table Structure `peopleAttendedTheEvent`
--

CREATE TABLE IF NOT EXISTS `peopleAttendedTheEvent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `participantID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table Structure `peopleHaveCreditCards`
--

CREATE TABLE IF NOT EXISTS `peopleHaveCreditCards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personID` int(11) NOT NULL,
  `creditCardID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT**/;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS**/;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION**/;

-- --------------------------------------------------------
