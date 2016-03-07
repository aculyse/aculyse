<?php

namespace Aculyse\Interfaces;

interface IMark
{

    public function getTopStudents($profile_id);

    public function getBottomStudents($profile_id);

    public function getProfileMarkList($profile_id);

    public function insertMark($student_id, $profile_id);

    public function getStudentMarks($student_id, $profile_id);

    public function updateMark($id, $column, $value, $is_final, $profile_id);
}
