<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['prefix'=>'users','as'=>'users.'], function(){
    Route::get('download-users-csv', 'UsersController@users_download')->name('download-csv');
    Route::post('set-admin','UsersController@setAdmin')->name('set-admin');
    Route::post('test-broadcast','UsersController@testBroadcast')->name('test-broadcast');
    Route::post('remove-admin','UsersController@removeAdmin')->name('remove-admin');
});

Route::resource('/users','UsersController');
Route::resource('/event-types','EventTypesController');
Route::resource('/foods','FoodsController');

Route::group(['prefix'=>'foods','as'=>'foods.'], function(){
    Route::get('{food}/ingredients/create','FoodsController@ingredients_create')->name('ingredients.create');
    Route::delete('{food}/ingredients/{ingredient}','FoodsController@ingredient_destroy')->name('ingredients.destroy');
    Route::post('{food}/ingredients','FoodsController@ingredients_store')->name('ingredients.store');
    Route::get('{food}/steps/create','FoodsController@steps_create')->name('steps.create');
    Route::delete('{food}/steps/{step}','FoodsController@step_destroy')->name('steps.destroy');
    Route::post('{food}/steps','FoodsController@steps_store')->name('steps.store');
    Route::patch('{food}/steps/{step}','FoodsController@step_update')->name('steps.update');
    Route::get('{food}/steps/{step}/edit','FoodsController@step_edit')->name('steps.edit');
});

Route::resource('/drinks','DrinksController');

Route::group(['prefix'=>'drinks','as'=>'drinks.'], function(){
    Route::get('{drink}/ingredients/create','DrinksController@ingredients_create')->name('ingredients.create');
    Route::delete('{drink}/ingredients/{ingredient}','DrinksController@ingredient_destroy')->name('ingredients.destroy');
    Route::post('{drink}/ingredients','DrinksController@ingredients_store')->name('ingredients.store');
    Route::get('{drink}/steps/create','DrinksController@steps_create')->name('steps.create');
    Route::delete('{drink}/steps/{step}','DrinksController@step_destroy')->name('steps.destroy');
    Route::post('{drink}/steps','DrinksController@steps_store')->name('steps.store');
    Route::patch('{drink}/steps/{step}','DrinksController@steps_update')->name('steps.update');
    Route::get('{drink}/steps/{step}/edit','DrinksController@steps_edit')->name('steps.edit');
});

Route::resource('/questions','QuizQuestionsController');

Route::post('/quiz/web-hook','HomeController@quiz_hook');
Route::get('/', 'AdminController@index')->name('admin-home');
Route::get('/guest', 'HomeController@guests')->name('guest')->middleware('auth');
Route::get('/test','HomeController@test');
Route::get('/email-template','HomeController@email_template');
Route::get('/email-send','HomeController@email_send');
Route::get('/api/alexa/english','API\DrinksAndFoodsController@alexa_english');
Route::get('/api/alexa/spanish','API\DrinksAndFoodsController@alexa_spanish');
Route::get('/api/alexa/german','API\DrinksAndFoodsController@alexa_german');

Auth::routes();
