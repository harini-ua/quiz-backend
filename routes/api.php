<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth','middleware'=>'CORS'], function () {
    Route::post('login', 'API\AuthenticationController@login')->name('login');
    Route::post('register', 'API\AuthenticationController@register');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\AuthenticationController@logout');

        Route::get('user', 'API\AuthenticationController@user');
    });
    // FACEBOOK LOGIN
    Route::post('login/facebook', 'API\AuthenticationController@login_facebook')->name('login-fb');
});

Route::group(['middleware' => ['auth:api','CORS'],'namespace'=>'API'], function() {
    Route::post('set-language','AuthenticationController@set_language');
    Route::group(['prefix' => 'events'], function () {
        Route::get('types','EventsController@types');
    });
    Route::resource('/events','EventsController');
    Route::resource('/contacts','ContactsController');
    Route::post('/contacts/invite','ContactsController@invite');
    Route::post('/contacts/invited','ContactsController@invited');
    Route::post('/contacts/attending','ContactsController@attending');
    Route::post('/drinks','DrinksAndFoodsController@drinks');
    Route::post('/foods','DrinksAndFoodsController@foods');
    Route::post('/ingredients','DrinksAndFoodsController@ingredients');
    Route::post('/ingredients/missing','DrinksAndFoodsController@missing_ingredients');
    Route::post('/steps','DrinksAndFoodsController@steps');
    Route::group(['prefix' => 'quiz'], function () {
        Route::post('generate','QuizController@generate_quiz');
    });
});

Route::group(['prefix' => 'quiz','middleware'=>'CORS','namespace'=>'API'], function () {
    Route::post('join','QuizController@join_quiz');
    Route::post('presence','QuizController@presence');
    Route::post('question','QuizController@unused_question');
    Route::post('answer','QuizController@answer_question');
    Route::post('vote','QuizController@answer_vote');
    Route::post('winner','QuizController@winner');
    Route::post('change-host','QuizController@change_host');
    Route::post('player-left','QuizController@player_left');
});

Route::group(['middleware'=>'CORS','namespace'=>'API'], function () {
    Route::post('/whatsapp-code','EventsController@whatsapp_code');
    Route::post('/whatsapp-attending','EventsController@whatsapp_attending');
});

Route::group(['middleware'=>'CORS','namespace'=>'API'], function () {
    Route::post('/email-code','EventsController@email_code');
    Route::post('/email-attending','EventsController@email_attending');
});
