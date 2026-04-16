-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 01:54 AM
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
-- Database: `bercuitm`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_reviews`
--

CREATE TABLE `assigned_reviews` (
  `id` int(11) NOT NULL,
  `research_title` varchar(255) NOT NULL,
  `reviewer_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned_reviews`
--

INSERT INTO `assigned_reviews` (`id`, `research_title`, `reviewer_id`) VALUES
(3, 'MOBILE LEGENDS', '041309');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_reviews`
--
ALTER TABLE `assigned_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `research_title` (`research_title`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_reviews`
--
ALTER TABLE `assigned_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_reviews`
--
ALTER TABLE `assigned_reviews`
  ADD CONSTRAINT `assigned_reviews_ibfk_1` FOREIGN KEY (`research_title`) REFERENCES `berc1` (`research_title`),
  ADD CONSTRAINT `assigned_reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewer` (`staffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
