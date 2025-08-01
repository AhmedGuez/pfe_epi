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
        Schema::create('bns_dechet_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bns_dechet_id')->constrained()->onDelete('cascade');
            $table->foreignId('dechet_type_id')->constrained()->onDelete('cascade');
            $table->decimal('prix_par_kg', 10, 3);
            $table->decimal('qty', 10, 3);
            $table->decimal('total', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bns_dechet_articles');
    }
};
