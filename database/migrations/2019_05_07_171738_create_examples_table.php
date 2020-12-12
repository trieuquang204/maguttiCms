<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examples', function (Blueprint $table) {
            $table->increments('id');('id');
            $table->integer('article_id')->nullable();
            $table->string('color', 7)->nullable();
            $table->date('date')->nullable();
            $table->integer('article_2_id')->nullable();
            $table->integer('article_3_id')->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('description_2', 255)->nullable();
            $table->string('slug', 100)->unique();
            $table->string('doc', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('image_crop', 255)->nullable();
            $table->smallInteger('image_media_id')->nullable();
            $table->smallInteger('status_id')->nullable();
            $table->smallInteger('sort')->nullable();
            $table->boolean('pub')->default(1)->nullable();
            $table->timestamps();
        });


        Schema::create('example_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('example_id');
            $table->string('slug', 255)->nullable();
            $table->string('locale', 255);
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('description_2')->nullable();
            $table->string('image', 255)->nullable();
            $table->smallInteger('image_media_id')->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->boolean('seo_no_index')->nullable();
            $table->nullableTimestamps();
            $table->unique(['example_id', 'locale'], 'examples_translations_example_id_locale_unique');
            $table->index('locale', 'examples_translations_locale_index');
            $table->foreign('example_id', 'examples_translations_example_id_foreign')->references('id')->on('examples')->onDelete('CASCADE
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
        Schema::dropIfExists('examples');
        Schema::dropIfExists('example_translation');
    }
}
