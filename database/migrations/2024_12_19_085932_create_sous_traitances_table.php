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
        Schema::create('sous_traitances', function (Blueprint $table) {
            $table->id();
            $table->string('sous_traitance_number')->unique();
            $table->date('datedesortie');
            $table->decimal('Total', 10, 2);
            $table->enum('status', ['Livrer', 'En Cours', 'En Attente'])->default('En Cours');
            $table->boolean('confirmer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_traitances');
    }
};
