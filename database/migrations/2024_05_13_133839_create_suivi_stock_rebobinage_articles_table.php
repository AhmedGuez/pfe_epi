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
        Schema::create('suivi_stock_rebobinage_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suivi_stock_rebobinage_id')
                  ->constrained('suivi_stock_rebobinages')
                  ->onDelete('cascade')
                  ->name('ssr_article_fk');
            $table->unsignedBigInteger('article_matiere_premiere_id');
            $table->float('quantity');
            $table->foreign('article_matiere_premiere_id', 'rb_amp_fk')
                  ->references('id')
                  ->on('article_matiere_premieres')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suivi_stock_rebobinage_articles');
    }
};
