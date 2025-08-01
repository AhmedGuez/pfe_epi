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
        Schema::create('frange_payements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sous_traitance_controlle_id')->constrained()->onDelete('cascade');
            $table->date('payement_date');
            $table->decimal('total_amount', 15, 3)->default(0);
            $table->decimal('paid_amount', 15, 3)->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frange_payements');
    }
};
