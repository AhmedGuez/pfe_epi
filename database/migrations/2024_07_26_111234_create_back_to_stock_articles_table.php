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
        Schema::create('back_to_stock_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('back_to_stock_id');
            $table->foreign('back_to_stock_id')->references('id')->on('back_to_stocks')->onDelete('cascade');
            $table->unsignedBigInteger('article_matiere_premiere_id');
            $table->foreign('article_matiere_premiere_id', 'bts_amp_fk')
                  ->references('id')
                  ->on('article_matiere_premieres')
                  ->onDelete('cascade');
            $table->foreignId('categorie_id')
                  ->constrained()
                  ->onDelete('cascade');
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
        Schema::dropIfExists('back_to_stock_articles');
    }
};
