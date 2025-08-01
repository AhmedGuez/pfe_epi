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
        Schema::table('commande_articles', function (Blueprint $table) {
            $table->integer('rest')->nullable();
            $table->integer('qty_transferred')->default(0);
            $table->string('client_transferred_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commande_articles', function (Blueprint $table) {
            $table->dropColumn(['rest', 'qty_transferred', 'client_transferred_to']);
        });
    }
};
