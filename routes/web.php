<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\DrinksAndFoodsController;
use App\Http\Controllers\DrinksController;
use App\Http\Controllers\EventTypesController;
use App\Http\Controllers\FoodsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizQuestionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::get('download-users-csv', [UsersController::class, 'users_download'])->name('download-csv');
    Route::post('set-admin', [UsersController::class, 'setAdmin'])->name('set-admin');
    Route::post('test-broadcast', [UsersController::class, 'testBroadcast'])->name('test-broadcast');
    Route::post('remove-admin', [UsersController::class, 'removeAdmin'])->name('remove-admin');
});

Route::resource('/users', UsersController::class);
Route::resource('/event-types', EventTypesController::class);
Route::resource('/foods', FoodsController::class);

Route::group(['prefix' => 'foods', 'as' => 'foods.'], function(){
    Route::get('{food}/ingredients/create', [FoodsController::class, 'ingredients_create'])->name('ingredients.create');
    Route::delete('{food}/ingredients/{ingredient}', [FoodsController::class, 'ingredient_destroy'])->name('ingredients.destroy');
    Route::post('{food}/ingredients', [FoodsController::class, 'ingredients_store'])->name('ingredients.store');
    Route::get('{food}/steps/create', [FoodsController::class, 'steps_create'])->name('steps.create');
    Route::delete('{food}/steps/{step}', [FoodsController::class, 'step_destroy'])->name('steps.destroy');
    Route::post('{food}/steps', [FoodsController::class, 'steps_store'])->name('steps.store');
    Route::patch('{food}/steps/{step}', [FoodsController::class, 'step_update'])->name('steps.update');
    Route::get('{food}/steps/{step}/edit', [FoodsController::class, 'step_edit'])->name('steps.edit');
});

Route::resource('/drinks',DrinksController::class);

Route::group(['prefix' => 'drinks', 'as' => 'drinks.'], function(){
    Route::get('{drink}/ingredients/create', [DrinksController::class, 'ingredients_create'])->name('ingredients.create');
    Route::delete('{drink}/ingredients/{ingredient}', [DrinksController::class, 'ingredient_destroy'])->name('ingredients.destroy');
    Route::post('{drink}/ingredients', [DrinksController::class, 'ingredients_store'])->name('ingredients.store');
    Route::get('{drink}/steps/create', [DrinksController::class, 'steps_create'])->name('steps.create');
    Route::delete('{drink}/steps/{step}', [DrinksController::class, 'step_destroy'])->name('steps.destroy');
    Route::post('{drink}/steps', [DrinksController::class, 'steps_store'])->name('steps.store');
    Route::patch('{drink}/steps/{step}', [DrinksController::class, 'steps_update'])->name('steps.update');
    Route::get('{drink}/steps/{step}/edit', [DrinksController::class, 'steps_edit'])->name('steps.edit');
});

Route::resource('/questions', QuizQuestionsController::class);

Route::get('/', [AdminController::class, 'index'])->name('admin-home');
Route::post('/quiz/web-hook', [HomeController::class, 'quiz_hook']);
Route::get('/guest', [HomeController::class, 'guests'])->name('guest')->middleware('auth');
Route::get('/test', [HomeController::class, 'test']);
Route::get('/email-template', [HomeController::class, 'email_template']);
Route::get('/email-send', [HomeController::class, 'email_send']);
Route::get('/api/alexa/english', [DrinksAndFoodsController::class, 'alexa_english']);
Route::get('/api/alexa/spanish', [DrinksAndFoodsController::class, 'alexa_spanish']);
Route::get('/api/alexa/german', [DrinksAndFoodsController::class, 'alexa_german']);

Auth::routes();
