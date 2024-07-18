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
        Schema::create('polipeople_members', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("last_name");
            $table->string("slug")->unique();
            $table->text("bio")->nullable();
            $table->json("avatar")->nullable();
            $table->json("links")->nullable();
            $table->string("handle")->nullable();
            $table->boolean("is_published")->default(1);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polipeople_members');
    }
};
