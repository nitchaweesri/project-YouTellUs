-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2020 at 10:17 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.23

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
-- Table structure for table `CONFIG_YTU_PRODUCT`
--

CREATE TABLE `CONFIG_YTU_PRODUCT` (
  `PRODUCTID` int(11) NOT NULL,
  `COMPLAINTCODE` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PRODUCTCODE` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PRODUCTTITLE_TH` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PRODUCTTITLE_EN` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CONFIG_YTU_PRODUCT`
--

INSERT INTO `CONFIG_YTU_PRODUCT` (`PRODUCTID`, `COMPLAINTCODE`, `PRODUCTCODE`, `PRODUCTTITLE_TH`, `PRODUCTTITLE_EN`) VALUES
(1, 'GN', 'DP', 'บัญชีเงินฝาก', 'Deposit Account'),
(2, 'GN', 'CC', 'บัตรเครดิต', 'Credit Card'),
(3, 'GN', 'PL', 'สินเชื่อส่วนบุคคล', 'Personal loan'),
(4, 'OT', 'DP', 'บัญชีเงินฝาก', 'Deposit Account'),
(5, 'OT', 'CC', 'บัตรเครดิต', 'Credit Card'),
(6, 'OT', 'PL', 'สินเชื่อส่วนบุคคล', 'Personal loan'),
(7, 'JP', 'DP', 'บัญชีเงินฝาก', 'Deposit Account'),
(8, 'JP', 'CC', 'บัตรเครดิต', 'Credit Card'),
(9, 'JP', 'PL', 'สินเชื่อส่วนบุคคล', 'Personal loan'),
(10, 'GN', 'IE', 'อื่น ๆ', 'Other'),
(11, 'JP', 'IE', 'อื่น ๆ', 'Other'),
(12, 'OT', 'IE', 'อื่น ๆ', 'Other');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CONFIG_YTU_PRODUCT`
--
ALTER TABLE `CONFIG_YTU_PRODUCT`
  ADD PRIMARY KEY (`PRODUCTID`),
  ADD KEY `COMPLAINTCODE` (`COMPLAINTCODE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CONFIG_YTU_PRODUCT`
--
ALTER TABLE `CONFIG_YTU_PRODUCT`
  MODIFY `PRODUCTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
