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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('id');
            $table->string('affected')->nullable()->after('code');
            $table->string('situation')->nullable()->after('affected');
            $table->string('nombre_enfants')->nullable()->after('situation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['code', 'affected']);
        });
    }
};
