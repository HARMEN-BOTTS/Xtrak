<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ctcdashboard extends Migration
{
    public function up()
    {
        Schema::create('ctc_vue', function (Blueprint $table) {
            $table->string('date_ctc');
            $table->string('company_ctc');
            $table->string('civ');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('function_ctc');
            $table->string('std_ctc');
            $table->string('ext_ctc');
            $table->string('ld');
            $table->string('cell');
            $table->string('mail');
            $table->string('ctc_code');
            $table->string('trg_code');
            $table->string('remarks');
            $table->string('notes');  
        });
    }

    public function down()
    {
        Schema::dropIfExists('ctc_vue');
    }
}

