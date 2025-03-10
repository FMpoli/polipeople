<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('polipeople_members', function (Blueprint $table) {
            $table->integer('sort_order')->nullable();
        });

        // Aggiorna i record esistenti con un valore di sort_order basato sull'ID
        DB::statement('UPDATE polipeople_members SET sort_order = id WHERE sort_order IS NULL');
    }

    public function down(): void
    {
        Schema::table('polipeople_members', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
