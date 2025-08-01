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
        Schema::create('bnc_matiere_premieres', function (Blueprint $table) {
            $table->id();
            $table->date('creation_date');
            $table->string('bnc_number')->unique();
            $table->string('created_by');
            $table->boolean('status')->default(false);

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
        Schema::dropIfExists('bnc_matiere_premieres');
    }
};
