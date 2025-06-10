<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class mcpdashboard extends Migration
{
    public function up()
    {
        Schema::create('mcp_vue', function (Blueprint $table) {
            $table->date('date_mcp')->nullable();
            $table->string('mcp_code')->nullable();
            $table->string('designation')->nullable();
            $table->string('object')->nullable();
            $table->string('tag_source')->nullable();
            $table->string('message')->nullable();
            $table->string('tool')->nullable();
            $table->string('recip_list_path')->nullable();
            $table->string('message_doc')->nullable();
            $table->json('attachments')->nullable();
            $table->string('from_email')->nullable();
            $table->string('subject')->nullable();
            $table->dateTime('launch_date')->nullable();
            $table->integer('pause_min')->nullable();
            $table->integer('pause_max')->nullable();
            $table->integer('batch_min')->nullable();
            $table->integer('batch_max')->nullable();
            $table->time('work_time_start')->nullable();
            $table->time('work_time_end')->nullable();
            $table->string('ref_time')->nullable();
            $table->string('status')->nullable();
            $table->date('status_date')->nullable();
            $table->string('target_status')->nullable();
            $table->string('remarks')->nullable();
            $table->text('notes')->nullable();
            $table->integer('total_mails')->nullable();
            $table->integer('success_count')->nullable();
            $table->integer('fails_count')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_vue');
    }
}
