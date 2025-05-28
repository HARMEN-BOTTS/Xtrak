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
        Schema::create('cst_opp_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cst_id');
            $table->unsignedBigInteger('opp_id');
            $table->timestamps();

            $table->foreign('cst_id')->references('id')->on('cst_vue')->onDelete('cascade');
            $table->foreign('opp_id')->references('id')->on('opportunity_table')->onDelete('cascade');

            // Prevent duplicate links
            $table->unique(['cst_id', 'opp_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cst_opp_links');
    }
};
