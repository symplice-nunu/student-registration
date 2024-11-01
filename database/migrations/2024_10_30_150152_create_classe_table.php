<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('classID')->unique(); // Unique auto-generated ID
            $table->string('className'); // Class name
            $table->string('teacherID')->nullable(); // Nullable teacher ID
            $table->string('schedule'); // Class schedule
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
