-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 06:02 PM
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
-- Database: `bitbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `iban` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `uid`, `iban`, `amount`, `currency`) VALUES
(1, 1, 'LT95999990000000001', 5, 'Eur'),
(3, 3, 'LT94999990000000002', 5, 'Eur');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `time` varchar(19) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `time`, `user`, `status`) VALUES
(1, '2024-01-27 16:22:07', 0, 'Login failed'),
(2, '2024-01-27 17:16:18', NULL, 'Login ok'),
(3, '2024-01-27 17:16:32', NULL, 'Login ok'),
(4, '2024-01-27 17:17:47', NULL, 'Login ok'),
(5, '2024-01-27 17:21:59', 3, 'Login ok'),
(6, '2024-01-27 17:22:10', 3, 'Logout ok'),
(7, '2024-01-27 17:22:27', 0, 'Login failed'),
(8, '2024-01-27 17:22:38', 1, 'Login ok'),
(9, '2024-01-27 17:58:45', 1, 'Logout ok');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `time` varchar(19) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `fromIBAN` varchar(255) DEFAULT NULL,
  `toIBAN` varchar(255) DEFAULT NULL,
  `fromName` varchar(255) DEFAULT NULL,
  `toName` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL,
  `curr` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `time`, `from`, `to`, `fromIBAN`, `toIBAN`, `fromName`, `toName`, `amount`, `curr`) VALUES
(1, '2024-01-27 17:56:59', 0, 1, 'cash', 'LT95999990000000001', '', '', 20, 'Eur'),
(2, '2024-01-27 17:57:22', 0, 1, 'cash', 'LT95999990000000001', '', '', 10, 'Eur'),
(3, '2024-01-27 17:57:27', 1, 0, 'LT95999990000000001', 'cash', '', '', 200, 'Eur'),
(4, '2024-01-27 17:58:16', 1, 3, 'LT95999990000000001', 'LT94999990000000002', 'Vilkas Pilkas', 'Lapė Snapė', 5, 'Eur');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `ak` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pw` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `ak`, `email`, `pw`) VALUES
(1, 'Vilkas', 'Pilkas', '51501029047', 'vilkas.pilkas@zaliasmiskas.lt', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(3, 'Lapė', 'Snapė', '35008078198', 'lape.snape@zaliasmiskas.lt', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
