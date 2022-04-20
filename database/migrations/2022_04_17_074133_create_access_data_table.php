<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('badge_number')->nullable();
            $table->string('transponder_number')->nullable();
            $table->string('rank_access')->nullable();
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
        Schema::dropIfExists('access_data');
    }
}
