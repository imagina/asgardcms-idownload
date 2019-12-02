<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdownloadSuscriptorTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idownload__suscriptor_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('suscriptor_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['suscriptor_id', 'locale']);
            $table->foreign('suscriptor_id')->references('id')->on('idownload__suscriptors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idownload__suscriptor_translations', function (Blueprint $table) {
            $table->dropForeign(['suscriptor_id']);
        });
        Schema::dropIfExists('idownload__suscriptor_translations');
    }
}
