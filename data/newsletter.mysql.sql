-- phpMyAdmin SQL Dump
-- version 4.3.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2015 at 02:53 PM
-- Server version: 10.0.19-MariaDB-1~trusty-log
-- PHP Version: 5.5.9-1ubuntu4.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `charisma-beads`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterMailQueue`
--

DROP TABLE IF EXISTS `newsletterMailQueue`;
CREATE TABLE IF NOT EXISTS `newsletterMailQueue` (
  `subscriberId` int(11) unsigned NOT NULL,
  `mailQueueId` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterMessage`
--

DROP TABLE IF EXISTS `newsletterMessage`;
CREATE TABLE IF NOT EXISTS `newsletterMessage` (
  `messageId` int(10) unsigned NOT NULL,
  `templateId` int(10) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=1558 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterSubscription`
--

DROP TABLE IF EXISTS `newsletterSubscription`;
CREATE TABLE IF NOT EXISTS `newsletterSubscription` (
  `subscriptionId` int(10) unsigned NOT NULL,
  `subscriberId` int(10) unsigned NOT NULL,
  `newsletterId` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD PRIMARY KEY (`subscriptionId`);

--
-- Indexes for table `newsletterTemplate`
--
ALTER TABLE `newsletterTemplate`
  ADD PRIMARY KEY (`templateId`);

SET FOREIGN_KEY_CHECKS=1;

