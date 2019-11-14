<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdownloadDownloadTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idownload__download_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title');
            $table->text('slug');
            $table->text('description')->nullable();
            $table->text('translatable_options')->nullable();
            $table->integer('download_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['download_id', 'locale']);
            $table->foreign('download_id')->references('id')->on('idownload__downloads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idownload__download_translations', function (Blueprint $table) {
            $table->dropForeign(['download_id']);
        });
        Schema::dropIfExists('idownload__download_translations');
    }
}
