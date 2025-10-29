<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('parking_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('r2_price');
            $table->unsignedBigInteger('r4_price');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('parking_settings');
    }
};