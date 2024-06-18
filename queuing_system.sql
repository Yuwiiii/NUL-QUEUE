-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 10:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

-- --------------------------------------------------------

--
-- Table structure for table `academics_logs`
--

CREATE TABLE `academics_logs` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(255) NOT NULL,
  `student_id` varchar(12) NOT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `timeout` timestamp NULL DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `availability` int(255) NOT NULL DEFAULT 0,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting`
--

CREATE TABLE `accounting` (
  `id` int(11) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `availability` int(11) NOT NULL DEFAULT 0,
  `window` varchar(255) NOT NULL DEFAULT '0',
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accounting_logs`
--

CREATE TABLE `accounting_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `timeout` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `program` varchar(255) DEFAULT NULL,
  `endorsed_from` varchar(255) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(255) NOT NULL DEFAULT 1,
  `window` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `transaction` varchar(255) DEFAULT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `timeout` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `availability` int(11) NOT NULL DEFAULT 0,
  `window` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_logs`
--

CREATE TABLE `assets_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `endorsed_from` varchar(255) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_to` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `timeout` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `availability` int(11) NOT NULL DEFAULT 0,
  `window` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_logs`
--

CREATE TABLE `clinic_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
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
  `officeName` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `guidance_logs`
--

CREATE TABLE `guidance_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `endorsed_from` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_to` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(255) NOT NULL DEFAULT 1,
  `timeout` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `transaction` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `availability` int(11) NOT NULL DEFAULT 0,
  `window` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itso_logs`
--

CREATE TABLE `itso_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `endorsed_from` varchar(255) NOT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
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
(13, 'F', 'ACADEMICS', 0),
(23, 'BX', 'BULLDOGEXCHANGE', 0);

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
(1, 'Vincent Rivera', 'SCS', 'available', 0, 'BSCS'),
(2, 'Marlon Diloy', 'SCS', 'offline', 0, 'BSIT_BSIS'),
(3, 'Carlito Loyola Jr.', 'SAS', 'available', 0, 'BMMA_ABCOMM'),
(4, 'Marjualita Malapo', 'SAS', 'available', 0, 'BSPSYCH'),
(5, 'Frederick Dalena', 'SAS', 'available', 0, 'BSESS'),
(6, 'Jude Thaddeus Bartolome', 'SAS', 'available', 0, 'BSCRIM'),
(7, 'Brian De Guzman', 'SEA', 'available', 0, 'BSCE'),
(9, 'Juliet Niega', 'SEA', 'available', 0, 'BSCPE'),
(10, 'Joseph Alcoran', 'SEA', 'available', 0, 'BSARCHI'),
(11, 'Florenda De Vero', 'SABM', 'available', 0, 'BSTM'),
(12, 'Johnny Boy Tizon', 'SABM', 'available', 0, 'BSBA'),
(13, 'Arnel Villamin', 'SABM', 'available', 0, 'BSA'),
(14, 'Richard Miguel Butial', 'SHS', 'offline', 0, 'ABM'),
(15, 'Jhanna Mae Tadique', 'SHS', 'offline', 0, 'STEM'),
(16, 'Maria Carina Pontanar', 'SHS', 'available', 0, 'HUMSS');

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `queue_number` varchar(10) NOT NULL,
  `office` varchar(20) NOT NULL,
  `program` varchar(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `endorsed` varchar(255) NOT NULL,
  `studentstatus` int(255) NOT NULL DEFAULT 0
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
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `endorsed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `availability` int(11) NOT NULL DEFAULT 0,
  `window` int(11) DEFAULT NULL,
  `endorsed_to` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrar_logs`
--

CREATE TABLE `registrar_logs` (
  `id` int(255) NOT NULL,
  `queue_number` varchar(64) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `endorsed_from` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `endorsed_to` varchar(255) NOT NULL,
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
(1, 'Vincent Rivera', 'SCS', 'vincentrivera', '25d55ad283aa400af464c76d713c07ad', 'available', 1),
(2, 'Marlon Diloy', 'SCS', 'marlondiloy', '25d55ad283aa400af464c76d713c07ad', 'offline', 0),
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
(13, 'Richard Miguel Butial', 'SHS', 'Richard', '25d55ad283aa400af464c76d713c07ad', 'offline', 0),
(14, 'Jhanna Mae Tadique', 'SHS', 'Jhanna', '25d55ad283aa400af464c76d713c07ad', 'offline', 0),
(15, 'Maria Carina Pontanar', 'SHS', 'Maria', '12345678', NULL, 0),
(22, 'Admission 1', 'ADMISSION', 'admission1', '12345678', NULL, 4),
(32, 'Accounting 1', 'ACCOUNTING', 'accounting1', '12345678', 'offline', 1),
(33, 'Accounting 2', 'ACCOUNTING', 'accounting2', '12345678', NULL, 2),
(34, 'Registrar 1', 'REGISTRAR', 'registrar1', '12345678', NULL, 1),
(35, 'Registrar 2', 'REGISTRAR', 'registrar2', '12345678', NULL, 2),
(36, 'Clinic 1', 'CLINIC', 'clinic1', '12345678', NULL, 1),
(37, 'Clinic 2', 'CLINIC', 'clinic2', '12345678', NULL, 2),
(38, 'Assets 1', 'ASSETS', 'assets1', '12345678', NULL, 1),
(39, 'Assets 2', 'ASSETS', 'assets2', '12345678', NULL, 2),
(40, 'ITSO 1', 'ITSO', 'itso1', '12345678', NULL, 1),
(41, 'ITSO 2', 'ITSO', 'itso2', '12345678', NULL, 2),
(42, 'Guidance 1', 'GUIDANCE', 'guidance1', '12345678', NULL, 1),
(43, 'Guidance 2', 'GUIDANCE', 'guidance2', '12345678', NULL, 2),
(44, 'Admission 2', 'ADMISSION', 'admission2', '12345678', NULL, 2);

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
-- Indexes for table `assets_logs`
--
ALTER TABLE `assets_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic_logs`
--
ALTER TABLE `clinic_logs`
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
-- Indexes for table `guidance_logs`
--
ALTER TABLE `guidance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itso`
--
ALTER TABLE `itso`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itso_logs`
--
ALTER TABLE `itso_logs`
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
-- Indexes for table `registrar_logs`
--
ALTER TABLE `registrar_logs`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `academics_logs`
--
ALTER TABLE `academics_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `academics_queue`
--
ALTER TABLE `academics_queue`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting`
--
ALTER TABLE `accounting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounting_logs`
--
ALTER TABLE `accounting_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_logs`
--
ALTER TABLE `admission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_logs`
--
ALTER TABLE `assets_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinic_logs`
--
ALTER TABLE `clinic_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `display`
--
ALTER TABLE `display`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `display_a`
--
ALTER TABLE `display_a`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guidance`
--
ALTER TABLE `guidance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guidance_logs`
--
ALTER TABLE `guidance_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itso`
--
ALTER TABLE `itso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itso_logs`
--
ALTER TABLE `itso_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `program_chairs`
--
ALTER TABLE `program_chairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_logs`
--
ALTER TABLE `queue_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrar`
--
ALTER TABLE `registrar`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrar_logs`
--
ALTER TABLE `registrar_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentid_list`
--
ALTER TABLE `studentid_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
