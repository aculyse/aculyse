<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class GuardianStudent extends Model
{

    public $timestamps = false;

    public function dependent()
    {
        return $this->hasMany("Aculyse\Models\Student", "id", "student_id");
    }

}
