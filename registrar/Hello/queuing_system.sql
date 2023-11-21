-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2023 at 08:29 AM
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
  `program` varchar(255) NOT NULL,
  `concern` text NOT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(555) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academics`
--

INSERT INTO `academics` (`id`, `queue_number`, `student_id`, `program`, `concern`, `endorsed_from`, `timestamp`, `remarks`, `transaction`) VALUES
(33, 'SEA006', 'GUEST', 'SEA', 'Brian De Guzman', NULL, '2023-10-25 09:01:02', NULL, 'Subject Registration');

-- --------------------------------------------------------

--
-- Table structure for table `accounting`
--

CREATE TABLE `accounting` (
  `id` int(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` varchar(64) NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `remarks` varchar(64) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounting`
--

INSERT INTO `accounting` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `remarks`, `status`) VALUES
(1, 'R001', '2020-1200', '2023-09-23 14:14:32', NULL, 'gIOaLPHONSE', 0),
(2, 'AS212', '2020-1245', '2023-09-23 14:14:32', NULL, 'THIS IS NICE', 1),
(3, 'SCS007', '2020-120283', '2023-10-25 00:31:42', 'Academics', 'qweqwrqwrqasdqweqweqwe', 0);

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
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL DEFAULT current_timestamp(),
  `time_stamp` varchar(64) NOT NULL,
  `remarks` varchar(64) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `queue_number`, `student_id`, `time_stamp`, `remarks`, `status`) VALUES
(1, 'AC011', '2020-12001', '0000-00-00 00:00:00', 'Hi this is just a test', 0);

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
(1, 'Vincent Rivera', 'SCS', 'offline'),
(2, 'Marlon Diloy', 'SCS', 'offline'),
(3, 'Carlito Loyola Jr.', 'SAS', NULL),
(4, 'Marjualita Malapo', 'SAS', NULL),
(5, 'Frederick Dalena', 'SAS', NULL),
(6, 'Jude Thaddeus Bartolome', 'SAS', NULL),
(7, 'Brian De Guzman', 'SEA', NULL),
(9, 'Juliet Niega', 'SEA', NULL),
(10, 'Joseph Alcoran', 'SEA', NULL),
(11, 'Florenda De Vero', 'SABM', NULL),
(12, 'Johnny Boy Tizon', 'SABM', NULL),
(13, 'Arnel Villamin', 'SABM', NULL),
(14, 'Richard Miguel Butial', 'SHS', NULL),
(15, 'Jhanna Mae Tadique', 'SHS', NULL),
(16, 'Maria Carina Pontanar', 'SHS', NULL);

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
(1, '2020-123', 'AD001', 'ADMISSION', '', '2023-09-21 07:35:47', 0, NULL),
(2, '2020-123', 'R001', 'REGISTRAR', '', '2023-09-23 03:19:13', 1, NULL),
(3, '2020-12345', 'AC0011', 'ACCOUNTING', '', '2023-09-23 06:14:32', 1, NULL),
(4, '2020-123', 'AC002', 'ACCOUNTING', '', '2023-09-23 06:14:40', 0, NULL),
(5, '2020-123', 'AD002', 'ADMISSION', '', '2023-09-24 22:36:25', 0, NULL),
(6, '2020-123', 'AS001', 'ASSETS', '', '2023-09-24 22:37:35', 0, NULL),
(7, '2020-123', 'AC003', 'ACCOUNTING', '', '2023-09-25 06:49:46', 0, NULL),
(8, '2020-123', 'CL001', 'CLINIC', '', '2023-09-28 02:41:32', 0, NULL),
(9, '2020-123', 'AC004', 'ACCOUNTING', '', '2023-09-28 02:50:22', 0, NULL),
(11, '2020-123', 'R002', 'REGISTRAR', '', '2023-09-28 02:50:39', 0, NULL),
(12, '2020-123', 'R003', 'REGISTRAR', '', '2023-09-28 02:50:49', 0, NULL),
(13, '2020-123', 'CL002', 'CLINIC', '', '2023-09-28 02:56:33', 0, NULL),
(14, '2020-123', 'AS002', 'ASSETS', '', '2023-09-28 02:57:34', 0, NULL),
(15, '2020-123', 'AS003', 'ASSETS', '', '2023-09-28 02:57:41', 0, NULL),
(16, 'GUEST', 'AD003', 'ADMISSION', '', '2023-09-28 04:31:40', 0, NULL),
(17, '2020-123', 'R004', 'REGISTRAR', '', '2023-09-28 04:31:46', 0, NULL),
(18, '2020-123', 'CL003', 'CLINIC', '', '2023-09-28 04:35:04', 0, NULL),
(19, '2020-123', 'IT001', 'ITRO', '', '2023-09-28 04:35:15', 0, NULL),
(22, '2020-12001', 'AC011', 'ACCOUNTING', '', '0000-00-00 00:00:00', 1, NULL),
(23, '', '', '', '', '2023-10-06 04:18:29', 0, NULL),
(24, '2020-12001', 'AC123', 'ACCOUNTING', '', '0000-00-00 00:00:00', 0, NULL),
(25, 'GUEST', 'AD004', 'ADMISSION', '', '2023-10-10 14:21:00', 0, NULL),
(29, '231312', 'AD005', 'ADMISSION', 'SEA', '2023-10-10 14:27:08', 0, NULL),
(36, '2020-12028', 'SCS006', 'ACADEMICS', 'SCS', '2023-10-24 16:26:23', 0, NULL),
(37, '2020-12028', 'SCS007', 'ACADEMICS', 'SCS', '2023-10-24 16:31:32', 0, NULL),
(38, 'GUEST', 'SEA006', 'ACADEMICS', '-', '2023-10-25 09:01:02', 0, NULL),
(39, 'GUEST', 'CL004', 'CLINIC', '-', '2023-10-26 13:17:04', 0, NULL),
(40, 'GUEST', 'AD006', 'ADMISSION', '-', '2023-10-26 13:26:47', 0, NULL),
(41, 'GUEST', 'AD007', 'ADMISSION', '-', '2023-10-26 13:27:02', 0, NULL),
(42, 'GUEST', 'R005', 'REGISTRAR', '-', '2023-10-29 05:23:19', 0, NULL),
(43, 'GUEST', 'R006', 'REGISTRAR', '-', '2023-11-02 14:36:09', 0, NULL),
(44, 'GUEST', 'R007', 'REGISTRAR', '-', '2023-11-02 14:36:16', 0, NULL);

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
  `remarks` varchar(64) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `window` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar`
--

INSERT INTO `registrar` (`id`, `queue_number`, `student_id`, `timestamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `window`) VALUES
(4, 'R0004', '4', '2023-11-02 13:14:09', '44', '4', '4', 0, 1),
(5, 'R0005', '5', '2023-11-02 13:14:21', '5', '5', '5', 0, 2),
(6, 'R0006', '6', '2023-11-02 13:14:37', '6', '6', '6', 0, 3),
(7, 'R0007', '7', '2023-11-02 13:14:48', '7', '7', '7', 0, 1),
(8, 'R0008', '8', '2023-11-02 13:15:03', '8', '8', '8', 0, 2),
(9, 'R0009', '9', '2023-11-02 13:15:17', '9', '9', '9', 0, 3),
(10, 'R0010', '10', '2023-11-02 13:16:20', '10', '10', '10', 0, 1);

--
-- Triggers `registrar`
--
DELIMITER $$
CREATE TRIGGER `trg_registrar_window` BEFORE INSERT ON `registrar` FOR EACH ROW BEGIN
    -- Calculate the window value based on the ID
    SET NEW.window = ((NEW.id - 1) % 3) + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `registrar_done`
--

CREATE TABLE `registrar_done` (
  `id` varchar(64) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `timeout` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrar_done`
--

INSERT INTO `registrar_done` (`id`, `queue_number`, `student_id`, `time_stamp`, `endorsed_from`, `transaction`, `remarks`, `status`, `timeout`) VALUES
('', 'R001', '123', '2023-10-30 18:21:04', 'REGISTRAR', '123', '123', 0, NULL),
('', 'R0001', '123', '2023-10-30 18:22:42', 'REGISTRAR', '123', '123', 0, NULL),
('', '23', '321', '2023-10-31 12:00:44', 'REGISTRAR', '312', '321', 0, NULL),
('', '21', '21', '2023-11-01 09:55:48', 'REGISTRAR', '21', '21', 0, NULL),
('', '21', '21', '2023-11-01 10:02:58', 'REGISTRAR', '21', '21', 0, NULL),
('', '21', '21', '2023-11-01 10:07:05', 'REGISTRAR', '21', '21', 0, NULL),
('', '21', '21', '2023-11-01 10:10:46', 'REGISTRAR', '21', '21', 0, NULL);

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
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`ID`, `full_name`, `office`, `username`, `password`, `status`) VALUES
(1, 'Dora D. Explorer', 'CLINIC', 'Dddddora', '123456', NULL),
(2, 'Olaf D. Snowman', 'ACCOUNTING', 'inSummer2', '123456', NULL),
(3, 'Marlon Diloy', 'SCS', 'marlondiloy', '12345678', 'offline');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academics`
--
ALTER TABLE `academics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounting`
--
ALTER TABLE `accounting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `accounting`
--
ALTER TABLE `accounting`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `registrar`
--
ALTER TABLE `registrar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `studentid_list`
--
ALTER TABLE `studentid_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
