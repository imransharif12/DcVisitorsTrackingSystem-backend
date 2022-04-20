<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscortAuthorizedPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escort_authorized_people', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('escort_f_name')->nullable();
            $table->string('escort_l_name')->nullable();
            $table->string('escort_badge_number')->nullable();
            $table->string('escort_authorized_signature')->nullable();
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
        Schema::dropIfExists('escort_authorized_people');
    }
}
