<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionIntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_ints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_employe');
            $table->foreign('id_employe')->references('id')->on('employe')->onDelete('cascade');
            $table->unsignedBigInteger('id_caisse');
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
        Schema::dropIfExists('transaction_ints');
    }
}
