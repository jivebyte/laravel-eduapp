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
    return view('home');
});

Route::get('/map/{cat_id}', 'MapController@map');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Categories
Route::resource('categories','CategorysController');

//Levels
Route::get('/levels/create/{id}','LevelsController@create');
Route::post('/levels/{id}','LevelsController@store');
Route::delete('levels/delete/{lid}/{lnum}/{cid}','LevelsController@destroy');
Route::get('levels/{id}','LevelsController@index');

//Questions
Route::get('/questions/{id}','QuestionsController@index');
Route::post('/questions','QuestionsController@display');
Route::post('/questions/{id}', 'QuestionsController@store');
Route::get('/questions/create/{id}','QuestionsController@create');
Route::get('/questions/{id}/edit','QuestionsController@edit');
Route::put('/questions/update/{id}','QuestionsController@update');
