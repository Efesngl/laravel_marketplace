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
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("specification");
        });
        Schema::create("specification_values",function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("specification_id");
            $table->string("value");
            $table->foreign("specification_id")->references("id")->on("specifications")->cascadeOnDelete();
        });
        Schema::create("category_specifications",function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("specification_id");
            $table->foreign("category_id")->references("id")->on("categories")->cascadeOnDelete();
            $table->foreign("specification_id")->references("id")->on("specifications")->cascadeOnDelete();
        });
        Schema::create("product_specifications",function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("specification_id");
            $table->unsignedBigInteger("value_id");
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete();
            $table->foreign("specification_id")->references("id")->on("specifications")->cascadeOnDelete();
            $table->foreign("value_id")->references("id")->on("specification_values")->cascadeOnDelete(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
        Schema::dropIfExists('specification_values');
        Schema::dropIfExists('category_specifications');
        Schema::dropIfExists('product_specifications');
    }
};
