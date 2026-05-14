<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\PageController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Front routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/products', [PageController::class, 'products'])->name('products.index');
Route::get('/products/{id}', [PageController::class, 'productDetail'])->name('products.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/place-order', [CartController::class, 'storeOrder'])->name('checkout.place-order');
Route::get('/sitemap.xml', function () {
    $products = Product::where('is_active', true)->latest('updated_at')->get(['id', 'updated_at']);
    return response()->view('front.sitemap', ['products' => $products])
        ->header('Content-Type', 'application/xml');
});

// Admin auth (public)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Admin protected routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index','show','destroy']);
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
