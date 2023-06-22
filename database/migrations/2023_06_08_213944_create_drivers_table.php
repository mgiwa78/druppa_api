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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('password');
            $table->string('firstName');
            $table->string('phone_number');
            $table->string('lastName');
            $table->string('email')->nullable()->unique();
            $table->string('profile')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string("type");
            $table->string("title");
            $table->string("gender");
            $table->string('licenseNumber')->nullable();
            $table->date('licenseExpiration')->nullable();
            $table->string('vehicleMake')->nullable();
            $table->string('vehicleModel')->nullable();
            $table->string('licensePlate')->nullable();
            $table->boolean('isActive')->default(false);
            $table->string('insurance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};