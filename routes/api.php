<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/salesforce-handler/opp-won', 'SalesforceController@oppWon')->name('opp_won_post');
Route::post('/salesforce-handler/opp-created', 'SalesforceController@oppWon')->name('opp_won_post');

Route::post('/prodpad-handler/prod-shipped', 'ProdpadController@prodShipped')->name('card_complete_post');

Route::post('/greenhouse-handler/candidate-hired', 'GreenhouseController@candHired')->name('card_complete_post');