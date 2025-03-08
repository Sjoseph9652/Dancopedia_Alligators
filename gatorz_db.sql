-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 12:43 PM
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
-- Database: `gatorz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dances`
--

CREATE TABLE `dances` (
  `dance_ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `creator_email` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `style` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` blob NOT NULL,
  `MimeType` varchar(30) DEFAULT NULL,
  `Link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dances`
--


INSERT INTO `dances` (`dance_ID`, `name`, `creator_email`, `region`, `style`, `description`, `status`, `image`, `MimeType`,`Link`) VALUES
(1, 'Tango', 'example.account@gmail.com','Mexico','Tango', 'Dance', 0, '', NULL, NULL),
(2, 'example dance', 'example.account@gmail.com', 'Mexico', 'Southern', 'This is an example dance', 0, '', NULL, NULL),
(3, 'example dance', 'example.account@gmail.com',  'Mexico','Western','This is an example dance', 0, '', NULL, NULL);
-- --------------------------------------------------------

--
-- Table structure for table `dancesuggestion`
--

CREATE TABLE `dancesuggestion` (
  `suggestion_ID` int(11) NOT NULL,
  `dance_name` varchar(30) NOT NULL,
  `style` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dancesuggestion`
--

INSERT INTO `dancesuggestion` (`suggestion_ID`, `dance_name`, `style`, `region`, `description`) VALUES
(1, 'new dance ', 'East', 'pop', 'Add this ');

-- --------------------------------------------------------

--
-- Table structure for table `inaccuracies`
--

CREATE TABLE `inaccuracies` (
  `report_ID` int(11) NOT NULL,
  `dance_name` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inaccuracies`
--

INSERT INTO `inaccuracies` (`report_ID`, `dance_name`, `description`) VALUES
(1, 'tango ', 'I think this is from a different region'),
(2, 'other dance ', 'I think this is from a different region');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `pref_ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `value` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    hash VARCHAR(255),
    active VARCHAR(10),
    role VARCHAR(20),
    modified_time DATETIME,
    created_time DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `hash`, `role`) VALUES
(1, 'Joe ', 'Salmon ', 'sv2606xg@go.minnstate.edu', 'password', 'user'),
(2, 'example ', 'account', 'example.account@gmail.com', '1234', 'user'),
(3, 'Bill ', 'Bob', 'Bill.Bob@gmail.com', '4321', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dances`
--
ALTER TABLE `dances`
  ADD PRIMARY KEY (`dance_ID`);

--
-- Indexes for table `dancesuggestion`
--
ALTER TABLE `dancesuggestion`
  ADD PRIMARY KEY (`suggestion_ID`);

--
-- Indexes for table `inaccuracies`
--
ALTER TABLE `inaccuracies`
  ADD PRIMARY KEY (`report_ID`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`pref_ID`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dances`
--
ALTER TABLE `dances`
  MODIFY `dance_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dancesuggestion`
--
ALTER TABLE `dancesuggestion`
  MODIFY `suggestion_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inaccuracies`
--
ALTER TABLE `inaccuracies`
  MODIFY `report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `pref_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
