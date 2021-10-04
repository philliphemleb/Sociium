<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Route;

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

/*  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authentication Protected
Route::group(['middleware' => ['auth:sanctum']], function ()
{
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('/twitter')->group(function ()
{
    Route::get('/authenticate', [TwitterController::class, 'authenticate']);
    Route::get('/saveCredentials', [TwitterController::class, 'saveCredentials']);
});
