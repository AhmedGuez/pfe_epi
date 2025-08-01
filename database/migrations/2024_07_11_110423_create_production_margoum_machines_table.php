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
        Schema::create('production_margoum_machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_margoum_id')
                ->constrained()
                ->onDelete('cascade');
            $table->integer('machine');
            $table->string('comment')->nullable()->after('machine');
            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_margoum_machines');
    }
};
