-- Active: 1722366031711@@127.0.0.1@3306@chakao
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2023 at 04:57 AM
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
-- Database: `chakao`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `employee_id` int(5) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`employee_id`, `name`, `surname`, `username`, `password`) VALUES
(1, 'Amin', 'Daoh', 'admin', '1234'),
(2, 'Jane', 'Smith', 'janesmith', 'password2'),
(3, 'Bob', 'Johnson', 'bobjohnson', 'password3'),
(5, 'Daniel', 'Harris', 'danielh', 'employee567'),
(6, 'Emma', 'Perez', 'emmap', 'employee678'),
(7, 'Liam', 'Lewis', 'liaml', 'employee789'),
(8, 'Mia', 'Allen', 'miam', 'employee890'),
(9, 'Benjamin', 'Scott', 'benjamins', 'employee901'),
(10, 'Harper', 'Turner', 'harper', 'employee012');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `customer_tel` varchar(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `sub_district` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `datebirth`, `customer_tel`, `address`, `sub_district`, `district`, `city`, `zipcode`) VALUES
(1, 'ไม่ได้เป็นสมาชิก', '-', '2023-10-16', '00', '-', '-', '-', '-', '-'),
(5, 'Amin', 'Daoh', '2002-09-17', '0645675605', '50/6', 'พร่อน', 'เมือง', 'ยะลา', '95160'),
(6, 'อานัส', 'ดอเลาะ', '2023-10-17', '0622425756', '557', 'พร่อน', 'เมือง', 'ยะลา', '95000'),
(7, 'อามานี', 'ดอเลาะ', '2023-10-17', '0808637679', '557', 'พร่อน', 'เมือง', 'ยะลา', '95000');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `member_tel` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `points` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `customer_id`, `member_tel`, `password`, `points`) VALUES
(1, 1, '00', '12345678', 1994100),
(5, 5, '0645675605', '12345678', 170),
(6, 6, '0622425756', '1234', 0),
(7, 7, '0808637679', '1234', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `product_image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `points`, `product_image`) VALUES
(8, 'ชามะนาว', 100.00, 10, 0x2e2e2f2e2e2f75706c6f6164732f70726f642d696d672f646f776e6c6f6164202831292e6a666966),
(9, 'ชาเขียว ปั่น', 50.00, 10, 0x2e2e2f2e2e2f75706c6f6164732f70726f642d696d672f363532646564363932396536385f646f776e6c6f61642e6a666966),
(10, 'โกโก้ ปั่น', 45.00, 10, 0x2e2e2f2e2e2f75706c6f6164732f70726f642d696d672f363532646564633237326532345f646f776e6c6f6164202832292e6a666966),
(11, 'สตรอเบอรี่ ปั่น', 40.00, 20, 0x2e2e2f2e2e2f75706c6f6164732f70726f642d696d672f363532646565303232383534365f646f776e6c6f6164202833292e6a666966);

-- --------------------------------------------------------

--
-- Table structure for table `redemption_history`
--

CREATE TABLE `redemption_history` (
  `redemption_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `reward_id` int(11) NOT NULL,
  `redemption_date` datetime NOT NULL,
  `redeemed_points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redemption_history`
--

INSERT INTO `redemption_history` (`redemption_id`, `member_id`, `reward_id`, `redemption_date`, `redeemed_points`) VALUES
(29, 1, 1, '2023-10-16 21:17:53', 100),
(30, 1, 1, '2023-10-16 21:17:53', 100),
(31, 1, 1, '2023-10-16 21:19:34', 100),
(32, 1, 1, '2023-10-16 21:19:35', 100),
(33, 1, 1, '2023-10-16 21:19:44', 100),
(34, 1, 1, '2023-10-16 21:22:44', 100),
(35, 1, 1, '2023-10-16 21:25:13', 100),
(36, 1, 1, '2023-10-16 21:25:14', 100),
(37, 1, 1, '2023-10-16 21:25:23', 100),
(38, 1, 1, '0000-00-00 00:00:00', 100),
(39, 1, 1, '0000-00-00 00:00:00', 100),
(40, 1, 1, '0000-00-00 00:00:00', 100),
(41, 1, 1, '2023-10-16 21:28:33', 100),
(42, 1, 1, '2023-10-16 21:31:18', 100),
(43, 1, 1, '2023-10-16 21:31:19', 100),
(44, 1, 1, '2023-10-16 21:31:58', 100),
(45, 1, 1, '2023-10-16 21:31:59', 100),
(46, 1, 1, '2023-10-16 21:36:08', 100),
(47, 1, 1, '2023-10-16 21:36:10', 100),
(48, 1, 1, '2023-10-16 21:40:52', 100),
(49, 1, 1, '2023-10-16 21:40:54', 100),
(50, 1, 1, '2023-10-16 21:40:55', 100),
(51, 1, 1, '2023-10-16 21:41:05', 100),
(52, 1, 1, '2023-10-16 21:41:06', 100),
(53, 1, 1, '2023-10-16 21:41:11', 100),
(54, 1, 1, '2023-10-16 21:43:24', 100),
(55, 1, 1, '2023-10-16 21:43:27', 100),
(56, 1, 1, '2023-10-16 21:44:37', 100),
(57, 1, 1, '2023-10-16 22:01:54', 100),
(58, 1, 1, '2023-10-16 22:28:18', 100),
(59, 1, 1, '2023-10-16 22:28:22', 100),
(60, 1, 1, '2023-10-17 08:59:31', 100);

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `reward_id` int(11) NOT NULL,
  `reward_name` varchar(255) NOT NULL,
  `points_required` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`reward_id`, `reward_name`, `points_required`, `description`, `image_url`) VALUES
(1, 'แลกฟรี 1 รายการ', 100, 'อะไรก็ได้', 0x2e2e2f2e2e2f75706c6f6164732f7265776172642d696d672f363532643236656465353836655f3332363438393939395f313839373634343932333932303134325f353435303332353039313031333637333433395f6e2d6d6f6469666965642e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `sales_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `total_points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `member_id`, `sales_date`, `total_quantity`, `total_price`, `total_points`) VALUES
(11, 1, '2023-10-16 03:51:00', 6, 180.00, 60),
(12, 1, '2023-10-16 07:58:00', 11, 330.00, 110),
(13, NULL, '2023-10-16 08:17:00', 9, 270.00, 90),
(14, NULL, '2023-10-16 08:17:00', 2, 60.00, 20),
(15, 1, '2023-10-16 08:18:00', 5, 150.00, 50),
(16, 1, '2023-10-16 08:19:00', 12, 360.00, 120),
(17, 1, '2023-10-16 10:36:00', 25, 625.00, 250),
(18, 1, '2023-10-16 17:23:00', 1, 25.00, 10),
(19, 5, '2023-10-17 02:15:00', 9, 430.00, 90),
(20, 5, '2023-10-17 02:34:00', 5, 500.00, 50),
(21, 1, '2023-10-17 02:35:00', 6, 270.00, 60),
(22, 5, '2023-10-17 02:38:00', 1, 100.00, 10),
(23, 5, '2023-10-17 02:38:00', 8, 320.00, 160);

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `sales_detail_id` int(11) NOT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_details`
--

INSERT INTO `sales_details` (`sales_detail_id`, `sales_id`, `product_id`, `product_name`, `price`, `points`, `quantity`) VALUES
(18, 11, NULL, '            โกโก้', 30.00, 10, 3),
(19, 11, NULL, '            ชาเย็น', 30.00, 10, 3),
(20, 12, NULL, '            โกโก้', 30.00, 10, 3),
(21, 12, NULL, '            ชาเย็น', 30.00, 10, 8),
(22, 13, NULL, '            โกโก้', 30.00, 10, 9),
(23, 14, NULL, '            โกโก้', 30.00, 10, 2),
(24, 15, NULL, '            ชาเย็น', 30.00, 10, 5),
(25, 16, NULL, '            ชาเย็น', 30.00, 10, 12),
(26, 17, NULL, '            lemonade', 25.00, 10, 25),
(27, 18, NULL, '            น้ำมะนาว', 25.00, 10, 1),
(28, 19, 10, '            โกโก้ ปั่น', 45.00, 10, 4),
(29, 19, 9, '            ชาเขียว ปั่น', 50.00, 10, 5),
(30, 20, 8, '            ชามะนาว', 100.00, 10, 5),
(31, 21, 10, '            โกโก้ ปั่น', 45.00, 10, 6),
(32, 22, 8, '            ชามะนาว', 100.00, 10, 1),
(33, 23, 11, '            สตรอเบอรี่ ปั่น', 40.00, 20, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `member_tel` (`member_tel`),
  ADD KEY `fk-customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `redemption_history`
--
ALTER TABLE `redemption_history`
  ADD PRIMARY KEY (`redemption_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `reward_id` (`reward_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `sales_ibfk_1` (`member_id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`sales_detail_id`),
  ADD KEY `sales_id` (`sales_id`),
  ADD KEY `sales_details_ibfk_2` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `redemption_history`
--
ALTER TABLE `redemption_history`
  MODIFY `redemption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `reward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sales_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `fk-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `redemption_history`
--
ALTER TABLE `redemption_history`
  ADD CONSTRAINT `redemption_history_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`),
  ADD CONSTRAINT `redemption_history_ibfk_2` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`reward_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`sales_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
