ALTER TABLE `access_log`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `account_types`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `activity_log`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `classes`
 ADD PRIMARY KEY (`class_id`);


ALTER TABLE `licenses`
 ADD PRIMARY KEY (`key`);


ALTER TABLE `marks`
 ADD PRIMARY KEY (`id`), ADD KEY `college number` (`student id`);


ALTER TABLE `profiles`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `schools`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `students`
 ADD PRIMARY KEY (`student_id`), ADD UNIQUE KEY `id` (`id`), ADD KEY `class name` (`class_name`), ADD KEY `class of` (`class of`);


ALTER TABLE `subjects`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `trs and subjects`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
 ADD PRIMARY KEY (`teacher id`), ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `access_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `account_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `activity_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `classes`
MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;


ALTER TABLE `marks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `schools`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `trs and subjects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `users`
MODIFY `teacher id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `guardians`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`email`), ADD UNIQUE KEY `phone` (`phone`);

ALTER TABLE `guardian_invitations`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `guardian_students`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `guardians`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `guardian_invitations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `guardian_students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;