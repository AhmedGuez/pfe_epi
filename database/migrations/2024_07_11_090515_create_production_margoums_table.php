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
        Schema::create('production_margoums', function (Blueprint $table) {
            $table->id();
            $table->date('creation_date');
            $table->string('created_by');
            $table->string('section');
            $table->float('total');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_margoums');
    }
};
