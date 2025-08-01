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
        Schema::create('transfer_margoum_finis', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->date('creation_date');
            $table->string('created_by');
            $table->string('matricule_camion');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_margoum_finis');
    }
};
