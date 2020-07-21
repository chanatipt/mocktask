<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
			/* fbsg-signature-addModelAttr:<begin> task */
            $table->string('tasktitle');
            $table->string('taskcode');
            $table->dateTime('duedate')->nullable();
            $table->string('remark')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
			/* fbsg-signature-addModelAttr:<end> task */
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
        Schema::dropIfExists('tasks');
    }
}
