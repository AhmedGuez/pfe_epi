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
        Schema::create('sous_traitance_controlle_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sous_traitance_controlle_id');
            $table->foreign('sous_traitance_controlle_id', 'stc_article_fk')
                ->references('id')
                ->on('sous_traitance_controlles')
                ->onDelete('cascade');
            $table->foreignId('ref_fringe_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('fringe_contact_id')
                ->constrained()
                ->onDelete('cascade');
            $table->decimal('approved_qty', 10, 3);
            $table->decimal('rejected_qty', 10, 3);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_traitance_controlle_articles');
    }
};
