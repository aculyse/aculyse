CREATE TABLE IF NOT EXISTS `guardian_students` (
`id` int(11) NOT NULL,
  `guardian_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1 COMMENT='guardian and student link';
