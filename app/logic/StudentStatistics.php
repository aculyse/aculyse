<?php

namespace Aculyse;

use Aculyse\Students;
use Aculyse\Helpers\Auth;
use Aculyse\Models\Student;

class StudentStatistics extends Students
{

    private $current_year;

    public function __construct()
    {
        $this->current_year = date("Y");
        parent::__construct();
    }

    public function all_records()
    {
        $count = Student::where("school", Auth\ActiveSession::school())->count();
        return $count;
    }

    private function onlyActive($status)
    {

        $count = Student::where("school", Auth\ActiveSession::school())
                ->where("status", $status)
                ->where("class of", "<", $this->current_year)
                ->count();
        return $count;
    }

    public function count($status, $only_active = TRUE)
    {

        if ($only_active) {
            return $this->onlyActive($status);
        }
        $count = Student::where("school", Auth\ActiveSession::school())
                ->where("status", $status)
                ->count();
        return $count;
    }

}
