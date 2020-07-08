-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 11, 2020 at 07:10 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `db_medic`
--

-- --------------------------------------------------------

--
-- Table structure for table `kartotekar`
--

CREATE TABLE `kartotekar` (
  `UID` varchar(100) NOT NULL,
  `USERWORD` varbinary(500) NOT NULL,
  `USERPASS` varbinary(500) NOT NULL,
  `KEYENCR` varchar(50) NOT NULL,
  `LOGEDIN` int(2) NOT NULL DEFAULT '0',
  `TYPE` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kartotekar`
--

INSERT INTO `kartotekar` (`UID`, `USERWORD`, `USERPASS`, `KEYENCR`, `LOGEDIN`, `TYPE`) VALUES
('E79Xxjm2m86zgK9wZEOqxQnuBturMEyVwGJK', 0xae113e742e7b82ddc50bb08799e836be, 0x0e73be00f79906107b7010277b88243a, '3zbnUAWwXD6bPkX5kBHFAgZ8XhiwAVvcwUPb', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicuser`
--

CREATE TABLE `medicuser` (
  `ID` int(10) NOT NULL,
  `FNAME` varchar(200) NOT NULL,
  `LNAME` varchar(200) NOT NULL,
  `USEMAIL` varchar(100) NOT NULL,
  `USEPASS` varchar(100) NOT NULL,
  `SALUTE` varchar(5) NOT NULL,
  `MAINKEY` varbinary(200) NOT NULL,
  `VERIF` varchar(100) DEFAULT NULL,
  `TYPE` int(2) NOT NULL DEFAULT '2',
  `NOTES` varchar(2000) DEFAULT NULL,
  `PHONE` varchar(30) DEFAULT NULL,
  `ADRES` varchar(500) DEFAULT NULL,
  `REGISTRATION` varchar(10) NOT NULL,
  `VERIFICATION` varchar(10) DEFAULT NULL,
  `TERMS` varchar(10) DEFAULT NULL,
  `DOB` varchar(10) DEFAULT NULL,
  `ZIP` varchar(20) DEFAULT NULL,
  `CITY` varchar(100) DEFAULT NULL,
  `INSURANCE` varchar(50) DEFAULT NULL,
  `INSUNO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicuser`
--

INSERT INTO `medicuser` (`ID`, `FNAME`, `LNAME`, `USEMAIL`, `USEPASS`, `SALUTE`, `MAINKEY`, `VERIF`, `TYPE`, `NOTES`, `PHONE`, `ADRES`, `REGISTRATION`, `VERIFICATION`, `TERMS`, `DOB`, `ZIP`, `CITY`, `INSURANCE`, `INSUNO`) VALUES
(25, 'Vladimir', 'Uzelac', 'uzelac92@yahoo.com', 'vladimirce', 'Mr', 0x930c76ce25a98d22b3b44ef18f56201ed67fad83ef01bf26a27ad44633120fa68d90c1e95955fb4335de4321fd122a41, '', 2, 'asdasd', '+381638171366', '123456789', '04.03.2020', '04.03.2020', '04.03.2020', '03.04.1992', '21000', 'Novi Sad', '123123', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kartotekar`
--
ALTER TABLE `kartotekar`
  ADD PRIMARY KEY (`UID`);

--
-- Indexes for table `medicuser`
--
ALTER TABLE `medicuser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicuser`
--
ALTER TABLE `medicuser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
