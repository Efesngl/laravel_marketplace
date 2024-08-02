<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(HomeController::class)->group(function () {
    Route::get("/", "index")->name("home");
});
Route::resource("/deal", DealController::class);
Route::controller(DealController::class)->group(function () {
    Route::post("/deal/image", "uploadPhotos")->name("deal.image");
    Route::delete("/deal/image/{id}", "deleteImage")->name("deal.deleteimage");
    
});
Route::get("/category/{id}/specs", [CategoryController::class,"specs"])->name("category.specs");
Route::controller(AuthController::class)->group(function () {
    Route::get("/login", "login_view")->name("login");
    Route::post("/login", "login")->name("login");
    Route::get("/register", "register_view")->name("register");
    Route::post("/register", "register")->name("register");
    Route::get("/logout", "logout")->name("logout");
});
Route::prefix("/account")->middleware("auth")->group(function () {
    Route::inertia("/", "Account/Account")->name("account");
    Route::controller(AccountController::class)->group(function () {
        Route::get("/settings", "index")->name("account.settings");
        Route::post("/profile", "updateProfile")->name("account.update.profile");
        Route::post("/email", "updateEmail")->name("account.update.email");
        Route::post("/password", "updatePassword")->name("account.update.password");
        Route::post("/phone", "updatePhone")->name("account.update.phone");
    });
});
Route::controller(SearchController::class)->group(function () {
    Route::get("/search", "index")->name("search");
    Route::get("/result", "result")->name("search.result");
});
Route::controller(BrowseController::class)->prefix("/categories")->group(function () {
    Route::get("/{cat?}", "index")->name("browse.index");
});