-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2026 at 02:25 AM
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
-- Database: `smartbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ItemID` int(11) NOT NULL,
  `ParentItemID` int(11) DEFAULT NULL,
  `ItemName` varchar(120) NOT NULL,
  `Description` text DEFAULT NULL,
  `ItemType` enum('Category','Product') NOT NULL DEFAULT 'Category'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationID` int(11) NOT NULL,
  `City` varchar(80) NOT NULL,
  `State` varchar(80) NOT NULL,
  `County` varchar(80) DEFAULT NULL,
  `Latitude` decimal(9,6) DEFAULT NULL,
  `Longitude` decimal(9,6) DEFAULT NULL,
  `Timezone` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `StoreID` int(11) NOT NULL,
  `LocationID` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Type` varchar(60) NOT NULL,
  `PriceRating` tinyint(3) UNSIGNED DEFAULT NULL,
  `HoursOfOperation` varchar(160) DEFAULT NULL,
  `CustomerReviews` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `storeitem`
--

CREATE TABLE `storeitem` (
  `StoreID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `StockStatus` enum('In Stock','Limited','Out of Stock','Unknown') DEFAULT 'Unknown',
  `ProductRating` decimal(2,1) NOT NULL DEFAULT 4.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `fk_category_parent` (`ParentItemID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`),
  ADD UNIQUE KEY `uq_location_city_state` (`City`,`State`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`StoreID`),
  ADD KEY `fk_store_location` (`LocationID`);

--
-- Indexes for table `storeitem`
--
ALTER TABLE `storeitem`
  ADD PRIMARY KEY (`StoreID`,`ItemID`),
  ADD KEY `fk_storecategory_category` (`ItemID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `StoreID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `fk_store_location` FOREIGN KEY (`LocationID`) REFERENCES `location` (`LocationID`) ON UPDATE CASCADE;

--
-- Constraints for table `storeitem`
--
ALTER TABLE `storeitem`
  ADD CONSTRAINT `fk_storecategory_category` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_storecategory_store` FOREIGN KEY (`StoreID`) REFERENCES `store` (`StoreID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;