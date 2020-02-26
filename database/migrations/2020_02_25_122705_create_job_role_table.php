<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['name' => 'Account Executive'],
            ['name' => 'Product Manager'],
            ['name' => 'Engineer'],
            ['name' => 'Business Development Representative'],
            ['name' => 'Solutions Architect']
        ];

        DB::table('job_roles')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_role');
    }
}
