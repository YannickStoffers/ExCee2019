--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` enum('pre-excursion','city-01','city-02','city-03','post-excursion') NOT NULL DEFAULT 'pre-excursion',
  `date` date,
  `time` time,
  `title` varchar(255),
  `description` varchar(4096),
  `image_name` varchar(30),
  `company_visit` tinyint(1) NOT NULL DEFAULT '0',
  `company_id` int,
  PRIMARY KEY (`id`)
) ENGINE = INNODB;
