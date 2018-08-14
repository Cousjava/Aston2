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
        $events = Event::paginate(20);
        return view('/list', array('events' => $events));
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
        Log::debug("Creating or updating an event with ".implode('|', $data));
        
        $event = Event::find($data[id]);
        if (isset($event)) {
            Log::debug("Updating event".strval($event));
            $event->fill($data);
            $event->save();
            Log::debug("Event is now". strval($event));
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
    
    /**
     * Sets a students interest in an event
     * @param type $id event id
     * @param type $interest true if the student is interested in the event
     * @return type
     */
    public function displayInterest($id, $interest = false) {
        $event = Event::find($id);
        $userId = Auth::id();
        if ($interest) {
            $event->attendees()->attach($userId);
        } else {
            $event->attendees()->detach($userId);
        }
        //Show original event again with a redirect to make it idempotent
        return redirect()->route('display',$event->id); 
    }
    
    public function category($category) {
        return view('/list', array('events' => Event::query()->whereDate('date', '>=', now())->where('category', $category)->paginate(10)));
    }
    
    public function popular() {
        $events = Event::query()->whereDate('date', '>=', now())->withCount('attendees')->orderBy('attendees_count', 'desc')->paginate(10);
        return view('/list', $events);
    }
    
    public function byDate(){
        return view('/list', array('events' => Event::query()->orderBy('date')->paginate(10)));
    }
    
    public function mine(){
        $user = Auth::user();
        if ($user->type == 'event_organiser') {
            $events = Event::query()->where('event_organiser', $user->id)->paginate(10);
            return view('/list', array('events' => $events));
        } else {
            $events = $user->events()->paginate(10);
            return view('/list', array('events'=> $events)); 
        }
        
    }

}