@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Events</div>

                <table class="wide">
                    <thead>
                        <tr>
                            <th> Event </th>
                            <th> Category  </th>
                            <th> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="trhover">
                            <td><a href="{{ route("display", $event->id)}}"> {{$event->name}}</a> </td>
                            <td> {{$event->category }} </td>
                            <td> {{$event->date}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection