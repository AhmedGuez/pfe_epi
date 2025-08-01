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
        Schema::create('bne_matiere_premieres', function (Blueprint $table) {
            $table->id();
            $table->string('bon_entree_number')->unique();
            $table->date('creation_date');
            $table->string('usine');
            $table->string('created_by');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bne_matiere_premieres');
    }
};
