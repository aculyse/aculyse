CREATE TABLE IF NOT EXISTS `schools` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `account_type` int(11) NOT NULL,
  `level` text NOT NULL,
  `from_date` date NOT NULL,
  `to_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
