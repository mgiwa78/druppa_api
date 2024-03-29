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
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CouponRecordsController;
use App\Http\Controllers\InventoryDeliveryRequestController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RetainershipController;
use App\Http\Controllers\RetainershipInstanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorItemCategoryController;
use App\Http\Controllers\VendorItemController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransactionsController;
use App\Models\CustomerOrder;
use App\Models\Payment;
use App\Models\VendorItemCategory;
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
Route::get('/test', [AdminController::class, 'test']);

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
        // Customer Request For Inventory
        Route::post('/{id}/request-inventory', [CustomerController::class, 'requestInventory']);
        Route::get('/inventory/inventory-request', [CustomerController::class, 'getInventoryRequests']);
    });

    /*
        |--------------------------------------------------------------------------
        | Vendor Routes
        |--------------------------------------------------------------------------
        */

    Route::group(['prefix' => 'vendors'], function () {
        Route::get('/', [VendorController::class, 'index']);
        Route::post('/', [VendorController::class, 'store']);
        Route::put('/{id}', [VendorController::class, 'edit']);
    });
    /*
        |--------------------------------------------------------------------------
        | VendorItemCategories Routes
        |--------------------------------------------------------------------------
        */

    Route::group(['prefix' => 'vendorItemCategories'], function () {
        Route::get('/', [VendorItemCategoryController::class, 'index']);
    });
    /*
        |--------------------------------------------------------------------------
        | VendorItem Routes
        |--------------------------------------------------------------------------
        */

    Route::group(['prefix' => 'vendorItem'], function () {
        Route::post('/', [VendorItemController::class, 'store']);
        Route::get('/', [VendorItemController::class, 'index']);
        Route::put('/', [VendorItemController::class, 'update']);
    });

    /*
        |--------------------------------------------------------------------------
        | inventoryDeliveryRequest Routes
        |--------------------------------------------------------------------------
        */

    Route::group(['prefix' => 'inventoryDeliveryRequest'], function () {
        Route::get('/', [InventoryDeliveryRequestController::class, 'index']);
        Route::get('/confirmQuantity/{inventory_id}', [InventoryDeliveryRequestController::class, 'confirmQuantity']);
        Route::get('/{id}', [InventoryDeliveryRequestController::class, 'show']);
        Route::put('/{id}', [InventoryDeliveryRequestController::class, 'edit']);
        Route::post('/', [InventoryDeliveryRequestController::class, 'store']);
        Route::post('/approveRequest', [InventoryDeliveryRequestController::class, 'deliveryRequestApproval']);
        Route::delete('/{id}', [InventoryDeliveryRequestController::class, 'destroy']);
    });

    /*
       |--------------------------------------------------------------------------
       | Wallet Routes
       |--------------------------------------------------------------------------
       */

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/{id}', [WalletController::class, 'balance']);
        Route::post('/withdraw', [WalletController::class, 'withdraw']);
        Route::post('/deposit', [WalletController::class, 'deposit']);
    });
    /*
       |--------------------------------------------------------------------------
       | WalletTransactions Routes
       |--------------------------------------------------------------------------
       */

    Route::group(['prefix' => 'walletTransactions'], function () {
        Route::get('/myCummulativeTransactions', [WalletTransactionsController::class, 'myCummulativeTransactions']);
        Route::get('/', [WalletTransactionsController::class, 'index']);
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
    | Invoice Routes
    |--------------------------------------------------------------------------
        */

    Route::group([
        'prefix' => 'retainerships'
    ], function () {
        Route::get('', [RetainershipController::class, 'index']);
        Route::post('', [RetainershipController::class, 'create']);
        Route::get('/{id}', [RetainershipController::class, 'show']);
        Route::get('/{id}/confirm-exceeded-orders', [RetainershipController::class, 'confirmExceededOrders']);
        Route::get('/{customer_id}/instances', [RetainershipInstanceController::class, 'getInstancesByCustomer']);
        Route::get('/{retainership_id}/instances', [RetainershipInstanceController::class, 'getInstancesByRetainership']);
        Route::post('/{retainership_id}/instances', [RetainershipInstanceController::class, 'createInstance']);

    });

    /*
    |--------------------------------------------------------------------------
    | Misc Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/driverStatics', [DriverController::class, 'getDriverStatics']);
    Route::get('/vendorStatics', [VendorController::class, 'getVendorStatics']);
    Route::get('/adminStatics', [AdminController::class, 'getAdminStatics']);
    Route::get('/fetchDriverDeliveries', [DeliveryController::class, 'getDriverDeliveries']);
    Route::get('/getPendingOrders/{size}', [CustomerOrderController::class, 'showPendingOrders']);
    Route::post('/stateUpdate', [DriverController::class, 'stateUpdate']);

    /*
        |--------------------------------------------------------------------------
        | Resturant Routes
        |--------------------------------------------------------------------------
        */

    Route::group(['prefix' => 'restaurants'], function () {
        // Restaurants
        Route::get('/', [RestaurantController::class, 'index']);
        Route::post('/', [RestaurantController::class, 'store']);
        Route::get('/{restaurant}', [RestaurantController::class, 'show']);
        Route::put('/{restaurant}', [RestaurantController::class, 'update']);
        Route::delete('/{restaurant}', [RestaurantController::class, 'destroy']);

        // Categories
        Route::get('/{restaurant}/categories', [CategoryController::class, 'index']);
        Route::post('/{restaurant}/categories', [CategoryController::class, 'store']);
        Route::get('/{restaurant}/categories/{category}', [CategoryController::class, 'show']);
        Route::put('/{restaurant}/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/{restaurant}/categories/{category}', [CategoryController::class, 'destroy']);

        // Category Products
        Route::get('/{restaurant}/categories/{category}/products', [CategoryProductController::class, 'index']);
        Route::post('/{restaurant}/categories/{category}/products', [CategoryProductController::class, 'store']);
        Route::get('/{restaurant}/categories/{category}/products/{product}', [CategoryProductController::class, 'show']);
        Route::put('/{restaurant}/categories/{category}/products/{product}', [CategoryProductController::class, 'update']);
        Route::delete('/{restaurant}/categories/{category}/products/{product}', [CategoryProductController::class, 'destroy']);
    });

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

        // Routes for Delivery Requests
        Route::post('/{id}/request-delivery', [InventoryController::class, 'requestDelivery']);
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
        Route::get('/vendor/orders', [CustomerOrderController::class, 'showVendorOrders']);
        Route::post('/resturant', [CustomerOrderController::class, 'createResturantOrder']);
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
        Route::post('/create/new', [CouponController::class, 'store']);
        Route::get('/', [CouponController::class, 'index']);
        Route::post('/verify', [CouponController::class, 'validateCoupon']);
        Route::get('/{id}', [CouponController::class, 'show']);
        Route::get('/customers/{couponId}', [CouponController::class, 'getCouponCustomers']);
        Route::put('/{id}', [CouponController::class, 'update']);
        Route::delete('/{id}', [CouponController::class, 'destroy']);
        Route::post('/{coupon_id}/assign/{customer_id}', [CouponController::class, 'assignToCustomer']);
    });

    /*
        |--------------------------------------------------------------------------
        | Coupon Routes
        |--------------------------------------------------------------------------
        */

    Route::group(['prefix' => 'coupon'], function () {
        Route::post('/', [CouponRecordsController::class, 'create']);

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