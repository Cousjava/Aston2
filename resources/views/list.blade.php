@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="title">Events</div>

                <table class="wide ">
                    <thead>
                        <tr>
                            <th> Event </th>
                            <th> Category  </th>
                            <th> Date </th>
                            <th> Time </th>
                            <th> Location </th>
                            <th> Description
                        </tr>
                    </thead>
                    <tbody class="largerFont">
                        @foreach($events as $event)
                        <tr class="trhover">
                            <td><a href="{{ route("display", $event->id)}}"> {{$event->name}}</a> </td>
                            <td> {{$event->category }} </td>
                            <td> {{$event->date}} </td>
                            <td> {{str_limit($event->time, 5, '')}} </td>
                            <td> {{$event->location}}</td>
                            <td> {{str_limit($event->description, 75) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection