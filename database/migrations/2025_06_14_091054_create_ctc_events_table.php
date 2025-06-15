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
        Schema::create('ctc_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ctc_id');
            $table->date('event_date');
            $table->string('type')->nullable();
            $table->string('io')->nullable(); // I/O field
            $table->string('object')->nullable();
            $table->string('status')->nullable();
            $table->string('feed')->nullable();
            $table->string('temper')->nullable();
            $table->text('comment')->nullable();
            $table->string('next')->nullable();
            $table->string('ech')->nullable();
            $table->string('priority')->nullable();
            $table->text('last_comment')->nullable();
            $table->date('date_last_comment')->nullable();
            $table->text('other_comment')->nullable();
            $table->text('note1')->nullable();
            $table->timestamps();

            $table->foreign('ctc_id')->references('id')->on('ctcdashboards')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ctc_events');
    }
};
