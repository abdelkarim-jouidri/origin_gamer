<?php

use App\Http\Controllers\AssignRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\ResetPasswordController;

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
Route::group(['middleware' => ['jwt.auth']], 

function() {
    
        Route::apiResource('categories',CategoryController::class);
        Route::put('/users/{user}',[EditProfileController::class,'edit']);
        Route::get('/products',[ProductController::class,'index']);
        Route::post('/products',[ProductController::class,'store']);
        Route::delete('/products/{product}',[ProductController::class,'destroy']);
        Route::put('/products/{product}',[ProductController::class,'update']);
        Route::get('/products/{product}',[ProductController::class,'show']);
        Route::get('/products/category/{id}',[ProductController::class,'filter']);

        Route::post('/user/role/{user}',[AssignRoleController::class,'update']);
    }
  
);


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::post('/forgot-password',[ResetPasswordController::class,'sendResetLink']);
Route::get('/reset-password/{token}',function($token){
    return $token;
})->name('password.reset');
Route::post('/reset-password',[ResetPasswordController::class,'resetPassword']);
