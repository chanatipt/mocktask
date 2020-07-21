<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelRelationTaskstatusOnetoNTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        /* fbsg-signature-addModelRel:<begin> taskStatus 1->N task */
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('task_statuses')->onDelete('cascade');
        });
        /* fbsg-signature-addModelRel:<end> taskStatus 1->N task */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
