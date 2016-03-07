CREATE TABLE IF NOT EXISTS `profiles` (
`id` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `school` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `number of courseworks` int(11) NOT NULL,
  `class of` int(11) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  `status` enum('closed','in progress','','') NOT NULL DEFAULT 'in progress',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `author` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='A list of profiles created';
