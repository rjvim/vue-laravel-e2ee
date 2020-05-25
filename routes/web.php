<?php

use Illuminate\Support\Facades\Route;


use Virgil\CryptoImpl\VirgilCardCrypto;
use Virgil\CryptoImpl\VirgilCrypto;
use Virgil\Sdk\CardManager;
use Virgil\Sdk\Web\Authorization\CallbackJwtProvider;
use Virgil\Sdk\Web\Authorization\TokenContext;

use Virgil\Sdk\Verification\VerifierCredentials;
use Virgil\Sdk\Verification\VirgilCardVerifier;
use Virgil\Sdk\Verification\Whitelist;
use Virgil\CryptoImpl\VirgilAccessTokenSigner;
use App\Helpers\JWTGenerator;

// "AT.bCah4Y6dOkZ9iKKpXLk9IwayoftMEwN9"

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
    $authenticatedQueryToServerSide = function (TokenContext $context) {
        $JWTGenerator = new JWTGenerator();

        return $JWTGenerator->generate('rajiv@betalectic.com');

        // Get generated token from server-side
        return "eyJraWQiOiI3MGI0NDdlMzIxZjNhMGZkIiwidHlwIjoiSldUIiwiYWxnIjoiVkVEUzUxMiIsImN0eSI6InZpcmdpbC1qd3Q7dj0xIn0.eyJleHAiOjE1MTg2OTg5MTcsImlzcyI6InZpcmdpbC1iZTAwZTEwZTRlMWY0YmY1OGY5YjRkYzg1ZDc5Yzc3YSIsInN1YiI6ImlkZW50aXR5LUFsaWNlIiwiaWF0IjoxNTE4NjEyNTE3fQ.MFEwDQYJYIZIAWUDBAIDBQAEQP4Yo3yjmt8WWJ5mqs3Yrqc_VzG6nBtrW2KIjP-kxiIJL_7Wv0pqty7PDbDoGhkX8CJa6UOdyn3rBWRvMK7p7Ak";
    };

    // Setup AccessTokenProvider
    $accessTokenProvider = new CallbackJwtProvider($authenticatedQueryToServerSide);

    // initialize Crypto library
    $cardCrypto = new VirgilCardCrypto();
    $accessTokenSigner = new VirgilAccessTokenSigner();


    $privateKeyStr = env('VIRGIL_KEY');
    $apiKeyData = base64_decode($privateKeyStr);

    // Crypto library imports a private key into a necessary format
    $crypto = new VirgilCrypto();
    $privateKey = $crypto->importPrivateKey($apiKeyData);

    $virgilCardVerifier = new VirgilCardVerifier($cardCrypto, true, true);

    $cardManager = new CardManager($cardCrypto, $accessTokenProvider, $virgilCardVerifier);


    $cards = $cardManager->searchCards('');

    dd($cards);
    
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
