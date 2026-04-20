<?php

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = \App\Models\Category::all();
    $bestSellers = \App\Models\Product::take(8)->get();
    return view('home', compact('categories', 'bestSellers'));
});

// Google Authentication Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('/products', function (Illuminate\Http\Request $request) {
    $categorySlug = $request->get('category');
    $query = Product::query();
    
    if ($categorySlug) {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $query->where('category_id', $category->id);
    }
    
    $products = $query->paginate(12)->withQueryString();
    $categories = Category::all();
    
    return view('products', compact('products', 'categories'));
})->name('products.index');

Route::get('/product/{product:slug}', function (Product $product) {
    return view('product', compact('product'));
})->name('product.detail');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/return-policy', function () {
    return view('return-policy');
})->name('return-policy');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

use App\Http\Controllers\OrderTrackingController;

Route::get('/order-track', [OrderTrackingController::class, 'index'])->name('order-track');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', function () {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja Anda kosong.');
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $couponCode = session()->get('coupon');
        if ($couponCode) {
            $couponModel = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($couponModel && $couponModel->isValid($total)) {
                $discount = $couponModel->calculateDiscount($total);
            }
        }

        $paymentMethods = \App\Models\PaymentMethod::active()->get();

        return view('checkout', compact('cart', 'total', 'discount', 'paymentMethods'));
    })->name('checkout');
    Route::post('/checkout', [CartController::class, 'store'])->name('checkout.store');

    // Payment Confirmation
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payment.store');

    // Review
    Route::post('/orders/{order}/review/{product}', [ReviewController::class, 'store'])->name('reviews.store');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/order-success/{order}', function (\App\Models\Order $order) {
    if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
        abort(403);
    }
    $paymentMethodDetails = \App\Models\PaymentMethod::where('name', $order->payment_method)->first();
    return view('order-success', compact('order', 'paymentMethodDetails'));
})->middleware('auth')->name('order.success');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show'])->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('admin.customers.show');

    // Payment Methods
    Route::resource('payment-methods', PaymentMethodController::class)->except(['show'])->names([
        'index' => 'admin.payment_methods.index',
        'create' => 'admin.payment_methods.create',
        'store' => 'admin.payment_methods.store',
        'edit' => 'admin.payment_methods.edit',
        'update' => 'admin.payment_methods.update',
        'destroy' => 'admin.payment_methods.destroy',
    ]);

    // Coupons
    Route::resource('coupons', CouponController::class)->except(['show'])->names([
        'index' => 'admin.coupons.index',
        'create' => 'admin.coupons.create',
        'store' => 'admin.coupons.store',
        'edit' => 'admin.coupons.edit',
        'update' => 'admin.coupons.update',
        'destroy' => 'admin.coupons.destroy',
    ]);

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::patch('/orders/{order}/verify', [AdminController::class, 'verifyOrder'])->name('admin.orders.verify');
    Route::patch('/orders/{order}/reject', [AdminController::class, 'rejectOrder'])->name('admin.orders.reject');
    Route::patch('/orders/{order}/ship', [AdminController::class, 'shipOrder'])->name('admin.orders.ship');
    Route::patch('/orders/{order}/complete', [AdminController::class, 'completeOrder'])->name('admin.orders.complete');
    Route::patch('/orders/{order}/cancel', [AdminController::class, 'cancelOrder'])->name('admin.orders.cancel');
});

require __DIR__.'/auth.php';
