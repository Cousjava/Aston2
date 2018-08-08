<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = ['location'];
    
    public function event(){
        return $this->belongsTo('App\Event');
    }
}