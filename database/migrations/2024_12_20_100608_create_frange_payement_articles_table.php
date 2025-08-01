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
        Schema::create('frange_payement_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('frange_payement_id')->constrained()->onDelete('cascade');
            $table->foreignId('fringe_contact_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('ref_fringe_id')
            ->constrained()
            ->onDelete('cascade');
            $table->decimal('approved_qty', 10, 3);
            $table->decimal('rejected_qty', 10, 3);
            $table->text('prix_par_kg');
            $table->decimal('Total', 10, 3);
            $table->decimal('montant_payer', 10, 3);
            $table->decimal('reste_a_payer', 10, 3);
            $table->decimal('second_payment', 10, 3);
            $table->enum('payment_status', ['non_payé', 'partiellement_payé', 'totalement_payé'])->default('non_payé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frange_payement_articles');
    }
};
