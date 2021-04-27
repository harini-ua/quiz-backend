<?php

use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\ContactsController;
use App\Http\Controllers\API\DrinksAndFoodsController;
use App\Http\Controllers\API\EventsController;
use App\Http\Controllers\API\QuizController;
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

Route::group(['middleware' => 'CORS'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('register', [AuthenticationController::class, 'register']);
        Route::group(['middleware' => 'auth:api'], function() {
            Route::get('logout', [AuthenticationController::class, 'logout']);
            Route::get('user', [AuthenticationController::class, 'user']);
        });
        // FACEBOOK LOGIN
        Route::post('login/facebook', [AuthenticationController::class, 'login_facebook'])
            ->name('login-fb');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('set-language', [AuthenticationController::class, 'set_language']);
        Route::group(['prefix' => 'events'], function () {
            Route::get('types', [EventsController::class, 'types']);
        });
        Route::resource('/events', EventsController::class);
        Route::resource('/contacts', ContactsController::class);
        Route::post('/contacts/invite', [ContactsController::class, 'invite']);
        Route::post('/contacts/invited', [ContactsController::class, 'invited']);
        Route::post('/contacts/attending', [ContactsController::class, 'attending']);
        Route::post('/drinks', [DrinksAndFoodsController::class, 'drinks']);
        Route::post('/foods', [DrinksAndFoodsController::class, 'foods']);
        Route::post('/ingredients', [DrinksAndFoodsController::class, 'ingredients']);
        Route::post('/ingredients/missing', [DrinksAndFoodsController::class, 'missing_ingredients']);
        Route::post('/steps', [DrinksAndFoodsController::class, 'steps']);
        Route::group(['prefix' => 'quiz'], function () {
            Route::post('generate', [QuizController::class, 'generate_quiz']);
        });
    });

    Route::group(['prefix' => 'quiz'], function () {
        Route::post('join', [QuizController::class, 'join_quiz']);
        Route::post('presence', [QuizController::class, 'presence']);
        Route::post('question', [QuizController::class, 'unused_question']);
        Route::post('answer', [QuizController::class, 'answer_question']);
        Route::post('vote', [QuizController::class, 'answer_vote']);
        Route::post('winner', [QuizController::class, 'winner']);
        Route::post('change-host', [QuizController::class, 'change_host']);
        Route::post('player-left', [QuizController::class, 'player_left']);
    });

    Route::post('/whatsapp-code', [EventsController::class, 'whatsapp_code']);
    Route::post('/whatsapp-attending', [EventsController::class, 'whatsapp_attending']);

    Route::post('/email-code', [EventsController::class, 'email_code']);
    Route::post('/email-attending', [EventsController::class, 'email_attending']);
});
