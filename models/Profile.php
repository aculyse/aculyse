<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Profile extends Model {

    protected $table = "profiles";

    public function classes() {
        return $this->hasOne('Aculyse\Models\Classes', "class_id", "class_name");
    }

    public function for_subject() {
        return $this->hasOne('Aculyse\Models\Subjects', "id", "subject");
    }

    public function hasMarks(){
    	return $this->hasMany('Aculyse\Models\Marks','profile id','id');
    }
}
