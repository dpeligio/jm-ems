<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id');
            $table->unsignedBigInteger('student_id');
            $table->text('positive_comments')->nullable();
            $table->text('negative_comments')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable();
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('evaluation_id')
                ->references('id')
                ->on('evaluations')
				->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
				->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_students');
    }
}
