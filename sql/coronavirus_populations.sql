CREATE TABLE `coronavirus_populations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_of_location` varchar(100) NOT NULL,
  `number_of_people` int(11) NOT NULL,
  `rate_of_infection` varchar(25) NOT NULL,
  `recoveries` int(11) NOT NULL,
  `deaths` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_of_location` (`name_of_location`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8
