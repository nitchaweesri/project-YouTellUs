-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: devscbdb01:9306
-- Generation Time: Nov 06, 2020 at 10:38 AM
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
-- Table structure for table `CASEINFO`
--

CREATE TABLE `CASEINFO` (
  `CASEID` int(11) NOT NULL,
  `FEEDID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEEDTYPE` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEEDSUBTYPE` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEEDACCOUNT` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEEDTITLE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEEDBODY` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEATURE01` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FEATURE02` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FEATURE03` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FEATURE04` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FEATURE05` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SOCIAL_CUSTID` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `SOCIAL_CUSTNAME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `CONTACTID` int(11) NOT NULL DEFAULT -7,
  `CREATED_DT` datetime NOT NULL DEFAULT current_timestamp(),
  `PRIORITYSCORE` int(11) NOT NULL DEFAULT 0,
  `SLASEC` int(5) NOT NULL DEFAULT 0,
  `SLADUE_DT` datetime DEFAULT NULL,
  `OLASEC` int(5) NOT NULL DEFAULT 0,
  `OLADUE_DT` datetime DEFAULT NULL,
  `ADDED_DT` datetime NOT NULL DEFAULT current_timestamp(),
  `LANGUAGE` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `FEEDPARENTID` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ISPARENTRESP` int(11) NOT NULL DEFAULT 0,
  `INTENTID` int(11) NOT NULL DEFAULT -1,
  `SUBINTENTID` int(11) NOT NULL DEFAULT -1,
  `INTENTION` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `INTENTION_CONF` int(11) NOT NULL DEFAULT 0,
  `SENTIMENT_VALUE` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `TARGETAGENTID` int(11) DEFAULT NULL,
  `RT_REASON` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `RP_STATUS` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'F',
  `FROMBOT` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `HASUPDATED` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `HASUPDATED_DT` datetime DEFAULT NULL,
  `RPTEXCL` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `EXCLREASON` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CASESTATUS` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `AGENTID` int(11) NOT NULL DEFAULT -1,
  `ACCEPTED_DT` datetime DEFAULT NULL,
  `FINISHED_DT` datetime DEFAULT NULL,
  `CLOSEDTYPE` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CLOSEDCODE` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CLOSEDDETAIL` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT '',
  `AUTOREPLY` int(11) NOT NULL DEFAULT -1,
  `AUTOREPLYDT` datetime DEFAULT NULL,
  `FIRSTREPLYDT` datetime DEFAULT NULL,
  `ANALYSEDDT` datetime DEFAULT NULL,
  `CONVERSESSIONID` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `CASETOPIC` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `LATESTPROCDT` datetime DEFAULT NULL,
  `TOTALHANDLINGSEC` int(11) NOT NULL DEFAULT 0,
  `FINBYBOTFLAG` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `BOTSTARTDT` datetime DEFAULT NULL,
  `BOTENDDT` datetime DEFAULT NULL,
  `BOTLASTRESPDT` datetime DEFAULT NULL,
  `BOTHUMANLASTRESPDT` datetime DEFAULT NULL,
  `SCBPRODUCT` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SCB topic reply 2',
  `SCBEMOTION` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'SCB topic reply 3',
  `CASETYPE` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'live/leave',
  `CURRVER` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PARAM_TEAM` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Forward to other team',
  `EMAILTYPE` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email out type(R/F)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Keep Social Case Information';

--
-- Dumping data for table `CASEINFO`
--

INSERT INTO `CASEINFO` (`CASEID`, `FEEDID`, `FEEDTYPE`, `FEEDSUBTYPE`, `FEEDACCOUNT`, `FEEDTITLE`, `FEEDBODY`, `FEATURE01`, `FEATURE02`, `FEATURE03`, `FEATURE04`, `FEATURE05`, `SOCIAL_CUSTID`, `SOCIAL_CUSTNAME`, `CONTACTID`, `CREATED_DT`, `PRIORITYSCORE`, `SLASEC`, `SLADUE_DT`, `OLASEC`, `OLADUE_DT`, `ADDED_DT`, `LANGUAGE`, `FEEDPARENTID`, `ISPARENTRESP`, `INTENTID`, `SUBINTENTID`, `INTENTION`, `INTENTION_CONF`, `SENTIMENT_VALUE`, `TARGETAGENTID`, `RT_REASON`, `RP_STATUS`, `FROMBOT`, `HASUPDATED`, `HASUPDATED_DT`, `RPTEXCL`, `EXCLREASON`, `CASESTATUS`, `AGENTID`, `ACCEPTED_DT`, `FINISHED_DT`, `CLOSEDTYPE`, `CLOSEDCODE`, `CLOSEDDETAIL`, `AUTOREPLY`, `AUTOREPLYDT`, `FIRSTREPLYDT`, `ANALYSEDDT`, `CONVERSESSIONID`, `CASETOPIC`, `LATESTPROCDT`, `TOTALHANDLINGSEC`, `FINBYBOTFLAG`, `BOTSTARTDT`, `BOTENDDT`, `BOTLASTRESPDT`, `BOTHUMANLASTRESPDT`, `SCBPRODUCT`, `SCBEMOTION`, `CASETYPE`, `CURRVER`, `PARAM_TEAM`, `EMAILTYPE`) VALUES
(131186, '93583426', 'PT', 'CM', 'BNK48', 'สวยมาก', '<strong>ความคิดเห็นที่ 18</strong><br/>สวยมาก', '', NULL, NULL, NULL, NULL, '1677390', 'สมาชิกหมายเลข 1677390', 106, '2020-07-11 13:58:29', 50, 1800, '2020-07-11 14:28:29', 1800, '2020-07-11 14:28:29', '2020-07-11 14:01:16', 'TH', '40050730', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131187, '30232011', 'PT', 'CR', 'BNK48', 'อ๋อ ใช่ๆ<br />\nถ้าชื่อชาวโชเชี่ยนนตั้งนี่ ไม่มีดีแน่ๆ ฮะ&nbsp;&nbsp;55', 'อ๋อ ใช่ๆ<br />\nถ้าชื่อชาวโชเชี่ยนนตั้งนี่ ไม่มีดีแน่ๆ ฮะ&nbsp;&nbsp;55', '', NULL, NULL, NULL, NULL, '399461', 'กินผักเพื่อสุขภาพแข็งแรง', 54, '2020-07-11 13:57:42', 50, 1800, '2020-07-11 14:27:42', 1800, '2020-07-11 14:27:42', '2020-07-11 14:01:17', 'TH', '93582169', 0, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131188, '93583403', 'PT', 'CM', 'BNK48', 'โถ่จี้&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เห็นแบบนี้&nbsp;&nbsp;เป้ ฉลาดนะด้านไวพริบ&nbsp;&nbsp;&nbsp;&nbsp; โตกว่าด้วยไม่แปลกที่โดนหลอก <img class=\"img-in-emotion\" title=\"เพี้ยนขำหนักมาก\" alt=\"เพี้ยนขำหนักมาก\" src=\"https://ptcdn.info/emoticon', '<strong>ความคิดเห็นที่ 8</strong><br/>โถ่จี้&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เห็นแบบนี้&nbsp;&nbsp;เป้ ฉลาดนะด้านไวพริบ&nbsp;&nbsp;&nbsp;&nbsp; โตกว่าด้วยไม่แปลกที่โดนหลอก <img class=\"img-in-emotion\" title=\"เพี้ยนขำหนักมาก\" alt=\"เพี้ยนขำหนักมาก\" src=\"https://ptcdn.info/emoticons/pantip_toy/pien2/555.png\" />', '', NULL, NULL, NULL, NULL, '179922', 'คนรักเกม', 156, '2020-07-11 13:55:44', 50, 1800, '2020-07-11 14:25:44', 1800, '2020-07-11 14:25:44', '2020-07-11 14:02:32', 'TH', '40050485', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131189, '93583398', 'PT', 'CM', 'BNK48', 'อ่าน ๆ ดูเหมือนแซะกันแบบเนียน ๆ', '<strong>ความคิดเห็นที่ 9</strong><br/>อ่าน ๆ ดูเหมือนแซะกันแบบเนียน ๆ', '', NULL, NULL, NULL, NULL, '1677390', 'สมาชิกหมายเลข 1677390', 106, '2020-07-11 13:54:52', 50, 1800, '2020-07-11 14:24:52', 1800, '2020-07-11 14:24:52', '2020-07-11 14:02:33', 'TH', '40050666', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131190, '93583467', 'PT', 'CM', 'BNK48', 'ยืมชื่อเมมมาแซะคนอื่น วนๆเวียนๆเดิมๆอ่ะแหล่ะพวก ปสด<br />\nใครเนียมผสมโรงนี่รู้เลยนะ', '<strong>ความคิดเห็นที่ 10</strong><br/>ยืมชื่อเมมมาแซะคนอื่น วนๆเวียนๆเดิมๆอ่ะแหล่ะพวก ปสด<br />\nใครเนียมผสมโรงนี่รู้เลยนะ', '', NULL, NULL, NULL, NULL, '5636452', 'สมาชิกหมายเลข 5636452', 2077, '2020-07-11 14:03:01', 50, 1800, '2020-07-11 14:33:01', 1800, '2020-07-11 14:33:01', '2020-07-11 14:04:58', 'TH', '40050666', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131191, '93583435', 'PT', 'CM', 'BNK48', 'ไม่ว่าเนื้อเพลงภาษาไทยจะออกมาดีหรือไม่ดี<br />\nก็รู้สึกดีใจที่ได้เห็นน้องๆ BNK และ CGM เอาเพลงที่ผมชื่นชอบมาร้องมาเต้นให้ได้ชมได้ฟังกัน<br />\nถึงอย่างไร สุดท้ายผมก็กลับไปฟัง ver.ญี่ปุ่น อยู่ดีครับ<br />\nที่ผ่านมามีเพียงเพลง ฤดูใหม่ ที่ผมชอบฟัง ver.ไทย มาก', '<strong>ความคิดเห็นที่ 14</strong><br/>ไม่ว่าเนื้อเพลงภาษาไทยจะออกมาดีหรือไม่ดี<br />\nก็รู้สึกดีใจที่ได้เห็นน้องๆ BNK และ CGM เอาเพลงที่ผมชื่นชอบมาร้องมาเต้นให้ได้ชมได้ฟังกัน<br />\nถึงอย่างไร สุดท้ายผมก็กลับไปฟัง ver.ญี่ปุ่น อยู่ดีครับ<br />\nที่ผ่านมามีเพียงเพลง ฤดูใหม่ ที่ผมชอบฟัง ver.ไทย มากกว่า', '', NULL, NULL, NULL, NULL, '5169380', 'สมาชิกหมายเลข 5169380', 4884, '2020-07-11 13:59:34', 50, 1800, '2020-07-11 14:29:34', 1800, '2020-07-11 14:29:34', '2020-07-11 14:06:22', 'TH', '40049351', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131192, '30232089', 'PT', 'CR', 'BNK48', 'รูปจูเน่เบลอจริงครับ สังเกตที่ตากับเส้นผม เหมือนความไวชัตเตอร์ต่ำไป หรือไม่จูเน่ก็สวยจนตากล้องมือสั่น', 'รูปจูเน่เบลอจริงครับ สังเกตที่ตากับเส้นผม เหมือนความไวชัตเตอร์ต่ำไป หรือไม่จูเน่ก็สวยจนตากล้องมือสั่น', '', NULL, NULL, NULL, NULL, '267890', 'มัคคะวารี', 1471, '2020-07-11 14:11:54', 50, 1800, '2020-07-11 14:41:54', 1800, '2020-07-11 14:41:54', '2020-07-11 14:14:22', 'TH', '93582714', 0, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131193, '93583557', 'PT', 'CM', 'BNK48', 'ท็อปพวกนี้มันเปลี่ยนได้ แต่ตำนานมันเปลี่ยนไม่ได้ครับ<br />\n<br />\nท็อปแล้วเลือกเพลงก็ไม่ได้ สุดท้ายแกรดออกไปก็ไม่ท็อปแล้ว<br />\nแต่ตำนานที่ได้เป็นเซ็นเตอร์เพลงดังที่สุดมันไม่เปลี่ยนไง<br />\nจะสิบยี่สิบปีก็ไม่เปลี่ยน จสลเลยเลือกที่จะเป็นตำนานยังไงล่ะ <br /', '<strong>ความคิดเห็นที่ 11</strong><br/>ท็อปพวกนี้มันเปลี่ยนได้ แต่ตำนานมันเปลี่ยนไม่ได้ครับ<br />\n<br />\nท็อปแล้วเลือกเพลงก็ไม่ได้ สุดท้ายแกรดออกไปก็ไม่ท็อปแล้ว<br />\nแต่ตำนานที่ได้เป็นเซ็นเตอร์เพลงดังที่สุดมันไม่เปลี่ยนไง<br />\nจะสิบยี่สิบปีก็ไม่เปลี่ยน จสลเลยเลือกที่จะเป็นตำนานยังไงล่ะ <br />\n<br />\nปล.ช่วยเปิดให้นะครับ กระทู้จะได้คึกคัก อิอิ', '', NULL, NULL, NULL, NULL, '5870222', 'สมาชิกหมายเลข 5870222', 7075, '2020-07-11 14:13:31', 50, 1800, '2020-07-11 14:43:31', 1800, '2020-07-11 14:43:31', '2020-07-11 14:14:23', 'TH', '40050666', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131194, '30232087', 'PT', 'CR', 'BNK48', 'จริงครับ ชอบยอดนู้นนี้ มาข่มคนอื่นเค้ามันน่าภูมิใจตรงไหนว่ะ', 'จริงครับ ชอบยอดนู้นนี้ มาข่มคนอื่นเค้ามันน่าภูมิใจตรงไหนว่ะ', '', NULL, NULL, NULL, NULL, '4559604', 'สมาชิกหมายเลข 4559604', 5348, '2020-07-11 14:11:43', 50, 1800, '2020-07-11 14:41:43', 1800, '2020-07-11 14:41:43', '2020-07-11 14:14:23', 'TH', '93582496', 0, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131195, '93583567', 'PT', 'CM', 'BNK48', 'เหอๆเป็นโอตะ สนุกจังเฟ้ยยยยยยย', '<strong>ความคิดเห็นที่ 12</strong><br/>เหอๆเป็นโอตะ สนุกจังเฟ้ยยยยยยย', '', NULL, NULL, NULL, NULL, '5752000', 'สมาชิกหมายเลข 5752000', 2353, '2020-07-11 14:15:00', 50, 1800, '2020-07-11 14:45:00', 1800, '2020-07-11 14:45:00', '2020-07-11 14:18:41', 'TH', '40050666', 1, -1, -1, '', 0, '', -1, '', 'F', 'N', 'N', NULL, 'N', NULL, 'N', -1, NULL, NULL, '', '', '', -1, NULL, NULL, NULL, '', '', NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CASEINFO`
--
ALTER TABLE `CASEINFO`
  ADD PRIMARY KEY (`CASEID`),
  ADD KEY `FEEDTYPE` (`FEEDTYPE`,`FEEDSUBTYPE`),
  ADD KEY `CREATED_DT` (`CREATED_DT`),
  ADD KEY `CASEID` (`CASEID`,`FEEDID`,`FEEDTYPE`,`FEEDSUBTYPE`,`FEEDACCOUNT`),
  ADD KEY `FEEDID` (`FEEDID`,`FEEDTYPE`,`FEEDSUBTYPE`,`FEEDACCOUNT`) USING BTREE,
  ADD KEY `FEEDTYPE_2` (`FEEDTYPE`,`SOCIAL_CUSTID`,`FEEDPARENTID`) USING BTREE,
  ADD KEY `FEEDPARENTID` (`FEEDTYPE`,`FEEDSUBTYPE`,`FEEDACCOUNT`,`FEEDPARENTID`) USING BTREE,
  ADD KEY `FEEDTYPEACCNT` (`FEEDTYPE`,`FEEDACCOUNT`) USING BTREE,
  ADD KEY `FINBYBOTFLAG` (`FINBYBOTFLAG`),
  ADD KEY `BOTSTARTDT` (`BOTSTARTDT`),
  ADD KEY `BOTENDDT` (`BOTENDDT`),
  ADD KEY `RPTEXCL` (`RPTEXCL`),
  ADD KEY `FINISHED_DT` (`FINISHED_DT`),
  ADD KEY `CASESTATUS` (`CASESTATUS`),
  ADD KEY `QRYIDXC01` (`FEEDTYPE`,`FEEDPARENTID`,`SOCIAL_CUSTID`),
  ADD KEY `QRYIDXC02` (`FEEDTYPE`,`FEEDACCOUNT`,`SOCIAL_CUSTID`,`CASESTATUS`),
  ADD KEY `HASUPDATED` (`HASUPDATED`),
  ADD KEY `QRYIDXC03` (`FEEDTYPE`,`FEEDPARENTID`,`CASESTATUS`),
  ADD KEY `ACCEPTED_DT` (`ACCEPTED_DT`),
  ADD KEY `CURRLIVESTATUS` (`CASEID`,`CURRVER`,`INTENTION`,`CASETYPE`),
  ADD KEY `FEEDPARENT` (`FEEDTYPE`,`FEEDPARENTID`),
  ADD KEY `RT_REASON` (`RT_REASON`),
  ADD KEY `RP_STATUS` (`RP_STATUS`),
  ADD KEY `CIFGRP01` (`CREATED_DT`,`CASEID`,`AGENTID`,`CASESTATUS`),
  ADD KEY `SOCIAL_CUSTID` (`SOCIAL_CUSTID`),
  ADD KEY `AGENTID` (`AGENTID`),
  ADD KEY `CIFGRP02` (`CREATED_DT`,`CASESTATUS`),
  ADD KEY `CIFGRP03` (`FEEDTYPE`,`FEEDSUBTYPE`,`FEEDACCOUNT`),
  ADD KEY `CIFGRP04` (`CASEID`,`AGENTID`),
  ADD KEY `CIFGRP05` (`CREATED_DT`,`SOCIAL_CUSTNAME`,`CASESTATUS`),
  ADD KEY `FEEDTYPE_3` (`FEEDTYPE`),
  ADD KEY `FEEDSUBTYPE` (`FEEDSUBTYPE`),
  ADD KEY `FEEDACCOUNT` (`FEEDACCOUNT`),
  ADD KEY `TARGETAGENTID` (`TARGETAGENTID`),
  ADD KEY `SOCIAL_CUSTNAME` (`SOCIAL_CUSTNAME`),
  ADD KEY `INTENTID` (`INTENTID`),
  ADD KEY `QRY_ALERTSLA` (`CREATED_DT`,`CASESTATUS`,`SLADUE_DT`,`FEEDTYPE`,`FEEDSUBTYPE`,`RPTEXCL`),
  ADD KEY `CASELIST01` (`FEEDTYPE`,`FEEDACCOUNT`,`CASESTATUS`,`CREATED_DT`,`AGENTID`) USING BTREE,
  ADD KEY `WAITINGCASE` (`CASESTATUS`,`HASUPDATED`,`FEATURE03`) USING BTREE,
  ADD KEY `CONTACTID` (`CONTACTID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CASEINFO`
--
ALTER TABLE `CASEINFO`
  MODIFY `CASEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163217;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
