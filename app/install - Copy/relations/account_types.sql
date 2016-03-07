CREATE TABLE IF NOT EXISTS `account_types` (
`id` int(11) NOT NULL,
  `type` enum('trial','free','basic','premium','ultimate') NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
