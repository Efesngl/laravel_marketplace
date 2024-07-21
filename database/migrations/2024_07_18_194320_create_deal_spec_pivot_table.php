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
        Schema::create('deal_specification_pivot', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('specification_id');
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_spec_pivot');
    }
};
