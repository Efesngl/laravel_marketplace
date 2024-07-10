<?php

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
    Route::get("/login","login")->name("auth.login");
});