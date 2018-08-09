@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{ $event->name}}</h2>
            @foreach($pictures as $picture)
            <p>
                <img src="../../storage/app/{{$picture->location }}"></img>
            </p>
            @endforeach
            
            <h4>Event Organiser: {{$organiser}}</h4>
            
            <h4>Date: {{$event->date}}</h4>
            <h4>Time: {{ str_limit($event->time, 5, '')}}</h4>
            <h4>Location: {{$event->location}}</h4>
            
            <h4>Category: {{$event->category}}</h4>
            
            <p>
                {{$event->description}}    
            </p>
            
            @if (Auth::id() == $event->event_organiser)
            <button onclick="location.href='{{ route('editEvent', $event->id) }}'">Edit</button>
            @endif
        </div>
    </div>
</div>
@endsection