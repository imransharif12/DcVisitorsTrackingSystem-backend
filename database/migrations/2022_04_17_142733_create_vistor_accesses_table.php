<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVistorAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vistor_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('v_f_name')->nullable();
            $table->string('v_l_name')->nullable();
            $table->tinyInteger('status')->comment('1=active 0=deactive')->default(1);
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
        Schema::dropIfExists('vistor_accesses');
    }
}
