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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RetainershipCustomerController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Models\CustomerOrder;
use App\Models\Payment;
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
        Route::put('/{id}', [CustomerController::class, 'updateCustomerProfile']);
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
        Route::patch('driver/assignDelivery/{id}', [DeliveryController::class, 'assignOrderToDriver']);
        Route::get('driver/getDriverOngoingDeliveries', [DeliveryController::class, 'getDriverOngoingDeliveries']);
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
        Route::post('/', [InvoiceController::class, 'CreateInvoice']);
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
    | Warehousing Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'warehouses'], function () {
        Route::get('/', [WarehouseController::class, 'index']);
        Route::post('/', [WarehouseController::class, 'store']);
        Route::get('/{id}', [WarehouseController::class, 'show']);
        Route::put('/{id}', [WarehouseController::class, 'update']);
        Route::delete('/{id}', [WarehouseController::class, 'destroy']);

        Route::post('/{warehouseId}/request-warehousing', [WarehouseController::class, 'requestWarehousing']);
        Route::post('/{warehouseId}/send-products-for-warehousing', [WarehouseController::class, 'sendProductsForWarehousing']);
        Route::post('/products/{productId}/request-delivery', [WarehouseController::class, 'requestDelivery']);
        Route::get('/customers/{customerId}/track-records', [WarehouseController::class, 'trackRecords']);
    });

    /*
    |--------------------------------------------------------------------------
    | CustomerOrder Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'customerorders'], function () {
        Route::get('/', [CustomerOrderController::class, 'index']);
        Route::get('/{id}', [CustomerOrderController::class, 'show']);
        Route::post('/', [CustomerOrderController::class, 'create']);
        Route::get('/customer/{id}', [CustomerOrderController::class, 'showCustomerOrder']);
        Route::get('all/customer/{size}', [CustomerOrderController::class, 'showCustomersOrders']);
    });

    /*
    |--------------------------------------------------------------------------
    | Retainership Customers Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'retainership-customers'], function () {
        Route::get('/', [RetainershipCustomerController::class, 'index']);
        Route::get('/{id}', [RetainershipCustomerController::class, 'show']);
        Route::post('/', [RetainershipCustomerController::class, 'store']);
        Route::put('/{id}', [RetainershipCustomerController::class, 'update']);
        Route::delete('/{id}', [RetainershipCustomerController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Cupon Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'coupon'], function () {
        Route::post('/', [CouponController::class, 'store']);
        Route::get('/', [CouponController::class, 'index']);
        Route::get('/{id}', [CouponController::class, 'show']);
        Route::put('/{id}', [CouponController::class, 'update']);
        Route::delete('/{id}', [CouponController::class, 'destroy']);
        Route::post('/{coupon_id}/assign/{customer_id}', [CouponController::class, 'assignToCustomer']);
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
        Route::put('/', [AdminController::class, 'edit']);
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
        Route::post('verify/pickup', [DriverController::class, 'verifyPickup']);
        Route::post('verify/dropoff', [DriverController::class, 'verifyDropOff']);
    });

    /*
    |--------------------------------------------------------------------------
    | Activity Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'activity'], function () {
        Route::get('/', [ActivityLogController::class, 'getUserActivityLog']);
        Route::get('/all', [ActivityLogController::class, 'getAllActivityLog']);
    });
    /*
    |--------------------------------------------------------------------------
    | Payments Routes
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'payment'], function () {
        Route::post('/', [PaymentController::class, 'store']);
    });
});
