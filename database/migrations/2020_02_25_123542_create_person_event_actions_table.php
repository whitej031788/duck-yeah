<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonEventActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_event_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('person_id');
            $table->integer('event_type_id');
            $table->string('giphy_action');
            $table->string('youtube_url');
            $table->string('description');
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
        Schema::dropIfExists('person_event_actions');
    }
}
