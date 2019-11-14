<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdownloadSuscriptorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idownload__suscriptors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('comment')->nullable();
            $table->text('options')->default('')->nullable();
            $table->integer('download_id')->unsigned();
            $table->foreign('download_id')->references('id')->on('idownload__downloads')->onDelete('restrict');
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
        Schema::dropIfExists('idownload__suscriptors');
    }
}
