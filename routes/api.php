<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('movies')->group(function() {
    Route::get('/frontend-start/{channel}/{per_page}', 'MovieController@frontendStart');
    Route::get('/frontend-page/{channel}/{offset}/{per_page}', 'MovieController@frontendPage');
    Route::get('/search-channel-year/{channel}/{year}', 'MovieController@frontendSearchYear');
    Route::get('/search-channel-time/{channel}/{start}/{end}', 'MovieController@frontendSearchTime');
    Route::get('/search-channel-rating/{channel}/{rating}', 'MovieController@frontendSearchRating');
    Route::get('/search-channel-category/{channel}/{category}', 'MovieController@frontendSearchCategory');

    Route::get('/admin', 'MovieController@adminStart');
    Route::get('/admin/{letter}', 'MovieController@adminLetter');

    Route::get('/producers/{id}', 'MovieController@producers');
    Route::get('/cast/{id}', 'MovieController@cast');
    Route::get('/titles/{channel}', 'MovieController@channelTitles');
    Route::get('/media/{id}', 'MovieController@media');
    Route::get('/category/{category}', 'MovieController@category');
    Route::get('/year/{year}', 'MovieController@year');
    Route::get('/time/{start}/{end}', 'MovieController@time');
});

Route::prefix('series')->group(function() {
    Route::get('/frontend-start/{channel}/{per_page}', 'SeriesController@frontendStart');
    Route::get('/frontend-page/{channel}/{offset}/{per_page}', 'SeriesController@frontendPage');
    Route::get('/search-channel-year/{channel}/{year}', 'SeriesController@frontendSearchYear');
    Route::get('/search-channel-rating/{channel}/{rating}', 'SeriesController@frontendSearchRating');
    Route::get('/search-channel-category/{channel}/{category}', 'SeriesController@frontendSearchCategory');

    Route::get('/producers/{id}', 'SeriesController@producers');
    Route::get('/cast/{id}', 'SeriesController@cast');
    Route::get('/titles/{channel}', 'SeriesController@channelTitles');
    Route::get('/media/{id}', 'SeriesController@media');
    Route::get('/year/{year}', 'SeriesController@year');
    Route::get('/time/{start}/{end}', 'MovieController@time');
});

Route::prefix('media')->group(function() {
    Route::get('/', 'Qualifiers\MediaController@index');
});

Route::prefix('categories')->group(function() {
    Route::get('/', 'Qualifiers\CategoryController@index');
});
