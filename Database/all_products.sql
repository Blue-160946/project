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
-- Table structure for table `all_products`
--

CREATE TABLE `all_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(4,0) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_products`
--

INSERT INTO `all_products` (`product_id`, `product_name`, `category`, `price`, `quantity_in_stock`, `image_url`) VALUES
(1, 'FLODUCKY', 'Flower', '299', 10, 'img/flower/page-1/product-1.png'),
(2, 'Sunshine', 'Flower', '299', 5, 'img/flower/page-1/product-2.png'),
(3, 'Love Sampler', 'Flower', '359', 7, 'img/flower/page-1/product-3.png'),
(4, 'Forgetmenot 1', 'Flower', '129', 15, 'img/flower/page-1/product-4.png'),
(5, 'Sun Blue 1', 'Flower', '299', 10, 'img/flower/page-1/product-5.png'),
(6, 'Sweetie', 'Flower', '229', 10, 'img/flower/page-1/product-6.png'),
(7, 'Bunny Bunny', 'Flower', '299', 10, 'img/flower/page-1/product-7.png'),
(8, 'Sun Blue 2', 'Flower', '229', 10, 'img/flower/page-1/product-8.png'),
(9, 'Sunflower', 'Flower', '129', 10, 'img/flower/page-2/product-1.png'),
(10, 'Sunlit Memories', 'Flower', '218', 10, 'img/flower/page-2/product-3.png'),
(11, 'Daisy', 'Flower', '129', 10, 'img/flower/page-2/product-4.png'),
(12, 'Tulips', 'Flower', '79', 10, 'img/flower/page-2/product-5.png'),
(13, 'Tulip twist', 'Accessories', '69', 10, 'img/accessories/page-1/product-1.png'),
(14, 'Broccoli', 'Keychain', '59', 10, 'img/keychain/page-1/product-1.jpg'),
(15, 'Moji', 'Keychain', '59', 10, 'img/keychain/page-1/product-2.jpg'),
(16, 'Jellyfish', 'Keychain', '79', 10, 'img/keychain/page-1/product-3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_products`
--
ALTER TABLE `all_products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_products`
--
ALTER TABLE `all_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
