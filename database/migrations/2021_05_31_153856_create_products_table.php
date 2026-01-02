<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('quantity');
            $table->integer('sale_price');
            $table->integer('actual_price')->nullable();
            $table->integer('off')->nullable();
            $table->boolean('is_percentage')->default(0);
            $table->integer('point')->default(0);
            $table->string('image');
            $table->text('description')->nullable();
            $table->boolean('is_stock')->default(1);
            $table->integer('added_by');
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
        Schema::dropIfExists('products');
    }
}
