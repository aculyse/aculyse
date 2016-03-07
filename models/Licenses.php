<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Licenses extends Model
{

     public $primaryKey = "key";
     public $timestamps = false;

     public function plan_type(){
     	return $this->hasOne('Aculyse\Models\AccountTypes','id','plan_id');
     }

     public function school_info(){
     	return $this->hasOne("Aculyse\Models\School","id","school_id");
     }
}
