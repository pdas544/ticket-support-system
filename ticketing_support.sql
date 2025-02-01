-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 24, 2025 at 10:13 AM
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
-- Database: `ticketing_support`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `name`, `email`, `password`) VALUES
(1, 'kamal', 'kamal@test.com', '5f4dcc3b5aa765d61d8327deb882cf99'),
(2, 'biraj', 'biraj@test.com', '1a1dc91c907325c69271ddf0c944bc72'),
(3, 'Test agent', 'testagent@abc.com', '098f6bcd4621d373cade4e832627b4f6'),
(4, 'santosh sahoo', 'santosh@abc.com', '4e8d6af15861d0225f3689a9326c85ea');

-- --------------------------------------------------------

--
-- Table structure for table `guest_tickets`
--

CREATE TABLE `guest_tickets` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest_tickets`
--

INSERT INTO `guest_tickets` (`id`, `ticket_id`, `user_id`, `agent_id`, `subject`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TKT19901', 1, 1, 'new sub', 'new desc', 'Resolved', '2024-11-24 11:31:23', '2024-11-25 11:45:06'),
(2, 'TKT19902', 2, 2, 'test sub2', 'test desc2', 'In-Progress', '2024-11-24 14:47:38', '2024-11-25 14:11:20'),
(3, 'TKT19903', 3, 1, 'network issue', 'network test issue', 'Resolved', '2024-11-25 10:53:08', '2024-11-26 10:23:06'),
(4, 'TKT19904', 4, 2, 'Fraudulance ', 'Money got debited from my account', 'Resolved', '2024-11-25 14:18:29', '2024-11-25 17:28:01'),
(5, 'TKT19905', 5, 3, 'network issue', 'network issue', 'Resolved', '2024-11-25 17:24:50', '2024-11-26 15:00:42'),
(6, 'TKT19906', 6, 3, 'Not getting princess treatment', 'Poor boyfriend, insufficient income.', 'Open', '2024-12-12 15:46:18', '2024-12-12 15:46:18'),
(7, 'TKT19907', 7, 4, 'test subject', 'Poor boyfriend, insufficient income.', 'Open', '2024-12-12 15:55:22', '2024-12-12 15:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `guest_users`
--

CREATE TABLE `guest_users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest_users`
--

INSERT INTO `guest_users` (`id`, `name`, `email`) VALUES
(1, 'test user', 'test@abc.com'),
(2, 'test name', 'test@abc.com'),
(3, 'bimal', 'bimal@test.com'),
(4, 'Bidisha Das', 'bidishad92@gmail.com'),
(5, 'Debangshu Nayak', 'ja.fc.bhu@nift.ac.in'),
(6, 'Baby Das', 'princessbaby29@gmail.com'),
(7, 'test name', 'test@abc.com');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(30) DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `agent_id`, `subject`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'test subject', 'test description', 'in-progress', '2024-11-23 14:24:54', '2025-01-24 09:00:22'),
(2, 9, 2, 'my subject', 'my description', 'Resolved', '2024-11-23 16:04:40', '2024-11-26 14:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(3, 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6'),
(4, 'Bimal', 'bimal@test.com', '1a1dc91c907325c69271ddf0c944bc72'),
(5, 'Bidisha', 'bids@test.com', '03c98ff9edc4b0e2fa19dd478e1613ee'),
(9, 'swaraj', 'swaraj@test.com', '1a1dc91c907325c69271ddf0c944bc72'),
(10, 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3'),
(11, 'test user', 'testuser@test.com', '$2y$10$PTpN3GeVnhoPvx8RTk.BOuW4tBHyRY5FiQPvOD/mqzh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_tickets`
--
ALTER TABLE `guest_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkuserid` (`user_id`),
  ADD KEY `fkagentid` (`agent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guest_tickets`
--
ALTER TABLE `guest_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guest_users`
--
ALTER TABLE `guest_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fkagentid` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `fkuserid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
