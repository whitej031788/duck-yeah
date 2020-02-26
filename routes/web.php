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
    return view('main');
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

    Route::get('/edit-person/{id}', 'PersonController@index')->name('edit_person_view');
    Route::post('/edit-person', 'PersonController@editPerson')->name('edit_person_post');

    Route::post('/delete-person', 'PersonController@deletePerson')->name('delete_person_post');

    Route::get('/test-alert', 'TestAlertController@index')->name('test_alert_view');
    Route::post('/test-alert', 'TestAlertController@testAlert')->name('test_alert_post');
});