-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2023 at 04:14 PM
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
(0, 'Z001', '2020-120951', 'SAS', 'Jude Thaddeus Bartolome ', 'REGISTRAR', '2023-11-13 12:27:17', '2121', 'DSA', 0);

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
(0, 'R001', '2121', '2023-11-13 14:43:11', 'REGISTRAR', '2121', '2121', 0, 0);

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
(82, 'ONEPIECE', '2121', '2023-10-30 08:17:47', 'REGISTRAR', '2121', '2121', NULL, 0),
(83, 'R002', '2020-120951', NULL, NULL, '2121', '1212', NULL, 0);

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
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(0, 'R001', '2121', '2023-11-13 15:02:27', 'REGISTRAR', '2121', '2112', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(0, 'R001', '2121', '2023-11-13 15:06:16', 'REGISTRAR', '2121', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `guidance`
--

CREATE TABLE `guidance` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guidance`
--

INSERT INTO `guidance` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(0, 'G0001', '2121', '2023-11-13 15:06:43', 'REGISTRAR', '2121', '2121', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `itso`
--

CREATE TABLE `itso` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itso`
--

INSERT INTO `itso` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(0, 'R001', '2121', '2023-11-13 15:04:15', 'REGISTRAR', '2121', '2121', 0, '');

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
(1, '2020-12092', 'R099', 'REGISTRAR', '2121', '2023-11-13 10:51:13', 2121, '212');

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
('', 'R001', '2121', '2121', '2121', '2112', 1, '2023-11-13 15:08:17', '2023-11-13 15:08:12'),
('', 'R002', '2121', '2121', '2121', '2121', 1, '2023-11-13 15:08:37', '2023-11-13 15:08:33');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `admission_logs`
--
ALTER TABLE `admission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
