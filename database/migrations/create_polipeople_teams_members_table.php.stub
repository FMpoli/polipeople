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
        Schema::create('polipeople_teams_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->unsigned()->nullable()->references('id')->on('polipeople_members')->onDelete('cascade');
            $table->foreignId("team_id")->unsigned()->nullable()->references('id')->on('polipeople_teams')->onDelete('cascade');
            $table->integer("position")->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polipeople_teams_members');
    }
};
