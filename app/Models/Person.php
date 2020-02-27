<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';

    protected $fillable = ['first_name', 'last_name', 'email', 'job_role_id'];

    public function job_role() {
        return $this->hasOne(Job_Role::class, 'id', 'job_role_id');
    }

    public function event_actions() {
        return $this->hasMany(Person_Event_Action::class, 'person_id', 'id')->with('event_type_info');
    }
}
