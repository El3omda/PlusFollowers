-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2021 at 02:57 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instafollowers`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `OrderOwner` varchar(50) NOT NULL,
  `RFollowers` int(6) NOT NULL,
  `OldFollowers` int(11) NOT NULL,
  `NewFollowers` int(11) NOT NULL,
  `CFollowers` int(11) NOT NULL,
  `OrderStatus` varchar(10) NOT NULL,
  `CoinSpend` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `OrderOwner`, `RFollowers`, `OldFollowers`, `NewFollowers`, `CFollowers`, `OrderStatus`, `CoinSpend`) VALUES
(10, 'hassan', 5, 10718, 0, 0, 'Pending', 50),
(11, 'adel', 1, 4034, 4035, 1, 'Success', 50),
(12, 'adel', 5, 4035, 0, 0, 'Pending', 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `UserEmail` varchar(100) NOT NULL,
  `UserPass` varchar(100) NOT NULL,
  `InstaUser` varchar(50) NOT NULL,
  `Followers` int(11) NOT NULL,
  `Follows` int(11) NOT NULL,
  `Coins` int(11) NOT NULL DEFAULT 0,
  `Online` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `UserEmail`, `UserPass`, `InstaUser`, `Followers`, `Follows`, `Coins`, `Online`) VALUES
(3, 'emad othman', 'el3om0a@gmail.com', '123456', 'E.A.A.A.O', 246, 3, 40, 'No'),
(28, 'mohamed ibrahim', 'mo@123.com', '123', 'hassan', 10721, 225, 0, 'No'),
(29, 'Adel Shakel', 'sh@123.com', '123', 'adel', 4031, 281, 0, 'Yas'),
(31, 'Abdelfatah Elsisi', 'sisi@123.com', '123', 'sisi', 127, 0, 0, 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserEmail` (`UserEmail`),
  ADD UNIQUE KEY `InstaUser` (`InstaUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
