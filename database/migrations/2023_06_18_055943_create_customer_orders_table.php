<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');

            $table->unsignedBigInteger('payment_id');
            $table->string('service_rendered');
            $table->string('payment_method');
            $table->string('total_payment');


            $table->timestamp('expected_delivery_date');

            $table->text('shipment_description');

            $table->string('status')->default('Pending');
            $table->timestamps();

            $table->string('pickup_address');
            $table->string('pickup_state');
            $table->string('distance');
            $table->string('pickup_lga');
            $table->string('pickup_city');
            $table->string('dropOff_LGA');
            $table->string('dropOff_state');

            $table->string('dropOff_city');
            $table->string('dropOff_address');
            $table->string('shipment_weight');

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};