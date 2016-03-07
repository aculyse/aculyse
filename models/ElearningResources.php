<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class ElearningResources extends Model
{

    public function subject_info()
    {
        return $this->hasOne('Aculyse\Models\Subjects', 'id', 'subject_id');
    }

    public function author_info()
    {
        return $this->hasOne('Aculyse\Models\User', 'teacher id', 'author');
    }

    public function class_info()
    {
        return $this->hasOne('Aculyse\Models\Classes', 'class_id', 'class_id');
    }

}
