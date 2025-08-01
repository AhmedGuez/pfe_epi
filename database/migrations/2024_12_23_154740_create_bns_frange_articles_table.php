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
        Schema::create('bns_frange_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bns_frange_id')->constrained()->onDelete('cascade');
            $table->foreignId('ref_fringe_id')->constrained()->onDelete('cascade');
            $table->decimal('qty', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bns_frange_articles');
    }
};
