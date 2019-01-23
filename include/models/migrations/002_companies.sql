--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50),
  `description` varchar(4096),
  `home_page` varchar(255),
  `logo_url` varchar(255),
  `activity_date` date,
  `activity_time` time,
  `activity_description` varchar(4096),
  PRIMARY KEY (`id`),
  UNIQUE(`name`)
) ENGINE = INNODB;
