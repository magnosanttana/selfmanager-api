<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDentistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpf',11);
            $table->string('name');
            $table->string('email')->unique();
            $table->char('gender',1);
            $table->date('date_of_birth');
            $table->string('rg');
            $table->string('agency');

            $table->integer('marital_status_id')->unsigned();
            $table->foreign('marital_status_id')->references('id')->on('marital_status');
            
            $table->string('nationality');
            $table->string('place_of_birth');
            $table->string('address_postcode');
            $table->string('address_address');
            $table->string('address_number');
            $table->string('address_secondary_address')->nullable();
            $table->string('address_city');
            $table->char('address_state',2);
            $table->string('license')->nullable();
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
        Schema::dropIfExists('dentists');
    }
}
