CREATE TABLE IF NOT EXISTS `users` (
`teacher id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `access level` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `sex` enum('male','female','','') NOT NULL,
  `school` int(11) DEFAULT NULL,
  `cell number` varchar(100) NOT NULL,
  `piclink` text NOT NULL,
  `status` enum('activated','deactivated','suspended','deleted') NOT NULL DEFAULT 'activated',
  `reset_key` varchar(100) NOT NULL,
  `verification_code` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='list of teachers in the database';
