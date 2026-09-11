<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\CommonDataCollectController;
use App\Http\Controllers\Api\allDetailsController;
use App\Models\User;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    abort_unless($request->user()?->tokenCan('user:read'), 403, 'Forbidden.');

    return response()->json([
        'name' => $request->user()->name,
        'email' => $request->user()->email,
    ]);
});

Route::middleware(['throttle:api-register'])->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('usercreate', [UserController::class, 'register']);
});

Route::middleware(['throttle:api-login'])->post('login', [UserController::class, 'loginUser']);

// Route::post('updateLocation', [CommonDataCollectController::class, 'updateLocation'])->middleware('auth:sanctum');
//Route::apiREsource('post',CollectorController::class)->middleware('auth:sanctum');
// Route::post('store', [DataController::class, 'store'])->middleware('auth:sanctum');
Route::get('/all-details', [allDetailsController::class, 'index']);



Route::get('/pest-data', function (Request $request) {

    $user = User::all();

    return response()->json($user);
});
