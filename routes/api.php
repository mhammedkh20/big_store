<?php

use App\Models\User;
use Illuminate\Http\Request;
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


Route::group(['middleware' => ['changeLanguage', 'checkPassword'],'prefix'=>'auth/'], function () {

    Route::post('register', 'AuthController@register');

    Route::post('login', 'AuthController@login');

    Route::post('password/email', 'AuthController@forget')->name('password.sent');

    Route::post('password/reset', 'AuthController@reset')->name('password.reset');

    Route::post('email/verification-notification', 'AuthController@sendVerificationEmail');

    Route::post('verify-email/{id}/{hash}', 'AuthController@verify')->name('verification.verify');
});
