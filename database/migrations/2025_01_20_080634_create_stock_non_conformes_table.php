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
        Schema::create('stock_non_conformes', function (Blueprint $table) {
            $table->id();
            $table->string('sous_traitance_number');
            $table->foreignId('ref_fringe_id')->constrained()->onDelete('cascade');
            $table->foreignId('fringe_contact_id')->constrained()->onDelete('cascade');
            $table->decimal('qty', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_non_conformes');
    }
};
