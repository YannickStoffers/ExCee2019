--
-- Table structure for table `packlist`
--

DROP TABLE IF EXISTS `packlist`;
CREATE TABLE `packlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(50),
  `section` enum('Personal Care','Clothing','Sleeping','Travel','Other') NOT NULL DEFAULT 'Other',
  PRIMARY KEY (`id`)
) ENGINE = INNODB;
