-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: devscbdb01:9306
-- Generation Time: Nov 10, 2020 at 10:19 PM
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
-- Table structure for table `YTU_REQFILE`
--

CREATE TABLE `YTU_REQFILE` (
  `RECID` int(11) NOT NULL,
  `MOBILENO` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CASEID` int(11) NOT NULL,
  `FILEDESC` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `AGENTID` int(11) NOT NULL,
  `CREATED_DT` datetime NOT NULL,
  `EXPIRED_DT` datetime NOT NULL,
  `RECSTATUS` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `YTU_REQFILE`
--

INSERT INTO `YTU_REQFILE` (`RECID`, `MOBILENO`, `CASEID`, `FILEDESC`, `AGENTID`, `CREATED_DT`, `EXPIRED_DT`, `RECSTATUS`) VALUES
(1, '0822671922', 163216, 'บัตรประชาชนที่มีการปิดบังข้อมูลบางส่วนแล้ว,สำเนาบัตรประชาชน,สำเนาทะเบียนบ้าน', 3, '2020-11-07 14:19:11', '2020-11-12 14:19:11', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `YTU_REQFILE`
--
ALTER TABLE `YTU_REQFILE`
  ADD PRIMARY KEY (`RECID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `YTU_REQFILE`
--
ALTER TABLE `YTU_REQFILE`
  MODIFY `RECID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
