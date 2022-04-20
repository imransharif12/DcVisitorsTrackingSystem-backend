<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditByDatacubesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_by_datacubes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->string('auditor_signature')->nullable();
            $table->string('signature_date')->nullable();
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
        Schema::dropIfExists('audit_by_datacubes');
    }
}
