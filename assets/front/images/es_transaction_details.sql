-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2018 at 10:20 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estates`
--

-- --------------------------------------------------------

--
-- Table structure for table `es_transaction_details`
--

CREATE TABLE `es_transaction_details` (
  `id` int(11) NOT NULL,
  `property_number` varchar(30) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `tranid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pay_status` varchar(10) CHARACTER SET utf8 NOT NULL,
  `amount` double NOT NULL,
  `payment_date` varchar(30) CHARACTER SET utf8 NOT NULL,
  `created_financial_year` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `es_transaction_details`
--

INSERT INTO `es_transaction_details` (`id`, `property_number`, `name`, `receipt_no`, `tranid`, `pay_status`, `amount`, `payment_date`, `created_financial_year`) VALUES
(1, '408102001709', 'श्री. ताहेर गफुर कोकणी', 'ETSRCEP00001', 'e72c2d1b22d2174b61eb', 'success', 4706, '1543845258', '2018-2019'),
(2, '408102001709', 'श्री. ताहेर गफुर कोकणी', 'ETSRCEP00002', 'e72c2d1b22d2174b65rt', 'success', 5000, '1543968000', '2018-2019'),
(3, '104300299 ', 'Sachin', 'ETSRCEP00003', '1e572761a7941b3153aa', 'success', 100, '1543995235', '2018-2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `es_transaction_details`
--
ALTER TABLE `es_transaction_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `es_transaction_details`
--
ALTER TABLE `es_transaction_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
