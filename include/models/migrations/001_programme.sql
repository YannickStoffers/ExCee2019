--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date,
  `time` time,
  `title` varchar(255),
  `description` varchar(4096),
  `image_name` varchar(30),
  `company_visit` tinyint(1) NOT NULL DEFAULT '0',
  `company_id` int,
  PRIMARY KEY (`id`)
) ENGINE = INNODB;
