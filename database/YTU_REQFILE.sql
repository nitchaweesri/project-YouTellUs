-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 07:35 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `REQFILEID` int(11) NOT NULL,
  `CASEID` text NOT NULL,
  `FILEREQ` mediumtext NOT NULL,
  `EXPIRYDATE` date NOT NULL,
  `STATUS` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `YTU_REQFILE`
--

INSERT INTO `YTU_REQFILE` (`REQFILEID`, `CASEID`, `FILEREQ`, `EXPIRYDATE`, `STATUS`) VALUES
(1, '163215', 'สำเนาบัตรประชาชน,สำเนาทะเบียนบ้าน', '2020-11-14', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `YTU_REQFILE`
--
ALTER TABLE `YTU_REQFILE`
  ADD PRIMARY KEY (`REQFILEID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `YTU_REQFILE`
--
ALTER TABLE `YTU_REQFILE`
  MODIFY `REQFILEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
