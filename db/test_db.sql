-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2023 at 05:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `message_from` int(11) NOT NULL,
  `message_to` int(11) NOT NULL,
  `sent_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `content`, `message_from`, `message_to`, `sent_date`) VALUES
(49, 'asfsafsafsafaf', 29, 1, '2023-07-27 16:36:59'),
(87, 'asfsafsafsafaf', 29, 27, '2023-07-27 16:37:18'),
(88, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(89, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(90, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(91, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(92, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(93, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(94, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(95, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(96, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(97, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(99, 'asfsafsafsafaf', 29, 27, '0000-00-00 00:00:00'),
(100, 'fsdafdsfs', 27, 29, '2023-07-19 17:08:28'),
(102, 'wow', 27, 29, '2023-07-20 10:22:15');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `created`, `modified`) VALUES
(1, 'The title', 'This is the post body.', '2023-07-12 09:25:41', NULL),
(2, 'A title once again', 'And the post body follows.', '2023-07-12 09:25:41', NULL),
(3, 'Title strikes back', 'This is really exciting! Not.', '2023-07-12 09:25:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `profile_img` varchar(50) NOT NULL,
  `hubby` text NOT NULL,
  `joined_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `password` text NOT NULL,
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `gender`, `birthdate`, `profile_img`, `hubby`, `joined_date`, `last_login`, `password`, `role`) VALUES
(27, 'FDC Test1', 'fdc_test1@gmail.com', 1, '2023-07-31', 'FDC Test123-07-18.png', 'wow', '2023-07-17 09:07:36', '2023-07-20 09:02:41', 'f049cfab9284954cc7af09482d7265efe1177c96', 0),
(29, 'sadasd', 'wow@gmail.com', 1, '2023-07-18', 'sadasd23-07-18.png', 'dsasafasfagaggasggagsza', '2023-07-17 09:10:31', '2023-07-19 03:25:52', 'f049cfab9284954cc7af09482d7265efe1177c96', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
