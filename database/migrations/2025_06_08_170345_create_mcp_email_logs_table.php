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
        Schema::create('mcp_email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mcp_code')->index();
            $table->dateTime('launch_date');
            $table->time('hour');
            $table->integer('pause')->comment('Random time between min and max pause');
            $table->enum('status', ['Success', 'Failed'])->default('Success');
            $table->string('designation')->nullable();
            $table->string('target_status')->nullable();
            $table->string('recipient_email');
            $table->string('recipient_name')->nullable();
            $table->string('company')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcp_email_logs');
    }
};
