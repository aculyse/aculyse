<?php

/*
  | -----------------------------------------------------------------------
  | PROFILER
  | -----------------------------------------------------------------------
  | Manage student perfomance profiles
  |
 */

namespace Aculyse;

use Aculyse\Models\Marks;
use Aculyse\Models\Profile;
use Aculyse\Models\Student;
use Aculyse\Models\Subjects;
use Aculyse\Traits\Eloquent;
use Aculyse\Traits\DBConnection;
use Aculyse\Helpers\Auth\ActiveSession;
use Aculyse\Loggers\ActivityLogger;

class Profiler extends MarksManager
{

    use Eloquent,
        DBConnection;

    public $ActivityLogger;
    private $Student;
    private $final_exam_weight;
    private $course_work_weight;
    private $number_of_courseworks;
    private $weighted_course_work;
    private $profile_id;

    function __construct()
    {
        $this->Student = new Students();
        $this->startEloquent();
        $this->con = $this->databaseInstance();
        $this->authenticated_user = ActiveSession::user();
        $this->auth_teacher_id = ActiveSession::id();
        $this->auth_school_id = ActiveSession::school();
    }

    /**
     * Check if a profile is available, Return TRUE if profile is not availble or else
     * @param string $subject
     * @param int $term
     * @param date $year
     * @param string $mode
     * @param date $class_of
     * @return string|boolean
     */
    public function isProfileNotTaken(array $arg)
    {
        $this->subject = $arg["subject"];
        $this->term = $arg["term"];
        $this->year = $arg["year"];
        $this->mode = $arg["mode"];
        $this->class_of = $arg["class of"];

        $result = Profile::where("subject", $this->subject)
                ->where("term", $this->term)
                ->where("year", $this->year)
                ->where("class_name", $this->mode)
                ->where("class of", $this->class_of)
                ->count();

        if (is_numeric($result) && $result == 0) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Get a list of students in a class
     * @param type $subject
     * @param type $term
     * @param type $year
     * @param type $number_of_courseworks
     * @param type $mode
     * @param type $class_of
     * @return boolean
     */
    public function getClassStudents(array $student_arg)
    {

        $this->subject = $student_arg["subject"];
        $this->term = $student_arg["term"];
        $this->year = $student_arg["year"];
        $this->number_of_courseworks = $student_arg["course work"];
        $this->mode = $student_arg["mode"];
        $this->class_of = $student_arg["class of"];

        $this->result = Student::where("class of", $this->class_of)
                ->where("class_name", $this->mode)
                ->where("school", $this->auth_school_id)
                ->where("status", "!=", "deleted")
                ->get()
                ->toArray();

        if (is_array($this->result)) {
            asort($this->result);
            return $this->result;
        }
        return FALSE;
    }

    /**
     * Save initial profile marks to database
     * NB* all the marks will be zero we are just saving a list of students in a profile
     * @param type $students
     * @param type $subject
     * @param type $term
     * @param type $year
     * @param type $number_of_courseworks
     * @param type $mode
     * @param type $class_of
     * @param type $single_student
     * @return string
     */
    public function initializeProfile($students, array $profile_data, $status = "in progress")
    {
        if (!is_array($profile_data) || !is_array($students)) {
            return FALSE;
        }

        $profile = new Profile();
        $profile["subject"] = $profile_data["subject"];
        $profile["term"] = $profile_data["term"];
        $profile["year"] = $profile_data["year"];
        $profile["number of courseworks"] = $profile_data["course work"];
        $profile["class_name"] = $profile_data["mode"];
        $profile["class of"] = $profile_data["class of"];
        $profile["status"] = "in progress";
        $profile["author"] = $this->auth_teacher_id;
        $profile["school"] = $this->auth_school_id;
        $profile->save();
        $profile_id = $profile->id;

        if ($this->generateInitialMarks($students, $profile_id)) {
            return json_encode(array("status" => "success", "profile" => $profile_id));
        }
        return "MarkGenerationException";
    }

    /**
     * Generate student marks spread sheet with zeros as default values
     * @param  array  $students   list of students
     * @param  int $profile_id unique id of the profile which marks are to be entered
     * @todo "Check for success"
     */
    public function generateInitialMarks(array $students, $profile_id)
    {
        //check if the list of students is an array first
        if (!is_array($students)) {
            return "DataFormatException";
        }
        foreach ($students as $value) {
            $student_id = $value["student_id"];
            $this->insertMark($student_id, $profile_id);
        }
        return TRUE;
    }

    /**
     * Add a student as an individual to a profile manually
     * @return string
     */
    public function addIndividualInProfile($student_id)
    {
        return $this->Student->findByStudentId($student_id);
    }

    /**
     * Get profiles created by the currently logged in user
     * @return array
     */
    public function getTeacherProfiles()
    {
        $profiles = Profile::where("status", "!=", "closed")
                ->where("school", ActiveSession::school())
                ->where("author", ActiveSession::id())
                ->orderBy("year", "DESC")
                ->with('classes')
                ->with('for_subject')
                ->get();
        return $profiles;
    }

    /**
     * Get all closed profiles
     * @return type
     */
    public function getClosedProfiles()
    {
        $profiles = Profile::where("status", "closed")
                ->where("school", ActiveSession::school())
                ->orderBy("year", "DESC")
                ->with('classes')
                ->with('for_subject')
                ->get();
        return $profiles;
    }

    /**
     * Get a list of profiles for a subject and class
     * @param type $subject_id
     * @param type $class_of
     * @param type $status
     * @return type
     */
    public function getSubjectProfiles($subject_id, $class_of, $status = "closed")
    {
        $profile = Profile::where('subject', $subject_id)
                ->where("class of", $class_of)
                ->where("status", $status)
                ->orderBy("year", "DESC")
                ->orderBy("term", "DESC")
                ->get();
        return $profile;
    }

    /**
     * Compile and close the profile. After this operationn the records become readonly. At least no further compiling can be done.
     * @param type $subject
     * @param type $term
     * @param type $year
     * @param type $mode
     * @param type $class_of
     * @param type $course_work_weight
     * @param type $final_exam_weight
     * @return string
     */
    public function compileProfile(array $profile_data, $course_work_weight = 0, $final_exam_weight = 0)
    {

        $ClassMgr = new ClassManager();

        $this->profile_id = mysqli_real_escape_string($this->con, $profile_data["profile_id"]);
        $this->number_of_courseworks = mysqli_real_escape_string($this->con, $profile_data["course work"]);

        $this->course_work_weight = mysqli_real_escape_string($this->con, $course_work_weight);
        $this->final_exam_weight = mysqli_real_escape_string($this->con, $final_exam_weight);
        $this->weighted_course_work = 0;
//validate
        if (!is_numeric($this->final_exam_weight) || !is_numeric($this->course_work_weight) || $this->final_exam_weight > 100 || $this->final_exam_weight < 0 || $this->course_work_weight > 100 || $this->course_work_weight < 0) {
            throw new \Exception("InvalidWeightException");
        }

        if ($this->course_work_weight + $this->final_exam_weight > 100) {
            throw new Exception("WeightOverflowException");
        }

        if ($this->getProfileStatus($this->profile_id)->count() == 0) {
            throw new \Exception("ProfileUnavailableException");
        }

        $this->dataset = $this->getProfileMarkList($this->profile_id);

        //choose grading system based on class level
        $class_level = $ClassMgr->getClassDetails($profile_data["class_name"])[0]["level"];
        $grading = GradingSystem::chooseDefaultGrading($class_level);

        for ($i = 0; $i <= sizeof($this->dataset) - 1; $i++) {
            $this->final_mark = mysqli_real_escape_string($this->con, $this->dataset[$i]["final exam"]);
            $this->id = mysqli_real_escape_string($this->con, $this->dataset[$i]["id"]);

            //retrieve course work values
            $this->total_course_work = 0;
            for ($j = 1; $j <= $this->number_of_courseworks; $j++) {
                $this->total_course_work += $this->dataset[$i]["course work $j"];
            }

            //calculate weighted course work
            if ($this->number_of_courseworks != 0) {
                $this->weighted_course_work = ($this->total_course_work / $this->number_of_courseworks) * ($this->course_work_weight / 100);
            }
            $this->weighted_exam_mark = $this->final_mark * ($this->final_exam_weight / 100);

            //this is the final mark for the student
            $this->weighted_final_mark = $this->weighted_course_work + $this->weighted_exam_mark;

            $grade_symbol = GradingSystem::ZIMSEC($grading, $this->weighted_final_mark);
            $this->saveCompiled($this->id, $grade_symbol);
        }
        if ($this->closeProfile($this->profile_id) == TRUE) {
            return "Success";
        }
        return "ProfileClosureFailure";
    }

    /**
     * Save a compiled mark
     * @param type $mark_id
     * @param type $grade_symbol
     * @return type
     */
    private function saveCompiled($mark_id, $grade_symbol)
    {
        $compiled_mark = Marks::find($mark_id);

        $compiled_mark["weighted course work"] = $this->weighted_course_work;
        $compiled_mark["weighted final mark"] = $this->weighted_exam_mark;

        $compiled_mark["combined mark"] = $this->weighted_final_mark;

        $compiled_mark["course work percentage"] = $this->course_work_weight;
        $compiled_mark["final weight percentage"] = $this->final_exam_weight;

        $compiled_mark["grade"] = $grade_symbol;
        return $compiled_mark->save();
    }

    /**
     * Make the profile readonly
     * @param  int  $profile_id
     * @return bool
     * @TODO find a way to determine if saving was successful
     */
    private function closeProfile($profile_id)
    {
        $Profile = Profile::find($profile_id);
        $Profile->status = "closed";
        return $Profile->save();
    }

    public function updateTestNumber($profile_id, $new_value)
    {
        $profile = Profile::find($profile_id);
        $profile["number of courseworks"] = $new_value;
        return $profile->save();
    }

    /**
     * Remove student marks
     * @param type $student_id
     * @return string|boolean
     */
    public final function removeStudentMarks($student_id)
    {
        $marks = Mark::find($student_id);
        $marks->deleted = "TRUE";
        return $marks->save();
    }

    /**
     * Get status of the Profile
     * @param array $profile_data
     * @return boolean
     */
    public function getProfileStatus($profile_id = NULL)
    {

        $profile_details = Profile::find($profile_id);

        if ($profile_details->count() == 0) {
            return FALSE;
        }
        return $profile_details;
    }

    /**
     * Map subject id to the name of the subject, something easy for humanity to understand
     * @param  int $subject_id the unique id of a subject
     */
    public function getSubjectName($subject_id)
    {
        return Subjects::find($subject_id);
    }

}
