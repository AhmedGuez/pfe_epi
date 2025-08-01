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
        Schema::create('bnl_margoum_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bnl_margoum_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('stock_margoum_fini_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('commande_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->integer('nombre_de_pieces_livre');
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnl_margoum_articles');
    }
};
