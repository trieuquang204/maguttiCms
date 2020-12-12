<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('info')->nullable();
            $table->string('full_address', 255)->default('');
            $table->string('street', 100)->default('')->nullable();
            $table->string('number', 5)->nullable()->default('');
            $table->string('zip_code', 10);
            $table->string('city', 50)->default('');
            $table->string('province', 50)->default('');
            $table->string('country_code',3)->nullable();
            $table->string('phone', 30)->nullable()->default('');
            $table->string('mobile', 30)->nullable()->default('');
            $table->string('email', 50)->nullable()->default('');
            $table->string('vat', 100)->nullable()->default('');
            $table->string('slug', 255)->nullable();
            $table->string('doc', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->decimal('lat', 11,8)->nullable();
            $table->decimal('lng', 11,8)->nullable();
            $table->integer('sort')->nullable();
            $table->boolean('pub')->nullable()->default(1);

            $table->timestamps();
        });

        Schema::create('location_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->string('slug',255)->nullable();
            $table->string('locale', 3);
            $table->string('title', 255)->nullable();;
            $table->string('subtitle', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('info')->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->string('seo_no_index', 255)->nullable();
            $table->integer('created_by');
            $table->integer('update_by');
            $table->timestamps();

            $table->unique(['location_id', 'locale'], 'location_translations_location_id_locale_unique');
            $table->index('locale', 'location_translations_locale_index');

            $table->foreign('location_id', 'location_translations_location_id_foreign')->references('id')->on('locations')->onDelete('CASCADE
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
        Schema::dropIfExists('locations');
        Schema::dropIfExists('location_translations');
    }
}
