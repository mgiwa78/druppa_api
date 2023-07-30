<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRetainershipCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('retainership_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('retainership_customers');
    }
};
