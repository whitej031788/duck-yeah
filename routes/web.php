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
    return view('welcome');
});

// We don't want anyone to be able to register, so only enable registration to create highest admin users

Auth::routes();

/*
Comment out above and uncomment below to remove the ability for new registrations, which
should be done for production as new users should only be added via an already authenticated user 
*/

// Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/add-person', 'PersonController@index')->name('add_person_view');
    Route::post('/add-person', 'PersonController@addPerson')->name('add_person_post');
});