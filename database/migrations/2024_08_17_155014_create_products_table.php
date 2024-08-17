<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string("title");
            $table->decimal("price", 14, 2);
            $table->string("banner");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("category_id");
            $table->text("description");
            $table->boolean("is_active")->default(true);
            $table->unsignedSmallInteger("stock");
            $table->unsignedSmallInteger("quantity_per_user");
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("category_id")->references("id")->on("categories")->restrictOnDelete();
        });
        Schema::create("product_images", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("product_id");
            $table->string("image");
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete();
        });
        Schema::create("favorites", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("product_id");
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('favorites');
    }
};
