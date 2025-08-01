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
    Schema::create('questionnaires', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->unsignedBigInteger('employe_id'); // Foreign key reference to the 'employees' table
        $table->text('question'); // Field for storing the question text
        $table->string('fichier_joint')->nullable(); // File attachment (nullable)
        $table->timestamps(); // Timestamps for created_at and updated_at

        // Adding foreign key constraint
        $table->foreign('employe_id')->references('id')->on('employees')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
