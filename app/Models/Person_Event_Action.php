<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person_Event_Action extends Model
{
    protected $table = 'person_event_actions';

    protected $fillable = ['person_id', 'event_type_id', 'giphy_url', 'youtube_key', 'description', 'youtube_start'];

    public function event_type_info() {
        return $this->hasOne(Event_Type::class, 'id', 'event_type_id');
    }
}