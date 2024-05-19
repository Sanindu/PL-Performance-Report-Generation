-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 11:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `league`
--

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `team` varchar(255) NOT NULL,
  `won` int(11) NOT NULL,
  `drawn` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `goalsfor` int(11) NOT NULL,
  `against` int(11) NOT NULL,
  `gd` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `played` int(11) DEFAULT NULL,
  `manager` varchar(255) DEFAULT NULL,
  `remaining` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team`, `won`, `drawn`, `lost`, `goalsfor`, `against`, `gd`, `points`, `played`, `manager`, `remaining`) VALUES
(83, 'Manchester City', 27, 7, 3, 93, 33, 60, 88, 37, NULL, 2),
(84, 'Arsenal', 27, 5, 5, 89, 28, 61, 86, 37, NULL, 3),
(85, 'Liverpool', 23, 10, 4, 84, 41, 43, 79, 37, NULL, 3),
(86, 'Aston Villa', 20, 8, 9, 76, 56, 20, 68, 37, NULL, 3),
(87, 'Tottenham Hotspur', 19, 6, 12, 71, 61, 10, 63, 37, NULL, 1),
(88, 'Chelsea', 17, 9, 11, 75, 62, 13, 60, 37, NULL, 3),
(89, 'Newcastle United', 17, 6, 14, 81, 60, 21, 57, 37, NULL, 3),
(90, 'Manchester United', 17, 6, 14, 55, 58, -3, 57, 37, NULL, 1),
(91, 'West Ham United', 14, 10, 13, 59, 71, -12, 52, 37, NULL, 2),
(92, 'Brighton & Hove Albion', 12, 12, 13, 55, 60, -5, 48, 37, NULL, 3),
(93, 'AFC Bournemouth', 13, 9, 15, 53, 65, -12, 48, 37, NULL, 3),
(94, 'Crystal Palace', 12, 10, 15, 52, 58, -6, 46, 37, NULL, 3),
(95, 'Wolverhampton Wanderers', 13, 7, 17, 50, 63, -13, 46, 37, NULL, 3),
(96, 'Fulham', 12, 8, 17, 51, 59, -8, 44, 37, NULL, 2),
(97, 'Everton', 13, 9, 15, 39, 49, -10, 40, 37, NULL, 3),
(98, 'Brentford', 10, 9, 18, 54, 61, -7, 39, 37, NULL, 3),
(99, 'Nottingham Forest', 8, 9, 20, 47, 66, -19, 29, 37, NULL, 3),
(100, 'Luton Town', 6, 8, 23, 50, 81, -31, 26, 37, NULL, 3),
(101, 'Burnley', 5, 9, 23, 40, 76, -36, 24, 37, NULL, 1),
(102, 'Sheffield United', 3, 7, 27, 35, 101, -66, 16, 37, NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
