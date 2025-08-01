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
        Schema::create('bns_dechets', function (Blueprint $table) {
            $table->id();
            $table->string('bon_sortie_number')->unique();
            $table->date('creation_date');
            $table->string('created_by');
            $table->foreignId('dechet_contact_id')->constrained()->onDelete('cascade');
            $table->string('matriclule');
            $table->decimal('prix_total', 10, 3);
            $table->decimal('remise', 10, 3);
            $table->decimal('net_payer', 10, 3);
            $table->decimal('old_credit', 10, 3);
            $table->decimal('credit', 10, 3);
            $table->decimal('reste_a_payer', 10, 3);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bns_dechets');
    }
};
