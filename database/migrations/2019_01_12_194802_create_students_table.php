<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('first_name', 50);
            $table->string('second_name', 50);
            $table->string('third_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('year', 4)->default("0000");
            $table->string('month', 2)->default("00");
            $table->string('day', 2)->default("00");
            $table->integer('gender_id');
            $table->integer('city_id');
            $table->string('image', 200)->default('default.png');
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
        Schema::dropIfExists('students');
    }
}
