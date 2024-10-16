<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStaffController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\CheckRole;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Purchase;

// Route gốc
Route::get('/', [HomePageController::class, 'HomeIndex'])->name('home');
Route::get('/home/{id}/detail', [HomePageController::class, 'productdetail'])->name('home.products.detail');
Route::get('about', [HomePageController::class, 'About'])->name('about');
Route::get('contact', [HomePageController::class, 'Contact'])->name('contact');
Route::get('services', [HomePageController::class, 'Service'])->name('services');

// Route đăng nhập và đăng ký
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Route cho Orders
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('processPayment');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('payment/gateway/{order}', [CheckoutController::class, 'paymentGateway'])->name('payment.gateway');
});

Route::middleware(['auth', CheckRole::class . ':staff'])->group(function () {
    Route::get('/staff/orders', [OrderStaffController::class, 'index'])->name('staff.orders.index');
    Route::get('/staff/orders/{order}/edit', [OrderStaffController::class, 'edit'])->name('staff.orders.edit');
    Route::put('/staff/orders/{order}', [OrderStaffController::class, 'update'])->name('staff.orders.update');
    Route::get('/api/pending-orders-count', [OrderStaffController::class, 'getPendingOrdersCount']);
});

// Route cho Admin
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('admin/users/{user}', [AdminController::class, 'show'])->name('admin.users.show');
    Route::get('admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

// Route cho Manager
Route::middleware(['auth', CheckRole::class . ':manager'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::patch('purchases/{id}/update-status', [PurchaseController::class, 'updateStatus'])->name('purchases.updateStatus');
});

// Route cho Manager và Admin
Route::middleware(['auth', CheckRole::class . ':manager,admin'])->group(function () {
    Route::resource('products', ProductController::class)->except(['index']);
    Route::get('product-list', [ProductController::class, 'index'])->name('products.list');
});

Route::middleware(['auth', CheckRole::class . ':customer'])->group(function () {
    Route::get('customer/profile/edit', [CustomerController::class, 'editProfile'])->name('customer.profile.edit');
    Route::put('customer/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.updateProfile');
    Route::get('customer/profile', [CustomerController::class, 'showProfile'])->name('customer.profile');
    Route::get('/product-reviews', [ProductReviewController::class, 'index'])->name('product-reviews.index');
    Route::get('/reviews/create/{order_id}/{product_id}', [ProductReviewController::class, 'createReview'])->name('reviews.create');
    Route::post('/reviews', [ProductReviewController::class, 'storeReview'])->name('reviews.store');
    Route::get('/api/customer-pending-count', [OrderController::class, 'getPendingCount']);
    Route::post('/contact/submit', [ContactController::class, 'sendContactEmail'])->name('contact.submit');
});
