-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 03:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdoapp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_role` varchar(255) NOT NULL,
  `encryption_key` varbinary(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `admin_username`, `admin_pass`, `admin_role`, `encryption_key`) VALUES
(1, 'Admin', 'a/gk7fvTDcL6rrksA7HJMUUrdklVeXdwY01vTGxBdERLU1ZrN2w4bDRHQ0ZKa0FSeldBZ1NHRUdaMDlSYlRCdEwra3A2MVVxSFNoRTJCOWszMHIxSHF1WGhYdmVxMll6cjBuLzd3PT0=', 'admin', 0xce92e94f4a39c401411544bcafb002bc52a83645e496c9fffacce6d56ba3ce93);

-- --------------------------------------------------------

--
-- Table structure for table `application_tbl`
--

CREATE TABLE `application_tbl` (
  `application_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `application_image` varchar(255) NOT NULL,
  `application_title` varchar(255) NOT NULL,
  `application_description` text NOT NULL,
  `application_link` varchar(255) NOT NULL,
  `application_color` varchar(255) NOT NULL,
  `encryption_key` varbinary(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application_tbl`
--

INSERT INTO `application_tbl` (`application_id`, `admin_id`, `application_image`, `application_title`, `application_description`, `application_link`, `application_color`, `encryption_key`, `created_at`) VALUES
(1, 1, 'H3wdHeKVvolxTpi1dHKiGVdXV3ZqcVBCVVdReG9rT1kweEhZUytkbVo2ZFNNSGViemswN0NsM2RoMVk9', '1xvVQuVyDb6VUtNpUANsPDNKSis5OUZJS0lDRnRWM0dKSkw3Y3BpVjRSbmc5V3lYYlVrOURnaWY3ejdwZkluL08yS1FvKzlDQ05Fd3lKMWQ=', '(SDO-CAS) is a groundbreaking initiative aimed at preserving vast amounts of valuable information for current and future generations. It prioritizes accessibility through advanced indexing, search algorithms, and user-friendly interfaces, going beyond mere storage.', '+6/m+bKtPO/lwIto6/7cEk5rVStzQ3ZMNm5yMmoxd2t3VkFMS0xzL1hvMVlERUt4K2xwRFFXUmJUTW89', 'ah6F7AeJyEpl1sNI9iMcmWZTQXZnWk5CdmVBYmpRaEJ4Wi9yb1E9PQ==', 0xeb3b22d02759d6445711e2a5cf27630cb74866095ec75b7adb404505d4793c6d, '2024-06-23 03:47:02'),
(2, 1, 'qO5uirBp4AbPD2tQZGPUdU9FYkFrcm85dVBnMlRHOElMTDczZFdoL0w1KzN1ekN5dGFBbnpCODJVczg9', 'vnl2rg0Yn8/Cn9S7cJh2bTN0TWtONVVXSmdJVGl4T3doaDdFOEJWV2UzWXlDb3dIazdZRnZsMUQ4dUk9', 'Project ATHENA-AI revolutionizes education with AI. It creates personalized learning environments for both educators and students. The system offers AI-generated content and tools for customizing learning materials.', 'G2k5R+BaWsseupBHNOC7w2xsRWxuTDUyaXR1Q0ZMRVNiUFdTajdiYXkvbkduNGlyaEw0TStPbWFGUnRNSnMzckVqR3BwV0pWWk5uR211TWQ=', 'E2kJWwJ460QNhazHuqe7WHdZd1IvSWxtL0NvclR1VmZwM2NvS2c9PQ==', 0xc8312d891a028a76df4b509f9657c09657267eeacd895a60220c32bfc7c96e6c, '2024-06-19 06:46:10'),
(3, 1, 'H7CbU4fyWeoNpiSw6ENtq1JhdzkySU1YNWJQZTJZWUhsZWFjdnlNay8rWkhzUDBqbyt3Rkx4SU1uNnc9', 'ieUVawXqCHDHvdtSB7/lFHJjSHB3SG1vNG5kUG9QVER0Rm1vc1VTem4rdEc3RmZYY0IxVFZsQTZ0VnM9', 'The SDOOC Chatbot is custom fine-tuned on a dataset specific to PRIME-HRM and the Schools Division Office of Olongapo City. Using advanced language models and fine-tuning techniques, it delivers accurate and reliable responses.', 'aS+wDBYYcB7G3awHCpSZnDhsVlduZVg5bXBnNkpGaTlMK3dzQTNxK2s2N3FvcTlqVDdNcUZDZ0xsRkE9', 'tPFg4d0U9mFk3Io4O9K/tmRtc29DdTdHNjVZVmxiLzZibmxIM2c9PQ==', 0xf3fdde6308e53722aa1b1fb53c46643c81f75652dd4d7b3745375a6cec909b08, '2024-06-19 06:47:47'),
(5, 1, 'xUpVRetrn86viYXA1wamyGY2YlV0U2lsZlYvb2dLS3k3S2E0ZHNscGFmaHJJK004dk16bytFaWZubVU9', 'pp9fxSaesX4L6G+viCaCwEl4RkdQTUwrMkVqbFRiY3Z6a29XUFQwWTMxRDlVMENjbFE5aVU3UlcwL21nbGxrYzNWUmdza0lXaks3OWRlNzBrQUNQRG1aQjFUcGUxQnQ1UCtJQ2xBPT0=', 'Our software streamlines medical operations by automating visitor data, tallies, SHNU activities, and administrative tasks, improving efficiency and reducing errors.', 'iG1OyXH0mc0GigVct3d03npEcFZsQnJ5Ky83ZFJzZ1RYMUZVWDQyandaRWxOQ1ZFSlZ3dGtOUVpZelU9', 'Nd3/9cndjBiaa2uzn85b6UlEdVRoblhuWDhvSW13ZXVXd3V4R3c9PQ==', 0x1e15c4d78813943352aab92899bc14a8ad614944253795d397f00154eb9c63fa, '2024-06-19 06:52:47'),
(6, 1, 'oU7Tm/O5onrqbUz67WAi+lRHamJBMHZON2VwUXYvWndJd3pYMzdYMG1peWpkcTN3WDBLOW9uRklMbFU9', 'ZcXTdNzm6yWub/XKiF4Uw3c1a3lRcUMyaXJsc0ZmQ3lRWk9uZWZlbzlvaDBndWxtaGJwcmtVUHVmcUk9', 'SDOOC - Certificate Generator System automates the creation of certificates for academic achievements, training completions, and professional certifications, simplifying the traditionally manual process.', 'qIPIanR6OAjwA5OdlLYQXkl2ZkVQaHpBUzdhNU5IYzBWVG9pV0dWWmQ1SHg2NW8zSEtEWWl2TWFiN3M9', 'x4ZnwhPF4YyTVhfuByszo0FoUmQra0pZOWhnUXlhcEdEQnNVL2c9PQ==', 0x2b39e4f90ce7f6bce4e96ceb434cc1bd2b7bd5443b9175c986cd5d0d7163e11b, '2024-06-19 06:54:34'),
(7, 1, 'ODuX9gJpkx0bl1rkhkHTwTdPS2tCRmR4M2VucUc1Wlc1N2NLRmMxa2xTNXFSNG5ZemhmQ21EU3Jjemc9', 'MQWgU8naJJdAOxDJM0SO91gzT3FZby9OQWdTTXFiSlh0ZGZkOXhGOFBaZFJZaGJ4SEIrTldXb24wOFU9', 'Biometric synchronization in time tracking uses unique traits like fingerprints for secure employee authentication. This tech prevents fraud and enhances overall security, streamlining tracking for efficient time management.', 'Xfg9sU/AvVbB9dizEbqF9WhQb2FabGtTRmt3ckRxTXdVVm40SlRsZVJTeE1qVWh5Tmh6aG1LTVZ6SFE9', 'Iv0oTs2AUZHPQKxwK2ZCHk9wOXpocFpMWDJrcnovYkJvV2FMb0E9PQ==', 0x6b6cf5145e02cdb14f7fab73c5a98683369f934b521ea6882f026b4b2e4c23f8, '2024-06-24 00:57:01'),
(8, 1, '/uzCHBULvGFMfrdJWut4dUdkSy8wYk0zNENIazdiOWlYZm5HbHp5aHlQZXRJOHhBekxwNkpDeE1EZUk9', 'rCX86I6xoxv75rMGiTOZEFFpQ3FScTI3V3diYkxyMUJ4Ukl2ZzVMWEI1QS9YSFdLZDZXdXNqMXk3ZDU3UllXcWU4cWxkbHpmNG5KeHlTUFY=', 'The ICTU & DIGITOOLS Ticketing System streamlines issue management for ICTU and DIGITOOLS, acting as a virtual helpdesk where users can submit and track their inquiries. By automatically routing tickets and prioritizing urgent matters, it enhances efficiency in addressing and processing SDO Olongapo City client queries.', 'cEwZc0HSFj2uC5ItokzzeDk2YldNTlNDaGh2alVwNldDSC9YLzVvZDNpL1V1eXhLaHc2NnZ1OXEraTA9', 'uT5DmgWNUracIx6playtf0dUb1lQZlRweTNyK0NiL1JIQ2Q0dFE9PQ==', 0x0363b2789c1b343112e992fe3d3ccd88f5180ab84abacfa7b4f4cfc2d0ff1f1f, '2024-06-24 00:54:32'),
(9, 1, 'nEZfRpceFUFOT5cUgbqHHHRoMHhPeUF1U0JVcUR6WEhFRnNHMXRQaDd0QzAyQzZLQlNUcHlPZFVIQUk9', 'rjXMk36kOeHFAXDkitC7GzVlSFZhaG94dWJGcGp2UnpjZm9WY2cyc0FnbjdNb3B1dlFNZGVhK0NMb1U9', 'The Records Management System (RMS) is a user-friendly web application designed to manage end-to-end transactions digitally. It also tracks the movement of submitted digital documents within SDO Olongapo City&#039;s system.', 'J52QT8f+StDKKKyg/1a+QXlSVW96TFU5LzhFK0lmb2o0NjVQZ2xKNlUrQys1L1h6YlZBVzFUNVdkdkE9', 'wuMOzzAW2XjnWCogF5GHhVFUTGR5ampqZzk3ZkVERWdjS3k5Znc9PQ==', 0xb3e7c6b1b2282e788a765d0b7187fe77baece6a5106b2f98e1c705449ebfa6d8, '2024-06-23 02:58:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `application_tbl`
--
ALTER TABLE `application_tbl`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `application_tbl_ibfk1` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `application_tbl`
--
ALTER TABLE `application_tbl`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_tbl`
--
ALTER TABLE `application_tbl`
  ADD CONSTRAINT `application_tbl_ibfk1` FOREIGN KEY (`admin_id`) REFERENCES `admin_tbl` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
