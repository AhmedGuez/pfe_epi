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
        Schema::create('bnl_stock_margoums', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('bon_livraison_number')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->date('creation_date');
            $table->string('created_by');
            $table->string('camion');
            $table->string('chauffeur');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnl_stock_margoums');
    }
};
