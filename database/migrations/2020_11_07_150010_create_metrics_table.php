<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->integer('value');
            $table->integer('sort')->nullable();
            $table->boolean('pub')->nullable()->default(1);
            $table->timestamps();
        });


        Schema::create('metric_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('metric_id')->unsigned();
            $table->string('locale', 255);
            $table->string('title', 255)->nullable();
            $table->nullableTimestamps();
            $table->unique(['metric_id', 'locale'], 'metric_translations_metric_id_locale_unique');
            $table->index('locale', 'metric_translations_locale_index');
            $table->foreign('metric_id')->references('id')->on('metrics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metrics');
    }
}
