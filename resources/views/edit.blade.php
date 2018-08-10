@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Event') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('saveEvent') }}" aria-label="{{ __('Edit') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                       name="name" value="{{ $event->name }}" required autofocus maxlength="100">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Separate date and time fields as datetime-local is not supported by all browsers yet-->
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" 
                                       name="date" value="{{ $event->date }}" min="{{ date('Y-m-d')}}" required >

                                @if ($errors->has('date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Time') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" 
                                       name="time" value="{{ str_limit($event->time, 5, '') }}" required >

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                                       name="location" value="{{ $event->location }}" required autofocus maxlength="100">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
                            <div class="col-md-6">
                                <select name="category" required selected="{{$event->category}}">
                                    <option>Sport</option>
                                    <option>Culture</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" 
                                       name="description" autofocus maxlength="4000">{{ $event->description }}</textarea>
                                Maximum characters: 4000

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        @if (count($pictures) >= 1)
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Images') }}</label>
                            <div class="col-md-6">
                                Tick the box for any image you wish to delete
                                @foreach($pictures as $picture)
                                <p>
                                    <img src="../../../storage/app/{{$picture->location }}" width="100" height="100">
                                    <input type="checkbox" name="oldimages[]" value="{{$picture->id}}">
                                </p>
                                @endforeach

                            </div>
                        </div>
                        @endif
                        
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Upload Images') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="images[]" 
                                       accept="image/*" multiple>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                Images have a maximum file size of 2MB.
                            </div>
                        </div>

                        

                        <input type="hidden" name="id" value="{{$event->id}}">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
