<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Breakdown extends Model {

	public $timestamps = false;

	protected $casts = ['test_num' => 'array'];

	public function profile_info(){
		return $this->hasOne('Aculyse\Models\Profile','id','profile_id');
	}

}
