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
        Schema::create('opp_cst_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opp_id');
            $table->unsignedBigInteger('cst_id');
            $table->timestamps();
            
            $table->foreign('opp_id')->references('id')->on('opportunity_table')->onDelete('cascade');
            $table->foreign('cst_id')->references('id')->on('cst_vue')->onDelete('cascade');
            
            // Prevent duplicate links
            $table->unique(['opp_id', 'cst_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opp_cst_links');
    }
};


