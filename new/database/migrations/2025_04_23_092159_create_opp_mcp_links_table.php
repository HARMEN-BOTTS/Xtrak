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
        Schema::create('opp_mcp_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opp_id');
            $table->unsignedBigInteger('mcp_id');
            $table->timestamps();
            
            $table->foreign('opp_id')->references('id')->on('opportunity_table')->onDelete('cascade');
            $table->foreign('mcp_id')->references('id')->on('mcp_vue')->onDelete('cascade');
            
            // Prevent duplicate links
            $table->unique(['opp_id', 'mcp_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opp_mcp_links');
    }
};

