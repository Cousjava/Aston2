<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Picture;

class EventController extends Controller {

    public function all() {
        return view('/list', array('events' => Event::all()));
    }

    public function display($id) {
        $event = Event::findOrFail($id);
        $organiser = User::find($event->event_organiser);
        $intrested = DB::table('user_event_intrests')->where('userId', Auth::user()->id)->where('eventId', $event->id)->count();
        return view('/display', array('event' => $event, 'pictures' => Picture::query()->where('event_id', $id)->get(), 'organiser'=> $organiser->name,
                 'intrest' => $intrested));
    }
    
    public function edit($id) {
        return view('/edit', array('event' => Event::findOrFail($id), 'pictures' => Picture::query()->where('event_id', $id)->get()));
    }
    
    public function newEvent(){
        return view('/edit');
    }
    
    /**
     * Saves an event based on data in a request
     * If an event id is provided then that request is edited,
     * otherwise a new event is created
     * @param Request $request
     * @return type
     */
    public function save(Request $request){
        $data = $request->all();
        
        $data['event_organiser'] = \Illuminate\Support\Facades\Auth::id();
        Log::fine("Creating or updating an event with ".implode('|', $data));
        
        $event = Event::find($data[id]);
        if (isset($event)) {
            Log::fine("Updating event".strval($event));
            $event->fill($data);
            $event->save();
            Log::fine("Event is now". strval($event));
            //If checkboxes were checked then delete image
            foreach($request->oldimages as $toDelete){
                Picture::destroy($toDelete);
            }
        } else {
            $event = Event::create($data);
        }
        //Add any images
        foreach($request->images as $image){
            $file = $image->store('photos');
            Picture::create(['location' => $file, 'event_id' => $event->id]);
        }
        return redirect()->route('display',$event->id);
    }
    
    public function displayInterest($id, $interest = false) {
        $event = Event::find($id);
        $userId = Auth::id();
        if ($interest) {
            $event->attendees()->attach($userId);
        } else {
            $event->attendees()->detach($userId);
        }
        return redirect()->route('display',$event->id); //Show original event again
    }
    
    public function category($category) {
        return view('/list', array('events' => Event::query()->where('date' >= now())->where('category', $category)->paginate()));
    }
    
    public function popular() {
        $events = Event::query()->where('date' >= now())->withCount('attendees')->orderBy('attendees_count', 'desc')->paginate(50);
        return view('/list', $events);
    }
    
    public function mine(){
        $user = Auth::user();
        if ($user->type == 'Event Organiser') {
            return view('/list', array('events'=>where('event_organiser', $user->id)));
        } else {
            return view('/list', array('events'=> $user->events())); 
        }
        
    }

}