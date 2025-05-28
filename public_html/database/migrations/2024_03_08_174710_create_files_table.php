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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('path');
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->foreignUuid('owner_id')->nullable()->references('id')->on('candidates');
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->enum('file_type', ['cv', 'cover letter', 'other'])->default('other');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
