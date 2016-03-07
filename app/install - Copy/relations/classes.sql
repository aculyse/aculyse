CREATE TABLE IF NOT EXISTS `classes` (
`class_id` int(11) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  `level` varchar(50) NOT NULL,
  `school` int(11) NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='this table contains classes found in schools';
