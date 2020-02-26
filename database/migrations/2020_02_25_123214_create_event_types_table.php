<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_code');
            $table->string('event_name');
            $table->timestamps();
        });

        $data = [
            ['event_code' => 'opp_won', 'event_name' => 'Opportunity Won'],
            ['event_code' => 'opp_created', 'event_name' => 'Opportunity Created'],
            ['event_code' => 'prod_shipped', 'event_name' => 'Product Shipped']
        ];

        DB::table('event_types')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_types');
    }
}
