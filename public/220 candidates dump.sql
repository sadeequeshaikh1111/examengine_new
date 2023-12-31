-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2021 at 08:07 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam_engine`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `reg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `node` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qpset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_qn` int(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`reg_no`, `name`, `node`, `status`, `dob`, `time`, `qpset`, `marks`, `current_qn`, `created_at`, `updated_at`) VALUES
('1', 'candidate 1', 'C1', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('10', 'candidate 10', 'C10', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('100', 'candidate 100', 'C100', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('101', 'candidate 101', 'C101', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('102', 'candidate 102', 'C102', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('103', 'candidate 103', 'C103', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('104', 'candidate 104', 'C104', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('105', 'candidate 105', 'C105', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('106', 'candidate 106', 'C106', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('107', 'candidate 107', 'C107', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('108', 'candidate 108', 'C108', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('109', 'candidate 109', 'C109', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('11', 'candidate 11', 'C11', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('110', 'candidate 110', 'C110', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('111', 'candidate 111', 'C111', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('112', 'candidate 112', 'C112', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('113', 'candidate 113', 'C113', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('114', 'candidate 114', 'C114', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('115', 'candidate 115', 'C115', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('116', 'candidate 116', 'C116', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('117', 'candidate 117', 'C117', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('118', 'candidate 118', 'C118', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('119', 'candidate 119', 'C119', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('12', 'candidate 12', 'C12', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('120', 'candidate 120', 'C120', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('121', 'candidate 121', 'C121', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('122', 'candidate 122', 'C122', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('123', 'candidate 123', 'C123', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('124', 'candidate 124', 'C124', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:32', '2021-04-30 12:35:32'),
('125', 'candidate 125', 'C125', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('126', 'candidate 126', 'C126', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('127', 'candidate 127', 'C127', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('128', 'candidate 128', 'C128', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('129', 'candidate 129', 'C129', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('13', 'candidate 13', 'C13', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('130', 'candidate 130', 'C130', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('131', 'candidate 131', 'C131', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('132', 'candidate 132', 'C132', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('133', 'candidate 133', 'C133', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('134', 'candidate 134', 'C134', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('135', 'candidate 135', 'C135', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('136', 'candidate 136', 'C136', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('137', 'candidate 137', 'C137', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('138', 'candidate 138', 'C138', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('139', 'candidate 139', 'C139', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('14', 'candidate 14', 'C14', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('140', 'candidate 140', 'C140', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('141', 'candidate 141', 'C141', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('142', 'candidate 142', 'C142', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('143', 'candidate 143', 'C143', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('144', 'candidate 144', 'C144', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('145', 'candidate 145', 'C145', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('146', 'candidate 146', 'C146', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('147', 'candidate 147', 'C147', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('148', 'candidate 148', 'C148', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('149', 'candidate 149', 'C149', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('15', 'candidate 15', 'C15', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('150', 'candidate 150', 'C150', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('151', 'candidate 151', 'C151', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('152', 'candidate 152', 'C152', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:33', '2021-04-30 12:35:33'),
('153', 'candidate 153', 'C153', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('154', 'candidate 154', 'C154', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('155', 'candidate 155', 'C155', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('156', 'candidate 156', 'C156', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('157', 'candidate 157', 'C157', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('158', 'candidate 158', 'C158', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('159', 'candidate 159', 'C159', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('16', 'candidate 16', 'C16', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('160', 'candidate 160', 'C160', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('161', 'candidate 161', 'C161', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('162', 'candidate 162', 'C162', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('163', 'candidate 163', 'C163', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('164', 'candidate 164', 'C164', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('165', 'candidate 165', 'C165', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('166', 'candidate 166', 'C166', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('167', 'candidate 167', 'C167', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('168', 'candidate 168', 'C168', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('169', 'candidate 169', 'C169', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('17', 'candidate 17', 'C17', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('170', 'candidate 170', 'C170', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('171', 'candidate 171', 'C171', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('172', 'candidate 172', 'C172', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('173', 'candidate 173', 'C173', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('174', 'candidate 174', 'C174', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('175', 'candidate 175', 'C175', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('176', 'candidate 176', 'C176', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('177', 'candidate 177', 'C177', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('178', 'candidate 178', 'C178', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('179', 'candidate 179', 'C179', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('18', 'candidate 18', 'C18', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('180', 'candidate 180', 'C180', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:34', '2021-04-30 12:35:34'),
('181', 'candidate 181', 'C181', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('182', 'candidate 182', 'C182', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('183', 'candidate 183', 'C183', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('184', 'candidate 184', 'C184', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('185', 'candidate 185', 'C185', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('186', 'candidate 186', 'C186', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('187', 'candidate 187', 'C187', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('188', 'candidate 188', 'C188', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('189', 'candidate 189', 'C189', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('19', 'candidate 19', 'C19', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('190', 'candidate 190', 'C190', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('191', 'candidate 191', 'C191', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('192', 'candidate 192', 'C192', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('193', 'candidate 193', 'C193', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('194', 'candidate 194', 'C194', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('195', 'candidate 195', 'C195', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:35', '2021-04-30 12:35:35'),
('196', 'candidate 196', 'C196', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('197', 'candidate 197', 'C197', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('198', 'candidate 198', 'C198', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('199', 'candidate 199', 'C199', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('2', 'candidate 2', 'C2', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('20', 'candidate 20', 'C20', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('200', 'candidate 200', 'C200', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('201', 'candidate 201', 'C201', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('202', 'candidate 202', 'C202', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('203', 'candidate 203', 'C203', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('204', 'candidate 204', 'C204', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('205', 'candidate 205', 'C205', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('206', 'candidate 206', 'C206', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('207', 'candidate 207', 'C207', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('208', 'candidate 208', 'C208', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('209', 'candidate 209', 'C209', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('21', 'candidate 21', 'C21', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('210', 'candidate 210', 'C210', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('211', 'candidate 211', 'C211', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('212', 'candidate 212', 'C212', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('213', 'candidate 213', 'C213', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('214', 'candidate 214', 'C214', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('215', 'candidate 215', 'C215', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('216', 'candidate 216', 'C216', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:36', '2021-04-30 12:35:36'),
('217', 'candidate 217', 'C217', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:37', '2021-04-30 12:35:37'),
('218', 'candidate 218', 'C218', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:37', '2021-04-30 12:35:37'),
('219', 'candidate 219', 'C219', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:37', '2021-04-30 12:35:37'),
('22', 'candidate 22', 'C22', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('23', 'candidate 23', 'C23', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('24', 'candidate 24', 'C24', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('25', 'candidate 25', 'C25', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('26', 'candidate 26', 'C26', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('27', 'candidate 27', 'C27', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('28', 'candidate 28', 'C28', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('29', 'candidate 29', 'C29', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('3', 'candidate 3', 'C3', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('30', 'candidate 30', 'C30', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('31', 'candidate 31', 'C31', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('32', 'candidate 32', 'C32', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('33', 'candidate 33', 'C33', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('34', 'candidate 34', 'C34', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('35', 'candidate 35', 'C35', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('36', 'candidate 36', 'C36', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('37', 'candidate 37', 'C37', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('38', 'candidate 38', 'C38', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('39', 'candidate 39', 'C39', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('4', 'candidate 4', 'C4', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('40', 'candidate 40', 'C40', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('41', 'candidate 41', 'C41', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('42', 'candidate 42', 'C42', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('43', 'candidate 43', 'C43', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('44', 'candidate 44', 'C44', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('45', 'candidate 45', 'C45', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:28', '2021-04-30 12:35:28'),
('46', 'candidate 46', 'C46', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('47', 'candidate 47', 'C47', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('48', 'candidate 48', 'C48', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('49', 'candidate 49', 'C49', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('5', 'candidate 5', 'C5', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('50', 'candidate 50', 'C50', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('51', 'candidate 51', 'C51', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('52', 'candidate 52', 'C52', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('53', 'candidate 53', 'C53', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('54', 'candidate 54', 'C54', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('55', 'candidate 55', 'C55', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('56', 'candidate 56', 'C56', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('57', 'candidate 57', 'C57', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('58', 'candidate 58', 'C58', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('59', 'candidate 59', 'C59', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('6', 'candidate 6', 'C6', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('60', 'candidate 60', 'C60', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('61', 'candidate 61', 'C61', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('62', 'candidate 62', 'C62', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('63', 'candidate 63', 'C63', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('64', 'candidate 64', 'C64', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('65', 'candidate 65', 'C65', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('66', 'candidate 66', 'C66', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('67', 'candidate 67', 'C67', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('68', 'candidate 68', 'C68', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('69', 'candidate 69', 'C69', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('7', 'candidate 7', 'C7', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('70', 'candidate 70', 'C70', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:29', '2021-04-30 12:35:29'),
('71', 'candidate 71', 'C71', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('72', 'candidate 72', 'C72', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('73', 'candidate 73', 'C73', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('74', 'candidate 74', 'C74', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('75', 'candidate 75', 'C75', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('76', 'candidate 76', 'C76', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('77', 'candidate 77', 'C77', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('78', 'candidate 78', 'C78', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('79', 'candidate 79', 'C79', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('8', 'candidate 8', 'C8', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('80', 'candidate 80', 'C80', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('81', 'candidate 81', 'C81', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('82', 'candidate 82', 'C82', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('83', 'candidate 83', 'C83', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('84', 'candidate 84', 'C84', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('85', 'candidate 85', 'C85', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:30', '2021-04-30 12:35:30'),
('86', 'candidate 86', 'C86', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('87', 'candidate 87', 'C87', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('88', 'candidate 88', 'C88', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('89', 'candidate 89', 'C89', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('9', 'candidate 9', 'C9', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:27', '2021-04-30 12:35:27'),
('90', 'candidate 90', 'C90', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('91', 'candidate 91', 'C91', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('92', 'candidate 92', 'C92', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('93', 'candidate 93', 'C93', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('94', 'candidate 94', 'C94', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('95', 'candidate 95', 'C95', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('96', 'candidate 96', 'C96', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('97', 'candidate 97', 'C97', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('98', 'candidate 98', 'C98', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31'),
('99', 'candidate 99', 'C99', 'not started', '1234', '4300', 'A', '10', 1, '2021-04-30 12:35:31', '2021-04-30 12:35:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`reg_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
