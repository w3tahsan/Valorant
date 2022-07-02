<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Models\CustomerLogin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//frontend
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/product/details/{product_id}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::get('/privacy', [FrontendController::class, 'privacy']);
Route::get('/terms', [FrontendController::class, 'terms']);
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Users
Route::get('/user/delete/{user_id}', [HomeController::class, 'delete'])->name('del');

//Category
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::post('/category/insert', [CategoryController::class, 'insert'])->name('category.insert');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'restore'])->name('category.restore');
Route::get('/category/force_delete/{category_id}', [CategoryController::class, 'force_delete'])->name('category.force_delete');
Route::post('/mark/delete', [CategoryController::class, 'markdel'])->name('category.markdel');

//subcategory
Route::get('/subcategory', [SubcategoryController::class, 'index'])->name('subcategory.index');
Route::post('/subcategory/insert', [SubcategoryController::class, 'insert'])->name('subcategory.insert');
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'delete'])->name('subcategory.delete');


//dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard']);

//Profile
Route::get('/profile',[ProfileController::class, 'profile'])->name('profile');
Route::post('/name/change',[ProfileController::class, 'name_change'])->name('name.change');
Route::post('/password/change',[ProfileController::class, 'password_change'])->name('password.change');
Route::post('/photo/change',[ProfileController::class, 'photo_change'])->name('photo.change');

//Product
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::post('/getCategory', [ProductController::class, 'getCategory']);
Route::post('/product/insert', [ProductController::class, 'insert']);
Route::get('/color', [InventoryController::class, 'color'])->name('color');
Route::post('/color/insert', [InventoryController::class, 'insert']);
Route::get('/size', [InventoryController::class, 'size'])->name('size');
Route::post('/size/insert', [InventoryController::class, 'size_insert']);
Route::get('/inventory/{product_id}', [InventoryController::class, 'inventory'])->name('inventory');
Route::post('/inventory/insert', [InventoryController::class, 'inventory_insert']);


//customer
Route::get('/customer/register/form', [CustomerRegisterController::class, 'customer_register_form'])->name('customer.register.form');
Route::post('/customer/register', [CustomerRegisterController::class, 'customer_register']);
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login']);
Route::get('/customer/account', [AccountController::class, 'account'])->name('account');
Route::get('/customer/logout', [AccountController::class, 'customerlogout'])->name('customerlogout');
Route::get('/customer/email/verify/{token}', [AccountController::class, 'customerEmailverify'])->name('customer.email.verify');

//cart
Route::post('/cart/insert', [CartController::class, 'cart_insert']);
Route::get('/cart/delete/{cart_id}', [CartController::class, 'cart_delete'])->name('cart.delete');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update']);

//coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/insert', [CouponController::class, 'coupon_insert']);

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/placed', [CheckoutController::class, 'order_insert']);
Route::get('/order/confirmed', [CheckoutController::class, 'order_confirmed'])->name('order.confirmed');



// SSLCOMMERZ Start
Route::get('/sslpay', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);
Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//Stripe
Route::get('stripe', [StripePaymentController::class, 'stripe']);
Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

//invoice
Route::get('/invoice/download/{invoice_id}', [AccountController::class, 'invoice'])->name('invoice.download');

//Customer Password Reset
Route::get('/customer/pass/reset/req', [AccountController::class, 'password_reset_req'])->name('password.reset.req');
Route::post('/customer/pass/reset/store', [AccountController::class, 'password_reset_store'])->name('password.reset.store');
Route::get('/customer/pass/reset/form/{token}', [AccountController::class, 'password_reset_req_form'])->name('pass.reset.form');
Route::post('/customer/pass/update', [AccountController::class, 'pass_update'])->name('customer_pass_update');


//Github login
Route::get('/github/redirect', [GithubController::class, 'redirectToProvider']);
Route::get('/github/callback', [GithubController::class, 'handleProviderCallback']);

//Google login
Route::get('/google/redirect', [GoogleController::class, 'redirectToProvider']);
Route::get('/google/callback', [GoogleController::class, 'handleProviderCallback']);

//facebook login
Route::get('/facebook/redirect', [FacebookController::class, 'redirectToProvider']);
Route::get('/facebook/callback', [FacebookController::class, 'handleProviderCallback']);

//review
Route::post('/product/review/{product_id}', [FrontendController::class, 'product_review'])->name('product.review');

//Role
Route::get('/role', [RoleController::class, 'role'])->name('role');
Route::post('/permission/store', [RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleController::class, 'role_store'])->name('role.store');
Route::post('/role/assign', [RoleController::class, 'role_assign'])->name('role.assign');
Route::get('/role/edit/{user_id}', [RoleController::class, 'role_edit'])->name('role.edit');
Route::post('/role/update', [RoleController::class, 'role_update'])->name('role.update');

