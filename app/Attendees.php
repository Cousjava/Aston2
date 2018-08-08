<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendees extends Model
{
    protected $table = 'user_event_intrests';
    protected $primaryKey = ['userId', 'eventId'];
    public $incrementing = false;
}