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
    Schema::create('miseapieds', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->unsignedBigInteger('employe_id'); // Foreign key reference to the 'employees' table
        $table->date('date_debut'); // Start date of the suspension
        $table->date('date_fin'); // End date of the suspension
        $table->integer('nombre_jour'); // Number of days of suspension
        $table->text('raison')->nullable(); // Reason for suspension (nullable)
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
        Schema::dropIfExists('miseapieds');
    }
};
