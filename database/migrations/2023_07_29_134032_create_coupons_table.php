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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->dateTime('validFrom');
            $table->dateTime('validUntil');
            $table->string('couponType')->default("percentageDiscount")->nullable();
            $table->boolean('status')->default(false);
            $table->decimal('reductionAmount')->default(0)->nullable();
            $table->integer('percentageDiscount')->default(0)->nullable();
            ;
            $table->integer('maxUses')->unsigned();
            $table->integer('currentUses')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};