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
        Schema::create('deal_locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('deal_id');
            $table->foreign("deal_id")->references("id")->on("deals");
            $table->unsignedBigInteger('city_id');
            $table->foreign("city_id")->references("id")->on("cities");
            $table->unsignedBigInteger('district_id');
            $table->foreign("district_id")->references("id")->on("districts");
            $table->unsignedBigInteger('neighbourhood_id');
            $table->foreign("neighbourhood_id")->references("id")->on("neighbourhoods");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_location');
    }
};
