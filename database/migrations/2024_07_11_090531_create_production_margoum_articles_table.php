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
        Schema::create('production_margoum_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_margoum_machine_id')
                  ->constrained('production_margoum_machines')
                  ->onDelete('cascade')
                  ->name('pm_machine_fk');
            $table->json('employee_name');
            $table->foreignId('taille_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->name('pm_taille_fk'); 
            $table->foreignId('color_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->name('pm_color_fk'); 
            $table->float('quantity');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_margoum_articles');
    }
};
