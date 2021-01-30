<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('movies')->group(function() {
    Route::get('/frontend-start/{channel}/{per_page}', 'MovieController@frontendStart');
    Route::get('/frontend-page/{channel}/{offset}/{per_page}', 'MovieController@frontendPage');
    Route::get('/frontend-year/{channel}/{year}', 'MovieController@frontendSearchYear');
    Route::get('/frontend-time/{channel}/{start}/{end}', 'MovieController@frontendSearchTime');
    Route::get('/frontend-rating/{channel}/{rating}', 'MovieController@frontendSearchRating');
    Route::get('/frontend-category/{channel}/{category}', 'MovieController@frontendSearchCategory');

    Route::get('/admin', 'MovieController@adminStart');
    Route::get('/admin/{letter}', 'MovieController@adminLetter');

    Route::get('/producers/{id}', 'MovieController@producers');
    Route::get('/cast/{id}', 'MovieController@cast');
    Route::get('/media/{id}', 'MovieController@media');
    Route::get('/category/{category}', 'MovieController@category');
    Route::get('/year/{year}', 'MovieController@year');
    Route::get('/time/{start}/{end}', 'MovieController@time');
});

Route::prefix('series')->group(function() {
    Route::get('/frontend-start/{channel}/{per_page}', 'SeriesController@frontendStart');
    Route::get('/frontend-page/{channel}/{offset}/{per_page}', 'SeriesController@frontendPage');
    Route::get('/frontend-year/{channel}/{year}', 'SeriesController@frontendSearchYear');
    Route::get('/frontend-rating/{channel}/{rating}', 'SeriesController@frontendSearchRating');
    Route::get('/frontend-category/{channel}/{category}', 'SeriesController@frontendSearchCategory');

    Route::get('/admin', 'SeriesController@adminStart');
    Route::get('/admin/{letter}', 'SeriesController@adminLetter');

    Route::get('/producers/{id}', 'SeriesController@producers');
    Route::get('/cast/{id}', 'SeriesController@cast');
    Route::get('/media/{id}', 'SeriesController@media');
    Route::get('/year/{year}', 'SeriesController@year');
});

Route::prefix('media')->group(function() {
    Route::get('/', 'Qualifiers\MediaController@index');
});

Route::prefix('categories')->group(function() {
    Route::get('/', 'Qualifiers\CategoryController@index');
});
