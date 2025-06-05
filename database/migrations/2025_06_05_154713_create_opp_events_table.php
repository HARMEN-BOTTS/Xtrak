<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_opp_events_table.php
    public function up()
    {
        Schema::create('opp_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opp_id');
            $table->date('event_date');
            $table->string('type')->nullable();
            $table->string('io')->nullable(); // I/O field
            $table->string('object')->nullable();
            $table->string('feedback')->nullable();
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->string('next1')->nullable();
            $table->string('term')->nullable();
            $table->text('note1')->nullable();
            $table->timestamps();

            $table->foreign('opp_id')->references('id')->on('opportunity_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opp_events');
    }
};
