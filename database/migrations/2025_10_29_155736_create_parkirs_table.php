<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('parkirs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('shift'); 

            $table->unsignedBigInteger('pendapatan_r2');
            $table->unsignedBigInteger('pendapatan_r4');

            $table->unsignedInteger('jumlah_r2');
            $table->unsignedInteger('jumlah_r4');

            $table->unsignedBigInteger('total'); 

            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('parkirs');
    }
};