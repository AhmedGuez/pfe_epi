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
        Schema::create('production_fringes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_fringe_id')->constrained()->onDelete('cascade');
            $table->date('creation_date');
            $table->string('employee_name');
            $table->decimal('qty', 10, 3);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_fringes');
    }
};
