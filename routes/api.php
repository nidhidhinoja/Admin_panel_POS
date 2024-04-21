<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopkeeperController;
use App\Models\Product;



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

Route::post('register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class,'login']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('product/show', [ProductController::class, 'show_product']);
    Route::post('product/search', [ProductController::class, 'search_product']);
    Route::post('category/show/', [CategoryController::class, 'show']);
    Route::post('category/search/', [CategoryController::class, 'search']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'print']);
    Route::post('pos/orders', [OrderController::class, 'posStore']);
    Route::get('pos/orders/{id}', [OrderController::class, 'posPrint']);
    Route::post('/orders-report', [OrderController::class,'getOrdersByDateRange']);
    Route::post('/customer', [CustomerController::class,'apiStore']);
    Route::get('/showCustomer', [CustomerController::class,'show']);
});

Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/shopkeeper', [ShopkeeperController::class, 'apiStore'])->name('shopkeeper.store');
