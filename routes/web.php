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

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/mymovies', 'MyMovieController');
    Route::resource('/movies', 'MovieController');
    Route::resource('/users', 'UserController');
    Route::get('/excel', 'ExcelController@export')->name('export');
});

Route::get('Usermovies/{user_id}', 'Api\v1\ApiMovieController@getUserMovies')->name('usermovies');
Route::get('/', 'WelcomeController@index')->name('welcome');
Auth::routes();

