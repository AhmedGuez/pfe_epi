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
        Schema::create('transfer_commandes', function (Blueprint $table) {
            $table->id();
            $table->date('transfer_date');
            $table->string('code_commande')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['en cours','en attente','livrer'])->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_commandes');
    }
};
