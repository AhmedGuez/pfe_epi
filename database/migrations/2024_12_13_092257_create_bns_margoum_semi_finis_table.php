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
        Schema::create('bns_margoum_semi_finis', function (Blueprint $table) {
            $table->id();
            $table->string('bon_sortie_number')->unique();
            $table->string('usine');
            $table->date('creation_date');
            $table->string('created_by');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bns_margoum_semi_finis');
    }
};
