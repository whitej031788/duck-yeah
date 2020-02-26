<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person_Event_Action extends Model
{
    protected $table = 'person_event_actions';

    protected $fillable = ['person_id', 'event_type_id', 'giphy_action', 'youtube_url', 'description'];
}
