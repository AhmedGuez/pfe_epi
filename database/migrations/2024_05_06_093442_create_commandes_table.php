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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('code_commande')->unique();
            $table->date('date_commande');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['terminer', 'en cours', 'annuler', 'en attente', 'livrer'])->default('en attente');
            $table->boolean('is_transfered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('commandes', function (Blueprint $table) {
            // Drop the enum status column
            $table->dropColumn('status');

            // Add the old boolean status column back
            $table->boolean('status')->default(false);
        });
    }
};
