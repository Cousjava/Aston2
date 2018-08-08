<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Student
Route::get('/home', 'HomeController@index')->name('home');

Route::get('event/{id}', 'EventController@display')->name('display')->middleware('auth');
Route::post('event/{id}/{interest}', 'EventController@display')->name('displayInterest')->middleware('auth');
Route::get('events', 'EventController@all');
Route::get('events/by/t/{category}/{startAt?}', 'EventController@category')->middleware('auth');;
Route::get('events/by/popular/{startAt?}', 'EventController@popular')->middleware('auth');;
Route::get('events/by/');

//Organisers
Route::get('events/new', 'EventController@new')->name('newEvent')->middleware('auth');
Route::get('events/edit/{id}', 'EventController@edit')->name('editEvent')->middleware('auth');;


