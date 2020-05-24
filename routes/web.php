<?php

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

Route::get('/', function () {
    // $extension = 'virgil_crypto_php';

    // $result = [
    //     'EXTENSION' => $extension,
    //     'IS_EXTENSION_LOADED' => extension_loaded($extension),
    //     'OS' => PHP_OS,
    //     'PHP' => PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION,
    //     'PATH_TO_EXTENSIONS_DIR' => PHP_EXTENSION_DIR,
    //     'PATH_TO_PHP.INI' => php_ini_loaded_file(),
    // ];


    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
