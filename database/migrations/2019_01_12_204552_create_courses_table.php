<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('identifier', 10)->unique();
            $table->string('address');
            $table->string('location');
            $table->integer('price');
            $table->string('type');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_reservation');
            $table->integer('attendance');
            $table->integer('gender');
            $table->integer('coupon');
            $table->integer('category_id');
            $table->integer('city_id');
            $table->integer('template_id');
            $table->integer('center_id');
            $table->integer('visible')->default(1);
            $table->text('description');
            $table->integer('validation')->default(0);
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
        Schema::dropIfExists('courses');
    }
}
