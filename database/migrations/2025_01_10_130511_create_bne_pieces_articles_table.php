<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bne_pieces_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bne_piece_id')->constrained()->onDelete('cascade')->nullable(); 
            $table->foreignId('piece_id')->constrained()->onDelete('cascade');
            $table->decimal('quantite')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bne_pieces_articles');
    }
};
