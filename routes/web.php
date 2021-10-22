<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\twitter\TwitterAuthController;
use App\Http\Controllers\twitter\TwitterController;
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

Route::fallback([HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'create'])->name('register');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/twitter')->group(function () {
        Route::get('/', [TwitterController::class, 'index'])->name('twitter_index');

        Route::get('/authenticate', [TwitterAuthController::class, 'authenticate'])->name('twitter_authenticate');
        Route::get('/saveCredentials', [TwitterAuthController::class, 'saveCredentials'])->name('twitter_saveCredentials');
    });
});
