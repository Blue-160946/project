-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2024 at 01:38 PM
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
-- Table structure for table `keychain`
--

CREATE TABLE `keychain` (
  `keychain_id` int(5) NOT NULL,
  `keychain_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int(4) NOT NULL,
  `detel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keychain`
--

INSERT INTO `keychain` (`keychain_id`, `keychain_name`, `price`, `detel`) VALUES
(7, 'Broccoli', 59, 'หนูไม่กินผัก หนูไม่กินผัก แต่บรอกโคลี่อันนี้ไม่ใช่ผัก แต่เป็นความน่ารักกกกก (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(8, 'Moji', 59, 'น้องๆหน้าอ้วนนน น่ารัก น่ารักหยิกสุดๆ (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(9, 'Jellyfish', 79, 'รับสมัครคนรับน้องไปดูแล เลี้ยงง่าย น่ารักมากกก (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keychain`
--
ALTER TABLE `keychain`
  ADD PRIMARY KEY (`keychain_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keychain`
--
ALTER TABLE `keychain`
  MODIFY `keychain_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
