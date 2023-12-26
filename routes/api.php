<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\Transaction\TransactionCategoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function(){
    //Products
    Route::apiResource('products', ProductController::class)->only(['index', 'show']);

    //Categories
    Route::apiResource('categories', CategoryController::class);

    //Transactions
    Route::apiResource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::apiResource('transactions.categories', TransactionCategoryController::class)->only(['index']);
    Route::apiResource('transactions.sellers', TransactionSellerController::class)->only(['index']);

    //Buyers
    Route::apiResource('buyers', BuyerController::class)->only(['index', 'show']);

    //Sellers
    Route::apiResource('sellers', SellerController::class)->only(['index', 'show']);

    //Users
    Route::apiResource('users', UserController::class);
});
