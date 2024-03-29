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
        Schema::create('manage_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('candidate_name')->nullable();
            $table->string('voter_name')->nullable();
            $table->double('rate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manage_criterias');
    }
};
