-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 03:23 PM
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
-- Database: `dbvoltmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `picture`, `detail`, `stock`) VALUES
(1, 'Handphone Samsung', 2000000, 'product_672fbfdaab1e07.00753858.jpg', 'Handphone Samsung', 50),
(2, 'Laptop', 10000000, 'product_672fc0b22abb06.18504548.jpg', 'Laptop Asus', 2),
(3, 'Keyboard', 500000, NULL, 'Keyboard Logitech', 1),
(4, 'S24 Ultra', 20000000, 'RIFF\Z?\0\0WEBPVP8 ?\0\0P??*?L>?J?M???? 񹢠?in???h΍??w?A?\'\r??l????? ??n2???[T???п?{!????\Zv??wCݺ???5??Q?+yF???\'Ο????\0~cx??K???????>????????JQ0\",n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X??', NULL, 1),
(6, 'Mouse Razer', 1500000, '', 'Ini adalah Mouse Razer terbaru', 431);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `passwords` varchar(255) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `balance` int(11) NOT NULL DEFAULT 10000,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `passwords`, `email`, `role`, `balance`, `picture`) VALUES
(1, 'adminRaihan', 'b010361127f9b98e823b06a13988ae8d', '', 'user', 10000, NULL),
(4, 'test@mail.com', '$2y$10$Gh6/cTD08kxjQdsnDgJIEu.agF/iC./FW5Bxxm7HzfjkQz15RG4f6', '', 'user', 10000, NULL),
(5, 'test2@mail.com', '$2y$10$whSmnjKUDIU3jW82aRj5Pu7RXDqUD6zFIImbjD4/bOz0LncIDLHMy', '', 'user', 10000, NULL),
(6, 'test3@mail.com', '$2y$10$qfDZIWxgXwO0RrtDbG6bwOov15nYGCzMyFi4y/JR9Eqri9Gmb996m', '', 'user', 10000, NULL),
(7, 'adminRaihan@', '$2y$10$NrehtjIdNUbWtFti3H6z3.MqkSw/nT/8R621we3TlXjt6UQSWLwfG', '', 'user', 10000, NULL),
(8, 'adminRaihan2', '$2y$10$8NbAzNIwuMmIU7Q2aqI/q.p9j7SVmKa./kuDy/2l2.pM4wwhgoikK', 'adminRaihan@mail.com', 'user', 10000, NULL),
(9, 'adminRaihan3', '$2y$10$uS1EQaVZ7jRRGlw3OrJEoe43JHWeJpKlEuEaGf8T6IMoQDiVgHQiq', 'adminRaihan3@mai.com', 'user', 10000, NULL),
(10, 'adminRaihan4', '$2y$10$xY1ZkIp72A4KP4RqfKNL9.P09wUqcfFD41mYDb2tZXAzvzonpUFya', 'adminRaihan4@mail.com', 'admin', 10000, 'uploads/profile_pictures/images.jpg'),
(11, 'adminRaihan5', '6b818298192f03a8e76ce268c93817528634a7a1b478c021be4d672086dcd1ce', 'adminRaihan5@mail.com', 'admin', 10000, NULL),
(12, 'userRaihan', 'a51679da47e9b33b94a82b50db12a83c3333ada779b9cea68d6159a61a9f96d3', 'userRaihan@mail.com', 'user', 10000, NULL),
(13, 'testm', '86c6548f9966f7af158a60f10ad46572f5fae4252882d208b013f5d1992ae75d', 'm@email.com', 'admin', 10000, NULL),
(14, 'userRaihan2', '$2y$10$eP9DrdsjFE1BmiDM7wc80OE1zV5rKsb4P6ZG7FQX0OojiKMyblfBW', 'userRaihan2@mail.com', 'user', 10000, 'uploads/profile_pictures/0_Ggt-XwliwAO6QURi.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
