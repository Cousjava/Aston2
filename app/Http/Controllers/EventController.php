<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Picture;

class EventController extends Controller {

    public function all() {
        return view('/list', array('account' => Event::all()));
    }

    public function display($id) {
        return view('/display', array('event' => Event::findOrFail($id), 'pictures' => Picture::query()->where('eventId', $id)->get()));
    }
    
    public function displayInterest($id, $interest) {
        $event = Event::find($id);
        $userId = Auth::userId();
        if ($interest) {
            $event->attendees()->attach($userId);
        } else {
            $event->attendees()->detach($userId);
        }
        return display($id); //Show original event again
    }
    
    public function category($category) {
        return view('/list', array('events' => Event::query()->where('date' >= now())->where('category', $category)->paginate()));
    }
    
    public function popular() {
        $events = Event::query()->where('date' >= now())->withCount('attendees')->orderBy('attendees_count', 'desc')->paginate(20);
        return view('/list', $events);
    }

}