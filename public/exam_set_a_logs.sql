-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2021 at 08:09 PM
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
-- Table structure for table `exam_set_a_logs`
--

CREATE TABLE `exam_set_a_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Question_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SQN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selected_ans` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_set_a_logs`
--

INSERT INTO `exam_set_a_logs` (`id`, `reg_no`, `Question_number`, `SQN`, `selected_ans`, `status`, `points`, `created_at`, `updated_at`) VALUES
(1, '4', '1', '5', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(2, '4', '2', '4', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(3, '4', '3', '3', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(4, '4', '4', '2', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(5, '4', '5', '1', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(6, '4', '1', '10', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(7, '4', '2', '9', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(8, '4', '3', '8', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(9, '4', '4', '7', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(10, '4', '5', '6', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(11, '4', '1', '15', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(12, '4', '2', '14', '0', 'untouched', '0', '2021-04-28 07:42:10', '2021-04-28 07:42:10'),
(13, '4', '3', '13', '0', 'untouched', '0', '2021-04-28 07:42:11', '2021-04-28 07:42:11'),
(14, '4', '4', '12', '0', 'untouched', '0', '2021-04-28 07:42:11', '2021-04-28 07:42:11'),
(15, '4', '5', '11', '0', 'untouched', '0', '2021-04-28 07:42:11', '2021-04-28 07:42:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam_set_a_logs`
--
ALTER TABLE `exam_set_a_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam_set_a_logs`
--
ALTER TABLE `exam_set_a_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
