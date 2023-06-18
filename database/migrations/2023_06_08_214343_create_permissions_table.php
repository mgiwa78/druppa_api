<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admin_id')->constrained('admins');
            $table->string("permission");
            $table->string("status");

            $table->index(['admin_id', 'permission']);
        });

        DB::statement("ALTER TABLE permissions ADD CONSTRAINT check_active_permission CHECK (status != 'Active' OR (status = 'Active' AND permission IS NULL))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};