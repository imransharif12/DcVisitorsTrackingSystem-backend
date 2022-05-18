<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\TabController;
use App\Http\Controllers\Api\AdminController;


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
Route::prefix('user')->group(function () {
Route::post('register', [AuthController::class, 'register']);
Route::post('saverecord', [TabController::class, 'saveRecord']);
Route::post('get_record', [TabController::class, 'getRecord']);
Route::post('get_record', [TabController::class, 'getRecord']);
Route::post('get_detail', [TabController::class, 'companyDetail']);
Route::post('change_status', [TabController::class, 'changeStatus']);
Route::post('admins', [AdminController::class, 'index']);
Route::post('admin-register', [AdminController::class, 'index']);
});

Route::prefix('admin')->group(function () {
Route::post('index', [AdminController::class, 'index']);
Route::post('register', [AdminController::class, 'register']);
Route::post('login', [AdminController::class, 'login']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
