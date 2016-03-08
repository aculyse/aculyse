CREATE TABLE IF NOT EXISTS `licenses` (
  `plan_id` int(11) NOT NULL,
  `key` varchar(200) NOT NULL,
  `pin` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `activated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiry_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `used` enum('1','0','','') NOT NULL DEFAULT '0',
  `duration` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
