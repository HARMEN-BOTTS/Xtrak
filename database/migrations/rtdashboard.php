<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class rtdashboard extends Migration
{
    public function up()
    {
        Schema::create('rt_vue', function (Blueprint $table) {
            $table->string('date_rt');
            $table->string('auth');
            $table->string('task_code');
            $table->string('destination');
            $table->string('type_input');
            $table->string('subject');
            $table->string('position');
            $table->string('re');
            $table->string('problems');
            $table->string('corrective_actions');
            $table->string('delay');
            $table->string('remarks');
            $table->string('priority');
            $table->string('status');
            $table->string('note_one');
            $table->string('note_two');
            $table->string('rk');
            $table->string('vol');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rt_vue');
    }
}
