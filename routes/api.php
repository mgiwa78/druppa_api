<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Models\CustomerOrder;
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


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'customerRegister']);

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [CustomerController::class, 'fetchCustomerProfiles']);
        Route::get('/{id}', [CustomerController::class, 'fetchProfile']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::delete('/{id}', [CustomerController::class, 'destroy']);


        Route::get('count/getCount', [CustomerController::class, 'getCustomerCount']);
    });

    /*
    |--------------------------------------------------------------------------
    | Delivery Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'deliveries'], function () {
        Route::get('/', [DeliveryController::class, 'index']);
        Route::post('/', [DeliveryController::class, 'store']);
        Route::get('/{id}', [DeliveryController::class, 'show']);


        Route::patch('/{id}', [DeliveryController::class, 'update']);
        Route::delete('/{id}', [DeliveryController::class, 'destroy']);
        Route::get('customer/{id}', [DeliveryController::class, 'getCustomerDelivery']);

        Route::get('count/getCount', [DeliveryController::class, 'getDeliveryCount']);
    });


    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [AuthController::class, 'getProfile']);
        Route::post('/', [AuthController::class, 'updateProfile']);
        Route::post('/emailUpdate', [AuthController::class, 'updateEmail']);
        Route::post('/passwordUpdate', [AuthController::class, 'updatePassword']);

    });

    /*
|--------------------------------------------------------------------------
| Invoice Routes
|--------------------------------------------------------------------------
*/

    Route::group(['prefix' => 'invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::get('/customer/{size}', [InvoiceController::class, 'getCustomerInvoices']);


    });
    /*
|--------------------------------------------------------------------------
| Misc Routes
|--------------------------------------------------------------------------
*/

    Route::get('/driverStatics', [DriverController::class, 'getDriverStatics']);
    Route::get('/adminStatics', [AdminController::class, 'getAdminStatics']);
    Route::get('/fetchDriverDeliveries', [DeliveryController::class, 'getDriverDeliveries']);
    Route::get('/getPendingOrders/{size}', [CustomerOrderController::class, 'showPendingOrders']);
    Route::post('/stateUpdate', [DriverController::class, 'stateUpdate']);




    /*
    |--------------------------------------------------------------------------
    | Inventory Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', [InventoryController::class, 'index']);
        Route::post('/', [InventoryController::class, 'store']);
        Route::get('/{id}', [InventoryController::class, 'show']);

        Route::patch('/{id}', [InventoryController::class, 'update']);
        Route::delete('/{id}', [InventoryController::class, 'destroy']);
        Route::get('customer/{id}', [InventoryController::class, 'getCustomerInventory']);

        Route::get('count/getCount', [InventoryController::class, 'getInventoryCount']);
    });

    /*
    |--------------------------------------------------------------------------
    | CustomerOrder Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'customerorders'], function () {
        Route::get('/', [CustomerOrderController::class, 'index']);
        Route::get('/{id}', [CustomerOrderController::class, 'show']);
        Route::get('/customer/{id}', [CustomerOrderController::class, 'showCustomerOrder']);
    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'fetchAdminProfiles']);
        Route::get('/{id}', [AdminController::class, 'show']);
        Route::post('/', [AdminController::class, 'create']);
        Route::delete('/{id}', [AdminController::class, 'destroy']);
        Route::get('count/getCount', [AdminController::class, 'getAdminCount']);
    });

    /*
    |--------------------------------------------------------------------------
    | Driver Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'drivers'], function () {
        Route::get('/', [DriverController::class, 'fetchDriverProfiles']);
        Route::post('/', [DriverController::class, 'store']);
        Route::get('/{id}', [DriverController::class, 'show']);
        Route::post('/{id}', [DriverController::class, 'updateDriver']);
        Route::delete('/{id}', [DriverController::class, 'destroy']);
        Route::get('count/getCount', [DriverController::class, 'getDriverCount']);
    });

    /*
    |--------------------------------------------------------------------------
    | Driver Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'activity'], function () {
        Route::get('/', [ActivityLogController::class, 'getUserActivityLog']);
        Route::get('/all', [ActivityLogController::class, 'getAllActivityLog']);

    });
});