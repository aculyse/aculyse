<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Student extends Model {

    protected $table = "students";
    public $timestamps = false;
    protected $hidden = ['password'];

    public function classes() {
        return $this->hasOne('Aculyse\Models\Classes', "class_id", "class_name");
    }

    public function has_marks(){
        return $this->hasMany('Aculyse\Models\Marks','student id','student_id');
    }

    public function school_info()
    {
        return $this->hasOne('Aculyse\Models\School', "id", "school");
    }

    public function getStatusAttribute($status) {
        return strtoupper($status);
    }

    public function getStudentIdAttribute($student_id) {
        return strtoupper($student_id);
    }

}
