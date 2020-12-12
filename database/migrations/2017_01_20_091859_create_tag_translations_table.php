<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateTagTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->string('locale', 255);
            $table->string('title', 255)->nullable();
            $table->timestamps();

            $table->unique(['tag_id', 'locale'], 'tag_translations_tag_id_locale_unique');
            $table->index('locale', 'tag_translations_locale_index');

            $table->foreign('tag_id', 'tag_translations_tag_id_foreign')->references('id')->on('tags')->onDelete('CASCADE
')->onUpdate('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_translations');
    }
}
