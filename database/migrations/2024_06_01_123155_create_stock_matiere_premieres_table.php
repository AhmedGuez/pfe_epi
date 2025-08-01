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
        Schema::create('stock_matiere_premieres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_matiere_premiere_id')->nullable();
            $table->foreign('article_matiere_premiere_id')->references('id')->on('article_matiere_premieres')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->float('quantity');
            $table->string('unite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_matiere_premieres');
    }
};
