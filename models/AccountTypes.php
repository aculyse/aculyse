<?php

namespace Aculyse\Models;

use Illuminate\Database\Eloquent\Model as Model;

class AccountTypes extends Model
{

    public $table = "account_types";
    public $timestamps = false;

    public function activated()
    {
        return $this->hasOne('Aculyse\Models\Licenses', 'plan_id', 'id');
    }

}
