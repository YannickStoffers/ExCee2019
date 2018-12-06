--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
CREATE TABLE `registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255),
  `surname` varchar(255),
  `birthday` date,
  `address` varchar(255),
  `postal_code` varchar(255),
  `city` varchar(255),
  `email` varchar(254), -- official max length of an email-address
  `phone` varchar(100),
  `emergency_phone` varchar(100),
  `iban` varchar(34), -- official max length of an iban
  `bic` varchar(11), -- official max length of a bic
  `student_ov` enum('Weekend','Week','Neither') NOT NULL,
  `remarks` varchar(1024),
  `accept_terms` tinyint(1) NOT NULL DEFAULT '0',
  `accept_costs` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('registered','cancelled','waiting_list') NOT NULL DEFAULT 'registered',
  PRIMARY KEY (`id`),
  UNIQUE (`email`)
) ENGINE = INNODB;