-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 10:50 PM
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
-- Database: `fmi_php`
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
(12, 'First Pdf', '/Applications/XAMPP/xamppfiles/htdocs/Fmi_web_php_books/public/uploads/images/66559b24e14b3-images.jpg', '/Applications/XAMPP/xamppfiles/htdocs/Fmi_web_php_books/public/uploads/pdfs/66559b24e14c2-сем.pdf', 'some really short descripition just to have something here. Just statistics things', '/Applications/XAMPP/xamppfiles/htdocs/Fmi_web_php_books/public/uploads/pdfs/66559b24e14c2-сем.pdf', 20, 10, 0, 1, 4),
(13, 'italy', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/images/6657871d23adc-Italy.jpg', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/6657871d23ae4-Домашна-работа-4.pdf', 'jnini', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/6657871d23ae4-Домашна-работа-4.pdf', 7, 5, 0, 1, 4),
(14, 'sssssss', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/images/66578f15e464a-Italy.jpg', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/66578f15e4652-IntelliEthics_Feedback.pdf', 'ss', 'C:\\xampp\\htdocs\\Fmi_web_php_books/public/uploads/pdfs/66578f15e4652-IntelliEthics_Feedback.pdf', 7, 2, 0, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pdf_requests`
--

CREATE TABLE `pdf_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','denied') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'gabi', 'gabi@abv.bg', '$2y$10$b9PNPTN.w9LCyZ6FtUPs4O6zg.eC/RF9Bsx8I/6Ug13Akrv85HXSa', 1),
(4, 'gabi1', 'gabi1@abv.bg', '$2y$10$qbMlEe1o/FKqfyaNsOau3.5/X4VrlYdp.GMa4MUb5T1UBItwd7cZ.', 1);

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
(1, 3, 14, '2023-01-01', '2023-01-01'),
(2, 4, 12, '2023-01-01', '2023-01-01');

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
  ADD KEY `user_id` (`user_id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pdf_requests`
--
ALTER TABLE `pdf_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_pdfs`
--
ALTER TABLE `user_pdfs`
  MODIFY `user_pdf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `pdf_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pdf_requests_ibfk_2` FOREIGN KEY (`pdf_id`) REFERENCES `pdfs` (`id`);

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