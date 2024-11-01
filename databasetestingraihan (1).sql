-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 10:35 PM
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
-- Database: `databasetestingraihan`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `status` enum('Avaiable','Out of stock') DEFAULT 'Avaiable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `picture`, `detail`, `status`) VALUES
(1, 'Handphone', 2000000, NULL, 'Handphone Samsung', 'Avaiable'),
(2, 'Laptop', 10000000, NULL, 'Laptop Asus', 'Out of stock'),
(3, 'Keyboard', 500000, NULL, 'Keyboard Logitech', 'Avaiable'),
(4, 'S24 Ultra', 20000000, 'RIFF\Z?\0\0WEBPVP8 ?\0\0P??*?L>?J?M???? 񹢠?in???h΍??w?A?\'\r??l????? ??n2???[T???п?{!????\Zv??wCݺ???5??Q?+yF???\'Ο????\0~cx??K???????>????????JQ0\",n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X??', NULL, 'Avaiable'),
(5, NULL, NULL, 'RIFF\Z?\0\0WEBPVP8 ?\0\0P??*?L>?J?M???? 񹢠?in???h΍??w?A?\'\r??l????? ??n2???[T???п?{!????\Zv??wCݺ???5??Q?+yF???\'Ο????\0~cx??K???????>????????JQ0\",n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X???cw?n??ޱ??7z??X??', NULL, 'Avaiable');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `passwords` varchar(255) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `passwords`, `email`, `role`) VALUES
(1, 'adminRaihan', 'b010361127f9b98e823b06a13988ae8d', '', 'user'),
(3, 'testRaihan@mail.com', '$2y$10$YY.fbRzlNDIhgcOUSIweQeOB4mLLU1avDr0GhSDciuD0G7OCOXuLq', '', 'user'),
(4, 'test@mail.com', '$2y$10$Gh6/cTD08kxjQdsnDgJIEu.agF/iC./FW5Bxxm7HzfjkQz15RG4f6', '', 'user'),
(5, 'test2@mail.com', '$2y$10$whSmnjKUDIU3jW82aRj5Pu7RXDqUD6zFIImbjD4/bOz0LncIDLHMy', '', 'user'),
(6, 'test3@mail.com', '$2y$10$qfDZIWxgXwO0RrtDbG6bwOov15nYGCzMyFi4y/JR9Eqri9Gmb996m', '', 'user'),
(7, 'adminRaihan@', '$2y$10$NrehtjIdNUbWtFti3H6z3.MqkSw/nT/8R621we3TlXjt6UQSWLwfG', '', 'user'),
(8, 'adminRaihan2', '$2y$10$8NbAzNIwuMmIU7Q2aqI/q.p9j7SVmKa./kuDy/2l2.pM4wwhgoikK', 'adminRaihan@mail.com', 'user'),
(9, 'adminRaihan3', '$2y$10$uS1EQaVZ7jRRGlw3OrJEoe43JHWeJpKlEuEaGf8T6IMoQDiVgHQiq', 'adminRaihan3@mai.com', 'user'),
(10, 'adminRaihan4', '$2y$10$xY1ZkIp72A4KP4RqfKNL9.P09wUqcfFD41mYDb2tZXAzvzonpUFya', 'adminRaihan4@mail.com', 'user'),
(11, 'adminRaihan5', '6b818298192f03a8e76ce268c93817528634a7a1b478c021be4d672086dcd1ce', 'adminRaihan5@mail.com', 'admin'),
(12, 'userRaihan', 'a51679da47e9b33b94a82b50db12a83c3333ada779b9cea68d6159a61a9f96d3', 'userRaihan@mail.com', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
