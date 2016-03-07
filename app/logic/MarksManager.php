<?php

/*
  | -----------------------------------------------------------------------
  | MARK MANAGER
  | -----------------------------------------------------------------------
  | Perform CRUD proccesses against marks
  |
 */

namespace Aculyse;

use Aculyse\Models\Marks;
use Aculyse\Models\Student;
use Aculyse\Traits\Eloquent;
use Aculyse\Interfaces\IMark;
use Aculyse\Traits\DBConnection;
use Aculyse\Helpers\Auth\ActiveSession;
use Illuminate\Database\Capsule\Manager as Capsule;

class MarksManager implements IMark
{

    use Eloquent;

    function __construct()
    {
        $this->startEloquent();
    }

    /**
     * Get student marks in a profile
     * @param int $student_id
     * @param int $profile_id
     * @return type
     */
    public function getStudentMarks($student_id, $profile_id)
    {
        $marks = Marks::where("student id", $student_id)
            ->where("profile id", $profile_id)
            ->where("deleted", "FALSE")
            ->get();

        return $marks;
    }

    public function report($student_id)
    {
        $marks = Student::where("student_id", $student_id)
            ->with("has_marks")
            ->get()
            ->first();
        return $marks;
    }

    /**
     * Add blank marks for profile. This is used for initialisation
     * purposes. For changing marks check out updateMarks method
     *
     * @param string $student_id
     * @param int $profile_id
     * @return type
     */
    public function insertMark($student_id, $profile_id)
    {
        $mark = new Marks();
        $mark["profile id"] = $profile_id;
        $mark["student id"] = $student_id;
        return $mark->save();
    }

    /**
     * Get marks in a profile
     * @param int $profile_id
     * @return array
     */
    public function getProfileMarkList($profile_id)
    {
        $marks = Marks::where("profile id", $profile_id)
            ->where("deleted", "FALSE")
            ->orderBy("student id", "ASC")
            ->with("profile_details")
            ->with("student_details")
            ->get();

        return $marks;
    }

    /**
     * Helper method for top and bottom students
     * @param int $profile_id
     * @param string $order
     * @param int $limit
     * @return array
     */
    protected function getTopAndBottomMarks($profile_id, $order = "DESC", $limit = 5)
    {
        $marks = Marks::where("profile id", $profile_id)
            ->where("deleted", "FALSE")
            ->orderBy("combined mark", $order)
            ->limit($limit)
            ->get();

        return $marks;
    }

    /**
     * Get bootom students in a profile
     * @param int $profile_id
     * @return type
     */
    public function getBottomStudents($profile_id)
    {
        return $this->getTopAndBottomMarks($profile_id, "ASC");
    }

    /**
     * Get top students in a profile
     * @param int $profile_id
     * @return type
     */
    public function getTopStudents($profile_id)
    {
        return $this->getTopAndBottomMarks($profile_id, "DESC");
    }

    /**
     * Update student mark, this is used on initialised profiles
     * for new profiles check insertMark function
     * @param int $id Database id of the mark
     * @param int $column Coursework number
     * @param double $value The value to be saved
     * @param boolean $is_final
     * @param int $profile_id
     */
    public function updateMark($id, $column, $value, $is_final, $profile_id)
    {
        if (!is_numeric($value) || $value > 100 || $value < 0) {
            return "invalid mark";
        }

        if (!is_numeric($column)) {
            return "invalid column";
        }
        $db_column = "course work $column";

        if (strtoupper($is_final) == "TRUE") {
            $db_column = "final exam";
        }

        $mark = Marks::find($id);
        $mark["$db_column"] = $value;
        return $mark->save();
    }

}
