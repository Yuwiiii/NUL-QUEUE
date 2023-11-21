-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2023 at 03:09 PM
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

--
-- Dumping data for table `academics`
--

INSERT INTO `academics` (`id`, `queue_number`, `student_id`, `program`, `concern`, `endorsed_from`, `timestamp`, `remarks`, `transaction`) VALUES
(2, 'R12301', '2020-120018', 'SCS', 'MARLON DILOY', 'Accounting', '2023-11-09 17:25:09', 'Test lang po ito', 'Registrar'),
(3, 'ROO1', '2020-120018', 'SAS', 'Carlito Loyola Jr.', 'Accounting', '2023-11-09 17:08:30', 'Trial', 'Payment'),
(4, 'ROO1', '2020-120018', 'SCS', 'Marlon Diloy', 'Accounting', '2023-11-09 17:08:30', 'TEST', 'Payment'),
(5, 'ROO12', '2020-120018', 'SCS', 'Marlon Diloy', 'Registrar', '2023-11-09 17:08:30', 'Test if working pa.', 'Registrar');

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
  `remarks` int(11) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics_logs`
--

INSERT INTO `academics_logs` (`id`, `queue_number`, `student_id`, `endorsed_from`, `timestamp`, `timeout`, `remarks`, `transaction`, `status`) VALUES
(1, 'SCS001', '2020-120283', 'Academics', '2023-10-26 13:46:38', '2023-10-26 13:46:52', NULL, 'accounting', 1),
(2, 'SCS002', '2020-120283', 'Academics', '2023-10-26 13:51:37', '2023-10-26 13:51:59', NULL, 'accounting', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `academics_queue`
--

CREATE TABLE `academics_queue` (
  `id` int(255) NOT NULL,
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
(1, 'SCS003', '2020-120283', 'SCS', 'Marlon Diloy', 'Front desk', '2023-11-09 09:06:14', NULL, 'Subject Registration', 1),
(2, 'R12O1', '2020-120018', 'SCS', 'Marlon Diloy', 'Accounting', '2023-11-09 17:08:30', 'Academics queue', 'Payment', 0);

-- --------------------------------------------------------

--
-- Table structure for table `accounting`
--

CREATE TABLE `accounting` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `availability` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounting`
--

INSERT INTO `accounting` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `availability`) VALUES
(1, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Registrar', 'Payment', 'Uniform Payment', 0, 0),
(2, 'R1OO1', '2020-120018', '2023-11-09 17:25:09', 'Registrar', 'Registrar', 'Payment', 0, 0),
(11, 'ROO12', '2020-120018', '2023-11-09 17:08:30', 'ITRO', 'Registrar', 'Payment', 0, 0),
(13, 'R1OO441', '2020-120018', '2023-11-09 17:25:09', 'Registrar', 'Registrar', 'Payment', 0, 0),
(15, 'R12O1', '2020-120018', '2023-11-09 17:08:30', 'ITRO', 'Payment', 'Uniform Payment', 0, 0),
(16, 'R12301', '2020-120018', '2023-11-09 17:25:09', 'Registrar', 'Registrar', 'Payment', 0, 0),
(17, 'RO1240', '2020-120018', '2023-11-09 17:08:30', 'Regisrar', 'Registrar', 'Payment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `accounting_logs`
--

CREATE TABLE `accounting_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `timeout` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `endorsed_from` varchar(255) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounting_logs`
--

INSERT INTO `accounting_logs` (`id`, `queue_number`, `student_id`, `timestamp`, `timeout`, `endorsed_from`, `transaction`, `remarks`, `status`) VALUES
(1, 'R001', 2020, '2023-09-23 14:14:32.000000', '2023-11-09 15:20:57.505655', 'Registrar', 'Payments', 'End na', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `users` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `program`, `status`) VALUES
(1, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 'Endorse to admission test.', NULL, 0),
(2, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 'SCS', 'SCS', 0);

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
  `timeout` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission_logs`
--

INSERT INTO `admission_logs` (`id`, `student_id`, `queue_number`, `office`, `remarks`, `timestamp`, `timeout`, `status`) VALUES
(1, '2020-123', 'AD00019', NULL, 'qwe', NULL, NULL, 0),
(11, '2020-123', 'AD0020', NULL, 'qwe', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`) VALUES
(1, 'ROO1', '2020-120018', '2023-11-10 01:08:30', 'Accounting', 'Accounting', 'Test', 0),
(2, 'RO1240', '2020-120018', '2023-11-10 01:08:30', 'Accounting', 'Registrar', 'This is test for assets.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assets_logs`
--

CREATE TABLE `assets_logs` (
  `id` varchar(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `timeout` timestamp(6) NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `id` int(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `remarks` varchar(64) NOT NULL,
  `transaction` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `endorsed_from` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`id`, `queue_number`, `student_id`, `remarks`, `transaction`, `timestamp`, `status`, `endorsed_from`) VALUES
(14, 'R12O1', '2020-120018', 'Test to clinic', 'Payment', '2023-11-09 17:08:30', NULL, 'Accounting');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_logs`
--

CREATE TABLE `clinic_logs` (
  `id` varchar(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `timeout` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `ID` int(11) NOT NULL,
  `acronym` varchar(11) NOT NULL,
  `collegeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`ID`, `acronym`, `collegeName`) VALUES
(1, 'SCS', 'School of Computer Studies'),
(2, 'SEA', 'School of Engineering and Architecture'),
(3, 'SAS', 'School of Arts and Sciences'),
(4, 'SABM', 'School of Accountancy and Business Management'),
(5, 'SHS', 'Senior High School');

-- --------------------------------------------------------

--
-- Table structure for table `guidance`
--

CREATE TABLE `guidance` (
  `id` int(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `remarks` varchar(64) NOT NULL,
  `transaction` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `endorsed_from` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guidance`
--

INSERT INTO `guidance` (`id`, `queue_number`, `student_id`, `remarks`, `transaction`, `timestamp`, `status`, `endorsed_from`) VALUES
(1, 'GD0011', '2020-123456', 'BSDFSF', 'SDFSDFSD', '2023-11-03 11:30:44', 0, ''),
(2, 'GD0022', '2021-123321', 'EGSDGSDG', 'EWGSDGDS', '2023-11-03 11:30:46', 1, ''),
(14, 'R1OO441', '2020-120018', 'Finally', 'Registrar', '2023-11-09 17:25:09', NULL, 'Accounting');

-- --------------------------------------------------------

--
-- Table structure for table `guidance_logs`
--

CREATE TABLE `guidance_logs` (
  `id` varchar(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `timeout` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itso`
--

CREATE TABLE `itso` (
  `id` int(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `remarks` varchar(64) NOT NULL,
  `transaction` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `endorsed_from` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itso`
--

INSERT INTO `itso` (`id`, `queue_number`, `student_id`, `remarks`, `transaction`, `timestamp`, `status`, `endorsed_from`) VALUES
(0, 'GD0033', '2020-543221', 'Validation of ID', NULL, '2023-10-26 18:19:44', NULL, ''),
(0, 'R1OO1', '2020-120018', 'itro', 'Registrar', '2023-11-09 17:25:09', NULL, 'Accounting');

-- --------------------------------------------------------

--
-- Table structure for table `itso_logs`
--

CREATE TABLE `itso_logs` (
  `id` varchar(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `timeout` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `ID` int(11) NOT NULL,
  `acronym` varchar(11) NOT NULL,
  `officeName` varchar(255) NOT NULL,
  `office` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`ID`, `acronym`, `officeName`, `office`) VALUES
(1, 'AD', 'ADMISSION', 0),
(2, 'R', 'REGISTRAR', 0),
(3, 'AC', 'ACCOUNTING', 0),
(6, 'CL', 'CLINIC', 1),
(7, 'AS', 'ASSETS', 1),
(8, 'IT', 'ITSO', 1),
(9, 'G', 'GUIDANCE', 1),
(13, 'F', 'ACADEMICS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `program_chairs`
--

CREATE TABLE `program_chairs` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_chairs`
--

INSERT INTO `program_chairs` (`id`, `full_name`, `program`, `status`, `user_id`) VALUES
(1, 'Vincent Rivera', 'SCS', NULL, 1),
(2, 'Marlon Diloy', 'SCS', NULL, 2),
(3, 'Carlito Loyola Jr.', 'SAS', NULL, 3),
(4, 'Marjualita Malapo', 'SAS', NULL, 4),
(5, 'Frederick Dalena', 'SAS', NULL, 5),
(6, 'Jude Thaddeus Bartolome', 'SAS', NULL, 6),
(7, 'Brian De Guzman', 'SEA', NULL, 7),
(8, 'Juliet Niega', 'SEA', NULL, 8),
(9, 'Joseph Alcoran', 'SEA', NULL, 9),
(10, 'Florenda De Vero', 'SABM', NULL, 10),
(11, 'Johnny Boy Tizon', 'SABM', NULL, 11),
(12, 'Arnel Villamin', 'SABM', NULL, 12),
(13, 'Richard Miguel Butial', 'SHS', NULL, 13),
(14, 'Jhanna Mae Tadique', 'SHS', NULL, 14),
(15, 'Maria Carina Pontanar', 'SHS', NULL, 15);

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
  `status` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `endorsed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue_logs`
--

CREATE TABLE `queue_logs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `queue_number` varchar(10) NOT NULL,
  `office` varchar(20) NOT NULL,
  `program` varchar(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `endorsed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_logs`
--

INSERT INTO `queue_logs` (`id`, `student_id`, `queue_number`, `office`, `program`, `timestamp`, `status`, `remarks`, `endorsed`) VALUES
(1, '2020-123', 'AD001', 'ADMISSION', '', '2023-09-21 07:35:47', 1, NULL, ''),
(2, '2020-123', 'R001', 'REGISTRAR', '', '2023-09-23 03:19:13', 1, NULL, ''),
(3, '2020-12345', 'AC0011', 'ACCOUNTING', '', '2023-09-23 06:14:32', 1, NULL, ''),
(4, '2020-123', 'AC002', 'ACCOUNTING', '', '2023-09-23 06:14:40', 0, NULL, ''),
(5, '2020-123', 'AD002', 'ADMISSION', '', '2023-09-24 22:36:25', 1, NULL, ''),
(6, '2020-123', 'AS001', 'ASSETS', '', '2023-09-24 22:37:35', 0, NULL, ''),
(7, '2020-123', 'AC003', 'ACCOUNTING', '', '2023-09-25 06:49:46', 0, NULL, ''),
(8, '2020-123', 'CL001', 'CLINIC', '', '2023-09-28 02:41:32', 0, NULL, ''),
(9, '2020-123', 'AC004', 'ACCOUNTING', '', '2023-09-28 02:50:22', 0, NULL, ''),
(11, '2020-123', 'R002', 'REGISTRAR', '', '2023-09-28 02:50:39', 0, NULL, ''),
(12, '2020-123', 'R003', 'REGISTRAR', '', '2023-09-28 02:50:49', 0, NULL, ''),
(13, '2020-123', 'CL002', 'CLINIC', '', '2023-09-28 02:56:33', 0, NULL, ''),
(14, '2020-123', 'AS002', 'ASSETS', '', '2023-09-28 02:57:34', 0, NULL, ''),
(15, '2020-123', 'AS003', 'ASSETS', '', '2023-09-28 02:57:41', 0, NULL, ''),
(16, 'GUEST', 'AD003', 'ADMISSION', '', '2023-09-28 04:31:40', 0, NULL, ''),
(17, '2020-123', 'R004', 'REGISTRAR', '', '2023-09-28 04:31:46', 0, NULL, ''),
(18, '2020-123', 'CL003', 'CLINIC', '', '2023-09-28 04:35:04', 0, NULL, ''),
(19, '2020-123', 'IT001', 'ITRO', '', '2023-09-28 04:35:15', 0, NULL, ''),
(22, '2020-12001', 'AC011', 'ACCOUNTING', '', '0000-00-00 00:00:00', 1, NULL, ''),
(24, '2020-12001', 'AC123', 'ACCOUNTING', '', '0000-00-00 00:00:00', 0, NULL, ''),
(25, 'GUEST', 'AD004', 'ADMISSION', '', '2023-10-10 14:21:00', 0, NULL, ''),
(29, '231312', 'AD005', 'ADMISSION', 'SEA', '2023-10-10 14:27:08', 1, NULL, ''),
(46, '2020-12028', 'SCS001', 'ACADEMICS', 'SCS', '2023-10-26 13:46:38', 0, NULL, ''),
(47, '2020-12028', 'SCS002', 'ACADEMICS', 'SCS', '2023-10-26 13:51:37', 0, NULL, ''),
(48, 'GUEST', 'SCS003', 'ACADEMICS', '-', '2023-11-03 08:10:43', 0, NULL, ''),
(49, 'GUEST', 'IT002', 'ITRO', '-', '2023-11-10 13:06:08', 0, NULL, ''),
(50, 'GUEST', 'SCS004', 'ACADEMICS', '-', '2023-11-10 13:12:48', 0, NULL, ''),
(51, 'GUEST', 'AC124', 'ACCOUNTING', '-', '2023-11-11 01:00:20', 0, NULL, ''),
(52, '123455', 'AS004', 'ASSETS', 'SAS', '2023-11-11 01:06:01', 0, NULL, ''),
(53, '123455', 'IT003', 'ITRO', 'SAS', '2023-11-11 01:06:03', 0, NULL, ''),
(54, 'GUEST', 'G001', 'GUIDANCE', '-', '2023-11-11 01:13:27', 0, NULL, ''),
(55, 'GUEST', 'IT004', 'ITRO', '-', '2023-11-11 02:59:43', 0, NULL, ''),
(56, 'GUEST', 'scs001', 'hello', '-', '2023-11-11 04:18:21', 0, NULL, ''),
(57, 'GUEST', 'AC125', 'ACCOUNTING', '-', '2023-11-11 13:46:44', 0, NULL, 'kiosk');

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
  `window` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar`
--

INSERT INTO `registrar` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(3, 'R003', '2121', '2023-11-12 11:03:12', '2121', '2121', '2121', 1, 'Window 2'),
(4, 'R004', '2121', '2023-11-12 11:03:34', '2121', '2121', '2112', 0, NULL),
(0, 'R1OO1', '2020-120018', '2023-11-09 17:25:09', 'Accounting', 'Registrar', 'This is just a test.', 0, NULL),
(0, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 'Endorse to now working', 0, NULL),
(0, 'ROO12', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Registrar', 'Sample transaction', 0, NULL),
(0, 'R12O1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 'Please work', 0, NULL),
(0, 'RO1240', '2020-120018', '2023-11-09 17:08:30', 'Accounting', '', 'Test', 0, NULL),
(0, 'R1OO1', '2020-120018', '2023-11-09 17:25:09', 'Accounting', 'Registrar', 'Test transaction', 0, NULL),
(0, 'R1OO441', '2020-120018', '2023-11-09 17:25:09', 'Accounting', 'Registrar', 'Work this', 0, NULL),
(0, 'R12301', '2020-120018', '2023-11-09 17:25:09', 'Accounting', 'Registrar', 'ds', 0, NULL),
(0, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', '', 'ds', 0, NULL),
(0, 'ROO12', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Registrar', 'Tomorrow', 0, NULL),
(0, 'R12O1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 't', 0, NULL),
(0, 'R1OO1', '2020-120018', '2023-11-09 17:25:09', 'Accounting', '', 'test', 0, NULL),
(0, 'R1OO441', '2020-120018', '2023-11-09 17:25:09', 'Accounting', '', 'Test', 0, NULL);

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
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `window` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`ID`, `full_name`, `office`, `username`, `password`, `status`, `window`) VALUES
(1, 'Vincent Rivera', 'SCS', 'vincentrivera', '12345678', NULL, 'Window 1'),
(2, 'Marlon Diloy', 'SCS', 'marlondiloy', '12345678', NULL, 'Window 2'),
(3, 'Carlito Loyola Jr.', 'SAS', 'carlito', '12345678', NULL, 'Window 1'),
(4, 'Marjualita Malapo', 'SAS', 'marjualita', '12345678', NULL, 'Window 2'),
(5, 'Frederick Dalena', 'SAS', 'Frederick', '12345678', NULL, 'Window 3'),
(6, 'Jude Thaddeus Bartolome', 'SAS', 'Jude', '12345678', NULL, 'Window 4'),
(7, 'Brian De Guzman', 'SEA', 'Brian', '12345678', NULL, 'Window 1'),
(8, 'Juliet Niega', 'SEA', 'Juliet', '12345678', NULL, 'Window 2'),
(9, 'Joseph Alcoran', 'SEA', 'Joseph', '12345678', NULL, 'Window 3'),
(10, 'Florenda De Vero', 'SABM', 'Florenda', '12345678', NULL, 'Window 1'),
(11, 'Johnny Boy Tizon', 'SABM', 'Johnny', '12345678', NULL, 'Window 2'),
(12, 'Arnel Villamin', 'SABM', 'Arnel', '12345678', NULL, 'Window 3'),
(13, 'Richard Miguel Butial', 'SHS', 'Richard', '12345678', NULL, 'Window 1'),
(14, 'Jhanna Mae Tadique', 'SHS', 'Jhanna', '12345678', NULL, 'Window 2'),
(15, 'Maria Carina Pontanar', 'SHS', 'Maria', '12345678', NULL, 'Window 3');

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
-- Indexes for table `academics_queue`
--
ALTER TABLE `academics_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounting`
--
ALTER TABLE `accounting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounting_logs`
--
ALTER TABLE `accounting_logs`
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
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `guidance`
--
ALTER TABLE `guidance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `queue_logs`
--
ALTER TABLE `queue_logs`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `academics_logs`
--
ALTER TABLE `academics_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `academics_queue`
--
ALTER TABLE `academics_queue`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `accounting`
--
ALTER TABLE `accounting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `accounting_logs`
--
ALTER TABLE `accounting_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admission_logs`
--
ALTER TABLE `admission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `guidance`
--
ALTER TABLE `guidance`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `program_chairs`
--
ALTER TABLE `program_chairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_logs`
--
ALTER TABLE `queue_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `studentid_list`
--
ALTER TABLE `studentid_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
