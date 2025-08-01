<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Drop the unique index on email
            $table->dropUnique('clients_email_unique');

            // Make the column nullable
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Make it not nullable again and reapply the unique constraint
            $table->string('email')->unique()->change();
        });
    }
};
