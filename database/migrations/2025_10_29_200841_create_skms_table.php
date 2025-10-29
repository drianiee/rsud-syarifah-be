<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('skms', function (Blueprint $table) {
            $table->id();
            $table->string('period_name');           
            $table->string('survey_period');          
            $table->unsignedInteger('male_count');    
            $table->unsignedInteger('female_count'); 
            $table->decimal('index_value', 5, 2);    
            $table->string('service_quality', 1);    
            $table->string('performance');           
            $table->decimal('ekm_value', 6, 2);       
            $table->unsignedSmallInteger('year');     
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('skms');
    }
};
