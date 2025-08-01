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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade');
            $table->string('created_by');
            $table->enum('type', ['entrée', 'dépense', 'retour']);
            $table->decimal('amount', 10, 3);
            $table->text('description')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('demandeur')->nullable();
            $table->string('attached_file')->nullable();
            $table->date('transaction_date');
            $table->boolean('justificatif')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
