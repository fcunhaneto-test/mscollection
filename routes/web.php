<?php

use App\Models\Qualifiers\Media;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return redirect('/filmes/netflix');
    return view('testes');
});

Route::get('/filmes/{channel}', function ($channel) {
    $table = 'movies';
    $subtitle = '';

    $ms = new Media();
    $media = $ms->isStreams();

    foreach ($media as $m) {
        if($m->slug == $channel) {
            $subtitle = $m->name;
        }
    }
    return view('titles', compact('subtitle', 'media', 'table'));
})->name('movies');

Route::get('/series/{channel}', function ($channel) {
    $table = 'series';
    $subtitle = '';

    $ms = new Media();
    $media = $ms->isStreams();

    foreach ($media as $m) {
        if($m->slug == $channel) {
            $subtitle = $m->name;
        }
    }
    return view('titles', compact('subtitle', 'media', 'table'));
})->name('series');


Route::get('/admin', function () {
    return redirect('/login');
})->name('admin');

Route::get('/admin/filmes', function () {
    return view('admin');
})->name('admin-movies');

Auth::routes();
