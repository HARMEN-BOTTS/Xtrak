<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trg_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trg_id');
            $table->date('event_date');
            $table->string('type')->nullable();
            $table->string('io')->nullable(); // I/O field
            $table->string('object')->nullable();
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->string('next')->nullable();
            $table->string('ech')->nullable();
            $table->string('priority')->nullable();
            $table->text('last_comment')->nullable();
            $table->date('date_last_comment')->nullable();
            $table->text('other_comment')->nullable();
            $table->text('note1')->nullable();
            $table->string('temper')->nullable();
            $table->string('retour')->nullable();
            $table->timestamps();

            $table->foreign('trg_id')->references('id')->on('trg_vue')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trg_events');
    }
};
