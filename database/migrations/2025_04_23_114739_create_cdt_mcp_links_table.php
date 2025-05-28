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
        Schema::create('cdt_mcp_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mcp_id');
            $table->unsignedBigInteger('cdt_id');
            $table->timestamps();
            
            $table->foreign('mcp_id')->references('id')->on('mcp_vue')->onDelete('cascade');
            $table->foreign('cdt_id')->references('id')->on('candidates')->onDelete('cascade');
            
            // Prevent duplicate links
            $table->unique(['mcp_id', 'cdt_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdt_mcp_links');
    }
};


