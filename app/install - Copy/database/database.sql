-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2016 at 09:37 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

-- --------------------------------------------------------

--
-- Table structure for table `access log`
--

CREATE TABLE IF NOT EXISTS `access log` (
`id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `ip address` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `browser` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='store access logs to the app  ' ;

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE IF NOT EXISTS `account_types` (
`id` int(11) NOT NULL,
  `type` enum('trial','free','basic','premium','ultimate') NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
`id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `activity_type` enum('delete','edit','create','update','read') NOT NULL,
  `table` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `browser` text NOT NULL,
  `ip address` varchar(200) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='track all activities';

-- --------------------------------------------------------

--
-- Table structure for table `breakdowns`
--

CREATE TABLE IF NOT EXISTS `breakdowns` (
`id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `test_num` text NOT NULL,
  `exam` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
`class_id` int(11) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  `level` varchar(50) NOT NULL,
  `school` int(11) NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='this table contains classes found in schools';

-- --------------------------------------------------------

--
-- Table structure for table `elearning_resources`
--

CREATE TABLE IF NOT EXISTS `elearning_resources` (
`id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `level` varchar(200) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `author` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `format` varchar(200) NOT NULL,
  `link` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(250) NOT NULL,
  `browser` text NOT NULL,
  `status` enum('pending','solved','','') NOT NULL DEFAULT 'pending',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE IF NOT EXISTS `guardians` (
`id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guardian_invitations`
--

CREATE TABLE IF NOT EXISTS `guardian_invitations` (
`id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `invitation_code` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `invitation_key` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guardian_students`
--

CREATE TABLE IF NOT EXISTS `guardian_students` (
`id` int(11) NOT NULL,
  `guardian_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='guardian and student link';

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
`id` int(11) NOT NULL,
  `profile id` int(11) NOT NULL,
  `student id` varchar(100) NOT NULL,
  `course work 1` float NOT NULL DEFAULT '0',
  `course work 2` float NOT NULL DEFAULT '0',
  `course work 3` float NOT NULL DEFAULT '0',
  `course work 4` float NOT NULL DEFAULT '0',
  `course work 5` float NOT NULL DEFAULT '0',
  `course work 6` float NOT NULL DEFAULT '0',
  `course work 7` float NOT NULL DEFAULT '0',
  `course work 8` float NOT NULL DEFAULT '0',
  `course work 9` float NOT NULL DEFAULT '0',
  `course work 10` float NOT NULL DEFAULT '0',
  `course work percentage` float NOT NULL,
  `final weight percentage` float NOT NULL,
  `final exam` float NOT NULL,
  `weighted course work` float NOT NULL,
  `weighted final mark` float NOT NULL,
  `combined mark` int(11) NOT NULL,
  `grade` varchar(100) NOT NULL,
  `deleted` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE',
  `comment` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='This table contains the marks of the students';

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`id` int(11) NOT NULL,
  `school` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','cancelled','approved','denied') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='order pressed by schools';

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
`id` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `topic` text NOT NULL,
  `objectives` text NOT NULL,
  `assumed_knowledge` text NOT NULL,
  `media` text NOT NULL,
  `introduction` text NOT NULL,
  `stages_num` int(11) NOT NULL,
  `conclusion` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='lesson plans';

-- --------------------------------------------------------

--
-- Table structure for table `plan_stages`
--

CREATE TABLE IF NOT EXISTS `plan_stages` (
`id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `stage_num` int(11) NOT NULL,
  `lesson_content` text NOT NULL,
  `pupil_activity` text NOT NULL,
  `teacher_activity` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='the stages in lesson plans';

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

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

-- --------------------------------------------------------

--
-- Stand-in structure for view `profiles_and_marks`
--
CREATE TABLE IF NOT EXISTS `profiles_and_marks` (
`profile id` int(11)
,`subject` int(11)
,`year` int(11)
,`term` int(11)
,`status` enum('closed','in progress','','')
,`mark` int(11)
,`comment` text
,`student id` varchar(100)
,`grade` varchar(100)
);
-- --------------------------------------------------------

--
-- Table structure for table `profile_metadata`
--

CREATE TABLE IF NOT EXISTS `profile_metadata` (
`id` int(11) NOT NULL,
  `profile id` int(11) NOT NULL,
  `test_num` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `scope` text NOT NULL,
  `comment` text NOT NULL,
  `last modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='describes data about the profile';

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `account_type` int(11) NOT NULL,
  `level` text NOT NULL,
  `from_date` date NOT NULL,
  `to_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `school_trs_view`
--
CREATE TABLE IF NOT EXISTS `school_trs_view` (
`id` int(11)
,`name` text
,`account_type` int(11)
,`from_date` date
,`to_date` datetime
,`teacher id` int(11)
,`username` varchar(100)
,`password` varchar(100)
,`fullname` text
,`school` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
`id` int(11) NOT NULL,
  `student_id` varchar(12) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  `class of` int(11) NOT NULL,
  `school` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middle name` text NOT NULL,
  `surname` text NOT NULL,
  `home` text NOT NULL,
  `cell number` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `sex` enum('MALE','FEMALE') NOT NULL,
  `piclink` varchar(100) NOT NULL,
  `status` enum('activated','deactivated','suspended','graduated','deferred','drop-out','deleted') NOT NULL DEFAULT 'deactivated',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students and subjects`
--

CREATE TABLE IF NOT EXISTS `students and subjects` (
`id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
`id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `pry level` enum('yes','no','','') NOT NULL,
  `o level` enum('yes','no','','') NOT NULL,
  `a level` enum('yes','no','','') NOT NULL,
  `school` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `title`, `pry level`, `o level`, `a level`, `school`) VALUES
  (1, 'PRINCIPLES OF ACCOUNTS', '', '', '', 0),
  (2, 'AGRICULTURE', '', '', '', 0),
  (3, 'ART', '', '', '', 0),
  (4, 'BIOLOGY', '', '', '', 0),
  (5, 'BUSINESS STUDIES', '', '', '', 0),
  (6, 'COMMERCE', '', '', '', 0),
  (7, 'TONGA', '', '', '', 0),
  (8, 'ENGLISH', '', '', '', 0),
  (9, 'FRENCH', '', '', '', 0),
  (10, 'GEOGRAPHY', '', '', '', 0),
  (11, 'HISTORY', '', '', '', 0),
  (12, 'INTERGRATED SCIENCE', '', '', '', 0),
  (13, 'ENGLISH LITERATURE', '', '', '', 0),
  (14, 'MATHEMATICS', '', '', '', 0),
  (15, 'METALWORK', '', '', '', 0),
  (16, 'MUSIC', '', '', '', 0),
  (17, 'NDAU', '', '', '', 0),
  (18, 'NDEBELE', '', '', '', 0),
  (19, 'PHYSICAL EDUCATION AND SPORT', '', '', '', 0),
  (20, 'PHYSICAL SCIENCE', '', '', '', 0),
  (21, 'PORTUGUESE', '', '', '', 0),
  (22, 'RELIGIOUS STUDIES', '', '', '', 0),
  (23, 'SHONA', '', '', '', 0),
  (25, 'VENDA', '', '', '', 0),
  (26, 'WOODWORK', '', '', '', 0),
  (27, 'HUMAN AND SOCIAL BIOLOGY', '', '', '', 0),
  (28, 'SOCIOLOGY', '', '', '', 0),
  (29, 'STATISTICS', '', '', '', 0),
  (30, 'TECHNICAL GRAPHICS', '', '', '', 0),
  (32, 'CHEMISTRY', '', '', '', 0),
  (33, 'HOME ECONOMICS', '', '', '', 0),
  (34, 'FASHION AND FABRICS', '', '', '', 0),
  (35, 'FOOD AND NUTRITION', '', '', '', 0),
  (36, 'HOME MANAGEMENT', '', '', '', 0),
  (38, 'ECONOMICS', '', '', '', 0),
  (39, 'COMPUTER STUDIES', '', '', '', 0),
  (43, 'LAW', '', '', '', 0),
  (44, 'FURTHER MATHEMATICS', '', '', '', 0),
  (45, 'GEOMETRICAL & MECHANICAL/BUILDING DRAWING', '', '', '', 0),
  (46, 'LITERATURE IN ENGLISH', '', '', '', 0),
  (47, 'DIVINITY', '', '', '', 0),
  (48, 'ENGLISH LANGUAGE AND COMMUNICATION SKILLS ', '', '', '', 0),
  (49, 'TEXTILES AND CLOTHING DESIGN', '', '', '', 0),
  (50, 'FOOD SCIENCE', '', '', '', 0);
--
-- Stand-in structure for view `teacher_with_their_subjects`
--
CREATE TABLE IF NOT EXISTS `teacher_with_their_subjects` (
`id` int(11)
,`deleted` enum('yes','no','','')
,`title` varchar(150)
,`teacher_id` int(11)
,`class` int(11)
,`subject` text
);
-- --------------------------------------------------------

--
-- Table structure for table `trs and subjects`
--

CREATE TABLE IF NOT EXISTS `trs and subjects` (
`id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `class` int(11) NOT NULL,
  `deleted` enum('yes','no','','') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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

-- --------------------------------------------------------

--
-- Structure for view `profiles_and_marks`
--
DROP TABLE IF EXISTS `profiles_and_marks`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `profiles_and_marks` AS select `profiles`.`id` AS `profile id`,`profiles`.`subject` AS `subject`,`profiles`.`year` AS `year`,`profiles`.`term` AS `term`,`profiles`.`status` AS `status`,`marks`.`combined mark` AS `mark`,`marks`.`comment` AS `comment`,`marks`.`student id` AS `student id`,`marks`.`grade` AS `grade` from (`profiles` join `marks`) where (`profiles`.`id` = `marks`.`profile id`);

-- --------------------------------------------------------

--
-- Structure for view `school_trs_view`
--
DROP TABLE IF EXISTS `school_trs_view`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `school_trs_view` AS select `schools`.`id` AS `id`,`schools`.`name` AS `name`,`schools`.`account_type` AS `account_type`,`schools`.`from_date` AS `from_date`,`schools`.`to_date` AS `to_date`,`users`.`teacher id` AS `teacher id`,`users`.`username` AS `username`,`users`.`password` AS `password`,`users`.`fullname` AS `fullname`,`users`.`school` AS `school` from (`schools` join `users`) where (`schools`.`id` = `users`.`school`);

-- --------------------------------------------------------

--
-- Structure for view `teacher_with_their_subjects`
--
DROP TABLE IF EXISTS `teacher_with_their_subjects`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `teacher_with_their_subjects` AS select `trs and subjects`.`id` AS `id`,`trs and subjects`.`deleted` AS `deleted`,`subjects`.`title` AS `title`,`trs and subjects`.`teacher_id` AS `teacher_id`,`trs and subjects`.`class` AS `class`,`trs and subjects`.`subject` AS `subject` from (`trs and subjects` join `subjects`) where (`trs and subjects`.`subject` = `subjects`.`id`);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access log`
--
ALTER TABLE `access log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `breakdowns`
--
ALTER TABLE `breakdowns`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
 ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `elearning_resources`
--
ALTER TABLE `elearning_resources`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`email`), ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `guardian_invitations`
--
ALTER TABLE `guardian_invitations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardian_students`
--
ALTER TABLE `guardian_students`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
 ADD PRIMARY KEY (`key`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
 ADD PRIMARY KEY (`id`), ADD KEY `college number` (`student id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_stages`
--
ALTER TABLE `plan_stages`
 ADD PRIMARY KEY (`id`), ADD KEY `plans` (`plan_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_metadata`
--
ALTER TABLE `profile_metadata`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
 ADD PRIMARY KEY (`student_id`), ADD UNIQUE KEY `id` (`id`), ADD KEY `class name` (`class_name`), ADD KEY `class of` (`class of`);

--
-- Indexes for table `students and subjects`
--
ALTER TABLE `students and subjects`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trs and subjects`
--
ALTER TABLE `trs and subjects`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`teacher id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access log`
--
ALTER TABLE `access log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `breakdowns`
--
ALTER TABLE `breakdowns`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `elearning_resources`
--
ALTER TABLE `elearning_resources`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `guardian_invitations`
--
ALTER TABLE `guardian_invitations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `guardian_students`
--
ALTER TABLE `guardian_students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `plan_stages`
--
ALTER TABLE `plan_stages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `profile_metadata`
--
ALTER TABLE `profile_metadata`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `students and subjects`
--
ALTER TABLE `students and subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `trs and subjects`
--
ALTER TABLE `trs and subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `teacher id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
