<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerficationCollectionRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verfication_collection_registers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('collection_name')->nullable();
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
        Schema::dropIfExists('verfication_collection_registers');
    }
}
