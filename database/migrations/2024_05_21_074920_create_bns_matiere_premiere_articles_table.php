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
        Schema::create('bns_matiere_premiere_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bns_matiere_premiere_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('article_matiere_premiere_id');
            $table->foreign('article_matiere_premiere_id', 'bns_amp_fk')->references('id')->on('article_matiere_premieres')->onDelete('cascade');
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
        Schema::dropIfExists('bns_matiere_premiere_articles');
    }
};
