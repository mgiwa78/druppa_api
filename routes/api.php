<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/customer/register', [AuthController::class, 'customerRegister']);
Route::post('/loginAdmin', [AuthController::class, 'loginAdmin']);


Route::group(['prefix' => 'customers'], function () {
    Route::get('/', [CustomerController::class, 'fetchCustomerProfiles']);
    Route::get('/{id}', [CustomerController::class, 'fetchProfile']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::put('/{id}', [CustomerController::class, 'updateCustomerProfile']);
    Route::delete('/{id}', [CustomerController::class, 'destroy']);
});



Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'fetchAdminProfiles']);
    Route::get('/{id}', [AdminController::class, 'show']);
    Route::post('/', [AdminController::class, 'create']);
    Route::put('/{id}', [AdminController::class, 'edit']);
    Route::delete('/{id}', [AdminController::class, 'destroy']);
});


