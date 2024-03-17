-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 08:47 AM
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
-- Database: `note_sharing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `follower_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `follower_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `following_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `followed_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `user_id`, `title`, `subject`, `content`, `created_at`, `file_path`) VALUES
(3, 7, 'advanced ai softwares', 'ai', 'zxsada', '2024-03-10 17:33:01', 'C:/xampp/htdocs/notesharing/uploads/Ai(3,4).docx'),
(4, 7, '3rd module', 'OR', 'ffghkkhiikhjhjkgkgj', '2024-03-10 18:00:08', 'C:/xampp/htdocs/notesharing/uploads/s#18 Graph Algorithms-IV.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'albin', 'albinjoseph229@gmail.com', '$2y$10$pPgGeRXwp4La1VdsmRcHX.DwDXEayibnqvB3mZbqsee5eIC6ZbQvm', '2024-02-26 13:00:10'),
(3, 'albin@gmail.com', 'aaaa@ggg.com', '$2y$10$9GupIgC8APtelthtb.LK.ubrY0.t8YdplGUL0jsN0h7G0nnJknaHi', '2024-02-26 13:10:20'),
(6, 'albin123', 'albin@gmail.com', '$2y$10$h10FHrLVzyzRg2qFPk2U6OFDUo7sxncj0edTfhr9GAVY1Mh2Pj8Ty', '2024-02-26 13:13:39'),
(7, 'admin', 'admin@gmail.com', '$2y$10$dZl6lswnMII6CBVkpQw.EO7.Gd/equ8V0Dk.h4XiVYPMAmcReEG2i', '2024-02-26 13:14:42'),
(9, 'root123', 'root123@gmail.com', '$2y$10$fMI9Gv96Dx.bFgrJ3zYGzuOQb9N4aGjLIMi592d94QMxt5Dq4u0iG', '2024-03-10 05:18:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`follower_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`follower_user_id`),
  ADD KEY `follower_user_id` (`follower_user_id`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_user_id` (`following_user_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `followed_user_id` (`followed_user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `follower_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`follower_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `following_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `following_ibfk_2` FOREIGN KEY (`following_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followed_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
