<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaypalController;
use App\Models\Cart;
use App\Models\ImgProduct;
use App\Models\Product;
use App\Models\ProductImg;

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


// user
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/product', [UserController::class, 'product'])->name('product');

Route::get('/product-detail/{id}', [UserController::class, 'product_detail'])->name('product-detail');

Route::get('/search-products', [UserController::class, 'search_products'])->name('search-products');
Route::get('/product-filter', [UserController::class, 'product_filter']);
Route::middleware('user_auth')->group(function(){
    Route::get('/cart', [UserController::class, 'cart'])->name('cart');
    Route::post('/add-cart', [CartController::class, 'create'])->name('add.cart');
    Route::get('/minus-quanity', [CartController::class, 'minus_quantity']);
    Route::get('/plus-quanity', [CartController::class, 'plus_quantity']);
    Route::get('/remove-item-cart', [CartController::class, 'remove_item_cart']);

    Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
    Route::get('/district', [UserController::class, 'district']);
    Route::get('/ward', [UserController::class, 'ward']);
    
    Route::get('/thankyou', [UserController::class, 'thankyou'])->name('thankyou');
    Route::get('/order',[UserController::class, 'order'])->name('user.order');
    Route::get('/order-detail/{id}',[UserController::class, 'order_detail'])->name('user.order.detail');
    Route::get('/order-filter',[UserController::class, 'order_filter']);
    Route::get('/cancel-order/{id}',[UserController::class, 'cancel_order'])->name('user.cancel.order');
    Route::get('/profile',[UserController::class, 'profile'])->name('user.profile');
    Route::post('/edit-profile',[UserController::class, 'edit_profile'])->name('user.edit_profile');
    //payment
    Route::post('/add-order', [PaypalController::class, 'create'])->name('paypal.checkout');
    Route::get('/payment/paypal/return',[PaypalController::class, 'return'])->name('payment.paypal_return');
    Route::get('/payment/paypal/cancel',[PaypalController::class, 'cancel'])->name('payment.paypal_cancel');
});


Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/login', [UserController::class, 'auth_login'])->name('user.auth.login');

Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

Route::get('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/register', [UserController::class, 'auth_register'])->name('user.auth.register');




//admin
Route::get('/admin', [AdminController::class, 'index'])->name('login');
Route::post('/admin/auth', [AdminController::class, 'auth'])->name('admin_auth');
Route::middleware('admin_auth')->prefix('admin')->group(function () {



    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //category routes
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    //add category
    Route::get('/category/manage_category', [CategoryController::class, 'manage_category'])->name('manage_category');
    Route::post('/category/manage_category', [CategoryController::class, 'add_category']);
    //delete category
    Route::get('/category/delete_category', [CategoryController::class, 'delete_category'])->name('delete_category');
    // edit category
    Route::get('/category/edit_category', [CategoryController::class, 'edit_category'])->name('edit_category');
    Route::post('/category/edit_category', [CategoryController::class, 'edit_category_process']);

    // //product routes
    Route::resource('product', ProductController::class);
    Route::post('product/featured',[ProductController::class, 'product_featured']);
    Route::get('/order',[OrderController::class, 'index'])->name('order');
    Route::get('/order-detail/{id}',[OrderController::class, 'detail'])->name('order.detail');
    Route::get('/edit-status',[OrderController::class, 'edit_status']);
    Route::get('/confirm-order/{id}',[OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('/completed-order/{id}',[OrderController::class, 'completed'])->name('order.completed');
    Route::get('/order-filters',[OrderController::class, 'order_filter']);

    Route::get('/invoice',[OrderController::class, 'invoice'])->name('invoice');
    Route::get('/customer',[UserController::class, 'listCustomer'])->name('customer');
    Route::get('/export-users',[UserController::class, 'exportUsers'] )->name('export.users');
    Route::get('/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        return redirect('admin');
    });
});
