<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuizAndExamMarksToSelectionsTable extends Migration
{
    public function up()
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->integer('quiz_marks')->nullable();
            $table->integer('exam_marks')->nullable();
        });
    }

    public function down()
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->dropColumn(['quiz_marks', 'exam_marks']);
        });
    }
}

