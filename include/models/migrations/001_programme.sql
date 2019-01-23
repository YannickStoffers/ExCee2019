--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(4096),
  PRIMARY KEY (`id`)
) ENGINE = INNODB;
