<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\TermController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController as UserUserController;
use App\Http\Controllers\RestaurantController as UserRestaurantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 管理者としてログインしていない状態でのみアクセス可能にするルーティング
Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('restaurants', RestaurantController::class);
});

// ユーザーのルーティング
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('user',UserController::class)->only(['index', 'edit', 'update']);
});  


require __DIR__.'/auth.php';
// 管理者専用のルーティング
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function() {
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
    Route::resource('/users', Admin\UserController::class)->only(['index', 'show']);
    Route::resource('/restaurants', Admin\RestaurantController::class);
    Route::resource('/categories', Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('/company', Admin\CompanyController::class);
    Route::resource('/terms', Admin\TermController::class);
});
