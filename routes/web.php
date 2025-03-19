<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;






Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    // Route::get('/', function () {

    //     $locale = LaravelLocalization::getCurrentLocale();

    //     return redirect(LaravelLocalization::getLocalizedURL($locale, 'products'));
    // })->name('home');
    // Route::get('', fn() => to_route('products.index'))->name('home');
    Route::get('', fn() => redirect(LaravelLocalization::getLocalizedURL(app()->getLocale(), 'products')))->name('home');



    Route::get('/products/list', [ProductController::class, 'getProducts'])->name('products.list');
    Route::resource('products', ProductController::class);
    Route::middleware(['auth'])->group(function () {
        Route::post('/orders/add-to-cart/{product}', [OrderController::class, 'addToCart'])->name('orders.add-to-cart');
        Route::post('/orders/remove-item/{id}', [OrderController::class, 'removeItem'])->name('orders.remove-item');
        Route::post('/orders/decrease-item/{id}', [OrderController::class, 'decreaseItem'])->name('orders.decrease-item');
        Route::post('/orders/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
        Route::get('/orders/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders');
        Route::get('/orders/my-purchases', [OrderController::class, 'myPurchases'])->name('orders.my-purchases');
        Route::get('/orders/list', [OrderController::class, 'getOrders'])->name('orders.list');
        Route::resource('orders', OrderController::class);
        Route::resource('orderitems', OrderItemController::class);
    });
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/management', function () {
        return view('management.index', ['user' => Auth::user()]); 
    })->name('management');
});


Route::prefix('reports')->group(function () {
    Route::get('/orders-last-7-days', [ReportController::class, 'ordersLast7Days'])->name('reports.orders_last_7_days');
    Route::get('/product-sales-last-30-days', [ReportController::class, 'productSalesLast30Days'])->name('reports.product_sales_last_30_days');
    Route::get('/top-5-customers', [ReportController::class, 'top5Customers'])->name('reports.top_5_customers');
    Route::get('/orders-with-more-than-3-products', [ReportController::class, 'ordersWithMoreThan3Products'])->name('reports.orders_with_more_than_3_products');
    Route::get('/order-products-list', [ReportController::class, 'orderProductsList'])->name('reports.order_products_list');
});
require __DIR__ . '/auth.php';
