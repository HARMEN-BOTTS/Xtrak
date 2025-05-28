<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class kpisdashboard extends Migration
{
    public function up()
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->integer('trg_calls_done');
            $table->integer('trg_calls_obj');
            $table->integer('trg_wn_done');
            $table->integer('trg_nrp_done');
            $table->integer('trg_ctc_done');
            $table->integer('trg_ctc_obj');
            $table->integer('trg_rv_done');
            $table->integer('trg_rv_obj');
            $table->integer('trg_bqf_done');
            $table->integer('trg_bqf_obj');
            $table->integer('trg_klf_done');
            $table->integer('trg_klf_obj');
            $table->integer('trg_hrd_done');
            $table->integer('trg_hrd_obj');
            $table->integer('cdt_calls_done');
            $table->integer('cdt_calls_obj');
            $table->integer('cdt_ctc_done');
            $table->integer('cdt_refs_done');
            $table->integer('cdt_cv_done');
            $table->integer('cdt_cv_obj');
            $table->integer('cdt_push_done');
            $table->integer('cdt_push_obj');
            $table->integer('cdt_cre_done');
            $table->integer('cdt_cre_obj');
            $table->integer('cdt_ctc_obj');
            $table->integer('cdt_refs_obj');
            $table->date('trg_date');
            $table->date('ctc_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpis');
    }
}
