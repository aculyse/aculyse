<?php

/**
 * * @package Elearning
 */

namespace Aculyse\Elearning;

use Aculyse\Traits\Eloquent;
use Aculyse\Models\ElearningResources;
use Aculyse\Helpers\Auth\ActiveSession;

class Resources
{

    use Eloquent;

    public function __construct()
    {
        $this->startEloquent();
        $this->authenticated_user = ActiveSession::user();
        $this->auth_teacher_id = ActiveSession::id();
        $this->auth_school_id = ActiveSession::school();
    }

    public function getAll()
    {
        return ElearningResources::all();
    }

    public function get($resource_id)
    {
        return ElearningResources::find($resource_id)->first();
    }

}
