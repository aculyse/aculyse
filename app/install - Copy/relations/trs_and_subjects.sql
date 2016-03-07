CREATE TABLE IF NOT EXISTS `trs and subjects` (
`id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `class` int(11) NOT NULL,
  `deleted` enum('yes','no','','') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

