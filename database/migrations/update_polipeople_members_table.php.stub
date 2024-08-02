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
        Schema::table('polipeople_members', function (Blueprint $table) {
            $table->text('prefix')->nullable();
            $table->text('role')->nullable();
            $table->text('affiliation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('polipeople_members', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->dropColumn('role');
            $table->dropColumn('affiliation');
        });
    }
};
