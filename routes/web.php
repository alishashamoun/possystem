<?php
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryHistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomerPurchaseHistoryController;
use App\Http\Controllers\LoyaltyProgramController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BarcodeController;
use App\Models\Transaction;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Product Management Routes
    Route::prefix('admin/products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/barcode', [ProductController::class, 'generateBarcode'])->name('barcode');
        Route::get('/products/search', [ProductController::class, 'searchProducts'])->name('products.search');
    });


    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/store', [TagController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [TagController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [TagController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/store', [InventoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [InventoryController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [InventoryHistoryController::class, 'destroy'])->name('destroy');

        Route::post('stock-in/{id}', [InventoryController::class, 'stockIn']);
        Route::post('stock-out/{id}', [InventoryController::class, 'stockOut']);

        Route::get('/report', [InventoryHistoryController::class, 'inventoryReport'])->name('report');
        // Route::get('/check-stock-levels', [InventoryController::class, 'checkStockLevels'])->name('checkStockLevels');
    });

    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/store', [SalesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SalesController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SalesController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [SalesController::class, 'destroy'])->name('destroy');
        Route::get('/history', [SalesHistoryController::class, 'index'])->name('history');
        Route::get('/print-receipt/{id}', [ReceiptController::class, 'printReceipt'])->name('print-receipt');
    });

    Route::resource('admin/users', UserController::class);
    Route::resource('admin/suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');

});

Route::middleware(['auth', 'role:cashier|admin'])->group(function () {
    Route::get('/cashier/order/', [CashierController::class, 'index'])->name('cashier.index');
    Route::get('/payment-form', [CashierController::class, 'showPaymentForm'])->name('cashier.showPaymentForm');
    Route::post('/process-payment', [CashierController::class, 'processPayment'])->name('cashier.processPayment');
    Route::get('/receipt', [CashierController::class, 'receipt'])->name('customer.receipt');

    Route::prefix('sales')->name('sales.')->group(function () {
        // Sales routes
        Route::get('/', [SalesController::class, 'index'])->name('index');
        Route::get('/create', [SalesController::class, 'create'])->name('create');
        Route::post('/store', [SalesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SalesController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SalesController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [SalesController::class, 'destroy'])->name('destroy');
        Route::get('/showsales', [SalesController::class, 'showSale'])->name('show');
        Route::get('/history', [SalesHistoryController::class, 'index'])->name('history');
        Route::get('/print-receipt/{id}', [TransactionController::class, 'printReceipt'])->name('transactions.print-receipt');
    });
});

Route::middleware(['auth', 'role:'])->group(function () {
    Route::get('/inventory-staff/dashboard', [InventoryController::class, 'index'])->name('inventory.dashboard');

});

Route::middleware(['auth', 'role:customer|admin|cashier'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    // Customer Management Routes
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [AdminCustomerController::class, 'index'])->name('index');
        Route::get('/create', [AdminCustomerController::class, 'create'])->name('create');
        Route::post('/store', [AdminCustomerController::class, 'store'])->name('store');
        Route::get('/{id}/show', [AdminCustomerController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminCustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [AdminCustomerController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [AdminCustomerController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/add-loyalty-points', [AdminCustomerController::class, 'addLoyaltyPoints'])->name('add-loyalty-points');
        Route::get('customer/purchases', [PurchaseController::class, 'index'])->name('customer.purchases.index');
    });

    Route::resource('admin/users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/cashier/order', [CashierController::class, 'index'])->name('cashier.index');

});

require __DIR__ . '/auth.php';
Route::get('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('pos.logout');

