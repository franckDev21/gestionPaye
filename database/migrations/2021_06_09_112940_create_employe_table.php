<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('profile')->nullable();
            $table->string('matricule')->unique();
            $table->string('noms_prenoms');
            $table->string('cni');
            $table->string('telephone');
            $table->string('email');
            $table->string('date_naissance');
            $table->string('ville');
            $table->string('addresse');
            $table->string('grade');
            $table->string('departement');
            $table->string('poste');
            $table->string('sexe');
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
        Schema::dropIfExists('employe');
    }
}
