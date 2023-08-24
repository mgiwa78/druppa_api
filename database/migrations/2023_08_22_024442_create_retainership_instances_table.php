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
        Schema::create('retainership_instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("retainership_id");
            $table->unsignedBigInteger("customer_order_id");
            $table->unsignedBigInteger("payment_id");
            $table->unsignedBigInteger("customer_id");

            $table->timestamps();

            $table->foreign('customer_order_id')->references('id')->on('customer_orders')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('retainership_id')->references('id')->on('retainerships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retainership_instances');
    }
};