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
        Schema::create('trg_mcp_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trg_id');
            $table->unsignedBigInteger('mcp_id');
            $table->timestamps();

            $table->foreign('trg_id')->references('id')->on('trg_vue')->onDelete('cascade');
            $table->foreign('mcp_id')->references('id')->on('mcp_vue')->onDelete('cascade');

            // Prevent duplicate links
            $table->unique(['trg_id', 'mcp_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trg_mcp_links');
    }
};
