<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->string('code_piece', 50)->unique()->notNull();
            $table->string('nom_piece', 100)->notNull();
            $table->string('categorie')->notNull();
            $table->decimal('quantite')->default(0);
            $table->integer('seuil_minimum')->default(0);
            $table->string('unite_mesure', 20)->default('pièce');
            $table->string('marque', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('dimension', 100)->nullable();
            $table->string('puissance', 50)->nullable();
            $table->string('materiau', 50)->nullable();
            $table->string('emplacement', 100)->nullable();
            $table->decimal('prix_unitaire', 10, 3)->nullable();
            $table->decimal('prix_total', 10, 3)->nullable();
            $table->string('etat')->default('Neuf');
            $table->string('compatibilite', 255)->nullable();
            $table->timestamp('date_ajout')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_derniere_utilisation')->nullable();
            $table->text('description')->nullable();
            $table->string('garantie', 50)->nullable();
            $table->string('numero_serie', 100)->nullable();
            $table->string('photo_piece', 255)->nullable();
            $table->string('ficher_join_piece', 255)->nullable();
            $table->string('fournisseur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
