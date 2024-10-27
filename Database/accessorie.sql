-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2024 at 01:37 PM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessorie`
--

CREATE TABLE `accessorie` (
  `accessorie_id` int(5) NOT NULL,
  `accessorie_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int(4) NOT NULL,
  `detel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accessorie`
--

INSERT INTO `accessorie` (`accessorie_id`, `accessorie_name`, `price`, `detel`) VALUES
(1, 'Tulip twist', 69, 'ที่คาดผมดอกทิวลิป น่ารักสดใสมากกก (หากต้องการเลือกสีเอง สามารถIBทางร้านได้เลยค่ะ)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessorie`
--
ALTER TABLE `accessorie`
  ADD PRIMARY KEY (`accessorie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessorie`
--
ALTER TABLE `accessorie`
  MODIFY `accessorie_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
