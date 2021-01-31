-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 24, 2021 at 12:01 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `JobID` int(11) NOT NULL,
  `Position` varchar(255) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Wage` int(11) DEFAULT NULL,
  `PostingDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`JobID`, `Position`, `Type`, `Email`, `Description`, `Wage`, `PostingDate`) VALUES
(1, 'Software Developer', 'full-time', 'hr1@gmail.com', 'This is a software developer job.', 30, '2021-01-21'),
(2, 'Full Stack Web Developer', 'part-time', 'hr2@gmail.com', 'This is a full-stack web developer job.', 40, '2021-01-15'),
(3, 'Data Scientist', 'contract', 'hr3@gmail.com', 'This is a data scientist job.', 50, '2021-01-11'),
(4, 'IT Analyst', 'contract', 'hr4@gmail.com', 'This is an information technology analyst job.', 10, '2021-01-05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`JobID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `JobID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
