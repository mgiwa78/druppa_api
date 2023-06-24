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
        Schema::create('deliveries', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('customer_order_id');

            $table->string('tracking_number');
            $table->string('status')->default('Pending');
            $table->string('state')->nullable();
            $table->time('time_taken')->nullable();
            $table->string('city')->nullable();

            $table->integer('distance')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();

            $table->timestamp('pickup_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->timestamps();


            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('customer_order_id')->references('id')->on('customer_orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};