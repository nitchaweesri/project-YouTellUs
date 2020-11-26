-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: devscbdb01:9306
-- Generation Time: Nov 25, 2020 at 01:56 PM
-- Server version: 10.2.25-MariaDB-log
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scbytu_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `ONLINECOMPLAINT`
--
CREATE TABLE `ONLINECOMPLAINT` (
  `OCID` int(11) NOT NULL,
  `CASEID` int(11) NOT NULL,
  `FEEDTYPE` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FEEDSUBTYPE` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PROJECTTYPE` int(1) NOT NULL DEFAULT 1,
  `CASESTATUS` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CLOSEDTYPE` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CLOSEDCODE` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CREATED_DT` datetime NOT NULL DEFAULT current_timestamp(),
  `ADDED_DT` datetime NOT NULL DEFAULT current_timestamp(),
  `SLADUE_DT` datetime DEFAULT NULL,
  `OLADUE_DT` datetime DEFAULT NULL,
  `RPTEXCL` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `EXCLREASON` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `AGENTID` int(11) NOT NULL DEFAULT -1,
  `ACCEPTED_DT` datetime DEFAULT NULL,
  `FINISHED_DT` timestamp NULL DEFAULT NULL,
  `FIRSTREPLYDT` datetime DEFAULT NULL,
  `TOTALHANDLINGSEC` int(11) NOT NULL DEFAULT 0,
  `COMPANY` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IDCOMPANY` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FULLNAME` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IDCARD` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `POSITION` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FULLNAME2` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IDCARD2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PHONE` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EMAIL` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RELATIONSHIP` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TEXTFEEDSUBTYPE` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `PRODUCT` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IDPRODUCT` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ISSUE` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `REQUEST` mediumint(9) NOT NULL,
  `ATTACHMENT` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ONLINECOMPLAINT`
--
ALTER TABLE `ONLINECOMPLAINT`
  ADD PRIMARY KEY (`OCID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ONLINECOMPLAINT`
--
ALTER TABLE `ONLINECOMPLAINT`
  MODIFY `OCID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
