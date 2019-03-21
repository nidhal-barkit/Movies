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

    Route::group(['middleware' => 'is.admin'], function () {
        Route::resource('/users', 'UserController');

        Route::get('/excel', 'PhpSpreedSheetController@export')->name('export');
        Route::post('/import', 'PhpSpreedSheetController@import')->name('import');


        Route::get('/excelonesheet', 'OneSheetController@export')->name('excelonesheet');
        Route::post('/importonesheet', 'OneSheetController@import')->name('importonesheet');
    });

    Route::group(['middleware' => 'is.user'], function () {
        Route::resource('/mymovies', 'MyMovieController');
    });

    Route::resource('/movies', 'MovieController');
    //Route::post('/import', 'ExcelController@import')->name('import');
});


Route::get('Usermovies/{user_id}', 'Api\v1\ApiMovieController@getUserMovies')->name('usermovies');
Route::get('/', 'WelcomeController@index')->name('welcome');
Auth::routes();

