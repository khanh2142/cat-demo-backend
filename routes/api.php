<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;




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
Route::prefix("/admin")->group(function() {
    Route::prefix("/categories")->group(function() {
        Route::get('/index', [CategoryController::class , "index"]);
        Route::get("/{id}", [CategoryController::class , "get_category"]);
        Route::post("/create", [CategoryController::class , "store"]);
        Route::post("/update/{id}", [CategoryController::class , "update"]);
        Route::delete("/delete/{id}", [CategoryController::class , "destroy"]);
        Route::get("/detail/{id}", [CategoryController::class, "get_each_category"]);

    });
    Route::prefix("/carousels")->group(function(){
        Route::get("/index", [CarouselController::class, "index"]);
        Route::post("/index", [CarouselController::class, "store"]);
        Route::post("/update/{id}", [CarouselController::class , "update"]);
        Route::delete("/delete/{id}", [CarouselController::class, "destroy"]);
    });
    Route::prefix("/products")->group(function() {
        Route::get("/index", [ProductController::class , "index"]);
        Route::post("/create", [ProductController::class , "store"]);
        Route::post("/update/{id}", [ProductController::class, "update"]);
        Route::delete("/delete/{id}" , [ProductController::class , "destroy"]);
        Route::get("/detail/{id}" , [ProductController::class , "detail_product"]);
        Route::get("/by-category/{id}" , [ProductController::class , "get_product_by_category"]);
        Route::get("/images/{id}" , [ProductController::class , "get_images_by_product"]);
        Route::get("/random/{id}", [ProductController::class , "get_random_product"]);
        Route::get("/hot", [ProductController::class , "get_hot_product"]);
        // Route::post("/comment")
    });
    Route::prefix("/menu")->group(function() {
        Route::get("/index" , [MenuController::class , "index"]);
    });

    Route::prefix("/auth")->group(function (){
        Route::post("/login" , [UserController::class , "login"]);
        Route::get("/user" , [UserController::class , "index"]);
        Route::post("/signup" , [UserController::class , "signUp"]);
        Route::get("/getUser/{id}", [UserController::class, "get_user"]);
    });
});

