<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get("/", function () {
    return inertia("Home");
})->name("home");
Route::get("/ilan",function(){
    return response("İlan",200);
})->name("ilan");

Route::controller(AuthController::class)->group(function(){
    Route::get("/login","login_view")->name("login");
    Route::post("/login","login")->name("login");
    Route::get("/register","register_view")->name("register");
    Route::post("/register","register")->name("register");
    Route::get("/logout","logout")->name("logout");
});

Route::prefix("/account")->middleware("auth")->group(function(){
    Route::inertia("/","Account/Account")->name("account");
    Route::controller(AccountController::class)->group(function(){
        Route::get("/settings","index")->name("account.settings");
        Route::post("/profile","updateProfile")->name("account.update.profile");
        Route::post("/email","updateEmail")->name("account.update.email");
        Route::post("/password","updatePassword")->name("account.update.password");
        Route::post("/phone","updatePhone")->name("account.update.phone");
    });
});
