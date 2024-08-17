<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("product_id")->nullable();
            $table->unsignedSmallInteger("quantity");
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete();
        });
        Schema::create("order_statuses",function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->string("status");
        });
        Schema::create("orders",function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger("user_id");
            $table->decimal("total",14,2);
        });
        Schema::create("order_products",function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("product_id")->nullable();
            $table->unsignedBigInteger("status_id")->nullable();
            $table->foreign("order_id")->references("id")->on("orders")->cascadeOnDelete();
            $table->foreign("product_id")->references("id")->on("products")->nullOnDelete();
            $table->foreign("status_id")->references("id")->on("order_statuses")->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_cart');
        Schema::dropIfExists('order_statuses');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
    }
};
