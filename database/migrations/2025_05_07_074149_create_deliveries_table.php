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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('bnl_number');
            $table->enum('type', ['client', 'transfer', 'employee'])->default('client');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null'); 
            $table->foreignId('from_depot_id')->nullable()->constrained('depots')->onDelete('set null');
            $table->foreignId('to_depot_id')->nullable()->constrained('depots')->onDelete('set null');
            $table->string('car_number')->nullable();
            $table->date('delivery_date');
            $table->string('status')->default('Draft');
            $table->foreignId('delivered_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }


    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
