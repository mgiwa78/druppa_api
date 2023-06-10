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

Route::get('fetchCustomerProfile/{id}', [CustomerController::class, 'fetchProfile']);
Route::post('/customer/updateProfile', [CustomerController::class, 'updateProfile']);
Route::get('/fetchCustomerProfiles', [CustomerController::class, 'fetchCustomerProfiles']);



Route::get('/fetchAdminProfiles/{size}', [AdminController::class, 'fetchAdminProfiles']);
Route::post('/createAdminProfile', [AdminController::class, 'create']);
Route::get('/fetchAdminProfile/{id}', [AdminController::class, 'show']);
Route::post('/EditAdminProfile/{id}', [AdminController::class, 'edit']);