-- phpMyAdmin SQL Dump
-- version 4.3.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2016 at 09:56 PM
-- Server version: 5.5.47-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `uthando-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `newsletterId` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `visible` int(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterMessage`
--

DROP TABLE IF EXISTS `newsletterMessage`;
CREATE TABLE IF NOT EXISTS `newsletterMessage` (
  `messageId` int(10) unsigned NOT NULL,
  `templateId` int(10) unsigned NOT NULL,
  `newsletterId` int(10) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterSubscriber`
--

DROP TABLE IF EXISTS `newsletterSubscriber`;
CREATE TABLE IF NOT EXISTS `newsletterSubscriber` (
  `subscriberId` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterSubscription`
--

DROP TABLE IF EXISTS `newsletterSubscription`;
CREATE TABLE IF NOT EXISTS `newsletterSubscription` (
  `subscriptionId` int(10) unsigned NOT NULL,
  `subscriberId` int(10) unsigned NOT NULL,
  `newsletterId` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterTemplate`
--

DROP TABLE IF EXISTS `newsletterTemplate`;
CREATE TABLE IF NOT EXISTS `newsletterTemplate` (
  `templateId` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
ADD PRIMARY KEY (`newsletterId`);

--
-- Indexes for table `newsletterMessage`
--
ALTER TABLE `newsletterMessage`
ADD PRIMARY KEY (`messageId`);

--
-- Indexes for table `newsletterSubscriber`
--
ALTER TABLE `newsletterSubscriber`
ADD PRIMARY KEY (`subscriberId`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `newsletterSubscription`
--
ALTER TABLE `newsletterSubscription`
ADD PRIMARY KEY (`subscriptionId`), ADD KEY `subscriberId` (`subscriberId`), ADD KEY `newsletterId` (`newsletterId`);

--
-- Indexes for table `newsletterTemplate`
--
ALTER TABLE `newsletterTemplate`
ADD PRIMARY KEY (`templateId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
MODIFY `newsletterId` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `newsletterMessage`
--
ALTER TABLE `newsletterMessage`
MODIFY `messageId` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `newsletterSubscriber`
--
ALTER TABLE `newsletterSubscriber`
MODIFY `subscriberId` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `newsletterSubscription`
--
ALTER TABLE `newsletterSubscription`
MODIFY `subscriptionId` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `newsletterTemplate`
--
ALTER TABLE `newsletterTemplate`
MODIFY `templateId` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `newsletterSubscription`
--
ALTER TABLE `newsletterSubscription`
ADD CONSTRAINT `newsletterSubscription_ibfk_1` FOREIGN KEY (`subscriberId`) REFERENCES `newsletterSubscriber` (`subscriberId`) ON DELETE CASCADE,
ADD CONSTRAINT `newsletterSubscription_ibfk_2` FOREIGN KEY (`newsletterId`) REFERENCES `newsletter` (`newsletterId`) ON DELETE CASCADE;
