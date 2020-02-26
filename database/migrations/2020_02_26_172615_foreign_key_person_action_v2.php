<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeyPersonActionV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('person_event_actions', function (Blueprint $table) {
            $table->bigInteger('person_id')->change()->unsigned();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('person_event_actions', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });
    }
}
