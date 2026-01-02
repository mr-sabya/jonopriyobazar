<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('invoice')->unique();
            $table->integer('cupon_id')->nullable();
            $table->bigInteger('shipping_address_id')->nullable();
            $table->bigInteger('billing_address_id')->nullable();
            $table->string('type');
            $table->string('payment_option');

            // other order
            $table->string('image')->nullable();
            $table->string('custom')->nullable();

            // cancel
            $table->integer('reason_id')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('is_agree_cancel')->nullable();

            // electric bill
            $table->string('phone')->nullable();
            $table->string('meter_no')->nullable();
            $table->integer('company_id')->nullable();

            $table->integer('sub_total')->default(0);
            $table->integer('total')->default(0);
            $table->integer('grand_total')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
