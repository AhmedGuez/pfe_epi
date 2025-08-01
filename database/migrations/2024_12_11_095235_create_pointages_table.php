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
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Links to Employee
            $table->date('date');
            $table->decimal('hours_worked', 5, 2)->default(0); // Regular hours
            $table->decimal('overtime_hours', 5, 2)->default(0); // Overtime hours
            $table->boolean('is_weekend')->default(false); // If it's a weekend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointages');
    }
};
