<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('sort')->nullable();
            $table->tinyInteger('pub')->nullable()->default(1);
            $table->integer('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('faq_id');
            $table->string('locale', 255);
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['faq_id', 'locale'], 'faqs_translations_faq_id_locale_unique');
            $table->index('locale', 'faqs_translations_locale_index');
            $table->foreign('faq_id', 'faqs_translations_faq_id_foreign')->references('id')->on('faqs')->onDelete('CASCADE
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
        Schema::dropIfExists('faqs');
    }
}
