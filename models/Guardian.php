<?php


namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Guardian extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];
}
