<?php

declare(strict_types=1);

use Scriptura\Markov\Chain;
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

Route::get('/{dictionaryName?}', function ($dictionaryName = null) {
    $files = File::allFiles(resource_path('dictionaries'));
    $dictionaries = [];

    foreach ($files as $dictionary) {
        $dictionaries[$dictionary->getFilename()] = new \App\Markov\Dictionary($dictionary->getRealPath());
    }

    $dictionary = $dictionaries[$dictionaryName] ?? \Illuminate\Support\Arr::first($dictionaries);

    $generator = new \App\Markov\Generator($dictionary->lines(), 3);

    $title = $dictionary->title();

    return view('welcome', [
        'title' => $title,
        'dictionaries' => $dictionaries,
        'generator' => $generator,
    ]);
})->name('index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
