<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $fillable = ['name', 'description', 'date', 'category', 'event_organiser'];
    
    /**
     * Gets the pictures for this event
     * @return type
     */
    public function pictures(){
        return $this->hasMany('App\Picture');
    }
    
    public function organiser(){
        return $this->hasOne('App\User');
    }
    
    public function attendees(){
        return $this->belongsToMany('App\User', 'user_event_intrests', 'eventId', 'userId');
    }
    
}