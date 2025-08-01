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
    Schema::create('absences', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->unsignedBigInteger('employe_id'); // Foreign key to the employees table
        $table->date('date_debut'); // Start date of the absence
        $table->date('date_fin'); // End date of the absence
        $table->integer('duree_jours'); // Duration of the absence in days
        $table->text('raison'); // Reason for the absence
        $table->enum('justification', ['Aucune', 'Certificat', 'Autre'])->default('Aucune'); // Justification for the absence
        $table->timestamps(); // Created at and updated at timestamps

        // Foreign key constraint
        $table->foreign('employe_id')->references('id')->on('employees')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
