<?php

use App\Helpers\Iyzico;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(HomeController::class)->group(function () {
    Route::get("/", "index")->name("home");
});
Route::resource("/product", ProductController::class);
Route::controller(ProductController::class)->group(function () {
    Route::post("/product/image", "uploadPhotos")->name("product.image");
    Route::delete("/product/image/{id}", "deleteImage")->name("product.deleteimage");

});
Route::get("/category/{id}/specs", [CategoryController::class, "specs"])->name("category.specs");
Route::controller(AuthController::class)->group(function () {
    Route::get("/login", "loginView")->name("login");
    Route::post("/login", "login")->name("login");
    Route::get("/register", "registerView")->name("register");
    Route::post("/register", "register")->name("register");
    Route::get("/logout", "logout")->name("logout");
});
Route::prefix("/account")->middleware("auth")->group(function () {
    Route::inertia("/", "Account/Account")->name("account.index");
    Route::controller(AccountController::class)->group(function () {
        Route::get("/settings", "index")->name("account.settings");
        Route::post("/profile", "updateProfile")->name("account.update.profile");
        Route::post("/email", "updateEmail")->name("account.update.email");
        Route::post("/password", "updatePassword")->name("account.update.password");
        Route::post("/phone", "updatePhone")->name("account.update.phone");
        Route::get("/products/{status}", "products")->name("account.products");
    });
    Route::controller(ChatController::class)->group(function () {
        Route::get("/chats", "index")->name("account.chats.index");
        Route::get("/chat/{chatID}", "show")->name("account.chats.show");
        Route::post("/chat", "store")->name("chat.store");
    });
    Route::controller(MessageController::class)->group(function () {
        Route::post("/message/{chatID}", "store")->name("message.store");
    });
    Route::controller(FavoriteController::class)->group(function () {
        Route::get("/favorites", "index")->name("account.favorites.index");
        Route::post("/favorites", "store")->name("favorites.store");
        Route::delete("/favorites", "destroy")->name("favorites.destroy");
    });
    Route::controller(OrderController::class)->group(function(){
        Route::get("/orders","index");
    });
});
Route::controller(SearchController::class)->group(function () {
    Route::get("/search", "index")->name("search");
    Route::get("/result", "result")->name("search.result");
});
Route::controller(BrowseController::class)->prefix("/categories")->group(function () {
    Route::get("/{cat?}", "index")->name("browse.index");
});
Route::controller(CartController::class)->prefix("/cart")->middleware("auth")->group(function(){
    Route::get("/","index")->name("cart.index");
    Route::post("/","store")->name("cart.store");
    Route::patch("/{cart}/quantity","setQuantity")->name("cart.setquantity");
    Route::patch("/{cart}/selected","setSelected")->name("cart.setselected");
    Route::get("/checkout","checkout")->name("cart.checkout");
    Route::get("/clear","clear")->name("cart.clear");
});
Route::get("/iyzico", function () {
    $user = User::where("email", "=", "efe@gmail.com")->first();
    $iyzico = new Iyzico();
    dd($iyzico->initCheckoutForm());
});
Route::get("/info", function () {
    phpinfo();
});