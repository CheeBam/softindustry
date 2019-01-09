<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesHasProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_has_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('employees_has_projects', function(Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });

        Schema::table('employees_has_projects', function(Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_has_projects');
    }
}
