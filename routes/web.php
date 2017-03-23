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

Route::get('/', function () {
	$task = DB::table('task')->get();
    return view('welcome', compact('task'));
});

Route::get('/task/{id}', function ($id) {

	$task = DB::table('task')->find($id);

    return view('Task.show', compact('task'));
});

Route::get('/calendar', function () {

	

    return view('Task.calendar');
});

Auth::routes();

Route::get('/first', 'EventsController@first');

Route::post("/map", 'EventsController@index');

Route::get('/home', 'HomeController@index');
