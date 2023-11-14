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
        Schema::create('manage_candidates', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('full_name');
            $table->string('matric_id');
            $table->string('course');
            $table->integer('year');
            $table->integer('semester');
            $table->string('position');
            $table->string('manifesto');
            $table->string('video_link');
            $table->json('criteria_rate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_candidates');
    }
};
