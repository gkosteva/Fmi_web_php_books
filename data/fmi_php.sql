-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 22, 2024 at 01:23 PM
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
-- Database: `fmi_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `PDFs`
--

CREATE TABLE `PDFs` (
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
-- Dumping data for table `PDFs`
--

INSERT INTO `PDFs` (`id`, `title`, `img`, `pdf_file`, `descript`, `file_path`, `active_period`, `max_users_allowed`, `users_allowed_count`, `is_active`, `owner`) VALUES
(1, 'test title', '664cb978c9f29-download.jpg', '664cb978c9f3b-8MI0600092.pdf', 'test descrpt', '/Applications/XAMPP/xamppfiles/htdocs/Fmi_web_php_books/handlers/../uploads/pdfs/664cb978c9f3b-8MI0600092.pdf', 7, 2, 0, 1, 3),
(2, 'test', '/uploads/images/664cbbd96e792-download.jpg', '/uploads/pdfs/664cbbd96f105-8MI0600092.pdf', 'tets ettss', '/uploads/pdfs/664cbbd96f105-8MI0600092.pdf', 7, 3, 0, 1, 3),
(3, 'TEST', '/Fmi_web_php_book/public/uploads/images/664cbc67e7f0d-download.jpg', '/Fmi_web_php_book/public/uploads/pdfs/664cbc67e8629-8MI0600092.pdf', 'bhbdxbw', '/Fmi_web_php_book/public/uploads/pdfs/664cbc67e8629-8MI0600092.pdf', 7, 2, 0, 1, 3),
(4, 'aa', '/Fmi_web_php_book/public/uploads/images/664cbde6021f5-download.jpg', '/Fmi_web_php_book/public/uploads/pdfs/664cbde602840-8MI0600092.pdf', 'aa', '/Fmi_web_php_book/public/uploads/pdfs/664cbde602840-8MI0600092.pdf', 7, 2, 0, 1, 3),
(5, 'iii', '/public/uploads/images/664dd0cd7500d-', '/public/uploads/pdfs/664dd0cd77213-', 'iii', '/public/uploads/pdfs/664dd0cd77213-', 7, 2, 0, 1, 4),
(6, 'ai', '/public/uploads/images/664dd35d9d212-download.jpg', '/public/uploads/pdfs/664dd35d9d435-8MI0600092.pdf', 'ai', '/public/uploads/pdfs/664dd35d9d435-8MI0600092.pdf', 7, 2, 0, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `PDF_Requests`
--

CREATE TABLE `PDF_Requests` (
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
-- Table structure for table `User_PDFs`
--

CREATE TABLE `User_PDFs` (
  `user_pdf_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pdf_id` int(11) NOT NULL,
  `access_start_date` date NOT NULL,
  `access_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PDFs`
--
ALTER TABLE `PDFs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_owner` (`owner`);

--
-- Indexes for table `PDF_Requests`
--
ALTER TABLE `PDF_Requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pdf_id` (`pdf_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User_PDFs`
--
ALTER TABLE `User_PDFs`
  ADD PRIMARY KEY (`user_pdf_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pdf_id` (`pdf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PDFs`
--
ALTER TABLE `PDFs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `PDF_Requests`
--
ALTER TABLE `PDF_Requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `User_PDFs`
--
ALTER TABLE `User_PDFs`
  MODIFY `user_pdf_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `PDFs`
--
ALTER TABLE `PDFs`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner`) REFERENCES `user` (`id`);

--
-- Constraints for table `PDF_Requests`
--
ALTER TABLE `PDF_Requests`
  ADD CONSTRAINT `pdf_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pdf_requests_ibfk_2` FOREIGN KEY (`pdf_id`) REFERENCES `PDFs` (`id`);

--
-- Constraints for table `User_PDFs`
--
ALTER TABLE `User_PDFs`
  ADD CONSTRAINT `user_pdfs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_pdfs_ibfk_2` FOREIGN KEY (`pdf_id`) REFERENCES `PDFs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
