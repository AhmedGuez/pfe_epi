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
        Schema::create('licenciements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('employe_id'); 
            $table->text('raison');
            $table->date('date');
            $table->timestamps();
            $table->foreign('employe_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenciements');
    }
};
