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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('service_rendered');
            $table->string('delivery_address');
            $table->string('pickup_address');
            $table->string('payment_method');
            $table->string('currency');
            $table->date('expected_delivery_date');
            $table->time('expected_delivery_time');
            $table->string('payment_id');
            $table->string('paystack_refrence_id');
            $table->decimal('total_payment', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};