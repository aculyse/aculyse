<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Marks extends Model
{

    public function profile_details()
    {
        return $this->hasOne('Aculyse\Models\Profile', "id", "profile id");
    }

    
    public function student_details()
    {
        return $this->hasOne('Aculyse\Models\Student', "student_id", "student id");
    }

}
