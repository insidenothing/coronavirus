CREATE TABLE `coronavirus_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_number` varchar(50) NOT NULL,
  `sms_status` varchar(50) NOT NULL DEFAULT 'new',
  `date_validated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sms_number` (`sms_number`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8
