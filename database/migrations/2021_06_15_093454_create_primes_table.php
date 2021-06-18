<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_employe');
            $table->foreign('id_employe')->references('id')->on('employe')->onDelete('cascade');
            $table->unsignedBigInteger('id_caisse');
            $table->foreign('id_caisse')->references('id_caisse')->on('caisse')->onDelete('cascade');
            $table->double('primeA')->default(0);
            $table->double('primeB')->default(0);
            $table->double('primeC')->default(0);
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
        Schema::dropIfExists('primes');
    }
}
