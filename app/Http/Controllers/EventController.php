<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Event;
use App\Picture;

class EventController extends Controller {

    public function all() {
        return view('/list', array('account' => Event::all()));
    }

    public function display($id) {
        return view('/display', array('event' => Event::findOrFail($id), 'pictures' => Picture::query()->where('event_id', $id)->get()));
    }
    
    public function edit($id) {
        return view('/edit', array('event' => Event::findOrFail($id), 'pictures' => Picture::query()->where('event_id', $id)->get()));
    }
    
    public function newEvent(){
        return view('/edit');
    }
    
    public function save(Request $request){
        $data = $request->all();
        $data['event_organiser'] = \Illuminate\Support\Facades\Auth::id();
         Log::info("Creating a new event with ");
        foreach($data as $key => $var){
            Log::info($key." with value of ".$var);
        }
        Log::info("Creating a new event with ".implode('|', $data));
        $event = Event::create($data);
        foreach($request->images as $image){
            $file = $image->store('photos');
            Picture::create(['location' => $file, 'event_id' => $event->id]);
        }
        return redirect('display/'.$event->id);
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