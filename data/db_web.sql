-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 11:33 PM
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
-- Database: `db_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `pdfs`
--

CREATE TABLE `pdfs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `descript` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `active_period` int(11) DEFAULT NULL,
  `max_users_allowed` int(11) DEFAULT NULL,
  `users_allowed_count` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdfs`
--

INSERT INTO `pdfs` (`id`, `title`, `img`, `pdf_file`, `descript`, `file_path`, `active_period`, `max_users_allowed`, `users_allowed_count`, `is_active`, `owner`) VALUES
(22, 'Математически увод в икономиката', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/images/6667568bc984d-Screenshot 2024-06-10 223300.png', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/6667568bc9851-МУИ - компресирани теми.pdf', 'Компресирани теми ', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/6667568bc9851-МУИ - компресирани теми.pdf', 7, 5, 0, 1, 7),
(23, 'The adventure of Tom Sawer', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/images/666766c7867d7-Screenshot 2024-06-10 234334.png', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/666766c7867da-The_Adventures_of_Tom_Sawyer.pdf', 'Short adventure book', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/666766c7867da-The_Adventures_of_Tom_Sawyer.pdf', 20, 8, 1, 1, 8),
(24, 'The wizard of Oz', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/images/666767a58c135-the-wizard-of-oz.jpg', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/666767a58c13c-The-Wizard-Of-Oz.pdf', 'Adventure book for kids', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/666767a58c13c-The-Wizard-Of-Oz.pdf', 10, 10, 2, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `pdf_requests`
--

CREATE TABLE `pdf_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL,
  `status` enum('pending','approved','denied') DEFAULT 'pending',
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdf_requests`
--

INSERT INTO `pdf_requests` (`request_id`, `user_id`, `pdf_id`, `request_date`, `status`, `owner_id`) VALUES
(18, 8, 22, '2024-06-10 00:00:00', NULL, 7);

-- --------------------------------------------------------

--
-- Table structure for table `pdf_requests_unregistered`
--

CREATE TABLE `pdf_requests_unregistered` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pdf_requests_unregistered`
--

INSERT INTO `pdf_requests_unregistered` (`id`, `user_email`, `pdf_id`, `request_date`, `status`, `owner_id`) VALUES
(25, 'lea@abv.bg', 24, '2024-06-10 00:00:00', 'approved', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `expiration_date` datetime NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `pdf_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `expiration_date`, `user_email`, `pdf_id`) VALUES
(31, '6a3ddd5258194cc720e0db431b9f9f52', '2024-06-17 22:57:05', 'lea@abv.bg', 24);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_registered` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `is_registered`) VALUES
(7, 'Nikol', 'nikol@abv.bg', '$2y$10$s5ItgSu.lE7dP0riRkdMn.vWIgM.tuz2g/.NRjGL7I/ay0n2KCC9a', 1),
(8, 'Gabi', 'gabi@abv.bg', '$2y$10$eCbUWuDnuliRGBslM/ylse32yaNPRyMQ97XZIzvFY4ssaTFAcSyBO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_pdfs`
--

CREATE TABLE `user_pdfs` (
  `user_pdf_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `access_start_date` date NOT NULL,
  `access_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_pdfs`
--

INSERT INTO `user_pdfs` (`user_pdf_id`, `user_id`, `pdf_id`, `access_start_date`, `access_end_date`) VALUES
(24, 7, 23, '2024-06-10', '2024-06-30'),
(25, 7, 24, '2024-06-10', '2024-06-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pdfs`
--
ALTER TABLE `pdfs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_owner` (`owner`);

--
-- Indexes for table `pdf_requests`
--
ALTER TABLE `pdf_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_owner_id` (`owner_id`);

--
-- Indexes for table `pdf_requests_unregistered`
--
ALTER TABLE `pdf_requests_unregistered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pdf_id` (`pdf_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pdf_id` (`pdf_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pdfs`
--
ALTER TABLE `user_pdfs`
  ADD PRIMARY KEY (`user_pdf_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pdf_id` (`pdf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pdfs`
--
ALTER TABLE `pdfs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pdf_requests`
--
ALTER TABLE `pdf_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pdf_requests_unregistered`
--
ALTER TABLE `pdf_requests_unregistered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_pdfs`
--
ALTER TABLE `user_pdfs`
  MODIFY `user_pdf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pdfs`
--
ALTER TABLE `pdfs`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner`) REFERENCES `user` (`id`);

--
-- Constraints for table `pdf_requests`
--
ALTER TABLE `pdf_requests`
  ADD CONSTRAINT `fk_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `pdf_requests_unregistered`
--
ALTER TABLE `pdf_requests_unregistered`
  ADD CONSTRAINT `pdf_requests_unregistered_ibfk_1` FOREIGN KEY (`pdf_id`) REFERENCES `pdfs` (`id`),
  ADD CONSTRAINT `pdf_requests_unregistered_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`pdf_id`) REFERENCES `pdfs` (`id`);

--
-- Constraints for table `user_pdfs`
--
ALTER TABLE `user_pdfs`
  ADD CONSTRAINT `user_pdfs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_pdfs_ibfk_2` FOREIGN KEY (`pdf_id`) REFERENCES `pdfs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
