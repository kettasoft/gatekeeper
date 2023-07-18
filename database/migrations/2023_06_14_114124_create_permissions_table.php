<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('gatekeeper.tables.permissions'), function (Blueprint $table) {
            $table->id();
            $table->json('permissions')->nullable();
            $table->boolean('status')->default(config('gatekeeper.tables.default_status'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('gatekeeper.tables.permissions'));
    }
};
