<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trg_vue', function (Blueprint $table) {
            if (!Schema::hasColumn('trg_vue', 'id')) {
                $table->id()->first();
            }
        });
    }

    public function down(): void
    {
        Schema::table('trg_vue', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropTimestamps();
        });
    }
};


