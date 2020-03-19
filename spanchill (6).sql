-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2020 at 04:00 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spanchill`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(191) NOT NULL,
  `lastName` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `firstName`, `lastName`, `created_at`) VALUES
(1, 'bgemry', '005cc06bbaf1d8675db8d08a54bf2858', 'bgemry@yahoo.com', 'gemry', 'bulante', '2020-03-16 14:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(46, 'Post One(updated)', 'this is post one(updated)', '5e72dfce906193.36928137.jpg', '2020-03-16 05:16:32'),
(47, 'Post Two(updated)', 'This is post two with picture', '5e72dfb5868280.02573635.jpg', '2020-03-19 02:37:48');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_list`
--

CREATE TABLE `reserved_list` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `service_id` int(11) NOT NULL,
  `people` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `image`, `created_at`) VALUES
(1, 'Ashiatsu', '400.00', '5e706ab3a241c3.09722133.jpg', '2020-03-17 06:14:11'),
(2, 'Couples Massage', '450.00', '5e706ac55ea228.23362723.jpg', '2020-03-17 06:14:29'),
(3, 'Deep Tissue Massage', '475.00', '5e706ae104afe3.84097389.jpg', '2020-03-17 06:14:57'),
(4, 'Foot Massage', '300.00', '5e706af6b1d780.13515564.jpg', '2020-03-17 06:15:18'),
(5, 'Hot Stone Massage', '440.00', '5e7098468b0685.14076545.jpg', '2020-03-17 09:28:38'),
(6, 'Reflexology Massage', '500.00', '5e7098697b0c79.29293614.jpg', '2020-03-17 09:29:13'),
(7, 'Shiatsu', '600.00', '5e7098941b27c2.06034104.jpg', '2020-03-17 09:29:56'),
(8, 'Sports Massage', '300.00', '5e7098a6e60810.29142416.jpg', '2020-03-17 09:30:14'),
(9, 'Swedish Massage', '200.00', '5e7098b927bb01.32299173.jpg', '2020-03-17 09:30:33'),
(10, 'Thai Massage', '300.00', '5e7098cdf223d7.05483629.jpg', '2020-03-17 09:30:54'),
(11, 'Trigger Point Massage', '550.00', '5e7098df892f89.55440394.jpg', '2020-03-17 09:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transactionId` decimal(20,0) NOT NULL,
  `username` varchar(128) NOT NULL,
  `service_id` int(11) NOT NULL,
  `people` int(11) NOT NULL,
  `totalPrice` decimal(12,2) NOT NULL,
  `reserve_date` date NOT NULL,
  `status` varchar(128) NOT NULL DEFAULT 'reserved',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transactionId`, `username`, `service_id`, `people`, `totalPrice`, `reserve_date`, `status`, `created_at`) VALUES
(1, '20031910752957', 'bgemry2', 6, 1, '1000.00', '2020-03-19', 'reserved', '2020-03-19 02:34:45'),
(2, '20031910752957', 'bgemry2', 8, 1, '1000.00', '2020-03-19', 'reserved', '2020-03-19 02:34:45'),
(3, '20031910752957', 'bgemry2', 9, 1, '1000.00', '2020-03-19', 'reserved', '2020-03-19 02:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `email` varchar(255) NOT NULL,
  `vkey` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `firstName` varchar(191) NOT NULL,
  `lastName` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `vkey`, `email_verified_at`, `firstName`, `lastName`, `created_at`) VALUES
(3244, 'bgemry', '005cc06bbaf1d8675db8d08a54bf2858', 'bgemry@yahoo.com', '246c2c54cea33459b8bf6fdf4cac5f8a', '2020-03-18 17:59:08', 'gemry', 'bulante', '2020-03-18 17:58:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserved_list`
--
ALTER TABLE `reserved_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `reserved_list`
--
ALTER TABLE `reserved_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3248;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
