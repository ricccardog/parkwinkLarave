<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('car_id')->unsigned();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null')->onUpdate('cascade');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete ('set null')->onUpdate('cascade');
            $table->date('startDate');
            $table->date('endDate');
            $table->float('price');
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
        Schema::dropIfExists('rentals');
    }
}
