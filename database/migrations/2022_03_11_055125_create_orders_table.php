<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', '255')->nullable();
            $table->string('email', '255')->nullable();
            $table->json('product_info')->nullable();
            $table->json('billing_address')->nullable();
            $table->json('shipping_address')->nullable();
            $table->string('subtotal_price', '255')->nullable();
            $table->string('shipping', '100')->nullable();
            $table->json('shipping_detail')->nullable();
            $table->json('discount')->nullable();
            $table->string('tax', '255')->nullable();
            $table->string('total_price', '255')->nullable();
            $table->string('payment_gateway', '255')->nullable();
            $table->string('shopify_order_id', '255')->nullable();
            $table->string('shopify_order_name', '255')->nullable();
            $table->string('shopify_order_number', '255')->nullable();
			$table->string('shopify_customerid','255')->nullable();
            $table->string('orders_status', '255')->nullable();
            $table->string('fulfillment_status', '255')->nullable();
            $table->string('cancel_reason', '255')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('refunded_amount', '255')->nullable();
            $table->date('refunded_date')->nullable();
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
};
