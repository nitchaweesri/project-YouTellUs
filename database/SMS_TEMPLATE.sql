-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: devscbdb01:9306
-- Generation Time: Nov 25, 2020 at 01:54 PM
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
-- Table structure for table `SMS_TEMPLATE`
--

CREATE TABLE `SMS_TEMPLATE` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MESSAGE` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `STATUS` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `GROUPS` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ORDERS` int(11) NOT NULL,
  `CREATED_DT` datetime NOT NULL DEFAULT current_timestamp(),
  `MODIFIED_DT` datetime NOT NULL DEFAULT current_timestamp(),
  `MODIFIED_USER` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `SMS_TEMPLATE`
--

INSERT INTO `SMS_TEMPLATE` (`ID`, `TITLE`, `MESSAGE`, `STATUS`, `GROUPS`, `ORDERS`, `CREATED_DT`, `MODIFIED_DT`, `MODIFIED_USER`) VALUES
(1, 'ข้อความทดสอบ', 'ขอบคุณณที่ใช้บริการครับ จากแอดมินฟิคคนดี ธรณีชูชัย', 'A', 'B', 1, '2020-11-25 12:52:52', '2020-11-25 12:52:52', -1),
(2, 'ข้อความทดสอบ2', 'สวัสดีวันจันทร์ จากแอดมินฟิคคนดี ธรณีชูชัย', 'A', 'A', 2, '2020-11-25 12:52:52', '2020-11-25 12:52:52', -1),
(3, 'ทดสอบ1', 'ดำเนินการเรียบร้อย ขอบคุณที่ใช้บริการ', 'A', 'B', 5, '2020-11-25 13:01:04', '2020-11-25 13:01:04', -1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `SMS_TEMPLATE`
--
ALTER TABLE `SMS_TEMPLATE`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `SMS_TEMPLATE`
--
ALTER TABLE `SMS_TEMPLATE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
