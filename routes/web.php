<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->middleware('auth')->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->middleware('auth')->name('cart.index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->middleware('auth')->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->middleware('auth')->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::post('/order/place', [OrderController::class, 'place'])->middleware('auth')->name('order.place');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.update_status');
    
    // Products management
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::patch('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::post('/products/{id}/restore', [AdminController::class, 'restoreProduct'])->name('admin.products.restore');

    // Promos
    Route::get('/promos', [AdminController::class, 'promos'])->name('admin.promos');
    Route::get('/promos/create', [AdminController::class, 'createPromo'])->name('admin.promos.create');
    Route::post('/promos', [AdminController::class, 'storePromo'])->name('admin.promos.store');
    Route::get('/promos/{id}/edit', [AdminController::class, 'editPromo'])->name('admin.promos.edit');
    Route::patch('/promos/{id}', [AdminController::class, 'updatePromo'])->name('admin.promos.update');
    Route::delete('/promos/{id}', [AdminController::class, 'destroyPromo'])->name('admin.promos.destroy');

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    
    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/check/{product}', [WishlistController::class, 'isInWishlist'])->name('wishlist.check');
    
    // Review routes
    Route::post('/review/{product}', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::get('/review/{product}', [ReviewController::class, 'getProductReviews'])->name('review.get');
    
    // Payment page (after order placed)
    Route::get('/payment/{order}', [PaymentController::class, 'page'])->name('payment.page');
});

require __DIR__.'/auth.php';

// Notification endpoint (Midtrans server-to-server)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
