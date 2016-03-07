CREATE TABLE IF NOT EXISTS `subjects` (
`id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `pry level` enum('yes','no','','') NOT NULL,
  `o level` enum('yes','no','','') NOT NULL,
  `a level` enum('yes','no','','') NOT NULL,
  `school` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
