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
            $table->string('request_title');
            $table->text('request_description');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method');
            $table->boolean('payment_status')->default(false);
            $table->string('shipment_type');
            $table->string('status')->default('Pending');
            $table->string('drop_off');
            $table->string('pick_up');
            $table->text('shipment_details');
            $table->timestamps();

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