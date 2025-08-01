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
        Schema::create('bns_reste_bobine_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bns_reste_bobine_id');
            $table->foreign('bns_reste_bobine_id')->references('id')->on('bns_reste_bobines')->onDelete('cascade');
            $table->unsignedBigInteger('article_matiere_premiere_id');
            $table->foreign('article_matiere_premiere_id', 'bnsb_amp_fk')->references('id')->on('article_matiere_premieres')->onDelete('cascade');
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
        Schema::dropIfExists('bns_reste_bobine_articles');
    }
};
