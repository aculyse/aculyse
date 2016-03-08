CREATE VIEW  `profiles_and_marks` AS select `profiles`.`id` AS `profile id`,`profiles`.`subject` AS `subject`,`profiles`.`year` AS `year`,`profiles`.`term` AS `term`,`profiles`.`status` AS `status`,`marks`.`combined mark` AS `mark`,`marks`.`comment` AS `comment`,`marks`.`student id` AS `student id`,`marks`.`grade` AS `grade` from (`profiles` join `marks`) where (`profiles`.`id` = `marks`.`profile id`);