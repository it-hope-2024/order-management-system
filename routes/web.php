<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;






Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    // Route::get('/', function () {
  
    //     $locale = LaravelLocalization::getCurrentLocale();
   
    //     return redirect(LaravelLocalization::getLocalizedURL($locale, 'products'));
    // })->name('home');
    // Route::get('', fn() => to_route('products.index'))->name('home');
    Route::get('', fn() => redirect(LaravelLocalization::getLocalizedURL(app()->getLocale(), 'products')))->name('home');
    // Route::get('', fn() => redirect(LaravelLocalization::getLocalizedURL(app()->getLocale(), 'products.index')))->name('home');


    Route::get('/products/list', [ProductController::class, 'getProducts'])->name('products.list');
Route::resource('products', ProductController::class);
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
    Route::get('/admin/dashboard', function () {
        // return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
