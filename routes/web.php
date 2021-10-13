<?php

use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/twitter')->group(function () {
    Route::get('/authenticate', [TwitterController::class, 'authenticate'])->name('twitter_authenticate');
    Route::get('/saveCredentials', [TwitterController::class, 'saveCredentials'])->name('twitter_saveCredentials');
});
