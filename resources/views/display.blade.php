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
            @auth
            @if (Auth::id() == $event->event_organiser)
            <button onclick="location.href='{{ route('editEvent', $event->id) }}'">Edit</button>
            @endif
            @if (Auth::user()->type == 'student')
                @if ($intrest == 0)
                    <form method="POST" action="{{ route('displayInterest', ['id'=>$event->id, 'intrest'=>true]) }}">
                     @csrf
                    <input type="hidden" name="intrest" value="true">
                    <input type="submit" id="submitIntrest" value="I'm interested!">
                @else
                    <form method="POST" action="{{ route('displayInterest', ['id'=>$event->id, 'intrest'=>false]) }}">
                    @csrf
                    <input type="hidden" name="intrest" value="false">
                    <input type="submit" id="submitIntrest" value="No longer interested">
                @endif
                </form>
            @endif
            @endauth
        </div>
    </div>
</div>
@endsection