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
        Schema::create('cdt_opp_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opp_id');
            $table->unsignedBigInteger('cdt_id');
            $table->timestamps();
            
            $table->foreign('opp_id')->references('id')->on('opportunity_table')->onDelete('cascade');
            $table->foreign('cdt_id')->references('id')->on('candidates')->onDelete('cascade');
            
            // Prevent duplicate links
            $table->unique(['opp_id', 'cdt_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdt_opp_links');
    }
};


