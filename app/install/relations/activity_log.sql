CREATE TABLE IF NOT EXISTS `activity_log` (
`id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `activity_type` enum('delete','edit','create','update','read') NOT NULL,
  `table` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `browser` text NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='track all activities';
