<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_faculties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id');
            $table->unsignedBigInteger('faculty_id');
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
            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
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
        Schema::dropIfExists('evaluation_faculties');
    }
}
