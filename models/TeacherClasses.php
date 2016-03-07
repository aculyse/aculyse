<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class TeacherClasses extends Model {

    protected $table = "trs and subjects";
    public $timestamps = false;

    public function user_info(){
    	return $this->hasOne('Aculyse\Models\User','teacher id','teacher_id');
    }

    public function subject_info(){
    	return $this->hasOne('Aculyse\Models\Subjects','id','subject');
    }

    public function class_info(){
    	return $this->hasOne('Aculyse\Models\Classes','class_id','class');
    }
}
