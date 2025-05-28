<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class cstdashboard extends Migration
{
    public function up()
    {
        Schema::create('cst_vue', function (Blueprint $table) {
            $table->string('date_cst');
            $table->string('cst_code');
            $table->string('civ');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('cell');
            $table->string('mail');
            $table->string('status');
            $table->string('notes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cst_vue');
    }
}
