<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ProductVariationOptionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['changeLanguage', 'checkPassword'], 'prefix' => 'auth/'], function () {

    Route::post('register', 'AuthController@register');

    Route::post('login', 'AuthController@login');

    Route::post('password/email', 'AuthController@forget')->name('password.sent');

    Route::post('password/reset', 'AuthController@reset')->name('password.reset');

    Route::post('email/verification-notification', 'AuthController@sendVerificationEmail');

    Route::post('verify-email/{id}/{hash}', 'AuthController@verify')->name('verification.verify');
});

Route::group(['middleware' => ['changeLanguage', 'checkPassword']], function () {
    // todo:: city
    Route::resource('city', CityController::class);

    // todo:: point
    Route::resource('point', PointController::class);

    // todo:: store
    Route::resource('store', StoreController::class);

    // todo:: manager - stores
    Route::resource('manager', ManagerController::class);

    // todo:: staff - stores
    Route::resource('staff', StaffController::class);

    // todo:: brands
    Route::get("brand", [BrandController::class, "index"]);

    Route::get("brand/{id}", [BrandController::class, "show"]);

    Route::post("brand", [BrandController::class, "store"]);

    Route::post("brand/{id}", [BrandController::class, "update"]);

    Route::delete("brand/{id}", [BrandController::class, "destroy"]);

    // todo:: category
    Route::get("category", [CategoryController::class, "index"]);

    Route::get("category_parent", [CategoryController::class, "categoryParent"]);

    Route::get("category_children/{id}", [CategoryController::class, "categoryChildren"]);

    Route::get("category/{id}", [CategoryController::class, "show"]);

    Route::post("category", [CategoryController::class, "store"]);

    Route::post("category/{id}", [CategoryController::class, "update"]);

    Route::delete("category/{id}", [CategoryController::class, "destroy"]);

    // todo:: product
    Route::resource('product', ProductController::class);

    // todo:: product variation
    Route::resource('product_variation', ProductVariationController::class);

    // todo:: product variation options
    Route::resource('product_variation_option', ProductVariationOptionController::class);

    // todo:: order
    Route::resource('order', OrderController::class);

    // todo:: order - items
    Route::resource('order_items', OrderItemsController::class);

    // todo:: stock
    Route::resource('stock', StockController::class);
});
