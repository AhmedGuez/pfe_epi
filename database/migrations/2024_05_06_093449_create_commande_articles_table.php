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
        Schema::create('commande_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('nombre_de_pieces');
            $table->integer('nombre_de_pieces_fini')->nullable();
            $table->integer('nombre_de_pieces_semi_fini')->nullable();
            $table->integer('nombre_de_pieces_livre')->default(0);
            $table->integer('nombre_de_pieces_reste_a_livre')->nullable();
            $table->integer('rest')->nullable();
            $table->integer('qty_transferred')->default(0); 
            $table->string('client_transferred_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_articles');
    }
};
