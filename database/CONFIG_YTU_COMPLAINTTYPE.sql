-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: devscbdb01:9306
-- Generation Time: Nov 05, 2020 at 09:21 AM
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
-- Table structure for table `CONFIG_YTU_COMPLAINTTYPE`
--

CREATE TABLE `CONFIG_YTU_COMPLAINTTYPE` (
  `COMPLAINTCODE` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `COMPLAINTTITLE_TH` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `COMPLAINTTITLE_EN` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CONFIG_YTU_COMPLAINTTYPE`
--

INSERT INTO `CONFIG_YTU_COMPLAINTTYPE` (`COMPLAINTCODE`, `COMPLAINTTITLE_TH`, `COMPLAINTTITLE_EN`) VALUES
('GN', 'เรื่องร้องเรียนทั่วไป', 'General Complaint'),
('JP', 'ร้องเรียนในนามนิติบุคคล', 'Complain on behalf of a legal entity'),
('OT', 'ร้องเรียนแทนบุคคลอื่น', 'Complain on behalf of another person');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CONFIG_YTU_COMPLAINTTYPE`
--
ALTER TABLE `CONFIG_YTU_COMPLAINTTYPE`
  ADD PRIMARY KEY (`COMPLAINTCODE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
