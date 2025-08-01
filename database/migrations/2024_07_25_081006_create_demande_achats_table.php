<?php

use App\Enums\DemandeAchatStatus;
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
        Schema::create('demande_achats', function (Blueprint $table) {
            $table->id();
            $table->string('created_by');
            $table->date('date_demande');
            $table->string('reason');
            $table->string('designation');
            $table->string('ref')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->integer('quantite');
            $table->string('file_name')->nullable();
            
            $table->enum('status', ['confirmer', 'annuler', 'en cours'])->default('en cours');
             // Foreign key to fournisseurs table
            $table->unsignedBigInteger('fournisseur_id')->nullable();

        $table->timestamps();

        // Foreign key constraint
        $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_achats');
    }
};
