<?php

/**
 * Manage guardian info as well as relationships
 * with students
 *
 * @author Blessing Mashoko <projects@bmashoko.com>
 * @package Guardian
 */

namespace Aculyse\Guardian;

use Aculyse;
use Aculyse\Traits\Eloquent;
use Aculyse\Models\GuardianStudent;
use Aculyse\Traits\GuardianInvitable;
use Aculyse\Models\Student;

class Guardian
{

    use Eloquent,
        GuardianInvitable;

    /**
     * ID of guardian as saved in database
     * @var id
     */
    public $id;

    public function __construct()
    {
        $this->startEloquent();
    }

    /**
     * Get info about a guardian
     * @param $guardian_id
     * @return mixed
     */
    public function getInfo($guardian_id)
    {
        return Aculyse\Models\Guardian::find($guardian_id);
    }

    /**
     * Get a list of dependences
     * @return array
     */
    public function getDependences()
    {
        $dependences = GuardianStudent::where("guardian_id", $this->id)
            ->with("dependent")
            ->with("dependent.classes")
            ->with("dependent.school_info")
            ->get();
        return $dependences->toArray();

    }

    /**
     *
     * @param $guardian_id
     */
    public function refreshDependences()
    {
        $guardian = $this->getInfo($this->id);

        $dependences = $this->findByContact($guardian->phone, $guardian->email);

        //delete all relationships of the logged user and recreate them
        $this->deleteRelationships();
        foreach ($dependences as $dep) {
            $saving_status = $this->saveRelationships($dep->id, $this->id);
        }

        return $saving_status;

    }

    /**
     * Find dependences by contact details
     * @param $phone_number
     * @param $email_address
     * @return mixed
     */
    private function findByContact($phone_number, $email_address)
    {
        $dependences = Student::where('cell number', $phone_number)
            ->orWhere('email', $email_address)
            ->where('cell number', '!=', '')
            ->where('email', '!=', '')
            ->get();

        return $dependences;

    }

    /**
     * Save relationship between guardian and student
     * @param $student_id
     * @param $guardian_id
     */
    private function saveRelationships($student_id, $guardian_id)
    {

        $GuardianStudent = new GuardianStudent();
        $GuardianStudent->student_id = $student_id;
        $GuardianStudent->guardian_id = $guardian_id;
        return $GuardianStudent->save();
    }

    /**
     * Delete current relationships between guardian and student
     * @return mixed
     */
    private function deleteRelationships()
    {
        $guardian = GuardianStudent::where('guardian_id', $this->id);
        return $guardian->delete();

    }

}
