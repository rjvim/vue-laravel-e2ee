<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/virgil-token', function (Request $request) {
    $JWTGenerator = new App\Helpers\JWTGenerator();

    return $JWTGenerator->generate(request()->user()->email);
});

Route::post('update-user-keys', 'UserKeysController@update')->middleware('auth:api');
Route::post('share-note', 'ShareController@get')->middleware('auth:api');
Route::post('get-keys', 'ShareController@keys')->middleware('auth:api');

Route::resource('notes', 'NoteController')->middleware('auth:api');
