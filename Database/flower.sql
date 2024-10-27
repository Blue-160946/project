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
-- Table structure for table `flower`
--

CREATE TABLE `flower` (
  `flower_id` int(5) NOT NULL,
  `flower_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int(4) NOT NULL,
  `detel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flower`
--

INSERT INTO `flower` (`flower_id`, `flower_name`, `price`, `detel`) VALUES
(1, 'FLODUCKY', 299, 'ใครที่ชอบเป่ดเป้ดเป็ด ช่อนี้ตอบโจทย์มาก น้องเป็นช่อโทนสีเหลืองสดใส ในช่อประกอบด้วย เป็ด 1 ก้าน ทานตะวัน 2 ก้าน ฟอร์เก็ตมีน็อต 2 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(2, 'Sunshine', 299, 'โทนสีเหลืองที่มีแต่ความสดใส และความหมายดีๆของดอกไม้ ทานตะวัน 1 ก้าน ทิวลิป 1 ก้าน ลาเวนเดอร์ 2 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(3, 'Love Sampler', 359, 'ช่อดอกไม้ที่รวมดอกไม้ทุกอย่างที่มีแต่ความหมายที่น่ารัก เหมาะกับการใครคนรัก หรือใครสั่งคนที่อยากมอบให้ ประกอบด้วยดอก ทานตะวัน 1 ก้าน เดซี่ 1 ก้าน ฟอร์เก็ตมีน็อต 1 ก้าน ทิวลิป 1 ก้าน ลาเวนเดอร์ 2 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(4, 'Forgetmenot 1', 129, '“โปรดอย่าลืมฉันนะ“ ฟอร์เก็ตมีน็อต 3 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(5, 'Sun Blue 1', 299, 'ทานตะวันที่คู่กับท้องฟ้า ทานตะวัน 1 ทิวลิป 2 ฟอร์เก็ตมีน็อต 1 (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(6, 'Sweetie', 229, 'สีหวานฉ่ำขนาดนี้ เหมาะกับคนหวานๆอย่างเทอ ทิวลิป 2 ก้าน ฟอร์เก็ตมีน็อต 1 ก้าน ลาเวนเดอร์ 1 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(7, 'Bunny Bunny', 229, 'น้องกระต่ายที่น่ารัก เหมาะกับสีชมพู๊ชมพู กระต่าย 1 ตัว เดซี่ 2 ก้าน ทิวลิป 4 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(8, 'Sun Blue 2', 229, 'ทานตะวันที่คู่กับท้องฟ้า ทานตะวัน 1 ทิวลิป 2 ฟอร์เก็ตมีน็อต 1 (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(9, 'Sunflower', 129, 'ดอกไม้แห่งความซื่อสัตย์ (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(10, 'Sunlit Memories', 218, 'ดอกไม้แห่งความซื่อสัตย์ (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(11, 'Daisy', 129, 'ความไร้เดียงสา และความบริสุทธิ์ เดซี่ 3 (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)'),
(12, 'Tulips', 79, 'ชัดเจน หลงไหล และเสน่ห์หา ทิวลิป 1 ก้าน (หากต้องการเลือกสีเอง สามารถ IB ทางร้านได้เลยค่ะ)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flower`
--
ALTER TABLE `flower`
  ADD PRIMARY KEY (`flower_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flower`
--
ALTER TABLE `flower`
  MODIFY `flower_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
