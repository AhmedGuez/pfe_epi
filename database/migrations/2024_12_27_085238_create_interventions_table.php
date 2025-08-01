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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->foreignId('technicien_id')->constrained()->onDelete('cascade');
            $table->date('date_intervention'); 
            $table->enum('type_intervention', ['correctif', 'préventif'])->default('correctif'); 
            $table->string('intervention_number'); 
            $table->string('cause_intervention')->nullable(); 
            $table->integer('duree_intervention');
            $table->boolean('toggleInput')->default(false);
            $table->text('description')->nullable(); 
            $table->string('fichier_joint')->nullable(); 
            $table->string('created_by'); 
            $table->string('cause_intervention_autre')->nullable(); 
            $table->decimal('cout_technicien', 10, 3)->nullable(); 
            $table->boolean('status')->default(false); 
            $table->timestamps(); 
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
