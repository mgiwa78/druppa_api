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
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('payment_id');
            $table->string('package_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('origin')->nullable();
            $table->string('coupon_id')->nullable();
            $table->string('shipment_description')->nullable();
            $table->string('total_payment')->nullable();
            $table->string('delivery_instructions')->nullable();
            $table->string('location_type')->nullable();
            $table->string('status')->default('Pending')->nullable();
            $table->timestamps();
            $table->string('pickup_address')->nullable();
            $table->string('pickup_state')->nullable();
            $table->string('dropoff_state')->nullable();
            $table->string('dropoff_address')->nullable();
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