<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class oppdashboard extends Migration
{
    public function up()
    {
        Schema::create('opportunity_table', function (Blueprint $table) {
            $table->string('opportunity_date');
            $table->string('opp_code');
            $table->string('job_titles');
            $table->string('name');
            $table->string('postal_code_1');
            $table->string('site_city');
            $table->string('opportunity_status');
            $table->string('remarks');
            $table->string('trg_code');
            $table->string('total_paid');
            $table->string('auth');
            $table->string('ctc1_code');
            $table->string('civs');
            $table->string('ctc1_first_name');
            $table->string('ctc1_last_name');
            $table->string('position');
            $table->string('specificities');
            $table->string('domain');
            $table->string('postal_code');
            $table->string('town');
            $table->string('country');
            $table->string('experience');
            $table->string('schooling');
            $table->string('schedules');
            $table->string('mobility');
            $table->string('permission');
            $table->string('type');
            $table->string('vehicle');
            $table->string('job_offer_date');
            $table->string('skill_one');
            $table->string('skill_two');
            $table->string('skill_three');
            $table->string('other_one');
            $table->string('remarks_two');
            $table->string('job_start_date');
            $table->string('invoice_date');
            $table->string('gross_salary');
            $table->string('bonus_1');
            $table->string('bonus_2');
            $table->string('bonus_3');
            $table->string('other_two');
            $table->string('date_emb');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opportunity_table');
    }
}


