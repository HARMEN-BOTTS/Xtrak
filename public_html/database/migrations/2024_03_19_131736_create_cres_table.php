<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('response')->nullable();
            $table->longText('question')->nullable();
            $table->integer('number')->nullable();
            $table->foreignUuid('candidate_id')->nullable()->references('id')->on('candidates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cres');
    }
};
