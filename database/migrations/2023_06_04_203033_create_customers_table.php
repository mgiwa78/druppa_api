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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string("firstName");
            $table->string("lastName");
            $table->string('password');
            $table->string("type");
            $table->string("title");
            $table->string("gender");
            $table->string("phone_number")->nullable();
            $table->string("address")->nullable();
            $table->string("profile")->nullable();
            $table->decimal('balance', 8, 2)->default(0);
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('verify_token')->nullable();
        });
    }


};