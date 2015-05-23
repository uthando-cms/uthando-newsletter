
CREATE TABLE IF NOT EXISTS `newsletterSubscriber` (
  `subscriberId` int(10) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

ALTER TABLE `newsletterSubscriber`
  ADD PRIMARY KEY (`subscriberId`), ADD UNIQUE KEY `email` (`email`);

CREATE TABLE IF NOT EXISTS `newsletterMailQueue` (
  `subscriberId` int(11) NOT NULL,
  `mailQueueId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
