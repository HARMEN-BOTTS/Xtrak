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
        Schema::table('candidates', function (Blueprint $table) {
            // Supprimer les contraintes de clé étrangère existantes
            $table->dropForeign(['candidate_state_id']);
            $table->dropForeign(['candidate_statut_id']);
            $table->dropForeign(['civ_id']);
            $table->dropForeign(['compagny_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['disponibility_id']);
            $table->dropForeign(['field_id']);
            $table->dropForeign(['next_step_id']);
            $table->dropForeign(['ns_date_id']);
            $table->dropForeign(['position_id']);
            $table->dropForeign(['speciality_id']);

            // Recréer les contraintes de clé étrangère avec onDelete('set null')
            $table->foreign('candidate_state_id')->references('id')->on('candidate_states')->onDelete('set null');
            $table->foreign('candidate_statut_id')->references('id')->on('candidate_statuts')->onDelete('set null');
            $table->foreign('civ_id')->references('id')->on('civs')->onDelete('set null');
            $table->foreign('compagny_id')->references('id')->on('compagnies')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('disponibility_id')->references('id')->on('disponibilities')->onDelete('set null');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('set null');
            $table->foreign('next_step_id')->references('id')->on('next_steps')->onDelete('set null');
            $table->foreign('ns_date_id')->references('id')->on('ns_dates')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
            $table->foreign('speciality_id')->references('id')->on('specialities')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Supprimer les contraintes de clé étrangère avec onDelete('set null')
            $table->dropForeign(['candidate_state_id']);
            $table->dropForeign(['candidate_statut_id']);
            $table->dropForeign(['civ_id']);
            $table->dropForeign(['compagny_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['disponibility_id']);
            $table->dropForeign(['field_id']);
            $table->dropForeign(['next_step_id']);
            $table->dropForeign(['ns_date_id']);
            $table->dropForeign(['position_id']);
            $table->dropForeign(['speciality_id']);

            // Recréer les contraintes de clé étrangère originales
            $table->foreign('candidate_state_id')->references('id')->on('candidate_states');
            $table->foreign('candidate_statut_id')->references('id')->on('candidate_statuts');
            $table->foreign('civ_id')->references('id')->on('civs');
            $table->foreign('compagny_id')->references('id')->on('compagnies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('disponibility_id')->references('id')->on('disponibilities');
            $table->foreign('field_id')->references('id')->on('fields');
            $table->foreign('next_step_id')->references('id')->on('next_steps');
            $table->foreign('ns_date_id')->references('id')->on('ns_dates');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('speciality_id')->references('id')->on('specialities');
        });
    }
};
