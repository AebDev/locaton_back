<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('montant');
            $table->string('etat');
            $table->string('num_de_vol');
            $table->string('compagnie_aerienne');
            $table->string('date_debut');
            $table->string('date_fin');
            $table->string('type_de_protection');
            $table->string('option_gps');
            $table->string('option_wifi');
            $table->string('option_Rehausseur_enfant');
            $table->string('option_Rehausseur_bebe');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->delete('cascade');
            $table->unsignedBigInteger('vehicule_id');
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->delete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
