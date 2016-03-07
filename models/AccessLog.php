<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class AccessLog extends Model
{
    protected $table = "access_log";
    public $timestamps=true;
}
