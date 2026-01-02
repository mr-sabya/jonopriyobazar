<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable();
            $table->string('tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('copyright')->nullable();
            $table->double('refer_percentage')->nullable();
            $table->integer('min_refer')->nullable();
            $table->double('dev_percentage')->nullable();
            $table->double('marketing_percentage')->nullable();
            $table->string('invoice_logo')->nullable();
            //seo
            $table->string('meta_desc')->nullable();
            $table->string('tags')->nullable();
            $table->string('og_image')->nullable();

            $table->text('terms')->nullable();
            $table->text('privacy')->nullable();
            $table->text('refund')->nullable();
            $table->text('refer')->nullable();

            // about
            $table->text('about_1')->nullable();
            $table->text('about_2')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
