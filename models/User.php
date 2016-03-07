<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model {

	public $primaryKey="teacher id";
    public $timestamps = false;
    public $hidden = ["password"];

}
