<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Config::get('gatekeeper.tables.permissions'), function (Blueprint $table) {
            $table->id();
            $table->json('permissions')->nullable();
            $table->morphs('clientable');
            $table->boolean('status')->default(Config::get('gatekeeper.tables.default_status'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Config::get('gatekeeper.tables.permissions'));
    }
};
