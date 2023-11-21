-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 12:55 PM
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
-- Database: `queuing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `academics`
--

CREATE TABLE `academics` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(255) NOT NULL,
  `student_id` varchar(12) NOT NULL,
  `program` varchar(255) DEFAULT NULL,
  `concern` text DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `remarks` varchar(555) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `academics_accounts`
--

CREATE TABLE `academics_accounts` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `office` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics_accounts`
--

INSERT INTO `academics_accounts` (`username`, `password`, `full_name`, `office`, `status`) VALUES
('hernandezjohnlloyd', '12345678', 'John Lloyd Hernandez', 'SCS', 'offline'),
('kyletorres', '12345678', 'Kyle Torres', 'SAS', 'offline'),
('marlondiloy', '12345678', 'Marlon Diloy', 'SCS', 'available'),
('vincentrivera', '12345678', 'Vincent Rivera', 'SCS', 'offline'),
('hernandezjohnlloyd', '12345678', 'John Lloyd Hernandez', 'SCS', 'offline'),
('kyletorres', '12345678', 'Kyle Torres', 'SAS', 'offline'),
('marlondiloy', '12345678', 'Marlon Diloy', 'SCS', 'available'),
('vincentrivera', '12345678', 'Vincent Rivera', 'SCS', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `academics_logs`
--

CREATE TABLE `academics_logs` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(255) NOT NULL,
  `student_id` varchar(12) NOT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `timeout` timestamp NULL DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics_logs`
--

INSERT INTO `academics_logs` (`id`, `queue_number`, `student_id`, `endorsed_from`, `timestamp`, `timeout`, `transaction`) VALUES
(1, 'SCS001', '2020-120283', 'Academics', '2023-10-26 05:46:38', '2023-10-26 05:46:52', 'accounting'),
(2, 'SCS002', '2020-120283', 'Academics', '2023-10-26 05:51:37', '2023-10-26 05:51:59', 'accounting');

-- --------------------------------------------------------

--
-- Table structure for table `academics_queue`
--

CREATE TABLE `academics_queue` (
  `id` int(11) NOT NULL DEFAULT 0,
  `queue_number` varchar(255) NOT NULL,
  `student_id` varchar(12) NOT NULL,
  `program` varchar(255) NOT NULL,
  `concern` text NOT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(555) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `status` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics_queue`
--

INSERT INTO `academics_queue` (`id`, `queue_number`, `student_id`, `program`, `concern`, `endorsed_from`, `timestamp`, `remarks`, `transaction`, `status`) VALUES
(0, 'S002', '2020-120951', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-11 16:53:25', '2121', '2121212121', 0),
(0, 'AS001', '2121', 'SABM', 'Florenda De Vero ', 'REGISTRAR', '2023-11-11 19:18:12', '2112', '2121', 0),
(0, 'B001', '2020-120951', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-12 05:00:14', '2121', '2121', 0),
(0, 'D001', '2020-120951', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-12 05:37:37', '1221', '2121', 0),
(0, '2121', '2020-120951', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-01 06:33:33', '2121', '2121', 0),
(0, 'M004', '2020-120951', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-12 07:46:56', '2112', '212', 0),
(0, 'R003', '2121', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-07-03 08:03:14', '2121', '2121', 0),
(0, 'R002', '32', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-12 08:03:08', '2121', '21', 0),
(0, 'S001', '2020-120951', 'SCS', 'Vincent Rivera ', 'REGISTRAR', '2023-11-12 08:21:44', '2121', '2121', 0);

-- --------------------------------------------------------

--
-- Table structure for table `accounting`
--

CREATE TABLE `accounting` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `timeout` timestamp NULL DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounting`
--

INSERT INTO `accounting` (`id`, `queue_number`, `student_id`, `timestamp`, `timeout`, `endorsed_from`, `transaction`, `remarks`, `status`) VALUES
(0, 'R0001', '2020-120951', '2023-11-07 12:48:43', NULL, 'REGISTRAR', 'Payment', 'DAIDAHD', 1),
(0, 'R0001', '2020-120951', '2023-11-07 12:48:43', NULL, 'REGISTRAR', '2121', '2121', 1),
(0, 'R001', '2121', '2023-11-08 14:06:39', NULL, 'REGISTRAR', '2121', '2112', 1),
(0, 'R001', '2121', '2023-11-08 16:29:21', NULL, 'REGISTRAR', '2121', '2112', 1),
(0, 'R001', '2020-120169', '2023-11-08 16:53:02', NULL, 'REGISTRAR', 'PAYMENT', 'HELLO MY NAME IS RAVEN PONTI. I WANT TO RECEIVE THE CERTIFICATIO', 1),
(1, 'A001', '2121', '2023-11-08 17:04:50', NULL, '2121', '2121', '2121', 1),
(0, 'R002', '2020-120951', '2023-11-08 17:03:44', NULL, 'REGISTRAR', '2', '2', 0),
(0, 'R001', '2020-120961', '2023-11-08 17:24:36', NULL, 'REGISTRAR', 'PAYMENT', 'DSADDASA', 1),
(0, 'R001', '2121', '2023-11-08 21:07:05', NULL, 'REGISTRAR', '2121', '2121', 1),
(0, 'R001', '2020-120951', '2023-11-09 10:24:06', NULL, 'REGISTRAR', 'PAYMENT', 'NEW PAYMENT HELLO WORLD UDAGWYAGDYIWQGYQGWYDGYWGDYQWGYGQWDYGD NO', 1),
(0, 'S001', '2020-120951', '2023-11-09 11:14:37', NULL, 'REGISTRAR', '2121', '212121212121212121212121211212212121122121 3434434343434434343434434343443 565656565665656565656656565 87878787878878787887877', 1),
(0, 'S0002', '2121', '2023-11-09 11:17:02', NULL, 'REGISTRAR', '212112', '212121', 0),
(0, 'R0001', '2020-120951', '2023-11-07 12:48:43', NULL, 'REGISTRAR', 'Payment', 'DAIDAHD', 1),
(0, 'R0001', '2020-120951', '2023-11-07 12:48:43', NULL, 'REGISTRAR', '2121', '2121', 1),
(0, 'R001', '2121', '2023-11-08 14:06:39', NULL, 'REGISTRAR', '2121', '2112', 1),
(0, 'R001', '2121', '2023-11-08 16:29:21', NULL, 'REGISTRAR', '2121', '2112', 1),
(0, 'R001', '2020-120169', '2023-11-08 16:53:02', NULL, 'REGISTRAR', 'PAYMENT', 'HELLO MY NAME IS RAVEN PONTI. I WANT TO RECEIVE THE CERTIFICATIO', 1),
(1, 'A001', '2121', '2023-11-08 17:04:50', NULL, '2121', '2121', '2121', 1),
(0, 'R002', '2020-120951', '2023-11-08 17:03:44', NULL, 'REGISTRAR', '2', '2', 0),
(0, 'R001', '2020-120961', '2023-11-08 17:24:36', NULL, 'REGISTRAR', 'PAYMENT', 'DSADDASA', 1),
(0, 'R001', '2121', '2023-11-08 21:07:05', NULL, 'REGISTRAR', '2121', '2121', 1),
(0, 'R001', '2020-120951', '2023-11-09 10:24:06', NULL, 'REGISTRAR', 'PAYMENT', 'NEW PAYMENT HELLO WORLD UDAGWYAGDYIWQGYQGWYDGYWGDYQWGYGQWDYGD NO', 1),
(0, 'S001', '2020-120951', '2023-11-09 11:14:37', NULL, 'REGISTRAR', '2121', '212121212121212121212121211212212121122121 3434434343434434343434434343443 565656565665656565656656565 87878787878878787887877', 1),
(0, 'S0002', '2121', '2023-11-09 11:17:02', NULL, 'REGISTRAR', '212112', '212121', 0),
(0, 'R001', '2121', '2023-11-11 14:04:21', NULL, 'REGISTRAR', '2121', '2121', 0),
(0, 'L01', '2020-120951', '2023-11-12 05:02:13', NULL, 'REGISTRAR', '2121', '2121', 0),
(0, 'R001', '2020-120951', '2023-11-12 06:31:55', NULL, 'REGISTRAR', '2121', '2121', 0),
(0, 'NARUTO', '2020-120951', '2023-08-14 07:17:21', NULL, 'REGISTRAR', '2121', '2121', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `users` varchar(255) NOT NULL,
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`users`, `id`, `email`, `password`) VALUES
('window1', 1, 'magalingka@gmail.com', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(45) DEFAULT NULL,
  `student_id` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `endorsed_from` varchar(45) DEFAULT NULL,
  `transaction` varchar(45) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `program` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `program`, `status`) VALUES
(72, 'R001', '2121', '2023-11-11 14:12:32', 'REGISTRAR', '2121', '2121', NULL, 0),
(73, 'R004', '2121', NULL, 'REGISTRAR', '2121', '2121', NULL, 0),
(74, 'R004', '2121', NULL, 'REGISTRAR', '2121', '2121', NULL, 0),
(75, 'AS001', '2121', NULL, NULL, '2121', '2121', NULL, 0),
(76, '21', '21', '2023-11-12 05:32:12', 'REGISTRAR', '21', '21', NULL, 0),
(77, 'A001', '2121', '2023-10-18 06:44:03', 'REGISTRAR', '2121', '212', NULL, 0),
(78, 'M007', '2020-120951', '2023-07-03 07:55:16', 'REGISTRAR', '2121', '2121', NULL, 0),
(79, 'M006', '2112', '2023-11-12 07:55:12', 'REGISTRAR', '2121', '2121', NULL, 0),
(80, 'R001', '2112', '2023-11-12 08:01:13', 'REGISTRAR', '2121', '2112', NULL, 0),
(81, 'R004', '2121', '2023-09-15 08:03:39', 'REGISTRAR', '2121', '2121', NULL, 0),
(82, 'ONEPIECE', '2121', '2023-10-30 08:17:47', 'REGISTRAR', '2121', '2121', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admission_logs`
--

CREATE TABLE `admission_logs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(45) DEFAULT NULL,
  `queue_number` varchar(45) DEFAULT NULL,
  `office` varchar(45) DEFAULT NULL,
  `remarks` varchar(45) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `timeout` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(97, 'R002', '2020-120951', '2023-11-12 06:33:05', 'REGISTRAR', '2121', '2121', 0, 1);

--
-- Triggers `assets`
--
DELIMITER $$
CREATE TRIGGER `trg_assets_window` BEFORE INSERT ON `assets` FOR EACH ROW BEGIN
    -- Calculate the window value based on the ID
    SET NEW.window = ((NEW.id - 1) % 1) + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `timeout` timestamp NULL DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`id`, `queue_number`, `student_id`, `timestamp`, `timeout`, `endorsed_from`, `transaction`, `remarks`, `status`) VALUES
(10, 'R006', '6', '2023-11-08 17:04:40', NULL, 'REGISTRAR', '6', '6', 0),
(11, 'R001', '2121', '2023-11-09 10:04:03', NULL, 'REGISTRAR', '2121', '21', 0),
(12, 'R006', '2020-120951', '2023-11-09 13:50:18', NULL, 'REGISTRAR', '2121', '212121', 0),
(13, 'ONE PIECE', '2020-120951', '2023-11-12 07:17:17', NULL, 'REGISTRAR', '2121', '2121', 0);

-- --------------------------------------------------------

--
-- Table structure for table `guidance`
--

CREATE TABLE `guidance` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `timeout` timestamp NULL DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guidance`
--

INSERT INTO `guidance` (`id`, `queue_number`, `student_id`, `timestamp`, `timeout`, `endorsed_from`, `transaction`, `remarks`, `status`) VALUES
(6, 'A001', '2020-120951', '2023-11-08 17:04:50', NULL, 'REGISTRAR', '7', '7', 0),
(7, 'GFQAGQ', 'GFQAGQ', '2023-11-08 21:08:48', NULL, 'REGISTRAR', 'GFQAGQ', 'GFQAGQ', 0),
(8, 'R999', '2121', '2023-11-09 10:09:56', NULL, 'REGISTRAR', '2121', '2121', 0),
(9, 'R001', '2121', '2023-11-09 11:52:29', NULL, 'REGISTRAR', '21212', '1221', 0);

-- --------------------------------------------------------

--
-- Table structure for table `itro`
--

CREATE TABLE `itro` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `timeout` timestamp NULL DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itro`
--

INSERT INTO `itro` (`id`, `queue_number`, `student_id`, `timestamp`, `timeout`, `endorsed_from`, `transaction`, `remarks`, `status`) VALUES
(16, 'R001', '2121', '2023-11-09 08:37:49', NULL, 'REGISTRAR', '212', '12121', 0),
(17, 'AS2121', 'ADSSDA', '2023-11-09 10:13:59', NULL, 'REGISTRAR', 'DSAD', 'SADSA', 0),
(18, 'S0001', '2020-120951', '2023-11-12 04:54:02', NULL, 'REGISTRAR', '2121', '2121', 0),
(19, 'NEW', '2121', '2023-11-12 06:41:07', NULL, 'REGISTRAR', '2121', '2112', 0);

-- --------------------------------------------------------

--
-- Table structure for table `program_chairs`
--

CREATE TABLE `program_chairs` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_chairs`
--

INSERT INTO `program_chairs` (`id`, `full_name`, `program`, `status`) VALUES
(1, 'Vincent Rivera', 'SCS', 'available'),
(2, 'Marlon Diloy', 'SCS', 'available'),
(3, 'Carlito Loyola Jr.', 'SAS', 'available'),
(4, 'Marjualita Malapo', 'SAS', 'available'),
(5, 'Frederick Dalena', 'SAS', 'offline'),
(6, 'Jude Thaddeus Bartolome', 'SAS', NULL),
(7, 'Brian De Guzman', 'SEA', 'offline'),
(9, 'Juliet Niega', 'SEA', 'available'),
(10, 'Joseph Alcoran', 'SEA', 'available'),
(11, 'Florenda De Vero', 'SABM', NULL),
(12, 'Johnny Boy Tizon', 'SABM', NULL),
(13, 'Arnel Villamin', 'SABM', 'available'),
(14, 'Richard Miguel Butial', 'SHS', 'available'),
(15, 'Jhanna Mae Tadique', 'SHS', 'offline'),
(16, 'Maria Carina Pontanar', 'SHS', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `queue_number` varchar(10) NOT NULL,
  `office` varchar(20) NOT NULL,
  `program` varchar(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(32) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`id`, `student_id`, `queue_number`, `office`, `program`, `timestamp`, `status`, `remarks`) VALUES
(1049, 'GUEST', 'R001', 'REGISTRAR', '-', '2023-11-09 07:02:02', 1, NULL),
(1050, 'GUEST', 'AD001', 'ADMISSION', '-', '2023-11-09 07:02:42', 0, NULL),
(1051, 'GUEST', 'AC001', 'ACCOUNTING', '-', '2023-11-09 07:03:27', 0, NULL),
(1052, 'GUEST', 'SCS001', 'ACADEMICS', '-', '2023-11-09 07:03:46', 0, NULL),
(1058, 'GUEST', 'AD002', 'ADMISSION', '-', '2023-11-09 11:08:37', 0, NULL),
(1059, 'GUEST', 'R002', 'REGISTRAR', '-', '2023-11-09 13:13:04', 0, NULL),
(1060, 'GUEST', 'AD003', 'ADMISSION', '-', '2023-11-09 13:13:16', 0, NULL),
(1061, 'GUEST', 'AD004', 'ADMISSION', '-', '2023-11-09 13:13:34', 0, NULL),
(1062, 'GUEST', 'R003', 'REGISTRAR', '-', '2023-11-09 13:13:41', 0, NULL),
(1063, 'GUEST', 'R004', 'REGISTRAR', '-', '2023-11-09 13:13:53', 0, NULL),
(1064, 'GUEST', 'AC002', 'ACCOUNTING', '-', '2023-11-09 13:13:57', 0, NULL),
(1065, 'GUEST', 'SCS213', 'ACADEMICS', '-', '2023-11-09 13:14:09', 0, NULL),
(1066, '2020-123', 'R005', 'REGISTRAR', 'SCS', '2023-11-09 13:14:34', 0, NULL),
(1067, '2020-123', 'AD005', 'ADMISSION', 'SCS', '2023-11-09 13:14:45', 0, NULL),
(1068, '2020-123', 'SCS214', 'ACADEMICS', 'SCS', '2023-11-09 13:15:53', 0, NULL),
(1069, '2020-123', 'SCS215', 'ACADEMICS', 'SCS', '2023-11-09 13:16:02', 0, NULL),
(1070, '2020-123', 'CL001', 'CLINIC', 'SCS', '2023-11-09 13:16:35', 0, NULL),
(1071, '2020-123', 'AD006', 'ADMISSION', 'SCS', '2023-11-09 13:54:55', 0, NULL),
(1072, '2020-123', 'AD007', 'ADMISSION', 'SCS', '2023-11-09 13:55:21', 0, NULL),
(1073, '2020-123', 'AD008', 'ADMISSION', 'SCS', '2023-11-09 13:55:33', 0, NULL),
(1074, '2020-123', 'R006', 'REGISTRAR', 'SCS', '2023-11-09 13:55:42', 0, NULL),
(1075, 'GUEST', 'AD009', 'ADMISSION', '-', '2023-11-09 13:56:14', 0, NULL),
(1076, 'GUEST', 'R007', 'REGISTRAR', '-', '2023-11-09 13:56:27', 0, NULL),
(1077, 'GUEST', 'SCS001', 'ACADEMICS', '-', '2023-11-09 13:56:49', 0, NULL),
(1078, 'GUEST', 'R008', 'REGISTRAR', '-', '2023-11-09 13:57:01', 0, NULL),
(1079, 'GUEST', 'AD010', 'ADMISSION', '-', '2023-11-09 13:57:06', 0, NULL),
(1080, 'GUEST', 'R009', 'REGISTRAR', '-', '2023-11-09 14:41:36', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registrar`
--

CREATE TABLE `registrar` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` varchar(255) DEFAULT NULL,
  `current_window` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar`
--

INSERT INTO `registrar` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`, `current_window`) VALUES
(3, 'R003', '2121', '2023-11-12 11:03:12', '2121', '2121', '2121', 1, 'Window 2', NULL),
(4, 'R004', '2121', '2023-11-12 11:03:34', '2121', '2121', '2112', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registrar_done`
--

CREATE TABLE `registrar_done` (
  `id` varchar(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `timeout` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar_done`
--

INSERT INTO `registrar_done` (`id`, `queue_number`, `student_id`, `endorsed_from`, `transaction`, `remarks`, `status`, `timeout`, `timestamp`) VALUES
('', 'Y0001', '2121', '2121', '2112', '2121', 1, '2023-11-12 05:27:48', '2023-11-12 05:23:38'),
('', 'P001', '2121', '2121', '2121', '2121', 1, '2023-11-12 05:32:03', '2023-11-12 05:28:02'),
('', 'F001', '2121', '2121', '2121', '2112', 1, '2023-11-12 05:37:19', '2023-11-12 05:37:12'),
('', 'G001', '2121', '2121', '2121', '21121', 1, '2023-11-12 05:45:56', '2023-11-12 05:45:48'),
('', 'U001', '2121', '2121', '2121', '2112', 1, '2023-11-12 05:46:49', '2023-11-12 05:46:12'),
('', 'R001', '2121', '2121', '2121', '221', 1, '2023-11-12 06:22:24', '2023-11-12 06:16:44'),
('', 'R002', '2121', '2121', '2121', '2121', 1, '2023-11-12 06:22:31', '2023-11-12 06:17:10'),
('', 'R003', '2121', '2121', '2121', '2112', 1, '2023-11-12 06:22:42', '2023-11-12 06:17:33'),
('', 'R005', '2121', '2121', '2121', '2121', 1, '2023-11-12 06:22:44', '2023-11-12 06:21:14'),
('', 'R006', '2121', '2121', '2121', '2121', 1, '2023-11-12 06:22:46', '2023-11-12 06:21:43'),
('', 'R007', '212', '2121', '1212', '2121', 1, '2023-11-12 06:22:48', '2023-11-12 06:22:10'),
('', 'S9999', '2112', '2121', '2121', '2112', 1, '2023-11-12 06:45:16', '2023-06-06 06:40:21'),
('', 'D001', '21212', '2121', '2112', '2121', 1, '2023-11-12 06:47:18', '2023-09-11 06:38:15'),
('', 'S001', '2121', '2121', '2121', '2121', 1, '2023-11-12 06:47:26', '2023-10-04 06:34:55'),
('', 'M001', '2121', '2121', '2121', '2121', 1, '2023-11-12 07:22:50', '2023-11-12 07:19:06'),
('', 'M002', '21213', '213123', '321321', '321312', 1, '2023-11-12 07:46:40', '2023-11-12 07:19:21'),
('', 'M003', '2121', '2121', '2121', '2121', 1, '2023-11-12 07:55:53', '2023-11-12 07:32:13'),
('', '9999', '2112', '2121', '212112', '212121', 1, '2023-11-12 08:02:29', '2023-11-12 08:02:18'),
('', 'R0001', '2112', '2112', '2121', '2121', 1, '2023-11-12 08:23:07', '2023-11-12 08:02:58'),
('', '2121', '212121', '21212', '2121', '2112', 1, '2023-11-12 10:15:12', '2023-11-12 08:21:01'),
('', 'R0001', '2121', '2121', '', '2121', 1, '2023-11-12 10:25:40', '2023-11-12 10:16:23'),
('', 'R002', '2121', '212', '212', '212', 1, '2023-11-12 10:25:49', '2023-09-19 10:17:13'),
('', 'R001', '2121', '2121', '2121', '2121', 1, '2023-11-12 11:02:39', '2023-11-12 10:26:29'),
('', 'R002', '2121', '2121', '2121', '2112', 1, '2023-11-12 11:03:41', '2023-11-12 11:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `studentid_list`
--

CREATE TABLE `studentid_list` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentid_list`
--

INSERT INTO `studentid_list` (`id`, `student_id`) VALUES
(1, '2020-123');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `ID` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `office` varchar(255) NOT NULL,
  `window` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`ID`, `full_name`, `office`, `window`, `username`, `password`, `status`) VALUES
(1, 'Rick Admin', 'REGISTRAR', 'Window 1', 'Migzu', '123', NULL),
(2, 'Miguel Admin', 'ACCOUNTING', 'Window 2', 'Hello', '123', NULL),
(3, 'Hadji Aaron', 'REGISTRAR', 'Window 2', 'Hadji', '12345', NULL),
(4, '2121', '2121', '', '2121', '21212', '12121'),
(5, 'Dave', 'REGISTRAR', 'Window 3', 'Dave', '123', NULL),
(6, 'Nheal', 'REGISTRAR', 'Window 4', 'Nheal', '123', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academics`
--
ALTER TABLE `academics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `academics_logs`
--
ALTER TABLE `academics_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admission_logs`
--
ALTER TABLE `admission_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guidance`
--
ALTER TABLE `guidance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itro`
--
ALTER TABLE `itro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_chairs`
--
ALTER TABLE `program_chairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentid_list`
--
ALTER TABLE `studentid_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academics`
--
ALTER TABLE `academics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `academics_logs`
--
ALTER TABLE `academics_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `admission_logs`
--
ALTER TABLE `admission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `guidance`
--
ALTER TABLE `guidance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `itro`
--
ALTER TABLE `itro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1081;

--
-- AUTO_INCREMENT for table `studentid_list`
--
ALTER TABLE `studentid_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
