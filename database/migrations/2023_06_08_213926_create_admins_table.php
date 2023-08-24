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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('password');
            $table->string("type");
            $table->string("firstName");
            $table->string("phone_number");
            $table->string("lastName");
            $table->string("title")->nullable();
            $table->string("username")->nullable();

            $table->timestamp("last_login")->nullable();
            $table->string("gender")->nullable();
            $table->string("email")->nullable()->unique();
            $table->string("profile")->nullable();
            $table->string("city")->nullable();
            $table->boolean("super")->default(false)->nullable();
            $table->string("address")->nullable();
            $table->string("state")->nullable();

            $table->unsignedBigInteger("location_id")->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};