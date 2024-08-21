-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 06:32 AM
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
-- Database: `quotation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `quotation No` varchar(50) DEFAULT NULL,
  `quotation To` varchar(255) DEFAULT NULL,
  `quotation Amount` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  `loss` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `date`, `quotation No`, `quotation To`, `quotation Amount`, `subtotal`, `profit`, `loss`) VALUES
(57, '2024-08-14', '11', 'muruga', 10000.00, 2000.00, 8000.00, 0.00),
(58, '2024-08-14', '1313', 'muruga', 100000.00, 10000.00, 90000.00, 0.00),
(60, '2024-12-08', '123', 'muruga', 1000.00, 900.00, 100.00, 0.00),
(71, '2024-08-16', '123', 'cat', 10000000.00, 3041000.00, 6959000.00, 0.00),
(72, '2024-08-17', '1', 'muruga', 1000000.00, 893000.00, 107000.00, 0.00),
(73, '2024-08-17', '10', 'mruga', 10000.00, 1200.00, 8800.00, 0.00),
(74, '2024-08-17', '11', 'mruga', 1000.00, 800.00, 200.00, 0.00),
(75, '2024-08-17', '6', 'muruga', 100.00, 90.00, 10.00, 0.00),
(76, '2024-08-17', '1', 'muruga', 10000.00, 59000.00, 0.00, 49000.00),
(77, '2024-08-19', 'a', 'mruga', 10000.00, 6000.00, 4000.00, 0.00),
(78, '2024-08-17', '1', 'muruga', 10000.00, 3600.00, 6400.00, 0.00),
(79, '2024-08-20', '1', 'muruga', 1000.00, 800.00, 200.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `admin2`
--

CREATE TABLE `admin2` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `s_no` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin2`
--

INSERT INTO `admin2` (`id`, `quotation_id`, `s_no`, `item`, `price`, `qty`, `total`) VALUES
(36, 57, 1, '1', 1000.00, 2, 2000.00),
(37, 58, 1, 'qw', 10000.00, 1, 10000.00),
(39, 60, 1, 'pen', 90.00, 10, 900.00),
(68, 71, 1, 'a', 200.00, 5, 1000.00),
(69, 71, 2, 'b', 10000.00, 4, 40000.00),
(70, 71, 3, 'd', 1000000.00, 3, 3000000.00),
(71, 72, 1, 'm', 1000.00, 3, 3000.00),
(72, 72, 2, 'u', 1000.00, 5, 5000.00),
(73, 72, 3, 'r', 20000.00, 3, 60000.00),
(74, 72, 4, 'u', 5000.00, 5, 25000.00),
(75, 72, 5, 'g', 10000.00, 10, 100000.00),
(76, 72, 6, 'a', 700000.00, 1, 700000.00),
(77, 73, 1, 'm', 100.00, 7, 700.00),
(78, 73, 2, 'u', 100.00, 1, 100.00),
(79, 73, 3, 'r', 100.00, 1, 100.00),
(80, 73, 4, 'u', 100.00, 1, 100.00),
(81, 73, 5, 'g', 100.00, 1, 100.00),
(82, 73, 6, 'a', 100.00, 1, 100.00),
(83, 74, 1, 'a', 100.00, 1, 100.00),
(84, 74, 2, 'b', 500.00, 1, 500.00),
(85, 74, 3, 'c', 200.00, 1, 200.00),
(86, 75, 1, '1', 90.00, 1, 90.00),
(87, 76, 1, 'v', 1000.00, 1, 1000.00),
(88, 76, 2, 'e', 1000.00, 3, 3000.00),
(89, 76, 3, 'l', 1000.00, 5, 5000.00),
(90, 76, 0, 'y', 10000.00, 5, 50000.00),
(91, 77, 1, 'v', 1000.00, 2, 2000.00),
(92, 77, 2, 'e', 1000.00, 2, 2000.00),
(93, 77, 3, 'l', 1000.00, 2, 2000.00),
(94, 78, 1, 'pen', 100.00, 2, 200.00),
(95, 78, 2, 'doctor', 1000.00, 3, 3000.00),
(96, 78, 3, 'pf', 100.00, 4, 400.00),
(97, 79, 1, 'pen', 100.00, 4, 400.00),
(98, 79, 2, 'paper', 100.00, 2, 200.00),
(99, 79, 3, 'l', 50.00, 4, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'Admin@gmail.com', 'Admin@123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin2`
--
ALTER TABLE `admin2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_id` (`quotation_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `admin2`
--
ALTER TABLE `admin2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin2`
--
ALTER TABLE `admin2`
  ADD CONSTRAINT `admin2_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
