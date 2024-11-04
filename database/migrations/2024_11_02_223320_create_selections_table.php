<?php

// database/migrations/xxxx_xx_xx_create_selections_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectionsTable extends Migration
{
    public function up()
    {
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->string('student_name')->nullable();
            $table->string('class_name')->nullable();
            $table->text('course_names')->nullable(); // Store as comma-separated string
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('selections');
    }
}
