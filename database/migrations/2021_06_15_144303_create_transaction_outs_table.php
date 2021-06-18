<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_employe');
            $table->foreign('id_employe')->references('id')->on('employe')->onDelete('cascade');
            $table->double('montant',20)->default(0);
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
        Schema::dropIfExists('transaction_outs');
    }
}
