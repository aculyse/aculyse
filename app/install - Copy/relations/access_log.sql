CREATE TABLE IF NOT EXISTS `access_log` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `browser` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='store access logs to the app  ' ;
