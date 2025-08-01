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
        Schema::create('sous_traitance_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sous_traitance_id')->constrained()->onDelete('cascade');
            $table->foreignId('ref_fringe_id')->constrained()->onDelete('cascade');
            $table->foreignId('fringe_contact_id')->constrained()->onDelete('cascade');
            $table->string('chef_de_group');
            $table->string('emplacement');
            $table->decimal('qty', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_traitance_articles');
    }
};
