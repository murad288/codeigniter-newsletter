-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2019 at 03:12 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsletter_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_contents`
--

CREATE TABLE `newsletter_contents` (
  `nl_id` int(8) NOT NULL,
  `tracking_no` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `nl_group` varchar(200) NOT NULL,
  `nl_email` blob NOT NULL,
  `nl_contents` blob NOT NULL,
  `status` int(2) NOT NULL,
  `user` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sendingTime` datetime NOT NULL,
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_que`
--

CREATE TABLE `newsletter_que` (
  `queId` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `email` blob NOT NULL,
  `nl_contents` blob NOT NULL,
  `user` int(5) NOT NULL,
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` text NOT NULL,
  `uniqueId` int(10) NOT NULL,
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subscription_group` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `createdBy` varchar(8) NOT NULL,
  `createdTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateBy` varchar(8) NOT NULL,
  `updateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriber_group`
--

CREATE TABLE `subscriber_group` (
  `gid` int(8) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `createdTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `newsletter_contents`
--
ALTER TABLE `newsletter_contents`
  ADD PRIMARY KEY (`nl_id`);

--
-- Indexes for table `newsletter_que`
--
ALTER TABLE `newsletter_que`
  ADD PRIMARY KEY (`queId`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriber_group`
--
ALTER TABLE `subscriber_group`
  ADD PRIMARY KEY (`gid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `newsletter_contents`
--
ALTER TABLE `newsletter_contents`
  MODIFY `nl_id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `newsletter_que`
--
ALTER TABLE `newsletter_que`
  MODIFY `queId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscriber_group`
--
ALTER TABLE `subscriber_group`
  MODIFY `gid` int(8) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
