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
        Schema::table('leads', function (Blueprint $table) {
            // Nullify 'link' and 'comments' columns
            $table->string('link')->nullable()->change();
            $table->text('comments')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Revert the 'link' and 'comments' columns back to not nullable
            $table->string('link')->nullable(false)->change();
            $table->text('comments')->nullable(false)->change();
        });
    }
};
