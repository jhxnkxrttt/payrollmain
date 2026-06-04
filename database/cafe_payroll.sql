-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2026 at 07:38 AM
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
-- Database: `cafe_payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `status` enum('present','absent','late') DEFAULT 'present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `type` enum('SSS','Pag-IBIG','PhilHealth','Late','Absent','Other') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(50) NOT NULL,
  `monthly_salary` decimal(10,2) NOT NULL,
  `hire_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `position`, `monthly_salary`, `hire_date`, `status`, `created_at`) VALUES
(1, 'Miguel Santos', 'Manager', 25000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(2, 'Carla Reyes', 'Assistant Manager', 18000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(3, 'Ramon Dela Cruz', 'Head Chef', 20000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(4, 'Paolo Navarro', 'Assistant Chef', 15000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(5, 'Andrea Lim', 'Head Barista', 16000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(6, 'Sofia Mendoza', 'Barista', 12000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(7, 'Kevin Garcia', 'Barista', 12000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(8, 'Jason Bautista', 'Barista', 12000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(9, 'Mark Villanueva', 'Service Crew', 10000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(10, 'John Miguel Torres', 'Service Crew', 10000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(11, 'Carlo Ramos', 'Service Crew', 10000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(12, 'Ryan Dizon', 'Service Crew', 10000.00, '2026-01-01', 'active', '2026-05-27 05:33:39'),
(13, 'Angelo Cruz', 'Service Crew', 10000.00, '2026-01-01', 'active', '2026-05-27 05:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `paid_date` date DEFAULT NULL,
  `cut_off_start` date DEFAULT NULL,
  `cut_off_end` date DEFAULT NULL,
  `present_days` tinyint(3) UNSIGNED DEFAULT 0,
  `absent_days` tinyint(3) UNSIGNED DEFAULT 0,
  `late_days` tinyint(3) UNSIGNED DEFAULT 0,
  `total_days` int(11) DEFAULT 0,
  `gross_pay` decimal(10,2) DEFAULT 0.00,
  `late_deduction` decimal(10,2) DEFAULT 0.00,
  `selected_deductions` text DEFAULT NULL,
  `total_deductions` decimal(10,2) DEFAULT 0.00,
  `net_pay` decimal(10,2) DEFAULT 0.00,
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `email`, `password`, `role`, `created_at`) VALUES
(1, NULL, 'admin@cafe.com', '$2y$12$EL1VmJ1KNL1/tIQOw/2q3OdU2.xeSLWRbJMsQKJIQvr/qCecf0Ghy', 'admin', '2026-05-27 05:33:39'),
(2, 1, 'miguel.santos@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Manager', '2026-05-27 05:33:39'),
(3, 2, 'carla.reyes@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Assistant Manager', '2026-05-27 05:33:39'),
(4, 3, 'ramon.delacruz@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Head Chef', '2026-05-27 05:33:39'),
(5, 4, 'paolo.navarro@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Assistant Chef', '2026-05-27 05:33:39'),
(6, 5, 'andrea.lim@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Head Barista', '2026-05-27 05:33:39'),
(7, 6, 'sofia.mendoza@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Barista', '2026-05-27 05:33:39'),
(8, 7, 'kevin.garcia@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Barista', '2026-05-27 05:33:39'),
(9, 8, 'jason.bautista@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Barista', '2026-05-27 05:33:39'),
(10, 9, 'mark.villanueva@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Service Crew', '2026-05-27 05:33:39'),
(11, 10, 'john.torres@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Service Crew', '2026-05-27 05:33:39'),
(12, 11, 'carlo.ramos@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Service Crew', '2026-05-27 05:33:39'),
(13, 12, 'ryan.dizon@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Service Crew', '2026-05-27 05:33:39'),
(14, 13, 'angelo.cruz@cafe.com', '$2y$12$laFhticO9BzFsy9xrsiJaOQlKhSPfpo/O5py69UQbsKwdokgi6mQC', 'Service Crew', '2026-05-27 05:33:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
