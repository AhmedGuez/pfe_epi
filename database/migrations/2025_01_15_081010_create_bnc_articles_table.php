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
        Schema::create('bnc_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bnc_matiere_premiere_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->unsignedBigInteger('article_matiere_premiere_id');
            $table->foreign('article_matiere_premiere_id', 'bnc_fk_name') // Unique name
                  ->references('id')
                  ->on('article_matiere_premieres')
                  ->onDelete('cascade');
            $table->foreignId('categorie_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->float('quantity');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnc_articles');
    }
};
