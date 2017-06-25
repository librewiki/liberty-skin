-- phpMyAdmin SQL Dump
-- version 4.8.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 25, 2017 at 04:52 PM
-- Server version: 10.1.24-MariaDB-1~xenial
-- PHP Version: 7.1.6-1~ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Akari_Sandbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `liberty_navbar`
--

CREATE TABLE /*_*/liberty_navbar(
  number int(10) NOT NULL COMMENT 'Order of menu',
  title text NOT NULL COMMENT 'Menu Title',
  icon text DEFAULT NULL COMMENT 'FontAwesome Icon Name',
  link text DEFAULT NULL COMMENT 'Menu Link'
)/*$wgDBTableOptions*/;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `liberty_navbar`
--
ALTER TABLE /*_*/liberty_navbar
  ADD PRIMARY KEY (number);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `liberty_navbar`
--
ALTER TABLE /*_*/liberty_navbar
  MODIFY number int(10) NOT NULL AUTO_INCREMENT COMMENT 'Order of menu';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
