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
        // Index for commandes table
        Schema::table('commandes', function (Blueprint $table) {
            $table->index(['client_id', 'created_at'], 'commandes_client_created_idx');
            $table->index(['status', 'created_at'], 'commandes_status_created_idx');
            $table->index('date_commande', 'commandes_date_idx');
            $table->index('code_commande', 'commandes_code_idx');
        });

        // Index for commande_articles table
        Schema::table('commande_articles', function (Blueprint $table) {
            $table->index(['commande_id', 'product_id'], 'commande_articles_commande_product_idx');
            $table->index('product_id', 'commande_articles_product_idx');
        });

        // Index for client_user table
        Schema::table('client_user', function (Blueprint $table) {
            $table->index(['user_id', 'client_id'], 'client_user_user_client_idx');
            $table->index(['client_id', 'user_id'], 'client_user_client_user_idx');
        });

        // Index for products table
        Schema::table('products', function (Blueprint $table) {
            $table->index('code_article', 'products_code_article_idx');
        });

        // Index for clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->index('nom_entreprise', 'clients_nom_entreprise_idx');
            $table->index('email', 'clients_email_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropIndex('commandes_client_created_idx');
            $table->dropIndex('commandes_status_created_idx');
            $table->dropIndex('commandes_date_idx');
            $table->dropIndex('commandes_code_idx');
        });

        Schema::table('commande_articles', function (Blueprint $table) {
            $table->dropIndex('commande_articles_commande_product_idx');
            $table->dropIndex('commande_articles_product_idx');
        });

        Schema::table('client_user', function (Blueprint $table) {
            $table->dropIndex('client_user_user_client_idx');
            $table->dropIndex('client_user_client_user_idx');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_code_article_idx');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex('clients_nom_entreprise_idx');
            $table->dropIndex('clients_email_idx');
        });
    }
};