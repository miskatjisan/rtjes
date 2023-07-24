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
            $table->foreignId("user_id")->constrained();
            $table->integer('vendor_id');
            $table->integer("cart_total");
            $table->string("coupon_name");
            $table->integer("discount_total")->default(0);
            $table->integer("sub_total");
            $table->integer("shipping");
            $table->integer("grand_total");
            $table->integer("payment_option");
            $table->integer("payment_status")->default(0);
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
