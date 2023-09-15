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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('password');
            $table->string('type')->default("Vendor");
            $table->longText('email')->unique();
            $table->longText('profile')->nullable();
            $table->longText('vendorName')->unique();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};