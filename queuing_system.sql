-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 01:13 PM
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
  `transaction` varchar(255) DEFAULT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics`
--

INSERT INTO `academics` (`id`, `queue_number`, `student_id`, `program`, `concern`, `endorsed_from`, `timestamp`, `remarks`, `transaction`, `endorsed_to`, `status`) VALUES
(2, 'R12301', '2020-120018', 'SCS', 'MARLON DILOY', 'Accounting', '2023-11-09 17:25:09', 'Test lang po ito', 'Registrar', NULL, 0),
(3, 'ROO1', '2020-120018', 'SAS', 'Carlito Loyola Jr.', 'Accounting', '2023-11-09 17:08:30', 'Trial', 'Payment', NULL, 0),
(4, 'ROO1', '2020-120018', 'SCS', 'Marlon Diloy', 'Accounting', '2023-11-09 17:08:30', 'TEST', 'Payment', NULL, 0),
(5, 'ROO12', '2020-120018', 'SCS', 'Marlon Diloy', 'Registrar', '2023-11-09 17:08:30', 'Test if working pa.', 'Registrar', NULL, 0),
(6, 'SCS013', 'GUEST', 'SCS', 'Vincent Rivera', NULL, '2023-11-16 05:39:02', NULL, 'Subject Registration', NULL, 0),
(7, 'SCS014', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:39:21', NULL, 'Subject Registration', NULL, 0),
(8, 'SCS015', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:40:31', NULL, 'Subject Registration', NULL, 0),
(9, 'SCS016', 'GUEST', 'SCS', 'Vincent Rivera', NULL, '2023-11-16 05:42:09', NULL, 'Subject Registration', NULL, 0),
(10, 'SCS017', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:42:20', NULL, 'Subject Registration', NULL, 0),
(11, 'SCS018', 'GUEST', 'SCS', 'Vincent Rivera', NULL, '2023-11-16 05:46:10', NULL, 'Subject Registration', NULL, 0),
(12, 'SCS019', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:46:21', NULL, 'Subject Registration', NULL, 0),
(13, 'SCS020', 'GUEST', 'SCS', 'Olaf', NULL, '2023-11-16 05:47:28', NULL, 'Subject Registration', NULL, 0),
(14, 'SCS021', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 11:52:45', NULL, 'Subject Registration', NULL, 0),
(15, 'SAS002', 'GUEST', 'SAS', 'Carlito Loyola Jr.', NULL, '2023-11-16 11:52:50', NULL, 'Subject Registration', NULL, 0),
(16, 'SCS022', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 12:05:06', NULL, 'Subject Registration', NULL, 0);

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
  `status` int(255) NOT NULL DEFAULT 0,
  `endorsed_to` varchar(255) NOT NULL,
  `course` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics_queue`
--

INSERT INTO `academics_queue` (`id`, `queue_number`, `student_id`, `program`, `concern`, `endorsed_from`, `timestamp`, `remarks`, `transaction`, `status`, `endorsed_to`, `course`) VALUES
(1, 'SCS003', '2020-120283', 'SCS', 'Marlon Diloy', 'Front desk', '2023-11-09 09:06:14', NULL, 'Subject Registration', 1, '', NULL),
(2, 'R12O1', '2020-120018', 'SCS', 'Marlon Diloy', 'Accounting', '2023-11-09 17:08:30', 'Academics queue', 'Payment', 0, '', NULL),
(3, 'SCS013', 'GUEST', 'SCS', 'Vincent Rivera', NULL, '2023-11-16 05:39:02', NULL, 'Subject Registration', 0, '', NULL),
(4, 'SCS014', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:39:21', NULL, 'Subject Registration', 0, '', NULL),
(5, 'SCS015', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:40:31', NULL, 'Subject Registration', 0, '', ''),
(6, 'SCS016', 'GUEST', 'SCS', 'Vincent Rivera', NULL, '2023-11-16 05:42:09', NULL, 'Subject Registration', 0, '', ''),
(7, 'SCS017', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:42:20', NULL, 'Subject Registration', 0, '', ''),
(8, 'SCS018', 'GUEST', 'SCS', 'Vincent Rivera', NULL, '2023-11-16 05:46:10', NULL, 'Subject Registration', 0, '', ''),
(9, 'SCS019', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 05:46:21', NULL, 'Subject Registration', 0, '', ''),
(10, 'SCS020', 'GUEST', 'SCS', 'Olaf', NULL, '2023-11-16 05:47:28', NULL, 'Subject Registration', 0, '', 'Computer Science'),
(11, 'SCS021', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 11:52:45', NULL, 'Subject Registration', 0, '', ''),
(12, 'SAS002', 'GUEST', 'SAS', 'Carlito Loyola Jr.', NULL, '2023-11-16 11:52:50', NULL, 'Subject Registration', 0, '', ''),
(13, 'SCS022', 'GUEST', 'SCS', 'Marlon Diloy', NULL, '2023-11-16 12:05:06', NULL, 'Subject Registration', 0, '', '');

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
  `availability` int(11) NOT NULL DEFAULT 0,
  `window` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounting`
--

INSERT INTO `accounting` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `availability`, `window`, `endorsed_to`) VALUES
(1, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Registrar', 'Payment', 'Uniform Payment', 0, 0, '', NULL),
(2, 'R1OO1', '2020-120018', '2023-11-09 17:25:09', 'Registrar', 'Registrar', 'Payment', 0, 0, '', NULL),
(11, 'ROO12', '2020-120018', '2023-11-09 17:08:30', 'ITRO', 'Registrar', 'Payment', 0, 0, '', NULL),
(13, 'R1OO441', '2020-120018', '2023-11-09 17:25:09', 'Registrar', 'Registrar', 'Payment', 0, 0, '', NULL),
(15, 'R12O1', '2020-120018', '2023-11-09 17:08:30', 'ITRO', 'Payment', 'Uniform Payment', 0, 0, '', NULL),
(16, 'R12301', '2020-120018', '2023-11-09 17:25:09', 'Registrar', 'Registrar', 'Payment', 0, 0, '', NULL),
(17, 'RO1240', '2020-120018', '2023-11-09 17:08:30', 'Regisrar', 'Registrar', 'Payment', 0, 0, '', NULL),
(18, 'R004', '2313213', '2023-11-12 11:03:34', 'REGISTRAR', 'Payment', 'hello', 0, 0, '', 'ACCOUNTING'),
(19, 'R004', 'GUEST', '2023-11-15 14:53:13', 'REGISTRAR', 'Payment', '23123', 0, 0, '', 'ACCOUNTING'),
(20, 'AC001', 'GUEST', '2023-11-16 06:49:21', NULL, '', NULL, 0, 0, '', NULL),
(21, 'AC002', 'GUEST', '2023-11-16 06:49:37', NULL, '', NULL, 0, 0, '', NULL),
(22, 'AC001', 'GUEST', '2023-11-16 07:38:39', NULL, '', NULL, 0, 0, '', NULL),
(23, 'AC001', 'GUEST', '2023-11-16 11:56:38', NULL, '', NULL, 0, 0, '', NULL),
(24, 'AC002', 'GUEST', '2023-11-16 12:01:49', NULL, '', NULL, 0, 0, '', NULL);

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
  `status` int(255) NOT NULL,
  `window` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounting_logs`
--

INSERT INTO `accounting_logs` (`id`, `queue_number`, `student_id`, `timestamp`, `timeout`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(1, 'R001', 2020, '2023-09-23 14:14:32.000000', '2023-11-09 15:20:57.505655', 'Registrar', 'Payments', 'End na', 0, '');

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
  `status` int(11) DEFAULT 0,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `program`, `status`, `endorsed_to`) VALUES
(1, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 'Endorse to admission test.', NULL, 1, NULL),
(2, 'ROO1', '2020-120018', '2023-11-09 17:08:30', 'Accounting', 'Payment', 'SCS', 'SCS', 1, NULL),
(3, 'AD001', 'GUEST', '2023-11-13 07:10:09', NULL, '', '', '-', 1, NULL),
(4, 'AD002', 'GUEST', '2023-11-13 07:13:06', NULL, '', '', '-', 1, NULL),
(5, 'AD003', 'GUEST', '2023-11-15 23:18:06', NULL, '', '', '-', 1, NULL),
(6, 'AD004', 'GUEST', '2023-11-15 23:18:08', NULL, '', '', '-', 1, NULL),
(7, 'AD005', 'GUEST', '2023-11-15 23:18:10', NULL, '', '', '-', 1, NULL),
(8, 'AD006', 'GUEST', '2023-11-15 23:18:12', NULL, '', '', '-', 1, NULL),
(9, 'AD007', 'GUEST', '2023-11-15 23:18:13', NULL, '', '', '-', 0, NULL),
(10, 'AD008', 'GUEST', '2023-11-15 23:18:15', NULL, '', '', '-', 0, NULL),
(11, 'AD009', 'GUEST', '2023-11-15 23:18:17', NULL, '', '', '-', 0, NULL),
(12, 'AD010', 'GUEST', '2023-11-15 23:18:18', NULL, '', '', '-', 0, NULL),
(13, 'AD011', 'GUEST', '2023-11-15 23:18:20', NULL, '', '', '-', 0, NULL),
(14, 'AD012', 'GUEST', '2023-11-15 23:18:22', NULL, '', '', '-', 0, NULL),
(15, 'AD013', 'GUEST', '2023-11-15 23:18:24', NULL, '', '', '-', 0, NULL),
(16, 'AD014', 'GUEST', '2023-11-15 23:18:26', NULL, '', '', '-', 0, NULL),
(17, 'AD015', 'GUEST', '2023-11-15 23:18:52', NULL, '', '', '-', 0, NULL),
(18, 'AD016', 'GUEST', '2023-11-15 23:18:54', NULL, '', '', '-', 0, NULL),
(19, 'AD017', 'GUEST', '2023-11-15 23:18:56', NULL, '', '', '-', 0, NULL),
(20, 'AD018', 'GUEST', '2023-11-15 23:18:57', NULL, '', '', '-', 0, NULL),
(21, 'AD019', 'GUEST', '2023-11-15 23:18:59', NULL, '', '', '-', 0, NULL),
(22, 'AD020', 'GUEST', '2023-11-15 23:19:01', NULL, '', '', '-', 0, NULL),
(23, 'AD021', 'GUEST', '2023-11-15 23:19:03', NULL, '', '', '-', 0, NULL),
(24, 'AD022', 'GUEST', '2023-11-15 23:19:04', NULL, '', '', '-', 0, NULL),
(25, 'AD023', 'GUEST', '2023-11-15 23:19:06', NULL, '', '', '-', 0, NULL),
(26, 'AD024', 'GUEST', '2023-11-15 23:19:07', NULL, '', '', '-', 0, NULL),
(27, 'AD025', 'GUEST', '2023-11-15 23:19:09', NULL, '', '', '-', 0, NULL),
(28, 'AD026', 'GUEST', '2023-11-15 23:19:10', NULL, '', '', '-', 0, NULL),
(29, 'AD027', 'GUEST', '2023-11-15 23:19:12', NULL, '', '', '-', 0, NULL),
(30, 'AD028', 'GUEST', '2023-11-15 23:19:14', NULL, '', '', '-', 0, NULL),
(31, 'AD029', 'GUEST', '2023-11-15 23:19:16', NULL, '', '', '-', 1, NULL),
(32, 'AD030', 'GUEST', '2023-11-15 23:19:17', NULL, '', '', '-', 0, NULL),
(33, 'AD031', 'GUEST', '2023-11-15 23:19:19', NULL, '', '', '-', 0, NULL),
(34, 'AD032', 'GUEST', '2023-11-15 23:19:20', NULL, '', '', '-', 0, NULL),
(35, 'AD033', 'GUEST', '2023-11-15 23:19:22', NULL, '', '', '-', 0, NULL),
(36, 'AD034', 'GUEST', '2023-11-15 23:19:24', NULL, '', '', '-', 0, NULL),
(37, 'AD035', 'GUEST', '2023-11-15 23:19:26', NULL, '', '', '-', 0, NULL),
(38, 'AD036', 'GUEST', '2023-11-15 23:19:28', NULL, '', '', '-', 0, NULL),
(39, 'AD037', 'GUEST', '2023-11-15 23:19:30', NULL, '', '', '-', 0, NULL),
(40, 'AD038', 'GUEST', '2023-11-15 23:19:32', NULL, '', '', '-', 0, NULL),
(41, 'AD039', 'GUEST', '2023-11-15 23:19:33', NULL, '', '', '-', 0, NULL),
(42, 'AD040', 'GUEST', '2023-11-15 23:19:35', NULL, '', '', '-', 0, NULL),
(43, 'AD041', 'GUEST', '2023-11-15 23:19:36', NULL, '', '', '-', 0, NULL),
(44, 'AD042', 'GUEST', '2023-11-15 23:19:38', NULL, '', '', '-', 0, NULL),
(45, 'AD043', 'GUEST', '2023-11-15 23:19:40', NULL, '', '', '-', 0, NULL),
(46, 'AD044', 'GUEST', '2023-11-15 23:19:41', NULL, '', '', '-', 0, NULL),
(47, 'AD045', 'GUEST', '2023-11-15 23:19:55', NULL, '', '', '-', 0, NULL),
(48, 'AD046', 'GUEST', '2023-11-15 23:19:57', NULL, '', '', '-', 0, NULL),
(49, 'AD047', 'GUEST', '2023-11-15 23:19:58', NULL, '', '', '-', 0, NULL),
(50, 'AD048', 'GUEST', '2023-11-15 23:19:59', NULL, '', '', '-', 0, NULL),
(51, 'AD049', 'GUEST', '2023-11-15 23:20:01', NULL, '', '', '-', 0, NULL),
(52, 'AD050', 'GUEST', '2023-11-15 23:20:03', NULL, '', '', '-', 0, NULL),
(53, 'AD051', 'GUEST', '2023-11-15 23:20:05', NULL, '', '', '-', 0, NULL),
(54, 'AD001', 'GUEST', '2023-11-16 00:20:07', NULL, '', '', '-', 0, NULL),
(55, 'AD001', 'GUEST', '2023-11-16 00:20:30', NULL, '', '', '-', 0, NULL),
(56, 'AD001', 'GUEST', '2023-11-16 00:21:52', NULL, '', '', '-', 0, NULL),
(57, 'AD001', 'GUEST', '2023-11-16 00:26:10', NULL, '', '', '-', 0, NULL),
(58, 'AD001', 'GUEST', '2023-11-16 00:35:36', NULL, '', '', '-', 0, NULL),
(59, 'AD001', 'GUEST', '2023-11-16 00:37:17', NULL, '', '', '-', 0, NULL),
(60, 'AD001', 'GUEST', '2023-11-16 00:52:17', NULL, '', '', '-', 0, NULL);

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
(11, '2020-123', 'AD0020', NULL, 'qwe', NULL, NULL, 0),
(13, '2020-120018', 'ROO1', 'REGISTRAR', '', '2023-11-10 01:08:30', '2023-11-15 16:32:04', NULL),
(14, 'GUEST', 'AD004', 'CLINIC', 'asdasdasd', '2023-11-16 07:18:08', '2023-11-16 07:33:42', NULL),
(15, 'GUEST', 'AD002', 'CLINIC', 'Hi clinic', '2023-11-13 15:13:06', '2023-11-16 07:33:57', NULL),
(16, 'GUEST', 'AD005', 'ADMISSION', '', '2023-11-16 07:18:10', '2023-11-16 07:34:01', NULL),
(17, 'GUEST', 'AD001', 'ADMISSION', '', '2023-11-13 15:10:09', '2023-11-16 07:34:04', NULL),
(18, 'GUEST', 'AD003', 'CLINIC', '', '2023-11-16 07:18:06', '2023-11-16 07:34:09', NULL),
(19, 'GUEST', 'AD006', 'REGISTRAR', '', '2023-11-16 07:18:12', '2023-11-16 07:34:15', NULL),
(20, 'GUEST', 'AD029', 'CLINIC', '', '2023-11-16 07:19:16', '2023-11-16 07:34:30', NULL);

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
  `status` int(11) DEFAULT 0,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `endorsed_to`) VALUES
(1, 'ROO1', '2020-120018', '2023-11-10 01:08:30', 'Accounting', 'Accounting', 'Test', 0, NULL),
(2, 'RO1240', '2020-120018', '2023-11-10 01:08:30', 'Accounting', 'Registrar', 'This is test for assets.', 0, NULL);

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
  `status` int(11) NOT NULL,
  `endorsed_from` varchar(64) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`id`, `queue_number`, `student_id`, `remarks`, `transaction`, `timestamp`, `status`, `endorsed_from`, `endorsed_to`) VALUES
(14, 'R12O1', '2020-120018', 'Test to clinic', 'Payment', '2023-11-09 17:08:30', 0, 'Accounting', NULL),
(15, 'CL001', 'GUEST', '', NULL, '2023-11-14 16:28:40', 0, '', NULL),
(16, 'R002', '2020-1230', 'hello', 'Payment', '2023-11-15 14:50:22', 0, 'REGISTRAR', 'CLINIC');

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
-- Table structure for table `display`
--

CREATE TABLE `display` (
  `ID` int(11) NOT NULL,
  `queue_number` varchar(255) NOT NULL,
  `window` int(11) NOT NULL,
  `officeName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `display`
--

INSERT INTO `display` (`ID`, `queue_number`, `window`, `officeName`) VALUES
(4, 'No Queue Number', 1, 'REGISTRAR'),
(5, 'R001', 1, 'REGISTRAR'),
(6, 'R004', 1, 'REGISTRAR'),
(7, 'R12301', 1, 'REGISTRAR'),
(8, 'ROO12', 3, 'REGISTRAR'),
(9, 'R12O1', 1, 'REGISTRAR'),
(10, 'AC007', 1, 'ACCOUNTING'),
(11, 'AC007', 1, 'ACCOUNTING'),
(12, 'AC008', 1, 'ACCOUNTING'),
(13, 'AC007', 1, 'ACCOUNTING'),
(16, 'R1OO441', 1, 'REGISTRAR'),
(17, 'R001', 1, 'REGISTRAR'),
(18, 'R1OO441', 1, 'REGISTRAR'),
(19, 'R12301', 1, 'REGISTRAR'),
(20, 'R1OO441', 1, 'REGISTRAR'),
(21, 'ROO1', 1, 'REGISTRAR'),
(22, 'R002', 1, 'REGISTRAR'),
(23, 'R12O1', 1, 'REGISTRAR'),
(24, 'ROO12', 1, 'REGISTRAR'),
(25, 'ROO1', 1, 'REGISTRAR'),
(26, 'AD006', 2, 'REGISTRAR');

-- --------------------------------------------------------

--
-- Table structure for table `display_a`
--

CREATE TABLE `display_a` (
  `ID` int(11) NOT NULL,
  `window` int(11) NOT NULL,
  `collegeName` varchar(255) NOT NULL,
  `queue_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `endorsed_from` varchar(64) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guidance`
--

INSERT INTO `guidance` (`id`, `queue_number`, `student_id`, `remarks`, `transaction`, `timestamp`, `status`, `endorsed_from`, `endorsed_to`) VALUES
(1, 'GD0011', '2020-123456', 'BSDFSF', 'SDFSDFSD', '2023-11-03 11:30:44', 0, '', NULL),
(2, 'GD0022', '2021-123321', 'EGSDGSDG', 'EWGSDGDS', '2023-11-03 11:30:46', 1, '', NULL),
(14, 'R1OO441', '2020-120018', 'Finally', 'Registrar', '2023-11-09 17:25:09', NULL, 'Accounting', NULL),
(15, 'G001', 'GUEST', '', NULL, '2023-11-16 11:52:41', NULL, '', NULL);

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
  `endorsed_from` varchar(64) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itso`
--

INSERT INTO `itso` (`id`, `queue_number`, `student_id`, `remarks`, `transaction`, `timestamp`, `status`, `endorsed_from`, `endorsed_to`) VALUES
(0, 'GD0033', '2020-543221', 'Validation of ID', NULL, '2023-10-26 18:19:44', NULL, '', NULL),
(0, 'R1OO1', '2020-120018', 'itro', 'Registrar', '2023-11-09 17:25:09', NULL, 'Accounting', NULL);

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
  `user_id` int(11) NOT NULL,
  `course` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_chairs`
--

INSERT INTO `program_chairs` (`id`, `full_name`, `program`, `status`, `user_id`, `course`) VALUES
(2, 'Marlon Diloy', 'SCS', NULL, 2, NULL),
(3, 'Carlito Loyola Jr.', 'SAS', NULL, 3, NULL),
(4, 'Marjualita Malapo', 'SAS', NULL, 4, NULL),
(5, 'Frederick Dalena', 'SAS', NULL, 5, NULL),
(6, 'Jude Thaddeus Bartolome', 'SAS', NULL, 6, NULL),
(7, 'Brian De Guzman', 'SEA', NULL, 7, NULL),
(8, 'Juliet Niega', 'SEA', NULL, 8, NULL),
(9, 'Joseph Alcoran', 'SEA', NULL, 9, NULL),
(10, 'Florenda De Vero', 'SABM', NULL, 10, NULL),
(11, 'Johnny Boy Tizon', 'SABM', NULL, 11, NULL),
(12, 'Arnel Villamin', 'SABM', NULL, 12, NULL),
(13, 'Richard Miguel Butial', 'SHS', NULL, 13, NULL),
(14, 'Jhanna Mae Tadique', 'SHS', NULL, 14, NULL),
(15, 'Maria Carina Pontanar', 'SHS', NULL, 15, NULL),
(20, 'Vincent Rivera', 'SCS', NULL, 1, NULL);

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
(10, 'GUEST', 'SCS015', 'ACADEMICS', '-', '2023-11-16 05:40:31', 0, NULL, 'kiosk'),
(11, '2020-123', 'R002', 'REGISTRAR', '', '2023-09-28 02:50:39', 0, NULL, ''),
(12, '2020-123', 'R003', 'REGISTRAR', '', '2023-09-28 02:50:49', 0, NULL, ''),
(13, '2020-123', 'CL002', 'CLINIC', '', '2023-09-28 02:56:33', 0, NULL, ''),
(14, '2020-123', 'AS002', 'ASSETS', '', '2023-09-28 02:57:34', 0, NULL, ''),
(15, '2020-123', 'AS003', 'ASSETS', '', '2023-09-28 02:57:41', 0, NULL, ''),
(16, 'GUEST', 'AD003', 'ADMISSION', '', '2023-09-28 04:31:40', 0, NULL, ''),
(17, '2020-123', 'R004', 'REGISTRAR', '', '2023-09-28 04:31:46', 0, NULL, ''),
(18, '2020-123', 'CL003', 'CLINIC', '', '2023-09-28 04:35:04', 0, NULL, ''),
(19, '2020-123', 'IT001', 'ITRO', '', '2023-09-28 04:35:15', 0, NULL, ''),
(20, 'GUEST', 'AD007', 'ADMISSION', '-', '2023-11-16 06:18:13', 0, NULL, 'kiosk'),
(21, 'GUEST', 'AD008', 'ADMISSION', '-', '2023-11-16 06:18:15', 0, NULL, 'kiosk'),
(22, '2020-12001', 'AC011', 'ACCOUNTING', '', '0000-00-00 00:00:00', 1, NULL, ''),
(23, 'GUEST', 'AD010', 'ADMISSION', '-', '2023-11-16 06:18:18', 0, NULL, 'kiosk'),
(24, '2020-12001', 'AC123', 'ACCOUNTING', '', '0000-00-00 00:00:00', 0, NULL, ''),
(25, 'GUEST', 'AD004', 'ADMISSION', '', '2023-10-10 14:21:00', 0, NULL, ''),
(26, 'GUEST', 'AD013', 'ADMISSION', '-', '2023-11-16 06:18:24', 0, NULL, 'kiosk'),
(27, 'GUEST', 'AD014', 'ADMISSION', '-', '2023-11-16 06:18:26', 0, NULL, 'kiosk'),
(28, 'GUEST', 'AD015', 'ADMISSION', '-', '2023-11-16 06:18:52', 0, NULL, 'kiosk'),
(29, '231312', 'AD005', 'ADMISSION', 'SEA', '2023-10-10 14:27:08', 1, NULL, ''),
(30, 'GUEST', 'AD017', 'ADMISSION', '-', '2023-11-16 06:18:56', 0, NULL, 'kiosk'),
(31, 'GUEST', 'AD018', 'ADMISSION', '-', '2023-11-16 06:18:57', 0, NULL, 'kiosk'),
(32, 'GUEST', 'AD019', 'ADMISSION', '-', '2023-11-16 06:18:59', 0, NULL, 'kiosk'),
(33, 'GUEST', 'AD020', 'ADMISSION', '-', '2023-11-16 06:19:01', 0, NULL, 'kiosk'),
(34, 'GUEST', 'AD021', 'ADMISSION', '-', '2023-11-16 06:19:03', 0, NULL, 'kiosk'),
(35, 'GUEST', 'AD022', 'ADMISSION', '-', '2023-11-16 06:19:04', 0, NULL, 'kiosk'),
(36, 'GUEST', 'AD023', 'ADMISSION', '-', '2023-11-16 06:19:06', 0, NULL, 'kiosk'),
(37, 'GUEST', 'AD024', 'ADMISSION', '-', '2023-11-16 06:19:07', 0, NULL, 'kiosk'),
(38, 'GUEST', 'AD025', 'ADMISSION', '-', '2023-11-16 06:19:09', 0, NULL, 'kiosk'),
(39, 'GUEST', 'AD026', 'ADMISSION', '-', '2023-11-16 06:19:10', 0, NULL, 'kiosk'),
(40, 'GUEST', 'AD027', 'ADMISSION', '-', '2023-11-16 06:19:12', 0, NULL, 'kiosk'),
(41, 'GUEST', 'AD028', 'ADMISSION', '-', '2023-11-16 06:19:14', 0, NULL, 'kiosk'),
(42, 'GUEST', 'AD029', 'ADMISSION', '-', '2023-11-16 06:19:16', 1, NULL, 'kiosk'),
(43, 'GUEST', 'AD030', 'ADMISSION', '-', '2023-11-16 06:19:17', 0, NULL, 'kiosk'),
(44, 'GUEST', 'AD031', 'ADMISSION', '-', '2023-11-16 06:19:19', 0, NULL, 'kiosk'),
(45, 'GUEST', 'AD032', 'ADMISSION', '-', '2023-11-16 06:19:20', 0, NULL, 'kiosk'),
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
(57, 'GUEST', 'AC125', 'ACCOUNTING', '-', '2023-11-11 13:46:44', 0, NULL, 'kiosk'),
(58, 'GUEST', 'AD045', 'ADMISSION', '-', '2023-11-16 06:19:55', 0, NULL, 'kiosk'),
(59, 'GUEST', 'AD046', 'ADMISSION', '-', '2023-11-16 06:19:57', 0, NULL, 'kiosk'),
(60, 'GUEST', 'AD047', 'ADMISSION', '-', '2023-11-16 06:19:58', 0, NULL, 'kiosk'),
(61, 'GUEST', 'AD048', 'ADMISSION', '-', '2023-11-16 06:19:59', 0, NULL, 'kiosk'),
(62, 'GUEST', 'AD049', 'ADMISSION', '-', '2023-11-16 06:20:01', 0, NULL, 'kiosk'),
(63, 'GUEST', 'AD050', 'ADMISSION', '-', '2023-11-16 06:20:03', 0, NULL, 'kiosk'),
(64, 'GUEST', 'AD051', 'ADMISSION', '-', '2023-11-16 06:20:05', 0, NULL, 'kiosk'),
(65, 'GUEST', 'AC001', 'ACCOUNTING', '-', '2023-11-16 06:49:21', 0, NULL, 'kiosk'),
(66, 'GUEST', 'AC002', 'ACCOUNTING', '-', '2023-11-16 06:49:37', 0, NULL, 'kiosk'),
(67, 'GUEST', 'R001', 'REGISTRAR', '-', '2023-11-16 07:33:18', 0, NULL, 'kiosk'),
(68, 'GUEST', 'R001', 'REGISTRAR', '-', '2023-11-16 07:33:18', 0, NULL, 'kiosk'),
(69, 'GUEST', 'AD001', 'ADMISSION', '-', '2023-11-16 07:35:36', 0, NULL, 'kiosk'),
(70, 'GUEST', 'AD001', 'ADMISSION', '-', '2023-11-16 07:37:17', 0, NULL, 'kiosk'),
(71, 'GUEST', 'AC001', 'ACCOUNTING', '-', '2023-11-16 07:38:39', 0, NULL, 'kiosk'),
(72, 'GUEST', 'AD001', 'ADMISSION', '-', '2023-11-16 07:52:17', 0, NULL, 'kiosk'),
(73, 'GUEST', 'R001', 'REGISTRAR', '-', '2023-11-16 11:52:39', 0, NULL, 'kiosk'),
(74, 'GUEST', 'G001', 'GUIDANCE', '-', '2023-11-16 11:52:41', 0, NULL, 'kiosk'),
(75, 'GUEST', 'SCS021', 'ACADEMICS', '-', '2023-11-16 11:52:45', 0, NULL, 'kiosk'),
(76, 'GUEST', 'SAS002', 'ACADEMICS', '-', '2023-11-16 11:52:50', 0, NULL, 'kiosk'),
(77, 'GUEST', 'AC001', 'ACCOUNTING', '-', '2023-11-16 11:56:38', 0, NULL, 'kiosk'),
(78, 'GUEST', 'AC002', 'ACCOUNTING', '-', '2023-11-16 12:01:49', 0, NULL, 'kiosk'),
(79, 'GUEST', 'SCS022', 'ACADEMICS', '-', '2023-11-16 12:05:06', 0, NULL, 'kiosk');

-- --------------------------------------------------------

--
-- Table structure for table `registrar`
--

CREATE TABLE `registrar` (
  `id` int(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `window` int(11) DEFAULT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('', 'RO1240', '2020-120018', 'REGISTRAR', 'COMPLETED', '', 1, '2023-11-15 05:27:45', '2023-11-09 17:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `registrar_logs`
--

CREATE TABLE `registrar_logs` (
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
-- Dumping data for table `registrar_logs`
--

INSERT INTO `registrar_logs` (`id`, `queue_number`, `student_id`, `endorsed_from`, `transaction`, `remarks`, `status`, `timeout`, `timestamp`) VALUES
('', 'R023', 'GUEST', 'REGISTRAR', 'COMPLETED', 'dasd', 1, '2023-11-15 11:06:52', '2023-11-15 10:54:52');

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
  `window` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`ID`, `full_name`, `office`, `username`, `password`, `status`, `window`) VALUES
(1, 'Vincent Rivera', 'SCS', 'vincentrivera', '12345678', NULL, 1),
(2, 'Marlon Diloy', 'SCS', 'marlondiloy', 'defac44447b57f152d14f30cea7a73cb', NULL, 0),
(3, 'Carlito Loyola Jr.', 'SAS', 'carlito', '12345678', NULL, 0),
(4, 'Marjualita Malapo', 'SAS', 'marjualita', '12345678', NULL, 0),
(5, 'Frederick Dalena', 'SAS', 'Frederick', '12345678', NULL, 0),
(6, 'Jude Thaddeus Bartolome', 'SAS', 'Jude', '12345678', NULL, 0),
(7, 'Brian De Guzman', 'SEA', 'Brian', '12345678', NULL, 0),
(8, 'Juliet Niega', 'SEA', 'Juliet', '12345678', NULL, 0),
(9, 'Joseph Alcoran', 'SEA', 'Joseph', '12345678', NULL, 0),
(10, 'Florenda De Vero', 'SABM', 'Florenda', '12345678', NULL, 0),
(11, 'Johnny Boy Tizon', 'SABM', 'Johnny', '12345678', NULL, 0),
(12, 'Arnel Villamin', 'SABM', 'Arnel', '12345678', NULL, 0),
(13, 'Richard Miguel Butial', 'SHS', 'Richard', '12345678', NULL, 0),
(14, 'Jhanna Mae Tadique', 'SHS', 'Jhanna', '12345678', NULL, 0),
(15, 'Maria Carina Pontanar', 'SHS', 'Maria', '12345678', NULL, 0),
(22, 'Doras', 'SCS', 'marga', '12345678', NULL, 4),
(23, 'Dora D. Explorer', 'REGISTRAR', 'wowee', '12345678', NULL, 2);

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
-- Indexes for table `display`
--
ALTER TABLE `display`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `display_a`
--
ALTER TABLE `display_a`
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
-- Indexes for table `registrar`
--
ALTER TABLE `registrar`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `academics_logs`
--
ALTER TABLE `academics_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `academics_queue`
--
ALTER TABLE `academics_queue`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `accounting`
--
ALTER TABLE `accounting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `admission_logs`
--
ALTER TABLE `admission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `display`
--
ALTER TABLE `display`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `display_a`
--
ALTER TABLE `display_a`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guidance`
--
ALTER TABLE `guidance`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `program_chairs`
--
ALTER TABLE `program_chairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_logs`
--
ALTER TABLE `queue_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `registrar`
--
ALTER TABLE `registrar`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `studentid_list`
--
ALTER TABLE `studentid_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
